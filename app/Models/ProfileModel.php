<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfileModel extends My_model
{
    use HasFactory, SoftDeletes;
    protected $table = '';
    protected $primaryKey = 'i_id';
    protected $date = ['dt_deleted_at'];

    public function __construct(){
        parent::__construct();
        $this->table = config('constants.PROFILE_TABLE');
    }

    public function service(){
        return $this->hasMany(serviceModel::class, 'i_profile_id', 'i_id');
    }

    public function event(){
        return $this->hasMany(eventModel::class, 'i_profile_id', 'i_id');
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

        $query = ProfileModel::where('t_is_deleted', config('constants.INACTIVE_STATUS'));
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
