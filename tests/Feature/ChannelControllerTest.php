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
     *
     */
    public function loadChannelWithMembers()
    {
        $user = User::find(2);
        $this->actingAs($user);
        $response = $this->get('/chat/channels');
//
        $response->assertStatus(200);
    }
    /**
     * @test
     */
    public function loadChats()
    {
        $user = User::find(2);
        $this->actingAs($user);
        $response = $this->get('/chat/channels/807d8c00-8814-4b2c-ba42-fbeb3bcb1470/chats?lastId=947')->dump();


        $response->assertStatus(200);
    }
}
