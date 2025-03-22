<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceModel extends My_model
{
    use HasFactory, SoftDeletes;
    protected $table = '';
    protected $primaryKey = 'i_id';
    protected $date = ['dt_deleted_at'];

    public function __construct(){
        parent::__construct();
        $this->table = config('constants.INVOICE_TABLE');
    }

    public function getRecordDetails($whereData = [], $likeData = [], $additionalData = []){
        if(isset($whereData['singleRecord'])){
            $this->singleRecord = true;
            unset($whereData['singleRecord']);
        } else {
            $this->singleRecord = false;
        }

        if(isset($whereData['countRecord'])){
            $this->countRecord = true;
            unset($whereData['countRecord']);
        } else {
            $this->countRecord = false;
        }

        $query = InvoiceModel::where('t_is_deleted', config('constants.INACTIVE_STATUS'));
        $query = $this->commonWhereData($query , $whereData ,  $likeData , $additionalData);

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
