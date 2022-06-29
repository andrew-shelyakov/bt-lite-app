<?php
/**
 * @var \App\View\AppView $this
 * @var null $user
 */
?>
Вы не вошли
<?= $this->Html->link(
    'Войти',
    ['controller' => 'Users', 'action' => 'sign-in'],
    ['class' => 'btn btn-primary ml-3'],
) ?>
