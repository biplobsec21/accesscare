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

    Route::get('/password/forgot', [
        'as' => 'eac.auth.password.forgot',
        'uses' => 'ForgotPasswordController@forgotPassword'
    ]);
    Route::post('/password/recover', [
        'as' => 'eac.auth.password.recover.submit',
        'uses' => 'ForgotPasswordController@recoverPassword'
    ]);

    Route::get('/password/change', [
        'as' => 'eac.auth.password.change',
        'uses' => 'ChangePasswordController@changePassword',
    ]);

    Route::post('/password/update', [
        'as' => 'eac.auth.password.update',
        'uses' => 'ChangePasswordController@updatePassword',
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
