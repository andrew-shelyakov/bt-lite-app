<?php
namespace App\View\Helper;

use App\Model\Entity\User;
use App\View\Cell\UserPanelCell;
use Cake\View\Helper;
use LogicException;

class UserPanelHelper extends Helper
{
    /**
     * @var User|null
     */
    protected $_user = null;

    /**
     * @var UserPanelCell|null
     */
    protected $_cell = null;

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

        if ($this->_cell !== null) {
            $this->_cell = $user;
        }
    }

    /**
     * @param User|null $user
     * @return void
     */
    public function initCellWith($user)
    {
        $cell = $this->_View->cell('UserPanel');
        $cell->setUser($user);

        $this->_cell = $cell;
    }

    /**
     * @return UserPanelCell
     */
    public function getCell()
    {
        if ($this->_cell === null) {
            $cell = $this->_View->cell('UserPanel');
            $cell->setUser($this->_user);

            $this->_cell = $cell;
        }

        return $this->_cell;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getCell()->render();
    }
}
