<?php

namespace Shimoning\LineLogin\Communicator;

use Shimoning\LineLogin\Client\Request;
use Shimoning\LineLogin\Entities\AccessTokenCapsule;
use Shimoning\LineLogin\Entities\IdTokenVerifiedResult;
use Shimoning\LineLogin\Utilities\Url;
use Shimoning\LineLogin\Exceptions\RequestException;

class OAuth
{
    const BASE_ENDPOINT = 'https://api.line.me/oauth2/v2.1';

    /**
     * アクセストークンを取得する
     *
     * @see https://developers.line.biz/ja/reference/line-login/#issue-access-token
     *
     * @param string $channelId
     * @param string $channelSecret
     * @param string $callbackUrl
     * @param string $code
     * @return AccessTokenCapsule
     * @throws RequestException
     */
    public static function issueAccessToken(
        string $channelId,
        string $channelSecret,
        string $callbackUrl,
        string $code
    ): AccessTokenCapsule {
        $data = [
            'grant_type'    => 'authorization_code',
            'client_id'     => $channelId,
            'client_secret' => $channelSecret,
            'redirect_uri'  => $callbackUrl,
            'code'          => $code,
        ];
        $response = (new Request(['with_form' => true]))->post(
            Url::generate(self::BASE_ENDPOINT, 'token'),
            $data
        );
        $body = $response->getJSONDecodedBody();
        if (!$response->isSucceeded()) {
            throw new RequestException('アクセストークンの取得に失敗しました。' . $body['error_description']);
        }

        return new AccessTokenCapsule($body);
    }

    /**
     * アクセストークンをチェックする
     *
     * @see https://developers.line.biz/ja/reference/line-login/#verify-access-token
     *
     * @param string $accessToken
     * @return bool
     */
    public static function verifyAccessToken(string $accessToken): bool
    {
        $response = (new Request())->get(
            Url::generate(self::BASE_ENDPOINT, 'verify'),
            ['access_token' => $accessToken]
        );

        return $response->isSucceeded();
    }

    /**
     * アクセストークンを更新する
     *
     * @see https://developers.line.biz/ja/reference/line-login/#refresh-access-token
     *
     * @param string $channelId
     * @param string $channelSecret
     * @param string $refreshToken
     * @return AccessTokenCapsule
     * @throws RequestException
     */
    public static function refreshAccessToken(
        string $channelId,
        string $channelSecret,
        string $refreshToken
    ): AccessTokenCapsule {
        $data = [
            'grant_type'    => 'refresh_token',
            'client_id'     => $channelId,
            'client_secret' => $channelSecret,
            'refresh_token' => $refreshToken,
        ];
        $response = (new Request(['with_form' => true]))->post(
            Url::generate(self::BASE_ENDPOINT, 'token'),
            $data
        );
        $body = $response->getJSONDecodedBody();
        if (!$response->isSucceeded()) {
            throw new RequestException('アクセストークンの更新に失敗しました。' . $body['error_description']);
        }

        return new AccessTokenCapsule($body);
    }

    /**
     * アクセストークンを取り消す
     *
     * @see https://developers.line.biz/ja/reference/line-login/#revoke-access-token
     *
     * @param string $channelId
     * @param string $channelSecret
     * @param string $accessToken
     * @return bool
     * @throws RequestException
     */
    public static function revokeAccessToken(
        string $channelId,
        string $channelSecret,
        string $accessToken
    ): bool {
        $data = [
            'client_id'     => $channelId,
            'client_secret' => $channelSecret,
            'access_token'  => $accessToken,
        ];
        $response = (new Request(['with_form' => true]))->post(
            Url::generate(self::BASE_ENDPOINT, 'revoke'),
            $data
        );
        // 成功時に body は空になる
        if (!$response->isSucceeded()) {
            $body = $response->getJSONDecodedBody();
            throw new RequestException('アクセストークンの取り消しに失敗しました。' . $body['error_description']);
        }

        return true;
    }

    /**
     * IDトークンを検証する
     *
     * @see https://developers.line.biz/ja/reference/line-login/#verify-id-token
     *
     * @param string $channelId
     * @param string $idToken
     * @param string|null $nonce
     * @param string|null $userId
     * @return IdTokenVerifiedResult
     */
    public static function verifyIdToken(
        string $channelId,
        string $idToken,
        ?string $nonce = null,
        ?string $userId = null
    ): IdTokenVerifiedResult {
        $data = [
            'client_id' => $channelId,
            'id_token'  => $idToken,
        ];
        if (!\is_null($nonce)) {
            $data['nonce'] = $nonce;
        }
        if (!\is_null($nonce)) {
            $data['user_id'] = $userId;
        }

        $response = (new Request(['with_form' => true]))->post(
            Url::generate(self::BASE_ENDPOINT, 'verify'),
            $data
        );
        $body = $response->getJSONDecodedBody();
        if (!$response->isSucceeded()) {
            throw new RequestException('IDトークンを検証に失敗しました。' . $body['error_description']);
        }

        return new IdTokenVerifiedResult($body);
    }
}
