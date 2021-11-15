<?php

namespace App\Domains\Matching\Services;

use App\Domains\Repository\Interface\RedisRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class MatchingService
{
    public function __construct(private RedisRepositoryInterface $redisRepository)
    {
    }

    public function connectOnTheMaleSide()
    {
        if ($this->redisRepository->smembers('chatWomen')) {
            $woman = $this->redisRepository->spop('chatWomen');
            //connect
        } else {
            $this->redisRepository->sadd('chatMen', Auth::id());
        }

    }

    public function connectOnTheFemaleSide()
    {
        if ($this->redisRepository->smembers('chatMen')) {
            $man = $this->redisRepository->spop('chatMen');
            //connect
        } else {
            $this->redisRepository->sadd('chatWomen', Auth::id());
        }
    }

    public function connect(int $genderType, string $matchingType)
    {
        switch ($matchingType){
        }
    }
}

