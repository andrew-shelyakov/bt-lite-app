<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User|null $user
 */

if ($user === null) {
    require __DIR__.'/_anonymous.ctp';
}
else {
    require __DIR__.'/_authorized.ctp';
}
