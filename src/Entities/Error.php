<?php

namespace Shimoning\LineLogin\Entities;

class Error extends Base
{
    /**
     * エラーコード
     * @var string
     */
    protected $error;

    /**
     * エラーの内容
     * @var string|null
     */
    protected $errorDescription;

    public function getError(): string
    {
        return $this->error;
    }

    public function getErrorDescription(): ?string
    {
        return $this->errorDescription ?? null;
    }
}
