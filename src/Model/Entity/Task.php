<?php
namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * Task Entity
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $type
 * @property string $status
 * @property User $author
 * @property int $author_id
 * @property User|null $executor
 * @property int|null $executor_id
 * @property string|null $executor_comment
 * @property FrozenTime $created
 * @property FrozenTime $modified
 */
class Task extends Entity
{
    /**
     * @var string[]
     */
    public const TYPE_TO_LABEL_MAP = [
        'critical_bug' => 'Срочный баг',
        'regular_bug' => 'Обычный баг',
        'enhancement' => 'Улучшение',
    ];

    /**
     * @var string[]
     */
    public const STATUS_TO_LABEL_MAP = [
        'created' => 'Создана',
        'executing' => 'Исполненяется',
        'completed' => 'Завершена',
        'canceled' => 'Отменена',
    ];

    /**
     * @inheritDoc
     */
    protected $_accessible = [
        'title' => true,
        'description' => true,
        'type' => true,
        'status' => true,
        'executor_id' => true,
        'executor_comment' => true,
    ];

    /**
     * @return string
     */
    protected function _getTypeLabel()
    {
        return static::TYPE_TO_LABEL_MAP[$this->type];
    }

    /**
     * @return string
     */
    protected function _getStatusLabel()
    {
        return static::STATUS_TO_LABEL_MAP[$this->status];
    }
}
