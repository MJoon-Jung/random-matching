<?php

namespace Database\Seeders;


use App\Models\Friend;
use Database\Factories\FriendshipFactory;
use Illuminate\Database\Seeder;

class FriendSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Friend::factory()
            ->count(5)
            ->create();
    }
}
