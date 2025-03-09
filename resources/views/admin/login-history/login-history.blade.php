@extends( config('constants.ADMIN_FOLDER') .  'includes/header')

@section('content')

<main class="page-height bg-light-color">
    <div class="breadcrumb-wrapper d-flex border-bottom">
        <h1 class="h3 mb-0 me-3 header-title" id="pageTitle">{{ trans("messages.login-history") }} (<span class="total-record-count"></span>)</h1>
        <div class="ms-auto pt-sm-0 d-flex align-items-center">
        <button type="button" class="d-flex align-items-center btn add-btn text-white border btn-sm button-actions-top-bar twt-filter-btn" data-bs-toggle="collapse" data-bs-target="#filter" title="{{ trans('messages.filter') }}"><i class="fas fa-filter twt-filter-icon"></i><span class="d-sm-block d-none"> {{ trans("messages.filter") }} </span> </button>
        </div>
    </div>
    <div class="container-fluid visit-history pt-3">
    	@php
    	$searchPlaceholder = trans('messages.search-by-module' , [ 'Module' => implode(", " , [ trans('messages.username') ] ) ]);
    	@endphp
        <div class="collapse" id="filter">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        @if( in_array( session()->get('role') ,  [ config('constants.ROLE_ADMIN') ]  ) )
                        <div class="col-lg-3 col-sm-4">
                            <div class="form-group">
                            	<?php $searchPlaceholder = trans('messages.search-by-module' , [ 'Module' => implode(", " , [ trans('messages.name') ] ) ]); ?>
                                 <label class="control-label">{{ $searchPlaceholder }}</label>
                                 <select name="search_user" class="form-control select2" onchange="filterData(this);">
									<option value="">{{ trans('messages.select') }}</option>
									@if(count($userDetails) > 0 )
										@foreach($userDetails as $userDetail)
											@php
											$encodeRecordId = Message::encode($userDetail->i_id);
											$selected = "";
											if( isset($selectedUserId) && ( $selectedUserId == $userDetail->i_id ) ){
												$selected = "selected='selected'";
											}
											@endphp
											<option value="{{  $encodeRecordId }}" {{ $selected  }} >{{ $userDetail->v_name }}</option>
										@endforeach
									@endif
								</select>
                            </div>
                        </div>
                        @endif

                        <div class="col-lg-2 col-sm-4">
                            <div class="form-group">
                                <label class="control-label">{{ trans("messages.from-date") }}</label>
                                <div class="date">
                                     <input type="text" class="form-control date mb-3" name="search_start_date" placeholder="{{ config('constants.DEFAULT_DATE_FORMAT') }}" />
                                 </div>
                            </div>
                        </div>

                        <div class="col-lg-2 col-sm-4">
                            <div class="form-group">
                             <label class="control-label">{{ trans("messages.to-date") }}</label>
                                <div class="date">
                                    <input type="text" class="form-control date mb-3" name="search_end_date" placeholder="{{ config('constants.DEFAULT_DATE_FORMAT') }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 twt-search-div ">
                            <div class="form-group">
                                <a class="btn btn-theme text-white twt-search-btn" href="javascript:void(0)" onclick="filterData()" title="{{ trans('messages.search') }}">{{ trans("messages.search") }}</a>
                                <button type="button" class="btn btn-outline-secondary reset-wild-tigers twt-reset-btn" title="{{ trans('messages.reset') }}">{{ trans("messages.reset") }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="filter-result-wrapper">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive twt-fewcol-sticky">
                        <table class="table table-hover table-bordered table-sm">
                            <thead class="twt-table-header">
                                <tr class="">
                                    <th class="sr-col">{{ trans("messages.sr-no") }}</th>
                                    <th style="min-width: 100px;">{{ trans("messages.name") }}</th>
                                    <th style="min-width: 200px;">{{ trans("messages.login-date-time") }}</th>
                                    <th class="actions-col">{{ trans("messages.ip-address") }}</th>
                                </tr>
                            </thead>
                            <tbody class="ajax-view">
                                @include( config('constants.AJAX_VIEW_FOLDER') . 'login-history/login-history-list')
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    var login_history_url = '{{ config("constants.LOGIN_HISTORY_URL") }}' + '/';

    $(document).ready(function() {

        $("[name='search_start_date'],[name='search_end_date']").datetimepicker({
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

    function searchField() {
        var search_start_date = $.trim($("[name='search_start_date']").val());
        var search_end_date = $.trim($("[name='search_end_date']").val());
        var search_user = $.trim($("[name='search_user']").val());

        var search_data = {
            'search_user': search_user,
            'search_start_date': search_start_date,
            'search_end_date': search_end_date
        }

        return search_data;
    }


    function filterData() {

        var search_data = searchField();

        searchAjax(login_history_url + 'filter', search_data);

    }

    $(function() {
    	$("[name='search_start_date']").datetimepicker().on('dp.change', function(e) {
            if( $.trim($(this).val()) != "" && $.trim($(this).val()) != ""  ){
	            var incrementDay = moment((e.date)).startOf('d');
	            $("[name='search_end_date']").data('DateTimePicker').minDate(incrementDay);
	        }else{
	            $("[name='search_end_date']").data('DateTimePicker').minDate(false);
	        }
            $(this).data("DateTimePicker").hide();
        });

        $("[name='search_end_date']").datetimepicker().on('dp.change', function(e) {
            if( $.trim($(this).val()) != "" && $.trim($(this).val()) != ""  ){
	            var decrementDay = moment((e.date)).endOf('d');
	            $("[name='search_start_date']").data('DateTimePicker').maxDate(decrementDay);
	        }else{
	            $("[name='search_start_date']").data('DateTimePicker').maxDate(false);
	        }
            $(this).data("DateTimePicker").hide();
        });
    });
    var pagination_url = login_history_url + 'filter';
</script>
<script type="text/javascript" src="{{ asset ('public/js/scroll-pagination.js') }}"></script>
@endsection