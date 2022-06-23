<?php
use Cake\Auth\DefaultPasswordHasher;
use Migrations\AbstractSeed;

class UsersSeed extends AbstractSeed
{
    /**
     * @inheritDoc
     */
    public function run()
    {
        $hasher = new DefaultPasswordHasher();
        $now = date('Y-m-d H:i:s');

        $this->insert('users', [
            [
                'username' => 'bob',
                'password' => $hasher->hash('bob-123'),
                'created' => $now,
                'updated' => $now,
            ],
            [
                'username' => 'mia',
                'password' => $hasher->hash('mia-123'),
                'created' => $now,
                'updated' => $now,
            ],
            [
                'username' => 'tom',
                'password' => $hasher->hash('tom-123'),
                'created' => $now,
                'updated' => $now,
            ],
        ]);
    }
}
