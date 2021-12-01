<?php

namespace Tests\Feature;

use App\Domains\User\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MatchingControllerTest extends TestCase
{
    /**
     * @test
     */
    public function itListsAllMatchingsByPaginatedWay()
    {
        $factory = new UserFactory();
        $user = $factory->create();
        $response = $this->actingAs($user);

//        $response = $this->get('/matching')->dump();
        $response = $this->get('/home?lastId=10')->dump();
//        $response->assertJsonCount(1, 'data');


        $response->assertOk(); //200

        $this->assertNotNull($response->json('data')[0]['id']);
        $this->assertNotNull($response->json('data')[0]['man']['id']);
        $this->assertNotNull($response->json('data')[0]['woman']['id']);
    }
}
