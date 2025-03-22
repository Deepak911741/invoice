<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('constants.INVOICE_TABLE'), function (Blueprint $table) {
            getDefaultMigrationColumns($table, function($table){
                $table->integer('i_login_id');
                $table->text('v_name');
                $table->text('v_mobile');
                $table->date('dt_date');
                $table->longText('v_address');
                $table->text('i_service_ids');
                $table->text('i_event_ids');
                $table->text('v_total_payment');
                $table->text('v_advance_payment')->nullable();
                $table->text('v_due_payment');
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
        Schema::dropIfExists(config('constants.INVOICE_TABLE'));
    }
}
