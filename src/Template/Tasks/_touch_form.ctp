<?php
use App\Model\Entity\Task;

/**
 * @var \App\View\AppView $this
 * @var Task $task
 * @var array $userOptions
 */
?>
<?= $this->Form->create($task) ?>
    <?= $this->Form->control('type', [
        'label' => 'Тип',
        'type' => 'select',
        'options' => Task::TYPE_TO_LABEL_MAP,
    ]) ?>

    <?= $this->Form->control('title', [
        'label' => 'Название',
    ]) ?>

    <?= $this->Form->control('description', [
        'label' => 'Описание',
    ]) ?>

    <?= $this->Form->control('status', [
        'label' => 'Статус',
        'type' => 'select',
        'options' => Task::STATUS_TO_LABEL_MAP,
    ]) ?>

    <hr/>

    <?= $this->Form->control('executor_id', [
        'label' => 'Исполнитель',
        'type' => 'select',
        'options' => ['' => 'Не задан'] + ($userOptions),
    ]) ?>

    <?= $this->Form->control('executor_comment', [
        'label' => 'Комментарий исполнителя',
    ]) ?>

    <?= $this->Form->button('Сохранить') ?>
<?= $this->Form->end() ?>
