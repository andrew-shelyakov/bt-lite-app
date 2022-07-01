<?php
namespace App\Test\TestCase\Controller;

use Cake\ORM\Table;
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
     * @param int $userId
     * @param string $contains
     * @return void
     * @dataProvider _simpleLocationChecksProvider
     */
    public function testRedirectForUnathorized($location, $userId, $contains)
    {
        $this->get($location);

        $this->assertRedirect(['controller' => 'Users', 'action' => 'sign-in', 'redirect' => $location]);
    }

    /**
     * @param string $location
     * @param int $userId
     * @param string $contains
     * @return void
     * @dataProvider _simpleLocationChecksProvider
     */
    public function testLocationAreOkForAuthorized($location, $userId, $contains)
    {
        $this->_authorizedAs($userId);

        $this->get($location);

        $this->assertResponseOk();
        $this->assertResponseContains($contains);
    }

    /**
     * @param int $userId
     * @param array $data
     * @param array $condition
     * @return void
     * @dataProvider _addTaskProvider
     */
    public function testUserCanAddTaskAndItWillBeAddedCorrectly($userId, $data, $condition)
    {
        $this->_authorizedAs($userId);
        $this->enableCsrfToken();

        $this->post('/tasks/add', $data);

        $this->assertRedirect();
        $this->assertCount(1, $this->_loadModel('Tasks')->find('all', [
            'conditions' => $condition,
        ]));
    }

    /**
     * @return void
     */
    public function testUserCantBypassCsrfProtectionOnTaskAdd()
    {
        $this->_authorizedAs(1);

        $this->post('/tasks/add');

        $this->assertResponseCode(403);
        $this->assertResponseContains('CSRF');
    }

    /**
     * @return void
     */
    public function testUserCantBypassCsrfProtectionOnTaskEdit()
    {
        $this->_authorizedAs(1);

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
            ['/tasks', 1, 'Список задач'],
            ['/tasks/add', 1, 'Добавление задачи'],
            ['/tasks/view/1', 1, 'Задача #1'],
            ['/tasks/view/2', 1, 'Задача #2'],
            ['/tasks/edit/1', 1, 'Редактирование задачи #1'],
            ['/tasks/edit/2', 1, 'Редактирование задачи #2'],
        ];
    }

    /**
     * @return array
     */
    public function _addTaskProvider()
    {
        return [
            'Simple case' => [
                $userId = 1,
                $data = [
                    'type' => 'critical_bug',
                    'title' => 'Задача [162be7cc6690bd]',
                    'description' => 'Описание для "Задача [162be7cc6690bd]"',
                    'status' => 'created',
                    'executor_id' => null,
                    'executor_comment' => '',
                ],
                $condition = [
                    'author_id' => 1,
                    'type' => 'critical_bug',
                    'title' => 'Задача [162be7cc6690bd]',
                    'description' => 'Описание для "Задача [162be7cc6690bd]"',
                    'status' => 'created',
                    'executor_id IS' => null,
                    'executor_comment' => '',
                ],
            ],
            'Attempt to override `author_id`' => [
                $userId = 2,
                $data = [
                    'author_id' => 3,
                    'type' => 'regular_bug',
                    'title' => 'Задача [162be7ccad24e5]',
                    'description' => 'Описание для "Задача [162be7ccad24e5]"',
                    'status' => 'executing',
                    'executor_id' => null,
                    'executor_comment' => '',
                ],
                $condition = [
                    'author_id' => 2,
                    'type' => 'regular_bug',
                    'title' => 'Задача [162be7ccad24e5]',
                    'description' => 'Описание для "Задача [162be7ccad24e5]"',
                    'status' => 'executing',
                    'executor_id IS' => null,
                    'executor_comment' => '',
                ],
            ],
            'When `executor_id` is set' => [
                $userId = 3,
                $data = [
                    'type' => 'enhancement',
                    'title' => 'Задача [162be7ceabc7b6]',
                    'description' => 'Описание для "Задача [162be7ceabc7b6]"',
                    'status' => 'canceled',
                    'executor_id' => 2,
                    'executor_comment' => '',
                ],
                $condition = [
                    'author_id' => 3,
                    'type' => 'enhancement',
                    'title' => 'Задача [162be7ceabc7b6]',
                    'description' => 'Описание для "Задача [162be7ceabc7b6]"',
                    'status' => 'canceled',
                    'executor_id' => 2,
                    'executor_comment' => '',
                ],
            ],
        ];
    }

    /**
     * @param int $userId
     * @return void
     */
    protected function _authorizedAs($userId)
    {
        $this->session(['Auth.User.id' => $userId]);
    }

    /**
     * @param string $alias
     * @return Table
     */
    protected function _loadModel($alias)
    {
        return TableRegistry::getTableLocator()->get($alias);
    }
}
