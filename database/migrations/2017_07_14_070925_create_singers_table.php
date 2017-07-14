<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSingersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('singer', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Name', 80);
            $table->integer('Sex');
            $table->integer('Lang');
            $table->String('Spell', 12);
            $table->String('FileName', 12);
            $table->integer('star');
            $table->String('NameRaw', 80);
            $table->integer('frep');
            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('singer');
    }
}
