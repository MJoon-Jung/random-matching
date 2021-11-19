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

    public function spop(string $set)
    {
        return (int) Redis::command('spop', [$set]);
    }

    public function smembers(string $set)
    {
        $members = Redis::command('smembers', [$set]);
        if ($members) {
            return (int) $members[0];
        }
        return 0;
    }
}
