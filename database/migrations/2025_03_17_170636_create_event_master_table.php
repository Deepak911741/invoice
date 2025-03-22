<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('constants.EVENT_TABLE'), function (Blueprint $table) {
            getDefaultMigrationColumns($table, function($table){
                $table->integer('i_login_id');
        		$table->integer('i_profile_id');
        		$table->text('v_event');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('constants.EVENT_TABLE'));
    }
}
