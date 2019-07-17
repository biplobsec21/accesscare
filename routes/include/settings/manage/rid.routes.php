<?php

/**
 * Rid Settings
 */
//  Route::get('/courier', [
//   'as' => 'eac.portal.settings.manage.rid.shipment.courier.index',
//   'uses' => 'Rid\\ShippingCourierController@index',
//  ]);

// Route::post('/courier', [
//  'as' => 'eac.portal.settings.manage.rid.shipment.courier.save',
//  'uses' => 'Rid\\ShippingCourierController@ajaxUpdate',
// ]);

Route::group(['prefix' => 'courier' ,'namespace' => 'Rid','middleware' => 'auth'],function() {

	Route::resource('settings.shipment.courier.route', 'ShippingCourierController', [
	  'only' => ['index', 'create', 'store', 'edit' ]
	]);

	Route::get('/', ['as' => 'eac.portal.settings.manage.rid.shipment.courier.index', 'uses' => 'ShippingCourierController@index' ]);
	Route::get('create', ['as' => 'eac.portal.settings.manage.rid.shipment.courier.create', 'uses' => 'ShippingCourierController@create' ]);
	Route::post('store', ['as' => 'eac.portal.settings.manage.rid.shipment.courier.store', 'uses' => 'ShippingCourierController@store' ]);
	Route::get('edit/{id}', ['as' => 'eac.portal.settings.manage.rid.shipment.courier.edit', 'uses' => 'ShippingCourierController@edit' ]);
	Route::post('update/{id}', ['as' => 'eac.portal.settings.manage.rid.shipment.courier.update', 'uses' => 'ShippingCourierController@update' ]);
	Route::match(['get','post'],'courierdelete', ['as' => 'eac.portal.settings.manage.rid.shipment.courierdelete', 'uses' => 'ShippingCourierController@delete' ]);
	Route::match(['get','post'],'ajaxList', ['as' => 'eac.portal.settings.manage.rid.shipment.courier.ajaxlist', 'uses' => 'ShippingCourierController@ajaxlist' ]);
	Route::match(['get','post'],'loglist',['as' => 'eac.portal.settings.manage.shipment.courier.loglist', 'uses' => 'ShippingCourierController@loglist' ]);
	Route::get('courierlogview/{id}', ['as' => 'eac.portal.settings.manage.shipment.courierlogview', 'uses' => 'ShippingCourierController@logsview' ]);

});

//Route::get('/denial-reason-mgmt', [
// 'as' => 'eac.portal.settings.denial-reason-mgmt',
// 'uses' => function () {
// },
//]);
Route::group(['prefix' => 'denial' ,'namespace' => 'Rid','middleware' => 'auth'],function() {

	Route::resource('settings.denial.reason.route', 'DenialReasonController', [
	  'only' => ['index', 'create', 'store', 'edit' ]
	]);

	Route::get('/', ['as' => 'eac.portal.settings.manage.rid.denial.reason.index', 'uses' => 'DenialReasonController@index' ]);

	Route::match(['get','post'],'ajaxList', ['as' => 'eac.portal.settings.manage.rid.denial.reason.ajaxlist', 'uses' => 'DenialReasonController@ajaxlist' ]);

	Route::match(['get','post'],'denialreason', ['as' => 'eac.portal.settings.manage.rid.denial.reasondelete', 'uses' => 'DenialReasonController@delete' ]);
	Route::get('create', ['as' => 'eac.portal.settings.manage.rid.denial.reason.create', 'uses' => 'DenialReasonController@create' ]);
	Route::post('store', ['as' => 'eac.portal.settings.manage.rid.denial.reason.store', 'uses' => 'DenialReasonController@store' ]);
	Route::get('edit/{id}', ['as' => 'portal.settings.manage.rid.denial.reason.edit', 'uses' => 'DenialReasonController@edit' ]);
	Route::post('update/{id}', ['as' => 'eac.portal.settings.manage.rid.denial.reason.update', 'uses' => 'DenialReasonController@update' ]);
	Route::match(['get','post'],'loglist',['as' => 'eac.portal.settings.manage.rid.denial.reason.loglist', 'uses' => 'DenialReasonController@loglist' ]);
	Route::get('ridreasonlogview/{id}', ['as' => 'eac.portal.settings.manage.rid.denial.reason.ridreasonlogview', 'uses' => 'DenialReasonController@logsview' ]);

});
