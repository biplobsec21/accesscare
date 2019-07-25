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