<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dashbord extends Guest
{
    public function __construct(){
        parent::__construct();
        $this->foldername = config('constants.ADMIN_FOLDER') . 'dashbord/';
    }

    public function index(){
        $data['pageTitle'] = trans('messages.dashboard');
        return $this->loadAdminView($this->foldername . 'dashbord', $data);
    }

    public function logout(Request $request)
    {

        $currentSessionToken = session()->get('_token');
        // if (!empty($currentSessionToken)) {
        //     $this->my_model->updateTableData(config('constants.LOGIN_HISTORY_TABLE'), ['dt_logout_time' => date('Y-m-d H:i:s')], ['i_login_id' => session()->get('user_id'), 'i_session_id' => $currentSessionToken]);
        // }
        $request->session()->flush();
        unset($_SESSION['login_application_user']);
        return redirect(config('constants.LOGIN_URL'));
    }
}
