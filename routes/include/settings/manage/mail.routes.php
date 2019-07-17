<?php

/**
 * Mail Settings
 */
// mail routes for support manager
Route::group([
	'namespace' => 'Mail',
	'prefix' => '/mail'
], function () {
	Route::get('/notification-mail', [
		'as' => 'eac.portal.settings.mail.notification-mail',
		'uses' => 'NotificationMailController@index',
	]);
	Route::match(['post', 'get'], '/ajax/list', [
		'as' => 'eac.portal.settings.mail.ajax.list',
		'uses' => 'NotificationMailController@ajaxMailData'
	]);
	Route::post('/ajax/updateDB/notification-mail', [
		'as' => 'eac.portal.settings.mail.notification-mail.ajax',
		'uses' => 'NotificationMailController@ajaxUpdate',
	]);

	Route::get('/registration-mail', [
		'as' => 'eac.portal.settings.mail.registration-mail',
		'uses' => 'RegistrationMailController@index',
	]);
	Route::get('/shipping-mail', [
		'as' => 'eac.portal.settings.mail.shipping-mail',
		'uses' => 'ShippingMailController@index',
	]);
	Route::get('/create', [
		'as' => 'eac.portal.settings.mail.create',
		'uses' => 'NotificationMailController@create',
	]);

	Route::post('/create', [
		'as' => 'eac.portal.settings.mail.create',
		'uses' => 'NotificationMailController@postCreate'
	]);
	Route::get('/edit/{id}', [
		'as' => 'eac.portal.settings.mail.edit',
		'uses' => 'NotificationMailController@edit',
	]);

	Route::post('/edit', [
		'as' => 'eac.portal.settings.mail.edit',
		'uses' => 'NotificationMailController@postEdit',
	]);
	Route::match(['get','post'],'ajax/mailType/deleteDB', [
		'as' => 'mailType.ajaxDelete',
		'uses' => 'NotificationMailController@ajaxMailDelete',
	]);
	Route::get('/logMail', [
		'as' => 'eac.portal.settings.mail.logMail',
		'uses' => 'NotificationMailController@logMail',
	]);
	// Route::post('/mailLogview', [
	// 	'as' => 'eac.portal.settings.mail.mailLogview',
	// 	'uses' => 'NotificationMailController@mailLogview',
	// ]);
	Route::get('/mailLogview/{id}', [
		'as' => 'eac.portal.settings.mail.mailLogview',
		'uses' => 'NotificationMailController@mailLogview',
	]);

});
