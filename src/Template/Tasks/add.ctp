<?php
use App\Model\Entity\Task;

/**
 * @var \App\View\AppView $this
 * @var Task $task
 * @var array $userOptions
 */

$title = 'Добавление задачи';
$this->assign('title', $title);
?>

<?= $this->element('Header') ?>

<div class="container-fluid py-3">
    <h1><?= h($title) ?></h1>

    <?= $this->element('Controller/Tasks/touch_form') ?>
</div>
