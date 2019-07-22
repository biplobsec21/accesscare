<?php

/**
 * Geographical Settings
 */
// Route::get('/countries', [
// 	'as' => 'eac.portal.settings.manage.countries',
// 	'uses' => 'Country\\CountryController@index',
// ]);

// Route::get('/states', [
// 	'as' => 'eac.portal.settings.manage.states',
// 	'uses' => 'State\\StateController@index',
// ]);
Route::group(['prefix' => 'countries' ,'namespace' => 'Country','middleware' => 'auth'],function() {


	Route::resource('manage.geographical.country', 'CountryController', [
	  'only' => ['index', 'create', 'store', 'edit' ]
	]);
	Route::get('', ['as' => 'eac.portal.settings.manage.country.index', 'uses' => 'CountryController@index' ]);
	Route::get('create', ['as' => 'eac.portal.settings.manage.country.create', 'uses' => 'CountryController@create' ]);
	Route::post('store', ['as' => 'eac.portal.settings.manage.country.store', 'uses' => 'CountryController@store' ]);
	Route::get('edit/{id}', ['as' => 'eac.portal.settings.manage.country.edit', 'uses' => 'CountryController@edit' ]);
	Route::post('update/{id}', ['as' => 'eac.portal.settings.manage.country.update', 'uses' => 'CountryController@update' ]);
	Route::match(['get','post'],'delete', ['as' => 'eac.portal.settings.manage.countrydelete', 'uses' => 'CountryController@delete' ]);
	Route::match(['get','post'],'ajaxList', ['as' => 'eac.portal.settings.manage.country.ajaxlist', 'uses' => 'CountryController@ajaxlist' ]);
	Route::match(['get','post'],'logcountry',['as' => 'eac.portal.settings.manage.country.logcountry', 'uses' => 'CountryController@logcountry' ]);
	Route::match(['get','post'],'indexes',['as' => 'eac.portal.settings.manage.country.indexes', 'uses' => 'CountryController@manageindexes' ]);
	Route::match(['get','post'],'indexstore',['as' => 'eac.portal.settings.manage.country.indexes.store', 'uses' => 'CountryController@storeindexes' ]);
	Route::get('countrylogview/{id}', ['as' => 'eac.portal.settings.manage.country.countrylogview', 'uses' => 'CountryController@countrylogview' ]);

});

Route::group(['prefix' => 'states' ,'namespace' => 'State','middleware' => 'auth'],function() {


	Route::resource('manage.geographical.states', 'StateController', [
	  'only' => ['index', 'create', 'store', 'edit','loglist' ]
	]);
	Route::get('', ['as' => 'eac.portal.settings.manage.states.index', 'uses' => 'StateController@index' ]);
	Route::get('create', ['as' => 'eac.portal.settings.manage.states.create', 'uses' => 'StateController@create' ]);
	Route::post('store', ['as' => 'eac.portal.settings.manage.states.store', 'uses' => 'StateController@store' ]);
	Route::get('edit/{id}', ['as' => 'eac.portal.settings.manage.states.edit', 'uses' => 'StateController@edit' ]);
	Route::post('update/{id}', ['as' => 'eac.portal.settings.manage.states.update', 'uses' => 'StateController@update' ]);
	Route::match(['get','post'],'delete', ['as' => 'eac.portal.settings.manage.statesdelete', 'uses' => 'StateController@delete' ]);
	Route::match(['get','post'],'ajaxList', ['as' => 'eac.portal.settings.manage.states.ajaxlist', 'uses' => 'StateController@ajaxlist' ]);
	Route::match(['get','post'],'loglist',['as' => 'eac.portal.settings.manage.states.loglist', 'uses' => 'StateController@loglist' ]);
	Route::get('statelogview/{id}', ['as' => 'eac.portal.settings.manage.states.statelogview', 'uses' => 'StateController@statelogview' ]);

});

Route::group(['prefix' => 'ethnicity' ,'namespace' => 'Ethnicity','middleware' => 'auth'],function() {

	Route::resource('manage.geographical.ethnicity', 'EthnicityController', [
	  'only' => ['index', 'create', 'store', 'edit','loglist' ]
	]);
	Route::get('', ['as' => 'eac.portal.settings.manage.ethnicity.index', 'uses' => 'EthnicityController@index' ]);
	Route::get('create', ['as' => 'eac.portal.settings.manage.ethnicity.create', 'uses' => 'EthnicityController@create' ]);
	Route::post('store', ['as' => 'eac.portal.settings.manage.ethnicity.store', 'uses' => 'EthnicityController@store' ]);
	Route::get('edit/{id}', ['as' => 'eac.portal.settings.manage.ethnicity.edit', 'uses' => 'EthnicityController@edit' ]);
	Route::post('update/{id}', ['as' => 'eac.portal.settings.manage.ethnicity.update', 'uses' => 'EthnicityController@update' ]);
	Route::match(['get','post'],'delete', ['as' => 'eac.portal.settings.manage.ethnicitydelete', 'uses' => 'EthnicityController@delete' ]);
	Route::match(['get','post'],'ajaxList', ['as' => 'eac.portal.settings.manage.ethnicity.ajaxlist', 'uses' => 'EthnicityController@ajaxlist' ]);
	Route::match(['get','post'],'loglist',['as' => 'eac.portal.settings.manage.ethnicity.loglist', 'uses' => 'EthnicityController@loglist' ]);
	Route::get('ethnicityview/{id}', ['as' => 'eac.portal.settings.manage.ethnicity.statelogview', 'uses' => 'EthnicityController@statelogview' ]);

});

