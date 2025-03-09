<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('constants.SETTINGS_TABLE'), function (Blueprint $table) {
            getDefaultMigrationColumns($table, function ($table){
        		$table->longtext('v_primary_mobile_no')->nullable();
        		$table->longtext('v_secondary_mobile_no')->nullable();
        		$table->longtext('v_other_mobile_no')->nullable();
        		$table->longtext('v_whatsapp_number')->nullable();
        		$table->enum('e_whatsapp_position' , [ config('constants.LEFT') , config('constants.RIGHT') ])->default(config('constants.RIGHT'));
        		$table->longtext('v_email')->nullable();
        		$table->longtext('v_working_hours')->nullable();
        		$table->longtext('v_working_days')->nullable();
        		$table->longtext('v_google_map')->nullable();
        		$table->longtext('v_short_address')->nullable();
        		$table->longtext('v_address')->nullable();
        		$table->longtext('v_facebook_link')->nullable();
        		$table->longtext('v_instagram_link')->nullable();
        		$table->longtext('v_youtube_link')->nullable();
        		$table->longtext('v_linkedin_link')->nullable();
        		$table->longtext('v_twitter_link')->nullable();
        		$table->longtext('v_site_title')->nullable();
        		$table->longtext('v_site_keywords')->nullable();
        		$table->longtext('v_about_short_description')->nullable();
        		$table->longtext('v_site_description')->nullable();
        		$table->longtext('v_meta_author')->nullable();
        		$table->longtext('v_powered_by')->nullable();
        		$table->longtext('v_powered_by_link')->nullable();
        		$table->longtext('v_mail_title')->nullable();
        		$table->longtext('d_version')->nullable();
        		$table->longtext('v_default_cc_mail')->nullable();
        		$table->longtext('v_contact_receive_mail')->nullable();
        		$table->longtext('v_send_email_protocol')->nullable();
        		$table->longtext('v_send_email_host')->nullable();
        		$table->integer('i_send_email_port')->nullable();
        		$table->longtext('v_send_email_user')->nullable();
        		$table->longtext('v_send_email_password')->nullable();
        		$table->longtext('v_send_email_encryption')->nullable();
        		$table->longtext('v_website_logo')->nullable();
        		$table->longtext('v_website_footer_logo')->nullable();
        		$table->longtext('v_website_fav_icon')->nullable();
        		$table->longtext('v_website_og_icon')->nullable();
        		$table->tinyInteger('t_contact_settings_tab')->default('1');
        		$table->tinyInteger('t_social_links_tab')->default('1');
        		$table->tinyInteger('t_smtp_connection_tab')->default('1');
        		$table->tinyInteger('t_site_info_tab')->default('1');
        		$table->tinyInteger('t_logo_settings_tab')->default('1');
        		$table->tinyInteger('t_send_email')->default('1');
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
        Schema::dropIfExists(config('constants.SETTINGS_TABLE'));
    }
}
