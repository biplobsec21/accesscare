<?php
//use WebsiteProperties;
//use Illuminate\Support\Facades\Session;
//
///**
// * Helper Functions
// * @package App\Support
// *
// * @author Andrew Mellor <andrew@quasars.com>
// */
if(!function_exists('site')){
	function site(){
		$siteData = App\WebsiteProperties::first();
		if($siteData){
			return $siteData;
		}else{
			return '';
		}
	}
}
//if(!Session::get('time-zone')) {
//	$ip = file_get_contents("http://ipecho.net/plain");
//	$url = 'http://ip-api.com/json/'.$ip;
//	Session::put('time-zone', json_decode(file_get_contents($url),true)['timezone']);
//}