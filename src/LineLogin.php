<?php

namespace Shimoning\LineLogin;

use Shimoning\LineLogin\Communicator\Negotiator;
use Shimoning\LineLogin\Communicator\OAuth;
use Shimoning\LineLogin\Communicator\UserProfile;
use Shimoning\LineLogin\Communicator\Friendship;

use Shimoning\LineLogin\Entities\AccessTokenCapsule;
use Shimoning\LineLogin\Entities\IdTokenVerifiedResult;
use Shimoning\LineLogin\Entities\UserProfile as UserProfileEntity;
use Shimoning\LineLogin\Entities\FriendshipStatus;

use Shimoning\LineLogin\Exceptions\InvalidArgumentException;
use Shimoning\LineLogin\Exceptions\JsonParseException;

/**
 * @see https://developers.line.biz/ja/docs/line-login/integrate-line-login/
 */
class LINELogin
{
    /** @var string */
    private $channelId;
    /** @var string */
    private $channelSecret;
    /** @var string */
    private $callbackUrl;

    /**
     * @param string $channelId
     * @param string $channelSecret
     * @param string $callbackUrl
     */
    public function __construct(
        string $channelId,
        string $channelSecret,
        string $callbackUrl
    ) {
        $this->channelId = $channelId;
        $this->channelSecret = $channelSecret;
        $this->callbackUrl = $callbackUrl;
    }

    /**
     * 1. 認証コードを取得するための URL を生成する
     *
     * botPrompt については以下を参照
     * @see https://developers.line.biz/ja/docs/line-login/link-a-bot/#displaying-the-option-to-add-your-line-official-account-as-a-friend
     *
     * @param array $scopeList : profile, openid, email
     * @param string|null $status
     * @param string|null $botPrompt : normal or aggressive
     * @return string
     */
    public function generateRequestUrl(
        array $scopeList = ['profile'],
        ?string $status = null,
        ?string $botPrompt = null
    ): string {
        return Negotiator::generateRequestUrl(
            $this->channelId,
            $this->callbackUrl,
            $scopeList,
            $status,
            $botPrompt
        );
    }

    /**
     * 2. コールバックで受けとった値から認証コードを取り出す
     *
     * @param array|string $query
     * @param string|null $status
     * @return string
     * @throws InvalidArgumentException
     * @throws JsonParseException
     */
    public function extractCode($query, ?string $status = null): string
    {
        return Negotiator::extractCode($query, $status);
    }

    /**
     * アクセストークンの発行
     *
     * @param string $code
     * @return AccessTokenCapsule
     */
    public function issueAccessToken(string $code): AccessTokenCapsule
    {
        return OAuth::issueAccessToken(
            $this->channelId,
            $this->channelSecret,
            $this->callbackUrl,
            $code
        );
    }

    /**
     * アクセストークンの検証
     *
     * @param string $accessToken
     * @return bool
     */
    public function verifyAccessToken(string $accessToken): bool
    {
        return OAuth::verifyAccessToken($accessToken);
    }

    /**
     * アクセストークンの更新
     *
     * @param string $refreshToken
     * @return AccessTokenCapsule
     */
    public function refreshAccessToken(string $refreshToken): AccessTokenCapsule
    {
        return OAuth::refreshAccessToken(
            $this->channelId,
            $this->channelSecret,
            $refreshToken
        );
    }

    /**
     * アクセストークンの取り消し
     *
     * @param string $accessToken
     * @return bool
     */
    public function revokeAccessToken(string $accessToken): bool
    {
        return OAuth::revokeAccessToken(
            $this->channelId,
            $this->channelSecret,
            $accessToken
        );
    }

    /**
     * OpenId の検証
     *
     * @param string $idToken
     * @param string|null $nonce
     * @param string|null $userId
     * @return IdTokenVerifiedResult
     */
    public function verifyIdToken(
        string $idToken,
        ?string $nonce = null,
        ?string $userId = null
    ): IdTokenVerifiedResult {
        return OAuth::verifyIdToken(
            $this->channelId,
            $idToken,
            $nonce,
            $userId
        );
    }

    /**
     * ユーザプロファイルを取得する
     *
     * @param string $accessToken
     * @return UserProfileEntity
     */
    public function getUserProfile(string $accessToken): UserProfileEntity
    {
        return UserProfile::getUserProfile($accessToken);
    }

    /**
     * 公式アカウントとの友達状態を取得する
     *
     * @param string $accessToken
     * @return FriendshipStatus
     */
    public function getFriendshipStatus(string $accessToken): FriendshipStatus
    {
        return Friendship::getStatus($accessToken);
    }
}
