<?php

namespace App\Http\Controllers;

use App\Helpers\Message;
use App\Models\Login_model;
use App\Rules\UniqueEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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

    public function add(Request $request){
        if( session()->has('role')  && ( session()->get('role') != config('constants.ROLE_ADMIN') ) ){
			return redirect( config ( 'constants.DASHBOARD_URL') );
		}

        if(!empty($request->post())){
            $recordId = (!empty($request->post('record_id')) ? Message::decode($request->post('record_id')) : 0);
            $password = (checkNotEmptyString($request->input('new_password')) ? trim($request->input('new_password')) : '');

            $formValidation = [];
			$formValidation['name'] = 'required';
			$formValidation['mobile'] = [ 'required'] ;
			$formValidation['email'] = [ 'required', new UniqueEmail($recordId)];

            if (empty($recordId) || checkNotEmptyString($password)){
				$formValidation['confirm_password'] = ['required', 'same:new_password'];
			}
			
			// if ($recordId > 0){
			// 	$formValidation['new_password'] = [ new CheckLastPassword($request) ];
			// } else {
			// 	$formValidation['new_password'] = [ 'required', new CheckLastPassword($request) ];
			// }
            $validator = Validator::make ( $request->all (), $formValidation , [
                'name.required' => trans("messages.required-enter-field-validation" , [ "fieldName" => trans("messages.name") ]),
                'new_password.required' => trans("messages.required-enter-field-validation" , [ "fieldName" => trans("messages.password") ]),
                'confirm_password.required' => trans("messages.required-enter-field-validation" , [ "fieldName" => trans("messages.confirm-password") ]),
                'confirm_password.same' => trans('messages.password-confirm-password-not-match'),
                'email.required' => trans("messages.required-enter-field-validation" , [ "fieldName" => trans("messages.email-id") ]),
                'mobile.required' => trans("messages.required-enter-field-validation" , [ "fieldName" => trans("messages.mobile-no") ]),
            ]);

            if ($validator->fails()){
				return redirect()->back()->withErrors($validator)->withInput();
			}

            $recordData = [];
			$recordData['v_name'] = (checkNotEmptyString($request->input('name')) ? trim($request->input('name')) : '');
			$recordData['v_email'] = (checkNotEmptyString($request->input('email')) ? trim($request->input('email')) : null);
			$recordData['v_mobile'] = (checkNotEmptyString($request->input('mobile')) ? trim($request->input('mobile')) : null);
			
			if(checkNotEmptyString($password)){
				$recordData['v_password'] = password_hash($password, PASSWORD_DEFAULT);
			}
			
			$successMessage = trans ('messages.success-create', [ 'module' => $this->moduleName ] );
			$errorMessage = trans ('messages.error-create', [ 'module' => $this->moduleName ] );
			
			$result = false;
			
			DB::beginTransaction();
            try{
				if( $recordId > 0 ){
					$successMessage = trans ( 'messages.success-update', [ 'module' => $this->moduleName ] );
					$errorMessage = trans ( 'messages.error-update', [ 'module' => $this->moduleName ] );
					$this->crudModel->updateTableData( config('constants.LOGIN_TABLE') , $recordData , [ 'i_id' =>  $recordId ] );
				} else {
                    $recordData['v_role'] = config('constants.ROLE_USER');
					$this->crudModel->insertTableData( config('constants.LOGIN_TABLE') , $recordData );
				}
					
				$result = true;
			}catch(\Exception $e){
				$result = false;
				Log::error($e->getMessage());
				DB::rollBack();
			}
            if( $result != false ){
				if ($recordId > 0 && session()->has('user_id') && !empty(session()->has('user_id')) && ($recordId == session()->get('user_id'))){
					session()->put('name', $recordData['v_name']);
				}
				DB::commit();
				Message::setFlashMessage('success', $successMessage);
			} else {
				DB::rollBack();
				Message::setFlashMessage('danger', $errorMessage);
			}
			
			return redirect($this->redirectUrl);
        }
    }

    public function checkUniqueEmail(Request $request){
        $recordId = (!empty($request->record_id) ? (int)Message::decode($request->record_id) : 0);

        $validator = Validator::make ( $request->all (), [
            'email' => [ 'required' ,new UniqueEmail($recordId) ]  ,
        ], [
            'email.required' => trans('messages.required-enter-field-validation', ['fieldName' => trans('messages.email')]),
        ] );

        if ($validator->fails ()) {
            $this->ajaxResponse(config('constants.ERROR_AJAX_CALL'), $validator->errors()->first());
        }
        $this->ajaxResponse(config('constants.SUCCESS_AJAX_CALL'), trans('messages.success'));

    }
}
