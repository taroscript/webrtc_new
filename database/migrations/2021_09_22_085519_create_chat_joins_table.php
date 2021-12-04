<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatJoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_joins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_user_id')
            ->constrained('chat_users')
            ->onDelete('cascade');

            $table->foreignId('chat_room_id')
            ->constrained('chat_rooms')
            ->onDelete('cascade');
            
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
        Schema::dropIfExists('chat_joins');
    }
}
