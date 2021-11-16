<?php

namespace Database\Seeders;

use Database\Factories\ChannelMemberFactory;
use Illuminate\Database\Seeder;

class ChannelMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $factory = new ChannelMemberFactory();
        $factory
            ->count(30)
            ->create();
    }
}
