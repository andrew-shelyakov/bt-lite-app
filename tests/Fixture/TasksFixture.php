<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class TasksFixture extends TestFixture
{
    /**
     * @inheritDoc
     */
    public $import = ['model' => 'Tasks'];

    /**
     * @inheritDoc
     */
    public function init()
    {
        $userIdsMap = [
            'bob' => 1,
            'mia' => 2,
            'tom' => 3,
        ];
        $moments = [
            '1dayAgo' => date('Y-m-d H:i:s', (time() - (86400 * 1))),
            '3dayAgo' => date('Y-m-d H:i:s', (time() - (86400 * 3))),
            '5dayAgo' => date('Y-m-d H:i:s', (time() - (86400 * 5))),
            '7dayAgo' => date('Y-m-d H:i:s', (time() - (86400 * 7))),
        ];

        $this->records = [
            [
                'id' => 1,
                'title' => 'Срочный баг 1',
                'description' => 'Описание для "Срочный баг 1"',
                'type' => 'critical_bug',
                'status' => 'created',
                'author_id' => $userIdsMap['bob'],
                'executor_id' => null,
                'executor_comment' => null,
                'created' => $moments['7dayAgo'],
                'modified' => $moments['7dayAgo'],
            ],
            [
                'id' => 2,
                'title' => 'Обычный баг 1',
                'description' => 'Описание для "Обычный баг 1"',
                'type' => 'regular_bug',
                'status' => 'created',
                'author_id' => $userIdsMap['bob'],
                'executor_id' => null,
                'executor_comment' => null,
                'created' => $moments['5dayAgo'],
                'modified' => $moments['5dayAgo'],
            ],
            [
                'id' => 3,
                'title' => 'Срочный баг 2',
                'description' => 'Описание для "Срочный баг 2"',
                'type' => 'critical_bug',
                'status' => 'executing',
                'author_id' => $userIdsMap['tom'],
                'executor_id' => $userIdsMap['mia'],
                'executor_comment' => 'Комментарий для "Срочный баг 2"',
                'created' => $moments['5dayAgo'],
                'modified' => $moments['5dayAgo'],
            ],
            [
                'id' => 4,
                'title' => 'Обычный баг 2',
                'description' => 'Описание для "Обычный баг 2"',
                'type' => 'regular_bug',
                'status' => 'canceled',
                'author_id' => $userIdsMap['mia'],
                'executor_id' => null,
                'executor_comment' => null,
                'created' => $moments['3dayAgo'],
                'modified' => $moments['3dayAgo'],
            ],
            [
                'id' => 5,
                'title' => 'Улучшение 1',
                'description' => 'Описание для "Улучшение 1"',
                'type' => 'enhancement',
                'status' => 'created',
                'author_id' => $userIdsMap['mia'],
                'executor_id' => null,
                'executor_comment' => null,
                'created' => $moments['3dayAgo'],
                'modified' => $moments['3dayAgo'],
            ],
            [
                'id' => 6,
                'title' => 'Улучшение 2',
                'description' => 'Описание для "Улучшение 2"',
                'type' => 'enhancement',
                'status' => 'completed',
                'author_id' => $userIdsMap['mia'],
                'executor_id' => $userIdsMap['tom'],
                'executor_comment' => 'Комментарий для "Улучшение 2"',
                'created' => $moments['1dayAgo'],
                'modified' => $moments['1dayAgo'],
            ],
        ];

        parent::init();
    }
}
