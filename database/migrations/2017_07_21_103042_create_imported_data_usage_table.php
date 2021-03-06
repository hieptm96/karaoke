<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportedDataUsageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('imported_data_usages', function (Blueprint $table) {
             $table->increments('id');
             $table->unsignedInteger('imported_file_id')->default(0);
             $table->unsignedInteger('ktv_id')->index();
             $table->string('box_code')->index();
             $table->unsignedInteger('song_file_name')->index();
             $table->unsignedInteger('times')->default(1);
             $table->date('date');
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
         Schema::dropIfExists('imported_data_usages');
     }
}
