<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User|null $user
 */

if ($user === null) {
    echo $this->element('UserPanel/anonymous');
}
else {
    echo $this->element('UserPanel/authorized');
}
