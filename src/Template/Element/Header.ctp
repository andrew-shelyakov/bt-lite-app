<?php
/**
 * @var \App\View\AppView $this
 */
?>
<header>
    <nav class="navbar navbar-expand-lg navbar-light navbar-dark bg-dark">
        <a class="navbar-brand" href="/">BT-LITE-APP</a>

        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <?= $this->Html->link(
                    'Список задач',
                    ['controller' => 'Tasks', 'action' => 'index'],
                    ['class' => 'nav-link'],
                ) ?>
            </li>
        </ul>
    </nav>
</header>
