<?php
namespace Pstweb\Library\Controller;

class FrontController
{
    protected $router;
    protected $dispatcher;

    public function __construct($router)
    {
        $this->router = $router;
        $this->dispatcher = new Dispatcher();
    }

    public function run(Request $request, Response $response)
    {
        $route = $this->router->route($request);
        $this->dispatcher->dispatch($route, $request, $response);
    }
}
