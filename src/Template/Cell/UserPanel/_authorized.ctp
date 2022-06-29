<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
Вы вошли как <strong><?= h($user->username) ?></strong>
<?= $this->Html->link(
    'Выйти',
    ['controller' => 'Users', 'action' => 'sign-out'],
    ['class' => 'btn btn-outline-secondary ml-3'],
) ?>
