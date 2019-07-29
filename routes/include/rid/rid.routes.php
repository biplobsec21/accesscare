<?php

Route::group([
	'prefix' => '/rid',
	'namespace' => 'Rid',
	'middleware' => [
		'auth'
	],
], function () {
	Route::get('/create', [
		'as' => 'eac.portal.rid.create',
		'uses' => 'RidController@create'
	]);

	Route::post('/review', [
		'as' => 'eac.portal.rid.review',
		'uses' => 'RidController@review'
	]);

	Route::post('/update/auto', [
		'as' => 'eac.portal.rid.store.auto',
		'uses' => 'RidController@autoUpdate'
	]);

	Route::post('/patient/DOB', [
		'as' => 'eac.portal.rid.patient.DOB',
		'uses' => 'RidController@setDOB'
	]);

	Route::get('/show/{id}', [
		'as' => 'eac.portal.rid.show',
		'uses' => 'RidController@show',
	]);
	Route::post('/readnotification', [
		'as' => 'eac.portal.rid.readnotification',
		'uses' => 'RidController@readNotification',
	]);

	Route::post('/ajax/list', [
		'as' => 'eac.portal.rid.ajax.list',
		'uses' => 'RidController@ajaxRidData'
	]);
	Route::match(['post', 'get'], '/ajax/newlist', [
		'as' => 'eac.portal.rid.ajax.newRidlist',
		'uses' => 'RidController@ajaxNewRidData'
	]);
	/**
	 * Rid awaiting list
	 */
	Route::post('/ajax/ridawaitinglist', [
		'as' => 'eac.portal.rid.ajax.ridawaitinglist',
		'uses' => 'RidController@ridawaitinglist'
	]);

	Route::post('/store', [
		'as' => 'eac.portal.rid.store',
		'uses' => 'RidController@store'
	]);

	Route::get('/list', [
		'as' => 'eac.portal.rid.list',
		'uses' => 'RidController@index',
	]);

	Route::get('/edit/{id}', [
		'as' => 'eac.portal.rid.edit',
		'uses' => 'RidController@edit',
	]);
	Route::get('basic/edit/{id}', [
		'as' => 'eac.portal.rid.basicedit',
		'uses' => 'RidController@basicedit',
	]);
	Route::post('/basicstore', [
		'as' => 'eac.portal.rid.basicstore',
		'uses' => 'RidController@basicstore'
	]);
	Route::post('/updateColors', [
		'as' => 'eac.portal.rid.badge.update',
		'uses' => 'RidController@updateColors'
	]);
	Route::get('/edit/visit/{id}', [
		'as' => 'eac.portal.rid.visit.edit',
		'uses' => 'RidVisitController@edit',
	]);
	Route::get('/edit/shipment/{id}', [
		'as' => 'eac.portal.rid.shipment.edit',
		'uses' => 'RidShipmentController@edit',
	]);

	Route::match(['get', 'post'], '/deny/{id}', [
		'as' => 'eac.portal.rid.deny',
		'uses' => 'RidController@deny'
	]);
	Route::match(['get', 'post'], '/approve/{id}', [
		'as' => 'eac.portal.rid.approve',
		'uses' => 'RidController@approve'
	]);

	Route::get('/resupply/{id}', [
		'as' => 'eac.portal.rid.resupply',
		'uses' => 'RidController@resupply',
	]);
	Route::post('/resupply/store', [
		'as' => 'eac.portal.rid.resupply.store',
		'uses' => 'RidController@storeResupply'
	]);
	Route::post('/supply/update', [
		'as' => 'eac.portal.rid.supply.update',
		'uses' => 'RidController@updateSupply'
	]);
	Route::post('/edit/save', [
		'as' => 'eac.portal.rid.edit.save',
		'uses' => 'RidController@writeDB',
	]);

	Route::post('/edit/reason/save', [
		'as' => 'eac.portal.rid.edit.reason.save',
		'uses' => 'RidController@editReason',
	]);

	Route::post('/edit/status/save', [
		'as' => 'eac.portal.rid.edit.status.save',
		'uses' => 'RidController@setStatus',
	]);
	Route::post('/visit/edit/status/save', [
		'as' => 'eac.portal.rid.visit.edit.status.save',
		'uses' => 'RidVisitController@setStatus',
	]);

	/**
	 * Rid Treatment Routes
	 */
	Route::post('/edit/treatment_plan/save', [
		'as' => 'eac.portal.rid.edit.treatment_plan.save',
		'uses' => 'RidController@editTreatmentPlan',
	]);

	/**
	 * Rid Regimen Routes
	 */
	Route::post('/modal/dosage/save', [
		'as' => 'eac.portal.rid.edit.regimen.save',
		'uses' => 'RidRegimenController@update',
	]);
	Route::post('/modal/dosage/create', [
		'as' => 'eac.portal.rid.edit.regimen.create',
		'uses' => 'RidRegimenController@store',
	]);
	/**
	 * Shipment Routes
	 */
	Route::post('/edit/shipment/dates', [
		'as' => 'eac.portal.rid.shipment.dates.save',
		'uses' => 'RidShipmentController@updateDates',
	]);
	Route::post('/edit/shipment/info', [
		'as' => 'eac.portal.rid.shipment.info.save',
		'uses' => 'RidShipmentController@updateInfo',
	]);

	/**
	 * Pharmacy Routes
	 */
	Route::post('/new/pharmacy', [
		'as' => 'eac.portal.rid.pharmacy.store',
		'uses' => 'PharmacyController@store',
	]);
	Route::post('/edit/pharmacy', [
		'as' => 'eac.portal.rid.pharmacy.save',
		'uses' => 'PharmacyController@update',
	]);
	Route::post('/set/pharmacy', [
		'as' => 'eac.portal.rid.pharmacy.set',
		'uses' => 'PharmacyController@setPharmacy',
	]);
	Route::post('/set/pharmacist', [
		'as' => 'eac.portal.rid.pharmacist.set',
		'uses' => 'PharmacyController@setPharmacist',
	]);
	Route::post('/pharmacylist/all', [
		'as' => 'eac.portal.settings.manage.pharmacy.ajaxlist',
		'uses' => 'PharmacyController@ajaxlist',
	]);

	/**
	 * Document Routes
	 */
	Route::post('/modal/document/save', [
		'as' => 'eac.portal.rid.modal.document.save',
		'uses' => '\\App\\Http\\Controllers\\DocumentController@updateRidDoc',
	]);
	Route::post('/modal/document/create', [
		'as' => 'eac.portal.rid.modal.document.create',
		'uses' => '\\App\\Http\\Controllers\\DocumentController@storeRidUpload',
	]);
	Route::post('/modal/document/redacted', [
		'as' => 'eac.portal.rid.modal.document.redacted',
		'uses' => '\\App\\Http\\Controllers\\DocumentController@storeRedacted',
	]);
	Route::post('/modal/document/remove_file', [
		'as' => 'eac.portal.rid.modal.document.remove_file',
		'uses' => '\\App\\Http\\Controllers\\DocumentController@removeFile',
	]);
	Route::post('/modal/document/remove', [
		'as' => 'eac.portal.rid.modal.document.remove',
		'uses' => '\\App\\Http\\Controllers\\DocumentController@removeTemplate',
	]);
	Route::post('/document/required/update', [
		'as' => 'eac.portal.rid.document.required.update',
		'uses' => '\\App\\Http\\Controllers\\DocumentController@updateRequiredRidDoc',
	]);
	Route::post('/document/additional/store', [
		'as' => 'eac.portal.rid.document.additional.store',
		'uses' => '\\App\\Http\\Controllers\\DocumentController@storeRidForm',
	]);

	/**
	 * Rid User Routes
	 */
	Route::post('/modal/user/save', [
		'as' => 'eac.portal.rid.modal.user.save',
		'uses' => 'RidUserController@update',
	]);
	Route::post('/modal/user/create', [
		'as' => 'eac.portal.rid.modal.user.create',
		'uses' => 'RidUserController@store',
	]);
	Route::post('/modal/user/invite', [
		'as' => 'eac.portal.rid.modal.user.invite',
		'uses' => 'RidUserController@inviteUser',
	]);
	Route::get('/user/delete/{id}', [
		'as' => 'eac.portal.rid.user.delete',
		'uses' => 'RidUserController@destroy',
	]);

	/**
	 * Rid Team Routes
	 */
	Route::post('/modal/group/save', [
		'as' => 'eac.portal.rid.modal.group.save',
		'uses' => 'RidGroupController@store',
	]);
	Route::get('/group/unassign/{id}', [
		'as' => 'eac.portal.rid.group.destroy',
		'uses' => 'RidGroupController@destroy',
	]);

	/**
	 * Rid Status Routes
	 */
	Route::get('/ridstatus/{id}', [
		'as' => 'eac.portal.rid.ridstatus',
		'uses' => 'RidController@ridstatus',
	]);

	Route::post('/ajax/statuslist', [
		'as' => 'eac.portal.rid.ajax.statuslist',
		'uses' => 'RidController@statuslist'
	]);
	Route::get('/change/staus/{rid_id}/{status}', [
		'as' => 'eac.portal.rid.changestatus',
		'uses' => 'RidController@changestatus',
	]);

// Rid Post Approval Document

	Route::get('/post/review/{id}', [
		'as' => 'eac.portal.rid.postreview',
		'uses' => 'RidController@postreview',
	]);

	Route::post('/modal/review/doc/save', [
		'as' => 'eac.portal.rid.modal.review.doc.save',
		'uses' => 'RidController@reviewdocstore',
	]);

	Route::post('/modal/review/doc/delete', [
		'as' => 'eac.portal.rid.modal.review.doc.delete',
		'uses' => 'RidController@reviewdocdelete',
	]);
// End Rid Post Approval Document
	Route::post('/modal/rid/reassign/save', [
		'as' => 'eac.portal.rid.visit.edit.reassign.save',
		'uses' => 'RidController@reassign',
	]);
	
});

Route::group([
	'namespace' => 'Documentupload',
	'prefix' => '/documentup'
], function () {
	Route::get('/documentup', [
		'as' => 'redacted.document.uploadFile',
		'uses' => 'RidController@fileupload',
	]);
});
