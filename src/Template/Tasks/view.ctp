<?php
use App\Model\Entity\Task;

/**
 * @var \App\View\AppView $this
 * @var Task $task
 * @var bool $canEdit
 * @var bool $canDelete
 */

$title = 'Задача #'.$task->id;
$this->assign('title', $title);
?>

<?= $this->element('Header') ?>

<div class="container-fluid py-3">
    <?= $this->Flash->render() ?>

    <h1><?= h($title) ?></h1>

    <div class="row">
        <div class="col-md-5">
            <div class="mb-3 pb-3 border-bottom">
                <h3 class="h6 mb-1">Тип:</h3>
                <?= h($task->type_label) ?>
            </div>

            <div class="mb-3 pb-3 border-bottom">
                <h3 class="h6 mb-1">Название:</h3>
                <?= h($task->title) ?>
            </div>

            <div class="mb-3 pb-3 border-bottom">
                <h3 class="h6 mb-1">Описание:</h3>
                <?= h($task->description) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3 pb-3 border-bottom">
                <div class="mb-3 pb-3 border-bottom">
                    <h3 class="h6 mb-1">Статус:</h3>
                    <?= h($task->status_label) ?>
                </div>

                <h3 class="h6 mb-1">Исполнитель:</h3>
                <?php if (($executor = $task->executor) !== null): ?>
                    <?= h($executor->username) ?>
                <?php else: ?>
                    <i class="text-muted">Не задан</i>
                <?php endif ?>
            </div>

            <div class="mb-3 pb-3 border-bottom">
                <h3 class="h6 mb-1">Комментарий исполнителя:</h3>
                <?php if ((string)($executorComment = $task->executor_comment) !== ''): ?>
                    <?= h($executorComment) ?>
                <?php else: ?>
                    <i class="text-muted">Не задан</i>
                <?php endif ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3 pb-3 border-bottom">
                <h3 class="h6 mb-1">Автор:</h3>
                <?= h($task->author->username) ?>
            </div>

            <div class="mb-3 pb-3 border-bottom">
                <h3 class="h6 mb-1">Создана:</h3>
                <?= h($task->created) ?>
            </div>

            <div class="mb-3 pb-3 border-bottom">
                <h3 class="h6 mb-1">Изменена:</h3>
                <?= h($task->modified) ?>
            </div>

            <?php if ($canEdit): ?>
                <?= $this->Html->link(
                    'Редактировать'/*$this->Html->icon('pencil')*/,
                    ['controller' => 'Tasks', 'action' => 'edit', 'id' => $task->id],
                    [
                        'class' => 'btn btn-primary btn-lg btn-block mt-3',
                        'escapeTitle' => false,
                    ],
                ) ?>
            <?php endif ?>

            <?php if ($canDelete): ?>
                <?= $this->Form->postLink(
                    'Удалить'/*$this->Html->icon('trash')*/,
                    ['controller' => 'Tasks', 'action' => 'delete', 'id' => $task->id],
                    [
                        'class' => 'btn btn-danger btn-lg btn-block mt-3',
                        'escapeTitle' => false,
                        'confirm' => 'Удалить задачу?',
                    ],
                ) ?>
            <?php endif ?>
        </div>
    </div>
</div>
