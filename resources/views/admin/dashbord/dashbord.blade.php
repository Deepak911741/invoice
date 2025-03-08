@extends(config('constants.ADMIN_FOLDER') . 'includes/header')


@section('content')
<main class="page-height bg-light-color">
<div class="breadcrumb-wrapper d-flex border-bottom">
    <div>
        <h1 class="mb-0 header-title" id="pageTitle">{{ $pageTitle }}</h1>
    </div>
</div>
<section class="inner-wrapper-common-sections main-listing-section py-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="card bg-theme border-0 mb-3">
                    <div class="card-body card-body-dashbord py-xxl-4">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase h6 mb-0 ">Lorem Ipsum</h5>
                                <span class="h2 font-weight-bold mb-0">17</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center d-flex">
                        <div class="w-50 border-end">
                            <a class="text-white " href="javascript:void(0);" title="{{ trans('messages.view') }}">{{ trans("messages.view") }}</a>
                        </div>
                        <div class="w-50">
                            <a class="text-white" href="javascript:void(0);" title="{{ trans('messages.add') }}">{{ trans("messages.add") }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card bg-theme border-0 mb-3">
                    <div class="card-body card-body-dashbord py-xxl-4">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase h6 mb-0 ">Lorem Ipsum</h5>
                                <span class="h2 font-weight-bold mb-0">17</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center d-flex">
                        <div class="w-50 border-end">
                            <a class="text-white " href="javascript:void(0);" title="{{ trans('messages.view') }}">{{ trans("messages.view") }}</a>
                        </div>
                        <div class="w-50">
                            <a class="text-white" href="javascript:void(0);" title="{{ trans('messages.add') }}">{{ trans("messages.add") }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card bg-theme border-0 mb-3">
                    <div class="card-body card-body-dashbord py-xxl-4">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase h6 mb-0 ">Lorem Ipsum</h5>
                                <span class="h2 font-weight-bold mb-0">17</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center d-flex">
                        <div class="w-50 border-end">
                            <a class="text-white " href="javascript:void(0);" title="{{ trans('messages.view') }}">{{ trans("messages.view") }}</a>
                        </div>
                        <div class="w-50">
                            <a class="text-white" href="javascript:void(0);" title="{{ trans('messages.add') }}">{{ trans("messages.add") }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card bg-theme border-0 mb-3">
                <?php /* Card body -- */ ?>
                    <div class="card-body card-body-dashbord py-xxl-4">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase h6 mb-0">Lorem Ipsum</h5>
                                <span class="h2 font-weight-bold mb-0">17</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center d-flex">
                        <div class="w-50 border-end">
                            <a class="text-white " href="javascript:void(0);" title="{{ trans('messages.view') }}">{{ trans("messages.view") }}</a>
                        </div>
                        <div class="w-50">
                            <a class="text-white" href="javascript:void(0);" title="{{ trans('messages.add') }}">{{ trans("messages.add") }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</main>
@endsection
