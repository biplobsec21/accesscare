<?php

/**
 * Document Settings
 */
Route::group([
	'namespace' => 'Document',
	'prefix' => '/document'
], function () {
	Route::get('/document', [
		'as' => 'eac.portal.settings.document',
		'uses' => 'DocumentController@index',
	]);

	Route::get('/type', [
		'as' => 'eac.portal.settings.document.type',
		'uses' => 'Type\\DocumentTypeController@index',
	]);
        
        Route::get('/type/create', [
		'as' => 'eac.portal.settings.document.type.create',
		'uses' => 'Type\\DocumentTypeController@create',
	]);
        Route::post('/type/store', [
		'as' => 'eac.portal.settings.document.type.stroe',
		'uses' => 'Type\\DocumentTypeController@store',
	]);  
        Route::get('/type/edit/{id}', [
		'as' => 'eac.portal.settings.document.type.edit',
		'uses' => 'Type\\DocumentTypeController@edit',
	]);
        Route::post('/type/update', [
		'as' => 'eac.portal.settings.document.type.update',
		'uses' => 'Type\\DocumentTypeController@update',
	]);
        Route::match(['get','post'],'/type/delete/{id}', [
		'as' => 'eac.portal.settings.document.type.delete',
		'uses' => 'Type\\DocumentTypeController@delete',
	]);
    Route::match(['get','post'],'/type/logs', [
		'as' => 'eac.portal.settings.document.type.logs',
		'uses' => 'Type\\DocumentTypeController@logs',
	]);
        Route::match(['get','post'],'/type/logs/{id}', [
		'as' => 'eac.portal.settings.document.type.logsview',
		'uses' => 'Type\\DocumentTypeController@logsview',
	]);
	Route::post('ajax/documentType/updateDB', [
		'as' => 'documentType.updateDB',
		'uses' => 'Type\\DocumentTypeController@ajaxUpdate',
	]);
	Route::match(['post', 'get'], 'ajax/documentType/deleteDB', [
		'as' => 'documentType.ajaxDelete',
		'uses' => 'Type\\DocumentTypeController@ajaxDelete',
	]);

	Route::get('/resource/type', [
		'as' => 'eac.portal.settings.document.resource.type.index',
		'uses' => 'Resource\\Type\\ResourceTypeController@index',
	]);
	Route::post('ajax/resourceType/updateDB', [
		'as' => 'eac.portal.setting.document.resource.type.ajax.updateDB',
		'uses' => 'Resource\\Type\\ResourceTypeController@ajaxUpdate',
	]);

	Route::match(['post', 'get'], '/ajax/list', [
		'as' => 'eac.portal.settings.manage.document.documentAjaxlist',
		'uses' => 'Type\\DocumentTypeController@documentAjaxlist'
	]);
});
