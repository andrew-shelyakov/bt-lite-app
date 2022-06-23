<?php
namespace App\Controller;

use App\Model\Table\UsersTable;
use Cake\Event\Event;
use Cake\Http\Response;

/**
 * @property UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * @inheritDoc
     */
    public function beforeRender(Event $event)
    {
        $this->viewBuilder()->setClassName('BsApp');
    }

    /**
     * @return Response|null
     */
    public function signIn()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error('Логин или пароль указаны неверно.');
        }
    }

    /**
     * @return Response|null
     */
    public function signOut()
    {
        $this->Flash->success('Вы вышли из системы.');
        return $this->redirect($this->Auth->logout());
    }
}
