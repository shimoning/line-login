<?php

namespace Shimoning\LineLogin\Entities;

use Shimoning\LineLogin\Exceptions\ValidationException;
use Shimoning\LineLogin\Validation\Validator;
use Shimoning\LineLogin\Utilities\Str;

class Input
{
    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            // to lower camelCase
            $_key = Str::lowerCamel($key);
            if (\property_exists($this, $_key)) {
                $this->validate($_key, $value);
                $this->{$_key} = $value;
            }
        }
    }

    /**
     * バリデーション
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function validate(string $attribute, $value): bool
    {
        if (! isset($this->rules[$attribute])) {
            return true;
        }

        $validator = new Validator($this->rules[$attribute], $value);

        if (! $validator->passes()) {
            throw new ValidationException();
        }

        return true;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $values = [];

        $data = \get_object_vars($this);
        foreach ($data as $key => $value) {
            if ($key === 'rules') {
                continue;
            }

            // to snake_case
            $_key = Str::snake($key);
            $values[$_key] = $value;
        }

        return $values;
    }
}
