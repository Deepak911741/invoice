<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ (isset($pageTitle) ? $pageTitle : 'Home')}} | {{ isset($settingsInfo) && !empty($settingsInfo) ? $settingsInfo->v_site_title : ''}}</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="A secure, optimized website with proper meta tags." />
    <meta http-equiv="Strict-Transport-Security" content="max-age=31536000; includeSubDomains" />
    <meta name="referrer" content="strict-origin-when-cross-origin" />
    <meta name="robots" content="index, follow" />
    <meta http-equiv="X-Frame-Options" content="SAMEORIGIN" />
    <meta http-equiv="Permissions-Policy" content="geolocation=(self), camera=()" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="title" content="<?php echo (isset($pageTitle) && checkNotEmptyString($pageTitle) ? $pageTitle : 'Home') . ' | ' . (isset($settingsInfo) && checkNotEmptyString($settingsInfo->v_site_title) ? $settingsInfo->v_site_title : '') ?>">
    <meta name="description" content="{{ ( (isset($settingsInfo->v_site_description) && (checkNotEmptyString($settingsInfo->v_site_description)) ) ? $settingsInfo->v_site_description : '' ) }}">
    <meta name="keywords" content="{{ ( (isset($settingsInfo->v_site_keywords) && (checkNotEmptyString($settingsInfo->v_site_keywords)) ) ? $settingsInfo->v_site_keywords : '' ) }}">
    <meta name="author" content="{{ ( (isset($settingsInfo->v_meta_author) && (checkNotEmptyString($settingsInfo->v_meta_author)) ) ? $settingsInfo->v_meta_author : '' ) }}">

    @php
    $ogIconSrc = getUploadedAssetUrl(isset($settingsInfo->v_website_og_icon) ? $settingsInfo->v_website_og_icon : '');
    $websiteLogoSrc = getUploadedAssetUrl(isset($settingsInfo->v_website_logo) ? $settingsInfo->v_website_logo : '');
    $favIconSrc = getUploadedAssetUrl(isset($settingsInfo->v_website_fav_icon) ? $settingsInfo->v_website_fav_icon : '');
    $footerLogoSrc = getUploadedAssetUrl(isset($settingsInfo->v_website_footer_logo) ? $settingsInfo->v_website_footer_logo : '');
    $encodedUserId = session()->has('user_id') && !empty(session()->get('user_id')) ? Message::encode(session()->get('user_id')) : null;
    @endphp

    <link rel="icon" href="{{ (!empty($favIconSrc) ? $favIconSrc  : $favIconSrc ) }}">
    <link href='https://fonts.gstatic.com' crossorigin='anonymous' rel='preconnect'>
    <link rel="stylesheet" href="{{ asset ('public/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/alertify.min.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/bootstrap-datetimepicker-standalone.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/ckeditor5.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/dataTables.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/default.min.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/jquery.fancybox.min.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/select2.min.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset ('public/css/common.style.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/dashbord.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/header-vertical.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/error.css')}}">

    <script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
    <script type="text/javascript" src="{{ asset ('public/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('public/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('public/js/alertify.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="{{ asset ('public/js/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('public/js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('public/js/common.script.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('public/js/dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('public/js/jquery.fancybox.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('public/js/select2.min.js') }}"></script>


    
</head>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark min-vh-100">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <a href="">
                        <img src="{{ (!empty($websiteLogoSrc) ? $websiteLogoSrc  : $websiteLogoSrc ) }}" alt="" width="150" height="80" style="margin-bottom: 5px;">
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mt-4 align-items-center align-items-sm-start" id="menu">
                        <li class="nav-items-class">
                            <a href="{{ config('constants.DASHBOARD_URL') }}" class="nav-link d-flex align-items-center first-menu" title="{{ trans('messages.dashboard') }}">
                                <i class="fa-solid fa-house me-2"></i>
                                <span class="nav-text">{{ trans('messages.dashboard') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ config('constants.NAVBAR_URL')}}" class="nav-link d-flex align-items-center first-menu" title="{{ trans('messages.navbar') }}">
                                <i class="fa-solid fa-sitemap me-2"></i>
                                <span class="nav-text">{{ trans('messages.navbar') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ config('constants.PROFILE_URL') }}/edit/{{ $encodedUserId }}" title="{{ trans('messages.update-profile') }}" class="nav-link d-flex align-items-center first-menu">
                                <i class="fa-solid fa-user me-2"></i>
                                <span class="nav-text">{{ trans('messages.profile') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ config('constants.SKILLS_MASTER_URL')}}" class="nav-link d-flex align-items-center first-menu" title="{{ trans('messages.skills') }}">
                                <i class="fa-solid fa-gear me-2"></i>
                                <span class="nav-text">{{ trans('messages.skills') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ config('constants.SERVICE_MASTER_URL')}}" class="nav-link d-flex align-items-center first-menu" title="{{ trans('messages.service') }}">
                                <i class="fa fa-wrench me-2"></i>
                                <span class="nav-text">{{ trans('messages.service') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ config('constants.NAVBAR_URL')}}" class="nav-link d-flex align-items-center first-menu" title="{{ trans('messages.portfolio') }}">
                                <i class="fa-solid fa-star"></i>
                                <span class="nav-text">{{ trans('messages.portfolio') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ config('constants.CONTECT_BACK_URL')}}" class="nav-link d-flex align-items-center first-menu" title="{{ trans('messages.contect') }}">
                                <i class="fa fa-address-book me-2"></i>
                                <span class="nav-text">{{ trans('messages.contect') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ config('constants.SETTINGS_URL')}}" class="nav-link d-flex align-items-center first-menu" title="{{ trans('messages.settings') }}">
                                <i class="fa-solid fa-gear me-2"></i>
                                <span class="nav-text">{{ trans('messages.settings') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col py-3" style="">
                <div class="d-flex flex-column">
                    <div class="breadcrumb-wrapper d-flex justify-content-end align-items-center border-bottom">
                        <div class="dropdown admin-dropdown me-lg-0">
                            <a class="dropdown-toggle d-inline-block" href="javascript:void(0)" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="img-user me-2 rounded-circle d-blcok"><i class="fa fa-user me-2" aria-hidden="true"></i><span id="username" class="d-inline-block ">{{ ( session()->has('name') ? session()->get('name') : trans("messages.admin") )  }}</span></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ config('constants.CHANGE_PASSWORD_URL') }}" title="{{ trans('messages.change-password') }}"><i class="fas fa-lock password"></i>{{ trans("messages.change-password") }}</a>
                                @php
                                $encodedUserId = session()->has('user_id') && !empty(session()->get('user_id')) ? Message::encode(session()->get('user_id')) : null;
                                @endphp

                                <a class="dropdown-item" href="{{ config('constants.PROFILE_URL') }}/edit/{{ $encodedUserId }}" title="{{ trans('messages.update-profile') }}">
                                    {{ trans('messages.update-profile') }}
                                </a>
                                <a href="{{ config('constants.SITE_URL') .  'logout' }}" class="dropdown-item logout-btn text-dark text-decoration-none font-15 d-sm-none d-flex align-items-center" title="{{ trans('messages.logout') }}"><i class="fas fa-sign-out-alt password"></i>{{ trans("messages.logout") }}</a>
                            </div>
                        </div>
                        <div class="logout logout-btn-items d-sm-flex d-none ">
                            <a href="{{ config('constants.SITE_URL') .  'logout'  }}" class=" d-sm-flex d-none logout-btn text-dark text-decoration-none font-15  align-items-center" title="{{ trans('messages.logout') }}"><i class="fas fa-power-off me-2"></i> <span>{{ trans("messages.logout") }}</span> </a>
                        </div>
                    </div>

                    <?php /* Main Section Start Only Use In Developer*/ ?>


                    @yield('content')


                    <?php /* Main Section The End */ ?>

                </div>
            </div>
        </div>
    </div>

</body>

</html>