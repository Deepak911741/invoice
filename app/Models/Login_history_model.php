<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Login_history_model extends My_model
{
    use HasFactory,SoftDeletes;
    protected $table = '';
    protected $primaryKey = 'i_id';
    protected $dates = ['dt_deleted_at'];
    protected $softDelete = true;
    
    public function __construct(){
    	parent::__construct();
    	$this->table = config('constants.LOGIN_HISTORY_TABLE');
    }
	
	public function loginInfo(){
		return $this->belongsTo(Login_model::class , 'i_login_id');
	}

	public function getRecordDetails( $where = [] , $likeData = [] , $additionalData = [] ){
		if (isset($where['singleRecord'])) {
			$this->singleRecord = true;
			unset($where['singleRecord']);
		} else {
			$this->singleRecord = false;
		}
		
		if (isset($where['countRecord'])) {
			$this->countRecord = true;
			unset($where['countRecord']);
		} else {
			$this->countRecord = false;
		}
		
		$query = Login_history_model::where('t_is_deleted', config('constants.INACTIVE_STATUS'));
		
		$defaultWhere = [];
		$defaultWhere['order_by'] = [ 'i_id' => 'desc' ];
		$defaultWhere['whereHas'] = [ 'loginInfo', 't_is_deleted', config('constants.INACTIVE_STATUS') ];
        
		if (session()->has('role') && !empty(session()->get('role')) && session()->get('role') != config('constants.ROLE_ADMIN')){
			$defaultWhere['i_login_id'] = session()->get('user_id');
		}

		$whereData = (!empty($where) ? array_merge($defaultWhere, $where) : $defaultWhere);
		
		$query = $this->commonWhereData($query , $whereData , $likeData , $additionalData);
			
		if($this->countRecord != false) {
    		$data = $query->count();
    	} elseif($this->singleRecord != false) {
    		$data = $query->first();
    	} else {
    		$data = $query->get();
    	}
		
		return $data;
	}
}
