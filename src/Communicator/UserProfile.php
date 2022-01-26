<?php

namespace Shimoning\LineLogin\Communicator;

use Shimoning\LineLogin\Client\Request;
use Shimoning\LineLogin\Entities\UserProfile as UserProfileEntity;

use Shimoning\LineLogin\Exceptions\RequestException;

/**
 * @see https://developers.line.biz/ja/reference/line-login/#%E3%83%95%E3%82%9A%E3%83%AD%E3%83%95%E3%82%A3%E3%83%BC%E3%83%AB
 */
class UserProfile
{
    const BASE_ENDPOINT = 'https://api.line.me/v2/profile';

    /**
     * アクセストークンを取得する
     *
     * @see https://developers.line.biz/ja/reference/line-login/#issue-access-token
     *
     * @param string $accessToken
     * @return UserProfileEntity
     * @throws RequestException
     */
    public static function getUserProfile(string $accessToken): UserProfileEntity
    {
        $response = (new Request(['authorization' => $accessToken]))->get(
            self::BASE_ENDPOINT,
        );
        $body = $response->getJSONDecodedBody();
        if (!$response->isSucceeded()) {
            throw new RequestException('プロフィールの取得に失敗しました。' . $body['message']);
        }

        return new UserProfileEntity($body);
    }
}
