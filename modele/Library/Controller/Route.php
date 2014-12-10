<?php
namespace Pstweb\Library\Controller;

class Route
{
    private $pathRegExp;
    private $path;
    private $controllerClass;
    private $controllerMethod;

    public function __construct($path, $pathRegExp, $controller)
    {
        $this->path = $path;
        $this->pathRegExp = $pathRegExp;

        $this->exposeController($controller);
    }

    public function exposeController($controller)
    {
        if (empty($controller)) {
            $this->controllerClass = "DefaultController";
            $this->controllerMethod = 'defaultAction';
        } else {
            $components = explode(":", $controller);

            $this->controllerClass = $components[0];

            if (isset($components[1])) {
                $this->controllerMethod = $components[1];
            } else {
                $this->controllerMethod = 'defaultAction';
            }
        }
    }

    public function generate($params = array())
    {
        $url = $this->path;
        preg_match_all("/\{([^\}]+)\}/", $url, $parameters);

        if (count($parameters)) {
            foreach ($parameters[0] as $i => $param) {
                if (isset($params[$parameters[1][$i]])) {
                    $url = str_replace(
                        $parameters[0][$i],
                        $params[$parameters[1][$i]],
                        $url
                    );
                } else {
                    throw new RouterException(
                        "Il manque le paramètre '" .
                        $parameters[1][$i] .
                        "' pour générer la route"
                    );
                }
            }
        }

        return $url;
    }

    public function match(Request $request)
    {
        $res = preg_match($this->pathRegExp, $request->getUri());
        if ($res === false) {
            throw new \Exception(
                "Une erreur nous empêche de vérifier la route"
            );
        }

        return ($res == 1);
    }

    public function createController(Request $request, Response $response)
    {
        return new $this->controllerClass($request, $response);
    }

    public function getControllerMethod()
    {
        return $this->controllerMethod;
    }
}
