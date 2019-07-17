<?php

namespace App\Http\Controllers\Settings\Manage\Rid;

use App\DenialReason;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

/*/**
 * Class ShippingCourierController
 * @package App\Http\Controllers\Settings\Manage\Drug
 *
 * @author Biplob Hossain <biplob@quasars.com>
 */
class DenialReasonController extends Controller {


    public $_data = [
        // route load
        'editButton' => 'eac.portal.settings.manage.drug.dosage.strength.edit',
        'createButton' => 'eac.portal.settings.manage.rid.denial.reason.create',
        'deleteButton' => 'eac.portal.settings.manage.rid.denial.reason.delete',
        'storeAction' => 'eac.portal.settings.manage.rid.denial.reason.store',
        'updateAction' => 'eac.portal.settings.manage.rid.denial.reason.update',
        'listAll' => 'eac.portal.settings.manage.rid.denial.reason.index',
        'cancelAction' => 'eac.portal.settings.manage.rid.denial.reason.index',
        'logsr' => 'eac.portal.settings.manage.rid.denial.reason.loglist',
        'logsviewr' => 'eac.portal.settings.manage.rid.denial.reason.ridreasonlogview',
        // blade load
        'indexView' => 'portal.settings.manage.rid.denial.reason.index',
        'createView' => 'portal.settings.manage.rid.denial.reason.create',
        'editView' => 'portal.settings.manage.rid.denial.reason.edit',
        'ajaxView' => 'portal.settings.manage.rid.denial.reason.ajaxview',
        'logsv' => 'portal.settings.manage.rid.denial.reason.loglist',
        'logsviewv' => 'portal.settings.manage.rid.denial.reason.log_view',
    ];
    
    public function __construct(){
//     $this->middleware('auth'); // auth check from the route
    }
    public function index() {
        $allReasonList = DenialReason::Where('id','!=','');
        return view($this->_data['indexView'])
                        ->with('page', $this->_data)
                        ->with('allReasonList', $allReasonList);
    }

    public function ajaxlist(){
      $sql = DenialReason::Where('id','!=','');
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
                ->addColumn('description', function ($row) {
                    return $row->description;
                })    
                ->addColumn('status', function ($row) {
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

                <a title="Edit Denial Reason Courier" href="' .  route('portal.settings.manage.rid.denial.reason.edit', $row->id) . '">
                <i class="far fa-edit" aria-hidden="true"></i> <span class="sr-only">Edit Denial Reason </span>
                </a>
                
                ';
                })
                ->rawColumns([
                    'name',
                    'description',
                    'status',
                    'created_at',
                    'ops_btns'
                ])
                ->filterColumn('name', function ($query, $keyword) {
                    $query->where('name', 'like', "%" . $keyword . "%");
                })
                ->filterColumn('description', function ($query, $keyword) {
                    $query->where('description', 'like', "%" . $keyword . "%");
                })
               
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->where('updated_at', 'like', "%" . $keyword . "%");
                })
                ->order(function ($query) {
                    $columns = [
                        'name' => 0,
                        'description' => 1,
                        'status' => 2,
                        'created_at' => 3,
                       
                    ];

                    $direction = request('order.0.dir');

                    if (request('order.0.column') == $columns['name']) {
                        $query->orderBy('name', $direction)->orderBy('name', $direction);
                    }
                    if (request('order.0.column') == $columns['description']) {
                        $query->orderBy('description', $direction);
                    }
                    if (request('order.0.column') == $columns['status']) {
                        $query->orderBy('active', $direction);
                    }

                    if (request('order.0.column') == $columns['created_at']) {
                        $query->orderBy('updated_at', $direction);
                    }
                })
                ->smart(0)
                ->toJson();
    }

    
    public function delete(Request $request) {
        $id = $request->id;
        $resourceData = DenialReason::find($id);
        if ($resourceData):

            if ($resourceData->delete()):
                return [
                    'result' => 'success'
                ];
            endif;
        endif;
    }


    public function create(Request $request) {
        return view($this->_data['createView'])
                        ->with('active', 'create')
                        ->with('page', $this->_data);
    }

    public function store(Request $request) {

        // dd($_POST);

        $currentTimestamp = date('Y-m-d H:i:s');
        $validator = Validator::make(
                        $request->all(), [
                    'name' => 'required',
                    
                        ], [
                    'name.required' => ' Name Field is Required',
                    
                        ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with("alerts", ['type' => 'danger', 'msg' => 'Error occured in the page!'])
                            ->with("errors", $validator->errors())
                            ->withInput()
                            ->with('page', $this->_data);
        } else {

            $rows = new DenialReason();
            $rows->id = $this->newID(DenialReason::class);
            $rows->name = $request->name;
            $rows->description = $request->description;
            $rows->active = ($request->input('active') == 'on') ? 1 : 0;

            $rows->save();
            return redirect(route($this->_data['listAll']))
                            ->with("alerts", ['type' => 'success', 'msg' => 'Data inserted successfully']);
        }
    }

    public function edit($id) {

        $dosage = array();
        $rows = DenialReason::where('id', '=', $id);
        if (!count($rows)) {
            return redirect(route($this->_data['listAll']));
        }

        return view($this->_data['editView'])
                        ->with('active', 'edit')
                        ->with('rows', $rows)
                        ->with('page', $this->_data);
    }

    public function update(Request $request, $id) {
        $validator = Validator::make(
                        $request->all(), [
                    'name' => 'required',
                   
                        ], [
                    'name.required' => ' Name Field is Required',
                        ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with("alerts", ['type' => 'danger', 'msg' => 'Error occured in the page!'])
                            ->with("errors", $validator->errors())
                            ->withInput()
                            ->with('page', $this->_data);
        } else {
            $rows = DenialReason::find($id);
            $rows->name = $request->name;
            $rows->description = $request->description;
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

    public function loglist(){
            $logData = $this->getLogs(DenialReason::class);
            // dd($logData);
            return view($this->_data['logsv'], [
            'logData' => $logData,
                        'page'=> $this->_data
        ]);
        }
    public function logsview(Request $request,$id){
            $logData = \App\Log::where('subject_id','=',$id);
            return view($this->_data['logsviewv'], [
            'logData' => $logData,
                        'page'=> $this->_data
        ]);
    }
    
    
}
