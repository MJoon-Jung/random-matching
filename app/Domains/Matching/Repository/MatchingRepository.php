<?php

namespace App\Domains\Matching\Repository;

use App\Domains\Matching\Models\Matching;
use App\Domains\Matching\Repository\Interface\MatchingRepositoryInterface;
use Illuminate\Support\Facades\Redis;

class MatchingRepository implements MatchingRepositoryInterface
{

    public function sadd(string $set, int $userId)
    {
        Redis::command('sadd', [$set, $userId]);
    }

    public function spop(string $set): ?int
    {
        return Redis::command('spop', $set);
    }

    public function smembers(string $set): ?int
    {
        return Redis::command('smembers', $set);
    }
}
