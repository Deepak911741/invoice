@extends(config('constants.ADMIN_FOLDER') . 'includes/header')

@section('content')
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
                                <select class="form-select"  name="search_status">
                                	<option value="">{{ trans("messages.select") }}</option>
                                	<option value="">{{ trans("messages.enable") }}</option>
                                	<option value="">{{ trans("messages.disable") }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 twt-search-div">
                            <div class="form-group">
                                <button type="button" title="{{ trans('messages.search') }}" class="btn btn-theme text-white twt-search-btn">{{ trans("messages.search") }}</button>
                                <button type="button" title="{{ trans('messages.reset') }}" class="btn btn-outline-secondary reset-wild-tigers twt-reset-btn">{{ trans("messages.reset") }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="filter-result-wrapper">
                <div class="card card-body shadow-sm">
                {{ Message::readMessage() }}
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover">
                            <thead class="twt-table-header">
                                <tr>
                                    <th class="sr-col">{{ trans("messages.sr-no") }}</th>
                                    <th>{{ trans("messages.name") }}</th>
                                    <th>{{ trans("messages.email-id") }}</th>
                                    <th>{{ trans("messages.mobile-no") }}</th>
                                    <th class="status-col">{{ trans("messages.status") }}</th>
                                    <th class="actions-col">{{ trans("messages.actions") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="sr-col">1</td>
                                    <td>Lorem, ipsum dolor.</td>
                                    <td>demo@gmail.com</td>
                                    <td>9999999999</td>
                                    <td>
                                        <div class="form-check form-switch twt-custom-switch status-class">
                                            <input type="checkbox" class="form-check-input onclick-change-name" name="customSwitches2" id="customSwitches2">
                                            <label class="form-check-label" for="customSwitches2">Disable</label>
                                        </div>
                                    </td>
                                    <td class="actions-col">
                                        <div class="actions-col-div">
                                            <a title='{{ trans("messages.edit") }}' href="javascript:void(0)" class="btn btn-sm action-btn edit-btn"><i class="fa-fw fi fi-rr-pencil"></i></a>
                                            <button type="button" title='{{ trans("messages.delete") }}' class="btn btn-sm action-btn delete-btn"><i class="fi fi-rr-trash fa-fw"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="sr-col">2</td>
                                    <td>Lorem, ipsum dolor.</td>
                                    <td>demo@gmail.com</td>
                                    <td>9999999999</td>
                                    <td>
                                        <div class="form-check form-switch twt-custom-switch status-class">
                                            <input type="checkbox" class="form-check-input onclick-change-name" name="customSwitches2" id="customSwitches2">
                                            <label class="form-check-label" for="customSwitches2">Disable</label>
                                        </div>
                                    </td>
                                    <td class="actions-col">
                                        <div class="actions-col-div">
                                            <a title='{{ trans("messages.edit") }}' href="javascript:void(0)" class="btn btn-sm action-btn edit-btn"><i class="fa-fw fi fi-rr-pencil"></i></a>
                                            <button type="button" title='{{ trans("messages.delete") }}' class="btn btn-sm action-btn delete-btn"><i class="fi fi-rr-trash fa-fw"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection