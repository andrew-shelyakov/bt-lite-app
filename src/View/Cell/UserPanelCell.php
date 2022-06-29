<?php
namespace App\View\Cell;

use App\Model\Entity\User;
use Cake\View\Cell;

class UserPanelCell extends Cell
{
    /**
     * @var User|null
     */
    protected $_user;

    /**
     * @return User|null
     */
    public function getUser()
    {
        return $this->_user;
    }

    /**
     * @param User|null $user
     * @return void
     */
    public function setUser($user)
    {
        $this->_user = $user;
    }

    /**
     * @return void
     */
    public function display()
    {
        $this->set('user', $this->_user);
    }
}
