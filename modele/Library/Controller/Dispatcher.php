<?php
namespace Pstweb\Library\Controller;

class Dispatcher
{
    public function dispatch($route, $request, $response)
    {
        $controller = $route->createController($request, $response);

        if (
            is_subclass_of(
                $controller,
                'Pstweb\Library\Controller\AbstractController'
            )
        ) {
            if (method_exists($controller, $route->getControllerMethod())) {
                $controller->{$route->getControllerMethod()}();
            } else {
                throw new DispatcherException(
                    "Le Controller ne contient aucune action nommée " .
                    $route->getControllerMethod() . "."
                );
            }
        } else {
            throw new DispatcherException(
                "L'action fait référence à un Controller qui n'existe pas."
            );
        }
    }
}
