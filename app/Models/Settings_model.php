<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Settings_model extends My_model
{
    use HasFactory, SoftDeletes;
    protected $table = '';
    protected $primaryKey = 'i_id';
    protected $date = ['dt_deleted_at'];

    public function __construct(){
        parent::__construct();
        $this->table = config('constants.SETTINGS_TABLE');
    }

    public function getRecordDetails($whereData = [], $likeData = [], $additionalData = []){
        $selectData = [
            'v_primary_mobile_no',
            'v_secondary_mobile_no',
            'v_other_mobile_no',
            'v_whatsapp_number',
            'e_whatsapp_position',
            'v_email',
            'v_working_hours',
            'v_google_map',
            'v_short_address',
            'v_address',
            'v_facebook_link',
            'v_instagram_link',
            'v_youtube_link',
            'v_linkedin_link',
            'v_twitter_link',
            'v_site_title',
            'v_site_keywords',
            'v_about_short_description',
            'v_site_description',
            'v_meta_author',
            'v_powered_by',
            'v_powered_by_link',
            'v_mail_title',
            'd_version',
            'v_website_logo',
            'v_website_footer_logo',
            'v_website_fav_icon',
            'v_website_og_icon',
            't_contact_settings_tab',
            't_social_links_tab',
            't_site_info_tab',
            't_logo_settings_tab',
            'v_working_days'
    ];
    
    if(isset($whereData['isBackendRequest']) && $whereData['isBackendRequest'] != false){
        $selectData[] = "i_id";
        $selectData[] = "t_is_active";
        $selectData[] = 'v_contact_receive_mail';
        $selectData[] = 'v_default_cc_mail';
        $selectData[] = 'v_send_email_protocol';
        $selectData[] = 'v_send_email_host';
        $selectData[] =	'i_send_email_port';
        $selectData[] = 'v_send_email_user';
        $selectData[] = 'v_send_email_password';
        $selectData[] = 'v_send_email_encryption';
        $selectData[] = 't_smtp_connection_tab';
        $selectData[] = 't_send_email';
        unset($whereData['isBackendRequest']);
    }

    $data = Settings_model::select($selectData)->where('t_is_deleted', config('constants.INACTIVE_STATUS'))->first();
    return $data;
    }
}
