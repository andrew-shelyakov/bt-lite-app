<?php
namespace App\Controller;

use App\Model\Entity\Task;
use App\Model\Entity\User;
use App\Model\Table\TasksTable;
use Cake\Event\Event;
use Cake\Http\Response;
use Cake\ORM\TableRegistry;
use Crud\Controller\Component\CrudComponent;
use Crud\Controller\ControllerTrait;

/**
 * @property TasksTable $Tasks
 * @property CrudComponent $Crud
 */
class TasksController extends AppController
{
    use ControllerTrait;

    /**
     * @inheritDoc
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Crud', [
            'className' => CrudComponent::class,
            'actions' => [
                'Crud.Index',
                'Crud.Add',
                'Crud.Edit',
                'Crud.View',
                'Crud.Delete',
            ],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function beforeRender(Event $event)
    {
        $this->viewBuilder()->setClassName('BsApp');
    }

    /**
     * @return Response
     */
    public function index()
    {
        $Crud = $this->Crud;

        $Crud->on('beforePaginate', function(Event $event) {
            $event->getSubject()->query->contain(['author', 'executor']);
        });

        return $Crud->execute();
    }

    /**
     * @return Response
     */
    public function view()
    {
        $Crud = $this->Crud;

        $Crud->on('beforeFind', function(Event $event) {
            $event->getSubject()->query->contain(['author', 'executor']);
        });

        return $Crud->execute();
    }

    /**
     * @return Response
     */
    public function add()
    {
        $Crud = $this->Crud;

        $Crud->on('beforeRender', function(Event $event) {
            $this->_addUserOptionsVar();
        });

        $Crud->on('beforeSave', function(Event $event) {
            /** @var Task $task */
            $task = $event->getSubject()->entity;
            $task->author_id = $this->Auth->user()['id'];
        });

        return $Crud->execute();
    }

    /**
     * @return Response
     */
    public function edit()
    {
        $Crud = $this->Crud;

        $Crud->on('beforeRender', function(Event $event) {
            $this->_addUserOptionsVar();
        });

        return $Crud->execute();
    }

    /**
     * @return void
     */
    protected function _addUserOptionsVar()
    {
        $userOptions = [];

        foreach (TableRegistry::getTableLocator()->get('Users')->find() as $user) {
            /** @var User $user */
            $userOptions[$user->id] = $user->username;
        }

        $this->set('userOptions', $userOptions);
    }
}