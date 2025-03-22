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
                    {!! Form::open(array( 'id '=> 'add-user-form' , 'method' => 'post' , 'url' =>  config('constants.PROFILE_URL') . '/add')) !!}
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="control-label">{{ trans("messages.name") }}<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" disabled name="name" placeholder="{{ trans('messages.name') }}" value="{{old('name',  ( (isset($profileDetils) && (checkNotEmptyString($profileDetils->v_name))) ?  $profileDetils->v_name : '' ) )}}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="control-label">{{ trans("messages.email-id") }}<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" disabled name="email" placeholder="{{ trans('messages.email-id') }}" value="{{old('email',  ( (isset($profileDetils) && (checkNotEmptyString($profileDetils->v_email))) ?  $profileDetils->v_email : '' ) )}}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="control-label">{{ trans("messages.mobile-no") }}<span class="text-danger">*</span></label>
                                    <input maxlength="10" class="form-control" disabled type="text" name="mobile" placeholder="{{ trans('messages.mobile-no') }}" value="{{old('mobile', ( (isset($profileDetils) && (checkNotEmptyString($profileDetils->v_mobile))) ?  $profileDetils->v_mobile : '' ) )}}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="control-label">{{ trans("messages.shop-name") }}<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="shopname" placeholder="{{ trans('messages.shop-name') }}" value="{{old('shopname', ( (isset($recordInfo) && (checkNotEmptyString($recordInfo->v_shop_name))) ?  $recordInfo->v_shop_name : '' ) )}}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label">{{ trans("messages.address") }}<span class="text-danger">*</span></label>
                                    <textarea class="form-control" type="text" name="address" placeholder="{{ trans('messages.address') }}">{{old('address',  ( (isset($recordInfo) && (checkNotEmptyString($recordInfo->v_address))) ?  $recordInfo->v_address : '' ) )}}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="control-label">{{ trans("messages.service") }}<span class="text-danger">*</span></label>
                                    <div id="service-wrapper">
                                        @if(isset($recordInfo->service) && !empty($recordInfo->service))
                                            @foreach(($recordInfo->service) as $key => $service)
                                                <div class="input-group mb-2">
                                                    <input type="hidden" name="service_id[]" value="{{ (isset($service) && !empty($service->i_id) ? Message::encode($service->i_id) : 0) }}">
                                                    <input class="form-control" type="text" name="services[]" value="{{ (isset($service) && !empty($service->v_service) ? $service->v_service : '') }}" placeholder="{{ trans('messages.service') }}">
                                                    <button type="button" class="btn btn-danger remove-service"><i class="fa-solid fa-trash"></i></button>
                                                </div>
                                            @endforeach
                                        @endif
                                        <div class="input-group">
                                            <input class="form-control" type="text" name="services[]" placeholder="{{ trans('messages.service') }}">
                                            <button type="button" class="btn btn-success add-service"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="control-label">{{ trans("messages.events") }}<span class="text-danger">*</span></label>
                                    <div id="events-wrapper">
                                        @if(isset($recordInfo) && !empty($recordInfo->event))
                                            @foreach(($recordInfo->event) as $key => $event)
                                                <div class="input-group mb-2">
                                                <input type="hidden" name="event_id[]" value="{{ (isset($event) && !empty($event->i_id) ? Message::encode($event->i_id) : 0) }}">
                                                    <input class="form-control" type="text" name="events[]" value="{{ (isset($event) && !empty($event->i_id) ? ($event->v_event) : '') }}" placeholder="{{ trans('messages.events') }}">
                                                    <button type="button" class="btn btn-danger remove-event"><i class="fa-solid fa-trash"></i></button>
                                                </div>
                                            @endforeach
                                        @endif
                                        <div class="input-group">
                                            <input class="form-control" type="text" name="events[]" placeholder="{{ trans('messages.events') }}">
                                            <button type="button" class="btn btn-success add-event"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="twt-sticky-btn-div">
                        <input type="hidden" name="login_id" value="{{( (isset($profileDetils) && (!empty($profileDetils->i_id))) ?  Message::encode($profileDetils->i_id) : 0 )}}">
                        <?php if (isset($recordInfo) && ($recordInfo->i_id > 0)) { ?>
                            <input type="hidden" name="record_id" value="{{ Message::encode($recordInfo->i_id) }}">
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
            },
            mobile: {
                required: true,
                noSpace: true,
                mobile_regex: true
            },
            shopname: {
                required: true,
                noSpace: true,
            },
            address: {
                required: true,
                noSpace: true,
            },
            'services[]': {
                required: true,
                noSpace: true,
            },
            'events[]': {
                required: true,
                noSpace: true,
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
            shopname: {
                required: '{{ trans("messages.required-enter-field-validation" , [ "fieldName" => trans("messages.shop-name") ])  }}'
            },
            address: {
                required: '{{ trans("messages.required-enter-field-validation" , [ "fieldName" => trans("messages.address") ])  }}'
            },
            'services[]': {
                required: '{{ trans("messages.required-enter-field-validation" , [ "fieldName" => trans("messages.services") ])  }}'
            },
            'events[]': {
                required: '{{ trans("messages.required-enter-field-validation" , [ "fieldName" => trans("messages.events") ])  }}'
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

    $(document).ready(function () {
    $(document).on("click", ".add-service", function () {
        let newField = `
            <div class="input-group mt-3">
                <input class="form-control" type="text" name="services[]" placeholder="Service">
                <button type="button" class="btn btn-danger remove-service"><i class="fa-solid fa-trash"></i></button>
            </div>`;
        $("#service-wrapper").append(newField);
    });

    $(document).on("click", ".remove-service", function () {
        $(this).parent().remove();
    });

    $(document).on("click", ".add-event", function () {
        let newField = `
            <div class="input-group mt-3">
                <input class="form-control" type="text" name="events[]" placeholder="Event">
                <button type="button" class="btn btn-danger remove-event"><i class="fa-solid fa-trash"></i></button>
            </div>`;
        $("#events-wrapper").append(newField);
    });

    $(document).on("click", ".remove-event", function () {
        $(this).parent().remove();
    });
});

</script>

@endsection