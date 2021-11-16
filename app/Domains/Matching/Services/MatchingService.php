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

    public function maleSideConnection(string $matchingType)
    {
        if ($this->redisRepository->smembers($matchingType.'women')) {
            $woman = $this->redisRepository->spop($matchingType.'women');
            $this->createMatching(Auth::id(), $woman);
        } else {
            $this->redisRepository->sadd($matchingType.'men', Auth::id());
        }

    }

    public function femaleSideConnection(string $matchingType)
    {
        if ($this->redisRepository->smembers($matchingType.'men')) {
            /* set 에서 유저 한명 꺼내서 매칭 시킴
            */
            $man = $this->redisRepository->spop($matchingType.'men');
            $this->createChannel();
            return "matching success";
        } else {
            $this->redisRepository->sadd($matchingType.'women', Auth::id());
            return "wait a minute";
        }
    }
    public function classifyByGender(string $matchingType)
    {
        Auth::user()->isMan() ? $this->maleSideConnection($matchingType) : $this->femaleSideConnection($matchingType);
    }
    public function createChannel()
    {
        // 채널을 여기서 생성하는 게 맞는건지 다시 생각
        // 채널 레포지토리라든지 다른 데에 의존하는 게 맞는 것 같기도
        return Channel::create([
            'id' => (string) Str::uuid(),
            'type' => 'blind_data_video_chat',
//            ['blind_date_chat', 'blind_date_video_chat', 'chat', 'video_chat']);
        ]);
    }
}

