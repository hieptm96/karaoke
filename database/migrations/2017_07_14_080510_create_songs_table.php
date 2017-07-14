<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('song', function (Blueprint $table) {
            $table->increments('id');
            $table->string('SongName', 128)->index();
            $table->integer('WordNum')->index();
            $table->string('PyCode', 12);
            $table->text('Stroke');
            $table->string('SingerName1', 80)->index();
            $table->string('SingerName2', 80)->index();
            $table->string('FileName', 12);
            $table->integer('Lang');
            $table->integer('Mtype');
            $table->integer('yTrack');
            $table->integer('bTrack');
            $table->integer('yVolur');
            $table->integer('bVolume');
            $table->integer('SongTypeID');
            $table->integer('NewSong');
            $table->integer('Address');
            $table->integer('SingerID1');
            $table->integer('SingerID2');
            $table->integer('style');
            $table->integer('freq');
            $table->string('SongNameRaw', 128)->index();
            $table->text('lyric');
            $table->text('lyricRaw');
            $table->integer('favorite');
            $table->string('selectedTime');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('song');
    }
}
