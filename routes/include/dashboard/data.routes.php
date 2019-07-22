<?php

Route::group([
	'prefix' => '/dashboard',
	'middleware' => [
		'auth'
	],
], function () {
	
	
	Route::match(['post', 'get'], '/ajax/ajaxrecentactivity', [
		'as' => 'eac.portal.dashboard.ajax.ajaxrecentactivity',
		'uses' => 'DashboardController@ajaxrecentactivity'
	]);
	
});
