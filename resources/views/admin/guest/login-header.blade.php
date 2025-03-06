<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ (isset($pageTitle) ? $pageTitle : 'Home')}} | PORTFOLIO</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="A secure, optimized website with proper meta tags." />
    <meta http-equiv="Strict-Transport-Security" content="max-age=31536000; includeSubDomains" />
    <meta name="referrer" content="strict-origin-when-cross-origin" />
    <meta name="robots" content="index, follow" />
    <meta http-equiv="X-Frame-Options" content="SAMEORIGIN" />
    <meta http-equiv="Permissions-Policy" content="geolocation=(self), camera=()" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
    $assetFolder = config('constants.ASSET_FOLDER');
    $logoPath = $assetFolder . '/images/logo1.png';
    $faviconPath = $assetFolder . '/images/favicon.png';
    @endphp


    <link rel="icon" href="{{ (!empty($faviconPath) ? $faviconPath  : $faviconPath ) }}">
    <link href='https://fonts.gstatic.com' crossorigin='anonymous' rel='preconnect'>

 
    <link rel="stylesheet" href="{{ asset ('public/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/alertify.min.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/bootstrap-datetimepicker-standalone.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/ckeditor5.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/login.common.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/default.min.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/jquery.fancybox.min.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/select2.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset ('public/css/common.style.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/dashbord.css')}}">
    <link rel="stylesheet" href="{{ asset ('public/css/header-vertical.css')}}">

    <script type="text/javascript" src="{{ asset ('public/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('public/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('public/js/alertify.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('public/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('public/js/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('public/js/ckeditor5.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('public/js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('public/js/login.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('public/js/dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('public/js/jquery.fancybox.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('public/js/select2.min.js') }}"></script>
</head>


<main>
    <?php /* start Include content */ ?>

        @yield('content')

    <?php /* start Include content */ ?>
</main>