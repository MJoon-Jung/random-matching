<?php

namespace Tests\Feature;

use App\Domains\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChannelControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     */
    public function loadChannelWithMembers()
    {
        $user = User::query()->find(3);
        $this->actingAs($user);
        $response = $this->get('/chat/channels')->dump();

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function loadChannelWithCurrentChannel()
    {
        $user = User::query()->find(3);
        $this->actingAs($user);
        $response = $this->get('/chat/channels?friend=1')->dump();
//
        $response->assertStatus(200);
    }
    /**
     *
     */
    public function loadChats()
    {
        $user = User::find(2);
        $this->actingAs($user);
        $response = $this->get('/chat/channels/807d8c00-8814-4b2c-ba42-fbeb3bcb1470/chats?lastId=947');


        $response->assertStatus(200);
    }
}
