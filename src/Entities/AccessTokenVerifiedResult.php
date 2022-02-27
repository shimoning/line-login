<?php

namespace Shimoning\LineLogin\Entities;

/**
 * @see https://developers.line.biz/ja/reference/line-login/#verify-access-token
 */
class AccessTokenVerifiedResult extends Output
{
    /**
     * アクセストークンが発行されたチャネルID
     * @var string
     */
    protected $clientId;

    /**
     * アクセストークンの有効期限が切れるまでの秒
     * @var int
     */
    protected $expiresIn;

    /**
     * アクセストークンに付与されている権限。
     * スペース区切り
     * @see https://developers.line.biz/ja/docs/line-login/integrate-line-login/#scopes
     * @var string
     */
    protected $scope;

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    public function getScope(): string
    {
        return $this->scope;
    }

    public function getScopeList(): array
    {
        return \explode(' ', $this->scope);
    }
}
