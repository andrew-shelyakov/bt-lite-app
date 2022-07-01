<?php
use App\Model\Entity\Task;

/**
 * @var \App\View\AppView $this
 * @var Task $task
 * @var array $userOptions
 */

$title = 'Редактирование задачи #'.$task->id;
$this->assign('title', $title);
?>

<?= $this->element('Header') ?>

<div class="container-fluid py-3">
    <h1><?= h($title) ?></h1>

    <?= $this->element('Tasks/touch_form') ?>
</div>
