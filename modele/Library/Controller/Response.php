<?php
namespace Pstweb\Library\Controller;

class Response
{
    protected $parts;

    public function __construct($parts = array())
    {
        $this->parts = $parts;
    }

    public function setPart($key, $content)
    {
        $this->parts[$key] = $content;

        return $this;
    }

    public function getPart($key)
    {
        if (!isset($this->parts[$key])) {
            throw new \Exception("Partie '$key' inexistante.");
        }

        return $this->parts[$key];
    }
}
