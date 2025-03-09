<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoginHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('constants.LOGIN_HISTORY_TABLE'), function (Blueprint $table) {
            getDefaultMigrationColumns($table, function ($table){
        		$table->integer('i_login_id');
        		$table->longText('i_session_id')->nullable();
        		$table->dateTime('dt_logout_time')->nullable();
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
        Schema::dropIfExists(config('constants.LOGIN_HISTORY_TABLE'));
    }
}
