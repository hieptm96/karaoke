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
        Schema::create('singers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->integer('sex')->default(0);
            $table->integer('language')->default(0);
            $table->string('abbr', 20)->index();
            $table->string('file_name')->nullable();
            $table->integer('star')->default(1);
            $table->string('name_raw')->nullable();
            $table->integer('freq')->default(0);
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
        Schema::dropIfExists('singers');
    }
}