<?php
namespace App\Controller;

use Cake\Http\Response;

class RedirectController extends AppController
{
    /**
     * @return Response
     */
    public function index()
    {
        return $this->redirect(['controller' => 'Tasks', 'action' => 'index']);
    }
}
