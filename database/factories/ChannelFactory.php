<?php

namespace Database\Factories;

use App\Domains\Channel\Models\Channel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class ChannelFactory extends Factory
{
    /**
     * @var \App\Domains\Channel\Models\Channel  $model
     *
     */

    protected $model = Channel::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type = ['blind_date_chat', 'blind_date_video_chat', 'chat', 'video_chat'];
        return [
            'id' => $this->faker->uuid(),
            'type' => Arr::random($type),
        ];
    }
}
