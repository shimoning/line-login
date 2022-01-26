<?php

namespace Shimoning\LineLogin\Utilities;

class Nonce
{
    public static function generate(): string
    {
        return \md5(\uniqid());
    }
}
