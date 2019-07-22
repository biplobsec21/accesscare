<?php

namespace App\Http\Controllers\Drug;

use App\Address;
use App\Depot;
use App\MergeData;
use App\Drug;
use App\RidShipment;
use App\DrugLot;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DEVUPDATESCRIPTTABLE;
use DB;
/**
 * Class DrugDepotController
 * @package App\Http\Controllers\Drug
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class DrugDepotController extends Controller
{

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
		$depots = Depot::all();
		return view('portal.drug.depot.list', [
			'depots' => $depots,
		]);
	}

	public function create()
	{
		$countries = $this->getCountry();
		$states = \App\State::all()->sortBy('name');
		return view('portal.drug.depot.create', [
			'states' => $states,
			'countries' => $countries,
		]);
	}

	public function edit($id)
	{
		$depot = Depot::where('id', $id)->firstOrFail();
		$countries = $this->getCountry();
		$states = \App\State::all()->sortBy('name');
		return view('portal.drug.depot.edit', [
			'states' => $states,
			'countries' => $countries,
			'depot' => $depot,
		]);
	}
	public function ajaxlist(){
		// $sql = Depot::where('id','!=', '');
		$sql = Depot::Where('depots.id', '!=', '')
				->Leftjoin('drug_lots', 'depots.id', '=', 'drug_lots.depot_id')
				->Leftjoin('addresses', 'depots.address_id', '=', 'addresses.id')
				->Leftjoin('countries', 'addresses.country_id', '=', 'countries.id')
				->groupBy('depots.id')
				->select(
					DB::raw("count(drug_lots.depot_id) as lots"),
					'depots.name as name',
					'depots.id as id',
					'addresses.addr1 as addr1',
					'addresses.addr2 as addr2',
					'addresses.country_id as country_id',
					'countries.name as country',
					'depots.created_at as created_at',
					'depots.updated_at as updated_at');

		return \DataTables::of($sql)
		->addColumn('name', function ($row) {
			return $row->name;
		})->addColumn('lot', function ($row) {
			return '<span class="badge badge-dark">' . $row->lots . '</span>';
			
		})->addColumn('address', function ($row) {
			$ad1 = $row->addr1 ? $row->addr1 : '';
			$ad2 = $row->addr2 ? $row->addr2 : '';
			return $ad1 . $ad2;
		})->addColumn('country', function ($row) {
			// return $row->first_name . " " . $row->last_name;
			return $row->country;

		})->addColumn('created_at', function ($row) {
			return $row->updated_at ? $row->updated_at->format(config('eac.date_format')) : '';
		})->addColumn('ops_btns', function ($row) {
			return '
				      <a title="Edit Depot" href="' . route('eac.portal.depot.edit', $row->id) . '">
				       <i class="far fa-edit" aria-hidden="true"></i> <span class="sr-only">Edit Depot</span>
				      </a>
						';
		})->rawColumns([
			'name', 
			'lot', 
			'address', 
			'country', 
			'created_date', 
			'ops_btns'
		])
		->filterColumn('name', function ($query, $keyword) {
			$query->where('depots.name', 'like', "%" . $keyword . "%");
		})
		->filterColumn('lot', function ($query, $keyword) {
			$query->whereRaw("count(drug_lots.depot_id) like ?", ["%{$keyword}%"]);
		})
		->filterColumn('address', function ($query, $keyword) {
			$query->where('addresses.addr1', 'like', "%" . $keyword . "%");
			$query->OrWhere('addresses.addr2', 'like', "%" . $keyword . "%");
		})
		->filterColumn('country', function ($query, $keyword) {
			$query->where('countries.name', 'like', "%" . $keyword . "%");
		})
		->filterColumn('created_at', function ($query, $keyword) {
			$query->where('depots.updated_at', 'like', "%" . $keyword . "%");
		})
		
		->order(function ($query) {
                    $columns = [
                        
						'name' => 0,
						'lot' => 1,
						'address' => 2,
						'country' => 3,
						'created_at' => 4,
                    ];

                    $direction = request('order.0.dir');

                    if (request('order.0.column') == $columns['name']) {
                        $query->orderBy('depots.name', $direction);
                    }
                    if (request('order.0.column') == $columns['lot']) {
                        $query->orderBy('lots', $direction);
                    }
                    if (request('order.0.column') == $columns['address']) {
                        $query->orderBy('addresses.addr1', $direction);
                    }
                     if (request('order.0.column') == $columns['country']) {
                        $query->orderBy('countries.name', $direction);
                    }
                     if (request('order.0.column') == $columns['created_at']) {
                        $query->orderBy('depots.updated_at', $direction);
                    }
                    
                   
                })
                ->smart(0)
                ->toJson();
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$depot = new Depot();
		$address = new Address();
		$depot->id = $this->newID(Depot::class);
		$depot->name = $request->input('depot_name');
		$depot->address_id = $address->id = $this->newID(Address::class);
		$address->addr1 = $request->input('depot_addr1');
		$address->addr2 = $request->input('depot_addr2');
		$address->city = $request->input('depot_city');
		$address->state_province = $request->input('depot_state_province');
		$address->country_id = $request->input('depot_country_id');
		$address->zipcode = $request->input('depot_zip');
		$address->save();
		$depot->save();

		return redirect()->route('eac.portal.depot.list.all');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  string $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$depot = Depot::where('id', '=', $id)->firstOrFail();
		$address = Address::where('id', '=', $depot->address_id)->firstOrFail();
		$depot->name = $request->input('depot_name');
		$address->addr1 = $request->input('depot_addr1');
		$address->addr2 = $request->input('depot_addr2');
		$address->city = $request->input('depot_city');
		$address->state_province = $request->input('depot_state_province');
		$address->country_id = $request->input('depot_country_id');
		$address->zipcode = $request->input('depot_zip');
		$address->save();
		$depot->save();
		return redirect()->route('eac.portal.depot.list.all')->with('confirm', 'Depot Has Been Updated.');
	}

	public function inform()
	{
		$depot = Depot::where('id', '=', $_POST['depot_id'])->firstOrFail();
		$address = Address::where('id', '=', $depot->address_id)->firstOrFail();
		$str = '<strong>' . $depot->name . '</strong></br>';
		$str .= $address->strDisplay();
		return $str;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return mixed
	 */
	public function destroy($id)
	{
		return false;
	}
	// merge view load
	public function merge()
	{
		$depots = Depot::all();
		return view('portal.drug.depot.listmerge', [
			'depots' => $depots,
		]);
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
		$rowsPrimary = Depot::where('id',$primary_id);

		$merge_id = $request->merge;
		$rowsMerge = Depot::whereIn('id', $merge_id);

		return view('portal.drug.depot.selectedmerge', [
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
		$table_name = "depots";

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

		 
		// replace depot_id in rid_shipment and drug_lots table by primary id
		$ridShipment = RidShipment::whereIn('depot_id',$merge_data)->update(['depot_id'=>$primary_data]);
		$updatedShipment=RidShipment::whereIn('depot_id',$merge_data);



		$drugLot = DrugLot::whereIn('depot_id',$merge_data)->update(['depot_id'=>$primary_data]);
		$updatedDrugLot=DrugLot::whereIn('depot_id',$merge_data);
		
		// remove primary id from selected merge data 
		$temparray = array($primary_data);
		$result = array_diff($merge_data, $temparray);
		$remove = Depot::whereIn('id', $result)->delete();

		return redirect(route('eac.portal.depot.list.merge'))
                            ->with("alerts_merge", ['type' => 'success', 'msg' => $updatedShipment->count()." Rid shipments depots and ".$updatedDrugLot->count()." drug lot's depot updated"])
                            ->with("alerts", ['type' => 'success', 'msg' => 'Depot Merged successfully']);
		
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

	public function remove(Request $request){
        $id = $request->id;
        $resourceData = Depot::find($id);
        if ($resourceData):
            if ($resourceData->delete()):
                return [
                    'result' => 'success'
                ];
            endif;
        endif;
    
	}
}
