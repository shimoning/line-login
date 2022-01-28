<?php

namespace Shimoning\LineLogin\Entities;

class Base
{
    protected $_raw;

    public function __construct(array $data)
    {
        $this->_raw = $data;

        foreach ($data as $key => $value) {
            $_key = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));
            if (property_exists($this, $_key)) {
                $this->{$_key} = $value;
            }
        }
    }

    /**
     * @return array
     */
    public function getRaw(): array
    {
        return $this->_raw;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return \get_object_vars($this);
    }
}
