<?php
/**
 * @var \App\View\AppView $this
 */
?>

<?= $this->Flash->render() ?>

<h1>Вход в систему</h1>

<?= $this->Form->create() ?>
    <?= $this->Form->control('username', [
        'label' => 'Логин',
    ]) ?>

    <?= $this->Form->control('password', [
        'label' => 'Пароль',
    ]) ?>

    <?= $this->Form->button('Войти') ?>
<?= $this->Form->end() ?>
