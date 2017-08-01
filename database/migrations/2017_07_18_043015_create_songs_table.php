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
        Schema::create('songs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('file_name')->default(0);
            $table->string('name')->index();
            $table->string('name_raw')->nullable();
            $table->string('abbr', 100);
            $table->tinyInteger('word_num')->default(1);
            $table->tinyInteger('language')->default(0);
            $table->tinyInteger('is_new_song')->default(0);
            $table->tinyInteger('freq')->default(0);
            $table->boolean('has_fee')->default(1);
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
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
        Schema::dropIfExists('songs');
    }
}
