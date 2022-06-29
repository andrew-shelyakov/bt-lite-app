<?php
namespace App\View;

use BootstrapUI\View\UIViewTrait;
use Cake\View\View;

class AppView extends View
{
    use UIViewTrait;

    /**
     * @inheritDoc
     */
    public function initialize()
    {
        parent::initialize();

        $this->initializeUI(['layout' => false]);

        $this->loadHelper('UserPanel');
    }
}
