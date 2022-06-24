<?php
use App\Model\Entity\Task;

/**
 * @var \App\View\AppView $this
 * @var Task $task
 * @var array $userOptions
 */
?>
<h1>Редактирование задачи #<?= h($task->id) ?></h1>

<?php require __DIR__.'/_touch_form.ctp' ?>
