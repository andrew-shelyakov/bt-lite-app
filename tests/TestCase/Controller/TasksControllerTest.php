<?php
namespace App\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

/**
 * @uses \App\Controller\TasksController
 */
class TasksControllerTest extends IntegrationTestCase
{
    public $fixtures = ['app.Users', 'app.Tasks'];

    /**
     * @param string $location
     * @param string $username
     * @param string $contains
     * @return void
     * @dataProvider _simpleLocationChecksProvider
     */
    public function testRedirectForUnathorized($location, $username, $contains)
    {
        $this->get($location);

        $this->assertRedirect(['controller' => 'Users', 'action' => 'sign-in', 'redirect' => $location]);
    }

    /**
     * @param string $location
     * @param string $username
     * @param string $contains
     * @return void
     * @dataProvider _simpleLocationChecksProvider
     */
    public function testLocationAreOkForAuthorized($location, $username, $contains)
    {
        $this->_authorizedAs($username);

        $this->get($location);

        $this->assertResponseOk();
        $this->assertResponseContains($contains);
    }

    /**
     * @param string $username
     * @param string $taskType
     * @param string $taskStatus
     * @return void
     * @dataProvider _varyAddTaskTripletsProvider
     */
    public function testAnyUserCanAddTaskWithVaryTypesAndStatusesAndWillBeSetAsItsAuthor($username, $taskType, $taskStatus)
    {
        $taskData = $this->_createUniqueTaskFormData($taskType, $taskStatus);
        $queryCondition = $this->_convertDataToCondition('Tasks', ([
            'author_id' => $this->_resolveUserId($username),
        ] + $taskData));

        $this->_authorizedAs($username);
        $this->enableCsrfToken();

        $this->post('/tasks/add', $taskData);

        $this->assertRedirect();
        $this->assertCount(1, $this->_queryTasksInDbByCondition($queryCondition));
    }

    /**
     * @return void
     */
    public function testUserCantBypassCsrfProtectionOnTaskAdd()
    {
        $this->_authorizedAs('bob');

        $this->post('/tasks/add');

        $this->assertResponseCode(403);
        $this->assertResponseContains('CSRF');
    }

    /**
     * @return void
     */
    public function testUserCantBypassCsrfProtectionOnTaskEdit()
    {
        $this->_authorizedAs('bob');

        $this->post('/tasks/edit/1');

        $this->assertResponseCode(403);
        $this->assertResponseContains('CSRF');
    }

    /**
     * @return array
     */
    public function _simpleLocationChecksProvider()
    {
        return [
            ['/tasks', 'bob', 'Список задач'],
            ['/tasks/add', 'bob', 'Добавление задачи'],
            ['/tasks/view/1', 'bob', 'Задача #1'],
            ['/tasks/view/2', 'bob', 'Задача #2'],
            ['/tasks/edit/1', 'bob', 'Редактирование задачи #1'],
            ['/tasks/edit/2', 'bob', 'Редактирование задачи #2'],
        ];
    }

    /**
     * @return array
     */
    public function _varyAddTaskTripletsProvider()
    {
        $usernames = [
            'bob',
            'mia',
            'tom',
        ];

        $types = [
            'critical_bug',
            'regular_bug',
            'enhancement',
        ];

        $statuses = [
            'created',
            'executing',
            'completed',
            'canceled',
        ];

        $result = [];

        foreach ($usernames as $username) {
            foreach ($types as $type) {
                foreach ($statuses as $status) {
                    $result[] = [$username, $type, $status];
                }
            }
        }

        return $result;
    }

    /**
     * @param string $username
     * @return void
     */
    protected function _authorizedAs($username)
    {
        $this->session(['Auth.User.id' => $this->_resolveUserId($username)]);
    }

    /**
     * @param string $username
     * @return int
     */
    protected function _resolveUserId($username)
    {
        return [
            'bob' => 1,
            'mia' => 2,
            'tom' => 3,
        ][$username];
    }

    /**
     * @param string $type
     * @param string $status
     * @param int|null $executorId
     * @param string $executorComment
     * @return array
     */
    protected function _createUniqueTaskFormData($type, $status, $executorId = null, $executorComment = '')
    {
        $title = 'Задача ['.uniqid(true).']';
        $description = 'Описание для "'.$title.'"';

        return [
            'type' => $type,
            'title' => $title,
            'description' => $description,
            'status' => $status,
            'executor_id' => $executorId,
            'executor_comment' => $executorComment,
        ];
    }

    /**
     * @param string $table
     * @param array $data
     * @return array
     */
    protected function _convertDataToCondition($table, $data)
    {
        $result = [];

        foreach ($data as $key => $value) {
            $column = $table.'.'.$key;

            $result[] = (($value === null)
                ? [($column.' IS') => null]
                : [$column => $value]
            );
        }

        return $result;
    }

    /**
     * @param array $condition
     * @return int
     */
    protected function _queryTasksInDbByCondition($condition)
    {
        return TableRegistry::getTableLocator()
            ->get('Tasks')
            ->find()
            ->where($condition);
    }
}
