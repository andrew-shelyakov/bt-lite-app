<?php
use App\Model\Entity\Task;

/**
 * @var \App\View\AppView $this
 * @var Task $task
 * @var bool $canEdit
 * @var bool $canDelete
 */
?>
<h1>Задача #<?= h($task->id) ?>
    <?php if ($canEdit): ?>
        <?= $this->Html->link(
            'Редактировать'/*$this->Html->icon('pencil')*/,
            ['controller' => 'Tasks', 'action' => 'edit', 'id' => $task->id],
            [
                'class' => 'btn btn-primary btn-sm',
                'escapeTitle' => false,
            ],
        ) ?>
    <?php endif ?>

    <?php if ($canDelete): ?>
        <?= $this->Form->postLink(
            'Удалить'/*$this->Html->icon('trash')*/,
            ['controller' => 'Tasks', 'action' => 'delete', 'id' => $task->id],
            [
                'class' => 'btn btn-danger btn-sm',
                'escapeTitle' => false,
                'confirm' => 'Удалить задачу?',
            ],
        ) ?>
    <?php endif ?>
</h1>

<strong>Название:</strong><br/>
<?= h($task->title) ?>

<br/>

<strong>Описание:</strong><br/>
<?= h($task->description) ?>

<br/>

<strong>Тип:</strong><br/>
<?= h($task->type_label) ?>

<br/>

<strong>Статус:</strong><br/>
<?= h($task->status_label) ?>

<br/>

<strong>Автор:</strong><br/>
<?= h($task->author->username) ?>

<br/>

<strong>Создана:</strong><br/>
<?= h($task->created) ?>

<br/>

<strong>Изменена:</strong><br/>
<?= h($task->modified) ?>

<hr/>

<strong>Исполнитель:</strong><br/>
<?php if (($executor = $task->executor) !== null): ?>
    <?= h($executor->username) ?>
<?php else: ?>
    <i>Не задан</i>
<?php endif ?>

<br/>

<strong>Комментарий исполнителя:</strong><br/>
<?php if ((string)($executorComment = $task->executor_comment) !== ''): ?>
    <?= h($executorComment) ?>
<?php else: ?>
    <i>Не задан</i>
<?php endif ?>

<br/>
