<?php
namespace App\View;

use BootstrapUI\View\UIViewTrait;

class BsAppView extends AppView
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
