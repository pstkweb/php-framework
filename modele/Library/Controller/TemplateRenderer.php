<?php
namespace Pstweb\Library\Controller;

use Pstweb\Exifer\Controller\Router;

class TemplateRenderer
{
    public function render($view, $parameters = array()) {
        extract($parameters);

        ob_start();
        require_once "ui/views/" . $view . ".php";
        $html = ob_get_contents();
        ob_end_clean();

        $this->response->setPart('contenu', $html);
    }

    public function getRouter()
    {
        return Router::getInstance();
    }

    public function generateUrl($id, $params = array(), $absolute = false)
    {
        return $this->getRouter()->generateUrl($id, $params, $absolute);
    }

    public function redirect($id, $params = array())
    {
        return $this->getRouter()->redirect($id, $params);
    }
}