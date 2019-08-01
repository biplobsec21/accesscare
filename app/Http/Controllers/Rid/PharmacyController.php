<?php

namespace App\Http\Controllers\Rid;

use App\Address;
use App\DataTables\DataTableResponse;
use App\DataTables\DataTableRow;
use App\DEVUPDATESCRIPTTABLE;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rid\Pharmacy\CreateRequest;
use App\MergeData;
use App\Pharmacist;
use App\Pharmacy;
use App\Phone;
use App\Rid;
use App\RidShipment;
use App\Traits\WorksWithRIDs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class PharmacyController
 * @package App\Http\Controllers\Rid
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class PharmacyController extends Controller
{
	use WorksWithRIDs;

	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('user.approved');

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$pharmacies = Pharmacy::all();
		// dd($pharmacies);
		return view('portal.rid.pharmacy.list', [
			'pharmacies' => $pharmacies,
		]);
	}

	public function create()
	{
		$countries = $this->getCountry();
		$states = \App\State::all()->sortBy('name');
		return view('portal.rid.pharmacy.create', [
			'states' => $states,
			'countries' => $countries,
		]);
	}

	public function edit($id)
	{
		$pharmacy = Pharmacy::where('id', $id)->firstOrFail();
		$countries = \App\Country::all()->sortBy('name');
		$states = \App\State::all()->sortBy('name');
		return view('portal.rid.pharmacy.edit', [
			'states' => $states,
			'countries' => $countries,
			'pharmacy' => $pharmacy,
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param CreateRequest $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(CreateRequest $request)
	{
		$pharmacy = new Pharmacy();
		$address = new Address();
		$pharmacy->id = $this->newID(Pharmacy::class);
		$pharmacy->physician_id = $request->input('user_id');
		$pharmacy->name = $request->input('pharmacy_name');
		$pharmacy->address_id = $address->id = $this->newID(Address::class);
		$address->addr1 = $request->input('pharmacy_addr1');
		$address->addr2 = $request->input('pharmacy_addr2');
		$address->city = $request->input('pharmacy_city');
		$address->state_province = $request->input('pharmacy_state_province');
		$address->country_id = $request->input('pharmacy_country_id');
		$address->zipcode = $request->input('pharmacy_zip');
		$address->save();
		$pharmacy->save();

		return redirect()->route('eac.portal.pharmacy.edit', $pharmacy->id)->with("alert", ['type' => 'success', 'msg' => 'Information inserted successfully']);

	}

	public function editPharmacy()
	{
		$rid = Rid::where('id', '=', $_POST['id'])->firstOrFail();
		$rid->pharmacy_name = $_POST['pharmacy_name'];
		$rid->pharmacy_email = $_POST['pharmacy_email'];
		$rid->pharmacy_phone = $_POST['pharmacy_phone'];
		$rid->save();

		$pharmacy = Pharmacy::where('id', '=', $rid->pharmacy_id)->firstOrFail();
//  $pharmacy->pharmacy_name = $_POST['pharmacy_name'];
//  $pharmacy->save();

		$address = Address::where('id', '=', $pharmacy->address_id)->firstOrFail();
		$address->addr1 = $_POST['pharmacy_addr1'];
		$address->addr2 = $_POST['pharmacy_addr2'];
		$address->city = $_POST['pharmacy_city'];
		$address->state_province = $_POST['pharmacy_state_province'];
		$address->country_id = $_POST['pharmacy_country_id'];
		$address->zipcode = $_POST['pharmacy_zip'];
		$address->save();
		return redirect()->back();
	}

	public function setPharmacy(Request $request)
	{
		$shipment = RidShipment::where('id', $request->input('ship_id'))->firstOrFail();
		if ($request->input('pharmacy_id') === 'new') {
			$pharmacy = new Pharmacy();
			$address = new Address();
			$pharmacy->id = $shipment->pharmacy_id = $this->newID(Pharmacy::class);
			$pharmacy->physician_id = $request->input('user_id');
			$pharmacy->name = $request->input('pharmacy_name');
			$pharmacy->address_id = $address->id = $this->newID(Address::class);
			$address->addr1 = $request->input('addr1');
			$address->addr2 = $request->input('addr2');
			$address->city = $request->input('city');
			$address->state_province = $request->input('state_province');
			$address->country_id = $request->input('country_id');
			$address->zipcode = $request->input('zipcode');
			$address->save();
			$pharmacy->save();
		} else {
			$shipment->pharmacy_id = $request->input('pharmacy_id');
			if ($request->input('name') && $request->input('name')[0] != null) {
				$name = array_values($request->input('name'));
				$email = array_values($request->input('email'));
				$phone_number = array_values($request->input('phone'));
				for ($i = 0; $i < count($name); $i++) {
					$pharmacist = new Pharmacist();
					$pharmacist->id = $this->newID(Pharmacist::class);
					$pharmacist->pharmacy_id = $request->input('pharmacy_id');
					$pharmacist->name = $name[$i];
					$pharmacist->email = $email[$i];
					$phone = new Phone();
					$phone->id = $pharmacist->phone = $this->newID(Phone::class);
					$phone->number = $phone_number[$i];
					$phone->country_id = $request->country_name;
					$phone->is_primary = 1;
					$phone->save();
					$pharmacist->save();
				}
				$shipment->pharmacist_id = $pharmacist->id;
			}
		}

		if ($request->input('pharmacist_id')) {
			if ($request->input('pharmacy_id') === 'new') {
				$pharmacist = new Pharmacist();
				$pharmacist->id = $shipment->pharmacist_id = $this->newID(Pharmacist::class);
				$pharmacist->pharmacy_id = $shipment->pharmacy->id;
				$pharmacist->name = $request->input('pharmacist_name');
				$pharmacist->email = $request->input('pharmacist_email');
				$phone = new Phone();
				$phone->id = $pharmacist->phone = $this->newID(Phone::class);
				$phone->country_id = $shipment->pharmacy->address->country_id;
				$phone->number = $request->input('pharmacist_phone');
				$phone->is_primary = true;
				$phone->save();
				$pharmacist->save();
			} else {
				$shipment->pharmacist_id = $request->input('pharmacist_id');
			}
		}

		$shipment->save();
		return redirect()->back()->with('confirm', 'Pharmacy Has Been Set.');
	}

//	/**
//	 * Store a newly created resource in storage.
//	 *
//	 * @param  \Illuminate\Http\Request $request
//	 * @return \Illuminate\Http\Response
//	 */
//	public function updatePharma(){
//		$shipment = new RidShipment();
//		$shipment = RidShipment::where('id', $request->input('id'))->first();
//		$pharmacist = new Pharmacist();
//		$pharmacist->id = $this->newID(Pharmacist::class);
//		$pharmacist->pharmacy_id = $ridShipment->pharmacy_id;
//		$pharmacist->name = $data['pharmacist_name'];
//		$pharmacist->email = $data['pharmacist_email'] ? $data['pharmacist_email'] : null;
//		$pharmacist->phone = preg_replace('/[^0-9]/', '', $data['pharmacist_phone']);
//		$pharmacist->created_at = $currentDate;
//		$pharmacist->save();
//		return redirect()->back();
//	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update($id)
	{
		// dd($_POST);
		$pharmacy = Pharmacy::where('id', '=', $id)->firstOrFail();
		$address = Address::where('id', '=', $pharmacy->address_id)->firstOrFail();
		$pharmacy->name = $_POST['pharmacy_name'];
		if (isset($_POST['active'])) {
			$pharmacy->active = 1;
		} else {
			$pharmacy->active = 0;

		}

		$address->addr1 = $_POST['pharmacy_addr1'];
		$address->addr2 = $_POST['pharmacy_addr2'];
		$address->city = $_POST['pharmacy_city'];
		$address->state_province = $_POST['pharmacy_state_province'];
		$address->country_id = $_POST['pharmacy_country_id'];
		$address->zipcode = $_POST['pharmacy_zip'];

		$address->save();
		$pharmacy->save();
		return redirect()->route('eac.portal.pharmacy.list.all');
	}

	public function inform()
	{
		$pharmacy = Pharmacy::where('id', '=', $_POST['pharmacy_id'])->firstOrFail();
		$address = Address::where('id', '=', $pharmacy->address_id)->firstOrFail();
		$str = '<strong>' . $pharmacy->name . '</strong></br>';
		$str .= $pharmacy->address->strDisplay();
		$str .= '<hr/>';
		if ($pharmacy->pharmacists->count() == 0) {
			// get all pharmacist
			$pharmacy = '<select  name="pharmacist_id" class="form-control select2">';
			$pharmacy .= '<option disabled hidden selected value="">-- Select --</option>';
			foreach (Pharmacist::all() as $user)
				$pharmacy .= '<option value="' . $user->id . '">' . $user->name . '</option>';
			$pharmacy .= '</select>';
			// add more layout
			$str .= '<div class="table-responsive">
				<table class="table table-sm table-responsive table-striped table-hover group-member-templatetable">
						<thead>
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Phone</th>
							<th></th>
						</tr>
						</thead>
						<tbody id="memberSection">
						<tr class="">
							<td>
								<input type="text" name="name[]" placeholder="Pharmacist Name"
								       class="form-control">
							</td>
							<td>
								<input type="email" name="email[]" placeholder="Email"
								       class="form-control">
							</td>
							<td>
								<input type="text" name="phone[]" placeholder="Phone"
								       class="form-control">
							</td>
							<td>
							</td>
						</tr>
						</tbody>
					</table>
					</div>
					<!-- <div class="d-flex justify-content-between mt-3">
						<a href="#" class="btn btn-link" id="addMemberBtn" onclick="addMember()">
							<i class="fal fa-plus"></i> Add Another
						</a>
					</div> -->
					<div class="d-flex justify-content-between mt-3 ">
						<a href="#" class="btn btn-link" onclick="templateShow()">
							<i class="fal fa-plus"></i>  Add New Pharmacist
						</a>
					</div>
					<br>
						OR
					<br><br>
					<label class="d-block">Assign Pharmacist</label>	
					<div class="row m-sm-0">
						<div class="col-sm mb-3 mb-sm-0 p-sm-0">' . $pharmacy . '
						</div>
						</div>
						';
		} else {
			$str .= "<label class='d-block label_required'>Pharmacist </label>";
			$str .= '<select id="pharmacistSelect" name="pharmacist_id" class="form-control">';
			foreach ($pharmacy->pharmacists as $contact)
				$str .= '<option value="' . $contact->id . '">' . $contact->name . '</option>';
			$str .= '</select>';
		}
		return $str;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return mixed
	 */
	public function destroy($id)
	{
		//
	}

	public function ajaxlist()
	{
	    $pharmacies = Pharmacy::all();
        $response = new DataTableResponse(Company::class, $pharmacies);
        foreach ($pharmacies as $pharmacy) {
            $row = new DataTableRow($pharmacy->id);
            $row->setColumn('name', $pharmacy->name
            );
            $row->setColumn('status', $pharmacy->status,
                $pharmacy->status
            );
            $str = '';
            for ($i = 0; $i < $pharmacy->pharmacists->count(); $i++) {
                $str .= ucwords($pharmacy->pharmacists[$i]->name);
                if ($i < $pharmacy->pharmacists->count() - 1)
                    $str .= ' + ';
            }
            $row->setColumn('pharmacists', $pharmacy->pharmacists->count(),
                '<span class="badge badge-mw badge-outline-warning" title="' . $str . '"> ' . $pharmacy->pharmacists->count() . '</span>'
            );
            $row->setColumn('active', $pharmacy->users->count(),
                '<a href="' . route('eac.portal.company.show', $pharmacy->id) . '#xusers" class="badge badge-mw badge-outline-info"> ' . $pharmacy->users->count() . '</a>'
            );
            $row->setColumn('created_at', strtotime($pharmacy->created_at),
                '<span style="display: none">' . $pharmacy->created_at->format('Y-m-d') . '</span>' . $pharmacy->created_at->format(config('eac.date_format'))
            );
            $row->setColumn('btns', $pharmacy->id,
                '<div class="btn-group dropleft" role="group">' .
                '<a class="btn btn-link" href="#" id="dropdownMenuButton' . $pharmacy->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' .
                '<span class="far fa-fw fa-ellipsis-v"></span> <span class="sr-only">Actions</span>' .
                '</a>' .
                '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $pharmacy->id . '">' .
                '<a title="View Pharmacy" href="' . route('eac.portal.pharmacy.show', $row->id) . '">' .
                '<i class="far fa-search-plus" aria-hidden="true"></i> <span class="sr-only">View Pharmacy</span>' .
                '</a>' .
                '<a title="Edit Pharmacy" href="' . route('eac.portal.pharmacy.edit', $row->id) . '">' .
                '<i class="far fa-edit" aria-hidden="true"></i> <span class="sr-only">Edit Pharmacy</span>' .
                '</a>' .
                '</div>' .
                '</div>'
            );
            $response->addRow($row);
        }
        return $response->toJSON();
	}

	public function ajaxlistmerge()
	{
		$sql = Pharmacy::Leftjoin('users', 'users.id', '=', 'pharmacies.physician_id')
			->Leftjoin('addresses', 'addresses.id', '=', 'pharmacies.address_id')
			->Leftjoin('countries', 'countries.id', '=', 'addresses.country_id')
			->Where('pharmacies.id', '!=', '')
			->select([
				'pharmacies.id as id',
				'pharmacies.name as name',
				'users.first_name as first_name',
				'users.last_name as last_name',

				'addresses.addr1 as addr1',
				'addresses.addr2 as addr2',

				'countries.name as country_name',
				'pharmacies.physician_id as pid',
				'pharmacies.created_at as created_at']);

		return \DataTables::of($sql)
			->addColumn('primary', function ($row) {
				return '<input type="radio" name="primary" value="' . $row->id . '" />';
			})
			->addColumn('merge', function ($row) {
				return '<input type="checkbox" name="merge[]" value="' . $row->id . '" />';
			})
			->addColumn('name', function ($row) {
				return $row->name;
			})
			->addColumn('physician_id', function ($row) {
				$full_name = $row->first_name . ' ' . $row->last_name;
				return $full_name;
			})
			->addColumn('address', function ($row) {
				$a1 = $row->addr1 ? $row->addr1 : '';
				$a2 = $row->addr2 ? $row->addr2 : '';
				return $a1 . ' ' . $a2;
			})
			->addColumn('country', function ($row) {
				return $row->country_name;
			})
			->addColumn('created_at', function ($row) {
				return $row->created_at->toDateString();
			})
			->addColumn('ops_btns', function ($row) {
				return '

                <a title="Edit Pharmacy" href="' . route('eac.portal.pharmacy.edit', $row->id) . '">
                 <i class="far fa-edit" aria-hidden="true"></i> <span class="sr-only">Edit Pharmacy</span>
                </a>
               
                ';
			})
			->rawColumns([
				'primary',
				'merge',
				'name',
				'physician_id',
				'address',
				'country',
				'created_at'
			])
			->filterColumn('name', function ($query, $keyword) {
				$query->where('pharmacies.name', 'like', "%" . $keyword . "%");
			})
			->filterColumn('physician_id', function ($query, $keyword) {
				$query->where('users.first_name', 'like', "%" . $keyword . "%");
			})
			->filterColumn('address', function ($query, $keyword) {
				$query->where('addresses.addr1', 'like', "%" . $keyword . "%");
			})
			->filterColumn('country', function ($query, $keyword) {
				$query->where('countries.name', 'like', "%" . $keyword . "%");
			})
			->filterColumn('created_at', function ($query, $keyword) {
				$query->where('pharmacies.created_at', 'like', "%" . $keyword . "%");
			})
			->order(function ($query) {
				$columns = [

					'primary' => 0,
					'merge' => 1,
					'name' => 2,
					'physician_id' => 3,
					'address' => 4,
					'country' => 5,
					'created_at' => 6,

				];

				$direction = request('order.0.dir');

				if (request('order.0.column') == $columns['name']) {
					$query->orderBy('pharmacies.name', $direction);
				}
				if (request('order.0.column') == $columns['physician_id']) {
					$query->orderBy('users.first_name', $direction);
				}
				if (request('order.0.column') == $columns['address']) {
					$query->orderBy('addresses.addr1', $direction);
				}
				if (request('order.0.column') == $columns['country']) {
					$query->orderBy('countries.name', $direction);
				}
				if (request('order.0.column') == $columns['created_at']) {
					$query->orderBy('pharmacies.created_at', $direction);
				}
			})
			->smart(0)
			->toJson();
	}

	// merge view load
	public function merge()
	{
		// $depots = Depot::all();
		return view('portal.rid.pharmacy.listmerge');
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
		$rowsPrimary = Pharmacy::where('id', $primary_id);

		$merge_id = $request->merge;
		$rowsMerge = Pharmacy::whereIn('id', $merge_id);

		return view('portal.rid.pharmacy.selectedmerge', [
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
		$table_name = "pharmacies";

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


		// replace pharmacy in rid_shipment table by primary id
		$ridShipment = RidShipment::whereIn('pharmacy_id', $merge_data)->update(['pharmacy_id' => $primary_data]);
		$updatedShipment = RidShipment::whereIn('pharmacy_id', $merge_data);


		$Pharmacist = Pharmacist::whereIn('pharmacy_id', $merge_data)->update(['pharmacy_id' => $primary_data]);
		$Pharmacist = Pharmacist::whereIn('pharmacy_id', $merge_data);


		// remove primary id from selected merge data
		$temparray = array($primary_data);
		$result = array_diff($merge_data, $temparray);
		$remove = Pharmacy::whereIn('id', $result)->delete();

		return redirect(route('eac.portal.pharmacy.list.merge'))
			->with("alerts_merge", ['type' => 'success', 'msg' => $updatedShipment->count() . " Rid shipments pharmacy and " . $Pharmacist->count() . " pharmacist pharmacy info. updated"])
			->with("alert", ['type' => 'success', 'msg' => 'Pharmacy Merged successfully']);

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
		// dd($data->toJson());

		if ($data) {
			return $data;
		} else {
			return '0';

		}
	}

	public function show(Request $request, $id)
	{

		$pharmacy = Pharmacy::where('id', $id)->firstOrFail();
		$countries = $this->getCountry();
		$states = \App\State::all()->sortBy('name');
		return view('portal.rid.pharmacy.show', [
			'states' => $states,
			'countries' => $countries,
			'pharmacy' => $pharmacy,
		]);
	}

	public function getpharmacistajaxlist()
	{
		$sql = Pharmacist::Leftjoin('pharmacies', 'pharmacies.id', '=', 'pharmacists.pharmacy_id')
			->Leftjoin('phones', 'phones.id', '=', 'pharmacists.phone')
			->Where('pharmacists.pharmacy_id', '=', null)
			->select([
				'pharmacies.id as pharmacy_id',
				'pharmacies.name as pharmacy_name',

				'pharmacists.name as name',
				'pharmacists.id as id',

				'phones.number as phone',
				'pharmacists.email as email',
				'pharmacists.created_at as created_at']);

		return \DataTables::of($sql)
			->addColumn('select', function ($row) {
				return '<input type="checkbox" name="select[]" value="' . $row->id . '" />';
			})
			->addColumn('name', function ($row) {
				return $row->name;
			})
			->addColumn('email', function ($row) {
				return $row->email ? $row->email : 'N/A';
			})
			->addColumn('phone', function ($row) {

				return $row->phone ? $row->phone : 'N/A';
			})
			->addColumn('pharmacy', function ($row) {

				return $row->pharmacy_name ? $row->pharmacy_name : 'Not Assigned';
			})
			->addColumn('created_at', function ($row) {
				return $row->created_at->toDateString();
			})
			->addColumn('ops_btns', function ($row) {
				return '
                <a title="Edit Pharmacy" href="' . route('eac.portal.pharmacist.edit', $row->id) . '">
                 <i class="far fa-edit" aria-hidden="true"></i> <span class="sr-only">Edit Pharmacist</span>
                </a>
               
                ';
			})
			->rawColumns([
				'select',
				'name',
				'email',
				'phone',
				'pharmacy',
				'created_at',
				'ops_btns'
			])
			->filterColumn('name', function ($query, $keyword) {
				$query->where('pharmacists.name', 'like', "%" . $keyword . "%");
			})
			->filterColumn('email', function ($query, $keyword) {
				$query->where('pharmacists.email', 'like', "%" . $keyword . "%");
			})
			->filterColumn('phone', function ($query, $keyword) {
				$query->where('phones.number', 'like', "%" . $keyword . "%");
			})
			->filterColumn('pharmacy', function ($query, $keyword) {
				$query->where('pharmacies.name', 'like', "%" . $keyword . "%");
			})
			->filterColumn('created_at', function ($query, $keyword) {
				$query->where('pharmacist.created_at', 'like', "%" . $keyword . "%");
			})
			->order(function ($query) {
				$columns = [
					'select' => 0,
					'name' => 1,
					'email' => 2,
					'phone' => 3,
					'pharmacy' => 4,
					'created_at' => 5,

				];

				$direction = request('order.0.dir');

				if (request('order.0.column') == $columns['name']) {
					$query->orderBy('pharmacists.name', $direction);
				}
				if (request('order.0.column') == $columns['email']) {
					$query->orderBy('pharmacists.email', $direction);
				}
				if (request('order.0.column') == $columns['phone']) {
					$query->orderBy('phones.number', $direction);
				}
				if (request('order.0.column') == $columns['pharmacy']) {
					$query->orderBy('pharmacies.name', $direction);
				}
				if (request('order.0.column') == $columns['created_at']) {
					$query->orderBy('pharmacists.created_at', $direction);
				}
			})
			->smart(0)
			->toJson();
	}

	public function assignePharmacist(Request $request)
	{

		if (empty($request->select)) {
			return redirect()->back()->with("alert", ['type' => 'danger', 'msg' => 'Please select a pharmacist then submit!']);
		}

		$pharmacy_id = $request->pharmacy_id;
		$pharmacistInfo = $request->select;

		$Pharmacist = Pharmacist::whereIn('id', $pharmacistInfo)->update(['pharmacy_id' => $pharmacy_id]);

		return redirect()->back()
			->with("alert", ['type' => 'success', 'msg' => 'Pharmacist added successfully']);
	}


	public function pharmacistremove(Request $request)
	{
		$id = $request->id;
		$resourceData = Pharmacist::find($id);
		$resourceData->pharmacy_id = null;
		if ($resourceData->save()):
			return [
				'result' => 'success'
			];
		endif;
	}

	public function newpharmacist(Request $request)
	{
		// dd($request->all());
		if ($request->input('name') && $request->input('name')[0] != null) {
			$name = array_values($request->input('name'));
			$email = array_values($request->input('email'));
			$phone_number = array_values($request->input('phone'));

			for ($i = 0; $i < count($name); $i++) {
				$pharmacist = new Pharmacist();
				$pharmacist->id = $this->newID(Pharmacist::class);
				$pharmacist->pharmacy_id = $request->input('pharmacy_id');
				$pharmacist->name = $name[$i];
				$pharmacist->email = $email[$i];

				$phone = new Phone();
				$phone->id = $pharmacist->phone = $this->newID(Phone::class);
				$phone->number = $phone_number[$i];
				$phone->country_id = $request->country_name;
				$phone->is_primary = 1;
				$phone->save();
				$pharmacist->save();

			}
			return redirect()->back()->with("alert", ['type' => 'success', 'msg' => 'Pharmacist information inserted successfully']);
		}
		return redirect()->back();
	}

}
