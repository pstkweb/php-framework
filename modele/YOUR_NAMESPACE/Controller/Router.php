<?php
namespace YOUR_NAMESPACE\Controller;

use Pstweb\Library\Controller\Route;
use Pstweb\Library\Controller\AbstractRouter;

class Router extends AbstractRouter
{
    protected function loadRoutes()
    {
        // Get routes from YML file
        $routes = \Spyc::YAMLLoad('config/routes.yml');

        foreach ($routes as $id => $routeInfos) {
            $route = $routeInfos;
            // Extract all route params
            preg_match_all("/\{([^\}]+)\}/", $route['route'], $routeParameters);

            // Protect all slashes for regex usage
            $routeRegEx = str_replace('/', '\/', $route['route']);
            if (count($routeParameters)) {
                // Replace all route param by it's regex
                foreach ($routeParameters[0] as $i => $param) {
                    $routeRegEx = str_replace(
                        $routeParameters[0][$i],
                        str_replace('"', '', $route['parameters'][$routeParameters[1][$i]]),
                        $routeRegEx
                    );
                }
            }

            // Add the route to the list
            $this->addRoute(
                $id,
                new Route($route['route'], '/^' . $routeRegEx . '$/', $route['controller'])
            );
        }
    }
}
