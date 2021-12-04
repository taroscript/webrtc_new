<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateChatJoinsAddVideoStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chat_joins', function (Blueprint $table) {
            //
            $table->boolean("video_status")->default(false);
            $table->enum("join_type",["host","guest"])->default("guest");
            $table->text("offer_sdp")->nullable();
            $table->text("answer_sdp")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chat_joins', function (Blueprint $table) {
            //
            $table->boolean("video_status")->default(false);
            $table->string("join_type",["host","guest"])->default("guest");
            $table->text("offer_sdp")->nullable();
            $table->text("answer_sdp")->nullable();
        });
    }
}
