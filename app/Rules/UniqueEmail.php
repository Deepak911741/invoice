<?php

namespace App\Rules;

use App\Models\Login_model;
use Illuminate\Contracts\Validation\Rule;

class UniqueEmail implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $recordId;
    public function __construct($recordId = null)
    {
        if($recordId > 0){
            $this->recordId = $recordId;
        }
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(checkNotEmptyString($value)){
            $model = new Login_model();
            $where = [];
            $where['v_email'] = trim($value);
            $where['t_is_deleted'] = config('constants.INACTIVE_STATUS');
            $where['singleRecord'] = true;
            if($this->recordId > 0){
                $where['i_id != '] = $this->recordId;
            }

            $getRecordInfo = $model->getRecordDetails($where);

            if(!empty($getRecordInfo)){
                return false;
            }else{
                return true;
            }
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('messages.common-unique-value-error-message', [ 'module' =>  trans("messages.email-id") ] );
    }
}
