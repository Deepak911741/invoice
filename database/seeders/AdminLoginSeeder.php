<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class AdminLoginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(config('constants.LOGIN_TABLE'))->insert([
            'v_name' => 'Admin',
            'v_email' => 'infodeepak@gmail.com',
            'v_mobile' => '9117417204',
            'v_role' => 'admin',
            'v_password' => password_hash('admin', PASSWORD_DEFAULT),
            'i_created_id' => '1',
            'dt_created_at' => date('Y-m-d H-i-s'),
            'v_ip' => Request::ip(),
        ]);
    }
}
