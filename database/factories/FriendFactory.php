<?php

namespace Database\Factories;

use App\Domains\Friend\Models\Friend;
use App\Domains\User\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class FriendFactory extends Factory
{
    /**
     * @var \App\Domains\Friend\Models\Friend  $model
     * @var \Database\Factories\ChannelFactory $factory
     */
    protected $model = Friend::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $factory = new UserFactory();
        return [
            'user_id' => $factory,
            'friend_id' => 1,
        ];
//        return [
//            'user_id' => 1,
//            'friend_id' => $factory,
//        ];
    }
}
