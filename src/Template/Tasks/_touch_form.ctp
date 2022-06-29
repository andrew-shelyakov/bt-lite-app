<?php
use App\Model\Entity\Task;

/**
 * @var \App\View\AppView $this
 * @var Task $task
 * @var array $userOptions
 */
?>
<?= $this->Form->create($task, [
    'class' => 'row',
]) ?>
    <div class="col-md-5">
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
    </div>

    <div class="col-md-4">
        <?= $this->Form->control('status', [
            'label' => 'Статус',
            'type' => 'select',
            'options' => Task::STATUS_TO_LABEL_MAP,
        ]) ?>

        <?= $this->Form->control('executor_id', [
            'label' => 'Исполнитель',
            'type' => 'select',
            'options' => ['' => 'Не задан'] + ($userOptions),
        ]) ?>

        <?= $this->Form->control('executor_comment', [
            'label' => 'Комментарий исполнителя',
        ]) ?>
    </div>

    <div class="col-md-3">
        <?= $this->Form->button('Сохранить', [
            'class' => 'btn-primary btn-lg btn-block',
        ]) ?>
    </div>
<?= $this->Form->end() ?>
