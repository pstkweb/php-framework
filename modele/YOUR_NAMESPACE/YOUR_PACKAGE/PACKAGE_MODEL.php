<?php
namespace YOUR_NAMESPACE\YOUR_PACKAGE;

class PACKAGE_MODEL
{
    private $var;

    private function __construct($tab = array())
    {
        $this->var = $tab['var'];
    }

    public static function initialize($data = array())
    {
        $tab['var'] = isset($data['var']) ? $data['var'] : '';

        return new self($tab);
    }

    public function getVar()
    {
        return $this->var;
    }

    public function setVar($var)
    {
        $this->var = $var;

        return $this;
    }
}
