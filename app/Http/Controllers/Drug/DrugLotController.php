<?php

namespace App\Http\Controllers\Drug;

use App\Depot;
use App\DEVUPDATESCRIPTTABLE;
use App\Drug;
use App\DrugLot;
use App\Http\Controllers\Controller;
use App\MergeData;
use App\RidRegimen;
use App\Traits\AuthAssist;
use Illuminate\Http\Request;
use Validator;

/**
 * Class DrugLotController
 * @package App\Http\Controllers\Settings\Manage\Drug
 * @author Andrew Mellor <andrew@quasars.com>
 */
class DrugLotController extends Controller
{
    use AuthAssist;
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('user.approved');

	}

	/**
	 * Display a listing of the resource.
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$lots = DrugLot::all();
		return view('portal.drug.lot.list', ['lots' => $lots,]);
	}

	public function create(Request $request)
	{
		$drugs = Drug::all();

		$depot = null;
		if ($request->input('depot'))
			$depot = Depot::where('id', $request->input('depot'))->first();

		$depots = Depot::all()->sortBy('name');
        $access = $this->generalAuth('lot.index.create');
		return view('portal.drug.lot.create', ['drugs' => $drugs, 'depots' => $depots, 'depot' => $depot]);
	}

	public function edit($id, Request $request)
	{
		$drugs = collect();
		$lot = DrugLot::where('id', $id)->firstOrFail();
		$drug_all = Drug::all();
		if ($lot && $lot->dosage) {
			$drugs = Drug::where('id', '=', $lot->dosage->component->drug_id)->get();
		}
		$depot = null;
		if ($request->input('depot'))
			$depot = Depot::where('id', $request->input('depot'))->first();

		$depots = Depot::all()->sortBy('name');
        $access = $this->lotAuth($lot);
		return view('portal.drug.lot.edit', ['drugs' => $drugs, 'depots' => $depots, 'lot' => $lot, 'drug_all' => $drug_all, 'depot' => $depot, 'access' => $access]);
	}

	/**
	 * Update the specified resource in storage.
	 * @param Request $request
	 * @param string $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{

		$validator = Validator::make(
			$request->all(), [
			'number' => 'required',
			'dosage_id' => 'required',
			'depot_id' => 'required',
			'stock' => 'required',
			'minimum' => 'required',
		], [
				'number.required' => ' Number Field is Required',
				'dosage_id.required' => ' Please Select Dosage',
				'depot_id.required' => ' Please Select Depot',
				'stock.required' => ' Please Enter Stock',
				'minimum.required' => ' Please Enter Minimum Number',
			]
		);

		if ($validator->fails()) {
			return redirect()->back()->with("alert", ['type' => 'danger', 'msg' => 'Error occured in the page!'])
				->with("errors", $validator->errors())
				->withInput();
		} else {

			$lot = DrugLot::where('id', $id)->firstOrFail();
			$lot->number = $request->input('number');
			$lot->dosage_id = $request->input('dosage_id');
			$lot->depot_id = $request->input('depot_id');
			$lot->stock = $request->input('stock');
			$lot->minimum = $request->input('minimum');
			$lot->save();

			if ($request->input('redirect')) {
				return redirect()->route("eac.portal.depot.edit", $request->input('depot_id'))->with("alert", ['type' => 'success', 'msg' => 'Lot Created Successfully']);
			} else {
				return redirect()->back()
					->with("alert", ['type' => 'success', 'msg' => 'Lot Has Been Updated.']);
			}
		}
	}

	public function store(Request $request)
	{
		$validator = Validator::make(
			$request->all(), [
			'number' => 'required',
			'dosage_id' => 'required',
			'depot_id' => 'required',
			'stock' => 'required',
			'minimum' => 'required',
		], [
				'number.required' => ' Number Field is Required',
				'dosage_id.required' => ' Please Select Dosage',
				'depot_id.required' => ' Please Select Depot',
				'stock.required' => ' Please Enter Stock',
				'minimum.required' => ' Please Enter Minimum Number',
			]
		);

		if ($validator->fails()) {
			return redirect()->back()->with("errors", $validator->errors())
				->withInput();
		}

		$lot = new DrugLot();
		$lot->id = $this->newID(DrugLot::class);
		$lot->number = $request->input('number');
		$lot->dosage_id = $request->input('dosage_id');
		$lot->depot_id = $request->input('depot_id');
		$lot->stock = $request->input('stock');
		$lot->minimum = $request->input('minimum');
		$lot->save();

		if ($request->input('redirect')) {
			return redirect()->route("eac.portal.depot.edit", $request->input('depot_id'))->with("alert", ['type' => 'success', 'msg' => 'Lot Created Successfully']);
		} else {
			return redirect()->back()->with("alert", ['type' => 'success', 'msg' => 'Lot Created Successfully']);
		}
	}

	public function delete(Request $request)
	{

		$id = $request->id;
		$resourceData = DrugLot::find($id);
		if ($resourceData):
			if ($resourceData->delete()):
				return [
					'result' => 'success'
				];
			endif;
		endif;
	}

	public function ajaxlist(Request $request)
	{

		$sql = DrugLot::Where('drug_lots.id', '!=', '')
			->Leftjoin('dosages', 'dosages.id', '=', 'drug_lots.dosage_id')
			->Leftjoin('depots', 'depots.id', '=', 'drug_lots.depot_id')
			->Leftjoin('drug_components', 'drug_components.id', '=', 'dosages.component_id')
			->Leftjoin('drug', 'drug.id', '=', 'drug_components.drug_id')
			->Leftjoin('dosage_forms', 'dosage_forms.id', '=', 'dosages.form_id')
			->Leftjoin('dosage_units', 'dosage_units.id', '=', 'dosages.unit_id')
			// ->groupBy('rids.id')
			->select([
				'drug_lots.id as id',
				'drug_lots.number as number',
				'drug_lots.stock as stock',
				'drug_lots.minimum as minimum',
				'drug_lots.created_at as created_at',
				'drug_lots.updated_at as updated_at',

				'drug.id as drug_id',
				'drug.name as drug_name',

				'depots.id  as depot_id',
				'depots.name  as depot_name',

				'dosage_forms.name  as dosage',
				'dosages.amount  as amount',
				'dosage_units.abbr  as abbr',
				'depots.name  as depot_name',
				'depots.id  as depot_id'
			]);
		if ($request->input('depot'))
			$sql = $sql->where('depot_id', $request->input('depot'));

		return \DataTables::of($sql)
			->addColumn('number', function ($row) {
				return $row->number;
			})->addColumn('drug', function ($row) {
				if (isset($row->drug_id)) {
					return '<a title="Drug Show" href="' . route('eac.portal.drug.show', $row->drug_id) . '">' .
						$row->drug_name
						. '</a>';
				} else {
					return "N/A";
				}

			})->addColumn('dosage', function ($row) {
				return $row->dosage . " " . $row->amount . " " . $row->abbr;
			})->addColumn('depot', function ($row) {
				if (isset($row->depot_id)) {
					return '<a title="Depot Edit" href="' . route('eac.portal.depot.edit', $row->depot_id) . '">' .
						$row->depot_name
						. '</a>';
				} else {
					return "N/A";
				}


			})->addColumn('stock', function ($row) {
				// return $row->first_name . " " . $row->last_name;
				return $row->stock . " > " . $row->minimum;

			})->addColumn('created_date', function ($row) {
				return $row->updated_at->format(config('eac.date_format'));
			})->addColumn('ops_btns', function ($row) {
				return '
				      <a title="Edit Lot" href="' . route('eac.portal.lot.edit', $row->id) . '">
				       <i class="far fa-edit" aria-hidden="true"></i> <span class="sr-only">Edit Lot</span>
				      </a>
						';
			})->rawColumns(['number', 'drug', 'dosage', 'depot', 'stock', 'created_date', 'ops_btns'])->filterColumn('number', function ($query, $keyword) {
				$query->where('drug_lots.number', 'like', "%" . $keyword . "%");
			})->filterColumn('drug', function ($query, $keyword) {
				$query->where('drug.name', 'like', "%" . $keyword . "%");
			})->filterColumn('dosage', function ($query, $keyword) {

				$query->where('dosage_forms.name', 'like', "%" . $keyword . "%")
					->orWhere('dosage_units.abbr', 'like', "%" . $keyword . "%")
					->orWhere('dosages.amount', 'like', "%" . $keyword . "%");


			})->filterColumn('depot', function ($query, $keyword) {
				$query->where('depots.name', 'like', "%" . $keyword . "%");
			})->filterColumn('created_at', function ($query, $keyword) {
				$query->where('drug_lots.updated_at', 'like', "%" . $keyword . "%");
			})->order(function ($query) {
				$columns = ['number' => 0, 'drug' => 1, 'dosage' => 2, 'depot' => 3, 'stock' => 4, 'created_at' => 5];

				$direction = request('order.0.dir');

				if (request('order.0.column') == $columns['number']) {
					$query->orderBy('drug_lots.number', $direction);
				}
				if (request('order.0.column') == $columns['drug']) {
					$query->orderBy('drug.name', $direction);
				}
				if (request('order.0.column') == $columns['dosage']) {
					$query->orderBy('dosage_forms.name', $direction);
				}
				if (request('order.0.column') == $columns['depot']) {
					$query->orderBy('depots.name', $direction);
				}

				if (request('order.0.column') == $columns['created_at']) {
					$query->orderBy('drug_lots.updated_at', $direction);
				}
				if (request('order.0.column') == $columns['stock']) {
					$query->orderBy('drug_lots.stock', $direction);
				}
			})->smart(0)->toJson();
	}

	public function ajaxlistmerge(Request $request)
	{

		$sql = DrugLot::Where('drug_lots.id', '!=', '')
			->Leftjoin('dosages', 'dosages.id', '=', 'drug_lots.dosage_id')
			->Leftjoin('depots', 'depots.id', '=', 'drug_lots.depot_id')
			->Leftjoin('drug_components', 'drug_components.id', '=', 'dosages.component_id')
			->Leftjoin('drug', 'drug.id', '=', 'drug_components.drug_id')
			->Leftjoin('dosage_forms', 'dosage_forms.id', '=', 'dosages.form_id')
			->Leftjoin('dosage_units', 'dosage_units.id', '=', 'dosages.unit_id')
			// ->groupBy('rids.id')
			->select([
				'drug_lots.id as id',
				'drug_lots.number as number',
				'drug_lots.stock as stock',
				'drug_lots.minimum as minimum',
				'drug_lots.created_at as created_at',

				'drug.id as drug_id',
				'drug.name as drug_name',

				'depots.id  as depot_id',
				'depots.name  as depot_name',

				'dosage_forms.name  as dosage',
				'dosages.amount  as amount',
				'dosage_units.abbr  as abbr',
				'depots.name  as depot_name',
				'depots.id  as depot_id'
			]);
		// dd($sql);

		return \DataTables::of($sql)
			->addColumn('primary', function ($row) {
				return '<input type="radio" name="primary" value="' . $row->id . '" />';
			})
			->addColumn('merge', function ($row) {
				return '<input type="checkbox" name="merge[]" value="' . $row->id . '" />';
			})
			->addColumn('number', function ($row) {
				return $row->number;
			})->addColumn('drug', function ($row) {
				if (isset($row->drug_id)) {
					return '<a title="Drug Show" href="' . route('eac.portal.drug.show', $row->drug_id) . '">' .
						$row->drug_name
						. '</a>';
				} else {
					return "N/A";
				}

			})->addColumn('dosage', function ($row) {
				return $row->dosage . " " . $row->amount . " " . $row->abbr;
			})->addColumn('depot', function ($row) {
				if (isset($row->depot_id)) {
					return '<a title="Depot Edit" href="' . route('eac.portal.depot.edit', $row->depot_id) . '">' .
						$row->depot_name
						. '</a>';
				} else {
					return "N/A";
				}


			})->addColumn('stock', function ($row) {
				// return $row->first_name . " " . $row->last_name;
				return $row->stock . " > " . $row->minimum;

			})->addColumn('created_date', function ($row) {
				return $row->created_at->toDateString();
			})->addColumn('ops_btns', function ($row) {
				return '
				      <a title="Edit Lot" href="' . route('eac.portal.lot.edit', $row->id) . '">
				       <i class="far fa-edit" aria-hidden="true"></i> <span class="sr-only">Edit Lot</span>
				      </a>
						';
			})->rawColumns(['primary', 'merge', 'number', 'drug', 'dosage', 'depot', 'stock', 'created_date', 'ops_btns'])->filterColumn('number', function ($query, $keyword) {
				$query->where('drug_lots.number', 'like', "%" . $keyword . "%");
			})->filterColumn('drug', function ($query, $keyword) {
				$query->where('drug.name', 'like', "%" . $keyword . "%");
			})->filterColumn('dosage', function ($query, $keyword) {
				$query->where('dosage_forms.name', 'like', "%" . $keyword . "%");
			})->filterColumn('depot', function ($query, $keyword) {
				$query->where('depots.name', 'like', "%" . $keyword . "%");
			})->filterColumn('created_at', function ($query, $keyword) {
				$query->where('drug_lots.created_at', 'like', "%" . $keyword . "%");
			})->order(function ($query) {
				$columns = ['number' => 0, 'drug' => 1, 'dosage' => 2, 'depot' => 3, 'stock' => 4, 'created_at' => 5];

				$direction = request('order.0.dir');

				if (request('order.0.column') == $columns['number']) {
					$query->orderBy('drug_lots.number', $direction);
				}
				if (request('order.0.column') == $columns['drug']) {
					$query->orderBy('drug.name', $direction);
				}
				if (request('order.0.column') == $columns['dosage']) {
					$query->orderBy('dosage_forms.name', $direction);
				}
				if (request('order.0.column') == $columns['depot']) {
					$query->orderBy('depots.name', $direction);
				}

				if (request('order.0.column') == $columns['created_at']) {
					$query->orderBy('drug_lots.created_at', $direction);
				}
				if (request('order.0.column') == $columns['stock']) {
					$query->orderBy('drug_lots.stock', $direction);
				}
			})->smart(0)->toJson();
	}

	// merge view load
	public function merge()
	{
		// $depots = Depot::all();
		return view('portal.drug.lot.listmerge');
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
		$rowsPrimary = DrugLot::where('id', $primary_id);

		$merge_id = $request->merge;
		$rowsMerge = DrugLot::whereIn('id', $merge_id);

		return view('portal.drug.lot.selectedmerge', [
			'rowsPrimary' => $rowsPrimary,
			'rowsMerge' => $rowsMerge,
		]);

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
		$table_name = "drug_lots";

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
		$ridShipment = RidRegimen::whereIn('drug_lot_id', $merge_data)->update(['drug_lot_id' => $primary_data]);
		$updatedShipment = RidRegimen::whereIn('drug_lot_id', $merge_data);


		// remove primary id from selected merge data
		$temparray = array($primary_data);
		$result = array_diff($merge_data, $temparray);
		$remove = DrugLot::whereIn('id', $result)->delete();

		return redirect(route('eac.portal.lot.list.merge'))
			->with("alerts_merge", ['type' => 'success', 'msg' => $updatedShipment->count() . " Rid regimen lots  updated"])
			->with("alert", ['type' => 'success', 'msg' => 'Drug Lots Merged successfully']);

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

	public function getDosage(Request $request)
	{

		$string = '';
		$i = 0;
		$drug = Drug::find($request->input('drug_id'));
		$string .= '<label class="d-block label_required">Component and Dosage</label>
								<select name="dosage_id"  class="form-control" required="required">';
		if ($drug->components) {
			$string .= '<option disabled hidden selected value="">-- Select --</option>';
			foreach ($drug->components as $component) {
				$string .= '<optgroup label="' . $component->name . '">';
				foreach ($component->dosages as $dosage) {
					if ($dosage->active == 1) {
						$i++;
						$string .= '<option value="' . $dosage->id . '">';
						$string .= $dosage->form->name . " " . $dosage->amount;
						$string .= '<small>' . $dosage->unit->name . '</small>';
						$string .= '</option>';
					}
				}
				$string .= '</optgroup>';
			}
		}
		$string .= '<select>';

		if ($i < 1) {
			$string .= '<span class="text-warning"> No active dosage found <i><small><a href="' . route('eac.portal.drug.edit', $request->input('drug_id')) . '" target="_blank">Add dosage </a></small></i></span>';
		}

		return $string;
	}
}
