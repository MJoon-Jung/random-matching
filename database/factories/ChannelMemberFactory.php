<?php

namespace Database\Factories;

use App\Domains\Channel\Models\Channel;
use App\Domains\Channel\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class ChannelMemberFactory extends Factory
{
    /**
     * @var \App\Domains\Channel\Models\Member  $model
     */
    protected $model = Member::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
//        $channels = Channel::select('id')->get();
        $channels = ['0499f659-5df9-3996-ab3a-47eae7c3e832', '40470fbd-28f6-3309-9836-a0fce78b4f1f'];
        Arr::random($channels);
        $factory = new UserFactory();
        return [
            'member_id' => $factory,
            'channel_id' => Arr::random($channels),
        ];
    }
}
