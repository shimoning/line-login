<?php

namespace Shimoning\LineLogin\Communicator;

use Shimoning\LineLogin\Entities\CallbackParameters;
use Shimoning\LineLogin\Entities\NegotiationOptions;

use Shimoning\LineLogin\Utilities\Nonce;
use Shimoning\LineLogin\Utilities\Url;

use Shimoning\LineLogin\Exceptions\InvalidArgumentException;
use Shimoning\LineLogin\Exceptions\JsonParseException;

/**
 * @see https://developers.line.biz/ja/docs/line-login/integrate-line-login/
 */
class Negotiator
{
    const OAUTH_URI = 'https://access.line.me/oauth2/v2.1/authorize';

    /**
     * 1. 認証コードを取得するための URL を生成する
     *
     * @see https://developers.line.biz/ja/docs/line-login/integrate-line-login/#making-an-authorization-request
     *
     * @param string $channelId
     * @param string $callbackUrl
     * @param array $scopeList : profile, openid, email
     * @param string|null $state
     * @param NegotiationOptions|null $options
     * @return string
     */
    public static function generateRequestUrl(
        string $channelId,
        string $callbackUrl,
        array $scopeList = ['profile'], // TODO: validate scopeList
        ?string $state = null,
        ?NegotiationOptions $options = null
    ): string {
        $query = [
            'response_type' => 'code',
            'client_id'     => $channelId,
            'redirect_uri'  => $callbackUrl,
            'state'         => $state ?? Nonce::generate(),
            'scope'         => implode(' ', $scopeList),
        ];

        if ($options) {
            $query = \array_merge($query, $options->toArray());
        }

        return Url::generate(self::OAUTH_URI, '', $query);
    }

    /**
     * 2. コールバックから認証コードを取り出す (short-hand)
     * 通常は parseCallbackParameters を利用し、 state を検証する。
     *
     * @param array|string $query
     * @return string
     * @throws InvalidArgumentException
     */
    public static function extractCode($query): string {
        $parsed = self::parseCallbackParameters($query);

        if (empty($parsed->getCode())) {
            throw new InvalidArgumentException();
        }

        return $parsed->getCode();
    }

    /**
     * コールバックで受けとった値をパースする
     *
     * @param array|string $query
     * @return CallbackParameters
     * @throws InvalidArgumentException
     * @throws JsonParseException
     */
    public static function parseCallbackParameters($query): CallbackParameters
    {
        if (!\is_array($query) && !\is_string($query)) {
            throw new InvalidArgumentException();
        }

        if (\is_string($query)) {
            $query = \json_encode($query, true);
            if (JSON_ERROR_NONE !== \json_last_error()) {
                throw new JsonParseException();
            }
        }

        return new CallbackParameters($query);
    }
}
