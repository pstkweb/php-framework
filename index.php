<?php
use Pstweb\Library\Controller\FrontController;
use Pstweb\Library\Controller\Request;
use Pstweb\Library\Controller\Response;
use Pstweb\Exifer\Controller\Router;

// Link configuration files and init sessions
session_start();
require_once('config/config.php');

$titre = '';
$content = '';

try {
    // Init route
    if (isset($_GET['route'])) {
        $route = $_GET['route'];
        unset($_GET['route']);
    } else {
        $route = '/';
    }

    // Inject $_GET & Route params in same array
    $explodedRoute = explode("/", $route, 4);
    $params = array();
    if (isset($params[3])) {
        $params = explode("/", $explodedRoute[3]);
    }
    $params = array_merge($params, $_GET);

    // Create the Request Object and an empty Response
    $request = new Request($route, $params, $_POST);
    $response = new Response();

    // Create a Router
    $router = Router::getInstance();

    // Instanciate a FrontController to handle Request
    $controller = new FrontController($router);
    $controller->run($request, $response);

    // Get HTML page components
    $titre = $response->getPart('titre');
    $content = $response->getPart('contenu');
} catch (\Exception $e) {
    $titre = 'Erreur';
    $content = '<section id="error" class="container text-center">';
    $content .= '<h1>Une erreur nous empêche de servir la page</h1>';
    $content .= "<p>{$e->getMessage()}</p>";
    $content .= "<pre>{$e->getTraceAsString()}</pre>";
    $content .= '</section>';
}

// Handle XHR Requests
if (isset($request) && $request->isXHR()) {
    $html = $response->getPart('contenu');
} else {
    ob_start();
    require_once("ui/squelette.php");
    $html = ob_get_contents();
    ob_end_clean();
}

// Write HTML page
echo $html;
