<?php

namespace Database\Seeders;

use App\Domains\Channel\Models\Channel;
use Database\Factories\ChannelFactory;
use Illuminate\Database\Seeder;

class ChannelSeeder extends Seeder
{
    /**
     * @var \App\Domains\Channel\Models\Channel  $model
     * @var \Database\Factories\ChannelFactory $factory
     */
    protected $model = Channel::class;
    protected $factory = ChannelFactory::class;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $factory = new ChannelFactory();
        $factory
            ->count(5)
            ->create();
    }
}
