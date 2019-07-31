<?php

namespace App\Http\Controllers\Settings\Manage\Drug;

use App\DEVUPDATESCRIPTTABLE;
use App\Dosage;
use App\DosageForm;
use App\DosageStrength;
use App\DosageUnit;
use App\Drug;
use App\DrugLot;
use App\Http\Controllers\Controller;
use App\Http\Requests\Drug\Dosage\CreateRequest;
use App\Http\Requests\Drug\Dosage\UpdateRequest;
use App\MergeData;
use Illuminate\Http\Request;
use Validator;

/**
 * Class DrugDosageController
 * @package App\Http\Controllers\Settings\Manage\Drug
 *
 * @author Biplob Hossain <biplob@quasars.com>
 */
class DrugDosageController extends Controller
{

	public $_data = [
		// route load
		'editButton' => 'eac.portal.settings.manage.drug.dosage.edit',
		'createButton' => 'eac.portal.settings.manage.drug.dosage.create',
		'deleteButton' => 'eac.portal.settings.manage.drug.dosagedelete',
		'storeAction' => 'eac.portal.settings.manage.drug.dosage.store',
		'updateAction' => 'eac.portal.settings.manage.drug.dosage.update',
		'listAll' => 'eac.portal.settings.manage.drug.dosage.index',
		'cancelAction' => 'eac.portal.settings.manage.drug.dosage.index',
		'logsr' => 'eac.portal.settings.manage.drug.dosage.logs',
		'logsviewr' => 'eac.portal.settings.manage.drug.dosage.logsview',
		// blade load
		'indexView' => 'portal.settings.manage.drug.dosage.index',
		'createView' => 'portal.settings.manage.drug.dosage.create',
		'editView' => 'portal.settings.manage.drug.dosage.edit',
		'ajaxView' => 'portal.settings.manage.drug.dosage.ajaview',
		'logsv' => 'portal.settings.manage.drug.dosage.log',
		'logsviewv' => 'portal.settings.manage.drug.dosage.log_view',
	];

	public function __construct()
	{
//     $this->middleware('auth'); // auth check from the route
	}

	public function index(Request $request)
	{
		$rows = Dosage::all();

		return view($this->_data['indexView'])
			->with('page', $this->_data)
			->with('active', 'dosage')
			->with('rows', $rows);
	}

	public function update(UpdateRequest $request, $id)
	{
		$rows = Dosage::find($id);
		$rows->form_id = $request->form_id;
		$rows->strength_id = $request->strength_id;
		$rows->unit_id = $request->unit_id;
		$rows->temperature = $request->temperature;
		$rows->amount = $request->amount;
		$rows->active = ($request->input('active') == 'on') ? 1 : 0;

		if ($rows->isDirty()) {
			$rows->save();
			return redirect()->back()
				->with("alert", ['type' => 'success', 'msg' => 'Data Updated successfully']);
		}

		$rows->save();
		return redirect(route($this->_data['listAll']))
			->with("alert", ['type' => 'success', 'msg' => 'Data Updated successfully']);

		// $validator = Validator::make(
		//                 $request->all(), [
		//             'form_id' => 'required',
		//             'strength_id' => 'required',
		//             'unit_id' => 'required',
		//                 ], [
		//             'name.required' => ' Name Field is Required',
		//                 ]
		// );

		// if ($validator->fails()) {
		//     return redirect()->back()->with("alert", ['type' => 'danger', 'msg' => 'Error occured in the page!'])
		//                     ->with("errors", $validator->errors())
		//                     ->withInput()
		//                     ->with('page', $this->_data);
		// } else {

		// }
	}

	public function store(CreateRequest $request)
	{

		$currentTimestamp = date('Y-m-d H:i:s');
		$rows = new Dosage();
		$rows->id = $this->newID(Dosage::class);
		$rows->form_id = $request->form_id;
		$rows->strength_id = $request->strength_id;
		$rows->unit_id = $request->unit_id;
		$rows->temperature = $request->temperature;
		$rows->amount = $request->amount;
		$rows->active = ($request->input('active') == 'on') ? 1 : 0;
		$rows->save();
		return redirect(route($this->_data['listAll']))
			->with("alert", ['type' => 'success', 'msg' => 'Data inserted successfully']);

	}

	public function create(Request $request)
	{

		$dosage['dosageUnit'] = DosageUnit::where('active', '1');
		// $dosage['dosageRoute'] = DosageRoute::where('active', '1');
		$dosage['dosageStrength'] = DosageStrength::where('active', '1');
		$dosage['dosageForm'] = DosageForm::where('active', '1');
		$dosage['drug'] = Drug::where('active', '1');

		return view($this->_data['createView'])
			->with('active', 'create')
			->with('dosage', $dosage)
			->with('page', $this->_data);
	}

	public function ajaxlist()
	{

		$sql = Dosage::Where('dosages.active', '!=', '')
			// ->leftJoin('dosage_routes', 'dosages.route_id', '=', 'dosage_routes.id')
			->leftJoin('dosage_forms', 'dosages.form_id', '=', 'dosage_forms.id')
			// ->leftJoin('drug', 'dosages.drug_id', '=', 'drug.id')
			->leftJoin('dosage_strength', 'dosages.strength_id', '=', 'dosage_strength.id')
			->leftJoin('dosage_units', 'dosages.unit_id', '=', 'dosage_units.id')
			->select([
				'dosages.id as id',
				'dosages.created_at as created_at',
				'dosages.updated_at as updated_at',
				'dosages.active as active',
				'dosages.amount as amount',
				// 'dosage_routes.name as route_name',
				'dosage_forms.name as form_name',
				'dosage_units.name as unit_name',
				'dosage_strength.name as strength_name'
				// 'drug.name as drug_name'
			]);

		return \DataTables::of($sql)
			// ->addColumn('drug', function ($row) {
			//     return $row->drug_name;
			// })
			->setRowClass(function ($row) {

				if ($row->active == '1') {
					$class = 'v-active';
				} else {

					$class = 'v-inactive';

				}
				return $class;

			})
			->addColumn('form', function ($row) {
				return $row->form_name;
			})
			->addColumn('strength', function ($row) {
				return $row->strength_name;
			})
			->addColumn('unit', function ($row) {
				return $row->amount . ' ' . $row->unit_name;
			})
			->addColumn('active', function ($row) {

				return $row->active == '1' ? '<span class="badge badge-success">
                Active
                </span>' : '<span class="badge badge-danger">
                Inactive
                </span>';
			})
			->addColumn('created_at', function ($row) {
				return $row->updated_at ? $row->updated_at->format(config('eac.date_format')) : 'N/A';
			})
			->addColumn('ops_btns', function ($row) {
				return '

                <a title="Edit Dosage" href="' . route('eac.portal.settings.manage.drug.dosage.edit', $row->id) . '">
                 <i class="far fa-edit" aria-hidden="true"></i> <span class="sr-only">Edit Dosage</span>
                </a>
                <a class="text-danger" href="#" onclick="Confirm_Delete(' . "'" . $row->id . "'" . ')">
                 <i class="far fa-times" aria-hidden="true"></i> <span class="sr-only">Delete Dosage</span>
                </a>
                ';
			})
			->rawColumns([
				// 'drug',
				// 'route',
				'form',
				'strength',
				'unit',
				'active',
				'created_at',
				'ops_btns'
			])
			// ->filterColumn('drug', function ($query, $keyword) {
			//     $query->where('drug.name', 'like', "%" . $keyword . "%");
			// })
			// ->filterColumn('route', function ($query, $keyword) {
			//     $query->where('dosage_routes.name', 'like', "%" . $keyword . "%");
			// })
			->filterColumn('form', function ($query, $keyword) {
				$query->where('dosage_forms.name', 'like', "%" . $keyword . "%");
			})
			->filterColumn('strength', function ($query, $keyword) {
				$query->where('dosage_strength.name', 'like', "%" . $keyword . "%");
			})
			->filterColumn('unit', function ($query, $keyword) {
				$query->where('dosage_units.name', 'like', "%" . $keyword . "%");
			})
			->filterColumn('created_at', function ($query, $keyword) {
				$query->where('dosages.updated_at', 'like', "%" . $keyword . "%");
			})
			->order(function ($query) {
				$columns = [
					// 'drug' => 0,
					// 'route' => 1,
					'form' => 0,
					'strength' => 1,
					'unite' => 2,
					'active' => 3,
					'created_at' => 4
				];

				$direction = request('order.0.dir');

				if (request('order.0.column') == $columns['form']) {
					$query->orderBy('dosage_forms.name', $direction);
				}
				if (request('order.0.column') == $columns['strength']) {
					$query->orderBy('dosage_strength.name', $direction);
				}
				if (request('order.0.column') == $columns['unite']) {
					$query->orderBy('dosage_units.name', $direction);
				}
				if (request('order.0.column') == $columns['active']) {
					$query->orderBy('dosages.active', $direction);
				}

				if (request('order.0.column') == $columns['created_at']) {
					$query->orderBy('dosages.updated_at', $direction);
				}
			})
			->smart(0)
			->toJson();
	}

	public function edit($id)
	{
		$dosage = array();
		$dosage['dosageUnit'] = DosageUnit::where('active', '1');
		// $dosage['dosageRoute'] = DosageRoute::where('active', '1');
		$dosage['dosageStrength'] = DosageStrength::where('active', '1');
		$dosage['dosageForm'] = DosageForm::where('active', '1');
		$dosage['drug'] = Drug::where('active', '1');

		$rows = Dosage::where('id', '=', $id);
		if (!count($rows)) {
			return redirect(route($this->_data['listAll']));
		}

		return view($this->_data['editView'])
			->with('active', 'edit')
			->with('dosage', $dosage)
			->with('rows', $rows)
			->with('page', $this->_data);
	}

	public function delete(Request $request)
	{
		$id = $request->id;
		$resourceData = Dosage::find($id);
		if ($resourceData):
			if ($resourceData->delete()):
				return [
					'result' => 'success'
				];
			endif;
		endif;
	}

	public function logs()
	{
		$logData = $this->getLogs(Dosage::class);
		return view($this->_data['logsv'], [
			'logData' => $logData,
			'page' => $this->_data
		]);
	}

	public function logsview(Request $request, $id)
	{
		$logData = \App\Log::where('subject_id', '=', $id);
		return view($this->_data['logsviewv'], [
			'logData' => $logData,
			'page' => $this->_data
		]);
	}

	public function ajaxlistmerge(Request $request)
	{

		$sql = Dosage::Where('dosages.active', '!=', '')
			// ->leftJoin('dosage_routes', 'dosages.route_id', '=', 'dosage_routes.id')
			->leftJoin('dosage_forms', 'dosages.form_id', '=', 'dosage_forms.id')
			// ->leftJoin('drug', 'dosages.drug_id', '=', 'drug.id')
			->leftJoin('dosage_strength', 'dosages.strength_id', '=', 'dosage_strength.id')
			->leftJoin('dosage_units', 'dosages.unit_id', '=', 'dosage_units.id')
			->select([
				'dosages.id as id',
				'dosages.created_at as created_at',
				'dosages.updated_at as updated_at',
				'dosages.active as active',
				// 'dosage_routes.name as route_name',
				'dosage_forms.name as form_name',
				'dosage_units.name as unit_name',
				'dosage_strength.name as strength_name'
				// 'drug.name as drug_name'
			]);
		// dd($sql);

		return \DataTables::of($sql)->setRowClass(function ($row) {

			if ($row->active == '1') {
				$class = 'v-active';
			} else {

				$class = 'v-inactive';

			}
			return $class;

		})
			->addColumn('primary', function ($row) {
				return '<input type="radio" name="primary" value="' . $row->id . '" />';
			})
			->addColumn('merge', function ($row) {
				return '<input type="checkbox" name="merge[]" value="' . $row->id . '" />';
			})
			->addColumn('form', function ($row) {
				return $row->form_name;
			})->addColumn('strength', function ($row) {
				return $row->strength_name;
			})->addColumn('active', function ($row) {

				return $row->active == '1' ? '<span class="badge badge-success">
                Active
                </span>' : '<span class="badge badge-danger">
                Inactive
                </span>';
			})->addColumn('unit', function ($row) {
				return $row->unit_name;
			})->addColumn('created_at', function ($row) {
				return $row->updated_at ? $row->updated_at->toDateString() : 'N/A';
			})->addColumn('ops_btns', function ($row) {
				return '

                <a title="Edit Dosage" href="' . route('eac.portal.settings.manage.drug.dosage.edit', $row->id) . '">
                 <i class="far fa-edit" aria-hidden="true"></i> <span class="sr-only">Edit Dosage</span>
                </a>
                <a class="text-danger" href="#" onclick="Confirm_Delete(' . "'" . $row->id . "'" . ')">
                 <i class="far fa-times" aria-hidden="true"></i> <span class="sr-only">Delete Dosage</span>
                </a>
                ';
			})->rawColumns([
				'primary',
				'merge',
				'form',
				'strength',
				'unit',
				'active',
				'created_at',
				'ops_btns'
			])
			// ->filterColumn('drug', function ($query, $keyword) {
			//     $query->where('drug.name', 'like', "%" . $keyword . "%");
			// })
			// ->filterColumn('route', function ($query, $keyword) {
			//     $query->where('dosage_routes.name', 'like', "%" . $keyword . "%");
			// })
			->filterColumn('form', function ($query, $keyword) {
				$query->where('dosage_forms.name', 'like', "%" . $keyword . "%");
			})
			->filterColumn('strength', function ($query, $keyword) {
				$query->where('dosage_strength.name', 'like', "%" . $keyword . "%");
			})
			->filterColumn('unit', function ($query, $keyword) {
				$query->where('dosage_units.name', 'like', "%" . $keyword . "%");
			})
			->filterColumn('created_at', function ($query, $keyword) {
				$query->where('dosages.updated_at', 'like', "%" . $keyword . "%");
			})->order(function ($query) {
				$columns = [
					'primary' => 0,
					'merge' => 1,
					'form' => 2,
					'strength' => 3,
					'unite' => 4,
					'active' => 5,
					'created_at' => 6
				];

				$direction = request('order.0.dir');

				if (request('order.0.column') == $columns['form']) {
					$query->orderBy('dosage_forms.name', $direction);
				}
				if (request('order.0.column') == $columns['strength']) {
					$query->orderBy('dosage_strength.name', $direction);
				}
				if (request('order.0.column') == $columns['unite']) {
					$query->orderBy('dosage_units.name', $direction);
				}
				if (request('order.0.column') == $columns['active']) {
					$query->orderBy('dosages.active', $direction);
				}

				if (request('order.0.column') == $columns['created_at']) {
					$query->orderBy('dosages.updated_at', $direction);
				}
			})
			->smart(0)
			->toJson();
	}

	// merge view load
	public function merge()
	{
		// $depots = Depot::all();

		return view('portal.settings.manage.drug.dosage.listmerge')->with('page', $this->_data);

	}

	// merge view selected
	public function mergeselected(Request $request)
	{
		if (!$request->primary) {
			return redirect()->back()->with("alert", ['type' => 'danger', 'msg' => 'Please select a primary data!']);
		}
		if (empty($request->merge)) {
			return redirect()->back()->with("alert", ['type' => 'danger', 'msg' => 'Please select a merge data!']);
		}
		$primary_id = $request->primary;
		$rowsPrimary = Dosage::where('id', $primary_id);

		$merge_id = $request->merge;
		$rowsMerge = Dosage::whereIn('id', $merge_id);

		return view('portal.settings.manage.drug.dosage.selectedmerge', [
			'rowsPrimary' => $rowsPrimary,
			'rowsMerge' => $rowsMerge,
		])->with('page', $this->_data);

	}

	// merge selected data post

	public function mergepost(Request $request)
	{

		if (!$request->primary_id) {
			return redirect()->back()->with("alert", ['type' => 'danger', 'msg' => 'Please select a primary data!']);
		}
		$primary_data = $request->primary_id;
		$merge_data = $request->merged_id;

		$merged_id = json_encode($merge_data);
		$table_name = "dosages";

		$data = new MergeData();
		$data->id = $this->newID(MergeData::class);
		$data->primary_id = $primary_data;
		$data->primary_old_id = $this->findOldprimaryId($primary_data);
		$data->merge_id = $merged_id;
		$data->table_name = $table_name;
		// find out old ids
		array_push($merge_data, $primary_data);

		$migration_old_id = $this->findOldId($merge_data);
		$data->migration_old_id = $migration_old_id;
		$data->save();


		// replace drug_lot_id in rid_regimen primary id
		$drugLots = DrugLot::whereIn('dosage_id', $merge_data)->update(['dosage_id' => $primary_data]);
		$updatedrugLots = DrugLot::whereIn('dosage_id', $merge_data);


		// remove primary id from selected merge data
		$temparray = array($primary_data);
		$result = array_diff($merge_data, $temparray);
		$remove = Dosage::whereIn('id', $result)->delete();

		return redirect(route('eac.portal.settings.manage.drug.dosage.list.merge'))
			->with("alerts_merge", ['type' => 'success', 'msg' => $updatedrugLots->count() . " Drug Lots  updated"])
			->with("alert", ['type' => 'success', 'msg' => 'Dosages  Merged successfully']);
	}

	// migration old_id
	public function findOldId($array)
	{
		$data = DEVUPDATESCRIPTTABLE::whereIn('id_new', $array)->select('id_old');
		// dd($data->toJson());
		$singleArray = [];
		if ($data->count() > 0) {
			foreach ($data as $key => $value) {
				$singleArray[$key] = $value->id_old;
			}
			return json_encode($singleArray, TRUE);
		}


		return json_encode($singleArray, TRUE);
	}

	public function findOldprimaryId($array)
	{
		$data = DEVUPDATESCRIPTTABLE::where('id_new', $array)->select('id_old')->first();

		if ($data) {
			return $data;
		} else {
			return '0';

		}

	}

}
