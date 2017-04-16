<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosInPlaylistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos_in_playlists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('playlist_id');
            $table->integer('video_id');
            $table->integer('order_in_playlist');
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
        Schema::dropIfExists('videos_in_playlists');
    }
}
