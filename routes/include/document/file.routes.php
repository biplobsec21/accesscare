<?php

Route::get('/download/{id}', [
	'as' => 'eac.portal.file.download',
	'uses' => 'FileController@down',
]);
