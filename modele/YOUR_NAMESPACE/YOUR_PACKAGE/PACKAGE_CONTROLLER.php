<?php
namespace YOUR_NAMESPACE\YOUR_PACKAGE;

use Pstweb\Library\Controller\AbstractController;

class PACKAGE_CONTROLLER extends AbstractController
{
    public function method()
    {
        $this->response->setPart('titre', 'TITLE');

        $this->render("VIEW", array('param' => $param));
    }
}
