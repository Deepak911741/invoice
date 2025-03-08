<?php

namespace App\Http\Controllers;

use App\Helpers\Message;
use App\Models\Login_model;
use App\Rules\UniqueEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

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
        $data['statusDetails'] = getStatusDetails();
        return $this->loadAdminView($this->foldername . 'users', $data);
    }

    public function create(){
        if(session()->has('role') && session()->get('role') != config('constants.ROLE_ADMIN')){
            return redirect(config('constants.SUCCESS_LOGIN_REDIRECT'));
        }

        $data['pageTitle'] =trans('messages.add-user');
        return $this->loadAdminView($this->foldername . 'add-users', $data);
    }

    public function edit($recordId = null){
        if( session()->has('role')  && ( session()->get('role') != config('constants.ROLE_ADMIN') ) ){
			return redirect( config ( 'constants.DASHBOARD_URL') );
		}

        $errorFound = true;
        if(!empty($recordId)){
			$recordId = (int)Message::decode($recordId);
			
			if( $recordId > 0 ){
				$whereData = [];
				$whereData['singleRecord'] = true;
				$whereData['i_id'] = $recordId;
				$recordInfo = $this->crudModel->getRecordDetails ($whereData);
				
				if(!empty($recordInfo)){
					$errorFound = false;
					
					$data ['recordInfo'] = $recordInfo;
					$data['pageTitle'] = trans ( 'messages.update-user');
					$data['showConfirmBox'] = $this->showConfirmBox;
					
					return $this->loadAdminView($this->foldername . 'add-users', $data);
				}
			}
		}
        if( $errorFound != false ){
			return redirect(config('constants.PAGE_NOT_FOUND_URL'));
		}
    }

    public function add(Request $request){
        if( session()->has('role')  && ( session()->get('role') != config('constants.ROLE_ADMIN') ) ){
			return redirect( config ( 'constants.DASHBOARD_URL') );
		}

        if(!empty($request->post())){
            $recordId = (!empty($request->post('record_id')) ? (int)Message::decode($request->post('record_id')) : 0);
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


    public function filter(Request $request){
        $whereData = $likeData = $additionalData = [];

        $fieldData = $this->convertFilterRequest($request);
        $searchValue = $fieldData['tableSearch'];
        $columnName = $fieldData['sortColumnName'];
        $columnSortOrder = $fieldData['columnSortOrder'];
        $offset = $fieldData['offset'];
        $draw = $fieldData['draw'];
        $limit = $fieldData['limit'];
        
        $filterData = $this->commonFilterData($request);
        $whereData = (isset($filterData['where']) ? $filterData['where'] : []);
        $likeData = (isset($filterData['like']) ? $filterData['like'] : []);

        if(!empty($columnName)){
            switch ($columnName) {
                case 'name':
                    $columnName = 'v_name';
                    break;
                case 'email':
                    $columnName = 'v_email';
                    break;
                case 'mobile':
                    $columnName = 'v_mobile';
                    break;
            }
            $whereData['order_by'] = [$columnName => (!empty($columnSortOrder) ? $columnSortOrder : 'DESC')];
        }else{
            $whereData['order_by'] = ['i_id' => 'desc'];
        }

        $whereData['countRecord'] = true;
        $totalRecords = $this->crudModel->getRecordDetails($whereData, $likeData);
        if(isset($whereData['countRecord'])){
            unset($whereData['countRecord']);
        }

        $whereData['offset'] = $offset;
        $whereData['limit'] = $limit;

        $recordDetails = $this->crudModel->getRecordDetails($whereData, $likeData);

        $finalData = [];
        if(!empty($recordDetails)){
            $index = $offset;
            foreach ($recordDetails as $key => $recordDetail) {
                $encodeRecordId = Message::encode($recordDetail->i_id);

                $rowData = [];
                $rowData['sr_no'] = ++$index;
                $rowData['name'] = (checkNotEmptyString($recordDetail->v_name) ? $recordDetail->v_name : '' );
                $rowData['email'] = (checkNotEmptyString($recordDetail->v_email) ? ( $recordDetail->v_email ) : '');
                $rowData['mobile'] = (checkNotEmptyString($recordDetail->v_mobile) ? $recordDetail->v_mobile : '' );

                $checked = '';
                if($recordDetail->t_is_active == config('constants.ACTIVE_STATUS')){
                    $checked = 'checked="checked"';
                }
                
                $disabled = '';
                if( $recordDetail->v_role == config('constants.ROLE_ADMIN')  ){
                    $disabled = 'disabled';
                }

                $rowData['status'] = '<div class="form-check form-switch twt-custom-switch status-class">';
                $rowData['status'] .= '<input type="checkbox" '.$disabled.' class="form-check-input" '.$checked.' data-record-id="'.$encodeRecordId.'" id="disable_'.$key.'" data-module-name="'.config('constants.USER_MASTER').'" onclick="updateRecordStatus(this)">';
                $rowData['status'] .= '<label class="form-check-label record-status" for="disable_'.$key.'">'.(!empty($recordDetail->t_is_active == config('constants.ACTIVE_STATUS')) ? trans("messages.enable") : trans("messages.disable") ) .'</label>';
                $rowData['status'] .= '</div>';
                
                $rowData['action'] = '<div class="actions-col-div">';
                $rowData['action'] .= '<a href="'. route('user.edit', $encodeRecordId ).'" title="'.trans("messages.edit").'" class="btn edit-btn action-btn btn-sm edit-btn"><i class="fa-solid fa-pencil"></i></a>';
                if( $recordDetail->v_role != config('constants.ROLE_ADMIN')  ){
                    $rowData['action'] .= '<button title="'.trans("messages.delete").'" data-record-id="'.$encodeRecordId.'" data-module-name="'.config('constants.USER_MASTER').'" data-msg-module-name="'.$this->moduleName.'" onclick="deleteRecord(this);" type="button" class="btn action-btn btn-sm delete-btn"><i class="fa-solid fa-trash"></i></button>';
                }
                $rowData['action'] .= '</div>';
                
                $finalData[] = $rowData;
            }
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => count($finalData),
                "iTotalDisplayRecords" => $totalRecords,
                "aaData" => $finalData
            );
            
            return Response::json($response);
        }

    }

    public function checkUniqueEmail(Request $request){
        $recordId = (!empty($request->record_id) ? (int)Message::decode($request->record_id) : 0);

        $validator = Validator::make ( $request->all (), [
            'email' => [ 'required', new UniqueEmail($recordId) ]  ,
        ], [
            'email.required' => trans('messages.required-enter-field-validation', ['fieldName' => trans('messages.email')]),
        ] );

        if ($validator->fails ()) {
            $this->ajaxResponse(config('constants.ERROR_AJAX_CALL'), $validator->errors()->first());
        }
        $this->ajaxResponse(config('constants.SUCCESS_AJAX_CALL'), trans('messages.success'));

    }


    protected function commonFilterData($request = null){
        $whereData = $likeData = $additionalData = [];
		
		if( checkNotEmptyString($request->post('search_by')) ){
			$searchValue = trim($request->input ( 'search_by' ));
			$likeData = [ 'value' => $searchValue, 'columnName' => ['v_name' , 'v_mobile', 'v_email'] ];
		}
			
		if( !empty($request->post('search_status')) ){
			$whereData['t_is_active'] = trim($request->post('search_status')) == config('constants.ENABLE_STATUS') ? config('constants.ACTIVE_STATUS') : config('constants.INACTIVE_STATUS');
		}
	
		$response = [];
		$response['where'] = $whereData;
		$response['like'] = $likeData;
		$response['additional'] = $additionalData;
	
		return $response;
    }
}
