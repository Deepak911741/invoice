<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $this->defaultPage = config('constants.DEFAULT_PAGE_INDEX');
    }
}
