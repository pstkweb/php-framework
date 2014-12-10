<?php
namespace Pstweb\Library\Controller;

abstract class AbstractController extends TemplateRenderer
{
    protected $request;
    protected $response;

    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function defaultAction()
    {
        throw new \Exception("Aucune action par défaut n'a été définie.");
    }
}
