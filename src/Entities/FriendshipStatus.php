<?php

namespace Shimoning\LineLogin\Entities;

class FriendshipStatus extends Base
{
    /**
     * ειηΆζ
     * @var string
     * @var bool
     */
    protected $friendFlag;

    public function getFriendFlag(): bool
    {
        return (bool)$this->friendFlag;
    }
}
