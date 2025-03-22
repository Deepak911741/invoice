@extends(config('constants.ADMIN_FOLDER') . 'includes/header')

@section('content')
<main class="page-height bg-light-color add-user-section">
    <div class="breadcrumb-wrapper d-lg-flex p-3 border-bottom">
        <h1 class="h3 mb-lg-0 me-3 header-title" id="pageTitle">{{ $pageTitle }}</h1>
        <nav aria-label="breadcrumb" class="d-flex me-3">
            <ol class="breadcrumb bg-transparent p-0 mb-0 align-self-end">
                <li class="breadcrumb-item"><a href="{{ config('constants.INVOICE_URL') }}" class="category-add-link">{{ trans("messages.invoce") }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
            </ol>
        </nav>
    </div>
    <section class="inner-wrapper-common-section dropdown-main main-listing-section p-3 user-section">
        <div class="card">

            <div class="card-body">
                <div class="body-form-info reset-bdy-info mt-0 pb-0">
                    {{ Message::readMessage() }}
                    {!! Form::open(array( 'id '=> 'add-user-form' , 'method' => 'post' , 'url' =>  config('constants.INVOICE_URL') . '/add')) !!}
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="control-label">{{ trans("messages.name") }}<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="name" placeholder="{{ trans('messages.name') }}" value="{{old('name',  ( (isset($recordInfo) && (checkNotEmptyString($recordInfo->v_name))) ?  $recordInfo->v_name : '' ) )}}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="control-label">{{ trans("messages.mobile-no") }}<span class="text-danger">*</span></label>
                                    <input maxlength="10" class="form-control" type="text" name="mobile" onkeyup="onlyNumber(this);" onchange="onlyNumber(this);"  placeholder="{{ trans('messages.mobile-no') }}" value="{{old('mobile', ( (isset($recordInfo) && (checkNotEmptyString($recordInfo->v_mobile))) ?  $recordInfo->v_mobile : '' ) )}}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="control-label">{{ trans("messages.date") }}<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="date" placeholder="{{ config('constants.DEFAULT_DATE_FORMAT') }}" value="{{old('date',  ( (isset($recordInfo) && (checkNotEmptyString($recordInfo->dt_date))) ?  clientDate($recordInfo->dt_date) : '' ) )}}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label">{{ trans("messages.address") }}<span class="text-danger">*</span></label>
                                    <textarea class="form-control" type="text" name="address" placeholder="{{ trans('messages.address') }}">{{old('date',  ( (isset($recordInfo) && (checkNotEmptyString($recordInfo->v_name))) ?  $recordInfo->v_name : '' ) )}}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="">
                                    <label class="control-label">{{ trans('messages.select') }} {{ trans("messages.service") }}<span class="text-danger">*</span></label>
                                    <select name="services[]" class="form-control select2" multiple>
                                        <option value="">{{ trans('messages.select') }}</option>
                                        @if(isset($services) && !empty($services))
                                            @php
                                                $serviceId = (isset($recordInfo) && !empty($recordInfo->i_service_ids) ? explode(',', $recordInfo->i_service_ids) : 0);
                                            @endphp
                                            @foreach($services as $service)
                                                <option value="{{ (isset($service) ? Message::encode($service->i_id) : 0) }}"
                                                {{ (isset($service) && isset($serviceId) && is_array($serviceId) && in_array($service->i_id, $serviceId)) ? 'selected' : '' }}>
                                                    {{ (!empty($service->v_service) ? $service->v_service : '' ) }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="control-label">{{ trans('messages.select') }} {{ trans("messages.events") }}<span class="text-danger">*</span></label>
                                    <select name="events[]" class="form-control select2" multiple>
                                        <option value="">{{ trans('messages.select') }}</option>
                                        @if(isset($events) && !empty($events))
                                            @php
                                                $eventIds = (isset($recordInfo) && !empty($recordInfo->i_event_ids) ? explode(',', $recordInfo->i_event_ids) : 0);
                                            @endphp
                                            @foreach($events as $event)
                                                <option value="{{ (!empty($event->i_id) ? Message::encode($event->i_id) : 0 )}}"
                                                {{ (isset($event) && isset($eventIds) && is_array($eventIds) && in_array($event->i_id, $eventIds)) ? 'selected' : '' }}
                                                >{{ (!empty($event->v_event ) ? $event->v_event : '' ) }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="control-label">{{ trans("messages.total-payment") }}<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" onkeyup="onlyNumber(this);" onchange="onlyNumber(this);"  oninput="calculateDuePayment(this)" id="total_payment"  name="total_payment" placeholder="{{ trans('messages.total-payment') }}" value="{{old('total_payment',  ( (isset($recordInfo) && (checkNotEmptyString($recordInfo->v_total_payment))) ?  $recordInfo->v_total_payment : '' ) )}}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="control-label">{{ trans("messages.advance-payment") }}</label>
                                    <input class="form-control" type="text" onkeyup="onlyNumber(this);" onchange="onlyNumber(this);"  oninput="calculateDuePayment(this)" id="advance_payment" name="advance_payment" placeholder="{{ trans('messages.advance-payment') }}" value="{{old('advance_payment',  ( (isset($recordInfo) && (checkNotEmptyString($recordInfo->v_advance_payment))) ?  $recordInfo->v_advance_payment : '' ) )}}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="control-label">{{ trans("messages.total-due-payment") }}<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text"  id="total_due_payment" name="total_due_payment" readonly placeholder="{{ trans('messages.total-due-payment')  }}" value="{{old('total_due_payment',  ( (isset($recordInfo) && (checkNotEmptyString($recordInfo->v_due_payment))) ?  $recordInfo->v_due_payment : '' ) )}}">
                                </div>
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
                        <a href="{{ config('constants.INVOICE_URL') }}" title="{{ trans('messages.back') }}" class="btn btn-outline-secondary shadow-sm btn-wide twt-back-btn">{{ trans("messages.back") }}</a>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    $(document).ready(function() {
        $("[name='date']").datetimepicker({
            useCurrent: false,
            viewMode: 'days',
            ignoreReadonly: true,
            format: '{{ config("constants.DEFAULT_DATE_FORMAT") }}',
            showClear: true,
            showClose: true,
            widgetPositioning: {
            vertical: 'bottom',
            horizontal: 'left',
        },
        icons: {
            clear: 'fa fa-trash',
            Close: 'fa fa-trash',
        },
        });
    }); 

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
            },
            date: {
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
            total_payment: {
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
            date: {
                required: '{{ trans("messages.required-select-field-validation" , [ "fieldName" => trans("messages.date") ])  }}'
            },
            address: {
                required: '{{ trans("messages.required-enter-field-validation" , [ "fieldName" => trans("messages.address") ]) }}',
            },
            'services[]': {
                required: '{{ trans("messages.required-select-field-validation" , [ "fieldName" => trans("messages.service") ]) }}',
            },
            'events[]': {
                required: '{{ trans("messages.required-select-field-validation" , [ "fieldName" => trans("messages.events") ]) }}',
            },
            total_payment: {
                required: '{{ trans("messages.required-enter-field-validation" , [ "fieldName" => trans("messages.total-payment") ]) }}',
            },
        },
        submitHandler: function(form) {
            var confirm_box = '{{ trans("messages.add-invoce") }}';
        	var confirm_box_msg = '{{ trans("messages.common-module-confirm-msg" , [ "action" => trans("messages.add") , "module" => trans("messages.invoce") ] ) }}';

        	<?php if (isset($recordInfo) && ($recordInfo->i_id > 0)) { ?>
        		confirm_box = '{{ trans("messages.update-invoce") }}';
        		confirm_box_msg = '{{ trans("messages.common-module-confirm-msg" , [ "action" => trans("messages.update") , "module" => trans("messages.invoce") ] ) }}';
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


    function calculateDuePayment(inputField) {
        let formGroup = inputField.closest(".row");
        console.log(inputField);

        let totalPaymentInput = formGroup.querySelector("#total_payment");
        let advancePaymentInput = formGroup.querySelector("#advance_payment");
        let duePaymentInput = formGroup.querySelector("#total_due_payment");

        let totalPayment = parseFloat(totalPaymentInput.value) || 0;
        let advancePayment = parseFloat(advancePaymentInput.value) || 0;

        let duePayment = totalPayment - advancePayment;

        duePaymentInput.value = duePayment;
    }


</script>

@endsection