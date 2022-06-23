<?php
use Migrations\AbstractMigration;

class CreateUsers extends AbstractMigration
{
    /**
     * @return void
     */
    public function change()
    {
        $table = $this->table('users');

        $table->addColumn('username', 'string', [
            'limit' => 64,
            'null' => false,
        ]);

        $table->addColumn('password', 'string', [
            'limit' => 255,
            'null' => false,
        ]);

        $table->addColumn('created', 'datetime', [
            'null' => false,
        ]);

        $table->addColumn('updated', 'datetime', [
            'null' => false,
        ]);

        $table->addIndex(['username'], [
            'unique' => true,
        ]);

        $table->create();
    }
}
