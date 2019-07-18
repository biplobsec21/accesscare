<?php

Route::get('/download/{id}', [
	'as' => 'eac.portal.file.download',
	'uses' => 'FileController@down',
]);
Route::get('/view/{id}', [
	'as' => 'eac.portal.file.view',
	'uses' => 'FileController@view',
]);
