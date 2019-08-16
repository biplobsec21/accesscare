<?php

namespace App\Http\Controllers\Settings\Manage\Ethnicity;
use App\Traits\Logger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ethnicity;
use App\Log;
use Validator;

class EthnicityController extends Controller {
    use Logger;
    public $_data = [
        // route load
        'editButton' => 'eac.portal.settings.manage.ethnicity.edit',
        'createButton' => 'eac.portal.settings.manage.ethnicity.create',
        'deleteButton' => 'eac.portal.settings.manage.ethnicitydelete',
        'storeAction' => 'eac.portal.settings.manage.ethnicity.store',
        'updateAction' => 'eac.portal.settings.manage.ethnicity.update',
        'listAll' => 'eac.portal.settings.manage.ethnicity.index',
        'cancelAction' => 'eac.portal.settings.manage.ethnicity.index',
        // blade load
        'indexView' => 'portal.settings.manage.ethnicity.index',
        'createView' => 'portal.settings.manage.ethnicity.create',
        'editView' => 'portal.settings.manage.ethnicity.edit',
        'ajaxView' => 'portal.settings.manage.ethnicity.ajaview',
    ];

    public function __construct(){
//     $this->middleware('auth'); // auth check from the route
    }
    public function index(Request $request) {
        // dd($logsData);
        $rows = Ethnicity::all();
        return view($this->_data['indexView'])
                        ->with('page', $this->_data)
                        ->with('active', 'strength')
                        ->with('rows', $rows);
    }
    public function update(Request $request, $id) {
        $validator = Validator::make(
                        $request->all(), [
                    'name' => 'required|max:40',
                        ], [
                    'name.required' => ' Name Field is Required',
                        ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with("alert", ['type' => 'danger', 'msg' => 'Error occured in the page!'])
                            ->with("errors", $validator->errors())
                            ->withInput()
                            ->with('page', $this->_data);
        } else {
            $rows = Ethnicity::find($id);
            $rows->name = $request->name;
            $rows->notes = $request->notes;
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

    		],[
    			'name.required' => ' The name field is required.',

    		]);

        // if ($validator->fails()) {
        //     return redirect()->back()->with("alert", ['type' => 'danger', 'msg' => 'Error occured in the page!'])
        //                     ->with("errors", $validator->errors())
        //                     ->withInput()
        //                     ->with('page', $this->_data);
        // } else {

            $rows = new Ethnicity();
			$rows->id = $this->newID(Ethnicity::class);
            $rows->name = $request->name;
            $rows->notes = $request->notes;
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

        $rows = Ethnicity::where('active', '!=', '');

        return view($this->_data['createView'])
                        ->with('active', 'create')
                        ->with('rows', $rows)
                        ->with('page', $this->_data);
    }

    public function ajaxlist() {

        $sql = Ethnicity::where('ethnicity.active', '!=', null)
                 ->select([
            'ethnicity.name as name',
            'ethnicity.notes as notes',
            'ethnicity.active as active',
            'ethnicity.id as id',
            'ethnicity.created_at as created_at',
            'ethnicity.updated_at as updated_at',

        ]);
        return \DataTables::of($sql)
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
               ->setRowClass(function ($row) {

                if ($row->active == '1') {
                 $class = 'v-active';
                } else {

                   $class='v-inactive';

                }
                return $class;

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
                <a  href="' . route('eac.portal.settings.manage.ethnicity.edit', $row->id) . '">
                <i class="far fa-edit" aria-hidden="true"></i>
                </a>
                <a class="text-danger" href="#" onclick="Confirm_Delete(' . "'" . $row->id . "'" . ')">
                <i class="far fa-times" aria-hidden="true"></i> 
                </a>
                ';
                })
                ->rawColumns([
                    'name',
                    'notes',
                    'active',
                    'created_at',
                    'ops_btns'
                ])
                ->filterColumn('name', function ($query, $keyword) {
                    $query->where('ethnicity.name', 'like', "%" . $keyword . "%");
                })

                ->filterColumn('notes', function ($query, $keyword) {
                    $query->where('ethnicity.notes', 'like', "%" . $keyword . "%");
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->where('ethnicity.updated_at', 'like', "%" . $keyword . "%");
                })
                ->order(function ($query) {
                    $columns = [
						'name'=>0,
						'notes'=>1,
						'active'=>2,
						'created_at'=>3,
                    ];

                    $direction = request('order.0.dir');

                    if (request('order.0.column') == $columns['name']) {
                        $query->orderBy('ethnicity.name', $direction);
                    }
                     if (request('order.0.column') == $columns['notes']) {
                        $query->orderBy('ethnicity.notes', $direction);
                    }
                    if (request('order.0.column') == $columns['active']) {
                        $query->orderBy('ethnicity.active', $direction);
                    }

                    if (request('order.0.column') == $columns['created_at']) {
                        $query->orderBy('ethnicity.updated_at', $direction);
                    }
                })
                ->smart(0)
                ->toJson();
    }

 //    public function delete(Request $request)
	// {


	// }

    public function edit($id) {
    	$rows = Ethnicity::where('id',$id)->first();

    	// dd($allcountrylist);

    	 return view($this->_data['editView'])
                        ->with('page', $this->_data)
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
        $states = Ethnicity::find($stateId)->delete();
        return [
            "result" => "Success"
        ];
    }
    public function loglist() {

        $logData = $this->getLogs(Ethnicity::class);
        return view('portal.settings.manage.ethnicity.loglist')
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


         return view('portal.settings.manage.ethnicity.viewlogdetails')
                ->with('logData', $logData)
                ->with('page', $this->_data);

    }

}
