<?php

namespace Shimoning\LineLogin\Entities;

class IdTokenVerifiedResult extends Output
{
    /**
     * IDトークンの生成URL
     * @var string
     */
    protected $iss;

    /**
     * IDトークンの対象ユーザーID
     * @var string
     */
    protected $sub;

    /**
     * チャネルID
     * @var string
     */
    protected $aud;

    /**
     * IDトークンの有効期限。UNIXタイムです。
     * @var int
     */
    protected $exp;

    /**
     * IDトークンの生成時間。UNIXタイムです。
     * @var int
     */
    protected $iat;

    /**
     * ユーザー認証時間。UNIXタイムです。認可リクエストにmax_ageの値を指定しなかった場合は含まれません。
     * @var int|null
     */
    protected $authTime;

    /**
     * 認可URLに指定したnonceの値。
     * 認可リクエストにnonceの値を指定しなかった場合は含まれません。
     * @var string|null
     */
    protected $nonce;

    /**
     * ユーザーが使用した認証方法のリスト。特定の条件下ではペイロードに含まれません。
     * 以下のいずれかの値が含まれます。
     *  - pwd: メールアドレスとパスワードによるログイン
     *  - lineautologin: LINEによる自動ログイン（LINE SDKを使用した場合も含む）
     *  - lineqr: QRコードによるログイン
     *  - linesso: シングルサインオンによるログイン
     * @var string[]
     */
    protected $amr;

    /**
     * ユーザーの表示名。
     * 認可リクエストにprofileスコープを指定しなかった場合は含まれません。
     * @var string|null
     */
    protected $name;

    /**
     * ユーザープロフィールの画像URL。
     * 認可リクエストにprofileスコープを指定しなかった場合は含まれません。
     * @var string|null
     */
    protected $picture;

    /**
     * ユーザーのメールアドレス。
     * 認可リクエストにemailスコープを指定しなかった場合は含まれません。
     * @var string|null
     */
    protected $email;

    public function getIss(): string
    {
        return $this->iss;
    }

    public function getSub(): string
    {
        return $this->sub;
    }

    public function getAud(): string
    {
        return $this->aud;
    }

    public function getExp(): int
    {
        return $this->exp;
    }

    public function getIat(): int
    {
        return $this->iat;
    }

    public function getAuthTime(): ?int
    {
        return $this->authTime ?? null;
    }

    public function getNonce(): ?string
    {
        return $this->nonce ?? null;
    }

    /** @return  string[] */
    public function getAmr(): array
    {
        return $this->amr ?? [];
    }

    public function getName(): ?string
    {
        return $this->name ?? null;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
}
