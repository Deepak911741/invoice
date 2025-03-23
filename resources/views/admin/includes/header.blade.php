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

    <link href='https://fonts.gstatic.com' crossorigin='anonymous' rel='preconnect' />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link rel="icon" href="{{ (!empty($favIconSrc) ? $favIconSrc  : $favIconSrc ) }}">
    <link href='https://fonts.gstatic.com' crossorigin='anonymous' rel='preconnect'>
    <link rel="stylesheet" href="{{ asset ('public/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/alertify.min.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/ckeditor5.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/dataTables.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/default.min.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/jquery.fancybox.min.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/select2.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset ('public/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/dashbord.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/header-vertical.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/error.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/main.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/fontawesome/all.min.css')}}">

    <script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
    <script type="text/javascript" src="{{ asset ('public/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('public/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('public/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('public/js/alertify.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('public/js/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('public/js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('public/js/common.script.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('public/js/jquery.fancybox.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('public/js/select2.min.js') }}"></script>


    <script>
        var site_url = "{{ config('constants.SITE_URL') }}" ;
        var backend_site_url = "{{config('constants.BACKEND_SITE_URL')}}";
        var data_table = '';
    </script>

</head>

<body class="vertical-header">
<div id="wrapper" class="wrapper">
    <header class="d-print-none">
        <nav class="navbar navbar-dark">
            <button class="navbar-toggler ripple me-auto" type="button" accesskey="m">
                <span class="navbar-toggler-icon"></span>
            </button>
            @if(!empty(session()->get('role')) && session()->get('role') == config("constants.ROLE_ADMIN"))
            <li class="nav-item ms-auto d-block me-3"><a class="nav-link" title="{{ trans('messages.download-backup') }}" href="{{ config('constants.DASHBOARD_URL') . '/backup' }}"><i class="fas fa-download fa-fw"></i> <span class="d-none d-sm-inline-block">{{ trans("messages.download-backup") }}</span><span class="d-sm-none d-inline-block">{{ trans("messages.download-backup") }}</span></a></li>
            @endif
            <div class="dropdown admin-dropdown me-lg-0">
                <a class="dropdown-toggle d-inline-block" href="javascript:void(0)" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">         
                <span class="img-user align-middle me-2 rounded-circle d-blcok"><span id="username" class="d-inline-block align-middle">{{ ( session()->has('name') ? session()->get('name') : trans("messages.admin") )  }}</span></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ config('constants.CHANGE_PASSWORD_URL') }}" title="{{ trans('messages.change-password') }}"><i class="fas fa-lock password"></i>{{ trans("messages.change-password") }}</a>
                    <a class="dropdown-item" href="{{ config('constants.PROFILE_URL') . '/edit/' . ( session()->has('user_id') ? Message::encode(session()->get('user_id')) : 0 ) }}" title="{{ trans('messages.update-profile') }}"><i class="fas fa-user fa-fw"></i>{{ trans("messages.update-profile") }}</a>
                    <a href="{{ config('constants.SITE_URL') .  'logout' }}" class="dropdown-item logout-btn text-dark text-decoration-none font-15 d-sm-none d-flex align-items-center"  title="{{ trans('messages.logout') }}"><i class="fas fa-sign-out-alt password"></i>{{ trans("messages.logout") }}</a>
                </div>
            </div>
            <div class="logout logout-btn-items d-sm-flex d-none ">
                <a href="{{ config('constants.SITE_URL') .  'logout'  }}" class=" d-sm-flex d-none logout-btn text-dark text-decoration-none font-15  align-items-center" title="{{ trans('messages.logout') }}"><i class="fas fa-power-off me-2"></i> <span>{{ trans("messages.logout") }}</span> </a>
            </div>
        </nav>
        <div class="sidebar" id="sidebar">
            <ul class="sidebar-nav">
                <li class="text-center nav-users nav-logo-li">
                    <a class="navbar-brand p-lg-0" href="{{ config('constants.DASHBOARD_URL') }}">
                    <img src="{{ (isset($websiteLogoSrc) ? $websiteLogoSrc : $staticWebsiteLogo)  }}" alt="{{ ( (isset($settingsInfo->v_site_title) && (checkNotEmptyString($settingsInfo->v_site_title)) ) ? $settingsInfo->v_site_title : '' ) }}" class="img-fluid big-image nav-logo">
                    <img src="{{ (isset($favIconSrc) ? $favIconSrc  : $staticFavIcon ) }}" alt="{{ ( (isset($settingsInfo->v_site_title) && (checkNotEmptyString($settingsInfo->v_site_title)) ) ? $settingsInfo->v_site_title : '' ) }}" class="img-fluid big-image nav-logo nav-logo-toggla">
                    </a>
                </li>
                <li class="nav-items-class">
                    <a href="{{ config('constants.DASHBOARD_URL') }}" class="nav-link d-flex align-items-center first-menu" title="{{ trans('messages.dashboard') }}">
                        <i class="fa-solid fa-house fa-fw"></i>
                        <span class="nav-text">{{ trans("messages.dashboard") }}</span>
                    </a>
                </li>
                @if( in_array( session()->get('role') ,  [ config('constants.ROLE_ADMIN') ]  ) )
                <li class="nav-items-class">
                    <a href="{{ config('constants.USERS_URL') }}" class="nav-link d-flex align-items-center first-menu" title="{{ trans('messages.users') }}">
                        <i class="fa-solid fa-user fa-fw"></i>
                        <span class="nav-text">{{ trans("messages.users") }}</span>
                    </a>
                </li>
                @endif
                <li class="nav-items-class">
                    <a href="{{ config('constants.INVOICE_URL') }}" class="nav-link d-flex align-items-center first-menu" title="{{ trans('messages.invoce') }}">
                    <i class="fas fa-file-invoice fa-fw"></i>
                        <span class="nav-text">{{ trans("messages.invoce") }}</span>
                    </a>
                </li>
                <li class="nav-items-class">
                    <a href="{{ config('constants.LOGIN_HISTORY_URL')  }}" class="nav-link d-flex align-items-center first-menu" title="{{ trans('messages.login-history') }}">
                        <i class="fa-solid fa-calendar fa-fw"></i>
                        <span class="nav-text">{{ trans("messages.login-history") }}</span>
                    </a>
                </li>
                <li class="nav-items-class">
                        <a href="{{ config('constants.SETTINGS_URL')  }}" class="nav-link d-flex align-items-center first-menu" title="{{ trans('messages.settings') }}">
                            <i class="fa-solid fa-gear fa-fw"></i>
                            <span class="nav-text">{{ trans("messages.settings") }}</span>
                        </a>
                    </li>
            </ul>

            <div class="fixed-footer border-top p-2">
                <p class="text-center small mb-0">&copy; <?php echo date('Y') ?> 
                @if(isset($settingsInfo) && checkNotEmptyString($settingsInfo->v_powered_by))
                <a href="{{ ( checkNotEmptyString($settingsInfo->v_powered_by_link) ? $settingsInfo->v_powered_by_link : 'javascript:void(0)') }}" target="_blank" rel="noopener noreferrer">{{ $settingsInfo->v_powered_by }}</a>
                @endif
                </p>
            </div>
        </div>
    </header>

	@include(config('constants.ADMIN_FOLDER') . 'common-admin-js')
    @include(config('constants.ADMIN_FOLDER') . 'common-update-status-delete-script')
    @include('common-form-validation')
    @include('common-js')
    @yield('content')
    <?php /* nav end  -- */?>

</div>

<?php /* Notification -- */?>
<script>
    // before script
    var detect_open_notification = false;
    $('.icon_wrap').on('click', function() {
        detect_open_notification = true;
        if ($(this).parent().hasClass('active')) {
            $(this).parent().removeClass('active');
        } else {
            $(this).parent().addClass('active');
        }
    });

    $('main').click(function() {
        $('.notifications').removeClass('active');
    });

    $('.main-navbar-wrapper').click(function(e) {
        if (detect_open_notification != true) {
            if ($('.notifications').hasClass('active') != false) {
                $('.notifications').removeClass('active');
            }
        } else {
            detect_open_notification = false;
        }
    });

    
</script>



<script>
    $(document).ready(function() {
        $('.sidebar .main-drodown-toggle').on('click', function(e) {
            $(this).parent("li").toggleClass('active');
            $('.sidebar li.active').not($(this).parents("li")).removeClass("active");

        });
    });
</script>
<script>
    $(document).ready(function() {
        if($(window).width() < 767 && $(".dataTables_wrapper").length > 0){
                $.fn.DataTable.ext.pager.numbers_length = 5;
        } 
    });

    $(document).ready(function() {
        $(".select2").select2({
            placeholder: "Select Services",
            allowClear: false
        });
    });
</script>
</body>
</html>