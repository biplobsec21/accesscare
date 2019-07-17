<?php

Route::group([
	'prefix' => '/pharmacist',
	'namespace' => 'Rid',
	'middleware' => [
		'auth'
	],
], function () {
	Route::get('/list/all', [
		'as' => 'eac.portal.pharmacist.list.all',
		'uses' => 'PharmacistController@index',
	]);
	Route::get('/create', [
		'as' => 'eac.portal.pharmacist.create',
		'uses' => 'PharmacistController@create',
	]);
	Route::get('/edit/{id}', [
		'as' => 'eac.portal.pharmacist.edit',
		'uses' => 'PharmacistController@edit',
	]);

	Route::post('/store', [
		'as' => 'eac.portal.pharmacist.store',
		'uses' => 'PharmacistController@store',
	]);

	Route::post('/update/{id}', [
		'as' => 'eac.portal.pharmacist.update',
		'uses' => 'PharmacistController@update',
	]);


	Route::get('/ajaxlist', [
		'as' => 'eac.portal.pharmacist.ajaxlist',
		'uses' => 'PharmacistController@ajaxlist',
	]);
	Route::get('/ajaxlist/merge', [
		'as' => 'eac.portal.pharmacist.ajaxlistmerge',
		'uses' => 'PharmacistController@ajaxlistmerge',
	]);

	Route::get('/list/merge', [
		'as' => 'eac.portal.pharmacist.list.merge',
		'uses' => 'PharmacistController@merge',
	]);	
	Route::get('/status/{id}', [
		'as' => 'eac.portal.pharmacist.status',
		'uses' => 'PharmacistController@status',
	]);
	Route::post('/list/mergeselected', [
		'as' => 'eac.portal.pharmacist.list.mergeselect',
		'uses' => 'PharmacistController@mergeselected',
	]);
	Route::post('/list/mergepost', [
		'as' => 'eac.portal.pharmacist.list.mergepost',
		'uses' => 'PharmacistController@mergepost',
	]);
});
