<?php

namespace App\Domains\Matching\Services;

use App\Domains\Matching\Repository\Interface\MatchingRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ChatMatchingService
{
    public function __construct(private MatchingRepositoryInterface $matchingRepository)
    {
    }

    public function connectOnTheMaleSide()
    {
        if ($this->matchingRepository->smembers('women')) {
            $woman = $this->matchingRepository->spop('women');
            //connect
        } else {
            $this->matchingRepository->sadd('men', Auth::user()->id);
        }

    }

    public function connectOnTheFemaleSide()
    {
        if ($this->matchingRepository->smembers('men')) {
            $man = $this->matchingRepository->spop('men');
            //connect
        } else {
            $this->matchingRepository->sadd('women', Auth::user()->id);
        }
    }

    public function connect(int $type)
    {
        switch ($type){
            case 1:
                $this->connectWithOppositeGender();
            case 2:
                $this->connectWithRamdomGender();
        }
    }

    public function connectWithOppositeGender()
    {
        Auth::user()->isMan() ? $this->connectOnTheMaleSide() : $this->connectOnTheFemaleSide();
    }

    public function connectWithRamdomGender()
    {

    }
}

