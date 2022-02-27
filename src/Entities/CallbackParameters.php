<?php

namespace Shimoning\LineLogin\Entities;

class CallbackParameters extends Output
{
    /**
     * アクセストークンの取得に使用される認可コード
     * @var string
     */
    protected $code;

    /**
     * CSRF防止用の固有な英数字の文字列
     * @var string
     */
    protected $state;

    /**
     * チャネルにリンクされているLINE公式アカウントとユーザーの関係が、ログイン時に変わった場合
     * @var bool
     */
    protected $friendshipStatusChanged;

    /**
     * LINEログインチャネルのチャネルID
     * @var string|null
     */
    protected $liffClientId;

    /**
     * ログイン後にLIFFアプリで表示するURL
     * @var string|null
     */
    protected $liffRedirectUri;

    public function getCode(): string
    {
        return $this->code;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getFriendshipStatusChanged(): bool
    {
        return (bool)$this->friendshipStatusChanged;
    }

    public function getLiffClientId(): ?string
    {
        return $this->liffClientId ?? null;
    }

    public function getLiffRedirectUri(): ?string
    {
        return $this->liffRedirectUri ?? null;
    }
}
