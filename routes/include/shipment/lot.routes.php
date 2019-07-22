<?php

Route::group([
	'prefix' => '/lot',
	'namespace' => 'Drug',
	'middleware' => [
		'auth'
	],
], function () {
	Route::get('/list/all', [
		'as' => 'eac.portal.lot.list.all',
		'uses' => 'DrugLotController@index',
	]);
	Route::get('/create', [
		'as' => 'eac.portal.lot.create',
		'uses' => 'DrugLotController@create',
	]);
	Route::get('/edit/{id}', [
		'as' => 'eac.portal.lot.edit',
		'uses' => 'DrugLotController@edit',
	]);
	Route::post('/info', [
		'as' => 'eac.portal.lot.info',
		'uses' => 'DrugLotController@inform',
	]);
	Route::post('/store', [
		'as' => 'eac.portal.lot.store',
		'uses' => 'DrugLotController@store',
	]);
	Route::post('/edit/{id}', [
		'as' => 'eac.portal.lot.update',
		'uses' => 'DrugLotController@update',
	]);
	Route::post('/delete', [
		'as' => 'eac.portal.lot.delete',
		'uses' => 'DrugLotController@delete',
	]);
	Route::get('/ajaxlist', [
		'as' => 'eac.portal.lot.ajaxlist',
		'uses' => 'DrugLotController@ajaxlist',
	]);
	Route::get('/ajaxlistmerge', [
		'as' => 'eac.portal.lot.ajaxlistmerge',
		'uses' => 'DrugLotController@ajaxlistmerge',
	]);

	Route::get('/list/merge', [
		'as' => 'eac.portal.lot.list.merge',
		'uses' => 'DrugLotController@merge',
	]);
	Route::post('/list/mergeselected', [
		'as' => 'eac.portal.lot.mergeselect',
		'uses' => 'DrugLotController@mergeselected',
	]);
	Route::post('/list/mergepost', [
		'as' => 'eac.portal.lot.list.mergepost',
		'uses' => 'DrugLotController@mergepost',
	]);
	Route::post('/ajax/getDosage', [
		'as' => 'eac.portal.lot.get.dosage',
		'uses' => 'DrugLotController@getDosage',
	]);

});
