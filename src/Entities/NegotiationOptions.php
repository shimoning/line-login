<?php

namespace Shimoning\LineLogin\Entities;

class NegotiationOptions extends Input
{
    /**
     * リプレイアタックを防止するための文字列
     * @var string|null
     */
    protected $nonce;

    /**
     * ユーザーが要求された権限をすべて付与済みであっても、強制的に同意画面を表示します。
     * 許容値: `consent`
     * @var string|null
     */
    protected $prompt;

    /**
     * ユーザー認証後に許容される最大経過時間 (秒)
     * @var int|null
     */
    protected $maxAge;

    /**
     * LINEログインで表示される画面の表示言語および文字種: RFC 5646 (BCP 47)
     * 優先順位が高い順に、スペース区切りのリストで設定
     * @var string|null
     */
    protected $uiLocales;

    /**
     * LINE公式アカウントを友だち追加するオプションをユーザーのログイン時に表示
     * 許容値: `normal`, `aggressive`
     * @see https://developers.line.biz/ja/docs/line-login/link-a-bot/
     * @var string|null
     */
    protected $botPrompt;

    /**
     * LINE公式アカウントを友だち追加するオプションをユーザーのログイン時に表示
     * 許容値: `lineqr`
     * @var string|null
     */
    protected $initialAmrDisplay;

    /**
     * `false` を指定すると、ログインの方法を変更するための「メールアドレスでログイン」や「QRコードログイン」のボタンを非表示にします
     * @var bool|null
     */
    protected $switchAmr = true;

    /**
     * 自動ログインを無効
     * @var string|null
     */
    protected $disableAutoLogin = false;

    /**
     * iOSにおいて自動ログインを無効
     * @var string|null
     */
    protected $disableIosAutoLogin = false;

    /**
     * LINEログインをPKCE対応するために必要なパラメータ
     * @see https://developers.line.biz/ja/docs/line-login/integrate-pkce/#how-to-integrate-pkce
     * @var string|null
     */
    protected $codeChallenge;

    /**
     * PKCE対応に使用する暗号化方式
     * 許容値: `S256`
     * @see https://developers.line.biz/ja/docs/line-login/integrate-pkce/#how-to-integrate-pkce
     * @var string|null
     */
    protected $codeChallengeMethod;

    protected $rules = [
        'nonce' => ['string'],
        'prompt' => ['string', 'in:consent'],
        'maxAge' => ['numeric'],
        'uiLocales' => ['string'],
        'botPrompt' => ['string', 'in:normal,aggressive'],
        'initialAmrDisplay' => ['string', 'in:lineqr'],
        'switchAmr' => ['boolean'],
        'disableAutoLogin' => ['boolean'],
        'disableIosAutoLogin' => ['boolean'],
        'codeChallenge' => ['string'],
        'codeChallengeMethod' => ['string', 'in:S256'],
    ];
}
