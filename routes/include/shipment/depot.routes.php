<?php

Route::group([
	'prefix' => '/depot',
	'namespace' => 'Drug',
	'middleware' => [
		'auth'
	],
], function () {
	Route::get('/list/all', [
		'as' => 'eac.portal.depot.list.all',
		'uses' => 'DrugDepotController@index',
	]);
	Route::get('/create', [
		'as' => 'eac.portal.depot.create',
		'uses' => 'DrugDepotController@create',
	]);
	Route::get('/edit/{id}', [
		'as' => 'eac.portal.depot.edit',
		'uses' => 'DrugDepotController@edit',
	]);
	Route::post('/info', [
		'as' => 'eac.portal.depot.info',
		'uses' => 'DrugDepotController@inform',
	]);
	Route::post('/store', [
		'as' => 'eac.portal.depot.store',
		'uses' => 'DrugDepotController@store',
	]);
	Route::get('/ajaxlist', [
		'as' => 'eac.portal.depot.ajaxlist',
		'uses' => 'DrugDepotController@ajaxlist',
	]);
	Route::post('/edit/{id}', [
		'as' => 'eac.portal.depot.update',
		'uses' => 'DrugDepotController@update',
	]);
	Route::get('/list/merge', [
		'as' => 'eac.portal.depot.list.merge',
		'uses' => 'DrugDepotController@merge',
	]);
	Route::post('/list/mergeselected', [
		'as' => 'eac.portal.depot.list.mergeselect',
		'uses' => 'DrugDepotController@mergeselected',
	]);
	Route::post('/list/mergepost', [
		'as' => 'eac.portal.depot.list.mergepost',
		'uses' => 'DrugDepotController@mergepost',
	]);
	Route::match(['get','post'],'remove', ['as' => 'eac.portal.depot.remove', 'uses' => 'DrugDepotController@remove' ]);
	
});
