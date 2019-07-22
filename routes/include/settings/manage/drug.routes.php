<?php

Route::group(['prefix' => 'drug' ,'namespace' => 'Drug','middleware' => 'auth'],function() {

/* ---- Drug Dosage ---- */
Route::resource('drug.dosage', 'DrugDosageController', [
  'only' => ['index', 'create', 'store', 'edit' ]
]);
Route::get('dosage', ['as' => 'eac.portal.settings.manage.drug.dosage.index', 'uses' => 'DrugDosageController@index' ]);
Route::get('dosage/create', ['as' => 'eac.portal.settings.manage.drug.dosage.create', 'uses' => 'DrugDosageController@create' ]);
Route::post('dosage/store', ['as' => 'eac.portal.settings.manage.drug.dosage.store', 'uses' => 'DrugDosageController@store' ]);
Route::get('dosage/edit/{id}', ['as' => 'eac.portal.settings.manage.drug.dosage.edit', 'uses' => 'DrugDosageController@edit' ]);
Route::post('dosage/update/{id}', ['as' => 'eac.portal.settings.manage.drug.dosage.update', 'uses' => 'DrugDosageController@update' ]);
Route::match(['get','post'],'dosagedelete', ['as' => 'eac.portal.settings.manage.drug.dosagedelete', 'uses' => 'DrugDosageController@delete' ]);
Route::match(['get','post'],'dosage/ajaxList', ['as' => 'eac.portal.settings.manage.drug.dosage.ajaxlist', 'uses' => 'DrugDosageController@ajaxlist' ]);
Route::match(['get','post'],'dosage/logs', ['as' => 'eac.portal.settings.manage.drug.dosage.logs', 'uses' => 'DrugDosageController@logs' ]);
Route::match(['get','post'],'dosage/logsview/{id}', ['as' => 'eac.portal.settings.manage.drug.dosage.logsview', 'uses' => 'DrugDosageController@logsview' ]);

Route::get('dosage/ajaxlistmerge', ['as' => 'eac.portal.settings.manage.drug.dosage.ajaxlistmerge','uses' => 'DrugDosageController@ajaxlistmerge',]);
Route::get('dosage/list/merge', ['as' => 'eac.portal.settings.manage.drug.dosage.list.merge','uses' => 'DrugDosageController@merge',]);
Route::post('dosage/list/mergeselected', ['as' => 'eac.portal.settings.manage.drug.dosage.mergeselect','uses' => 'DrugDosageController@mergeselected',]);
Route::post('dosage/list/mergepost', ['as' => 'eac.portal.settings.manage.drug.dosage.list.mergepost','uses' => 'DrugDosageController@mergepost',]);
/* ---- Drug Dosage Form ---- */
Route::resource('drug.dosage.form', 'DrugDosageFormController', [
  'only' => ['index', 'create', 'store', 'edit' ]
]);
Route::get('dosage/form', ['as' => 'eac.portal.settings.manage.drug.dosage.form.index', 'uses' => 'DrugDosageFormController@index' ]);
Route::get('dosage/form/create', ['as' => 'eac.portal.settings.manage.drug.dosage.form.create', 'uses' => 'DrugDosageFormController@create' ]);
Route::post('dosage/form/store', ['as' => 'eac.portal.settings.manage.drug.dosage.form.store', 'uses' => 'DrugDosageFormController@store' ]);
Route::get('dosage/form/edit/{id}', ['as' => 'eac.portal.settings.manage.drug.dosage.form.edit', 'uses' => 'DrugDosageFormController@edit' ]);
Route::post('dosage/form/update/{id}', ['as' => 'eac.portal.settings.manage.drug.dosage.form.update', 'uses' => 'DrugDosageFormController@update' ]);
Route::match(['get','post'],'dosage/formdelete', ['as' => 'eac.portal.settings.manage.drug.dosage.formdelete', 'uses' => 'DrugDosageFormController@delete' ]);
Route::match(['get','post'],'dosage/form/ajaxList', ['as' => 'eac.portal.settings.manage.drug.dosage.form.ajaxlist', 'uses' => 'DrugDosageFormController@ajaxlist' ]);
Route::match(['get','post'],'dosage/form/logs', ['as' => 'eac.portal.settings.manage.drug.dosage.form.logs', 'uses' => 'DrugDosageFormController@logs' ]);
Route::match(['get','post'],'dosage/form/logsview/{id}', ['as' => 'eac.portal.settings.manage.drug.dosage.form.logsview', 'uses' => 'DrugDosageFormController@logsview' ]);


/* ---- Drug Dosage Strength ---- */
Route::resource('drug.dosage.strength', 'DrugDosageStrengthController', [
  'only' => ['index', 'create', 'store', 'edit' ]
]);

Route::get('dosage/strength', ['as' => 'eac.portal.settings.manage.drug.dosage.strength.index', 'uses' => 'DrugDosageStrengthController@index' ]);
Route::get('dosage/strength/create', ['as' => 'eac.portal.settings.manage.drug.dosage.strength.create', 'uses' => 'DrugDosageStrengthController@create' ]);
Route::post('dosage/strength/store', ['as' => 'eac.portal.settings.manage.drug.dosage.strength.store', 'uses' => 'DrugDosageStrengthController@store' ]);
Route::get('dosage/strength/edit/{id}', ['as' => 'eac.portal.settings.manage.drug.dosage.strength.edit', 'uses' => 'DrugDosageStrengthController@edit' ]);
Route::post('dosage/strength/update/{id}', ['as' => 'eac.portal.settings.manage.drug.dosage.strength.update', 'uses' => 'DrugDosageStrengthController@update' ]);
Route::match(['get','post'],'dosage/strengthdelete', ['as' => 'eac.portal.settings.manage.drug.dosage.strengthdelete', 'uses' => 'DrugDosageStrengthController@delete' ]);
Route::match(['get','post'],'dosage/strength/ajaxList', ['as' => 'eac.portal.settings.manage.drug.dosage.strength.ajaxlist', 'uses' => 'DrugDosageStrengthController@ajaxlist' ]);
Route::match(['get','post'],'dosage/strength/logs', ['as' => 'eac.portal.settings.manage.drug.dosage.strength.logs', 'uses' => 'DrugDosageStrengthController@logs' ]);
Route::match(['get','post'],'dosage/strength/logsview/{id}', ['as' => 'eac.portal.settings.manage.drug.dosage.strength.logsview', 'uses' => 'DrugDosageStrengthController@logsview' ]);


/* ---- Drug Dosage Strength ---- */
Route::resource('drug.dosage.concentration', 'DrugDosageConcentrationController', [
  'only' => ['index', 'create', 'store', 'edit' ]
]);

Route::get('dosage/concentration', ['as' => 'eac.portal.settings.manage.drug.dosage.concentration.index', 'uses' => 'DrugDosageConcentrationController@index' ]);
Route::get('dosage/concentration/create', ['as' => 'eac.portal.settings.manage.drug.dosage.concentration.create', 'uses' => 'DrugDosageConcentrationController@create' ]);
Route::post('dosage/concentration/store', ['as' => 'eac.portal.settings.manage.drug.dosage.concentration.store', 'uses' => 'DrugDosageConcentrationController@store' ]);
Route::get('dosage/concentration/edit/{id}', ['as' => 'eac.portal.settings.manage.drug.dosage.concentration.edit', 'uses' => 'DrugDosageConcentrationController@edit' ]);
Route::post('dosage/concentration/update/{id}', ['as' => 'eac.portal.settings.manage.drug.dosage.concentration.update', 'uses' => 'DrugDosageConcentrationController@update' ]);
Route::match(['get','post'],'dosage/concentrationdelete', ['as' => 'eac.portal.settings.manage.drug.dosage.concentrationdelete', 'uses' => 'DrugDosageConcentrationController@delete' ]);
Route::match(['get','post'],'dosage/concentration/ajaxList', ['as' => 'eac.portal.settings.manage.drug.dosage.concentration.ajaxlist', 'uses' => 'DrugDosageConcentrationController@ajaxlist' ]);
Route::match(['get','post'],'dosage/concentration/logs', ['as' => 'eac.portal.settings.manage.drug.dosage.concentration.logs', 'uses' => 'DrugDosageConcentrationController@logs' ]);
Route::match(['get','post'],'dosage/concentration/logsview/{id}', ['as' => 'eac.portal.settings.manage.drug.dosage.concentration.logsview', 'uses' => 'DrugDosageConcentrationController@logsview' ]);


/* ---- Drug Dosage Strength ---- */
Route::resource('drug.dosage.route', 'DrugDosageRouteController', [
  'only' => ['index', 'create', 'store', 'edit' ]
]);

Route::get('dosage/route', ['as' => 'eac.portal.settings.manage.drug.dosage.route.index', 'uses' => 'DrugDosageRouteController@index' ]);
Route::get('dosage/route/create', ['as' => 'eac.portal.settings.manage.drug.dosage.route.create', 'uses' => 'DrugDosageRouteController@create' ]);
Route::post('dosage/route/store', ['as' => 'eac.portal.settings.manage.drug.dosage.route.store', 'uses' => 'DrugDosageRouteController@store' ]);
Route::get('dosage/route/edit/{id}', ['as' => 'eac.portal.settings.manage.drug.dosage.route.edit', 'uses' => 'DrugDosageRouteController@edit' ]);
Route::post('dosage/route/update/{id}', ['as' => 'eac.portal.settings.manage.drug.dosage.route.update', 'uses' => 'DrugDosageRouteController@update' ]);
Route::match(['get','post'],'dosage/routedelete', ['as' => 'eac.portal.settings.manage.drug.dosage.routedelete', 'uses' => 'DrugDosageRouteController@delete' ]);
Route::match(['get','post'],'dosage/route/ajaxList', ['as' => 'eac.portal.settings.manage.drug.dosage.route.ajaxlist', 'uses' => 'DrugDosageRouteController@ajaxlist' ]);
Route::match(['get','post'],'dosage/route/logs', ['as' => 'eac.portal.settings.manage.drug.dosage.route.logs', 'uses' => 'DrugDosageRouteController@logs' ]);
Route::match(['get','post'],'dosage/route/logsview/{id}', ['as' => 'eac.portal.settings.manage.drug.dosage.route.logsview', 'uses' => 'DrugDosageRouteController@logsview' ]);


});