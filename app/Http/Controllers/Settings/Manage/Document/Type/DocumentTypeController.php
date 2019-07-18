<?php

namespace App\Http\Controllers\Settings\Manage\Document\Type;

use App\Http\Requests\Document\CreateRequest;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\DocumentType;
use App\File;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Validator;

/**
 * Class DocumentTypeController
 * @package App\Http\Controllers\Settings\Manage\Document
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class DocumentTypeController extends Controller
{
	public $_data = [
		// route load
		'editButton' => 'eac.portal.settings.document.type.edit',
		'createButton' => 'eac.portal.settings.document.type.create',
		'deleteButton' => 'eac.portal.settings.document.type.delete',
		'storeAction' => 'eac.portal.settings.document.type.stroe',
		'updateAction' => 'eac.portal.settings.document.type.update',
		'listAll' => 'eac.portal.settings.document.type',
		'cancelAction' => 'eac.portal.settings.document.type',
		// blade load
		'indexView' => 'portal.settings.manage.document.type.index',
		'createView' => 'portal.settings.manage.document.type.create',
		'editView' => 'portal.settings.manage.document.type.edit',
		'ajaxView' => 'portal.settings.manage.document.type.ajaview',
	];

	/**
	 * DocumentTypeController constructor.
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the DocumentType management page
	 */
	public function index()
	{
		return view('portal.settings.manage.document.type.index', [
			'docTypes' => DocumentType::all(),
			'page' => $this->_data
		]);
	}

	public function documentAjaxlist()
	{

		$sql = DocumentType::where('active', '!=', null);
		return \DataTables::of($sql)
			->setRowClass(function ($row) {

				if ($row->active == '1') {
					$class = 'v-active';
				} else {

					$class = 'v-inactive';

				}
				return $class;

			})
			->addColumn('active', function ($row) {
				return $row->active == '1' ? '<span class="badge badge-success">
                Active
                </span>' : '<span class="badge badge-danger">
                Inactive
                </span>';
			})
			->addColumn('name', function ($row) {
				return $row->name;
			})
			->addColumn('template', function ($row) {
				if ($row->template == NULL) {
					return '<span>N/A</span>';
				} else {
					$doc = \App\File::where('id', $row->template)->first();
					return '<a href="' . route('eac.portal.file.download', $doc->id) . '"  class="btn btn-link">
												<i class="far fa-download"></i>
											</a>';

				}

			})
			->addColumn('desc', function ($row) {
				if ($row->desc == NULL) {
					return '<span>N/A</span>';
				} else {
					return $row->desc;
				}

			})
			->addColumn('created_at', function ($row) {
				if ($row->created_at == NULL) {
					return '<span>N/A</span>';
				} else {
					return $row->updated_at->format(config('eac.date_format'));
				}

			})
			->addColumn('ops_btns', function ($row) {
				return '

                <a title="Edit Document" href="' . route('eac.portal.settings.document.type.edit', $row->id) . '">
                 <i class="far fa-edit" aria-hidden="true"></i> <span class="sr-only">Edit Document</span>
                </a>
                
                ';
			})
			->rawColumns([
				'active',
				'name',
				'template',
				'desc',
				'created_at',
				'ops_btns'
			])
			->filterColumn('name', function ($query, $keyword) {
				$query->where('name', 'like', "%" . $keyword . "%");
			})
			->filterColumn('desc', function ($query, $keyword) {
				$query->where('desc', 'like', "%" . $keyword . "%");
			})
			->filterColumn('created_at', function ($query, $keyword) {
				$query->where('updated_at', 'like', "%" . $keyword . "%");
			})
			->order(function ($query) {
				$columns = [

					'active' => 0,
					'name' => 1,
					'template' => 2,
					'desc' => 3,
					'created_at' => 4,
					'ops_btns' => 5,
				];

				$direction = request('order.0.dir');

				if (request('order.0.column') == $columns['name']) {
					$query->orderBy('name', $direction);
				}

				if (request('order.0.column') == $columns['desc']) {
					$query->orderBy('desc', $direction);
				}

				if (request('order.0.column') == $columns['template']) {
					$query->orderBy('template', $direction);
				}
				if (request('order.0.column') == $columns['created_at']) {
					$query->orderBy('updated_at', $direction);
				}

				if (request('order.0.column') == $columns['active']) {
					$query->orderBy('active', $direction);
				}
			})
			->smart(0)
			->toJson();
	}

	public function create(Request $request)
	{
		return view('portal.settings.manage.document.type.create', [
			'docTypes' => DocumentType::all(),
			'page' => $this->_data
		]);
	}

	public function store(Request $request)
	{


		$request->validate([
			'name' => 'required',

		]);


		$documentType = new DocumentType();
		$documentType->id = $this->newID(DocumentType::class);
		$documentType->name = $request->name;
		$documentType->desc = $request->desc;
		$documentType->active = ($request->input('active') == 'on') ? 1 : 0;
		$documentType->is_resource = ($request->input('resource') == 'on') ? 1 : 0;
		$documentType->is_document = ($request->input('documented') == 'on') ? 1 : 0;


		if ($request->file('template_file')) {
			$requestFile = $request->file('template_file');
			$dir = '/drug/documents';
			$filename = 'template_' . rand(10000000, 99999999) . '.' . $requestFile->getClientOriginalExtension();
			$path = $requestFile->storeAs($dir, $filename);
			$file = new File();
			$file->id = $this->newID(File::class);
			$file->path = $dir;
			$file->name = $filename;
			$file->save();
			$file_id = $file->id;
			$documentType->template = $file_id;
			$documentType->save();
			return redirect(route($this->_data['listAll']))
				->with("alerts", ['type' => 'success', 'msg' => 'Data inserted successfully']);
		} else {
			$documentType->save();
			return redirect(route($this->_data['listAll']))
				->with("alerts", ['type' => 'success', 'msg' => 'Data inserted successfully']);
		}
	}

	public function edit(Request $request, $id)
	{
		$docTypes = DocumentType::where('id', $id)->first();
		return view('portal.settings.manage.document.type.edit', [
			'docTypes' => $docTypes,
			'page' => $this->_data
		]);

	}

	public function update(Request $request)
	{
		$request->validate([
			'name' => 'required',
		]);
		$documentType = new DocumentType();
		$docTypes = DocumentType::find($request->doc_id);
		$documentType = DocumentType::find($request->doc_id);
		$documentType->name = $request->name;
		$documentType->desc = $request->desc;
		$documentType->active = ($request->input('active') == 'on') ? 1 : 0;
		$documentType->is_resource = ($request->input('resource') == 'on') ? 1 : 0;
		$documentType->is_document = ($request->input('documented') == 'on') ? 1 : 0;

		if ($request->file('template_file')) {
			$requestFile = $request->file('template_file');
			$dir = '/drug/documents';
			$filename = 'template_' . rand(10000000, 99999999) . '.' . $requestFile->getClientOriginalExtension();
			$path = $requestFile->storeAs($dir, $filename);
			$file = new File();
			$file->id = $this->newID(File::class);
			$file->path = $dir;
			$file->name = $filename;
			$file->save();
			$file_id = $file->id;
			$documentType->template = $file_id;
			$documentType->save();
			return redirect(route($this->_data['listAll']))
				->with("alerts", ['type' => 'success', 'msg' => 'Data inserted successfully']);
		} else {
			$documentType->template = $docTypes->template;
			$documentType->save();

			return redirect(route($this->_data['listAll']))
				->with("alerts", ['type' => 'success', 'msg' => 'Data updated successfully']);
		}
	}

	public function delete(Request $request, $id)
	{
		return view('portal.settings.manage.document.type.index', [
			'docTypes' => DocumentType::all(),
			'page' => $this->_data
		]);
	}

	public function logs()
	{
		$logData = $this->getLogs(DocumentType::class);
		return view('portal.settings.manage.document.type.log', [
			'logData' => $logData,
			'page' => $this->_data
		]);
	}

	public function logsview(Request $request, $id)
	{
		$logData = \App\Log::where('subject_id', '=', $id);
		return view('portal.settings.manage.document.type.log_view', [
			'logData' => $logData,
			'page' => $this->_data
		]);
	}

	public function ajaxUpdate(Request $request)
	{

		$documentTypeId = $request->id;
		$template = $request->template;
		$docType = DocumentType::find($documentTypeId);


		if ($request->file('file_image')) {
			$image = $request->file('file_image');
			$dir = './uploads/templates/';
			$uniqueFileName = "template_" . time() . uniqid() . '.' . $image->getClientOriginalExtension();
			$request->file('file_image')->move($dir, $uniqueFileName);

			$file = File::find($template);

			if (!empty($file)) {

				$file->path = "/uploads/templates/";
				$file->name = $uniqueFileName;
				$file->save();
				$file_id = $file->id;
			} else {
				$file = new File();
				$file->id = $this->newID(File::class);
				$file->path = "/uploads/templates/";
				$file->name = $uniqueFileName;
				$file->save();
				$file_id = $file->id;
			}
			$docType->template = $file_id;
			$docType->save();
			$returnHTML = view('portal.settings.manage.document.type.ajax_view')
				->with('file_name', $uniqueFileName)
				->with('file_id', $file_id)
				->render();
			return response()->json(array('result' => "Success", 'html' => $returnHTML));
		} else {


			if (isset($request->active_val)) {
//

				$docType->active = (int)$request->active_val;
			}
			if ($request->name) {
				$docType->name = $request->name;
			}
			if ($request->description) {
				if (Schema::hasColumn('document_types', 'desc'))
					; //check document_types table has column description
				{
					$docType->desc = $request->description;
				}
			}
		}

		$docType->save();

		return [
			"result" => "Success"
		];
	}

	public function ajaxDelete(Request $request)
	{

		$documentTypeId = $request->id;
		$docType = DocumentType::find($documentTypeId)->delete();
		return [
			"result" => "Success"
		];
	}

}
