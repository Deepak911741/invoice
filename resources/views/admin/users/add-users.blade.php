@extends(config('constants.ADMIN_FOLDER') . 'includes/header')

@section('content')
<main class="page-height bg-light-color add-user-section">
    <div class="breadcrumb-wrapper d-lg-flex p-3 border-bottom">
        <h1 class="h3 mb-lg-0 me-3 header-title" id="pageTitle">{{ $pageTitle }}</h1>
        <nav aria-label="breadcrumb" class="d-flex me-3">
            <ol class="breadcrumb bg-transparent p-0 mb-0 align-self-end">
                <li class="breadcrumb-item"><a href="{{ config('constants.USERS_URL') }}" class="category-add-link">{{ trans("messages.users") }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
            </ol>
        </nav>
    </div>
    <section class="inner-wrapper-common-section dropdown-main main-listing-section p-3 user-section">
        <div class="card">

            <div class="card-body">
                <div class="body-form-info reset-bdy-info mt-0 pb-0">
                    {{ Message::readMessage() }}
                    {!! Form::open(array( 'id '=> 'add-user-form' , 'method' => 'post' , 'url' =>  config('constants.USERS_URL') . '/add')) !!}
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="control-label">{{ trans("messages.name") }}<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="name" placeholder="{{ trans('messages.name') }}" value="{{old('name',  ( (isset($recordInfo) && (checkNotEmptyString($recordInfo->v_name))) ?  $recordInfo->v_name : '' ) )}}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="control-label">{{ trans("messages.email-id") }}<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="email" placeholder="{{ trans('messages.email-id') }}" value="{{old('email',  ( (isset($recordInfo) && (checkNotEmptyString($recordInfo->v_email))) ?  $recordInfo->v_email : '' ) )}}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="control-label">{{ trans("messages.mobile-no") }}<span class="text-danger">*</span></label>
                                    <input maxlength="10" class="form-control" type="text" name="mobile" onkeyup="onlyNumber(this);" onchange="onlyNumber(this);"  placeholder="{{ trans('messages.mobile-no') }}" value="{{old('mobile', ( (isset($recordInfo) && (checkNotEmptyString($recordInfo->v_mobile))) ?  $recordInfo->v_mobile : '' ) )}}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group pass-section">
                                    <label class="control-label">{{ trans("messages.password") }}<?php echo ((isset($recordInfo) && ($recordInfo->i_id > 0)) ? '' : '<span class="text-danger">*</span>') ?></label>
                                    <div class="position-relative">
                                        <input class="form-control pass-input" type="password" id="new_password" name="new_password" placeholder="{{ trans('messages.password') }}">
                                        <button type="button" class="showPass" onclick="showPassword(this)"> <i class="eye-slash-icon fa-regular fa-eye"></i></button>
                                    </div>
                                    <label id="new_password-error" class="invalid-input" for="new_password" style="display:none"></label>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group pass-section">
                                    <label class="control-label">{{ trans("messages.confirm-password") }}<?php echo ((isset($recordInfo) && ($recordInfo->i_id > 0)) ? '' : '<span class="text-danger">*</span>') ?></label>
                                    <div class="position-relative">
                                        <input class="form-control pass-input" type="password" name="confirm_password" placeholder="{{ trans('messages.confirm-password') }}" autocomplete="new-password">
                                        <button type="button" class="showPass" onclick="showPassword(this)"> <i class="eye-slash-icon fa-regular fa-eye"></i></button>
                                    </div>
                                    <label id="confirm_password-error" class="invalid-input" for="confirm_password" style="display:none"></label>
                                </div>
                            </div>
                        </div>
                        <div class="twt-sticky-btn-div">
                        <?php if (isset($recordInfo) && ($recordInfo->i_id > 0)) { ?>
                            <input type="hidden" name="record_id" value="{{ Message::encode($recordInfo->i_id)}}">
                            <button type="submit" title="{{ trans('messages.update') }}" class="btn btn bg-theme text-white btn-wide twt-submit-btn">{{ trans("messages.update") }}</button>
                        <?php } else { ?>
                            <button type="submit" title="{{ trans('messages.submit') }}" class="btn btn bg-theme text-white btn-wide twt-submit-btn">{{ trans("messages.submit") }}</button>
                        <?php } ?>
                        <a href="{{ config('constants.USERS_URL') }}" title="{{ trans('messages.back') }}" class="btn btn-outline-secondary shadow-sm btn-wide twt-back-btn">{{ trans("messages.back") }}</a>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    $("#add-user-form").validate({
        errorClass: "invalid-input",
        onsubmit: true,
        onkeyup: false,
        rules: {
            name: {
                required: true,
                noSpace: true
            },
            email: {
                required: true,
                noSpace: true,
                email_regex: true,
                validateUniqueEmail: true
            },
            mobile: {
                required: true,
                noSpace: true,
                mobile_regex: true
            },
            new_password: {
                required: function(element) {
                    return ( (($.trim($("[name='record_id']").val()) != null) && ($.trim($("[name='record_id']").val()) != "") ) ? false : true)
                },
                checkStrongPassword : ( ( ( check_old_password == 1 || check_password_regex == 1 ) ) ? true : false ) ,
                noSpace: true
            },
            confirm_password: {
                required: function(element) {
                	return ( ((($.trim($('[name="new_password"]').val()) != '') && ($.trim($('[name="new_password"]').val()) != '')) || (($.trim($("[name='record_id']").val()) == null) || ($.trim($("[name='record_id']").val()) == "") )) ? true : false);
                },
                noSpace: true,
                equalTo: "#new_password"
            },
        },
        messages: {
            name: {
                required: '{{ trans("messages.required-enter-field-validation" , [ "fieldName" => trans("messages.name") ]) }}'
            },
            email: {
                required: '{{ trans("messages.required-enter-field-validation" , [ "fieldName" => trans("messages.email-id") ]) }}'
            },
            mobile: {
                required: '{{ trans("messages.required-enter-field-validation" , [ "fieldName" => trans("messages.mobile-no") ]) }}'
            },
            new_password: {
                required: '{{ trans("messages.required-enter-field-validation" , [ "fieldName" => trans("messages.password") ])  }}'
            },
            confirm_password: {
                required: '{{ trans("messages.required-enter-field-validation" , [ "fieldName" => trans("messages.confirm-password") ]) }}',
                equalTo: '{{ trans("messages.password-confirm-password-not-match") }}'
            },
        },
        submitHandler: function(form) {
            var confirm_box = '{{ trans("messages.add-user") }}';
        	var confirm_box_msg = '{{ trans("messages.common-module-confirm-msg" , [ "action" => trans("messages.add") , "module" => trans("messages.user") ] ) }}';

        	<?php if (isset($recordInfo) && ($recordInfo->i_id > 0)) { ?>
        		confirm_box = '{{ trans("messages.update-user") }}';
        		confirm_box_msg = '{{ trans("messages.common-module-confirm-msg" , [ "action" => trans("messages.update") , "module" => trans("messages.user") ] ) }}';
        	<?php } ?>
				
        	<?php if( isset($showConfirmBox) && ($showConfirmBox != false ) ) { ?>
	        	alertify.confirm( confirm_box , confirm_box_msg  , function () {
	            	showLoader();
		            form.submit();
				}, function () { });
        	<?php } else { ?>
	        		showLoader();   
	            	form.submit();
        	<?php } ?>
        },
    });


    var unique_email_value_msg = '';
    $.validator.addMethod('validateUniqueEmail', function(value, element){
        var result = true;

        if($.trim(value) != '' && $.trim(value) != null){
            $.ajax({
                type: 'POST', 
                dataType: 'json',
                async: false,
                url: '<?php echo config('constants.USERS_URL') .'/checkUniqueEmail' ?>',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'email': $.trim(value),
                    'record_id': ($.trim($("[name='record_id']").val()) != '' ? $.trim($("[name='record_id']").val()) : null)
                },
                success: function(response) {
                	unique_email_value_msg = response.message;
                	if (response.status_code != "{{ config('constants.SUCCESS_AJAX_CALL') }}") {
                    	result = false;
                    }
                }
            });
        }
        return result;
    }, function (params, element) {
    	return unique_email_value_msg;
    });


</script>

@endsection