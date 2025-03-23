<?php

namespace App\Http\Controllers;

use App\Helpers\Message;
use App\Models\eventModel;
use App\Models\InvoiceModel;
use App\Models\serviceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Cast\Unset_;

class InvoiceController extends MY_controller
{
    public function __construct(){
        parent::__construct();
        $this->crudModel = new InvoiceModel();
        $this->tableName = config('constants.INVOICE_TABLE');
        $this->redirectUrl = config('constants.INVOICE_URL');
        $this->moduleName = trans('messages.invoce');
        $this->foldername = config('constants.ADMIN_FOLDER' ) . 'invoice/';
    }

    public function index(){
        $data['pageTitle'] = trans('messages.invoce');
        $data['statusDetails'] = getStatusDetails();

        return $this->loadAdminView($this->foldername . 'invoice', $data);
    }

    public function create(){
        $data['pageTitle'] = trans('messages.add-invoce');

        $whereData['i_login_id'] = (session()->has('user_id') && !empty(session()->get('user_id')) ? session()->get('user_id') : '');
        $data['services'] =  (new serviceModel)->getRecordDetails($whereData);
        $data['events'] =  (new eventModel)->getRecordDetails($whereData);
        $data['showConfirmBox'] = $this->showConfirmBox;

        return $this->loadAdminView($this->foldername . 'add-invoice', $data);
    }

    public function add(Request $request){
        $recordId = (!empty($request->post('record_id')) ? (int)Message::decode($request->post('record_id')) : 0);
        $serviceIds =  (!empty($request->post('services')) ? ($request->post('services')) : []);
        $eventIds =  (!empty($request->post('events')) ? ($request->post('events')) : []);

        $decodedServiceIds = $decodedEventIds = [];

        foreach ($serviceIds as $id) {
            $decodedServiceIds[] = (int)Message::decode($id);
        }

        foreach ($eventIds as $id) {
            $decodedEventIds[] = (int)Message::decode($id);
        }
 
        $formValidation = [];
        $formValidation['name'] = 'required';
        $formValidation['mobile'] = [ 'required'] ;
        $formValidation['date'] = ['required'];
        $formValidation['address'] = ['required'];
        $formValidation['total_payment'] = ['required'];

        $validator = Validator::make ( $request->all (), $formValidation , [
            'name.required' => trans("messages.required-enter-field-validation" , [ "fieldName" => trans("messages.name") ]),
            'mobile.required' => trans("messages.required-enter-field-validation" , [ "fieldName" => trans("messages.mobile-no") ]),
            'date.required' => trans("messages.required-enter-field-validation" , [ "fieldName" => trans("messages.date") ]),
            'address.required' => trans("messages.required-enter-field-validation" , [ "fieldName" => trans("messages.address") ]),
            'total_payment.required' => trans("messages.required-enter-field-validation" , [ "fieldName" => trans("messages.total-payment") ]),
        ]);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $recordData = [];
        $recordData['i_login_id'] = (session()->has('user_id') && !empty(session()->get('user_id')) ? session()->get('user_id') : 0);
        $recordData['v_name'] = (checkNotEmptyString($request->input('name')) ? trim($request->input('name')) : '');
        $recordData['v_mobile'] = (checkNotEmptyString($request->input('mobile')) ? trim($request->input('mobile')) : '');
        $recordData['dt_date'] = (checkNotEmptyString($request->input('date')) ? dbDate($request->input('date')) : '');
        $recordData['v_address'] = (checkNotEmptyString($request->input('address')) ? trim($request->input('address')) : '');
        $recordData['i_service_ids'] = (!empty($decodedServiceIds) ? implode(',', $decodedServiceIds) : '');
        $recordData['i_event_ids'] = (!empty($decodedEventIds) ? implode(',', $decodedEventIds) : '');
        $recordData['v_total_payment'] = (checkNotEmptyString($request->input('total_payment')) ? trim($request->input('total_payment')) : 0);
        $recordData['v_advance_payment'] = (checkNotEmptyString($request->input('advance_payment')) ? trim($request->input('advance_payment')) : 0);
        $recordData['v_due_payment'] = (checkNotEmptyString($request->input('total_due_payment')) ? trim($request->input('total_due_payment')) : 0);

        $successMessage = trans ('messages.success-create', [ 'module' => $this->moduleName ] );
		$errorMessage = trans ('messages.error-create', [ 'module' => $this->moduleName ] );
		
        $result = false;
        
        DB::beginTransaction();
        try{
            if( $recordId > 0 ){
                $successMessage = trans ( 'messages.success-update', [ 'module' => $this->moduleName ] );
                $errorMessage = trans ( 'messages.error-update', [ 'module' => $this->moduleName ] );
                $this->crudModel->updateTableData( config('constants.INVOICE_TABLE') , $recordData , [ 'i_id' =>  $recordId ] );
            } else {
                $this->crudModel->insertTableData( config('constants.INVOICE_TABLE') , $recordData );
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
			
		return redirect($this->redirectUrl);
    }

    public function filter(Request $request){
        $whereData = $likeData = $additionalData = [];

        $fieldData = $this->convertFilterRequest($request);
        $searchValue = $fieldData['tableSearch'];
        $columnName = $fieldData['sortColumnName'];
        $columnSortOrder = $fieldData['columnSortOrder'];
        $offset = $fieldData['offset'];
        $draw = $fieldData['draw'];
        $limit = $fieldData['limit'];
        
        $filterData = $this->commonFilterData($request);
        $whereData = (isset($filterData['where']) ? $filterData['where'] : []);
        $likeData = (isset($filterData['like']) ? $filterData['like'] : []);

        if(!empty($columnName)){
            switch ($columnName) {
                case 'name':
                    $columnName = 'v_name';
                    break;
                case 'email':
                    $columnName = 'v_email';
                    break;
                case 'date':
                    $columnName = 'dt_date';
                    break;
                case 'due_payment':
                    $columnName = 'v_due_payment';
                    break;
            }
            $whereData['order_by'] = [$columnName => (!empty($columnSortOrder) ? $columnSortOrder : 'DESC')];
        }else{
            $whereData['order_by'] = ['i_id' => 'desc'];
        }

        $whereData['i_login_id'] = (session()->has('user_id') && !empty(session()->get('user_id')) ? session()->get('user_id') : '');
        $whereData['countRecord'] = true;
        $totalRecords = $this->crudModel->getRecordDetails($whereData, $likeData);
        if(isset($whereData['countRecord'])){
            unset($whereData['countRecord']);
        }

        $whereData['offset'] = $offset;
        $whereData['limit'] = $limit;

        $recordDetails = $this->crudModel->getRecordDetails($whereData, $likeData);
        
        $finalData = [];
        if(!empty($recordDetails)){
            $index = $offset;
            foreach ($recordDetails as $key => $recordDetail) {
                $encodeRecordId = Message::encode($recordDetail->i_id);

                $rowData = [];
                $rowData['sr_no'] = ++$index;
                $rowData['name'] = (checkNotEmptyString($recordDetail->v_name) ? $recordDetail->v_name : '' );
                $rowData['mobile'] = (checkNotEmptyString($recordDetail->v_mobile) ? $recordDetail->v_mobile : '' );
                $rowData['date'] = (checkNotEmptyString($recordDetail->dt_date) ? clientDate($recordDetail->dt_date) : '' );
                $rowData['due_payment'] = (checkNotEmptyString($recordDetail->v_due_payment) ? $recordDetail->v_due_payment : '' );

                $checked = '';
                if($recordDetail->t_is_active == config('constants.ACTIVE_STATUS')){
                    $checked = 'checked="checked"';
                }

                $rowData['status'] = '<div class="form-check form-switch twt-custom-switch status-class">';
                $rowData['status'] .= '<input type="checkbox" class="form-check-input" '.$checked.' data-record-id="'.$encodeRecordId.'" id="disable_'.$key.'" data-module-name="'.config('constants.INVOICE_MASTER').'" onclick="updateRecordStatus(this)">';
                $rowData['status'] .= '<label class="form-check-label record-status" for="disable_'.$key.'">'.(!empty($recordDetail->t_is_active == config('constants.ACTIVE_STATUS')) ? trans("messages.enable") : trans("messages.disable") ) .'</label>';
                $rowData['status'] .= '</div>';
                
                $rowData['action'] = '<div class="actions-col-div">';
                $rowData['action'] .= '<a href="'. route('invoice.edit', $encodeRecordId ).'" title="'.trans("messages.edit").'" class="btn edit-btn action-btn btn-sm edit-btn"><i class="fa-solid fa-pencil"></i></a>';
                $rowData['action'] .= '<a href="'. route('invoice.exportPdf', $encodeRecordId ).'" title="'.trans("messages.view").'" target="_blank" class="btn edit-btn action-btn btn-sm edit-btn"><i class="fa-solid fa-eye" style="color: #FFD43B;"></i></a>';
                $rowData['action'] .= '<button title="'.trans("messages.delete").'" data-record-id="'.$encodeRecordId.'" data-module-name="'.config('constants.INVOICE_MASTER').'" data-msg-module-name="'.$this->moduleName.'" onclick="deleteRecord(this);" type="button" class="btn action-btn btn-sm delete-btn"><i class="fa-solid fa-trash"></i></button>';
                $rowData['action'] .= '</div>';
                
                $finalData[] = $rowData;
            }
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => count($finalData),
                "iTotalDisplayRecords" => $totalRecords,
                "aaData" => $finalData
            );
            
            return Response::json($response);
        }
    }

    public function edit($recordId){
        $errorFound = true;

        $recordId = (!empty($recordId) ? (int)Message::decode($recordId) : 0);
        if($recordId > 0){
            $errorFound = true;

            $whereData['i_id'] = $recordId;
            $whereData['singleRecord'] = true;

            $recordInfo = $this->crudModel->getRecordDetails ($whereData);
            unset($whereData['i_id']);
            unset($whereData['singleRecord']);

            if(!empty($recordInfo)){
                $errorFound = false;
                
                $data['recordInfo'] = $recordInfo;
                $data['pageTitle'] = trans ( 'messages.update-invoce');
                $data['showConfirmBox'] = $this->showConfirmBox;
                $whereData['i_login_id'] = (session()->has('user_id') && !empty(session()->get('user_id')) ? session()->get('user_id') : '');
                $data['services'] = (new serviceModel)->getRecordDetails($whereData);
                $data['events'] =  (new eventModel)->getRecordDetails($whereData);
                return $this->loadAdminView($this->foldername . 'add-invoice', $data);
            }
        }
       if($errorFound != false){
            return redirect(config('constants.PAGE_NOT_FOUND_URL'));
        }
    }

    public function updateStatus(Request $request){
		if(!empty($request->input())){
			return $this->updateMasterStatus($request , $this->tableName,  $this->moduleName);
		}
	}

    public function delete(Request $request){
		
		$errorFound = true;
		if(!empty($request->input())){
			$recordId = (!empty($request->input('delete_record_id')) ? (int)Message::decode( $request->input('delete_record_id') ) : 0 );

			if( $recordId  > 0 ){
				$errorFound = false;
				
				return $this->removeRecord($this->tableName, $recordId, $this->moduleName);
			}
		}
		
		if( $errorFound != false ){
			return redirect(config('constants.PAGE_NOT_FOUND_URL'));
		}
	}

    public function exportPdf($recordId){
        $errorFound = true;

        $recordId = (!empty($recordId) ? (int)Message::decode($recordId) : 0);
        if($recordId > 0){
            $errorFound = true;

            $whereData['i_id'] = $recordId;
            $whereData['singleRecord'] = true;

            $recordInfo = $this->crudModel->getRecordDetails ($whereData);
            unset($whereData['i_id']);
            unset($whereData['singleRecord']);

            if(!empty($recordInfo)){
                $errorFound = false;
                
                $data['recordInfo'] = $recordInfo;
                if(!empty($recordInfo->i_service_ids)) {
                    $serviceIds = explode(',', $recordInfo->i_service_ids);
                    $data['services'] = ServiceModel::whereIn('i_id', $serviceIds)->where('t_is_deleted', config('constants.INACTIVE_STATUS'))->get();
                } 

                if(!empty($recordInfo->i_event_ids)){
                    $eventsId = explode(',', $recordInfo->i_event_ids);
                    $data['events'] = eventModel::whereIn('i_id', $eventsId)->where('t_is_deleted', config('constants.INACTIVE_STATUS'))->get();
                }
                
                return $this->samplePDF($data);
            }
        }
       if($errorFound != false){
            return redirect(config('constants.PAGE_NOT_FOUND_URL'));
        }
    }

    public function samplePDF($data = []){
	
		$defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
		$fontDirs = $defaultConfig['fontDir'];
		$defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
		$fontDirs = $defaultConfig['fontDir'];
		$defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
		$fontData = $defaultFontConfig['fontdata'];
		$customFonts = [];
		$customFonts['poppins-regular'] = [ 'R' => 'Poppins-Regular.ttf' ];
		$customFonts['poppins-medium'] = [ 'R' => 'Poppins-Medium.ttf' ];
		$customFonts['poppins-bold'] = [ 'R' => 'Poppins-Bold.ttf' ];
		$customFonts['twt'] = [ 'R' => 'shruti-jay.ttf', 'useOTL' => 0xFF ];
		if(!empty($customFonts)){
			$fontData = array_merge($fontData,$customFonts);
		}
		
		$html = view ('admin.pdf.invoice-pdf')->with($data)->render();
        
		$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8',
			'format' => 'A4',
			'margin_left' => 0,
			'margin_right' => 0,
			'margin_top' => 0,
			'margin_bottom' => 0,
			'margin_header' => 0,
			'margin_footer' => 0,
			'fontDir' => array_merge($fontDirs, [
					public_path('css/fonts/'),
			]),
			'fontdata' => $fontData,
            'default_font' => 'Arial, sans-serif',
		]);

		$stylesheet = file_get_contents(public_path('css/pdf/pdf.css')); 
		$fileName = "invoice-" . date('d-m-Y');
	
		$mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
		$mpdf->SetTitle($fileName);
		$fileName = $fileName.'.pdf';
		$mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
		$mpdf->Output($fileName,'I');
	}

    protected function commonFilterData($request = null){
        $whereData = $likeData = $additionalData = [];
		
		if( checkNotEmptyString($request->post('search_by')) ){
			$searchValue = trim($request->input ( 'search_by' ));
			$likeData = [ 'value' => $searchValue, 'columnName' => ['v_name' , 'v_mobile'] ];
		}
			
		if( !empty($request->post('search_status')) ){
			$whereData['t_is_active'] = trim($request->post('search_status')) == config('constants.ENABLE_STATUS') ? config('constants.ACTIVE_STATUS') : config('constants.INACTIVE_STATUS');
		}

        if (!empty($request->post('search_date'))) {
            $whereData['dt_date'] =  dbDate($request->post('search_date'));
        }
	
		$response = [];
		$response['where'] = $whereData;
		$response['like'] = $likeData;
		$response['additional'] = $additionalData;
	
		return $response;
    }
}
