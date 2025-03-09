<?php

namespace App\Http\Controllers;

use App\Helpers\Message;
use App\Models\Login_history_model;
use App\Models\Login_model;
use Illuminate\Http\Request;

class Login_history extends MY_controller
{
    public function __construct(){
        parent::__construct();
        $this->crudModel = new Login_history_model();
		$this->foldername = config('constants.ADMIN_FOLDER') . 'login-history/';
		$this->tableName = config('constants.LOGIN_HISTORY_TABLE');
		$this->perPageRecord = config('constants.TABLE_LISTING_PER_PAGE');
    }

    public function index(){
		$data['pageTitle'] = trans('messages.login-history');
		
		$where = [];
		
		$data['selectedUserId'] = session()->get('user_id');
		
		$paginationData = [];
		
		$pageNo = config('constants.DEFAULT_PAGE_INDEX');
		
		if ($pageNo == config('constants.DEFAULT_PAGE_INDEX') ){
			
			$where['countRecord'] = true;
				
			$totalRecords = $this->crudModel->getRecordDetails( $where );
				
			unset($where['countRecord']);
				
			$lastpage = ceil($totalRecords/$this->perPageRecord);
				
			$paginationData['current_page'] = config('constants.DEFAULT_PAGE_INDEX');
				
			$paginationData['per_page'] = $this->perPageRecord;
				
			$paginationData['last_page'] = $lastpage;
			
		}
		
		$where['limit'] = $this->perPageRecord;
		
		$data['pageNo'] = $pageNo;
			
		$data['perPageRecord'] = $this->perPageRecord;
		
		$data['userDetails'] = [];
		if( in_array( session()->get('role') ,  [ config('constants.ROLE_ADMIN') ] ) ){
			$data['userDetails'] = Login_model::where('t_is_deleted',config('constants.INACTIVE_STATUS'))->whereNotIn('v_email',config('constants.DEFAULT_PORTFOLIO_ADMIN_EMAIL'))->orderBy('v_name','asc')->get();
		}
		
		$data['recordDetails'] = $this->crudModel->getRecordDetails ( $where );
		
		$data['pagination'] = $paginationData;
		
		if(isset($totalRecords)){
			$data['totalRecordCount'] = $totalRecords;
		}
		
		return $this->loadAdminView($this->foldername . 'login-history', $data);
	}

    public function filter(Request $request) {
		if ($request->ajax ()) {
			$whereData = $likeData  = $additionalData =  [];
				
			$pageNo = (! empty ( $request->input ( 'page' ) )) ? ( int ) $request->input ( 'page' ) : 1;
			
			$paginationData = [];
			
			if (!empty($request->post('search_user'))) {
				$whereData['i_login_id'] = (int)Message::decode($request->post('search_user'));
			}
			if (!empty($request->post('search_start_date'))) {
				$whereData['where_date'][] = 'dt_created_at >= ' . dbDate($request->post('search_start_date'));
			}
			if (!empty($request->post('search_end_date'))) {
				$whereData['where_date'][] = 'dt_created_at <= ' . dbDate($request->post('search_end_date'));
			}
			
			$paginationData = [];
			
			if ($pageNo == config('constants.DEFAULT_PAGE_INDEX') ){
					
				$whereData['countRecord'] = true;
					
				$totalRecords = $this->crudModel->getRecordDetails( $whereData , $likeData );
					
				unset($whereData['countRecord']);			
				
				$lastpage = ceil($totalRecords/$this->perPageRecord);
			
				$paginationData['current_page'] = config('constants.DEFAULT_PAGE_INDEX');
			
				$paginationData['per_page'] = $this->perPageRecord;
			
				$paginationData['last_page'] = $lastpage;
					
			}
			
			$whereData['limit'] = $this->perPageRecord;
			$whereData['offset'] = (($pageNo > config('constants.DEFAULT_PAGE_INDEX')) ? ($pageNo - 1) * $this->perPageRecord : 0);
				
			$recordDetails = $this->crudModel->getRecordDetails ( $whereData, $likeData );
				
			$data = [];
			
			$data['pageNo'] = $pageNo;
			
			$data['perPageRecord'] = $this->perPageRecord;
			
			$data['recordDetails'] = $recordDetails;
			
			$data['pagination'] = $paginationData;
			
			if(isset($totalRecords)){
				$data['totalRecordCount'] = $totalRecords;
			}
			
			$html = view ( config('constants.AJAX_VIEW_FOLDER') . 'login-history/login-history-list' )->with ( $data )->render();
			
			return response ( $html );
		}
	}
}
