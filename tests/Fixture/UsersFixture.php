<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;
use Cake\Auth\DefaultPasswordHasher;

class UsersFixture extends TestFixture
{
    /**
     * @inheritDoc
     */
    public $import = ['model' => 'Users'];

    /**
     * @inheritDoc
     */
    public function init()
    {
        $hasher = new DefaultPasswordHasher();
        $now = date('Y-m-d H:i:s');

        $this->records = [
            [
                'id' => 1,
                'username' => 'bob',
                'password' => $hasher->hash('bob-123'),
                'created' => $now,
                'updated' => $now,
            ],
            [
                'id' => 2,
                'username' => 'mia',
                'password' => $hasher->hash('mia-123'),
                'created' => $now,
                'updated' => $now,
            ],
            [
                'id' => 3,
                'username' => 'tom',
                'password' => $hasher->hash('tom-123'),
                'created' => $now,
                'updated' => $now,
            ],
        ];

        parent::init();
    }
}
