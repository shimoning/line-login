<?php

namespace Shimoning\LineLogin\Entities;

class AccessTokenCapsule extends Output
{
    /**
     * アクセストークン。
     * 有効期間は30日です。
     * @var string
     */
    protected $accessToken;

    /**
     * アクセストークンの有効期限が切れるまでの秒
     * @var int
     */
    protected $expiresIn;

    /**
     * ユーザ情報を含む JWT
     * @see https://developers.line.biz/ja/docs/line-login/verify-id-token/
     * @var string|null
     */
    protected $idToken;

    /**
     * 新しいアクセストークンを取得するためのトークン（リフレッシュトークン）。
     * アクセストークンが発行されてから90日間有効です。
     * @see https://developers.line.biz/ja/reference/line-login/#refresh-access-token
     * @var string
     */
    protected $refreshToken;

    /**
     * アクセストークンに付与されている権限。
     * スペース区切り
     * @see https://developers.line.biz/ja/docs/line-login/integrate-line-login/#scopes
     * @var string
     */
    protected $scope;

    /**
     * Bearer (固定)
     * @var string
     */
    protected $tokenType;

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    public function getIdToken(): ?string
    {
        return $this->idToken ?? null;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function getScope(): string
    {
        return $this->scope;
    }

    public function getScopeList(): array
    {
        return \explode(' ', $this->scope);
    }

    public function getTokenType(): string
    {
        return $this->tokenType;
    }
}
