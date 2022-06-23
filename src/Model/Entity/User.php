<?php
namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * @property int $id
 * @property string $username
 * @property string $password
 * @property FrozenTime $created
 * @property FrozenTime $updated
 */
class User extends Entity
{
    /**
     * @inheritDoc
     */
    protected $_accessible = [
        'username' => true,
        'password' => true,
    ];

    /**
     * @inheritDoc
     */
    protected $_hidden = [
        'password',
    ];

    /**
     * @return string
     */
    protected function _setPassword($value)
    {
        $hasher = new DefaultPasswordHasher();

        return $hasher->hash($value);
    }
}
