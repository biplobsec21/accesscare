<?php

namespace App\Http\Controllers\Settings\Manage\Document\Resource\Type;

use App\Http\Controllers\Controller;
use App\ResourceType;

/**
 * Class ResourceTypeController
 * @package App\Http\Controllers\Settings\Manage\Document\Resource
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class ResourceTypeController extends Controller
{
	/**
	 * ResourceTypeController constructor.
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return view('portal.settings.manage.document.resource.type.index', [
			'resTypes' => ResourceType::all(),
		]);
	}

	public function ajaxUpdate()
	{
		$id = $_POST['id'];
		$field = $_POST['field'];
		$val = $_POST['val'];

		try {
			$docType = ResourceType::where('id', "=", $id)->firstOrFail();
			$docType->$field = $val;
			$docType->saveOrFail();

		} catch (\Exception $e) {
			throw $e;
		}

		return [
			"result" => "Success"
		];
	}
}
