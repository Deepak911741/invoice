<?php

namespace App\Http\Controllers;

use App\Helpers\Message;
use App\Models\My_model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MY_controller extends Guest
{
    public $permissions;
    public $loginUserRole;
    public $loginUserName;
    public $loginUserId;
    public $defaultPage;
    public $redirectUrl;
    public $tableName;
    public $crudModel;
    public $moduleName;
    public function __construct(){
        parent::__construct();
        $this->defaultPage = config('constants.DEFAULT_PAGE_INDEX');
    }


    public function updateMasterStatus( $request , $tableName , $moduleName ){
    	$recordId = (!empty($request->record_id) ? (int)Message::decode($request->record_id) : 0);
    	
    	$currentStatus = trim($request->current_status);
    	
    	$updateData = [];
    	
    	switch ($currentStatus){
    		case  ( config('constants.ENABLE_STATUS') ):
    			$updateStatus = trans('messages.disable');
    			$updateData['t_is_active']  = config('constants.INACTIVE_STATUS');
    			break;
    		case  ( config('constants.DISABLE_STATUS') ):
    			$updateStatus = trans('messages.enable');
    			$updateData['t_is_active']  = config('constants.ACTIVE_STATUS');
    			break;
    		case  ( config('constants.ACTIVE_STATUS_TEXT') ):
    			$updateStatus = trans('messages.inactive');
    			$updateData['t_is_active']  = config('constants.INACTIVE_STATUS');
    			break;
    		case  ( config('constants.INACTIVE_STATUS_TEXT') ):
    			$updateStatus = trans('messages.active');
    			$updateData['t_is_active']  = config('constants.ACTIVE_STATUS');
    			break;
    						
    	}
    	
    	$updatedmodule =  $moduleName;
    	
    	if(!empty($updateData)){
    		$result = false;
    		DB::beginTransaction();
    	
    		try {
    			$this->my_model->updateTableData(  $tableName , $updateData , [ 'i_id' => $recordId ]);
    			
    			$result = true;
    		} catch (\Exception $e) {
    			$result = false;
    			DB::rollBack();
    			Log::error($e->getMessage());
    		}
    		
    		if( $result != false ){
    			DB::commit();
    			$message = trans ( 'messages.success-status-update', [ 'module' => $updatedmodule ] );
    			$this->ajaxResponse( config('constants.SUCCESS_AJAX_CALL') , $message , [ 'update_status'  =>  ( $updateStatus ) ] );
    		}
    	}
    	
    	DB::rollback();
    	$message = trans ( 'messages.error-status-update', [ 'module' => $updatedmodule ] );
    	$this->ajaxResponse( config('constants.ERROR_AJAX_CALL') , $message );
    }
    
    public function removeRecord($tableName , $recordId , $messageModuleName ){
    	if( $recordId > 0 && (!empty($tableName)) ){
    		$result = false;
    		DB::beginTransaction();
    		
    		try {
    			$this->my_model->deleteTableData(  $tableName ,  [] , [ 'i_id' => $recordId ] );
    			
    			$result = true;
    		} catch (\Exception $e) {
    			$result = false;
    			DB::rollBack();
    			Log::error($e->getMessage());
    		}
    		
    		if( $result != false ){
    			DB::commit();
    			Message::setFlashMessage ( 'success', trans ( 'messages.success-delete', ['module' => enumText($messageModuleName)] ) );
    		} else {
				DB::rollback();
    			Message::setFlashMessage ( 'danger', trans ( 'messages.error-delete', ['module' => enumText($messageModuleName)] ) );
    		}
    		
    		return redirect()->back();
    	}
    	
    	DB::rollback();
    	Message::setFlashMessage ( 'danger', trans ( 'messages.error-delete', [ 'module' => enumText($messageModuleName) ] ) );
    	return redirect()->back();
    }
    
    public function logLastQuery(){
    	Log::info(My_model::last_query());
    }
}
