<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('constants.PROFILE_TABLE'), function (Blueprint $table) {
            getDefaultMigrationColumns($table, function($table){
                $table->integer('i_login_id');
        		$table->text('v_shop_name');
        		$table->longText('v_address');
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
        Schema::dropIfExists(config('constants.PROFILE_TABLE'));
    }
}
