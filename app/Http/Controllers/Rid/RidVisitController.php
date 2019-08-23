<?php

namespace App\Http\Controllers\Rid;

use App\Address;
use App\Company;
use App\Drug;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rid\CreateRequest;
use App\Pharmacy;
use App\Rid;
use App\RidVisitStatus;
use App\RidVisit;
use App\Traits\AuthAssist;
use App\Traits\Notifier;
use App\Traits\WorksWithRIDs;
use Illuminate\Http\Request;

/**
 * Class RidController
 * @package App\Http\Controllers\Rid
 * @author Andrew Mellor <andrew@quasars.com>
 */
class RidVisitController extends Controller
{
	use WorksWithRIDs, Notifier, AuthAssist;

	/**
	 * Display a listing of the resource.
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('portal.rid.list');
	}

	public function review(CreateRequest $request)
	{
		$str = '';
		$data = $request->all();
		if ($request->input('pharmacy_id') !== 'new') {
			$pharmacy = Pharmacy::where('id', $request->input('pharmacy_id'))->firstOrFail();
			$address = Address::where('id', $pharmacy->address_id)->firstOrFail();
			$str = '<strong>' . $pharmacy->name . '</strong></br>';
			$str .= $address->strDisplay();
		} else {
			$str = '<strong>' . $data['pharmacy_name'] . '</strong></br>';
			$str = $data['pharmacy_addr1'] . '</br>';
			if ($data['pharmacy_addr2']) {
				$str .= $data['pharmacy_addr2'] . '</br>';
			}
			$str .= $data['pharmacy_city'] . ' ';
			if ($data['pharmacy_state_province']) {
				$state = \App\State::where('id', $data['pharmacy_state_province'])->first();
				$str .= $state->abbr . ' ';
			}
			$str .= $data['pharmacy_zip'] . '</br>';
			if ($data['pharmacy_country_id']) {
				$country = \App\Country::where('id', $data['pharmacy_country_id'])->first();
				$str .= $country->name . ' ';
			}
		}
		$data['patient_gender'] = $data['patient_gender'] == 'on' ? 'Male' : 'Female';
		$data['patient_dob'] = $data['patient_dob']['year'] . '-' . $data['patient_dob']['month'] . '-' . $data['patient_dob']['day'];
		return view('portal.rid.review', ['request' => $data, 'pharmacyStr' => $str, 'drug' => Drug::where('id', $request->input('drug_id'))->first(),]);
	}

	/**
	 * Store a newly created resource in storage.
	 * @param  mixed $data
	 * @return \Illuminate\Http\Response
	 */
	public function store()
	{
		$data = json_decode($_POST['data'], true);
		$rid = new Rid();
		$rid->id = $this->newID(Rid::class);

		if ($data['pharmacy_id'] === 'new') {
			$address = new Address();
			$pharmacy = new Pharmacy();

			$rid->pharmacy_id = $pharmacy->id = $this->newID(Pharmacy::class);
			$pharmacy->address_id = $address->id = $this->newID(Address::class);
			$pharmacy->name = $data['pharmacy_name'];

			$address->addr1 = $data['pharmacy_addr1'];
			$address->addr2 = $data['pharmacy_addr2'];
			$address->city = $data['pharmacy_city'];
			$address->state_province = $data['pharmacy_state_province'];
			$address->country_id = $data['pharmacy_country_id'];
			$address->zipcode = $data['pharmacy_zip'];

			$address->save();
			$pharmacy->save();
		} else {
			$rid->pharmacy_id = $data['pharmacy_id'];
		}

		$drug = Drug::where('id', $data['drug_id'])->firstOrFail();
		$company = Company::where('id', $drug->company_id)->firstOrFail();

		$rid->parent_id = null;
		$rid->number = $this->generateRidNumber($company);
		$rid->physician_id = $data['physician_id'];
		$rid->drug_id = $drug->id;
		$rid->physician_id = \Auth::user()->id;
		$rid->status_id = \App\RidStatus::where('name', 'New')->firstOrFail()->id;
		$rid->sub_status = \App\RidVisitStatus::where('status_id', $rid->status_id)->firstOrFail()->id;
		$rid->req_date = $data['req_date'];
		$rid->pharmacist_name = $data['pharmacist_name'];
		$rid->pharmacist_phone = $data['pharmacist_phone'];
		$rid->pharmacist_email = $data['pharmacist_email'];
		$rid->username = 0;
		$rid->password = 0;
		$rid->patient_gender = strtolower($data['patient_gender']);
		$rid->reason = $data['reason'];
		$rid->proposed_treatment_plan = $data['proposed_treatment_plan'];
		$rid->patient_dob = $data['patient_dob'];

		$rid->save();

		return redirect()->route('eac.portal.rid.edit', $rid->id);
	}

	/**
	 * Display the specified resource.
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$rid = Rid::where('id', $id)->firstOrFail();
		$access = $this->ridAuth($rid);
		$countries = \App\Country::all()->sortBy('name');
		return view('portal.rid.show.index', ['rid' => $rid, 'access' => $access, 'countries' => $countries,]);
	}

	/**
	 * Show the form for editing the specified resource.
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request,$id)
	{
		$warning = false;
		if($request->warning){
			$warning = true;
		}
		$visit = RidVisit::where('id', $id)->firstOrFail();
		$rid = $visit->rid;
		$access = $this->ridAuth($rid);
		//$this->authorize('rid.visit.update');
		$roles = \App\Role::all()->sortBy('name');
		$countries = \App\Country::all()->sortBy('name');
		$states = \App\State::all()->sortBy('name');
		$users = \App\User::all()->sortBy('first_name');
		$statuses = \App\RidStatus::all();
		$couriers = \App\ShippingCourier::all();
		$pharmacies = \App\Pharmacy::all();
		return view('portal.rid.edit.visit', [
			'rid' => $rid,
			'visit' => $visit,
			'states' => $states,
			'roles' => $roles,
			'countries' => $countries,
			'users' => $users,
			'statuses' => $statuses,
			'couriers' => $couriers,
			'pharmacies' => $pharmacies,
			'pageTitle' => 'Edit Visit',
			'warning' => $warning,
			'access' => $access
		]);
	}

	public function setStatus()
	{
		$rid = RidVisit::where('id', $_POST['visit_id'])->firstOrFail();
		$sub_status = RidVisitStatus::where('id', $_POST['sub_status'])->firstOrFail();
		$status = $sub_status->status;
		$rid->sub_status = $sub_status->id;
		$rid->status_id = $status->id;
		$rid->save();
		return redirect()->back();
	}

	public function ajaxRidData(Request $request)
	{
		$cols = ['number', 'status', 'physician_name', 'drug_name', 'created_at', 'ops_btns',];

		//Filtering
		//$query->where('created_at', 'like', "%" . $keyword . "%");

		$query = Rid::allAllowed(\Auth::user())->where('is_appeal', 0)->where('is_resupply', 0);
		if (!$query) {
			return;
		}

		$col = $cols[request()->get('order')[0]['column']];
		$direction = \request()->get('order')[0]['dir'];
		if ($col == 'physician_name') {
			$sortArray = $query->values();
			for ($i = 1; $i < count($sortArray); $i++) {
				for ($j = $i - 1; $j >= 0; $j--) {
					if (strcasecmp($sortArray[$i]->physician->first_name, $sortArray[$j]->physician->first_name) >= 0) {
						break;
					}
				}
				$sortArray->splice($j + 1, 0, [$sortArray[$i]]);
				$sortArray->forget($i + 1);
				$sortArray = $sortArray->values();
			}
			if ($direction == 'desc') {
				$query = $sortArray->reverse();
			} else {
				$query = $sortArray;
			}
		} else {
			if ($direction == 'desc') {
				$query = $query->sortBy($col)->reverse();
			} else {
				$query->sortBy($col);
			}
		}
		return \DataTables::of($query)->addColumn('number', function ($row) {
			return "<a href=" . route('eac.portal.rid.show', $row->id) . ">" . $row->number . "</a>";
		})->addColumn('status', function ($row) {
			if ($row->status && $row->subStatus) {
				return "<span class='badge badge-" . config('eac.ridStatus.' . $row->status->name) . "'>" . $row->status->name . ": " . $row->subStatus->name . "</span>";
			} else {
				return "No Status";
			}
		})->addColumn('physician_name', function ($row) {
			return "<a href=" . route('eac.portal.user.show', $row->physician->id) . ">" . $row->physician->full_name . "</a>";
		})->addColumn('drug_name', function ($row) {
			return '<a href="' . route('eac.portal.drug.show', $row->drug->id) . '">' . $row->drug->name . ' (' . $row->drug->lab_name . ')</a>';
		})->addColumn('created_at', function ($row) {
			return $row->created_at->toDateString();
		})->addColumn('ops_btns', function ($row) {
			return '
    <a title="Edit RID" href="' . route('eac.portal.rid.edit', $row->id) . '">
     <i class="far fa-edit" aria-hidden="true"></i> <span class="sr-only">Edit RID</span>
    </a>
    <a title="View RID" href="' . route('eac.portal.rid.show', $row->id) . '">
     <i class="far fa-search-plus" aria-hidden="true"></i> <span class="sr-only">View RID</span>
    </a>
    ';
		})->order(function ($query) {
			if (request()->has('physician_name')) {
			}
		})->rawColumns(['number', 'status', 'physician_name', 'drug_name', 'ops_btns',])->toJson();
	}

	public function writeDB()
	{
		$save_data = $_POST['save_data'];
		try {
			$row = Rid::where('id', "=", $save_data['id'])->firstOrFail();

			foreach ($save_data as $field => $val) {
				$row->$field = $val;
			}
			$row->saveOrFail();
			return ["result" => "success", "data" => $_POST['save_data']];
		} catch (\Throwable $e) {
			if (config('app.debug')) {
				throw $e;
			} else {
				return ['result' => 'error'];
			}
		}
	}
}
