<?php

Route::group([
	'prefix' => '/pharmacy',
	'namespace' => 'Rid',
	'middleware' => [
		'auth'
	],
], function () {
	Route::get('/list/all', [
		'as' => 'eac.portal.pharmacy.list.all',
		'uses' => 'PharmacyController@index',
	]);
	Route::get('/create', [
		'as' => 'eac.portal.pharmacy.create',
		'uses' => 'PharmacyController@create',
	]);
	Route::get('/edit/{id}', [
		'as' => 'eac.portal.pharmacy.edit',
		'uses' => 'PharmacyController@edit',
	]);
	Route::post('/info', [
		'as' => 'eac.portal.pharmacy.info',
		'uses' => 'PharmacyController@inform',
	]);
	Route::post('/store', [
		'as' => 'eac.portal.pharmacy.store',
		'uses' => 'PharmacyController@store',
	]);
	Route::post('/edit/{id}', [
		'as' => 'eac.portal.pharmacy.update',
		'uses' => 'PharmacyController@update',
	]);

	//Need to Deprecate
	Route::post('/edit/save', [
		'as' => 'eac.portal.rid.edit.pharmacy.save',
		'uses' => 'PharmacyController@editPharmacy',
	]);

	Route::post('/ajaxlist', [
		'as' => 'eac.portal.pharmacy.ajaxlist',
		'uses' => 'PharmacyController@ajaxlist',
	]);
	Route::post('/ajaxlist/merge', [
		'as' => 'eac.portal.pharmacy.ajaxlistmerge',
		'uses' => 'PharmacyController@ajaxlistmerge',
	]);

	Route::get('/list/merge', [
		'as' => 'eac.portal.pharmacy.list.merge',
		'uses' => 'PharmacyController@merge',
	]);
	Route::post('/list/mergeselected', [
		'as' => 'eac.portal.pharmacy.list.mergeselect',
		'uses' => 'PharmacyController@mergeselected',
	]);
	Route::post('/list/mergepost', [
		'as' => 'eac.portal.pharmacy.list.mergepost',
		'uses' => 'PharmacyController@mergepost',
	]);
	Route::get('/show/{id}', [
		'as' => 'eac.portal.pharmacy.show',
		'uses' => 'PharmacyController@show',
	]);
	Route::post('/pharmacystatus', [
		'as' => 'eac.portal.pharmacy.status.change',
		'uses' => 'PharmacyController@pharmacystatus',
	]);

	Route::get('/getpharmacistajaxlist', [
		'as' => 'eac.portal.pharmacy.getpharmacistajaxlist',
		'uses' => 'PharmacyController@getpharmacistajaxlist',
	]);
	Route::post('/assignePharmacist', [
		'as' => 'eac.portal.pharmacy.assign.pharmacist',
		'uses' => 'PharmacyController@assignPharmacist',
	]);
	Route::post('/newpharmacist', [
		'as' => 'eac.portal.pharmacy.newpharmacist',
		'uses' => 'PharmacyController@newpharmacist',
	]);

	Route::get('/pharmacistremove', [
		'as' => 'eac.portal.pharmacy.pharmacistremove',
		'uses' => 'PharmacyController@pharmacistremove',
	]);

});
