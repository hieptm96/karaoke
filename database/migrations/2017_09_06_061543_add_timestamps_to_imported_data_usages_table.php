<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimestampsToImportedDataUsagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('imported_data_usages', function (Blueprint $table) {
            $table->macAddress('mac')->after('ktv_id')->nullable();
            $table->timestamps();
//            $table->dropColumn('song_file_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('imported_data_usages', function (Blueprint $table) {
            //
        });
    }
}
