@extends(config('constants.ADMIN_FOLDER') . 'includes/header')

@section('content')
<main class="page-height bg-light-color">
<div class="breadcrumb-wrapper d-flex border-bottom">
        <h1 class="h3 mb-0 me-3 header-title" id="pageTitle">{{ $pageTitle  }} (<span class="total-record-count"></span>)</h1>
        <div class="ms-auto pt-sm-0 d-flex align-items-center">
            <a href="{{ config('constants.USERS_URL') . '/create'  }}" class="d-flex align-items-center btn btn-theme text-white button-actions-top-bar add-btn  border btn-sm me-2" title="{{ trans('messages.add-user') }}"><i class="fas fa-plus"></i> <span class="d-sm-block d-none"> {{ trans("messages.add-user") }} </span></a>
            <button type="button" class="d-flex align-items-center btn btn text-white button-actions-top-bar border btn-sm " data-bs-toggle="collapse" data-bs-target="#filter" title="{{ trans('messages.filter') }}"><i class="fas fa-filter"></i> <span class="d-sm-block d-none"> {{ trans("messages.filter") }} </span></button>
        </div>
    </div>
    <section class="inner-wrapper-common-section main-listing-section pt-3">
        <div class="container-fluid">
            <?php
            $searchPlaceholder = trans('messages.search-by-module', ['Module' => implode(", ", [trans('messages.navbar')])]);
            ?>
            <div class="collapse" id="filter">
                <div class="card card-body mb-3">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6">
                            <div class="form-group">
                                <label class="control-label">{{ trans("messages.search-by") }}</label>
                                <input type="text" class="form-control twt-enter-search custom-input" name="search_by" placeholder="<?php echo $searchPlaceholder ?>">
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6">
                            <div class="form-group">
                                <label class="control-label">{{ trans("messages.status") }}</label>
                                <select class="form-select" name="search_status" onchange="filterData();">
                                    <option value="">{{ trans("messages.select") }}</option>
                                    @if (isset($statusDetails) && !empty($statusDetails))
                                    @foreach ($statusDetails as $statusKey => $statusValue)
                                    <option value="{{ (isset($statusKey) && !empty($statusKey) ? $statusKey : '' )}}">{{ (isset($statusValue) && !empty($statusValue) ? $statusValue : '')}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 d-flex align-items-center gap-2 serach-bar-filter">
                            <button type="button" title="{{ trans('messages.search') }}" class="btn btn-theme text-white filter-search-button" onclick="filterData(this);" style="height: 40px;">{{ trans("messages.search") }}</button>
                            <button type="button" title="{{ trans('messages.reset') }}" class="btn btn-outline-secondary portfolio-reset-btn" style="height: 40px;">{{ trans("messages.reset") }}</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="filter-result-wrapper">
                <div class="shadow-sm">
                    {{ Message::readMessage() }}
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover" id="navbar-table">
                            <thead class="text-center">
                                <tr>
                                    <th class="sr-col text-center">{{ trans("messages.sr-no") }}</th>
                                    <th class="sr-col text-center">{{ trans("messages.navbar") }}</th>
                                    <th class="sr-col text-center">{{ trans("messages.navbar-link") }}</th>
                                    <th class="status-col text-center">{{ trans("messages.status") }}</th>
                                    <th class="actions-col text-center">{{ trans("messages.actions") }}</th>
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

@endsection