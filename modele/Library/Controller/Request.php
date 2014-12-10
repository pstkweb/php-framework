<?php
namespace Pstweb\Library\Controller;

class Request
{
    protected $uri;
    protected $params;
    protected $postedData;

    public function __construct($uri, $params, $post)
    {
        $this->params = $params;
        $this->postedData = $post;

        $this->uri = $uri;
        $this->extractUriParams();
    }

    protected function extractUriParams()
    {
        $params = explode("/", $this->uri);

        if (isset($params[0])) {
            $this->setParam('page', $params[0]);
        }
        if (isset($params[1])) {
            $this->setParam('action', $params[1]);
        }
        if (isset($params[2])) {
            $this->setParam('id', $params[2]);
        }
    }

    public function isXHR()
    {
        return (
            isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        );
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function setParam($key, $value)
    {
        $this->params[$key] = $value;

        return $this;
    }

    public function getParam($key)
    {
        if (!isset($this->params[$key])) {
            throw new \Exception("Paramètre '$key' inexistant.");
        }

        return $this->params[$key];
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getPostedData($key)
    {
        if (!isset($this->postedData[$key])) {
            throw new \Exception("Donnée POST '$key' inexistante.");
        }

        return $this->postedData[$key];
    }

    public function getAllPostedData()
    {
        return $this->postedData;
    }
}
