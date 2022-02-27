<?php

namespace Shimoning\LineLogin\Utilities;

class Str
{
    public static function lowerCamel(string $value): string
    {
        return \lcfirst(
            \str_replace(
                ' ',
                '',
                \ucwords(
                    \str_replace(
                        '_',
                        ' ',
                        $value
                    )
                )
            )
        );
    }

    public static function snake(string $value): string
    {
        return \strtolower(
            \preg_replace(
                '/(.)(?=[A-Z])/u',
                '$1_',
                \str_replace(
                    ' ',
                    '',
                    \ucwords($value)
                )
            )
        );
    }
}
