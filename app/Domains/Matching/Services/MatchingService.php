<?php

namespace App\Domains\Matching\Services;

use App\Domains\Channel\Events\NewChannelEvent;
use App\Domains\Channel\Models\Channel;
use App\Domains\Channel\Models\Member;
use App\Domains\Matching\Models\Matching;
use App\Domains\Repository\Interface\RedisRepositoryInterface;
use App\Domains\Repository\RedisRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class MatchingService
{
    public function __construct(private RedisRepository $redisRepository)
    {
    }

    public function maleSideConnection(string $type)
    {
        if ($this->redisRepository->smembers($type.'.women')) {
            $womanId = $this->redisRepository->spop($type.'.women');
            $this->joinChannel(Auth::id(), $womanId, $type);
            return "matching success";
        } else {
            $this->redisRepository->sadd($type.'.men', Auth::id());
            return "wait a minute";
        }

    }

    public function femaleSideConnection(string $type)
    {
        if ($this->redisRepository->smembers($type.'.men')) {
            /* set 에서 유저 한명 꺼내서 매칭 시킴
            */
            $manId = $this->redisRepository->spop($type.'.men');
            Log::info(
                sprintf(
                    "%d을 redis 에서 뺐습니다.",
                    $manId
                )
            );
            $this->joinChannel($manId, Auth::id(), $type);
            return "matching success";
        } else {
            $this->redisRepository->sadd($type.'.women', Auth::id());
            return "wait a minute";
        }
    }
    public function classifyByGender(string $type)
    {
        return Auth::user()->isMan() ? $this->maleSideConnection( $type) : $this->femaleSideConnection( $type);
    }

    /**
     * @throws \Throwable
     */
    public function joinChannel(int $manId, int $womanId, string $type)
    {
        DB::beginTransaction();
        try {
            $uuid = (string) Str::uuid();
            Log::info(
                sprintf(
                    "아이디 %s  타입은 %s",
                    $uuid,
                    $type
                )
            );
            $channel = Channel::create([
                'id' => $uuid,
                'type' => $type,
            ]);
            Log::info($channel);

            Member::create([
                'channel_id' => $channel->id,
                'member_id' => $manId,
            ]);
            Member::create([
                'channel_id' => $channel->id,
                'member_id' => $womanId,
            ]);
            broadcast(new NewChannelEvent($channel, $manId, $womanId));

            DB::commit();
        }catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }
}

