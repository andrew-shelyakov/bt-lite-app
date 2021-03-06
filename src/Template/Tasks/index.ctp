<?php
use App\Model\Entity\Task;

/**
 * @var \App\View\AppView $this
 * @var \Cake\ORM\ResultSet $tasks
 */

$title = 'Список задач';
$this->assign('title', $title);

$renderSortLink = function($key, $rawTitle, $options = []) {
    $Paginator = $this->Paginator;

    if ($key === $Paginator->sortKey()) {
        if ($Paginator->sortDir() === 'asc') {
            $rawTitle .= ' &#9650;';
        }
        else {
            $rawTitle .= ' &#9660;';
        }
    }

    return $Paginator->sort($key, $rawTitle, ([
        'escape' => false,
    ] + $options));
};

?>

<?= $this->element('Header') ?>

<div class="container-fluid py-3">
    <?= $this->Flash->render() ?>

    <h1><?= h($title) ?></h1>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col"><?= $renderSortLink('id', h('#')) ?></th>
                    <th scope="col"><?= $renderSortLink('type', h('Тип')) ?></th>
                    <th scope="col"><?= $renderSortLink('title', h('Название')) ?></th>
                    <th scope="col"><?= $renderSortLink('status', h('Статус')) ?></th>
                    <th scope="col"><?= $renderSortLink('executor.username', h('Исполнитель')) ?></th>
                    <th scope="col"><?= $renderSortLink('author.username', h('Автор')) ?></th>
                    <th scope="col"><?= $renderSortLink('created', h('Создана')) ?></th>
                    <th scope="col"><?= $renderSortLink('modified', h('Изменена')) ?></th>
                    <th scope="col" class="text-right"><?= $this->Html->link(
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
                        <td><?= h($task->status_label) ?></td>
                        <td>
                            <?php if (($executor = $task->executor) !== null): ?>
                                <?= h($executor->username) ?>
                            <?php else: ?>
                                <i class="text-muted">Не задан</i>
                            <?php endif ?>
                        </td>
                        <td><?= h($task->author->username) ?></td>
                        <td><?= h($task->created) ?></td>
                        <td><?= h($task->modified) ?></td>
                        <td class="text-right"><?= $this->Html->link(
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
    </div>

    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('Предыдущая') ?>
            <?= $this->Paginator->numbers([
                'first' => 1,
                'last' => 1,
                'templates' => [
                    'ellipsis' => '<li class="page-item disabled"><a class="page-link" tabindex="-1"><span aria-hidden="true">&hellip;</span></a></li>',
                ],
            ]) ?>
            <?= $this->Paginator->next('Следующая') ?>
        </ul>
    </div>
</div>
