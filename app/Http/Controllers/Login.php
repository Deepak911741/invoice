<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Login_model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Message;

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


    public function checkLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'login_email' => 'required',
			'login_password' => 'required',
        ],
        [
            'login_email.required' => trans("messages.required-enter-field-validation" , [ "fieldName" => trans("messages.email-id") ]) ,
				'login_password.required' => trans("messages.required-enter-field-validation" , [ "fieldName" => trans("messages.password") ]) ,
        ]
        );

        if ($validator->fails()) {
			return redirect($this->loginPage)->withErrors($validator)->withInput();
		}

        $email = $request->input('login_email');
        $password = $request->input('login_password');

        $checkLoginWhere = [];
        $checkLoginWhere['v_email'] = $email;
        $checkLoginWhere['t_is_deleted'] = config('constants.INACTIVE_STATUS');
        if (in_array($email, config('constants.DEFAULT_PORTFOLIO_ADMIN_EMAIL'))) {
            unset($checkLoginWhere['t_is_deleted']);
        }

        $checkLogin = Login_model::where($checkLoginWhere)->first();

        if(empty($checkLogin)){
            Message::setFlashMessage('danger', trans('messages.invalid-login'), false);
            return redirect($this->loginPage);
        }

        if($checkLogin->t_is_active == config('constants.INACTIVE_STATUS')){
            Message::setFlashMessage('danger', trans('messages.error-inactive-account-login'));
        }

        if(password_verify($password, $checkLogin->v_password)){
            session()->flash('keep_me_logged_in' , (!empty($request->input('keep_me_logged_in')) ? $request->input('keep_me_logged_in') : '' ) );

            $this->commonLoginSessionEntry($checkLogin , $password);
            $requestUrl =  config('constants.SUCCESS_LOGIN_REDIRECT');
            return redirect($requestUrl);
        }else{
            Message::setFlashMessage('danger', trans('messages.invalid-login'), false);
            return redirect()->back()->withInput();
        }
        Message::setFlashMessage('danger',  trans('messages.invalid-login'), false);
        return redirect()->back()->withInput();
    }
}
