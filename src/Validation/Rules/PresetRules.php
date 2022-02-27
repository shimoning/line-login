<?php

namespace Shimoning\LineLogin\Validation\Rules;

class PresetRules
{
    public static function numeric($value)
    {
        return \is_numeric($value);
    }

    public static function string($value)
    {
        return \is_string($value);
    }

    public static function boolean($value)
    {
        return \in_array($value, [true, false, 0, 1, '0', '1'], true);
    }

    public static function array($value)
    {
        return \is_array($value);
    }

    public static function in($value, $parameters)
    {
        return \is_array($value)
            ? count(\array_diff($value, $parameters)) === 0
            : \in_array((string)$value, $parameters);
    }
}
