<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropSongFileNameFromContentOwnerSong extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('content_owner_song', 'song_file_name')) {
            Schema::table('content_owner_song', function ($table) {
                $table->dropColumn('song_file_name');
            });
        }

        try {
            Schema::table('content_owner_song', function ($table) {
//                $table->dropColumn('song_file_name');
//                $table->dropUnique(['content_owner_id', 'song_file_name', 'type']);
            });
        } catch (Exception $e) {
            echo $e;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
