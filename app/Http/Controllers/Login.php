<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Login_model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class Login extends MY_controller
{
    public $loginPage;
    public function __construct(){
        parent::__construct();
        $this->loginPage = config('constants.LOGIN_URL');
        $this->foldername = config('constants.ADMIN_FOLDER');
    }

    public function index(){
        if(session()->has('isLoggedIn') && session()->get('isLoggedIn') != false){
           return redirect(config('constants.SUCCESS_LOGIN_REDIRECT'));
        }
    
        $data['pageTitle'] = trans('messages.login');
        return $this->guestView($this->foldername . 'login', $data);
    }
}
