<?php

namespace Shimoning\LineLogin\Entities;

class UserProfile extends Base
{
    /**
     * ユーザーID
     * @var string
     */
    protected $userId;

    /**
     * ユーザーの表示名
     * @var string
     */
    protected $displayName;

    /**
     * プロフィール画像のURL。スキームはhttpsです。
     * ユーザーが設定していない場合はレスポンスに含まれません。
     * @var string|null
     */
    protected $pictureUrl;

    /**
     * ユーザーのステータスメッセージ。
     * ユーザーが設定していない場合はレスポンスに含まれません。
     * @var string|null
     */
    protected $statusMessage;

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getDisplayName(): ?string
    {
        return $this->displayName ?? null;
    }

    public function getPictureUrl(): ?string
    {
        return $this->pictureUrl ?? null;
    }

    public function getStatusMessage(): ?string
    {
        return $this->statusMessage ?? null;
    }
}
