<?php

namespace App\Http\Middleware;

use App\Models\Settings_model;
use Closure;
use Illuminate\Http\Request;

class checkLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if( ( session()->has('isLoggedIn') ) && ( session()->get('isLoggedIn') != false ) ){
    		$settingModel = new Settings_model();
    		$settingsInfo = $settingModel->getRecordDetails();
    		$siteTitle = ( isset($settingsInfo->v_site_title) ? (checkNotEmptyString($settingsInfo->v_site_title) ? $settingsInfo->v_site_title : '' ) :  '' );
    		if( session()->get('site_title') == $siteTitle  ){
                $request->loggedUserId = ( session()->has('user_id') ? session()->get('user_id') : 0 ) ;
    		}
            return $next($request);
    	}
    	session()->put('url.intended', url()->current());
        return redirect(config('constants.LOGIN_URL'));
    }
}
