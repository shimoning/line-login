<?php

namespace Shimoning\LineLogin\Client;

// TODO: support PSR-7
class Response
{
    /** @var int */
    private $httpStatus;
    /** @var string */
    private $body;
    /** @var string[] */
    private $headers;

    public function __construct(int $httpStatus, string $body, array $headers = [])
    {
        $this->httpStatus = $httpStatus;
        $this->body = $body;
        $this->headers = $headers;
    }

    /**
     * HTTP ステータスを取得する
     *
     * @return int
     */
    public function getHTTPStatus(): int
    {
        return $this->httpStatus;
    }

    /**
     * リクエストが成功かどうか
     *
     * @return boolean
     */
    public function isSucceeded(): bool
    {
        return 200 <= $this->httpStatus && $this->httpStatus <= 299;
    }

    /**
     * 取得した Body をそのまま取得する
     *
     * @return string
     */
    public function getRawBody(): string
    {
        return $this->body;
    }

    /**
     * JSON をパースされた Body を取得する
     *
     * @return array
     */
    public function getJSONDecodedBody(): array
    {
        return json_decode($this->body, true);
    }

    /**
     * レスポンスヘッダを取得する
     *
     * @return string[]
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * 指定のレスポンスヘッダを取得する
     *
     * @param string $name
     * @return string|null
     */
    public function getHeader(string $name): ?string
    {
        return $this->headers[$name] ?? null;
    }
}
