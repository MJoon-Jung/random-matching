<?php

namespace App\Domains\Matching\Repository\Interface;

interface MatchingRepositoryInterface
{
    public function sadd(string $set, int $userId);

    public function spop(string $set): ?int;

    public function smembers(string $set): ?int;
}
