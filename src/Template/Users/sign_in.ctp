<?php
/**
 * @var \App\View\AppView $this
 */
?>

<div class="container pt-5 pb-3">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?= $this->Flash->render() ?>

            <h1>Вход в систему</h1>

            <?= $this->Form->create() ?>
                <?= $this->Form->control('username', [
                    'label' => 'Логин',
                    'class' => 'form-control-lg',
                ]) ?>

                <?= $this->Form->control('password', [
                    'label' => 'Пароль',
                    'class' => 'form-control-lg',
                ]) ?>

                <?= $this->Form->button('Войти', [
                    'class' => 'btn-primary btn-lg',
                ]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
