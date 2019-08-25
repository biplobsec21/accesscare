<?php

Route::group([
	'prefix' => '/drug',
	'namespace' => 'Drug',
	'middleware' => [
		'auth'
	],
], function () {
	Route::get('/create', [
		'as' => 'eac.portal.drug.create',
		'uses' => 'DrugController@create'
	]);

	Route::post('/store', [
		'as' => 'eac.portal.drug.store',
		'uses' => 'DrugController@store'
	]);

	Route::get('/list', [
		'as' => 'eac.portal.drug.list',
		'uses' => 'DrugController@index',
	]);

	Route::get('/edit/{id}', [
		'as' => 'eac.portal.drug.edit',
		'uses' => 'DrugController@edit',
	]);
	// get document type document template
	Route::get('/documentTypeTemplate', [
		'as' => 'eac.portal.drug.documentTypeTemplate',
		'uses' => 'DrugController@getDocumentTypeTemplate',
	]);

	Route::post('/edit/save', [
		'as' => 'eac.portal.drug.edit.save',
		'uses' => 'DrugController@writeDB',
	]);

    Route::post('/update', [
        'as' => 'eac.portal.drug.update',
        'uses' => 'DrugController@update',
    ]);

	Route::post('/update/availibility', [
        'as' => 'eac.portal.drug.update.availibility',
        'uses' => 'DrugController@updateAvailibility',
    ]);

	Route::post('/modal/document/remove_file', [
		'as' => 'eac.portal.drug.modal.document.remove_file',
		'uses' => '\\App\\Http\\Controllers\\DocumentController@removeFile',
	]);

	Route::post('/modal/resource/remove_file', [
		'as' => 'eac.portal.drug.modal.resource.remove_file',
		'uses' => '\\App\\Http\\Controllers\\DocumentController@removeResourceFile',
	]);

	Route::post('/modal/document/deletefile', [
		'as' => 'eac.portal.drug.modal.document.deletefile',
		'uses' => '\\App\\Http\\Controllers\\DocumentController@deleteFile',
	]);

	Route::post('/modal/document/create', [
		'as' => 'eac.portal.drug.modal.document.create',
		'uses' => '\\App\\Http\\Controllers\\DocumentController@storeDrugDoc',
	]);
	Route::post('/modal/document/save', [
		'as' => 'eac.portal.drug.modal.document.save',
		'uses' => '\\App\\Http\\Controllers\\DocumentController@updateDrugDoc',
	]);
	Route::post('/modal/resource/create', [
		'as' => 'eac.portal.drug.modal.resource.create',
		'uses' => '\\App\\Http\\Controllers\\DocumentController@storeDrugResource',
	]);
	Route::post('/modal/resource/save', [
		'as' => 'eac.portal.drug.modal.resource.save',
		'uses' => '\\App\\Http\\Controllers\\DocumentController@updateResource',
	]);

	Route::post('/modal/dosage/save', [
		'as' => 'eac.portal.drug.modal.dosage.save',
		'uses' => 'DrugDosageController@update',
	]);
	Route::post('/modal/dosage/create', [
		'as' => 'eac.portal.drug.modal.dosage.create',
		'uses' => 'DrugDosageController@store',
	]);

	Route::post('/modal/component/create', [
		'as' => 'eac.portal.drug.modal.component.create',
		'uses' => 'DrugDosageController@storeComponent',
	]);
	Route::post('/modal/component/edit', [
		'as' => 'eac.portal.drug.modal.component.edit',
		'uses' => 'DrugDosageController@editComponent',
	]);
	
	Route::match(['get','post'],'delete', [
		'as' => 'eac.portal.drug.component.delete', 
		'uses' => 'DrugDosageController@deleteComponent' 
	]);
	Route::match(['get','post'],'remove', [
		'as' => 'eac.portal.drug.component.dosage.remove', 
		'uses' => 'DrugDosageController@deleteComponentDosage' 
	]);

	/*
	 * Drug Assigned Group Routes
	 */
	Route::post('/modal/group/save', [
		'as' => 'eac.portal.drug.modal.group.save',
		'uses' => 'DrugGroupController@store',
	]);
	Route::post('/modal/newgroup/save', [
		'as' => 'eac.portal.drug.modal.newgroup.save',
		'uses' => 'DrugGroupController@newgroupstore',
	]);
	Route::get('/group/unassign/{id}', [
		'as' => 'eac.portal.drug.group.destroy',
		'uses' => 'DrugGroupController@destroy',
	]);

	Route::get('/show/{id}', [
		'as' => 'eac.portal.drug.show',
		'uses' => 'DrugController@show',
	]);

	Route::match(['post', 'get'], '/ajax/list', [
		'as' => 'eac.portal.drug.ajax.list',
		'uses' => 'DrugController@ajaxDrugData'
	]);
	
	Route::get('/druginfo/{id}',[
		'as' => 'eac.portal.drug.druginfo',
		'uses' => 'DrugController@druginfo',
	]);
	Route::get('/drug/status/{status}/{id}',[
		'as' => 'eac.portal.drug.status.change',
		'uses' => 'DrugController@changestatus',
	]);
	
	Route::get('/druginfolist',[
		'as' => 'eac.portal.drug.druginfolist',
		'uses' => 'DrugController@druginfolist',
	]);
	Route::post('/supply/add', [
		'as' => 'eac.portal.drug.supply.add',
		'uses' => 'DrugController@addInterval',
	]);
	Route::post('/supply/remove', [
		'as' => 'eac.portal.drug.supply.remove',
		'uses' => 'DrugController@removeInterval',
	]);
	Route::post('/supply/load', [
		'as' => 'eac.portal.drug.supply.load',
		'uses' => 'DrugController@loadIntervals',
	]);
	Route::post('/drug/description/update/{id}', [
		'as' => 'eac.portal.drug.description.update',
		'uses' => 'DrugController@descriptionupdate'
	]);
	Route::post('/drug/image/update/{id}', [
		'as' => 'eac.portal.drug.image.update',
		'uses' => 'DrugController@imageupdate'
	]);
	Route::post('/modal/doc/update/{id}', [
		'as' => 'eac.portal.drug.doc.modal.update',
		'uses' => '\\App\\Http\\Controllers\\DocumentController@updateDrugDoc',
	]);
});
