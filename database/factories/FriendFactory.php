<?php

namespace Database\Factories;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FriendFactory extends Factory
{
    protected $model = Friend::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
//        return [
//            'user_id' => User::factory(),
//            'friend_id' => 1,
//        ];
//        return [
//            'user_id' => 1,
//            'friend_id' => User::factory(),
//        ];
    }
}
