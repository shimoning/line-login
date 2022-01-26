<?php

namespace Shimoning\LineLogin\Utilities;

class Url
{
    /**
     * URL を生成
     *
     * @param string $baseUrl
     * @param string $path
     * @param array $query
     * @return string
     */
    public static function generate(
        string $baseUrl,
        string $path = '',
        array $query = []
    ): string {
        $_path = !empty($path)
            ? '/' . \ltrim($path, '/')
            : '';
        $queryString = !empty($query)
            ? '?' . \http_build_query($query)
            : '';
        return \rtrim($baseUrl, '/') . $_path . $queryString;
    }
}
