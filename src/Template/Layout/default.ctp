<?php
use Cake\Core\Configure;

/**
 * @var \App\View\AppView $this
 */

$debug = (bool)Configure::read('debug');

$this->prepend('meta', $this->Html->meta('favicon.ico', '/favicon.ico', ['type' => 'icon']));

$this->prepend('css', $this->Html->css($debug
    ? ['BootstrapUI.bootstrap.min']
    : ['BootstrapUI.bootstrap']
));

$this->prepend('script', $this->Html->script($debug
    ? ['BootstrapUI.jquery.min', 'BootstrapUI.popper.min', 'BootstrapUI.bootstrap.min']
    : ['BootstrapUI.jquery', 'BootstrapUI.popper', 'BootstrapUI.bootstrap']
));

?>
<!DOCTYPE html><html><head>
<?= $this->Html->charset() ?>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title><?= h($this->fetch('title')) ?></title>
<?= $this->fetch('meta') ?>
<?= $this->fetch('css') ?>

</head><body <?= $this->fetch('bodyTagAttributes')?>>

<?= $this->fetch('content') ?>
<?= $this->fetch('script') ?>

</body></html>
