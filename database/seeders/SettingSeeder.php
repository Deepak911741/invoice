<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(config('constants.SETTINGS_TABLE'))->truncate();
        DB::table(config('constants.SETTINGS_TABLE'))->insert([
            'v_primary_mobile_no' => '9117417204',
            'v_whatsapp_number' => '9117417204',
            'v_google_map' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3670.5297493508297!2d72.54341307600916!3d23.07769571426754!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e833890048eff%3A0x5f971f44dae31b42!2sAarambh%2C%20Chandlodia!5e0!3m2!1sen!2sin!4v1741502561439!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            'v_short_address' => 'Aarambh, Chandlodia, Gujrat',
            'v_address' => 'A Block 502, Aarambh By Saanvi Nirman, Chandlodia, Ahmedabad, Gujrat, 382481',
            'v_facebook_link' => 'https://www.facebook.com/',
            'v_instagram_link' => 'https://www.instagram.com/',
            'v_youtube_link' => 'https://www.youtube.com/',
            'v_linkedin_link' => 'https://www.linkedin.com/',
            'v_twitter_link' => 'https://www.twitter.com/',
            'v_site_title' => 'Invoce Management',
            'v_meta_author' => 'deepak kumar',
            'v_mail_title' => 'Invoce Management',
            'd_version' => date('d.m'),
            'v_powered_by_link' => 'https://deepakportfolio-nu.vercel.app',
            'v_powered_by' => 'DEEPAK',
            'v_send_email_protocol' => 'smtp',
            'v_send_email_host' => 'ssl://smtp.zoho.in',
            'i_send_email_port' => '465',
            'v_send_email_user' => 'dk367748@gmail.com',
            'v_send_email_password' => '123456789',
            'i_created_id' => '1',
            'dt_created_at' => date('Y-m-d H:i:s'),
            'v_ip' => Request::ip(),
        ]);
    }
}
