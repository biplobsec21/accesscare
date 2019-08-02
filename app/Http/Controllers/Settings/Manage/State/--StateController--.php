<?php

namespace App\Http\Controllers\Settings\Manage\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\State;
use App\Country;
use App\Log;
use Validator;


/**
 * Class DrugDosageController
 * @package App\Http\Controllers\Settings\Manage\Drug
 *
 * @author Biplob Hossain <biplob@quasars.com>
 */

class StateController extends Controller {
    public $_data = [
        // route load
        'editButton' => 'eac.portal.settings.manage.states.edit',
        'createButton' => 'eac.portal.settings.manage.states.create',
        'deleteButton' => 'eac.portal.settings.manage.statesdelete',
        'storeAction' => 'eac.portal.settings.manage.states.store',
        'updateAction' => 'eac.portal.settings.manage.states.update',
        'listAll' => 'eac.portal.settings.manage.states.index',
        'cancelAction' => 'eac.portal.settings.manage.states.index',
        // blade load
        'indexView' => 'portal.settings.manage.state.index',
        'createView' => 'portal.settings.manage.state.create',
        'editView' => 'portal.settings.manage.state.edit',
        'ajaxView' => 'portal.settings.manage.state.ajaview',
    ];

    public function __construct(){
//     $this->middleware('auth'); // auth check from the route
    }
    public function index(Request $request) {
        // dd($logsData);
        $rows = State::all();
        return view($this->_data['indexView'])
                        ->with('page', $this->_data)
                        ->with('active', 'strength')
                        ->with('rows', $rows);
    }
    public function update(Request $request, $id) {
        $validator = Validator::make(
                        $request->all(), [
                    'name' => 'required|max:40',
                    'abbr' => 'required',
                    'country_id' => 'required',
                    'index' => 'required',
                        ], [
                    'name.required' => ' Name Field is Required',
                    'abbr.required' => ' Name Field is Required',
                        ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with("alert", ['type' => 'danger', 'msg' => 'Error occured in the page!'])
                            ->with("errors", $validator->errors())
                            ->withInput()
                            ->with('page', $this->_data);
        } else {
            $rows = State::find($id);
            $rows->name = $request->name;
            $rows->abbr = $request->abbr;
            $rows->country_id = $request->country_id;
            $rows->notes = $request->notes;
            $rows->index = $request->index;
            $rows->active = ($request->input('active') == 'on') ? 1 : 0;

            if ($rows->isDirty()) {
                $rows->save();
                return redirect()->back()
                                ->with("alert", ['type' => 'success', 'msg' => 'Data Updated successfully']);
            }

            $rows->save();
            return redirect(route($this->_data['listAll']))
                            ->with("alert", ['type' => 'success', 'msg' => 'Data Updated successfully']);
        }
    }

    public function store(Request $request) {
        // dd($request);

        $currentTimestamp = date('Y-m-d H:i:s');

        $this->validate($request,[
                'name' => 'required|max:40',
                'abbr' => 'required|max:5',
                'country_id' => 'required',
                'index' => 'required',

            ],[
                'name.required' => ' The name field is required.',
                'abbr.required' => ' The abbr field is required.',
                'country_id.required' => ' The country field is required.',
                'index.required' => 'The index field is required.',

            ]);

        // if ($validator->fails()) {
        //     return redirect()->back()->with("alert", ['type' => 'danger', 'msg' => 'Error occured in the page!'])
        //                     ->with("errors", $validator->errors())
        //                     ->withInput()
        //                     ->with('page', $this->_data);
        // } else {

            $rows = new State();
            $rows->id = $this->newID(State::class);
            $rows->name = $request->name;
            $rows->abbr = $request->abbr;
            $rows->country_id = $request->country_id;
            $rows->notes = $request->notes;
            $rows->index = $request->index;
            $rows->active = ($request->input('active') == 'on') ? 1 : 0;
            // dd($rows);
            $rows->save();
            return redirect(route($this->_data['listAll']))
                            ->with("alert", ['type' => 'success', 'msg' => 'Data inserted successfully']);
            // return redirect()->back()->with('success', 'Successfully added!');
        // }
    }
    public function create(Request $request) {
        // dd($request);

        $rows = State::where('active', '!=', '');
        $country  = Country::all()->sortBy('name');;

        return view($this->_data['createView'])
                        ->with('active', 'create')
                        ->with('rows', $rows)
                        ->with('country', $country)
                        ->with('page', $this->_data);
    }

    public function ajaxlist() {

        $sql = State::where('states.active', '!=', null)
                 ->leftJoin('countries', 'states.country_id', '=', 'countries.id')
                 ->select([
            'states.name as name',
            'states.abbr as abbr',
            'countries.name as country',
            'states.notes as notes',
            'states.created_at as created_at',
            'states.updated_at as updated_at',
            'states.active as active',
            'states.id as id'

        ]);
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
                 ->addColumn('country', function ($row) {
                    return $row->country;
                })
                ->addColumn('notes', function ($row) {
                    return $row->notes;
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
                <a title="Edit State" href="' . route('eac.portal.settings.manage.states.edit', $row->id) . '">
                 <i class="far fa-edit" aria-hidden="true"></i> <span class="sr-only">Edit State</span>
                </a>
                <a class="text-danger" href="#" onclick="Confirm_Delete(' . "'" . $row->id . "'" . ')">
                 <i class="far fa-times" aria-hidden="true"></i> <span class="sr-only">Delete State</span>  
                </a>
                ';
                })
                ->rawColumns([
                    'name',
                    'abbr',
                    'country',
                    'notes',
                    'active',
                    'created_at',
                    'ops_btns'
                ])
                ->filterColumn('name', function ($query, $keyword) {
                    $query->where('states.name', 'like', "%" . $keyword . "%");
                })
                ->filterColumn('abbr', function ($query, $keyword) {
                    $query->where('states.abbr', 'like', "%" . $keyword . "%");
                })
                ->filterColumn('country', function ($query, $keyword) {
                    $query->where('countries.name', 'like', "%" . $keyword . "%");
                })
                ->filterColumn('notes', function ($query, $keyword) {
                    $query->where('states.notes', 'like', "%" . $keyword . "%");
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->where('states.updated_at', 'like', "%" . $keyword . "%");
                })
                ->order(function ($query) {
                    $columns = [
                        'name'=>0,
                        'abbr'=>1,
                        'country'=>2,
                        'notes'=>3,
                        'active'=>4,
                        'created_at'=>5,
                    ];

                    $direction = request('order.0.dir');

                    if (request('order.0.column') == $columns['name']) {
                        $query->orderBy('states.name', $direction);
                    }
                    if (request('order.0.column') == $columns['active']) {
                        $query->orderBy('states.active', $direction);
                    }

                    if (request('order.0.column') == $columns['created_at']) {
                        $query->orderBy('states.updated_at', $direction);
                    }
                    if (request('order.0.column') == $columns['abbr']) {
                        $query->orderBy('states.abbr', $direction);
                    }
                })
                ->smart(0)
                ->toJson();
    }

 //    public function delete(Request $request)
    // {


    // }

    public function edit($id) {
        $rows = State::where('id',$id)->first();
        $country_id = $rows->country_id;
        $countydetails = Country::where('id',$country_id)->first();
        $allcountrylist = Country::all()->sortBy('name');

        // dd($allcountrylist);

         return view($this->_data['editView'])
                        ->with('page', $this->_data)
                        ->with('country', $countydetails)
                        ->with('allcountrylist', $allcountrylist)
                        ->with('rows', $rows)
                        ->with('active', 'edit');





        // $dosage = array();
        // $rows = State::where('id', '=', $id)->get();
        // $country = Country::where('id', '=', $id)->get();
        // if (!count($rows)) {
        //     return redirect(route($this->_data['listAll']));
        // }

        // return view($this->_data['editView'])
        //                 ->with('active', 'edit')
        //                 ->with('rows', $rows)
        //                 ->with('country', $country)
        //                 ->with('page', $this->_data);
    }
    // public function delete(Request $request) {
    //     $id = $request->id;
    //     $resourceData = State::find($id);
    //     if ($resourceData):
    //         if ($resourceData->delete()):
    //             return [
    //                 'result' => 'success'
    //             ];
    //         endif;
    //     endif;
    // }
    public function delete(Request $request) {
            $stateId = $request->id;
        $states = State::find($stateId)->delete();
        return [
            "result" => "Success"
        ];
    }
    public function loglist() {

        $logData = $this->getLogs(State::class);
        return view('portal.settings.manage.state.loglist')
                ->with('logData', $logData)
                ->with('page', $this->_data);

    }

    public function statelogview($id){
         $logData  = Log::where('subject_id', $id);
         // echo $id;
         // dd($logData);
        // $stateid= $id;
//          foreach ($logData as $foo){
//             foreach ($foo as $name){
// dd($name);
//             }

//          }


         return view('portal.settings.manage.state.viewlogdetails')
                ->with('logData', $logData)
                ->with('page', $this->_data);

    }

}
