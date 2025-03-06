<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoginMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('constants.LOGIN_TABLE'), function (Blueprint $table) {
            getDefaultMigrationColumns($table, function($table){
                $table->text('v_name');
                $table->text('v_email')->nullable();
        		$table->text('v_mobile')->nullable();
        		$table->longText('v_password');
        		$table->text('v_role');
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
        Schema::dropIfExists(config('constants.LOGIN_TABLE'));
    }
}
