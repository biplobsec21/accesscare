<?php

Route::group(['prefix' => 'website' ,'namespace' => 'Website','middleware' => 'auth'],function() {

/* ---- Website menu ---- */
Route::resource('website.menu', 'WebsiteMenuController', [
  'only' => ['index', 'create', 'store', 'edit' ]
]);
Route::get('menu', ['as' => 'eac.portal.settings.manage.website.menu.index', 'uses' => 'WebsiteMenuController@index' ]);
Route::get('menu/create', ['as' => 'eac.portal.settings.manage.website.menu.create', 'uses' => 'WebsiteMenuController@create' ]);
Route::post('menu/store', ['as' => 'eac.portal.settings.manage.website.menu.store', 'uses' => 'WebsiteMenuController@store' ]);
Route::get('menu/edit/{id}', ['as' => 'eac.portal.settings.manage.website.menu.edit', 'uses' => 'WebsiteMenuController@edit' ]);
Route::post('menu/update/{id}', ['as' => 'eac.portal.settings.manage.website.menu.update', 'uses' => 'WebsiteMenuController@update' ]);
Route::match(['get','post'],'menudelete', ['as' => 'eac.portal.settings.manage.website.menudelete', 'uses' => 'WebsiteMenuController@delete' ]);
Route::match(['get','post'],'menu/ajaxList', ['as' => 'eac.portal.settings.manage.website.menu.ajaxlist', 'uses' => 'WebsiteMenuController@ajaxlist' ]);
Route::match(['get','post'],'menu/logs', ['as' => 'eac.portal.settings.manage.website.menu.logs', 'uses' => 'WebsiteMenuController@logs' ]);
Route::match(['get','post'],'menu/logsview/{id}', ['as' => 'eac.portal.settings.manage.website.menu.logsview', 'uses' => 'WebsiteMenuController@logsview' ]);

/* ---- Website page ---- */
Route::resource('website.page', 'WebsitePageController', [
  'only' => ['index', 'create', 'store', 'edit' ]
]);
Route::get('page', ['as' => 'eac.portal.settings.manage.website.page.index', 'uses' => 'WebsitePageController@index' ]);
Route::get('page/create', ['as' => 'eac.portal.settings.manage.website.page.create', 'uses' => 'WebsitePageController@create' ]);
Route::post('page/store', ['as' => 'eac.portal.settings.manage.website.page.store', 'uses' => 'WebsitePageController@store' ]);
Route::get('page/edit/{id}', ['as' => 'eac.portal.settings.manage.website.page.edit', 'uses' => 'WebsitePageController@edit' ]);
Route::post('page/update/{id}', ['as' => 'eac.portal.settings.manage.website.page.update', 'uses' => 'WebsitePageController@update' ]);
Route::match(['get','post'],'pagedelete', ['as' => 'eac.portal.settings.manage.website.pagedelete', 'uses' => 'WebsitePageController@delete' ]);
Route::match(['get','post'],'page/ajaxList', ['as' => 'eac.portal.settings.manage.website.page.ajaxlist', 'uses' => 'WebsitePageController@ajaxlist' ]);
Route::match(['get','post'],'page/logs', ['as' => 'eac.portal.settings.manage.website.page.logs', 'uses' => 'WebsitePageController@logs' ]);
Route::match(['get','post'],'page/logsview/{id}', ['as' => 'eac.portal.settings.manage.website.page.logsview', 'uses' => 'WebsitePageController@logsview' ]);
Route::match(['get','post'],'page/detail/{id}', ['as' => 'eac.portal.settings.manage.website.page.detail', 'uses' => 'WebsitePageController@detail' ]);
/* ---- Website properties ---- */
Route::resource('website.properties', 'WebsitePropertiesController', [
  'only' => ['index', 'create', 'store', 'edit' ]
]);
Route::get('properties', ['as' => 'eac.portal.settings.manage.website.properties.index', 'uses' => 'WebsitePropertiesController@index']);
Route::match(['get','post'],'properties/ajaxList', ['as' => 'eac.portal.settings.manage.website.properties.ajaxlist', 'uses' => 'WebsitePropertiesController@propAjaxlist']);
Route::get('properties/create', ['as' => 'eac.portal.settings.manage.website.properties.create', 'uses' => 'WebsitePropertiesController@create' ]);
Route::match(['get','post'],'properties/show/{id}', ['as' => 'eac.portal.settings.manage.website.properties.show', 'uses' => 'WebsitePropertiesController@detail' ]);
Route::get('properties/edit/{id}', ['as' => 'eac.portal.settings.manage.website.properties.edit', 'uses' => 'WebsitePropertiesController@edit' ]);
Route::post('properties/store', ['as' => 'eac.portal.settings.manage.website.properties.store', 'uses' => 'WebsitePropertiesController@store' ]);
Route::post('properties/update/{id}', ['as' => 'eac.portal.settings.manage.website.properties.update', 'uses' => 'WebsitePropertiesController@update' ]);
Route::post('properties/deletelogo', ['as' => 'eac.portal.settings.manage.website.properties.logo.delete', 'uses' => 'WebsitePropertiesController@logoDelete' ]);

});