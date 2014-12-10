<?php
namespace YOUR_NAMESPACE\YOUR_PACKAGE;


class PACKAGE_FORM
{
    const VIEW = "VIEW_FILE";

    private $entity;
    private $errors;

    public function __construct($entity)
    {
        $this->entity = $entity;
        $this->errors = array();
    }

    public function addError($field, $message)
    {
        $this->errors[$field] = $message;
    }

    public function hasError($field)
    {
        return isset($this->errors[$field]);
    }

    public function getError($field)
    {
        return $this->errors[$field];
    }

    public function isValid()
    {
        return true;
    }
}
