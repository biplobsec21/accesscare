<?php

namespace App\Http\Controllers\Settings\Manage\Drug;

use Illuminate\Http\Request;
use App\Dosage;
use App\DosageUnit;
use App\DosageRoute;
use App\DosageForm;
use App\Http\Controllers\Controller;
use App\Http\Requests\Drug\Dosage\CreateRequest;
use App\Http\Requests\Drug\Dosage\UpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;

/**
 * Class DrugDosageConcentrationController
 * @package App\Http\Controllers\Settings\Manage\Drug
 *
 * @author Biplob Hossain <biplob@quasars.com>
 */
class DrugDosageConcentrationController extends Controller {
    public $_data = [
        // route load
        'editButton' => 'eac.portal.settings.manage.drug.dosage.concentration.edit',
        'createButton' => 'eac.portal.settings.manage.drug.dosage.concentration.create',
        'deleteButton' => 'eac.portal.settings.manage.drug.dosage.concentrationdelete',
        'storeAction' => 'eac.portal.settings.manage.drug.dosage.concentration.store',
        'updateAction' => 'eac.portal.settings.manage.drug.dosage.concentration.update',
        'listAll' => 'eac.portal.settings.manage.drug.dosage.concentration.index',
        'cancelAction' => 'eac.portal.settings.manage.drug.dosage.concentration.index',
        'logsr' => 'eac.portal.settings.manage.drug.dosage.concentration.logs',
        'logsviewr' => 'eac.portal.settings.manage.drug.dosage.concentration.logsview',
        // blade load
        'indexView' => 'portal.settings.manage.drug.concentration.index',
        'createView' => 'portal.settings.manage.drug.concentration.create',
        'editView' => 'portal.settings.manage.drug.concentration.edit',
        'ajaxView' => 'portal.settings.manage.drug.concentration.ajaview',
        'logsv' => 'portal.settings.manage.drug.concentration.log',
        'logsviewv' => 'portal.settings.manage.drug.concentration.log_view',
    ];
    public function __construct()
    {
//     $this->middleware('auth'); // auth check from the route
    }
    public function index(Request $request) {
        $rows = DosageUnit::all();

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
            $rows = DosageUnit::find($id);
            $rows->name = $request->name;
            $rows->abbr = $request->abbr;
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

        $currentTimestamp = date('Y-m-d H:i:s');
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

            $rows = new DosageUnit();
            $rows->id = $this->newID(DosageUnit::class);
            $rows->name = $request->name;
            $rows->abbr = $request->abbr;
            $rows->active = ($request->input('active') == 'on') ? 1 : 0;
            $rows->save();
            return redirect(route($this->_data['listAll']))
                            ->with("alert", ['type' => 'success', 'msg' => 'Data inserted successfully']);
        }
    }
    public function create(Request $request) {
        $rows = DosageUnit::where('active', '!=', '');
        return view($this->_data['createView'])
                        ->with('active', 'create')
                        ->with('rows', $rows)
                        ->with('page', $this->_data);
    }

    public function ajaxlist() {

        $sql = DosageUnit::Where('active', '!=', null);


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
                ->addColumn('active', function ($row) {
                    return $row->active == '1' ? '<span class="badge badge-success">
                Active
                </span>' : '<span class="badge badge-danger">
                Inactive
                </span>';
                })
                ->addColumn('abbr', function ($row) {
                    return $row->abbr;
                })
                ->addColumn('created_at', function ($row) {
                    return $row->updated_at->format(config('eac.date_format'));
                })
                ->addColumn('ops_btns', function ($row) {
                    return '

                <a title="Edit Concentration" href="' . route('eac.portal.settings.manage.drug.dosage.concentration.edit', $row->id) . '">
                 <i class="far fa-edit" aria-hidden="true"></i> <span class="sr-only">Edit Concentration</span>
                </a>
                <a class="text-danger" href="#" onclick="Confirm_Delete(' . "'" . $row->id . "'" . ')">
                 <i class="far fa-times" aria-hidden="true"></i>  <span class="sr-only">Delete Concentration</span>
                </a>
                ';
                })
                ->rawColumns([
                    'name',
                    'active',
                    'abbr',
                    'created_at',
                    'ops_btns'
                ])
                ->filterColumn('name', function ($query, $keyword) {
                    $query->where('name', 'like', "%" . $keyword . "%");
                })
                ->filterColumn('abbr', function ($query, $keyword) {
                    $query->where('abbr', 'like', "%" . $keyword . "%");
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->where('updated_at', 'like', "%" . $keyword . "%");
                })
                ->order(function ($query) {
                    $columns = [
                        'name' => 0,
                        'active' => 1,
                        'abbr' => 2,
                        'created_at' => 3,
                    ];

                    $direction = request('order.0.dir');

                    if (request('order.0.column') == $columns['name']) {
                        $query->orderBy('name', $direction);
                    }
                    if (request('order.0.column') == $columns['active']) {
                        $query->orderBy('active', $direction);
                    }
                    if (request('order.0.column') == $columns['abbr']) {
                        $query->orderBy('abbr', $direction);
                    }

                    if (request('order.0.column') == $columns['created_at']) {
                        $query->orderBy('updated_at', $direction);
                    }
                })
                ->smart(0)
                ->toJson();
    }

    public function edit($id) {
        $dosage = array();
        $rows = DosageUnit::where('id', '=', $id)->get();
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
        $resourceData = DosageUnit::find($id);
        if ($resourceData):
            if ($resourceData->delete()):
                return [
                    'result' => 'success'
                ];
            endif;
        endif;
    }
    public function logs(){
            $logData = $this->getLogs(DosageUnit::class);
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
