<?php

namespace App\Domains\Channel\Controllers;

use App\Domains\Channel\Events\NewChannelEvent;
use App\Domains\Channel\Models\Channel;
use App\Domains\Channel\Models\Member;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChannelResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use function PHPUnit\Framework\isEmpty;

class ChannelController extends Controller
{
    public function index()
    {
        $friends = Auth::user()->getFriendsAttribute();
        if(request('friend')) {
            $channel = $this->searchDmChannel(request('friend'));
            if (!count($channel)) {
                $channel = $this->joinChannel(Auth::id(), request('friend', ),'chat');
            }
            $channels = Auth::user()->chatChannels;
            return Inertia::render('Channel/Index',['friends' => $friends, 'channels' => $channels, 'currentChannel' => $channel]);
        }
        $channels = Auth::user()->chatChannels;
        return Inertia::render('Channel/Index',['friends' => $friends, 'channels' => $channels]);
    }
    public function searchDmChannel(int $friendId): ?Collection
    {
        return Channel::query()
            ->leftJoin('channel_member', 'channels.id', '=', 'channel_member.channel_id')
            ->where('channels.type', 'chat')
            ->where('channel_member.member_id', Auth::id())
            ->whereIn('channels.id', function ($query) use ($friendId) {
                return $query->select('channel_id')->from('channel_member')->where('member_id', $friendId)->get();
            })
            ->select( 'channels.*')
            ->get();
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
                                }, function ($query) {
                                    return $query->take(30)->latest();
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
    public function joinChannel(int $member_id1, int $member_id2, string $type)
    {
        DB::beginTransaction();
        $channel=null;
        try {
            $uuid = (string) Str::uuid();

            $channel = Channel::create([
                'id' => $uuid,
                'type' => $type,
            ]);

            Member::create([
                'channel_id' => $channel->id,
                'member_id' => $member_id1,
            ]);

            Member::create([
                'channel_id' => $channel->id,
                'member_id' => $member_id2,
            ]);

            broadcast(new NewChannelEvent($channel, $member_id1, $member_id2));

            DB::commit();
        }catch (\Exception $e) {
            DB::rollback();
        }
        return $channel;
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
