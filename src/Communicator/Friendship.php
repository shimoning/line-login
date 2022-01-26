<?php

namespace Shimoning\LineLogin\Communicator;

use Shimoning\LineLogin\Client\Request;
use Shimoning\LineLogin\Entities\FriendshipStatus;

use Shimoning\LineLogin\Utilities\Url;

use Shimoning\LineLogin\Exceptions\RequestException;

/**
 * @see https://developers.line.biz/ja/reference/line-login/#%E5%8F%8B%E3%81%9F%E3%82%99%E3%81%A1%E9%96%A2%E4%BF%82
 */
class Friendship
{
    const BASE_ENDPOINT = 'https://api.line.me/friendship/v1';

    /**
     * アクセストークンを取得する
     *
     * @see https://developers.line.biz/ja/reference/line-login/#get-friendship-status
     *
     * @param string $accessToken
     * @return FriendshipStatus
     * @throws RequestException
     */
    public static function getStatus(string $accessToken): FriendshipStatus
    {
        $response = (new Request(['authorization' => $accessToken]))->get(
            Url::generate(self::BASE_ENDPOINT, 'status'),
        );
        $body = $response->getJSONDecodedBody();
        if (!$response->isSucceeded()) {
            throw new RequestException('友達状態の取得に失敗しました。' . $body['error_description']);
        }

        return new FriendshipStatus($body);
    }
}
