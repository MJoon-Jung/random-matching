<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel_chat', function (Blueprint $table) {
            $table->id();
            $table->string('content');
            $table->uuid('channel_id')->nullable();
            $table
                ->foreign('channel_id')
                ->references('id')
                ->on('channels')
                ->constrained()
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->unsignedBigInteger('member_id')->nullable();
            $table
                ->foreign('member_id')
                ->references('id')
                ->on('users')
                ->constrained()
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->index('channel_id');
            $table->index('member_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channelchats');
    }
}
