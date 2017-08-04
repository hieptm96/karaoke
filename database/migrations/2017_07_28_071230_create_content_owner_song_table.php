<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentOwnerSongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_owner_song', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('content_owner_id');
            $table->unsignedInteger('song_id');
            $table->string('type', 20);
            $table->unsignedInteger('percentage');
            $table->timestamps();
            $table->unsignedInteger('song_file_name')->default(0);

            $table->unique(['content_owner_id', 'song_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_owner_song');
    }
}
