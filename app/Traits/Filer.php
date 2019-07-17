<?php

namespace App\Traits;

use App\File;
use App\Mailer;
use App\Notification;
use App\User;
use Mail;
use App\Mail\GenericEmail;

/**
 * Trait Notifier
 */
trait Filer
{

	protected $extensions = [
		'pdf',
		'doc',
		'docx',
		'jpeg',
		'png',
		'pdf',
		'odt'
	];

	protected function createFile($requestFile, $type)
	{
		if(!array_key_exists($requestFile->getClientOriginalExtension(), $this->extensions)) {
			return abort(500, 'File type .' . $requestFile->getClientOriginalExtension() . ' not supported');
		}
		$file = new File();
		$file->id = $this->newID(File::class);
		$address = $this->upload($requestFile, $type, $file->id);
		$file->path = $address['dir'];
		$file->name = $address['name'];
		$file->save();
		return $file;
	}

	protected function upload($requestFile, $type, $file_id)
	{
		$filename = config('eac.storage.name.' . $type) . $file_id . '.' . $requestFile->getClientOriginalExtension();
		$dir = config('eac.storage.file.' . $type);

		$requestFile->storeAs($dir, $filename);
		return ['name' => $filename, 'dir' => $dir];
	}

	protected function download($id)
	{
		$file = File::where('id', '=', $id)->firstOrFail();
		return $this->downloadFrom($file->path, $file->name);
	}

	protected function downloadFrom($path, $name)
	{
		return \Storage::download($path . '/' . $name);
	}
}
