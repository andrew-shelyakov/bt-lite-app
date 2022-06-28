<?php
use App\Model\Entity\Task;

/**
 * @var \App\View\AppView $this
 * @var \Cake\ORM\ResultSet $tasks
 */
?>

<?= $this->element('Header') ?>

<h1>Список задач</h1>

<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Тип</th>
            <th scope="col">Название</th>
            <th scope="col">Автор</th>
            <th scope="col">Исполнитель</th>
            <th scope="col">Статус</th>
            <th scope="col">Создана</th>
            <th scope="col">Изменена</th>
            <th scope="col"><?= $this->Html->link(
                'Добавить'/*$this->Html->icon('add')*/,
                ['controller' => 'Tasks', 'action' => 'add'],
                [
                    'class' => 'btn btn-success btn-sm',
                    'escapeTitle' => false,
                ],
            ) ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tasks as $task): ?>
            <?php /** @var Task $task */ ?>
            <tr>
                <th scope="row"><?= h($task->id) ?></th>
                <td><?= h($task->type_label) ?></td>
                <td><?= h($task->title) ?></td>
                <td><?= h($task->author->username) ?></td>
                <td>
                    <?php if (($executor = $task->executor) !== null): ?>
                        <?= h($executor->username) ?>
                    <?php else: ?>
                        <i>Не задан</i>
                    <?php endif ?>
                </td>
                <td><?= h($task->status_label) ?></td>
                <td><?= h($task->created) ?></td>
                <td><?= h($task->modified) ?></td>
                <td><?= $this->Html->link(
                    'Просмотр'/*$this->Html->icon('eye')*/,
                    ['controller' => 'Tasks', 'action' => 'view', 'id' => $task->id],
                    [
                        'class' => 'btn btn-primary btn-sm',
                        'escapeTitle' => false,
                    ],
                ) ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->prev('Предыдущая страница') ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next('Следующая страница') ?>
    </ul>
    <p><?= $this->Paginator->counter() ?></p>
</div>
