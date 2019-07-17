<?php

namespace App\Http\Controllers\Rid;

use App\Address;
use App\RidVisit;
use App\Rid;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rid\Pharmacy\CreateRequest;
use App\Pharmacy;
use App\Pharmacist;
use App\RidShipment;
use App\MergeData;
use App\DEVUPDATESCRIPTTABLE;

use App\User;
use App\Phone;
use Illuminate\Http\Request;
use App\Traits\WorksWithRIDs;
use Validator;

/**
 * Class PharmacistController
 * @package App\Http\Controllers\Rid
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class PharmacistController extends Controller
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
		// dd($pharmacies);
		return view('portal.rid.pharmacist.list');
	}

	public function create()
	{
		$pharmacy = Pharmacy::all();
		$countries = $this->getCountry();
		return view('portal.rid.pharmacist.create', [
			'pharmacy' => $pharmacy,
			'countries' => $countries
		]);
	}

	public function edit($id)
	{
		$pharmacist = Pharmacist::where('id', $id)->firstOrFail();
		$pharmacy = Pharmacy::all();
		$countries = $this->getCountry();
		return view('portal.rid.pharmacist.edit', [
			'pharmacist' => $pharmacist,
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
	public function store(Request $request)
	{
		$validator = Validator::make(
                        $request->all(), [
                    'name' => 'required|max:40',
                    'email' => 'required|email:40',
                    'pharmacy_id' => 'required',
                    'country_name' => 'required',
                    'phone' => 'required',
                        ], [
                    'name.required' => ' Name Field is Required',
                    'email.required' => ' Email Field is Required',
                    'pharmacy_id.required' => ' Pharmacy id required',
                    'country_name.required' => ' Country name required',
                    'phone.required' => ' Phone is required',
                        ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with("alerts", ['type' => 'danger', 'msg' => 'Error occured in the page!'])
                            ->with("errors", $validator->errors())
                            ->withInput();
        }

		$pharmacist = new Pharmacist();
		$pharmacist->id = $this->newID(Pharmacist::class);
		$pharmacist->pharmacy_id = $request->input('pharmacy_id');
		$pharmacist->name = $request->input('name');
		$pharmacist->email = $request->input('email');

		if($request->phone){
			$phone = new Phone();
			$phone->id = $pharmacist->phone =  $this->newID(Phone::class);
			$phone->number = $request->phone;
			$phone->country_id = $request->country_name;
			$phone->is_primary = 1;
			$phone->save();
		}else{
			$pharmacist->phone = 0;
		}
		
		$pharmacist->save();

		return redirect()->route('eac.portal.pharmacist.list.all')->with("alerts", ['type' => 'success', 'msg' => 'Pharmacist inserted successfully']);;
	}

	public function update(Request $request,$id)
	{
		$validator = Validator::make(
                        $request->all(), [
                    'name' => 'required|max:40',
                    'email' => 'required|email:40',
                    'pharmacy_id' => 'required',
                    'country_name' => 'required',
                    'phone' => 'required',
                        ], [
                    'name.required' => ' Name Field is Required',
                    'email.required' => ' Email Field is Required',
                    'pharmacy_id.required' => ' Pharmacy id required',
                    'country_name.required' => ' Country name required',
                    'phone.required' => ' Phone is required',
                        ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with("alerts", ['type' => 'danger', 'msg' => 'Error occured in the page!'])
                            ->with("errors", $validator->errors())
                            ->withInput();
        }

		$pharmacist = Pharmacist::find($id);

		// $pharmacist->id = $this->newID(Pharmacist::class);
		$pharmacist->pharmacy_id = $request->input('pharmacy_id');
		$pharmacist->name = $request->input('name');
		$pharmacist->email = $request->input('email');

		if($request->phone){
			$phone = new Phone();
			$phone->id = $pharmacist->phone =  $this->newID(Phone::class);
			$phone->number = $request->phone;
			$phone->country_id = $request->country_name;
			$phone->is_primary = 1;
			$phone->save();
		}else{
			$pharmacist->phone = 0;
		}
		
		$pharmacist->save();
		if ($pharmacist->isDirty()) {
		        $rows->save();
		        return redirect()->back()
		                        ->with("alerts", ['type' => 'success', 'msg' => 'Pharmacist updated successfully ']);
		    }

		$pharmacist->save();
		return redirect()->route('eac.portal.pharmacist.list.all')->with("alerts", ['type' => 'success', 'msg' => 'Pharmacist updated successfully']);;
		
	}


	public function ajaxlist(){
		$sql = Pharmacist::Leftjoin('pharmacies', 'pharmacies.id', '=', 'pharmacists.pharmacy_id')
						->Leftjoin('phones', 'phones.id', '=', 'pharmacists.phone')
						->Where('pharmacists.id', '!=', '')
						->select([
					'pharmacies.id as pharmacy_id',
					'pharmacies.name as pharmacy_name',

					'pharmacists.name as name',
					'pharmacists.active as pharmacy_status',
					'pharmacists.id as id',

					'phones.number as phone',
					'pharmacists.email as email',
                    'pharmacists.updated_at as updated_at', 
					'pharmacists.created_at as created_at']);

        return \DataTables::of($sql)
        		 ->setRowClass(function ($row) {
                if ($row->pharmacy_status == '1') {
                 $class = 'v-active';
                } else {
                   $class='v-inactive';
                }
                return $class;

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
                 ->addColumn('status', function ($row) {
                 	if($row->pharmacy_status == 1 ){
                 	return '<span class="badge badge-info">Active</span>';
                 	}
                 	else{
                 	return '<span class="badge badge-warning">Inactive</span>';
                 	}

                })
                ->addColumn('pharmacy', function ($row) {

                    return $row->pharmacy_name ? $row->pharmacy_name : 'Not Assigned';
                })
               

                ->addColumn('created_at', function ($row) {
                    return $row->updated_at->format(config('eac.date_format'));
                })
                ->addColumn('ops_btns', function ($row) {
                    return '
                <a title="Edit Pharmacist" href="' . route('eac.portal.pharmacist.edit', $row->id) . '">
                 <i class="far fa-edit" aria-hidden="true"></i> <span class="sr-only">Edit Pharmacist</span>
                </a>
               
                ';
                })
                ->rawColumns([
                    'name',
                    'email',
                    'phone',
                    'status',
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
                    $query->where('pharmacist.updated_at', 'like', "%" . $keyword . "%");
                })
               
                ->order(function ($query) {
                    $columns = [
                        
						'name' => 0,
						'email' => 1,
						'phone' => 2,
						'status' => 3,
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
                    if (request('order.0.column') == $columns['status']) {
                        $query->orderBy('pharmacists.active', $direction);
                    }
                    if (request('order.0.column') == $columns['pharmacy']) {
                        $query->orderBy('pharmacies.name', $direction);
                    }
                    if (request('order.0.column') == $columns['created_at']) {
                        $query->orderBy('pharmacists.updated_at', $direction);
                    }
                })
                ->smart(0)
                ->toJson();
	}
	public function ajaxlistmerge(){
		$sql = Pharmacist::Leftjoin('pharmacies', 'pharmacies.id', '=', 'pharmacists.pharmacy_id')
						->Leftjoin('phones', 'phones.id', '=', 'pharmacists.phone')
						->Where('pharmacists.id', '!=', '')
						->select([
					'pharmacies.id as pharmacy_id',
					'pharmacies.name as pharmacy_name',

					'pharmacists.name as name',
					'pharmacists.id as id',

					'phones.number as phone',
					'pharmacists.email as email', 
					'pharmacists.created_at as created_at']);

        return \DataTables::of($sql)
        		->addColumn('primary', function ($row) {
					return '<input type="radio" name="primary" value="'.$row->id.'" />';
				})
				->addColumn('merge', function ($row) {
					return '<input type="checkbox" name="merge[]" value="'.$row->id.'" />';
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

                <a title="Edit Pharmacist" href="' . route('eac.portal.pharmacist.edit', $row->id) . '">
                 <i class="far fa-edit" aria-hidden="true"></i> <span class="sr-only">Edit Pharmacist</span>
                </a>
               
                ';
                })
                ->rawColumns([
                	'primary',
                	'merge',
                    'name',
                    'email',
                    'phone',
                    'pharmacy',
                    'created_at'
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
						'primary'=>0,
						'marge'=>1,
						'name' => 2,
						'email' => 3,
						'phone' => 4,
						'pharmacy' => 5,
						'created_at' => 6,
						
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
	// merge view load
	public function merge()
	{
		// $depots = Depot::all();
		return view('portal.rid.pharmacist.listmerge');
	}
	// merge view selected
	public function mergeselected(Request $request){
		if(!$request->primary){
			return redirect()->back()->with("alerts", ['type' => 'danger', 'msg' => 'Please select a primary data!']);
		}
		if(empty($request->merge)){
			return redirect()->back()->with("alerts", ['type' => 'danger', 'msg' => 'Please select a merge data!']);
		}
		$primary_id = $request->primary;
		$rowsPrimary = Pharmacist::where('id',$primary_id);

		$merge_id = $request->merge;
		$rowsMerge = Pharmacist::whereIn('id', $merge_id);

		return view('portal.rid.pharmacist.selectedmerge', [
			'rowsPrimary' => $rowsPrimary,
			'rowsMerge' => $rowsMerge,
		]);

	}
	// merge selected data post

	public function mergepost(Request $request){

		if(!$request->primary_id){ 	
			return redirect()->back()->with("alerts", ['type' => 'danger', 'msg' => 'Please select a primary data!']);
		}
		$primary_data = $request->primary_id;
		$merge_data = $request->merged_id;

		$merged_id = json_encode($merge_data);
		$table_name = "pharmacists";

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

		 
		// replace pharmacist_id in rid_shipment by primary id
		$ridShipment = RidShipment::whereIn('pharmacist_id',$merge_data)->update(['pharmacist_id'=>$primary_data]);
		$updatedShipment=RidShipment::whereIn('pharmacist_id',$merge_data);

		
		// remove primary id from selected merge data 
		$temparray = array($primary_data);
		$result = array_diff($merge_data, $temparray);
		$remove = Pharmacist::whereIn('id', $result)->delete();

		return redirect(route('eac.portal.pharmacist.list.merge'))
                            ->with("alerts_merge", ['type' => 'success', 'msg' => $updatedShipment->count()." Rid shipments pharmacist info. updated"])
                            ->with("alerts", ['type' => 'success', 'msg' => 'Pharmacist Merged successfully']);
		
	}
	// migration old_id 
	public function findOldId($array){
		$data = DEVUPDATESCRIPTTABLE::whereIn('id_new',$array)->select('id_old');
		// dd($data->toJson());
		$singleArray = [];
		if($data->count() > 0){
			foreach ($data as $key => $value){
				$singleArray[$key]=$value->id_old;
			}
			return json_encode($singleArray,TRUE);
		}
		

		return json_encode($singleArray,TRUE);
	}
	public function findOldprimaryId($array){
		$data = DEVUPDATESCRIPTTABLE::where('id_new',$array)->select('id_old')->first();
		// dd($data->toJson());

		if($data){
			return $data;
		}else{
			return '0';
			
		}
	}

	public function status($id){

		$pharmacist = Pharmacist::where('id', $id)->first();

		if($pharmacist->active == 1){
			// dd($pharmacist->is_active);
			$pharmacist->active = 0;
			$pharmacist->save();
		return redirect()->back()->with("alerts", ['type' => 'success', 'msg' => 'Inactive  successfully']);
		}
		else{
			$pharmacist->active = 1;
			$pharmacist->save();
		return redirect()->back()->with("alerts", ['type' => 'success', 'msg' => 'Active successfully']);
		}


	}
}
