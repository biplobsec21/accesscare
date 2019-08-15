<?php

Route::post('ajax/country/updateDB', [
	'as' => 'country.updateDB',
	'uses' => 'CountryController@ajaxUpdate',
]);
Route::post('ajax/document/updateDB', [
	'as' => 'document.updateDB',
	'uses' => 'DocumentController@ajaxUpdate',
]);

/**
 * Portal Routes
 */
Route::group([
	'prefix' => '/portal',
	'middleware' => 'auth'
], function () {
	Route::get('/dashboard', [
		'as' => 'eac.portal.getDashboard',
		'uses' => 'DashboardController@index',
	]);
	Route::get('/notifications/{id}', [
		'as' => 'eac.portal.notifications.read.all',
		'uses' => 'DashboardController@notificationAllRead',
	]);

	Route::match(['post', 'get'], '/notification/single', [
		'as' => 'eac.portal.notifications.read.single',
		'uses' => 'DashboardController@singleNotification'
	]);
	Route::get('/elements', function () {
		return view('portal.elements');
	})->name('elements');

 Route::get('/testing', function () {
  return view('portal.testing');
 })->name('testing');

 Route::get('/test-1', function () {
  return view('portal.test-1');
 });
 Route::get('/test-2', function () {
  return view('portal.test-2');
 });
 Route::get('/test-3', function () {
  return view('portal.test-3');
 });

 Route::get('/reports', function () {
  return view('portal.reports');
 })->name('reports');

	/**
	 * Note Routes
	 */
	Route::get('/note/delete/{id}', [
		'as' => 'eac.portal.note.delete',
		'uses' => 'NoteController@destroy',
	]);
	Route::post('/note/create', [
		'as' => 'eac.portal.note.create',
		'uses' => 'NoteController@store',
	]);
	/**
	 * Settings Routes
	 */
	require_once(__DIR__ . '/settings/settings.routes.php');

	/**
	 * Company Routes
	 */
	require_once(__DIR__ . '/company/company.routes.php');

	/**
	 * User Routes
	 */
	require_once(__DIR__ . '/user/user.routes.php');

	/**
	 * Drug Routes
	 */
	require_once(__DIR__ . '/drug/drug.routes.php');

	/**
	 * RID Routes
	 */
	require_once(__DIR__ . '/rid/rid.routes.php');

	/**
	 * Pharmacy Routes
	 */
	require_once(__DIR__ . '/shipment/pharmacy.routes.php');

	/**
	 * Lot Routes
	 */
	require_once(__DIR__ . '/shipment/lot.routes.php');

	/**
	 * Depot Routes
	 */
	require_once(__DIR__ . '/shipment/depot.routes.php');

	/**
	 * Helper Routes
	 */
	require_once(__DIR__ . '/document/file.routes.php');
	/**
	 * Helper Routes
	 */
	require_once(__DIR__ . '/dashboard/data.routes.php');
	/**
	 * Pharmacy Routes
	 */
	require_once(__DIR__ . '/shipment/pharmacist.routes.php');


}); // end portal
