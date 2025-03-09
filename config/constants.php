<?php

require_once 'php_config.php';

$constants = [
    'DEFAULT_PAGE_INDEX' => 1,
	'PER_PAGE' => 20,
	'TABLE_LISTING_PER_PAGE' => 30,
	'ADMIN_FOLDER' => 'admin/',
	'FORNTEND_FOLDER' => 'frontend/',
	'GUEST_FOLDER_PATH' => 'guest/',
    'ACTIVE_STATUS' => 1,
	'INACTIVE_STATUS' => 0,
	'ACTIVE_STATUS_TEXT' => 'Active',
	'INACTIVE_STATUS_TEXT' => 'Inactive',
	'ENABLE_STATUS' => 'Enable',
	'DISABLE_STATUS' => 'Disable',
	'SUCCESS_AJAX_CALL' => 1,
	'ERROR_AJAX_CALL' => 101,
	'PROFILE_MASTER_TABLE' => 'profile_master',
	'EDUCATION_MASTER_TABLE' => 'education_master',
	'EXPERIENCE_MASTER_TABLE' => 'exprience_master',
	'SETTINGS_TABLE' => 'setting_master',
	'PROFILE'=> 'Profile',
	'SELECTION_YES' => 'yes',

	'FILE_STORAGE_PATH' => storage_path('app/'),
	'UPLOAD_FOLDER' => 'uploads/',
	'FILE_STORAGE_PATH_URL' =>$portfolio['SITE_URL'] .  'storage/app/',
	'STATIC_IMAGE_PATH' =>  $portfolio['SITE_URL'] . 'storage/app/public/images/upload-image.png',

    'ROLE_ADMIN' => 'admin',
	'ROLE_USER' => 'user',
	'LOGIN_SLUG' => 'login',
	'LOGIN_URL'	 => $portfolio['SITE_URL'] . 'login',
    'LOGIN_TABLE' => 'login_master',
    'SUCCESS_LOGIN_REDIRECT' => $portfolio['BACKEND_SITE_URL'] . 'dashboard',
	'DASHBOARD_URL' => $portfolio['BACKEND_SITE_URL'] . 'dashboard',
	'NAVBAR_URL' => $portfolio['BACKEND_SITE_URL'] . 'navbar',
	'NAVBAR_TABLE' => 'navbar_master',
	'LOGIN_HISTORY_TABLE' => 'login_history',	
	'PROFILE_URL' => $portfolio['BACKEND_SITE_URL'] . 'profile',
	'SETTINGS_URL' => $portfolio['BACKEND_SITE_URL'] . 'settings',
	'LEFT' => 'left',
	'RIGHT' => 'right',

	'CONTECT_MASTER_TABLE' => 'contect_master',
	'CONTECT_URL' => $portfolio['SITE_URL'] . 'contact',
	'CONTECT_BACK_URL' => $portfolio['BACKEND_SITE_URL'] . 'contect',

	'SKILLS_MASTER_TABLE' => 'skills_master',
	'SKILLS_MASTER_URL' => $portfolio['BACKEND_SITE_URL'] . 'skills',
	'SKILLS_MASTER_MODULE' => 'skills',

	'SERVICE_MASTER_TABLE' => 'service_master',
	'SERVICE_MASTER_URL' => $portfolio['BACKEND_SITE_URL'] . 'services',

	'PAGE_NOT_FOUND_URL' => $portfolio['BACKEND_SITE_URL'] . 'page-not-found',
	
	'USERS_URL' => $portfolio['BACKEND_SITE_URL'] . 'users',
	'USER_MASTER' => 'users',

	'LOGIN_HISTORY_TABLE' => 'login_history',
];

return array_merge($constants , $portfolio);