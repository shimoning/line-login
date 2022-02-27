<?php

namespace Shimoning\LineLogin\Validation;

class ValidationExecuter
{
    /** @var callable */
    protected $method;

    /** @var array */
    protected $parameters;

    public function __construct($method, $parameters)
    {
        $this->method = $method;
        $this->parameters = $parameters;
    }

    public function execute($value)
    {
        return \call_user_func($this->method, $value, $this->parameters);
    }
}
