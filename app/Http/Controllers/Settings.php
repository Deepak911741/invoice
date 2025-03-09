<?php

namespace App\Http\Controllers;

use App\Helpers\Message;
use App\Models\Settings_model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Settings extends MY_controller
{
    public function __construct(){
        parent::__construct();
        $this->crudModel = new Settings_model();
        $this->tableName = config('constants.SETTINGS_TABLE');
        $this->foldername = config('constants.ADMIN_FOLDER'). 'settings/';
		$this->moduleName = trans('messages.settings');
		$this->redirectUrl = config('constants.SETTINGS_URL');
    }

    public function index(){
        $data = [];
		$data ['pageTitle'] = trans('messages.settings');
		$data['showConfirmBox'] = $this->showConfirmBox;
		
		$where = [];
		$where['isBackendRequest'] = true;
		$settingsInfo = $this->crudModel->getRecordDetails($where);
		$data['settingsInfo'] = (!empty($settingsInfo) ? $settingsInfo : []);
		
		return $this->loadAdminView($this->foldername . 'settings', $data);
    }

    public function add(Request $request){

		$removeWebisteLogo = (!empty($request->input('remove_image_logo_image')) ? $request->input('remove_image_logo_image') : null);
		if( (config('constants.ONLY_ADMIN_PANEL') != true) || (config('constants.IS_FRONTEND_REACT') != false) ){
			$removeFooterLogo = (!empty($request->input('remove_image_footer_logo_image')) ? $request->input('remove_image_footer_logo_image') : null);
		}
		$removeWebisteFavIcon = (!empty($request->input('remove_image_fav_icon_image')) ? $request->input('remove_image_fav_icon_image') : null);
		$removeWebisteOgIcon = (!empty($request->input('remove_image_og_icon_image')) ? $request->input('remove_image_og_icon_image') : null);
			
		$recordData  = [];
			
		if( (config('constants.ONLY_ADMIN_PANEL') != true) || (config('constants.IS_FRONTEND_REACT') != false) ){
			$recordData['v_primary_mobile_no'] = (checkNotEmptyString($request->input('primary_mobile_no')) ? ($request->input('primary_mobile_no')) : null);
			$recordData['v_secondary_mobile_no'] = (checkNotEmptyString($request->input('secondary_mobile_no')) ? ($request->input('secondary_mobile_no')) : null);
			$recordData['v_other_mobile_no'] = (checkNotEmptyString($request->input('other_mobile_no')) ? ($request->input('other_mobile_no')) : null);
			$recordData['e_whatsapp_position'] = (!empty($request->input('whatsapp_no_position')) ? ($request->input('whatsapp_no_position')) : '');
			$recordData['v_whatsapp_number'] = (checkNotEmptyString($request->input('whatsapp_no')) ? $request->input('whatsapp_no') : null);
			$recordData['v_email'] = (checkNotEmptyString($request->input('email')) ? ($request->input('email')): null);
			$recordData['v_working_hours'] = (checkNotEmptyString($request->input('working_hours')) ? $request->input('working_hours') : null);
			$recordData['v_working_days'] = (checkNotEmptyString($request->input('working_days')) ? $request->input('working_days') : null);
			$recordData['v_google_map'] = (checkNotEmptyString($request->input('google_map')) ? htmlentities($request->input('google_map')) : null);
			$recordData['v_short_address'] = (checkNotEmptyString($request->input('short_address')) ? $request->input('short_address') : null);
			$recordData['v_address'] = (checkNotEmptyString($request->input('address')) ? htmlentities($request->input('address')) : null);
				
			$recordData['v_facebook_link'] = (checkNotEmptyString($request->input('facebook')) ? ($request->input('facebook')) : null);
			$recordData['v_instagram_link'] = (checkNotEmptyString($request->input('instagram')) ? ($request->input('instagram')) : null);
			$recordData['v_youtube_link'] = (checkNotEmptyString($request->input('youtube')) ? ($request->input('youtube')) : null);
			$recordData['v_linkedin_link'] = (checkNotEmptyString($request->input('linkedin')) ? ($request->input('linkedin')) : null);
			$recordData['v_twitter_link'] = (checkNotEmptyString($request->input('twitter')) ? ($request->input('twitter')) : null);
		}
			
		$recordData['v_contact_receive_mail'] = (checkNotEmptyString($request->input('contact_receive_mail')) ? ($request->input('contact_receive_mail')) : null);
		$recordData['v_default_cc_mail'] = (checkNotEmptyString($request->input('default_cc_mail')) ? ($request->input('default_cc_mail')) : null);
		$recordData['v_send_email_protocol'] = (checkNotEmptyString($request->input('send_email_protocol')) ? ($request->input('send_email_protocol')) : null);
		$recordData['v_send_email_host'] = (checkNotEmptyString($request->input('send_email_host')) ? ($request->input('send_email_host')) : null);
		$recordData['i_send_email_port'] = (checkNotEmptyString($request->input('send_email_port')) ? ($request->input('send_email_port')) : null);
		$recordData['v_send_email_user'] = (checkNotEmptyString($request->input('send_email_user')) ? ($request->input('send_email_user')) : null);
		$recordData['v_send_email_password'] = (checkNotEmptyString($request->input('send_email_password')) ? ($request->input('send_email_password')) : null);
		$recordData['v_send_email_encryption'] = (checkNotEmptyString($request->input('send_email_encryption')) ? ($request->input('send_email_encryption')) : null);
			
			
		$recordData['v_site_title'] = (checkNotEmptyString($request->input('site_title')) ? $request->input('site_title') : null);
		$recordData['v_site_keywords'] = (checkNotEmptyString($request->input('site_keywords')) ? $request->input('site_keywords') : null);
		if( (config('constants.ONLY_ADMIN_PANEL') != true) || (config('constants.IS_FRONTEND_REACT') != false) ){
			$recordData['v_about_short_description'] = (checkNotEmptyString($request->input('about_short_description')) ? htmlentities($request->input('about_short_description')) : null);
		}
		$recordData['v_site_description'] = (checkNotEmptyString($request->input('site_description')) ? htmlentities($request->input('site_description')) : null);
			
		if( config('constants.SHOW_DEVELOPER_SETTINGS') == 1 ) {
			$recordData['d_version'] = (checkNotEmptyString($request->input('version')) ? ($request->input('version')) : null);
			$recordData['v_mail_title'] = (checkNotEmptyString($request->input('mail_title')) ? ($request->input('mail_title')) : null);
			$recordData['v_meta_author'] = (checkNotEmptyString($request->input('meta_author')) ? ($request->input('meta_author')) : null);
			$recordData['v_powered_by'] = (checkNotEmptyString($request->input('powered_by')) ? ($request->input('powered_by')) : null);
			$recordData['v_powered_by_link'] = (checkNotEmptyString($request->input('powered_by_link')) ? ($request->input('powered_by_link')) : null);
			$recordData['t_contact_settings_tab'] = (!empty($request->input('contact_settings_tab')) ? ($request->input('contact_settings_tab')) : '');
			$recordData['t_social_links_tab'] = (!empty($request->input('social_links_tab')) ? ($request->input('social_links_tab')) : '');
			$recordData['t_smtp_connection_tab'] = (!empty($request->input('smtp_connection_tab')) ? ($request->input('smtp_connection_tab')) : '');
			$recordData['t_site_info_tab'] = (!empty($request->input('site_info_tab')) ? ($request->input('site_info_tab')) : '');
			$recordData['t_logo_settings_tab'] = (!empty($request->input('logo_settings_tab')) ? ($request->input('logo_settings_tab')) : '');
		}
			
		$uploadLogoImage = null;
		if (!empty($request->file('logo_image'))){
			$fileUpload = $this->uploadFile($request, $this->foldername ,  'logo_image' );
			if (isset($fileUpload['status']) && ($fileUpload['status'] != false)){
				$uploadLogoImage = $fileUpload['filePath'];
			}
		}
			
		if( (config('constants.ONLY_ADMIN_PANEL') != true) || (config('constants.IS_FRONTEND_REACT') != false) ){
			$uploadFooterLogoImage = null;
			if (!empty($request->file('footer_logo_image'))){
				$fileUpload = $this->uploadFile($request, $this->foldername, 'footer_logo_image');
				if (isset($fileUpload['status']) && ($fileUpload['status'] != false)){
					$uploadFooterLogoImage = $fileUpload['filePath'];
				}
			}
		}
			
		$uploadFavIconImage = null;
		if (!empty($request->file('fav_icon_image'))){
			$fileUpload = $this->uploadFile($request , $this->foldername , 'fav_icon_image');
			if (isset($fileUpload['status']) && ($fileUpload['status'] != false)){
				$uploadFavIconImage = $fileUpload['filePath'];
			}
		}
			
		$uploadOgIconImage = null;
		if (!empty($request->file('og_icon_image'))){
			$fileUpload = $this->uploadFile($request , $this->foldername , 'og_icon_image'  );
			if (isset($fileUpload['status']) && ($fileUpload['status'] != false)){
				$uploadOgIconImage = $fileUpload['filePath'];
			}
		}
		$where = [];
		$where['isBackendRequest'] = true;
		$settingsInfo = $this->crudModel->getRecordDetails($where);
			
		$websiteLogo = (!empty($settingsInfo->v_website_logo) ? $settingsInfo->v_website_logo :null);
		if( (config('constants.ONLY_ADMIN_PANEL') != true) || (config('constants.IS_FRONTEND_REACT') != false) ){
			$websiteFooterLogo = (!empty($settingsInfo->v_website_footer_logo) ? $settingsInfo->v_website_footer_logo :null);
		}
		$websiteFavIcon = (!empty($settingsInfo->v_website_fav_icon) ? $settingsInfo->v_website_fav_icon :null);
		$websiteOgIcon = (!empty($settingsInfo->v_website_og_icon) ? $settingsInfo->v_website_og_icon :null);
			
		$recordData['v_website_logo'] =  ( (!empty($uploadLogoImage) ? $uploadLogoImage : ( (  (!empty($removeWebisteLogo)) && ( $removeWebisteLogo == config('constants.SELECTION_YES') )  ) ?  null : $websiteLogo ) ) ) ;
		if( (config('constants.ONLY_ADMIN_PANEL') != true) || (config('constants.IS_FRONTEND_REACT') != false) ){
			$recordData['v_website_footer_logo'] =  ( (!empty($uploadFooterLogoImage) ? $uploadFooterLogoImage : ( (  (!empty($removeFooterLogo)) && ( $removeFooterLogo == config('constants.SELECTION_YES') )  ) ?  null : $websiteFooterLogo ) ) ) ;
		}
		$recordData['v_website_fav_icon'] =  ( (!empty($uploadFavIconImage) ? $uploadFavIconImage : ( (  (!empty($removeWebisteFavIcon)) && ( $removeWebisteFavIcon == config('constants.SELECTION_YES') )  ) ?  null : $websiteFavIcon ) ) ) ;
		$recordData['v_website_og_icon'] =  ( (!empty($uploadOgIconImage) ? $uploadOgIconImage : ( (  (!empty($removeWebisteOgIcon)) && ( $removeWebisteOgIcon == config('constants.SELECTION_YES') )  ) ?  null : $websiteOgIcon) ) ) ;
			
		$result = false;
		DB::beginTransaction();
			
		$successMessage =  trans('messages.success-create',['module'=> $this->moduleName]);
		$errorMessage = trans('messages.error-create',['module'=> $this->moduleName]);
			
		try{
				
			if(!empty($settingsInfo)){
		
				$successMessage =  trans('messages.success-update',['module'=> $this->moduleName]);
				$errorMessage = trans('messages.error-update',['module'=> $this->moduleName]);
		
				$this->crudModel->updateTableData($this->tableName , $recordData , ['i_id' => $settingsInfo->i_id]);
			} else {
		
				$this->crudModel->insertTableData($this->tableName , $recordData );
					
			}
				
			$result = true;
		}catch(\Exception $e){
			DB::rollback();
			Log::error($e->getMessage());
		}
	
		if( $result != false ){
			DB::commit();
			Message::setFlashMessage ( 'success', $successMessage  );
			return redirect($this->redirectUrl);
		}
		DB::rollback();
		Message::setFlashMessage ( 'danger', $errorMessage  );
		return redirect()->back();
	}
}
