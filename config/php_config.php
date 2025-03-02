<?php

$portfolio = [];

$baseUrl = 'http://';
$portfolio['FRONTEND_URL'] = $baseUrl . $_SERVER['HTTP_HOST'] . '/';

$baseUrl .= $_SERVER['HTTP_HOST'].'/invoice/';

$portfolio['SITE_URL'] = $baseUrl;

$portfolio['ASSET_FOLDER'] = $portfolio['SITE_URL'] . 'public/asset';
$portfolio['SITE_TITLE'] = 'PORTFOLIO';

$portfolio['DISPLAY_DATE_FORMAT'] = "d-m-Y";
$portfolio['DISPLAY_DATE_TIME_FORMAT'] = "d-m-Y h:i:s A";
$portfolio['DEFAULT_DATE_FORMAT'] = "DD-MM-YYYY";

$portfolio['ONLY_ADMIN_PANEL'] = true;

$portfolio['BACKEND_ROUTE_SLUG'] = 'admin/';
$portfolio['BACKEND_SITE_URL'] = $baseUrl . $portfolio['BACKEND_ROUTE_SLUG'];
$portfolio['DEFAULT_PORTFOLIO_ADMIN_EMAIL'] = [ 'infodeepak@gmail.com' ];
$portfolio['ENCRYPTION_KEY'] = "PORTFOLIO_WEBSITE";
$portfolio['DATABSE_NAME'] = 'invoice';
$portfolio['DATABASE_USER'] = "root";
$portfolio['DATABASE_PASSWORD'] = "";
$portfolio['DISPLAY_DATE_FORMAT'] = "d-m-Y";
