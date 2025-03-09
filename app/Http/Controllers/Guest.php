<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\My_model;
use App\Models\Settings_model;
use Illuminate\Support\Facades\Session;

class Guest extends Controller
{
    public $foldername;
	public $redirectPage;
	public $sideTitle;
	public $perpageRecord;
	public $adminFolderName;
	public $my_model;
	public $settingModel;
	public $settingsInfo;
	public $siteTitle;
	public $showConfirmBox;
    public function __construct(){
		$this->my_model = new My_model();
		$this->adminFolderName = config('constants.ADMIN_FOLDER');
		$this->perpageRecord = config('constants.PER_PAGE');
		$this->showConfirmBox = config('constants.SHOW_CONFIRM_BOX');
		$this->settingModel = new Settings_model();
		$this->settingsInfo = $this->settingModel->getRecordDetails();
		$this->siteTitle = (isset($this->settingsInfo->v_site_title) ? (checkNotEmptyString($this->settingsInfo->v_site_title) ? $this->settingsInfo->v_site_title : '') :  '');
	}

    public function loadAdminView($viewName, $pageData = [])
	{
		$pageInfo = [];
		$pageInfo['settingsInfo'] = $this->settingsInfo;

		if (!empty($pageData)) {
			$pageInfo = array_merge($pageInfo, $pageData);
		}
		return view($viewName)->with($pageInfo);
	}

	public function guestView($viewName, $pageData)
	{
		return $this->loadAdminView($viewName, $pageData);
	}

	public function convertFilterRequest($request, $modulePerPage = 10)
	{
		$draw = (!empty($request->post('draw')) ? ($request->post('draw')) : config('constants.DEFAULT_PAGE_INDEX'));

		$offset = (!empty($request->post('start')) ? ($request->post('start')) : 0);
		$limit = (!empty($request->post('length')) ? ($request->post('length')) : $this->perpageRecord);

		$columnName = $columnIndex = $columnSortOrder = '';

		$columnIndex = (!empty($request->post('order')[0]['column']) ? ($request->post('order')[0]['column']) : '');
		$columnName = (!empty($request->post('columns')[$columnIndex]['data']) ? ($request->post('columns')[$columnIndex]['data']) : '');
		$columnSortOrder = (!empty($request->post('order')[0]['dir']) ? ($request->post('order')[0]['dir']) : '');

		$searchValue = (!empty($request->post('search')['value']) ? ($request->post('search')['value']) : '');

		$fieldData = [];
		$fieldData['draw'] = $draw;
		$fieldData['limit'] = $limit;
		$fieldData['offset'] = $offset;
		$fieldData['tableSearch'] = $searchValue;
		$fieldData['columnSortOrder'] = $columnSortOrder;
		$fieldData['sortColumnName'] = $columnName;

		return $fieldData;
	}

	private function getAllowedMineTypes($allowedExtensions = ['jpg', 'jpeg', 'png'])
	{
		$allowedMimeTypes = [];
		if (!empty($allowedExtensions)) {
			foreach ($allowedExtensions as $allowedExtension) {
				switch (strtolower($allowedExtension)) {
					case 'jpg':
						$allowedMimeTypes[] = "image/jpeg";
						break;
					case 'jpeg':
						$allowedMimeTypes[] = "image/jpeg";
						break;
					case 'png':
						$allowedMimeTypes[] = "image/png";
						break;
					case 'pdf':
						$allowedMimeTypes[] = "application/pdf";
						break;
				}
			}
		}
		return $allowedMimeTypes;
	}

	public function uploadFile( $request , $folderName , $fieldName ,  $allowedExtensions = [ 'jpg' , 'jpeg' , 'png' ] , $required = false  , $ceatethumb = true ){
    
    	if (! file_exists(config('constants.FILE_STORAGE_PATH') . config('constants.UPLOAD_FOLDER'))) {
    		mkdir(config('constants.FILE_STORAGE_PATH') . config('constants.UPLOAD_FOLDER'), 0777, true);
    	}
    	
    	if (! file_exists(config('constants.FILE_STORAGE_PATH') . config('constants.UPLOAD_FOLDER') . $folderName)) {
    		mkdir(config('constants.FILE_STORAGE_PATH') . config('constants.UPLOAD_FOLDER') . $folderName, 0777, true);
    	}
    	
    	$response = [];
    	$response['status'] = false;
    	$response['message'] = trans('messages.required-upload-field-validation' , [ 'fieldName' => trans('messages.file') ]);
    	if($request->hasFile($fieldName)) {
    
    		$allowedMimeTypes = $this->getAllowedMineTypes($allowedExtensions);
    		
    		$uploadedFileMimeType = strtolower($request->$fieldName->getClientMimeType());
    
    		if(!in_array($uploadedFileMimeType,$allowedMimeTypes)){
    			$errorMessage = trans('messages.error-only-specific-are-allowed' , [ 'fileType' => implode(", " , $allowedExtensions ) ] );
    			$response['message'] = $errorMessage;
    			return $response;
    		}
    
    		$uploadedFileExtension = $request->$fieldName->getClientOriginalExtension();
    
    		if(!in_array(strtolower($uploadedFileExtension),$allowedExtensions)){
    			$errorMessage = trans('messages.error-only-specific-are-allowed' , [ 'fileType' => implode(", " , $allowedExtensions ) ] );
    			$response['message'] = $errorMessage;
    			return $response;
    		}
    
    		// Get filename with extension
    		$filenameWithExt = $request->file($fieldName)->getClientOriginalName();
    
    		// Get just filename
    		$filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
    		$filename = createSlug( strtolower($filename) );
    		// Get just ext
    		$extension = $uploadedFileExtension;
    
    		//Filename to store
    		$fileNameToStore = $filename.'_'.uniqid().'.'.$extension;
    
    
    		$uploadedImagePath = $request->file($fieldName)->storeAs( config('constants.UPLOAD_FOLDER') .  $folderName , $fileNameToStore);
    
    		$response['status'] = true;
    		$response['filePath'] = $folderName .  $fileNameToStore;
    
    		return $response;
    		 
    	}
    	
    	if ($required != false) {
    	
    		$response['status'] = false;
    		$response['image'] = trans('messages.required-upload-field-validation' , [ 'fieldName' => trans('messages.file') ]);
    	}
    
    	return $response;
    }

	public function ajaxResponse($status , $messages , $data = [] ){
    	$result = [];
    	$result['status_code'] = $status;
    	$result['message'] = $messages;
    	if(!empty($data)){
    		$result['data'] = (!empty($data) ? $data : null );
    	}
    	echo json_encode($result);die;
    }

	protected function commonLoginSessionEntry($checkLogin, $password = null)
	{
		Session::put('user_id', $checkLogin->i_id);
		Session::put('name', $checkLogin->v_name);
		Session::put('role', $checkLogin->v_role);
		Session::put('email', $checkLogin->v_email);
		Session::put('isLoggedIn', true);
		Session::put('site_title', $this->siteTitle);

		$_SESSION['login_application_user'] = true;
		if (!empty($checkLogin)) {
			$loginHistoryId = [];
			$loginHistoryId['i_login_id'] = $checkLogin->i_id;
			$loginHistoryId['i_session_id'] = session()->get('_token');

			$insertLogin = $this->my_model->insertTableData(config('constants.LOGIN_HISTORY_TABLE'), $loginHistoryId);
		}
	}
}
