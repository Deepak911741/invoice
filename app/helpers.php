<?php

use App\Models\My_model;
use App\Models\Setting_model;
use Illuminate\Support\Facades\Log;

if(!function_exists('monthStartDate')){
    function monthStartDate($date = null){
        $result = null;
        $inputDate = (!empty($date) ? $date : date('Y-m-d'));
        if(!empty($inputDate)){
            $result = date('Y-m-01', strtotime($inputDate));
        }
        return $result;
    }
}

if(!function_exists('monthEndDate')){
    function monthEndDate(){
        $result = null;
        $inputDate = (!empty($date) ? $date : date('Y-m-d'));
        if (!empty($inputDate)) {
            $result = date('Y-m-t', strtotime($inputDate));
        }
        return $result;
    }
}

if (! function_exists('clientDateTime')) {

	function clientDateTime($value, $dbFormat = true)
	{
		$result = date('Y-m-d H:i:s', strtotime($value));
		if ($dbFormat != false) {
			$result = date(config('constants.DISPLAY_DATE_TIME_FORMAT'), strtotime($value));
		}

		return $result;
	}
}

if (! function_exists('clientTime')) {
	function clientTime($value)
	{
		$result = "";
		if(!empty($value)){
			$result = date('h:i A', strtotime($value));
		}

		return $result;
	}
}

if (! function_exists('dbDate')) {
	function dbDate($value, $dbFormat = true)
	{
		$result = null;
		if(!empty($value)){
			$value = str_replace("/", "-", $value);
			$result = date('Y-m-d', strtotime($value));
		}
		return $result;
	}
}

if (! function_exists('decimalAmount')) {
	function  decimalAmount($value){

		$result = 0;
		if(!empty($value)){
			$value = floatval($value);
			$fmt = new \NumberFormatter($locale = 'en_US', NumberFormatter::DECIMAL);
			$result = $fmt->format($value);
		} else {
			$result = 0.00;
		}

		return $result;
	}
}

if (! function_exists('enumText')) {
	function enumText($value) {
		$result = '';
		if(!empty($value)){
			$result = ucwords(str_replace("_",  " ", $value));
		}
		return $result;
	}
}


if( !function_exists('uploadedFileExists') ){
	function uploadedFileExists($fileName){
		if( !empty($fileName) ){
			return file_exists ( config('constants.FILE_STORAGE_PATH') . config('constants.UPLOAD_FOLDER') . $fileName );
		}
		return false;
	}
}

if (!function_exists('getUploadedAssetUrl')) {
	function getUploadedAssetUrl($asset = null)
	{
		$data = '';
		if (!empty($asset) && uploadedFileExists($asset)) {
			$data = config('constants.FILE_STORAGE_PATH_URL') . config('constants.UPLOAD_FOLDER') . $asset;
		}
		return $data;
	}
}

if(!function_exists('getStatusDetails')){
    function getStatusDetails(){
        $data = [];
        $data[config('constants.ENABLE_STATUS')] = trans('messages.enable');
        $data[config('constants.DISABLE_STATUS')] = trans('messages.disable');

        return $data;
    }
}

if (! function_exists('clientDate')) {

    function clientDate($value, $dbFormat = true)
    {
        $result = date('Y-m-d', strtotime($value));
        if ($dbFormat != false) {
            $result = date(config('constants.DISPLAY_DATE_FORMAT'), strtotime($value));
        }
        
        return $result;
    }
}

if (! function_exists('dbDate')) {
	function dbDate($value, $dbFormat = true)
	{
		$result = null;
		if(!empty($value)){
			$value = str_replace("/", "-", $value);
			$result = date('Y-m-d', strtotime($value));
		}
		return $result;
	}
}

if(!function_exists('dbYear')){
    function dbYear($value, $dbFormat = true){
        $result = null;
        if(!empty($value)){
            $value = str_replace('/', '-', $value);
            $result = date('Y', strtotime($value));
        }
        return $result;
    }
}


if(!function_exists('dbMonthDate')){
    function dbMonthDate($value, $dbFormat = true){
        $result = null;
        if(!empty($value)){
            $value = str_replace('/', '-', $value);
            $result = date('M Y', strtotime($value));
        }
        return $result;
    }
}

if (! function_exists('clientDate')) {

    function clientDate($value, $dbFormat = true)
    {
        $result = date('Y-m-d', strtotime($value));
        if ($dbFormat != false) {
            $result = date(config('constants.DISPLAY_DATE_FORMAT'), strtotime($value));
        }
        
        return $result;
    }
}


if (!function_exists('calculateMonths')) {
    function calculateMonths($startDate, $endDate = null) {
        $endDate = $endDate ?? date('Y-m-d');
        
        $start = new DateTime($startDate);
        $end = new DateTime($endDate);
        
        $interval = $start->diff($end);
        return ($interval->y * 12) + $interval->m;
    }    
}
if (! function_exists('createSlug')) {

	function createSlug($title) {
		$flip = $separator = '-';
		$title = preg_replace('!['.preg_quote($flip).']+!u', $separator, $title);
		$title = str_replace('@', $separator.'at'.$separator, $title);
		$title = preg_replace('![^'.preg_quote($separator).'\pL\pN\s]+!u', '', strtolower($title));
		$title = preg_replace('!['.preg_quote($separator).'\s]+!u', $separator, $title);
		return $title;
	}
}

if (!function_exists('getUploadedAssetUrl')) {
	function getUploadedAssetUrl($asset = null)
	{
		$data = '';
		if (!empty($asset) && uploadedFileExists($asset)) {
			$data = config('constants.FILE_STORAGE_PATH_URL') . config('constants.UPLOAD_FOLDER') . $asset;
		}
		return $data;
	}
}

if(!function_exists('getDefaultMigrationColumns')){
    function getDefaultMigrationColumns($table, $callback){
        if(!empty($table)){
            $table->increments('i_id');
            $callback($table);
            $table->tinyInteger('t_is_active')->default(config('constants.ACTIVE_STATUS'));
            $table->tinyInteger('t_is_deleted')->default(config('constants.INACTIVE_STATUS'));
            $table->integer('i_created_id');
			$table->dateTime('dt_created_at');
            $table->integer('i_updated_id')->nullable();
			$table->dateTime('dt_updated_at')->nullable();
			$table->integer('i_deleted_id')->nullable();
			$table->dateTime('dt_deleted_at')->nullable();
			$table->ipAddress('v_ip')->nullable();
        }
    }
}

if(!function_exists('checkNotEmptyString')){
    function checkNotEmptyString($string){
        return strlen(trim($string) > 0 ? true : false);
    }
}


if (! function_exists('sendMailSMTP')) {
	function sendMailSMTP($data){
		// if (config('constants.STOP_SYSTEM_SENDING_EMAIL') != false){
		// 	$result = [];
		// 	$result['status'] = true;
		// 	return $result;
		// }

        Log::info($data);
		
		$mailResult = false;
		
		$result['status'] = false;
		$where = [];
		$settingModel = new Setting_model();
		$settingInfo = $settingModel->getRecordDetails($where);
		
		try {
			$transport = new Swift_SmtpTransport( ( ( isset($settingInfo->v_send_email_host) && (!empty($settingInfo->v_send_email_host)) ) ?  $settingInfo->v_send_email_host : '' )  , ( ( isset($settingInfo->i_send_email_port) && (!empty($settingInfo->i_send_email_port)) ) ?  $settingInfo->i_send_email_port :  '' ) , ( ( isset($settingInfo->v_send_email_encryption) && (!empty($settingInfo->v_send_email_encryption)) ) ?  $settingInfo->v_send_email_encryption :  null ) );
			$transport->setUsername( ( isset($settingInfo->v_send_email_user) && (!empty($settingInfo->v_send_email_user)) ) ?  $settingInfo->v_send_email_user :  '' );
			$transport->setPassword( ( isset($settingInfo->v_send_email_password) && (!empty($settingInfo->v_send_email_password)) ) ?  $settingInfo->v_send_email_password : '' );
	

			$gmail = new Swift_Mailer($transport);
			
			$data['from'] = ( ( isset($settingInfo->v_send_email_user) && (!empty($settingInfo->v_send_email_user)) ) ?  $settingInfo->v_send_email_user : '' ) ;
			$data['to'] = (isset($data['to']) && !empty($data['to']) ? $data['to'] : '');
			
			if (config('constants.SEND_EMAIL_TO_ORIGINAL_USER') != true){
				$data['to'] = (isset($settingInfo->v_contact_receive_mail) && !empty($settingInfo->v_contact_receive_mail) ? $settingInfo->v_contact_receive_mail : '');
				$data['cc'] = (isset($settingInfo->v_default_cc_mail) && !empty($settingInfo->v_default_cc_mail) ? $settingInfo->v_default_cc_mail : '');
			}

			
			if (empty($data['to'])){
				$result['status'] = false;
				$result['msg'] = trans('messages.error-recipient-not-found');
				return $result;
			}
			
			$data['mailTitle'] = ( ( isset($settingInfo->v_mail_title) && (!empty($settingInfo->v_mail_title)) ) ?  $settingInfo->v_mail_title :  ''  ) ;
			Mail::setSwiftMailer($gmail);
			
			$data['mailData']['settingsInfo'] = $settingInfo;
			
			$result = Mail::send((!empty($data['viewName']) ? $data['viewName'] : ''), (!empty($data['mailData']) ? $data['mailData'] : []), function ($message) use ($data) {
				$message->from($data['from'], (!empty($data['mailTitle']) ? $data['mailTitle'] : null));
				
				$message->to($data['to']);
				
				if(isset($data['cc']) && !empty($data['cc'])){
					$message->cc($data['cc']);
				}
				
				if(isset($data['bcc']) && !empty($data['bcc'])){
					$message->bcc($data['bcc']);
				}
				
				$message->subject($data['subject']);
				
				if (!empty($data['mail_content'])) {
					$message->setBody($data['mail_content'], 'text/html');
				}
				
				if (!empty($data['attachment'])) {
					$data['attachment'] = json_decode($data['attachment'], true);
					if (!empty($data['attachment'])) {
						foreach ($data['attachment'] as $attchment) {
							$message->attach(public_path($attchment));
						}
					}
				}
				
			});
			
			$mailResult = true;
		} catch (\Exception $e) {
			$mailResult = false;
			Log::error($e->getMessage());
			$result['error'] = $e->getMessage();
		}
		//var_dump($mailResult);
		if ($mailResult != false) {
			$result['status'] = true;
		} else {
			$result['status'] = false;
		}
		//$result['status'] = true;
		return $result;
	}
}