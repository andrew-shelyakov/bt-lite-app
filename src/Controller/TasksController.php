<?php
namespace App\Controller;

use App\Model\Entity\Task;
use App\Model\Table\TasksTable;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\InternalErrorException;
use Cake\Http\Exception\MethodNotAllowedException;
use Cake\Http\Response;
use LogicException;

/**
 * @property TasksTable $Tasks
 */
class TasksController extends AppController
{
    /**
     * @return void
     */
    public function index()
    {
        $query = $this->Tasks->find()
            ->order($this->_parseSortParam(), true)
            ->contain(['author', 'executor']);
        $tasks = $this->paginate($query);

        $this->set('tasks', $tasks);
    }

    /**
     * @param string $id
     * @return void
     */
    public function view($id)
    {
        $task = $this->Tasks->get($id, [
            'contain' => ['author', 'executor'],
        ]);

        $this->set('task', $task);
        $this->set('canEdit', $this->_canEdit($task));
        $this->set('canDelete', $this->_canDelete($task));
    }

    /**
     * @return Response|void
     */
    public function add()
    {
        $model = $this->Tasks;
        $task = $model->newEntity();

        if ($this->request->is('post')) {
            $model->patchEntity($task, $this->request->getData());
            $task->author_id = $this->_getAuthUserId();

            if ($model->save($task)) {
                $this->Flash->success('Задача успешно добавлена.');

                return $this->redirect(['action' => 'index']);
            }
        }

        $this->set('task', $task);
        $this->_addUserOptionsVar();
    }

    /**
     * @param string $id
     * @return Response|void
     * @throws ForbiddenException
     */
    public function edit($id)
    {
        $model = $this->Tasks;
        $task = $model->get($id);

        if (!$this->_canEdit($task)) {
            throw new ForbiddenException('Вы не можете редактировать задачу, так как не являетесь её автором или исполнителем.');
        }

        if ($this->request->is('put')) {
            $model->patchEntity($task, $this->request->getData());

            if ($model->save($task)) {
                $this->Flash->success('Задача успешно отредактирована.');

                return $this->redirect(['action' => 'index']);
            }
        }

        $this->set('task', $task);
        $this->_addUserOptionsVar();
    }

    /**
     * @param string $id
     * @return Response
     * @throws MethodNotAllowedException
     * @throws ForbiddenException
     * @throws InternalErrorException
     */
    public function delete($id)
    {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        $model = $this->Tasks;
        $task = $model->get($id);

        if (!$this->_canDelete($task)) {
            throw new ForbiddenException('Вы не можете удалить задачу, так как не являетесь её автором.');
        }

        if (!$model->delete($task)) {
            throw new InternalErrorException('Не удалось удалить задачу.');
        }

        $this->Flash->success('Задача успешно удалена.');

        return $this->redirect(['action' => 'index']);
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
        $userOptions = $this->loadModel('Users')->find('list', [
            'valueField' => 'username',
        ])->toArray();

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
