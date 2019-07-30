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

	public $extensions = [
		'pdf',
		'jpg'
	];

	protected function createFile($requestFile, $type)
	{
		if(!in_array($requestFile->getClientOriginalExtension(), $this->extensions)) {
			return abort(415, 'The file type "' . strtoupper($requestFile->getClientOriginalExtension()) . '" is not supported for security reasons.</br> Please only use PDFs or JPGs in the future.');
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

		$requestFile->storeAs('public' . $dir, $filename);
		return ['name' => $filename, 'dir' => $dir];
	}

	protected function download($id)
	{
		$file = File::where('id', '=', $id)->firstOrFail();
		return $this->downloadFrom($file->path, $file->name);
	}

	protected function downloadFrom($path, $name)
	{
		return \Storage::download('public' . $path . '/' . $name);
	}

	protected function display($id)
	{
		$file = File::where('id', '=', $id)->firstOrFail();
		return $this->displayFrom($file->path, $file->name);
	}

	protected function displayFrom($path, $name)
	{
		return response()->file(storage_path('app/public' .$path . '/' . $name));
	}
}
