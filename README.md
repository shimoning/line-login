# line-login
Line login を使うライブラリ。

## Support versions
* PHP7 <= 7.2
* PHP8 <= 8.0

## Install

利用するプロジェクトの `composer.json` に以下を追加する。
```composer.json
"repositories": {
    "line-login": {
        "type": "vcs",
        "url": "https://github.com/shimoning/line-login.git"
    }
},
```

その後以下でインストールする。

```bash
composer require shimoning/line-login
```

## How to use

### 初期化
```php
use Shimoning\LineLogin\LINELogin;

$lineLogin = new LINELogin(
  $channelId,
  $channelSecret,
  $callbackUrl
);
```

### ユーザーに認証許可を得るためのURLを取得する
LINEログインボタンにセットしたり、リダイレクトさせる場合に使う URLを取得する。

```php
$lineLogin->generateRequestUrl(); // https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=...
```

### 上記URLを踏んで、LINE経由でユーザが戻ってきたとき
コードを取得する。

```php
$queryData = filter_input_array(INPUT_GET, $_GET); // Pure PHP
$queryData = $request->query(); // Laravel

$code = $lineLogin->extractCode($queryData); // Sh1m0...
```

### アクセストークンを取得する
上記で取得した code を使って、トークン関連の情報を取得する。
取得したアクセストークンはシステムの要件に合わせて安全に保存して利用する。

```php
$issued = $lineLogin->issueAccessToken($code); // AccessTokenCapsule エンティティ (後述)

// アクセストークン
$accessToken = $issued->getAccessToken(); // eyJhbGciOiJIUz...

// リフレッシュトークン
$refreshToken = $issued->getRefreshToken(); // N0mi...
```

その他のエンティティメソッドは後述。


### アクセストークンを検証する
```php
$verified = $lineLogin->verifyAccessToken($accessToken); // true or false
```

### アクセストークンを更新する
リフレッシュトークンを利用して、アクセストークンを更新する。

```php
$refreshed = $lineLogin->refreshAccessToken($refreshToken); // AccessTokenCapsule エンティティ (後述)
```

### アクセストークンを無効化する
```php
$revoked = $lineLogin->revokeAccessToken($accessToken); // true or false
```

### ユーザプロフィールを取得する
```php
$userProfile = $lineLogin->getUserProfile($accessToken); // UserProfile エンティティ (後述)
```

### 公式アカウントとの友達状態を取得する
```php
$friendshipStatus = $lineLogin->getFriendshipStatus($accessToken); // FriendshipStatus エンティティ (後述)
```

## エンティティ

### AccessTokenCapsule
|      Methods      |       Description           |
|:------------------|:----------------------------|
| getAccessToken    | アクセストークンを取得する      |
| getExpiresIn      | アクセストークンの有効の時間(秒) |
| getIdToken        | OpenId の JWT               |
| getRefreshToken   | 更新用のリフレッシュトークン    |
| getScope          | スコープ (スペースつなぎ)      |
| getScopeList      | スコープリスト (配列)         |
| getTokenType      | Bearer (固定)               |

### UserProfile
|      Methods      |       Description                           |
|:------------------|:--------------------------------------------|
| getUserId         | ユーザーID                                   |
| getDisplayName    | プロフィール画像のURL。(秒)                     |
| getPictureUrl     | プロフィール画像のURL。設定されていない場合は null |
| getStatusMessage  | ステータスメッセージ。設定されていない場合は null  |

### FriendshipStatus
|      Methods      |       Description        |
|:------------------|:-------------------------|
| getFriendFlag     | 友達状態                  |
