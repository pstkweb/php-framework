<?php
namespace Pstweb\Library\Controller;

abstract class AbstractRouter
{
    private static $instance = null;
    protected $controllerClassname;
    protected $controllerMethod;
    protected $routes;

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    private function __construct()
    {
        $this->loadRoutes();
    }

    public function route(Request $request)
    {
        foreach ($this->routes as $route) {
            if ($route->match($request)) {
                return $route;
            }
        }

        throw new \Exception(
            "Aucune route trouvée pour cette URL ({$request->getUri()})"
        );
    }

    public function generateUrl($id, $params = array(), $absolute = false)
    {
        $route = $this->getRoute($id);

        $split = explode("/", $_SERVER['SCRIPT_NAME']);
        array_pop($split);
        $path = implode("/", $split);

        if ($absolute) {
            if ($_SERVER['HTTPS'] == 'on') {
                $url = 'https://';
            } else {
                $url = 'http://';
            }

            $url .= $_SERVER['HTTP_HOST'];
        } else {
            $url = $path;
        }

        // Add slash at end of URL
        if (strrpos($url, '/') != (strlen($url) - 1)) {
            $url .= '/';
        }

        // Actual route
        $routeUrl = $route->generate($params);
        if (strlen($routeUrl) < 2) {
            $routeUrl = '';
        }

        return $url . $routeUrl;
    }

    public function redirect($id, $params = array())
    {
        header('Location: ' . $this->generateUrl($id, $params));
        exit;
    }

    public function addRoute($id, Route $route)
    {
        $this->routes[$id] = $route;

        return $this;
    }

    public function addRoutes(array $routes)
    {
        foreach ($routes as $id => $route) {
            $this->addRoute($id, $route);
        }

        return $this;
    }

    public function getRoute($id)
    {
        if (!isset($this->routes[$id])) {
            throw new \Exception(
                "Aucune route n'existe pour l'identifiant '{$id}'"
            );
        }

        return $this->routes[$id];
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function getControllerClassname()
    {
        return $this->controllerClassname;
    }

    public function getContollerMethod()
    {
        return $this->controllerMethod;
    }

    abstract protected function loadRoutes();
}