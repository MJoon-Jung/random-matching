<?php

namespace App\Domains\Repository\Interface;

interface RedisRepositoryInterface
{
    public function sadd(string $set, int $userId);

    public function spop(string $set);

    public function smembers(string $set);
}
