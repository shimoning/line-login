<?php

namespace Shimoning\LineLogin\Entities;

class FriendshipStatus extends Base
{
    /**
     * 友達状態
     * @var string
     * @var bool
     */
    protected $friendFlag;

    public function getFriendFlag(): bool
    {
        return (bool)$this->friendFlag;
    }
}
