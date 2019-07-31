<?php

/**
 * Authentication Routes
 */
Route::group([
	'prefix' => 'auth',
	'namespace' => 'Auth',
], function () {
	Route::get('/signin', [
		'as' => 'eac.auth.getSignIn',
		'uses' => 'LoginController@showLoginForm'
	]);
	Route::post('/signin', [
		'as' => 'eac.auth.postSignIn',
		'uses' => 'LoginController@login'
	]);

	Route::get('/register', [
		'as' => 'eac.auth.getSignUp',
		'uses' => 'RegisterController@showRegistrationForm'
	]);

    Route::get('/password/reset', [
        'as' => 'eac.auth.password.reset',
        'uses' => 'ForgotPasswordController@resetPasswordForm'
    ]);
    Route::post('/password/reset/submit', [
        'as' => 'eac.auth.password.reset.submit',
        'uses' => 'ForgotPasswordController@resetPassword'
    ]);

	Route::get('/pending', [
		'as' => 'eac.portal.user.wait',
		'uses' => 'StatusBouncer@pendingScreen'
	]);

	Route::post('/register', [
		'as' => 'eac.auth.postSignUp',
		'uses' => 'RegisterController@store'
	]);

	Route::get('/hold', [
		'as' => 'eac.portal.user.hold',
		'uses' => 'StatusBouncer@suspendedScreen'
	]);

	Route::get('/registering', [
		'as' => 'eac.portal.user.certify',
		'uses' => 'StatusBouncer@registeringScreen'
	]);

	Route::get('/logout', [
		'as' => 'eac.auth.logout',
		'uses' => 'LoginController@logout',
	]);

	Route::group([
		'prefix' => '/emu',
	], function () {
		Route::get('/init/{id}', [
			'as' => 'eac.auth.emu.init',
			'uses' => 'EmulationController@init',
		]);

		Route::get('/stop', [
			'as' => 'eac.auth.emu.stop',
			'uses' => 'EmulationController@stop',
		]);
	});

	Route::group([
		'prefix' => '/ridtrack',


	], function () {
	Route::post('/patient', [
		'as' => 'eac.auth.ridtrack.patient',
		'uses' => 'RidTrackController@show'
	]);
	Route::get('/patient/logout', [
		'as' => 'eac.auth.ridtrack.patient.logout',
		'uses' => 'RidTrackController@logout'
	]);
	Route::get('/patient/ridtrack/details/{id}', [
		'as' => 'eac.auth.ridtrack.details',
		'uses' => 'RidTrackController@ridtrackdetails',
	]);

	});
});
