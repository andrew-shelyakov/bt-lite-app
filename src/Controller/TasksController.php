<?php
namespace App\Controller;

use App\Model\Entity\Task;
use App\Model\Entity\User;
use App\Model\Table\TasksTable;
use Cake\Event\Event;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Response;
use Cake\ORM\TableRegistry;
use Crud\Controller\Component\CrudComponent;
use Crud\Controller\ControllerTrait;
use LogicException;

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
     * @return Response
     */
    public function index()
    {
        $Crud = $this->Crud;

        $Crud->on('beforePaginate', function(Event $event) {
            $event->getSubject()->query
                ->order($this->_parseSortParam(), true)
                ->contain(['author', 'executor']);
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

        $Crud->on('beforeRender', function(Event $event) {
            /** @var Task $task */
            $task = $event->getSubject()->entity;

            $this->set('canEdit', $this->_canEdit($task));
            $this->set('canDelete', $this->_canDelete($task));
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
            $task->author_id = $this->_getAuthUserId();
        });

        return $Crud->execute();
    }

    /**
     * @return Response
     */
    public function edit()
    {
        $Crud = $this->Crud;

        $Crud->on('afterFind', function(Event $event) {
            if (!$this->_canEdit($event->getSubject()->entity)) {
                throw new ForbiddenException('Вы не можете редактировать задачу, так как не являетесь её автором или исполнителем.');
            }
        });

        $Crud->on('beforeRender', function(Event $event) {
            $this->_addUserOptionsVar();
        });

        return $Crud->execute();
    }

    /**
     * @return Response
     */
    public function delete()
    {
        $Crud = $this->Crud;

        $Crud->on('afterFind', function(Event $event) {
            if (!$this->_canDelete($event->getSubject()->entity)) {
                throw new ForbiddenException('Вы не можете удалить задачу, так как не являетесь её автором.');
            }
        });

        return $Crud->execute();
    }

    /**
     * @return array
     */
    protected function _parseSortParam()
    {
        $sortParam = $this->getRequest()->getQuery('sort');
        if ($sortParam !== null && is_string($sortParam)) {
            if ($sortParam[0] === '-') {
                $sortByColumn = substr($sortParam, 1);
                $sortDirection = 'DESC';
            }
            else {
                $sortByColumn = $sortParam;
                $sortDirection = 'ASC';
            }

            $sortByRealColumn = ([
                'id' => 'Tasks.id',
                'type' => 'Tasks.type',
                'title' => 'Tasks.title',
                'status' => 'Tasks.status',
                'author' => 'author.username',
                'executor' => 'executor.username',
                'created' => 'Tasks.created',
                'modified' => 'Tasks.modified',
            ][$sortByColumn] ?? null);

            if ($sortByRealColumn !== null) {
                $orderFields = [$sortByRealColumn => $sortDirection];
            }
        }

        if (!isset($orderFields)) {
            $sortByColumn = null;
            $sortDirection = null;

            $orderFields = ['Tasks.type' => 'ASC', 'Tasks.created' => 'DESC'];
        }

        $this->set('sortByColumn', ($sortByColumn ?? null));
        $this->set('sortDirection', ($sortDirection ?? null));

        return $orderFields;
    }

    /**
     * @param Task $task
     * @return bool
     */
    protected function _canEdit($task)
    {
        $userId = $this->_getAuthUserId();

        return ($task->author_id === $userId || $task->executor_id === $userId);
    }

    /**
     * @param Task $task
     * @return bool
     */
    protected function _canDelete($task)
    {
        return ($task->author_id === $this->_getAuthUserId());
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

    /**
     * @return int
     * @throws LogicException
     */
    protected function _getAuthUserId()
    {
        $id = $this->Auth->user('id');

        if ($id === null) {
            throw new LogicException('Пользователь не авторизован, либо невозможно определить его id.');
        }

        return $id;
    }
}
