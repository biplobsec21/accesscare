<?php

Route::group([
	'prefix' => '/user',
	'namespace' => 'User',
	'middleware' => [
		'auth'
	],
], function () {

	Route::get('/create', [
		'as' => 'eac.portal.user.create',
		'uses' => 'UserController@create',
	]);

	Route::post('/create', [
		'as' => 'eac.portal.user.create',
		'uses' => 'UserController@postCreate'
	]);

	Route::post('/sendCertificates', [
		'as' => 'eac.portal.user.certify.submit',
		'uses' => 'UserController@sendCertification'
	]);

	Route::get('/list', [
		'as' => 'eac.portal.user.list',
		'uses' => 'UserController@listUsers',
	]);

	Route::get('/show/{id}', [
		'as' => 'eac.portal.user.show',
		'uses' => 'UserController@show',
	]);

	Route::post('/status/approve/{id}', [
		'as' => 'eac.portal.user.changePassword',
		'uses' => 'UserController@changePassword',
	]);

	Route::get('/status/approve/{id}', [
		'as' => 'eac.portal.user.approve',
		'uses' => 'UserController@approve',
	]);

	Route::get('/status/pend/{id}', [
		'as' => 'eac.portal.user.pend',
		'uses' => 'UserController@pend',
	]);

	Route::get('/status/deny/{id}', [
		'as' => 'eac.portal.user.deny',
		'uses' => 'UserController@deny',
	]);

    Route::get('/status/welcomeEmail/{id}', [
        'as' => 'eac.portal.user.userWelcome',
        'uses' => 'UserController@userWelcome',
    ]);

	Route::get('/edit/{id}', [
		'as' => 'eac.portal.user.edit',
		'uses' => 'UserController@edit',
	]);

	Route::post('/edit/{id}', [
		'as' => 'eac.portal.user.edit',
		'uses' => 'UserController@postEdit',
	]);

	/*
	 * User Groups
	 */
	Route::get('/group/list', [
		'as' => 'eac.portal.user.group.list',
		'uses' => 'UserGroupController@list',
	]);
	Route::get('/group/create', [
		'as' => 'eac.portal.user.group.create',
		'uses' => 'UserGroupController@create',
	]);
	Route::post('/group/store', [
		'as' => 'eac.portal.user.group.store',
		'uses' => 'UserGroupController@store',
	]);
	Route::get('/group/add/{id}', [
		'as' => 'eac.portal.user.group.add',
		'uses' => 'UserGroupController@addMember',
	]);
	Route::get('/group/remove/{id}', [
		'as' => 'eac.portal.user.group.remove',
		'uses' => 'UserGroupController@removeMember',
	]);
	Route::get('/group/edit/{id}', [
		'as' => 'eac.portal.user.group.edit',
		'uses' => 'UserGroupController@edit',
	]);
	Route::post('/group/update/{id}', [
		'as' => 'eac.portal.user.group.update',
		'uses' => 'UserGroupController@update',
	]);
	Route::match(['get', 'post'], '/group/delete', [
		'as' => 'eac.portal.user.group.delete',
		'uses' => 'UserGroupController@ajaxDelete',
	]);
	Route::match(['get', 'post'], '/group/ajaxlist', [
		'as' => 'eac.portal.user.grouplist.ajaxlist',
		'uses' => 'UserGroupController@ajaxlist',
	]);

	/*
	 * User Role Permissions
	 */
	Route::get('/role/areas', [
		'as' => 'eac.portal.user.permission.manage.area',
		'uses' => 'RoleController@manageAreas',
	]);
	Route::post('/role/sections', [
		'as' => 'eac.portal.user.role.section',
		'uses' => 'RoleController@manageSections',
	]);
	Route::post('/role/update', [
		'as' => 'eac.portal.user.role.save',
		'uses' => 'RoleController@update',
	]);
//	Route::post('/app/role/{id}', [
//		'as' => 'eac.portal.user.role.save',
//		'uses' => 'PermissionsController@setAppRole',
//	]);
//	Route::post('/app/permission/save', [
//		'as' => 'eac.portal.user.permission.save',
//		'uses' => 'PermissionsController@setGlobalPermission',
//	]);
//	Route::post('/drug/role/save', [
//		'as' => 'eac.portal.user.drug.role.save',
//		'uses' => 'PermissionsController@setDrugRole',
//	]);
//	Route::post('/drug/permission/save', [
//		'as' => 'eac.portal.drug.permission.save',
//		'uses' => 'PermissionsController@setDrugPermission',
//	]);
//	Route::post('/rid/role/save', [
//		'as' => 'eac.portal.user.rid.role.save',
//		'uses' => 'PermissionsController@setRidRole',
//	]);
//	Route::post('/rid/permission/save', [
//		'as' => 'eac.portal.rid.permission.save',
//		'uses' => 'PermissionsController@setRidPermission',
//	]);

	/*
	 * Ability and Gate
	 */
	Route::post('/ability/save', [
		'as' => 'eac.portal.ability.save',
		'uses' => 'AbilityController@storeAbility',
	]);
	Route::post('/gate/save', [
		'as' => 'eac.portal.gate.save',
		'uses' => 'AbilityController@storeGate',
	]);

	/*
	 * Ajax
	 */
	Route::match(['post', 'get'], '/ajax/list', [
		'as' => 'eac.portal.user.ajax.list',
		'uses' => 'UserController@ajaxUserData'
	]);
	Route::post('/ajax/{id}/rid/list', [
		'as' => 'eac.portal.user.ajax.rid.list',
		'uses' => 'UserController@ajaxAssociatedRids'
	]);
	/*
	 * User Merge
	 */
	Route::post('/ajaxlistmerge', [
		'as' => 'eac.portal.user.ajaxlistmerge',
		'uses' => 'UserController@ajaxlistmerge',
	]);

	Route::get('/list/merge', [
		'as' => 'eac.portal.user.list.merge',
		'uses' => 'UserController@merge',
	]);
	Route::post('/list/mergeselected', [
		'as' => 'eac.portal.user.mergeselect',
		'uses' => 'UserController@mergeselected',
	]);
	Route::post('/list/mergepost', [
		'as' => 'eac.portal.user.list.mergepost',
		'uses' => 'UserController@mergepost',
	]);
});
