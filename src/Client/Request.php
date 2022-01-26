<?php

namespace Shimoning\LineLogin\Client;

use GuzzleHttp\Client;

// TODO: support PSR-7
class Request
{
    /** @var float */
    private $_timeout = 0;
    /** @var float */
    private $_connectTimeout = 0;

    /** @var bool */
    private $_withForm = false;

    /** @var string|null */
    private $_authorization = null;

    /** @var Client */
    private $_client;

    public function __construct(array $options = [])
    {
        $this->setOptions($options);
        $this->_client = new Client();
    }

    /**
     * GET リクエスト
     * 取得
     *
     * @param string $uri
     * @param array $data
     * @param array $headers
     * @return Response
     */
    public function get(string $uri, array $data = [], array $headers = []): Response
    {
        if ($data) {
            $uri .= '?' . \http_build_query($data);
        }
        return $this->sendRequest('GET', $uri, $headers);
    }

    /**
     * POST リクエスト
     * 新規作成
     *
     * @param string $uri
     * @param array $data
     * @param array $headers
     * @return Response
     */
    public function post(string $uri, array $data = [], array $headers = []): Response
    {
        if (!isset($headers['Content-Type'])) {
            $headers['Content-Type'] = $this->_withForm
                ? ['Content-Type' => 'application/x-www-form-urlencoded']
                : ['Content-Type' => 'application/json; charset=utf-8'];
        }
        return $this->sendRequest('POST', $uri, $headers, $data);
    }

    /**
     * リクエストを実行する
     *
     * @param string $method
     * @param string $uri
     * @param array $headers
     * @param string|array|null
     * @return Response
     */
    protected function sendRequest(string $method, string $uri, array $headers = [], $data = null): Response
    {
        $options = [
            'http_errors' => false,
            'headers' => \array_merge(
                $this->headers(),
                $headers,
            ),
        ];
        if (!empty($data)) {
            if ($this->_withForm) {
                $options['form_params'] = $data;
            } else {
                $options['body'] = $data;
            }
        }

        // リクエスト
        $response = $this->_client->request(
            $method,
            $uri,
            $options,
        );

        // レスポンスを返す
        return new Response(
            $response->getStatusCode(),
            $response->getBody()->getContents(),
            $response->getHeaders(),
        );
    }

    /**
     * オプションをセットする
     *
     * @param array $options
     * @return void
     */
    protected function setOptions($options = []): void
    {
        if (isset($options['timeout'])) {
            $this->_timeout = (float)$options['timeout'];
        }
        if (isset($options['connect_timeout'])) {
            $this->_connectTimeout = (float)$options['connect_timeout'];
        }
        if (isset($options['with_form'])) {
            $this->_withForm = (bool)$options['with_form'];
        }
        if (isset($options['authorization'])) {
            $authorization = \strpos($options['authorization'], 'Bearer ') === 0
                ? $options['authorization']
                : 'Bearer ' . $options['authorization'];
            $this->_authorization = $authorization;
        }
    }

    /**
     * 基本のヘッダ設定
     *
     * @return array
     */
    protected function headers(): array
    {
        $headers = [
            'User-Agent' => 'Shimoning-LineLogin-PHP',
            'timeout' => $this->_timeout,
            'connect_timeout' => $this->_connectTimeout,
        ];
        if ($this->_authorization) {
            $headers['Authorization'] = $this->_authorization;
        }
        return $headers;
    }
}
