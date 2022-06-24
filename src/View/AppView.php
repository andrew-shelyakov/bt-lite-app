<?php
namespace App\View;

use Cake\View\View;
use BootstrapUI\View\UIViewTrait;

class AppView extends View
{
    use UIViewTrait;

    /**
     * @inheritDoc
     */
    public function initialize()
    {
        parent::initialize();

        $this->initializeUI();
    }
}
