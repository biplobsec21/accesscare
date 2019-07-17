<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\Filer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\File;

/**
 * Class DocumentController
 * @package App\Http\Controllers
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class FileController extends Controller
{
	use Filer;
	/**
	 * DocumentController constructor.
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Download file by ID
	 *
	 * @param string $id
	 * @return mixed
	 */
	public function down(string $id)
	{
		return $this->download($id);
	}
}
