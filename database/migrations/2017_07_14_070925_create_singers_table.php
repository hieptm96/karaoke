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
            $table->string('Name', 80)->index();
            $table->integer('Sex');
            $table->integer('Lang');
            $table->string('Spell', 12)->index();
            $table->String('FileName', 12);
            $table->integer('star');
            $table->string('NameRaw', 80)->index();
            $table->integer('freq');
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
        Schema::dropIfExists('singer');
    }
}
