<?php
use App\Model\Entity\Task;

/**
 * @var \App\View\AppView $this
 * @var Task $task
 * @var array $userOptions
 */
?>

<?= $this->element('Header') ?>

<h1>Добавление задачи</h1>

<?php require __DIR__.'/_touch_form.ctp' ?>
