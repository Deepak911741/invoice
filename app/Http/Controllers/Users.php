<?php

namespace App\Http\Controllers;

use App\Models\Login_model;
use Illuminate\Http\Request;

class Users extends MY_controller
{
    public function __construct(){
        parent::__construct();
        $this->crudModel = new Login_model();
        $this->tableName = config('constants.LOGIN_TABLE');
        $this->redirectUrl = config('constants.USERS_URL');
        $this->moduleName = trans('messages.user');
        $this->foldername = config('constants.ADMIN_FOLDER' ) . 'users/';
    }

    public function index(){
        if(session()->has('role') && session()->get('role') != config('constants.ROLE_ADMIN')){
            return redirect(config('constants.SUCCESS_LOGIN_REDIRECT'));
        }

        $data['pageTitle'] = trans('messages.users');
        return $this->loadAdminView($this->foldername . 'users', $data);
    }

    public function create(){
        if(session()->has('role') && session()->get('role') != config('constants.ROLE_ADMIN')){
            return redirect(config('constants.SUCCESS_LOGIN_REDIRECT'));
        }

        $data['pageTitle'] =trans('messages.add-user');
        return $this->loadAdminView($this->foldername . 'add-users', $data);
    }
}
