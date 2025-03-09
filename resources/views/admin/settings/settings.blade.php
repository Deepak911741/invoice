@extends( config('constants.ADMIN_FOLDER') .  'includes/header')


@section('content')

<div class="breadcrumb-wrapper d-flex border-bottom">
    <h1 class="h3 mb-0 me-3 header-title"  id="pageTitle">{{ $pageTitle }}</h1>
</div>
<div class="setting-part setting-tabs">
	<?php 
	if( (empty($settingsInfo)) || (  (!empty($settingsInfo)) && ( $settingsInfo->t_contact_settings_tab == 1 ) && ( (config('constants.ONLY_ADMIN_PANEL') != true) || (config('constants.IS_FRONTEND_REACT') != false) ) ) ){ ?>
		<a class="setting-link text-decoration-none d-line-block" href="#contact_settings" title="{{ trans('messages.contact-settings')}}">{{ trans("messages.contact-settings")}}</a>
	<?php }
	if( (empty($settingsInfo)) || ( (!empty($settingsInfo)) && ( $settingsInfo->t_social_links_tab == 1 ) && ( (config('constants.ONLY_ADMIN_PANEL') != true) || (config('constants.IS_FRONTEND_REACT') != false) ) ) ){?>
		<a class="setting-link text-decoration-none d-line-block" href="#social_links" title="{{ trans('messages.social-links')}}">{{ trans("messages.social-links") }}</a>
	<?php } 
	if( (empty($settingsInfo)) || ( (!empty($settingsInfo)) && ( $settingsInfo->t_smtp_connection_tab == 1 ) ) ){?>
		<a class="setting-link text-decoration-none d-line-block" href="#smtp-connection" title="{{ trans('messages.smtp-connection')}}">{{ trans("messages.smtp-connection")}}</a>
	<?php }
	if( (empty($settingsInfo)) || ( (!empty($settingsInfo)) && ( $settingsInfo->t_site_info_tab == 1 ) ) ){?>
		<a class="setting-link text-decoration-none d-line-block" href="#site-info" title="{{ trans('messages.site-info')}}">{{ trans("messages.site-info")}}</a>
	<?php }
	if( (empty($settingsInfo)) || ( (!empty($settingsInfo)) && ( $settingsInfo->t_logo_settings_tab == 1 ) ) ){?>
		<a class="setting-link text-decoration-none d-line-block" href="#logo-settings" title="{{ trans('messages.logo-settings')}}">{{ trans("messages.logo-settings")}}</a>
	<?php }?>
	<?php if( config('constants.SHOW_DEVELOPER_SETTINGS') == 1 ){?>
		<a class="setting-link text-decoration-none d-line-block" href="#developer-settings" title="{{ trans('messages.developer-settings')}}">{{ trans("messages.developer-settings")}}</a>
	<?php }?>
</div>

<div class="container-fluid pt-3">
	<div class="settings-cards">
	 {{ Message::readMessage() }}
     {!! Form::open(array( 'id '=> 'add-settings-form' , 'method' => 'post' ,  'files' => true , 'url' =>  config('constants.SETTINGS_URL') . '/add')) !!}
		<?php if( (empty($settingsInfo)) || (  (!empty($settingsInfo)) && ( $settingsInfo->t_contact_settings_tab == 1 ) && ( (config('constants.ONLY_ADMIN_PANEL') != true) || (config('constants.IS_FRONTEND_REACT') != false) ) ) ){
			?>		 
		<div class="card mb-3 shadow-sm" id="contact_settings">
			<div class="card-header">
				<h2 class="h4 mb-0">{{ trans("messages.contact-settings") }}</h2>
			</div>
				<div class="card-body">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label">{{ trans("messages.primary-mobile-no") }}</label>
								<input type="text" class="form-control" name="primary_mobile_no" placeholder="{{ trans('messages.primary-mobile-no') }}" onkeyup="onlyNumberWithSpaceAndPlusSign(this)" onchange="onlyNumberWithSpaceAndPlusSign(this)" minlength="8" maxlength="15" value="{{ old('primary_mobile_no' , ( (isset($settingsInfo) && (checkNotEmptyString($settingsInfo->v_primary_mobile_no)) ? $settingsInfo->v_primary_mobile_no : ''  ) ) ) }}">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label">{{ trans("messages.secondary-mobile-no") }}</label>
								<input type="text" class="form-control" name="secondary_mobile_no" placeholder="{{ trans("messages.secondary-mobile-no") }}" onkeyup="onlyNumberWithSpaceAndPlusSign(this)" onchange="onlyNumberWithSpaceAndPlusSign(this)" minlength="8" maxlength="15" value="{{ old('secondary_mobile_no' , ( (isset($settingsInfo) && (checkNotEmptyString($settingsInfo->v_secondary_mobile_no)) ? $settingsInfo->v_secondary_mobile_no : ''  ) ) ) }}">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label">{{ trans("messages.other-mobile-no") }}</label>
								<input type="text" class="form-control" name="other_mobile_no" placeholder='{{ trans("messages.other-mobile-no") }}' onkeyup="onlyNumberWithSpaceAndPlusSign(this)" onchange="onlyNumberWithSpaceAndPlusSign(this)" minlength="8" maxlength="15" value="{{ old('other_mobile_no' , ( (isset($settingsInfo) && (checkNotEmptyString($settingsInfo->v_other_mobile_no)) ? $settingsInfo->v_other_mobile_no : ''  ) ) ) }}">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label">{{ trans("messages.whatsapp-no") }}</label>
								<input type="text" class="form-control" name="whatsapp_no" placeholder='{{ trans("messages.whatsapp-no") }}' onkeyup="onlyNumberWithSpaceAndPlusSign(this)" onchange="onlyNumberWithSpaceAndPlusSign(this)" minlength="8" maxlength="15" value="{{ old('whatsapp_no' , ( (isset($settingsInfo) && (checkNotEmptyString($settingsInfo->v_whatsapp_number)) ? $settingsInfo->v_whatsapp_number : ''  ) ) ) }}">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label">{{ trans("messages.whatsapp-no-position") }}</label>
								<select class="form-select position-value" name="whatsapp_no_position">
									<option value="{{ config('constants.LEFT')}}"<?php echo ( ( (!empty($settingsInfo->e_whatsapp_position)) && ($settingsInfo->e_whatsapp_position ==  config('constants.LEFT') ) ) ? 'selected="selected"' : '' ) ?> >{{ trans("messages.left") }}</option>
									<option value="{{ config('constants.RIGHT')}}" <?php echo ( ( (!empty($settingsInfo->e_whatsapp_position)) && ($settingsInfo->e_whatsapp_position == config('constants.RIGHT')) ) ? 'selected="selected"' : '' ) ?>>{{ trans("messages.right") }}</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label">{{ trans("messages.email-id") }}</label>
								<input type="text" class="form-control" name="email"  placeholder='{{ trans("messages.email-id") }}' value="{{ old('email' , ( (isset($settingsInfo) && (checkNotEmptyString($settingsInfo->v_email)) ? $settingsInfo->v_email : ''  ) ) ) }}">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label">{{ trans("messages.working-hours") }}</label>
								<input type="text" class="form-control" name="working_hours"  placeholder="{{ trans('messages.working-hours') }}" value="{{ old('working_hours' , ( (isset($settingsInfo) && (checkNotEmptyString($settingsInfo->v_working_hours)) ? $settingsInfo->v_working_hours : ''  ) ) ) }}">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label">{{ trans("messages.working-days") }}</label>
								<input type="text" class="form-control" name="working_days" placeholder="{{ trans('messages.working-days') }}" value="{{ old('working_days' , ( (isset($settingsInfo) && (checkNotEmptyString($settingsInfo->v_working_days)) ? $settingsInfo->v_working_days : ''  ) ) ) }}">
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label class="control-label">{{ trans("messages.google-map") }}</label>
								<textarea class="form-control" name="google_map" rows="5" placeholder="{{ trans('messages.google-map') }}">{{ old('google_map' , ( (isset($settingsInfo) && (checkNotEmptyString($settingsInfo->v_google_map)) ? html_entity_decode( stripslashes( $settingsInfo->v_google_map ) ) : ''  ) ) ) }}</textarea>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label class="control-label">{{ trans("messages.short-address") }}</label>
								<input type="text" class="form-control" name="short_address" placeholder="{{ trans('messages.short-address') }}" value="{{ old('short_address' , ( (isset($settingsInfo) && (checkNotEmptyString($settingsInfo->v_short_address)) ? $settingsInfo->v_short_address : ''  ) ) ) }}">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label">{{ trans("messages.address") }}</label>
								<textarea class="form-control" name="address" rows="3">{{ old('address' , ( (isset($settingsInfo) && (checkNotEmptyString($settingsInfo->v_address)) ? html_entity_decode($settingsInfo->v_address) : ''  ) ) ) }}</textarea>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
			} 
			if( (empty($settingsInfo)) || ( (!empty($settingsInfo)) && ( $settingsInfo->t_social_links_tab == 1 ) && ( (config('constants.ONLY_ADMIN_PANEL') != true) || (config('constants.IS_FRONTEND_REACT') != false) ) ) ){
			?>
				<div class="card mb-3 shadow-sm" id="social_links">
					<div class="card-header">
						<h2 class="h4 mb-0">{{ trans("messages.social-links") }}</h2>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label">{{ trans("messages.facebook") }}</label>
									<input type="text" class="form-control" name="facebook" placeholder="{{ trans("messages.facebook") }}" value="{{ old('facebook' , ( (isset($settingsInfo) && (checkNotEmptyString($settingsInfo->v_facebook_link)) ? $settingsInfo->v_facebook_link : ''  ) ) ) }}" >
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label">{{ trans("messages.instagram") }}</label>
									<input type="text" class="form-control" name="instagram" placeholder="{{ trans("messages.instagram") }}" value="{{ old('instagram' , ( (isset($settingsInfo) && (checkNotEmptyString($settingsInfo->v_instagram_link)) ? $settingsInfo->v_instagram_link : ''  ) ) ) }}">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label">{{ trans("messages.youtube") }}</label>
									<input type="text" class="form-control" name="youtube" placeholder="{{ trans("messages.youtube") }}" value="{{ old('youtube' , ( (isset($settingsInfo) && (checkNotEmptyString($settingsInfo->v_youtube_link)) ? $settingsInfo->v_youtube_link : ''  ) ) ) }}">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label">{{ trans("messages.linkedin") }}</label>
									<input type="text" class="form-control" name="linkedin" placeholder="{{ trans("messages.linkedin") }}" value="{{ old('linkedin' , ( (isset($settingsInfo) && (checkNotEmptyString($settingsInfo->v_linkedin_link)) ? $settingsInfo->v_linkedin_link : ''  ) ) ) }}">
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<label class="control-label">{{ trans("messages.twitter") }}</label>
									<input type="text" class="form-control" name="twitter" placeholder="{{ trans("messages.twitter") }}" value="{{ old('twitter' , ( (isset($settingsInfo) && (checkNotEmptyString($settingsInfo->v_twitter_link)) ? $settingsInfo->v_twitter_link : ''  ) ) ) }}">
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php 
			}
			if( (empty($settingsInfo)) || ( (!empty($settingsInfo)) && ( $settingsInfo->t_smtp_connection_tab == 1 ) ) ){?>
				<div class="card mb-3 shadow-sm" id="smtp-connection">
					<div class="card-header">
						<h2 class="h4 mb-0">{{ trans("messages.smtp-connection") }}</h2>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label" >{{ trans("messages.contact-receive-mail") }}</label>
									<input type="text" class="form-control" name="contact_receive_mail" placeholder="{{ trans("messages.contact-receive-mail") }}" value="<?php echo old('contact_receive_mail' , ( checkNotEmptyString( $settingsInfo->v_contact_receive_mail ) ? $settingsInfo->v_contact_receive_mail : '' ) ) ?>">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label" >{{ trans("messages.default-cc-mail") }}</label>
									<input type="text" class="form-control" name="default_cc_mail" placeholder="{{ trans("messages.default-cc-mail") }}" value="<?php echo old('default_cc_mail' , ( checkNotEmptyString( $settingsInfo->v_default_cc_mail ) ? $settingsInfo->v_default_cc_mail : '' ) ) ?>">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label" >{{ trans("messages.send-email-protocol") }}</label>
									<input type="text" class="form-control" name="send_email_protocol" placeholder="{{ trans("messages.send-email-protocol") }}" value="<?php echo old('send_email_protocol' , ( checkNotEmptyString( $settingsInfo->v_send_email_protocol ) ? $settingsInfo->v_send_email_protocol : '' ) ) ?>" >
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label" >{{ trans("messages.send-email-host") }}</label>
									<input type="text" class="form-control" name="send_email_host" placeholder="{{ trans("messages.send-email-host") }}" value="<?php echo old('send_email_host' , ( checkNotEmptyString( $settingsInfo->v_send_email_host ) ? $settingsInfo->v_send_email_host : '' ) ) ?>">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label">{{ trans("messages.send-email-port") }}</label>
									<input type="text" class="form-control" name="send_email_port" placeholder="{{ trans("messages.send-email-port") }}" value="<?php echo old('send_email_port' , ( checkNotEmptyString( $settingsInfo->i_send_email_port ) ? $settingsInfo->i_send_email_port : '' ) ) ?>" >
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label">{{ trans("messages.send-email-user") }}</label>
									<input type="text" class="form-control" name="send_email_user" autocomplete="new_send_email_user" placeholder="{{ trans("messages.send-email-user") }}" value="<?php echo old('send_email_user' , ( checkNotEmptyString( $settingsInfo->v_send_email_user ) ? $settingsInfo->v_send_email_user : '' ) ) ?>">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group pass-section">
									<label class="control-label" >{{ trans("messages.send-email-password") }}</label>
									<div class="position-relative">
										<input type="password" class="form-control pass-input" name="send_email_password" autocomplete="new-password" placeholder="{{ trans("messages.send-email-password") }}" value="<?php echo old('send_email_password' , ( checkNotEmptyString( $settingsInfo->v_send_email_password ) ? $settingsInfo->v_send_email_password : '' ) ) ?>">
										<button type="button" class="showPass" onclick="showPassword(this)"> <i class="eye-slash-icon fa-regular fa-eye"></i></button>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label">{{ trans("messages.send-email-encryption") }}</label>
									<input type="text" class="form-control" name="send_email_encryption"  placeholder="{{ trans("messages.send-email-encryption") }}" value="<?php echo old('send_email_encryption' , ( checkNotEmptyString( $settingsInfo->v_send_email_encryption ) ? $settingsInfo->v_send_email_encryption : '' ) ) ?>">
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php 
			}
			if( (empty($settingsInfo)) || ( (!empty($settingsInfo)) && ( $settingsInfo->t_site_info_tab == 1 ) ) ){?>
				<div class="card mb-3 shadow-sm" id="site-info">
					<div class="card-header">
						<h2 class="h4 mb-0">{{ trans("messages.site-info") }}</h2>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label">{{ trans("messages.site-title") }}</label>
									<input type="text" class="form-control" name="site_title" placeholder="{{ trans("messages.site-title") }}" value="<?php echo old('site_title' , ( checkNotEmptyString( $settingsInfo->v_site_title ) ? $settingsInfo->v_site_title : '' ) ) ?>">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label">{{ trans("messages.site-keywords") }}</label>
									<input type="text" class="form-control" name="site_keywords" placeholder="{{ trans("messages.site-keywords") }}" value="<?php echo old('site_keywords' , ( checkNotEmptyString( $settingsInfo->v_site_keywords ) ? $settingsInfo->v_site_keywords : '' ) ) ?>">
								</div>
							</div>
							@if( (config('constants.ONLY_ADMIN_PANEL') != true) || (config('constants.IS_FRONTEND_REACT') != false) )
							<div class="col-lg-12">
								<div class="form-group">
									<label class="control-label" >{{ trans("messages.about-short-description") }}</label>
									<textarea class="form-control" name="about_short_description" rows="3">{{ old('about_short_description' , ( checkNotEmptyString( $settingsInfo->v_about_short_description ) ? html_entity_decode($settingsInfo->v_about_short_description) : '' ) ) }}</textarea>
								</div>
							</div>
							@endif
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label">{{ trans("messages.site-description") }}</label>
									<textarea class="form-control" name="site_description" rows="3" placeholder="{{ trans('messages.site-description') }}">{{ old('site_description' , ( checkNotEmptyString( $settingsInfo->v_site_description ) ? html_entity_decode($settingsInfo->v_site_description) : '' ) )}}</textarea>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			<?php 
			}
			if( (empty($settingsInfo)) || ( (!empty($settingsInfo)) && ( $settingsInfo->t_logo_settings_tab == 1 ) ) ){
				
				$websiteLogo = getUploadedAssetUrl($settingsInfo->v_website_logo);
                $websiteFooterLogo = getUploadedAssetUrl($settingsInfo->v_website_footer_logo);
                $websiteFavIcon = getUploadedAssetUrl($settingsInfo->v_website_fav_icon);
                $websiteOgIcon = getUploadedAssetUrl($settingsInfo->v_website_og_icon);
                
                $defaultImage = config('constants.STATIC_IMAGE_PATH');
                ?>
				<div class="card mb-3 shadow-sm" id="logo-settings">
					<div class="card-header">
						<h2 class="h4 mb-0">{{ trans("messages.logo-settings") }}</h2>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-lg-3">
								<div class="row website-logo-div image-start-div">
									<div class="col-12 form-group">
										<label class="control-label" for="logo_image">{{ trans("messages.header-logo") }}</label>
										<div class="custom-file mb-3">
											<input type="file" class="custom-file-input" id="logo_image" name="logo_image" onchange="imagePreview(this)">
											<label class="custom-file-label text-truncate" for="logo_image">{{ ( ( isset($settingsInfo) && uploadedFileExists($settingsInfo->v_website_logo) ) ? basename($settingsInfo->v_website_logo) : trans('messages.choose-file') ) }}</label>
											<label id="logo_image-error" class="invalid-input" for="logo_image" style="display: none;"></label>
										</div>
									</div>
									<div class="col-12 position-relative">
										<div class="mb-3 preview-image-div logo_image-preview-div" <?php echo ( isset($settingsInfo) && uploadedFileExists($settingsInfo->v_website_logo) ) ? '' : 'style=display:none;' ?>>
											<div class="remove-banner-btn setting-remove-btn hide-button ">
												<button type="button" class="btn btn-sm btn-danger rounded-circle close-button" data-field-name="logo_image" title="{{ trans('messages.delete-file') }}" data-single-field="{{ config('constants.SELECTION_YES') }}" onclick="removeImage(this)"> <i class="fas fa-fw fa-times"></i> </button>
											</div>
											<img src="<?php echo (!empty($websiteLogo) ? $websiteLogo : $defaultImage) ?>" alt="{{ ( isset($settingsInfo->v_site_title) ? $settingsInfo->v_site_title : '' ) }}" class="setting-logo preview-image border-0 file-upload-preview img-fluid logo_image-preview">
										</div>
									</div>
								</div>
							</div>
							
							@if( (config('constants.ONLY_ADMIN_PANEL') != true) || (config('constants.IS_FRONTEND_REACT') != false) )
							<div class="col-lg-3">
								<div class="row website-footer-logo-div image-start-div">
									<div class="col-12 form-group">
										<label class="control-label" for="footer_logo_image">{{ trans("messages.footer-logo") }}</label>
										<div class="custom-file mb-3">
											<input type="file" class="custom-file-input" id="footer_logo_image" name="footer_logo_image" onchange="imagePreview(this)">
											<label class="custom-file-label text-truncate" for="footer_logo_image">{{ ( ( isset($settingsInfo) && uploadedFileExists($settingsInfo->v_website_footer_logo) ) ? basename($settingsInfo->v_website_footer_logo) : trans('messages.choose-file') ) }}</label>
											<label id="footer_logo_image-error" class="invalid-input" for="footer_logo_image" style="display: none;"></label>
										</div>
									</div>
									<div class="col-12 position-relative">
										<div class="mb-3 preview-image-div footer_logo_image-preview-div" <?php echo ( isset($settingsInfo) && uploadedFileExists($settingsInfo->v_website_footer_logo) ) ? '' : 'style=display:none;' ?>>
											<div class="remove-banner-btn setting-remove-btn hide-button ">
												<button type="button" class="btn btn-sm btn-danger rounded-circle close-button" data-field-name="footer_logo_image" title="{{ trans('messages.delete-file') }}" data-single-field="{{ config('constants.SELECTION_YES') }}" onclick="removeImage(this)"> <i class="fas fa-fw fa-times"></i> </button>
											</div>
											<img src="<?php echo (!empty($websiteFooterLogo) ? $websiteFooterLogo : $defaultImage) ?>" alt="{{ ( isset($settingsInfo->v_site_title) ? $settingsInfo->v_site_title : '' )  }}" class="setting-logo preview-image border-0 file-upload-preview img-fluid footer_logo_image-preview">
										</div>
									</div>
								</div>
							</div>
							@endif
							
							
							<div class="col-lg-3">
								<div class="row website-fav-icon-div image-start-div">
									<div class="col-12 form-group">
										<label class="control-label" for="fav_icon_image">{{ trans("messages.fav-icon") }}</label>
										<div class="custom-file mb-3">
											<input type="file" class="custom-file-input" id="fav_icon_image" name="fav_icon_image" onchange="imagePreview(this)">
											<label class="custom-file-label text-truncate" for="fav_icon_image">{{ ( ( isset($settingsInfo) && uploadedFileExists($settingsInfo->v_website_fav_icon) ) ? basename($settingsInfo->v_website_fav_icon) : trans('messages.choose-file') ) }}</label>
											<label id="fav_icon_image-error" class="invalid-input" for="fav_icon_image" style="display: none;"></label>
										</div>
									</div>
									<div class="col-12 position-relative">
										<div class="mb-3 preview-image-div fav_icon_image-preview-div" <?php echo ( isset($settingsInfo) && uploadedFileExists($settingsInfo->v_website_fav_icon) ) ? '' : 'style=display:none;' ?>>
											<div class="remove-banner-btn hide-button setting-remove-btn">
												<button type="button" class="btn btn-sm btn-danger rounded-circle close-button" data-field-name="fav_icon_image" title="{{ trans('messages.delete-file') }}" data-single-field="{{ config('constants.SELECTION_YES') }}" onclick="removeImage(this)"> <i class="fas fa-fw fa-times"></i> </button>
													
											</div>
											<img src="<?php echo (!empty($websiteFavIcon) ? $websiteFavIcon : $defaultImage)?>" alt="{{ ( isset($settingsInfo->v_site_title) ? $settingsInfo->v_site_title : '' )  }}" class="setting-logo preview-image border-0 file-upload-preview img-fluid fav_icon_image-preview">
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="row website-og-icon-div image-start-div">
									<div class="col-12 form-group">
										<label class="control-label" for="og_icon_image">{{ trans("messages.og-icon") }}</label>
										<div class="custom-file mb-3">
											<input type="file" class="custom-file-input" id="og_icon_image" name="og_icon_image" onchange="imagePreview(this)">
											<label class="custom-file-label text-truncate" for="og_icon_image">{{ ( ( isset($settingsInfo) && uploadedFileExists($settingsInfo->v_website_og_icon) ) ? basename($settingsInfo->v_website_og_icon) : trans('messages.choose-file') ) }}</label>
											<label id="og_icon_image-error" class="invalid-input" for="og_icon_image" style="display: none;"></label>
											<label><small>Og Icon should be square i.e. 200 x 200 px, 100 x 100 px</small></label>
										</div>
									</div>
									<div class="col-12 position-relative">
										<div class="mb-3 preview-image-div og_icon_image-preview-div" <?php echo ( isset($settingsInfo) && uploadedFileExists($settingsInfo->v_website_og_icon) ) ? '' : 'style=display:none;' ?>>
											<div class="remove-banner-btn hide-button setting-remove-btn">
												<button type="button" class="btn btn-sm btn-danger rounded-circle close-button" data-field-name="og_icon_image" title="{{ trans('messages.delete-file') }}" data-single-field="{{ config('constants.SELECTION_YES') }}" onclick="removeImage(this)"> <i class="fas fa-fw fa-times"></i> </button>
											</div>
											<img src="<?php echo (!empty($websiteOgIcon) ? $websiteOgIcon :$defaultImage)?>" alt="{{ ( isset($settingsInfo->v_site_title) ? $settingsInfo->v_site_title : '' )  }}" class="setting-logo border-0 preview-image file-upload-preview img-fluid	 og_icon_image-preview">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php }
			 if( config('constants.SHOW_DEVELOPER_SETTINGS') == 1 ){?>
			<div class="card mb-3 shadow-sm" id="developer-settings">
					<div class="card-header">
						<h2 class="h4 mb-0">{{ trans("messages.developer-settings") }}</h2>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label">{{ trans("messages.version") }}</label>
									<input type="text" class="form-control" name="version" placeholder="{{ trans("messages.version") }}" value="<?php echo old('version' , ( checkNotEmptyString( $settingsInfo->d_version ) ? $settingsInfo->d_version : '' ) ) ?>"  onkeyup="onlyDecimal(this)" onchange="onlyDecimal(this)">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label">{{ trans("messages.mail-title") }}</label>
									<input type="text" class="form-control" name="mail_title" placeholder="{{ trans("messages.mail-title") }}" value="<?php echo old('mail_title' , ( checkNotEmptyString( $settingsInfo->v_mail_title ) ? $settingsInfo->v_mail_title : '' ) ) ?>">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label">{{ trans("messages.meta-author") }}</label>
									<input type="text" class="form-control" name="meta_author" placeholder="{{ trans("messages.meta-author") }}" value="<?php echo old('meta_author' , ( checkNotEmptyString( $settingsInfo->v_meta_author ) ? $settingsInfo->v_meta_author : '' ) ) ?>">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label">{{ trans("messages.powered-by") }}</label>
									<input type="text" class="form-control" name="powered_by" placeholder="{{ trans("messages.powered-by") }}" value="<?php echo old('powered_by' , ( !empty( $settingsInfo->v_powered_by ) ? $settingsInfo->v_powered_by : '' ) ) ?>">
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<label class="control-label">{{ trans("messages.powered-by-link") }}</label>
									<input type="text" class="form-control" name="powered_by_link" placeholder="{{ trans("messages.powered-by-link") }}" value="<?php echo old('powered_by_link' , ( checkNotEmptyString( $settingsInfo->v_powered_by_link ) ? $settingsInfo->v_powered_by_link : '' ) ) ?>">
								</div>
							</div>
							@if( (config('constants.ONLY_ADMIN_PANEL') != true) || (config('constants.IS_FRONTEND_REACT') != false) )
							<div class="col-lg-4">
								<div class="form-group">
									<label for="dealing" class="control-label">{{ trans("messages.contact-settings") }}</label>
									<div class="form-check form-switch twt-custom-switch">
										<input type="checkbox" class="form-check-input" id="contact_settings_tab" name="contact_settings_tab" value="1" <?php echo ( ( ( isset($settingsInfo) ) && ( strlen($settingsInfo->t_contact_settings_tab) > 0 ) && ( $settingsInfo->t_contact_settings_tab == 0 ) ) ? "" :  'checked' )?>>
										<label class="form-check-label" for="contact_settings_tab"><span></span></label>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">	
									<label for="dealing" class="control-label">{{ trans("messages.social-links") }}</label>
									<div class="form-check form-switch twt-custom-switch">
										<input type="checkbox" class="form-check-input" id="social_links_tab" name="social_links_tab" value="1" <?php echo ( ( ( isset($settingsInfo) ) && ( strlen($settingsInfo->t_social_links_tab) > 0 ) && ( $settingsInfo->t_social_links_tab == 0 ) ) ? "" :  'checked' )?>>
										<label class="form-check-label" for="social_links_tab"><span></span></label>
									</div>
								</div>
							</div>
							@endif
							<div class="col-lg-4">
								<div class="form-group">
									<label for="dealing" class="control-label">{{ trans("messages.smtp-connection") }}</label>
									<div class="form-check form-switch twt-custom-switch">
										<input type="checkbox" class="form-check-input" id="smtp_connection_tab" name="smtp_connection_tab" value="1" <?php echo ( ( ( isset($settingsInfo) ) && ( strlen($settingsInfo->t_smtp_connection_tab) > 0 ) && ( $settingsInfo->t_smtp_connection_tab == 0 ) ) ? "" :  'checked' )?>>
										<label class="form-check-label" for="smtp_connection_tab"><span></span></label>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">	
									<label for="dealing" class="control-label">{{ trans("messages.site-info") }}</label>
									<div class="form-check form-switch twt-custom-switch">
										<input type="checkbox" class="form-check-input" id="site_info_tab" name="site_info_tab" value="1" <?php echo ( ( ( isset($settingsInfo) ) && ( strlen($settingsInfo->t_site_info_tab) > 0 ) && ( $settingsInfo->t_site_info_tab == 0 ) ) ? "" :  'checked' ) ?>>
										<label class="form-check-label" for="site_info_tab"><span></span></label>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label for="dealing" class="control-label">{{ trans("messages.logo-settings") }}</label>
									<div class="form-check form-switch twt-custom-switch">
										<input type="checkbox" class="form-check-input" id="logo_settings_tab" name="logo_settings_tab" value="1" <?php echo ( ( ( isset($settingsInfo) ) && ( strlen($settingsInfo->t_logo_settings_tab) > 0 ) && ( $settingsInfo->t_logo_settings_tab == 0 ) ) ? "" :  'checked' )?>>
										<label class="form-check-label" for="logo_settings_tab"><span></span></label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php }?>
			
			<div class="text-center justify-content-end button-sticky-submit">
			<?php if (isset($settingsInfo) && ($settingsInfo->i_id > 0)) { ?>
				<button type="submit" class="btn bg-theme text-white btn-wide" title="{{ trans('messages.update') }}">{{ trans("messages.update") }}</button>	
			<?php } else { ?>
				<button type="submit" class="btn bg-theme text-white btn-wide" title="{{ trans('messages.submit') }}">{{ trans("messages.submit") }}</button>
			<?php } ?>
			
		</div>
		{!! Form::close() !!}
	</div>
</div>
<script src="{{ asset ('js/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">

    CKEDITOR.replace('about_short_description',{
			toolbar : ckEditorCongfig,
		});
    CKEDITOR.replace('address', {
			toolbar : ckEditorCongfig,
		});
    
</script>
<script>
    $("#add-settings-form").validate({
        errorClass: "invalid-input",
        ignore: [],
        debug: false,
        rules: {
            site_description: { noSpace : true},
            address: { noSpace : true},
            about_short_description : { noSpace : true},
            primary_mobile_no : { noSpace : true },
            secondary_mobile_no : { noSpace : true },
            other_mobile_no : { noSpace : true },
            whatsapp_no : { noSpace : true },
            email : { noSpace : true ,email_regex:true},
            working_hours : { noSpace : true },
            working_days : { noSpace : true },
            google_map : { noSpace : true },
            short_address : { noSpace : true },
           	facebook : { noSpace : true},
            instagram : { noSpace : true  },
            youtube : { noSpace : true },
            linkedin : { noSpace : true },
            twitter : { noSpace : true },
            site_title : { noSpace : true },
            site_keywords : { noSpace : true },
           	meta_author : { noSpace : true },
            site_name : { noSpace : true },
            powered_by : { noSpace : true },
            powered_by_link : { noSpace : true },
            default_cc_mail : { noSpace : true, email_regex:true},
            contact_receive_mail : { noSpace : true , email_regex:true},
            send_email_protocol : { noSpace : true },
            send_email_host : { noSpace : true },
            send_email_port : { noSpace : true },
            send_email_user : { noSpace : true , email_regex:true},
            send_email_password : { noSpace : true }
        },
        submitHandler: function(form) {
			@if(isset($showConfirmBox) && $showConfirmBox != false)
				var confirm_box = '{{ trans("messages.add-settings") }}';
				var confirm_box_msg = '{{ trans("messages.common-module-confirm-msg" , [ "action" => trans("messages.add") , "module" => trans("messages.settings") ] ) }}';

				@if (isset($settingsInfo) && ($settingsInfo->i_id > 0))
					confirm_box = '{{ trans("messages.update-settings") }}';
					confirm_box_msg = '{{ trans("messages.common-module-confirm-msg" , [ "action" => trans("messages.update") , "module" => trans("messages.settings") ] ) }}';
				@endif
				
				alertify.confirm( confirm_box , confirm_box_msg  , function () {
					showLoader();
					form.submit();
				}, function () { });
        	@else
	        	showLoader();
            	form.submit();
        	@endif
        }
    });
</script>

@endsection