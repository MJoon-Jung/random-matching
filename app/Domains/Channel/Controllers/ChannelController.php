<?php

namespace App\Domains\Channel\Controllers;

use App\Domains\Channel\Events\NewChannelEvent;
use App\Domains\Channel\Models\Channel;
use App\Domains\Channel\Models\Member;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChannelResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ChannelController extends Controller
{
    public function index()
    {
        $friends = Auth::user()->getFriendsAttribute();
        $channels = Auth::user()->chatChannels;

        return Inertia::render('Channel/Index',['friends' => $friends, 'channels' => $channels]);
    }

    public function show()
    {
    }
    public function loadChat(string $id)
    {
        $result = [];
        $status = 200;
        try {
            $channel = Channel::query()
                            ->where('id', $id)
                            ->with('chats', function($builder) {
                                return $builder->when(request('lastId'), function($query) {
                                    return $query->where('id', '<', request('lastId'))->take(30)->latest();
                                }, function ($q) {
                                    return $q->take(30)->latest();
                                });
                            })
                            ->orderByDesc('updated_at')
                            ->get()[0];
            $result['channel'] = $channel;
            $result['status'] = $status;
        }catch(\Exception $e) {
            $result['message'] = $e->getMessage();
            $result['status'] = $e->getCode();
        }

        return response()->json($result, $status);
    }
    public function joinChannel(int $manId, int $womanId, string $type)
    {
        DB::beginTransaction();
        try {
            $uuid = (string) Str::uuid();

            $channel = Channel::create([
                'id' => $uuid,
                'type' => $type,
            ]);

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
    public function participate(Channel $channel)
    {
        $channel->members()->save(new Member(['member_id'=>Auth::id(), 'channel_id'=>$channel->id]));

        $channel->load('members');

        return response()->json($channel);
    }

    public function store(Request $request)
    {

    }

    public function update()
    {
    }
}
