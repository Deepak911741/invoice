@extends(config('constants.ADMIN_FOLDER') . 'includes/header')

@section('content')

@include('common-datatable-scripts')

<main class="page-height bg-light-color">
    <div class="breadcrumb-wrapper d-flex border-bottom">
        <h1 class="h3 mb-0 me-3 header-title" id="pageTitle">{{ $pageTitle  }} (<span class="total-record-count">2</span>)</h1>
        <div class="ms-auto pt-sm-0 d-flex align-items-center">
            <a href="{{ config('constants.USERS_URL') . '/create' }}" class="d-flex align-items-center btn btn-theme text-white button-actions-top-bar add-btn  border btn-sm me-2 twt-add-btn" title="{{ trans('messages.add-user') }}"><i class="fas fa-plus twt-add-icon"></i> <span class="d-sm-block d-none"> {{ trans("messages.add-user") }} </span></a>
            <button type="button" class="d-flex align-items-center btn btn text-white button-actions-top-bar add-btn border btn-sm twt-filter-btn" data-bs-toggle="collapse" data-bs-target="#filter" title="{{ trans('messages.filter') }}"><i class="fas fa-filter twt-filter-icon"></i> <span class="d-sm-block d-none"> {{ trans("messages.filter") }} </span></button>
        </div>
    </div>

    <section class="inner-wrapper-common-section main-listing-section pt-3">
        <div class="container-fluid">
            <?php
            $searchPlaceholder = trans('messages.search-by-module' , [ 'Module' => implode(", " , [ trans('messages.name'), trans('messages.email-id'), trans('messages.mobile-no') ] ) ]);
            ?>
            <div class="collapse" id="filter">
                <div class="card card-body mb-3">
                    <div class="row align-items-center">
                        <div class="col-lg-3 col-sm-6">
                            <div class="form-group">
                                <label class="control-label">{{ trans("messages.search-by") }}</label>
                                <input type="text" class="form-control twt-enter-search custom-input" name="search_by" placeholder="<?php echo $searchPlaceholder ?>">
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6">
                            <div class="form-group">
                                <label class="control-label">{{ trans("messages.status") }}</label>
                                <select class="form-select"  name="search_status" onchange="filterData(this);">
                                <option value="">{{ trans("messages.select") }}</option>
                                    @if(isset($statusDetails) && !empty($statusDetails))
                                        @foreach($statusDetails as $statusKey => $statusValue)
                                        	<option value="{{ (isset($statusKey) && !empty($statusKey) ? $statusKey : '') }}">{{ (isset($statusValue) && !empty($statusValue) ? $statusValue : '') }}</option>
                                        @endforeach 
									@endif
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 twt-search-div">
                            <div class="form-group">
                                <button type="button" title="{{ trans('messages.search') }}" class="btn btn-theme text-white twt-search-btn" onclick="filterData(this);">{{ trans("messages.search") }}</button>
                                <button type="button" title="{{ trans('messages.reset') }}" class="btn btn-outline-secondary reset-wild-tigers twt-reset-btn">{{ trans("messages.reset") }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="filter-result-wrapper">
                <div class="card card-body shadow-sm">
                {{ Message::readMessage() }}
                    <div class="table-responsive W-100">
                        <table class="table table-sm table-bordered table-hover" id="user-table">
                            <thead class="twt-table-header">
                                <tr>
                                    <th class="sr-col">{{ trans("messages.sr-no") }}</th>
                                    <th>{{ trans("messages.name") }}</th>
                                    <th class="">{{ trans("messages.email-id") }}</th>
                                    <th>{{ trans("messages.mobile-no") }}</th>
                                    <th class="status-col">{{ trans("messages.status") }}</th>
                                    <th class="actions-col">{{ trans("messages.actions") }}</th>
                                </tr>
                            </thead>
                            <tbody class="ajax-view">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>


<script>
var table_id = 'user-table';

function searchField() {
    var search_by = $.trim($("[name='search_by']").val());
    var search_status = $.trim($("[name='search_status']").val());

    var search_data = {
        'search_by': search_by,
        'search_status': search_status,
    }
    
    return search_data;
}

function filterData() {
    if ($.fn.DataTable.isDataTable('#' + table_id)) {
        $('#' + table_id).DataTable().destroy();
    }
    reintDataTable(table_id);
}

$(document).ready(function() {
    reintDataTable(table_id);
})

var module_url = '{{ config("constants.USERS_URL") }}' + '/';

function reintDataTable(class_name = null) {
    var pagination_url = module_url + "filter";

    var table_columns = [];
    table_columns.push({ data: 'sr_no', orderable: false, class: 'sr-col' });
    table_columns.push({ data: 'name' });
    table_columns.push({ data: 'email' });
    table_columns.push({ data: 'mobile' });
    table_columns.push({ data: 'status', orderable: false });
    table_columns.push({ data: 'action', orderable: false, class: 'actions-col' });

    var search_data = searchField();

    displayDataTable(class_name, pagination_url, search_data, table_columns, true);
}
</script>
@endsection