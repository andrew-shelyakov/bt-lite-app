<?php
namespace App\Controller\Component;

use App\Controller\AppController;
use App\Model\Entity\User;
use App\View\AppView;
use Cake\Controller\Component;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use RuntimeException;

class UserPanelComponent extends Component
{
    /**
     * @var User|null
     */
    protected $_resolvedUser = null;

    /**
     * @inheritDoc
     */
    public function implementedEvents()
    {
        return ([
            'View.beforeRender' => 'beforeViewRender',
        ] + parent::implementedEvents());
    }

    /**
     * @param Event $event
     * @return void
     */
    public function beforeRender($event)
    {
        /** @var AppController $controller */
        $controller = $event->getSubject();

        if (!isset($controller->Auth)) {
            $this->_resolvedUser = null;
            return;
        }

        $authorized = $controller->Auth->user();

        if (!isset($authorized['id'])) {
            $this->_resolvedUser = null;
            return;
        }

        $table = TableRegistry::getTableLocator()->get('Users');
        $user = $table->find()->where([$table->getPrimaryKey() => $authorized['id']])->first();

        if ($user === null) {
            throw new RuntimeException('Unable to load User.');
        }

        $this->_resolvedUser = $user;
    }

    /**
     * @param Event $event
     * @return void
     */
    public function beforeViewRender($event)
    {
        /** @var AppView $view */
        $view = $event->getSubject();

        $view->UserPanel->setUser($this->_resolvedUser);
    }
}
