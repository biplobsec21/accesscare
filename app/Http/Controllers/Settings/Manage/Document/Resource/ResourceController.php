<?php

namespace App\Http\Controllers\Settings\Manage\Document\Resource;

use App\Resource;
use App\File;
use App\Http\Controllers\Controller;
use App\Http\Requests\Resource\CreateRequest;
use Illuminate\Http\Request;

/**
 * Class Resource Controller
 * @package App\Http\Controllers
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class ResourceController extends Controller
{

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(CreateRequest $request)
	{

		$drug = Drug::where('id', "=", $request->input('drug_id'))->firstOrFail();

		$resource = new Resource();
		$resource->id = $this->newID(Resource::class);
		$resource->drug_id = $drug->id;
		$resource->type_id = $request->input('type_id');
		$resource->file_id = 0;
		$resource->name = $request->input('name');
		$resource->is_required = $request->input('is_required') == 'on' ? 1 : 0;
		$resource->is_required_resupply = $request->input('is_required_resupply') == 'on' ? 1 : 0;

		$requestFile = $request->file('template_file');
		$filename = 'drug_template_file_' . rand(1000000000, 9999999999) . '.' . $requestFile->getClientOriginalExtension();
		$dir = '/drug/documents';
		$path = $requestFile->storeAs($dir, $filename);

		$file = new File();
		$file->id = $this->newID(File::class);
		$file->path = $dir;
		$file->name = $filename;
		$file->save();

		$resource->template_id = $file->id;

		$resource->save();

		return redirect()->back();
	}

	/**
	 * DocumentController constructor.
	 */
	public function __construct()
	{
		$this->middleware("auth");
	}

	public function ajaxUpdate()
	{
		$id = $_POST['id'];
		$field = $_POST['field'];
		$val = $_POST['val'];

		try {
			$document = Resource::where('id', "=", $id)->firstOrFail();
			$document->$field = $val;
			$document->saveOrFail();

		} catch (\Exception $e) {
			throw $e;
		}

		return [
			"result" => "Success"
		];
	}

	public function writeDB()
	{
		$save_data = $_POST['save_data'];
		try {
			if ($save_data['id'] === 'new') {
				//Generate ID
				$row = new Resource();
				$save_data['id'] = $this->generateUniqueWithPrefix('mysql', Resource::getTableName(), 'id', 'RESOURCE', $this->GENERATESSTRINGS_CHARS_UPPER_LOWER_NUM, 30);
			} else {
				$row = Resource::where('id', "=", $save_data['id'])->firstOrFail();
			}

			foreach ($save_data as $field => $val) {
				$row->$field = $val;
			}
			$row->saveOrFail();

		} catch (\Exception $e) {
			throw $e;
		}

		return [
			"result" => "Success"
		];
	}
}
