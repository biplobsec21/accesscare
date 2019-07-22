<?php

namespace App\Http\Controllers\Settings\Manage\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Country;
use Validator;
use App\Log;

/**
 * Class DrugDosageController
 * @package App\Http\Controllers\Settings\Manage\Drug
 *
 * @author Biplob Hossain <biplob@quasars.com>
 */

class CountryController extends Controller {
    public $_data = [
        // route load
        'editButton' => 'eac.portal.settings.manage.country.edit',
        'createButton' => 'eac.portal.settings.manage.country.create',
        'deleteButton' => 'eac.portal.settings.manage.countrydelete',
        'storeAction' => 'eac.portal.settings.manage.country.store',
        'updateAction' => 'eac.portal.settings.manage.country.update',
        'listAll' => 'eac.portal.settings.manage.country.index',
        'cancelAction' => 'eac.portal.settings.manage.country.index',
        // blade load
        'indexView' => 'portal.settings.manage.country.index',
        'createView' => 'portal.settings.manage.country.create',
        'editView' => 'portal.settings.manage.country.edit',
        'ajaxView' => 'portal.settings.manage.country.ajaview',
    ];
    
    public function __construct(){
//     $this->middleware('auth'); // auth check from the route
    }
    public function index(Request $request) {
        $rows = Country::all();
        return view($this->_data['indexView'])
                        ->with('page', $this->_data)
                        ->with('active', 'strength')
                        ->with('rows', $rows);
    }
    public function update(Request $request, $id) {
        $validator = Validator::make(
                        $request->all(), [
                    'name' => 'required|max:40',
                    'abbr' => 'required|max:5|unique:countries,abbr,'.$id,
                    'haa_prereq' => 'required',
                        ], [
                    'name.required' => ' Name Field is Required',
                    'abbr.required' => ' Abbr Field is Required',
                    'haa_prereq.required' => 'This is Required',
                        ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with("alerts", ['type' => 'danger', 'msg' => 'Error occured in the page!'])
                            ->with("errors", $validator->errors())
                            ->withInput()
                            ->with('page', $this->_data);
        } else {
            $rows = Country::find($id);
            $rows->name = $request->name;
            $rows->abbr = $request->abbr;
            $rows->haa_info = $request->haa_info;
            $rows->haa_prereq = $request->haa_prereq;
            $rows->ethics_req = $request->ethics_req ? 1 : 0;
            $rows->notes = $request->notes;
            $rows->index = $request->index ? $request->index : 0;
            // $rows->index = $request->index;
            $rows->avg_days_to_deliver_drug = $request->avg_days_to_deliver_drug;
            $rows->active = ($request->input('active') == 'on') ? 1 : 0;

            if ($rows->isDirty()) {
                $rows->save();
                return redirect()->back()
                                ->with("alerts", ['type' => 'success', 'msg' => 'Data Updated successfully']);
            }

            $rows->save();
            return redirect(route($this->_data['listAll']))
                            ->with("alerts", ['type' => 'success', 'msg' => 'Data Updated successfully']);
        }
    }

    public function store(Request $request) {
        // dd($request);

        $currentTimestamp = date('Y-m-d H:i:s');
        $validator = Validator::make(
                        $request->all(), [
                    'name' => 'required|max:40',
                    'abbr' => 'required|max:5|unique:countries,abbr',
                    'haa_prereq' => 'required',
                        ], [
                    'name.required' => ' Name Field is Required',
                    'abbr.required' => ' Abbr Field is Required',
                    'haa_prereq.required' => ' This is Required',
                        ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with("alerts", ['type' => 'danger', 'msg' => 'Error occured in the page!'])
                            ->with("errors", $validator->errors())
                            ->withInput()
                            ->with('page', $this->_data);
        } else {

            $rows = new Country();
            $rows->id = $this->newID(Country::class);
            $rows->name = $request->name;
            $rows->abbr = $request->abbr;
            $rows->haa_info = $request->haa_info;
            $rows->haa_prereq = $request->haa_prereq;
            $rows->ethics_req = $request->ethics_req ? 1 : 0;
            $rows->index = $request->index ? $request->index : 0;
            $rows->notes = $request->notes;
            // $rows->index = $request->index;
            $rows->avg_days_to_deliver_drug = $request->avg_days_to_deliver_drug;
            $rows->active = ($request->input('active') == 'on') ? 1 : 0;
            $rows->save();
            return redirect(route($this->_data['listAll']))
                            ->with("alerts", ['type' => 'success', 'msg' => 'Data inserted successfully']);
        }
    }
    public function create(Request $request) {

        $rows = Country::where('active', '!=', '');

        return view($this->_data['createView'])
                        ->with('active', 'create')
                        ->with('rows', $rows)
                        ->with('page', $this->_data);
    }

    public function ajaxlist() {

        $sql = Country::Where('active', '!=', null);
        return \DataTables::of($sql)
                ->setRowClass(function ($row) {
               
                if ($row->active == '1') {
                 $class = 'v-active';
                } else {

                   $class='v-inactive';

                }
                return $class;

                })
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('abbr', function ($row) {
                    return $row->abbr;
                })
                ->addColumn('days_to_deliver', function ($row) {
                    return $row->avg_days_to_deliver_drug;
                })

                ->addColumn('haa_info', function ($row) {
                    return $row->haa_info;
                })
                ->addColumn('active', function ($row) {
                    return $row->active == '1' ? '<span class="badge badge-success">
                Active
                </span>' : '<span class="badge badge-danger">
                Inactive
                </span>';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->updated_at->format(config('eac.date_format'));
                })
                ->addColumn('ops_btns', function ($row) {
                    return '

                <a title="Edit Country" href="' . route('eac.portal.settings.manage.country.edit', $row->id) . '">
                 <i class="far fa-edit" aria-hidden="true"></i> <span class="sr-only">Edit Country</span>
                </a>
                <a class="text-danger" href="#" onclick="Confirm_Delete(' . "'" . $row->id . "'" . ')">
                 <i class="far fa-times" aria-hidden="true"></i> <span class="sr-only">Delete Country</span>
                </a>
                ';
                })
                ->rawColumns([
                    'name',
                    'abbr',
                    'days_to_deliver',
                    'haa_info',
                    'active',
                    'created_at',
                    'ops_btns'
                ])
                ->filterColumn('name', function ($query, $keyword) {
                    $query->where('name', 'like', "%" . $keyword . "%");
                })
                ->filterColumn('haa_info', function ($query, $keyword) {
                    $query->where('haa_info', 'like', "%" . $keyword . "%");
                })
                ->filterColumn('abbr', function ($query, $keyword) {
                    $query->where('abbr', 'like', "%" . $keyword . "%");
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->where('updated_at', 'like', "%" . $keyword . "%");
                })
                ->filterColumn('active', function ($query, $keyword) {
                    $query->where('active', 'like', "%" . $keyword . "%");
                })
                ->filterColumn('days_to_deliver', function ($query, $keyword) {
                    $query->where('avg_days_to_deliver_drug', 'like', "%" . $keyword . "%");
                })
                ->order(function ($query) {
                    $columns = [
                        
                        'name' => 0,
                        'abbr' => 1,
                        'days_to_deliver' => 2,
                        'haa_info' => 3,
                        'active' => 4,
                        'created_at' => 5,
                    ];

                    $direction = request('order.0.dir');

                    if (request('order.0.column') == $columns['name']) {
                        $query->orderBy('name', $direction);
                    }
                    if (request('order.0.column') == $columns['abbr']) {
                        $query->orderBy('abbr', $direction);
                    }

                    if (request('order.0.column') == $columns['created_at']) {
                        $query->orderBy('updated_at', $direction);
                    }
                    if (request('order.0.column') == $columns['days_to_deliver']) {
                        $query->orderBy('avg_days_to_deliver_drug', $direction);
                    }
                    
                    if (request('order.0.column') == $columns['haa_info']) {
                        $query->orderBy('haa_info', $direction);
                    }
                    if (request('order.0.column') == $columns['active']) {
                        $query->orderBy('active', $direction);
                    }
                })
                ->smart(0)
                ->toJson();
    }

    public function edit($id) {

        $dosage = array();
        $rows = Country::where('id', '=', $id);
        if (!count($rows)) {
            return redirect(route($this->_data['listAll']));
        }

        return view($this->_data['editView'])
                        ->with('active', 'edit')
                        ->with('rows', $rows)
                        ->with('page', $this->_data);
    }
    public function delete(Request $request) {
        $id = $request->id;
        $resourceData = Country::find($id);
        if ($resourceData):
            if ($resourceData->delete()):
                return [
                    'result' => 'success'
                ];
            endif;
        endif;
    }

    public function logcountry(){
        $logData = $this->getLogs(Country::class);
        return view('portal.settings.manage.country.loglist')
                ->with('logData', $logData)
                ->with('page', $this->_data);
    }

    public function countrylogview($id){
         $logData  = Log::where('subject_id', $id);
         // echo $logData->id;
         // dd($logData);
    
         return view('portal.settings.manage.country.viewlogdetails')
                ->with('logData', $logData)
                ->with('page', $this->_data);

    }

    public function manageindexes(){
        $countryList = Country::orderBy('index','asc');

        return view('portal.settings.manage.country.manage_indexes')->with('countryList', $countryList);
    }

    public function storeindexes(Request $request){
        $orderedList = explode(',', $request->countries);
        for ($i=0; $i < count($orderedList); $i++) { 
            Country::where('id', $orderedList[$i])->update(['index' => ($i+1)]);
        }
        return redirect()->back()->with("alerts", ['type' => 'success', 'msg' => 'Index Updated successfully']);

    }

}