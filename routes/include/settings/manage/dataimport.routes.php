<?php

/**
 * Data Import
 */

// Route::group(['prefix' => 'live_data_import' ,'namespace' => 'Dataimport'],function() {

// 	Route::get('', ['as' => 'eac.portal.settings.manage.dataimport.index', 'uses' => 'LiveDataImportController@index' ]);
// });


Route::group(['prefix' => 'live_data_import' ,'namespace' => 'Dataimport'],function() {
	Route::get('', ['as' => 'eac.portal.settings.manage.dataimport.index', 'uses' => 'LiveDataImportController@index' ]);
	Route::match(['get','post'],'handle_db', ['as' => 'eac.portal.settings.manage.dataimport.handle_db', 'uses' => 'LiveDataImportController@migration_db' ]);
	// Route::match(['get','post'],'country_state', ['as' => 'eac.portal.settings.manage.dataimport.country_state', 'uses' => 'LiveDataImportController@country_state_ajax' ]);
	// Route::match(['get','post'],'pages_companies_ajax_call', ['as' => 'eac.portal.settings.manage.dataimport.pages_companies_ajax_call', 'uses' => 'LiveDataImportController@pages_companies_ajax_call' ]);

});
