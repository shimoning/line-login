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

    /**
     * 認可URLに含めたstateパラメータ。この値で、どのプロセスが拒否されたか特定できます。
     * @var string|null
     */
    protected $status;

    public function getError(): string
    {
        return $this->error;
    }

    public function getErrorDescription(): ?string
    {
        return $this->expiresIn ?? null;
    }

    public function getStatus(): ?string
    {
        return $this->status ?? null;
    }
}
