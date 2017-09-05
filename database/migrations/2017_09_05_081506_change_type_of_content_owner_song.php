<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTypeOfContentOwnerSong extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('content_owner_song', 'type')) {
            Schema::table('content_owner_song', function ($table) {
                $table->dropColumn('type');
            });
        }

        Schema::table('content_owner_song', function (Blueprint $table) {
            $table->tinyInteger('type')->default(1)->index();
        });

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
