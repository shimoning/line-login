<?php

namespace Shimoning\LineLogin\Entities;

use Shimoning\LineLogin\Utilities\Str;

class Output
{
    private $_raw;

    public function __construct(array $data)
    {
        $this->_raw = $data;

        foreach ($data as $key => $value) {
            // to lower camelCase
            $_key = Str::lowerCamel($key);
            if (\property_exists($this, $_key)) {
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
