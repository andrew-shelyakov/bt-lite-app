<?php
use App\Model\Entity\Task;

/**
 * @var \App\View\AppView $this
 * @var \Cake\ORM\ResultSet $tasks
 * @var string|null $sortByColumn
 * @var 'ASC'|'DESC'|null $sortDirection
 */

$renderSortLink = function($column, $rawTitle) use ($sortByColumn, $sortDirection) {
    if ($column === $sortByColumn) {
        if ($sortDirection === 'ASC') {
            $rawTitle .= ' &#9650;';
            $sortParam = '-'.$column;
        }
        else {
            $rawTitle .= ' &#9660;';
            $sortParam = $column;
        }
    }
    else {
        $sortParam = $column;
    }

    return $this->Html->link(
        $rawTitle,
        ['action' => 'index', 'sort' => $sortParam],
        [
            'escapeTitle' => false,
        ],
    );
};

?>

<?= $this->element('Header') ?>

<?= $this->Flash->render() ?>

<h1>Список задач</h1>

<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col"><?= $renderSortLink('id', '#') ?></th>
            <th scope="col"><?= $renderSortLink('type', 'Тип') ?></th>
            <th scope="col"><?= $renderSortLink('title', 'Название') ?></th>
            <th scope="col"><?= $renderSortLink('author', 'Автор') ?></th>
            <th scope="col"><?= $renderSortLink('executor', 'Исполнитель') ?></th>
            <th scope="col"><?= $renderSortLink('status', 'Статус') ?></th>
            <th scope="col"><?= $renderSortLink('created', 'Создана') ?></th>
            <th scope="col"><?= $renderSortLink('modified', 'Изменена') ?></th>
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
