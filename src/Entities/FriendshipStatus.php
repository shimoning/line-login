<?php

namespace Shimoning\LineLogin\Entities;

class FriendshipStatus extends Output
{
    /**
     * 友達状態
     * @var bool
     */
    protected $friendFlag;

    public function getFriendFlag(): bool
    {
        return (bool)$this->friendFlag;
    }
}
