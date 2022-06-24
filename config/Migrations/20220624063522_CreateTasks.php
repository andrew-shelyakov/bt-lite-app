<?php
use Migrations\AbstractMigration;

class CreateTasks extends AbstractMigration
{
    /**
     * @return void
     */
    public function change()
    {
        $table = $this->table('tasks');

        $table->addColumn('title', 'string', [
            'limit' => 255,
            'null' => false,
        ]);

        $table->addColumn('description', 'text', [
            'null' => false,
        ]);

        $table->addColumn('type', 'enum', [
            'values' => ['critical_bug', 'regular_bug', 'enhancement'],
            'null' => false,
        ]);

        $table->addColumn('status', 'enum', [
            'values' => ['created', 'executing', 'completed', 'canceled'],
            'null' => false,
            'default' => 'created',
        ]);

        $table->addColumn('author_id', 'integer', [
            'limit' => 11,
            'null' => false,
        ]);

        $table->addForeignKey(['author_id'], 'users', ['id'], [
            'update' => 'CASCADE',
            'delete' => 'RESTRICT',
        ]);

        $table->addColumn('executor_id', 'integer', [
            'limit' => 11,
            'null' => true,
            'default' => null,
        ]);

        $table->addForeignKey(['executor_id'], 'users', ['id'], [
            'update' => 'CASCADE',
            'delete' => 'RESTRICT',
        ]);

        $table->addColumn('executor_comment', 'text', [
            'null' => true,
            'default' => null,
        ]);

        $table->addColumn('created', 'datetime', [
            'null' => false,
        ]);

        $table->addColumn('modified', 'datetime', [
            'null' => false,
        ]);

        $table->create();
    }
}
