# line-login
Line login


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
LINEログインボタンにセットするURL

```php
$lineLogin->generateRequestUrl(); // https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=...
```

### 上記URLを踏んでユーザが戻ってきたとき
```php
$queryData = filter_input_array(INPUT_GET, $_GET); // Pure PHP
$queryData = $request->query(); // Laravel

$this->lineLogin->extractCode($queryData); // Sh1m0...
```

### アクセストークンを取得する
上記で取得した code を使う

```php
$issued = $this->lineLogin->issueAccessToken($code); // AccessTokenCapsule エンティティ (後述)

// アクセストークン
$accessToken = $issued->getAccessToken(); // eyJhbGciOiJIUz...

// リフレッシュトークン
$refreshToken $issued->getRefreshToken(); // N0mi...
```

### アクセストークンを検証する
```php
$this->lineLogin->verifyAccessToken($accessToken); // true or false
```

### アクセストークンを更新する
```php
$this->lineLogin->refreshAccessToken($refreshToken); // AccessTokenCapsule エンティティ (後述)
```

### アクセストークンを無効化する
```php
$this->lineLogin->revokeAccessToken($accessToken); // true or false
```

### ユーザプロフィールを取得する
```php
$this->lineLogin->getUserProfile($accessToken); // UserProfile エンティティ (後述)
```

### 公式アカウントとの友達状態を取得する
```php
$this->lineLogin->getFriendshipStatus($accessToken); // FriendshipStatus エンティティ (後述)
```

## エンティティ

### AccessTokenCapsule
|      Methods      |       Description        |
|:------------------|:-------------------------|
| getAccessToken    | アクセストークンを取得する   |
| getExpiresIn      | 有効期限までの時間(秒)      |
| getIdToken        | OpenId の JWT            |
| getRefreshToken   | 更新用のリフレッシュトークン |
| getScope          | スコープ (スペースつなぎ)   |
| getScopeList      | スコープリスト (配列)      |
| getTokenType      | Bearer (固定)            |

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
