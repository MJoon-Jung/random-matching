<?php

namespace App\Domains\Matching\Services;

use App\Domains\Channel\Models\Channel;
use App\Domains\Matching\Models\Matching;
use App\Domains\Repository\Interface\RedisRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MatchingService
{
    public function __construct(private RedisRepositoryInterface $redisRepository)
    {
    }

    public function maleSideConnection(string $type)
    {
        if ($this->redisRepository->smembers($type.'women')) {
            $womanId = $this->redisRepository->spop($type.'women');
            $this->joinChannel(Auth::id(), $womanId, $type);
            return "matching success";
        } else {
            $this->redisRepository->sadd($type.'men', Auth::id());
            return "wait a minute";
        }

    }

    public function femaleSideConnection(string $type)
    {
        if ($this->redisRepository->smembers($type.'men')) {
            /* set 에서 유저 한명 꺼내서 매칭 시킴
            */
            $manId = $this->redisRepository->spop($type.'men');
            $this->joinChannel($manId, Auth::id(), $type);
            return "matching success";
        } else {
            $this->redisRepository->sadd($type.'women', Auth::id());
            return "wait a minute";
        }
    }
    public function classifyByGender(string $type)
    {
        return Auth::user()->isMan() ? $this->maleSideConnection( $type) : $this->femaleSideConnection( $type);
    }
    public function joinChannel(int $manId, int $womanId, string $type)
    {
        $channel = Channel::create([
            'id' => (string) Str::uuid(),
            'type' => $type,
        ]);
        $channel->members()->save(['man_id' => $manId, 'woman_id' => $womanId]);
    }
}

