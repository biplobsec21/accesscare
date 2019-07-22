<?php

/**
 * User Settings
 */

Route::group([
	'namespace' => 'User',
	'prefix' => '/user'
], function () {
	Route::get('/role', [
		'as' => 'eac.portal.settings.manage.user.role',
		'uses' => '\\App\\Http\\Controllers\\User\\RoleController@index',
	]);
	Route::get('/role/create', [
		'as' => 'eac.portal.settings.manage.user.role.create',
		'uses' => '\\App\\Http\\Controllers\\User\\RoleController@create',
	]);
	Route::get('/role/permission/edit/{id}', [
		'as' => 'eac.portal.settings.manage.user.role.edit',
		'uses' => '\\App\\Http\\Controllers\\User\\RoleController@edit',
	]);
	Route::post('/role/store', [
		'as' => 'eac.portal.settings.manage.user.role.store',
		'uses' => '\\App\\Http\\Controllers\\User\\RoleController@store',
	]);
	Route::post('/role/save', [
		'as' => 'eac.portal.settings.manage.user.role.save',
		'uses' => '\\App\\Http\\Controllers\\User\\RoleController@update',
	]);
});
