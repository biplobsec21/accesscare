<?php

Route::group([
	'prefix' => '/company',
	'namespace' => 'Company',
	'middleware' => [
		'auth'
	],
], function () {
	Route::get('/list', [
		'as' => 'eac.portal.company.list',
		'uses' => 'CompanyController@listCompanies',
	]);

	Route::get('/create', [
		'as' => 'eac.portal.company.create',
		'uses' => 'CompanyController@create',
	]);

	Route::post('/create', [
		'as' => 'eac.portal.company.create',
		'uses' => 'CompanyController@postCreate',
	]);

	Route::get('/show/{id}', [
		'as' => 'eac.portal.company.show',
		'uses' => 'CompanyController@show',
	]);
	Route::get('/suspend/{id}', [
		'as' => 'eac.portal.company.suspend',
		'uses' => 'CompanyController@suspend',
	]);
	Route::get('/reactivate/{id}', [
		'as' => 'eac.portal.company.reactivate',
		'uses' => 'CompanyController@reactivate',
	]);
	Route::get('/approve/{id}', [
		'as' => 'eac.portal.company.approve',
		'uses' => 'CompanyController@approve',
	]);

	Route::get('/edit/{id}', [
		'as' => 'eac.portal.company.edit',
		'uses' => 'CompanyController@edit',
	]);
	Route::post('/update', [
		'as' => 'eac.portal.company.update',
		'uses' => 'CompanyController@updatestore',
	]);

	Route::post('/department/create', [
		'as' => 'eac.portal.company.department.create',
		'uses' => 'DepartmentController@store',
	]);

	Route::match(['get','post'],'delete', ['as' => 'eac.portal.company.department.delete', 'uses' => 'DepartmentController@delete' ]);

	Route::post('/department/update', [
		'as' => 'eac.portal.company.department.update',
		'uses' => 'DepartmentController@update',
	]);
	Route::post('/main/department/update', [
		'as' => 'eac.portal.company.main.department.deptupdate',
		'uses' => 'CompanyController@deptupdate',
	]);

	Route::delete('/delete/{id}', [
		'as' => 'eac.portal.company.delete',
		'uses' => 'CompanyController@delete',
	]);

	Route::post('/user/assign/group', [
		'as' => 'eac.portal.company.group.add',
		'uses' => 'CompanyController@assignUser',
	]);
	Route::get('/user/remove/group/{id}', [
		'as' => 'eac.portal.company.group.remove',
		'uses' => 'CompanyController@removeUser',
	]);

	/**
	 * Ajax Routes
	 */
	Route::match(['get', 'post'], '/ajax/list', [
		'as' => 'eac.portal.company.ajax.list',
		'uses' => 'CompanyController@ajaxCompanyData'
	]);

	Route::post('/ajax/{id}/userList', [
		'as' => 'eac.portal.company.ajax.userList',
		'uses' => 'CompanyController@ajaxUserList',
	]);

	Route::post('/ajax/{id}/rid/list', [
		'as' => 'eac.portal.company.ajax.rid.list',
		'uses' => 'CompanyController@ajaxAssociatedRids'
	]);

	Route::post('/ajax/{id}/drug/list', [
		'as' => 'eac.portal.company.ajax.drug.list',
		'uses' => 'CompanyController@ajaxDrugList'
	]);
	Route::post('desc/update', [
		'as' => 'eac.portal.company.desc.update',
		'uses' => 'CompanyController@updatedesc'
	]);
});
