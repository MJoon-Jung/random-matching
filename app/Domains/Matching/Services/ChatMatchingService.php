<?php

namespace App\Domains\Matching\Services;

use App\Domains\Matching\Repository\Interface\MatchingRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class ChatMatchingService
{
    public function __construct(private MatchingRepositoryInterface $matchingRepository)
    {
    }

    public function connectOnTheMaleSide()
    {
        Auth::user()->isMan() ? $this->connectOnTheMaleSide() : $this->connectOnTheFemaleSide();
        if ($this->matchingRepository->smembers('women')) {
            $woman = $this->matchingRepository->spop('women');
            //connect
        } else {
            $this->matchingRepository->sadd('men', Auth::user()->id);
        }

    }

    public function connectOnTheFemaleSide()
    {
        Auth::user()->isMan() ? $this->connectOnTheMaleSide() : $this->connectOnTheFemaleSide();
        if ($this->matchingRepository->smembers('men')) {
            $man = $this->matchingRepository->spop('men');
            //connect
        } else {
            $this->matchingRepository->sadd('women', Auth::user()->id);
        }
    }
    public function connect(string $type)
    {
    }
    public function connectWithOppositeGender()
    {

    }
    public function connectWithRamdomGender()
    {

    }
    public function categorize(int $type)
    {
        $type === 1 ? connectByGender() : connectOnRandom();
    }
}

