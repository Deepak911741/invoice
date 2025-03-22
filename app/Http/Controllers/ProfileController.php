<?php

namespace App\Http\Controllers;

use App\Helpers\Message;
use App\Models\Login_model;
use App\Models\ProfileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProfileController extends MY_controller
{
    public $loginModel;
    public function __construct()
    {
        parent::__construct();
        $this->foldername = config('constants.ADMIN_FOLDER') . 'profile/';
        $this->crudModel = new ProfileModel();
        $this->loginModel = new Login_model();
        $this->moduleName = trans('messages.profile');
    }

    public function edit($recordId)
    {
        $recordId = (!empty($recordId) ? (int)Message::decode($recordId) : 0);
        
        $errorFound = false;
        if ($recordId > 0) {
            $errorFound = true;
            $data['pageTitle'] = trans('messages.update-profile');
            $data['showConfirmBox'] = $this->showConfirmBox;
            
            $whereData['singleRecord'] = true;
            $whereData['i_login_id'] = $recordId;
            $data['recordInfo'] =  $this->crudModel->getRecordDetails($whereData);
            unset($whereData['i_login_id']);

            $whereData['i_id'] = $recordId;
            $data['profileDetils'] =  $this->loginModel->getRecordDetails($whereData);
            return $this->loadAdminView($this->foldername . 'add-profile', $data);
        }
    }

    public function add(Request $request){
        if (!empty($request->post())) {
            $recordId = (!empty($request->post('record_id')) ? (int)Message::decode($request->post('record_id')) : 0);
            $password = (checkNotEmptyString($request->input('new_password')) ? trim($request->input('new_password')) : '');

            $formValidation = [];
            $formValidation['shopname'] = 'required';
            $formValidation['address'] = ['required'];
            $formValidation['services'] = ['required'];
            $formValidation['events'] = ['required'];

            $validator = Validator::make($request->all(), $formValidation, [
                'shopname.required' => trans("messages.required-enter-field-validation", ["fieldName" => trans("messages.shop-name")]),
                'address.required' => trans("messages.required-enter-field-validation", ["fieldName" => trans("messages.address")]),
                'services.required' => trans("messages.required-enter-field-validation", ["fieldName" => trans("messages.service")]),
                'events.required' => trans("messages.required-enter-field-validation", ["fieldName" => trans("messages.event")]),
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $recordData = [];
			$recordData['i_login_id'] = (!empty($request->input('login_id')) ? (int)Message::decode($request->input('login_id')) : 0);
			$recordData['v_shop_name'] = (checkNotEmptyString($request->input('shopname')) ? trim($request->input('shopname')) : '');
			$recordData['v_address'] = (checkNotEmptyString($request->input('address')) ? trim($request->input('address')) : '');
			$services = (!empty($request->input('services')) ? ($request->input('services')) : []);
			$events = (!empty($request->input('events')) ? ($request->input('events')) : []);

            $successMessage = trans ('messages.success-create', ['module' => $this->moduleName ] );
			$errorMessage = trans ('messages.error-create', ['module' => $this->moduleName ] );

            $result = false;
            
            DB::beginTransaction();
            try{
				if( $recordId > 0 ){
					$successMessage = trans ( 'messages.success-update', ['module' => $this->moduleName ] );
					$errorMessage = trans ( 'messages.error-update', ['module' => $this->moduleName ] );
					$this->crudModel->updateTableData( config('constants.PROFILE_TABLE') , $recordData , [ 'i_id' =>  $recordId ]);

                    if(!empty($services)){
                        foreach ($services as $index => $service) {
                            $serviceId = (isset($request->input('service_id')[$index]) ? (int)Message::decode($request->input('service_id')[$index]) : 0);
                            $serviceData = [];
                            $serviceData['i_login_id'] = $recordData['i_login_id'];
                            $serviceData['i_profile_id'] = $recordId;
                            $serviceData['v_service'] = (!empty($service) ? $service : null); 

                            if (!empty($serviceId) > 0) {
                                $this->crudModel->updateTableData(config('constants.SERVICE_TABLE'), $serviceData, ['i_id' => $serviceId]);
                            } else {
                                $this->crudModel->insertTabledata(config('constants.SERVICE_TABLE'), $serviceData);
                            }
                        }
                    }

                    if(!empty($events)){
                        foreach ($events as $index => $event) {
                            $eventId = (isset($request->input('event_id')[$index]) ? (int)Message::decode($request->input('event_id')[$index]) : 0);
                            $eventData = [];
                            $eventData['i_login_id'] = $recordData['i_login_id'];
                            $eventData['i_profile_id'] = $recordId;
                            $eventData['v_event'] = (!empty($event) ? $event : null); 
                            
                            if (!empty($eventId) > 0) {
                                $this->crudModel->updateTableData(config('constants.EVENT_TABLE'), $eventData, ['i_id' => $eventId]);
                            } else {
                                $this->crudModel->insertTabledata(config('constants.EVENT_TABLE'), $eventData);
                            }
                        }
                    }
				} else {
					$profileId = $this->crudModel->insertTableData( config('constants.PROFILE_TABLE') , $recordData);

                    if(!empty($services)){
                        foreach ($services as $index => $service) {
                            $serviceData = [];
                            $serviceData['i_login_id'] = $recordData['i_login_id'];
                            $serviceData['i_profile_id'] = $profileId;
                            $serviceData['v_service'] = (!empty($service) ? $service : null); 
                            $this->crudModel->insertTabledata(config('constants.SERVICE_TABLE'), $serviceData);
                        }
                    }

                    if(!empty($events)){
                        foreach ($events as $index => $event) {
                            $eventData = [];
                            $eventData['i_login_id'] = $recordData['i_login_id'];
                            $eventData['i_profile_id'] = $profileId;
                            $eventData['v_event'] = (!empty($event) ? $event : null); 
                            $this->crudModel->insertTabledata(config('constants.EVENT_TABLE'), $eventData);
                        }
                    }
				}
					
				$result = true;
			}catch(\Exception $e){
				$result = false;
				\Log::error($e->getMessage());
				DB::rollBack();
			}
            if( $result != false ){
				DB::commit();
				Message::setFlashMessage('success', $successMessage);
			} else {
				DB::rollBack();
				Message::setFlashMessage('danger', $errorMessage);
			}
			return redirect()->back();
			
        }
    }
}
