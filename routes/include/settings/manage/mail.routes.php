<?php

/**
 * Mail Settings
 */
// mail routes for support manager
Route::group([
	'namespace' => 'Mail',
	'prefix' => '/mail'
], function () {
	Route::get('/list', [
		'as' => 'eac.portal.settings.mail.notification-mail',
		'uses' => 'MailerController@index',
	]);
	Route::match(['post', 'get'], '/ajax/list', [
		'as' => 'eac.portal.settings.mail.ajax.list',
		'uses' => 'MailerController@ajaxMailData'
	]);
	Route::post('/ajax/update', [
		'as' => 'eac.portal.settings.mail.notification-mail.ajax',
		'uses' => 'MailerController@ajaxUpdate',
	]);

	Route::get('/create', [
		'as' => 'eac.portal.settings.mail.create',
		'uses' => 'MailerController@create',
	]);

	Route::post('/create', [
		'as' => 'eac.portal.settings.mail.create',
		'uses' => 'MailerController@postCreate'
	]);
	Route::get('/edit/{id}', [
		'as' => 'eac.portal.settings.mail.edit',
		'uses' => 'MailerController@edit',
	]);

	Route::post('/edit', [
		'as' => 'eac.portal.settings.mail.update',
		'uses' => 'MailerController@postEdit',
	]);
	Route::match(['get','post'],'ajax/delete', [
		'as' => 'mailType.ajaxDelete',
		'uses' => 'MailerController@ajaxMailDelete',
	]);
	Route::get('/log', [
		'as' => 'eac.portal.settings.mail.log',
		'uses' => 'MailerController@logMail',
	]);
});
