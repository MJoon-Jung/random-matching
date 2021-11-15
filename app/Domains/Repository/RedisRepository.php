<?php

namespace App\Domains\Repository;

use App\Domains\Repository\Interface\RedisRepositoryInterface;
use Illuminate\Support\Facades\Redis;

class RedisRepository implements RedisRepositoryInterface
{

    public function sadd(string $set, int $userId)
    {
        Redis::command('sadd', [$set, $userId]);
    }

    public function spop(string $set): ?int
    {
        return Redis::command('spop', [$set]);
    }

    public function smembers(string $set): ?int
    {
        return Redis::command('smembers', [$set]);
    }
}
