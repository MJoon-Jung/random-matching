<?php

namespace Database\Seeders;


use App\Domains\Friend\Models\Friend;
use Database\Factories\FriendFactory;
use Database\Factories\FriendshipFactory;
use Illuminate\Database\Seeder;

class FriendSeeder extends Seeder
{
    protected $model = Friend::class;
    protected $factory = FriendFactory::class;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $factory = new FriendFactory();
        $factory
            ->count(5)
            ->create();
    }
}
