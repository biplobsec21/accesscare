<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return view('public.index');
})->name('public.index');

Route::get('elements', function () {
 return view('public.elements');
})->name('elements');

Route::get('/ajax', ['as' => 'eac.ajax.page', 'uses' => 'AjaxController@index']);

Route::get('page/{keyword}', ['as' => 'eac.public.page', 'uses' => 'HomeController@page']);


Route::get('mail/send', ['as' => 'eac.mail.send', 'uses' => 'EmailController@send']);
Route::get('mail/email_test', ['as' => 'eac.mail.email_test', 'uses' => 'EmailController@email_test']);
require_once(__DIR__ . '/include/auth.routes.php');

require_once(__DIR__ . '/include/portal.routes.php');

require_once(__DIR__ . '/include/legacy_redirects.routes.php');

Route::group(['prefix' => '/portal/live_data_import', 'namespace' => 'Dataimport'], function () {
	Route::get('', ['as' => 'eac.portal.live_data_import', 'uses' => 'LiveDataImportController@handleDb']);
});
