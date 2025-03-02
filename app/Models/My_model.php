<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;

class My_model extends Model
{
    public $loggedUserId;
    public $loggedUserRole;
    public $loggedUserName;
    public $settingsInfo;
    public $currentDateTime;
    public $singleRecord;
    const CREATED_AT = 'dt_created_at';
    const UPDATED_AT = 'dt_updated_at';
    const DELETED_AT = 'dt_deleted_at';
    public function __construct(){
        parent::__construct();
        $this->loggedUserId = 999;
        $this->currentDateTime = date('Y-m-d H-i-s');
        $this->singleRecord = false;
    }

    public function defualtData()
    {
        if (session()->has('user_id') && session()->get('user_id') > 0) {
            $this->loggedUserId = session()->get('user_id');
        }
    }

    protected function insertDateTimeData()
    {
        $this->defualtData();
        $result['i_created_id'] = $this->loggedUserId;
        $result['dt_created_at'] = $this->currentDateTime;
        $result['v_ip'] = Request::ip();
        return $result;
    }

    protected function updateDateTimeData()
    {
        $this->defualtData();
        $result['i_updated_id'] = $this->loggedUserId;
        $result['dt_updated_at'] = $this->currentDateTime;
        $result['v_ip'] = Request::ip();
        return $result;
    }

    protected function deleteDateTimeData()
    {
        $this->defualtData();
        $result['i_deleted_id'] = $this->loggedUserId;
        $result['dt_deleted_at'] = $this->currentDateTime;
        $result['t_is_active'] = config('constants.INACTIVE_STATUS');
        $result['t_is_deleted'] = config('constants.ACTIVE_STATUS');
        $result['v_ip'] = Request::ip();
        return $result;
    }

    public function insertTabledata($tableName, $insertData)
    {
        $recordId = 0;
        try {
            if (!empty($insertData)) {
                $insertData = array_merge($insertData, $this->insertDateTimeData());
                $recordId = DB::table($tableName)->insertGetId($insertData);
            }
        } catch (\Exception $e) {
            echo ("Error inserting data: " . $e->getMessage());
        }
        return $recordId;
    }

    public function updateTableData($tableName, $updateData, $whereData, $updateSequence = false)
    {
        $result = false;
        
        try {
            $updateQuery = DB::table($tableName);
            if (!empty($whereData)) {
                foreach ($whereData as $key => $value) {
                    $updateQuery->where($key, $value);
                }
                
                if ($updateSequence != true) {
                    $updateData = array_merge($this->updateDateTimeData(), $updateData);
                }
                
                $result = $updateQuery->update($updateData);
            }
        } catch (\Exception $e) {
            echo "Data Is not Updated " . $e->getMessage();
        }
        return $result;
    }

    public function commonWhereData($query, $whereData = [], $likeData = [], $additionalData = [])
    {
        if (!empty($whereData)) {
            foreach ($whereData as $key => $where) {
                switch ($key) {
                    case 'offset':
                        $query->skip($where);
                        break;
                    case 'limit':
                        $query->take($where);
                        break;
                    case 'where_date':
                        if (is_array($where)) {
                            foreach ($where as $value) {
                                $param = explode(" ", $value);
                                if (isset($param) && !empty($param) && count($param) > 0) {
                                    if (count($param) > 2) {
                                        $query->whereDate($param[0], $param[1], $param[2]);
                                    } else {
                                        $query->whereDate($param[0], $param[1]);
                                    }
                                }
                            }
                        } else {
                            $param = explode(" ", $where);
                            if (isset($param) && !empty($param) && count($param) > 0) {
                                if (count($param) > 2) {
                                    $query->whereDate($param[0], $param[1], $param[2]);
                                } else {
                                    $query->whereDate($param[0], $param[1]);
                                }
                            }
                        }
                        break;
                    case 'whereHas':
                        if (is_array($where) && count($where) == 3) {
                            $wherehas = isset($where[0]) && !empty($where[0]) ? $where[0] : '';
                            $columnSearch = isset($where[1]) && !empty($where[1]) ? $where[1] : '';
                            $keySearch = isset($where[2]) && checkNotEmptyString($where[2]) ? $where[2] : '';
                            if (isset($wherehas) && !empty($wherehas) && isset($columnSearch) && !empty($columnSearch)) {
                                $query->whereHas($wherehas, function ($query) use ($keySearch, $columnSearch) {
                                    $query->where($columnSearch, $keySearch);
                                });
                            }
                        }
                        break;
                    case 'order_by':

                        break;
                    case 'group_by':

                        break;
                    case 'having':
                        $query->havingRaw($where);
                        break;
                    case 'find_in_set':

                        break;
                    case 'singleRecord':

                        break;
                    case 'custom_function':

                        break;
                    case 'null_column':
                        $query->whereNull($where);
                        break;

                    case 'null_not_column':
                        if (is_array($where)) {
                            foreach ($where as $k => $v) {
                                $query->whereNotNull($v);
                            }
                        } else {
                            $query->whereNotNull($where);
                        }
                        break;
                    default:
                        if (preg_match('/[!=><]/', $key) != false) {
                            $key = explode(" ", $key);
                            $query->where($key[0], $key[1], $where);
                        } else {
                            $query->where($key, $where);
                        }
                        break;
                }
            }
        }

        if ((!empty($whereData)) && array_key_exists('order_by', $whereData)) {
            $orderByColumn = $whereData['order_by'];
            if (!empty($orderByColumn)) {
                foreach ($orderByColumn as  $key => $value) {
                    $query->orderBy($key, (!empty($value) ? $value : 'DESC'));
                }
            }
        }

        if ((!empty($whereData)) && array_key_exists('find_in_set', $whereData)) {
            $findInSetColumn = $whereData['find_in_set'];
            $query->whereRaw("find_in_set(" . $findInSetColumn[1] . "," . $findInSetColumn[0] . ")");
        }

        if ((!empty($whereData)) && array_key_exists('custom_function', $whereData)) {
            $customerFunctionWhere = $whereData['custom_function'];
            if (!empty($customerFunctionWhere)) {
                if (is_array($customerFunctionWhere)) {
                    foreach ($customerFunctionWhere as $key => $customerFunction) {
                        $query->whereRaw($customerFunction);
                    }
                } else {
                    $query->whereRaw($customerFunctionWhere);
                }
            }
        }

        if ((!empty($whereData)) && array_key_exists('group_by', $whereData)) {
            $query->groupBy($whereData['group_by']);
        }

        if (isset($likeData) && !empty($likeData)) {
            $searchString = (isset($likeData['value']) ? $likeData['value'] : null);

            $allLikeColumns = (isset($likeData['columnName']) ? $likeData['columnName'] : []);

            $relationShipColumns = (isset($likeData['relationShip']) ? $likeData['relationShip'] : []);

            if (!empty($relationShipColumns)) {
                $query->where(function ($q1) use ($searchString, $relationShipColumns, $allLikeColumns) {
                    foreach ($relationShipColumns as $relationShipColumn) {
                        $relationShipName = (isset($relationShipColumn['relationShipName']) ? $relationShipColumn['relationShipName'] : "");
                        $relationColumns = (isset($relationShipColumn['relationShipColumns']) ? $relationShipColumn['relationShipColumns'] : []);
                        if ((!empty($relationColumns)) && (!empty($relationShipName))) {
                            $q1->whereHas($relationShipName, function ($query) use ($searchString, $relationColumns) {
                                $allLikeColumns = $relationColumns;
                                $query->where(function ($q) use ($allLikeColumns, $searchString) {
                                    foreach ($allLikeColumns as $key => $allLikeColumn) {
                                        $q->orWhere($allLikeColumn, 'like', "%" . $searchString . "%");
                                    }
                                });
                            });
                        }
                    }

                    if ((checkNotEmptyString($searchString)) && (!empty($allLikeColumns))) {
                        $q1->orWhere(function ($q) use ($searchString, $allLikeColumns) {
                            foreach ($allLikeColumns as $key => $allLikeColumn) {
                                $q->orWhere($allLikeColumn, 'like', "%" . $searchString . "%");
                            }
                        });
                    }
                });
            } else {
                if ((checkNotEmptyString($searchString)) && (!empty($allLikeColumns))) {
                    $query->where(function ($q) use ($allLikeColumns, $searchString) {
                        foreach ($allLikeColumns as $key => $allLikeColumn) {
                            $q->orWhere($allLikeColumn, 'like', "%" . $searchString . "%");
                        }
                    });
                }
            }
        }

        return $query;
    }
}
