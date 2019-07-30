<?php

/**
 * Settings Routes
 */
Route::group([
	'prefix' => 'settings',
	'namespace' => 'Settings',
], function () {

	Route::get('/', [
		'as' => 'eac.portal.settings',
		'uses' => 'SettingsController@index',
	]);
    Route::post('/dataTables/{model}', [
        'as' => 'eac.portal.settings.dataTables',
        'uses' => 'SettingsController@responseDT',
    ]);
	Route::view('/mockup', 'portal.settings.mockup');

	Route::group([
		'prefix' => '/manage',
		'namespace' => 'Manage',
	], function () {

		Route::view('/status/index', 'portal.settings.manage.status.index');
		/**
		 * Permissions Settings
		 */
		require_once(__DIR__ . '/manage/user.routes.php');

		/**
		 * RID Settings
		 */
		require_once(__DIR__ . '/manage/rid.routes.php');

		/**
		 * Drug Settings
		 */
		require_once(__DIR__ . '/manage/drug.routes.php');

		/**
		 * Document Settings
		 */
		require_once(__DIR__ . '/manage/document.routes.php');

		/**
		 * Mail Settings
		 */
		require_once(__DIR__ . '/manage/mail.routes.php');

		/**
		 * Geographical Settings
		 */
		require_once(__DIR__ . '/manage/geographical.routes.php');
		/**
		 * Data Import
		 */
		require_once(__DIR__ . '/manage/dataimport.routes.php');
		/**
		 * web site
		 */
		require_once(__DIR__ . '/manage/website.routes.php');
	});
}); // end settings
