<?php
namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;

/**
 * @uses \App\Controller\UsersController
 */
class UsersControllerTest extends IntegrationTestCase
{
    public $fixtures = ['app.Users'];

    /**
     * @return void
     */
    public function testGuestCantBypassCsrfProtectionOnSignIn()
    {
        $this->post(['controller' => 'Users', 'action' => 'sign-in']);

        $this->assertResponseCode(403);
        $this->assertResponseContains('CSRF');
    }

    /**
     * @param array $credentials
     * @return void
     * @dataProvider _invalidCredentialsProvider
     */
    public function testGuestCantSignInUsingInvalidCredentials($credentials)
    {
        $this->enableCsrfToken();

        $this->post(['controller' => 'Users', 'action' => 'sign-in'], $credentials);

        $this->assertResponseOk();
        $this->assertResponseContains('Логин или пароль указаны неверно.');
    }

    /**
     * @param int $userId
     * @param array $credentials
     * @return void
     * @dataProvider _validCredentialsProvider
     */
    public function testGuestCanSignInUsingValidCredentialsAndSessionWillBeSetUpCorrectly($userId, $credentials)
    {
        $this->enableCsrfToken();

        $this->post(['controller' => 'Users', 'action' => 'sign-in'], $credentials);

        $this->assertRedirect();
        $this->assertSession($userId, 'Auth.User.id');
    }

    /**
     * @return void
     */
    public function testUserCanSignOut()
    {
        $this->_authorizedAs(1);

        $this->get(['controller' => 'Users', 'action' => 'sign-out']);

        $this->assertRedirect(['controller' => 'Users', 'action' => 'sign-in']);
        $this->assertSession(null, 'Auth.User.id');
        $this->assertSession(null, 'Auth.User');
    }

    /**
     * @return array
     */
    public function _invalidCredentialsProvider()
    {
        return [
            'Empty fields' => [
                [
                    'username' => '',
                    'password' => '',
                ]
            ],
            '`null` as values' => [
                [
                    'username' => null,
                    'password' => null,
                ]
            ],
            'Invalid types' => [
                [
                    'username' => [[123]],
                    'password' => [[456]],
                ]
            ],
            'Missing fields' => [
                [
                ],
            ],
            'Empty `password` while `username` valid' => [
                [
                    'username' => 'mia',
                    'password' => '',
                ]
            ],
            '`null` as `password` while `username` valid' => [
                [
                    'username' => 'mia',
                    'password' => null,
                ]
            ],
            'invalid `password` type while `username` valid' => [
                [
                    'username' => 'mia',
                    'password' => [[null]],
                ]
            ],
            'wrong `password` type while `username` valid' => [
                [
                    'username' => 'mia',
                    'password' => 'valid',
                ]
            ],
        ];
    }

    /**
     * @return array
     */
    public function _validCredentialsProvider()
    {
        return [
            [
                $userId = 1,
                $credentials = [
                    'username' => 'bob',
                    'password' => 'bob-123',
                ],
            ],
            [
                $userId = 2,
                $credentials = [
                    'username' => 'mia',
                    'password' => 'mia-123',
                ],
            ],
            [
                $userId = 3,
                $credentials = [
                    'username' => 'tom',
                    'password' => 'tom-123',
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
}
