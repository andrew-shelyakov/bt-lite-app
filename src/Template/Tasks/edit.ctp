<?php
use App\Model\Entity\Task;

/**
 * @var \App\View\AppView $this
 * @var Task $task
 * @var array $userOptions
 */
?>

<?= $this->element('Header') ?>

<div class="container-fluid py-3">
    <h1>Редактирование задачи #<?= h($task->id) ?></h1>

    <?php require __DIR__.'/_touch_form.ctp' ?>
</div>
