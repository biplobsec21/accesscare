<?php

namespace App\Http\Controllers\Settings\Manage\Drug;

use App\Traits\Logger;
use Illuminate\Http\Request;
use App\Dosage;
use App\DosageUnit;
use App\DosageRoute;
use App\DosageStrength;
use App\DosageForm;
use App\Http\Controllers\Controller;
use App\Http\Requests\Drug\Dosage\CreateRequest;
use App\Http\Requests\Drug\Dosage\UpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;

/**
 * Class DrugDosageController
 * @package App\Http\Controllers\Settings\Manage\Drug
 *
 * @author Biplob Hossain <biplob@quasars.com>
 */

class DrugDosageFormController extends Controller {
    use Logger;
    public $_data = [
        // route load
        'editButton' => 'eac.portal.settings.manage.drug.dosage.form.edit',
        'createButton' => 'eac.portal.settings.manage.drug.dosage.form.create',
        'deleteButton' => 'eac.portal.settings.manage.drug.dosage.form.delete',
        'storeAction' => 'eac.portal.settings.manage.drug.dosage.form.store',
        'updateAction' => 'eac.portal.settings.manage.drug.dosage.form.update',
        'listAll' => 'eac.portal.settings.manage.drug.dosage.form.index',
        'cancelAction' => 'eac.portal.settings.manage.drug.dosage.form.index',
        'logsr' => 'eac.portal.settings.manage.drug.dosage.form.logs',
        'logsviewr' => 'eac.portal.settings.manage.drug.dosage.form.logsview',
        // blade load
        'indexView' => 'portal.settings.manage.drug.form.index',
        'createView' => 'portal.settings.manage.drug.form.create',
        'editView' => 'portal.settings.manage.drug.form.edit',
        'ajaxView' => 'portal.settings.manage.drug.form.ajaview',
        'logsv' => 'portal.settings.manage.drug.form.log',
        'logsviewv' => 'portal.settings.manage.drug.form.log_view',
    ];

    public function __construct(){
//     $this->middleware('auth'); // auth check from the route
    }
    public function index(Request $request) {
        $dosageForms = DosageForm::all();

        return view($this->_data['indexView'])
                        ->with('page', $this->_data)
                        ->with('active', 'dosage')
                        ->with('dosageForms', $dosageForms);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $validator = Validator::make(
                        $request->all(), [
                    'name' => 'required|max:40',
                    'route_id' => 'required',
                        ], [
                    'name.required' => ' Name Field is Required',
                    'route_id.required' => ' Route Field is Required',
                        ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with("alert", ['type' => 'danger', 'msg' => 'Error occured in the page!'])
                            ->with("errors", $validator->errors())
                            ->withInput()
                            ->with('page', $this->_data);
        } else {

            $dosageForm = DosageForm::find($id);
            $dosageForm->name = $request->name;
            $dosageForm->route_id = $request->route_id;
            $dosageForm->desc = $request->desc;
            $dosageForm->active = ($request->input('active') == 'on') ? 1 : 0;
            $dosageForm->concentration_req = $request->concentration_req;

            if ($dosageForm->isDirty()) {
                $dosageForm->save();
                return redirect()->back()
                                ->with("alert", ['type' => 'success', 'msg' => 'Data Updated successfully']);
            }

            $dosageForm->save();
            return redirect(route($this->_data['listAll']))
                            ->with("alert", ['type' => 'success', 'msg' => 'Data Updated successfully']);
        }
    }

    public function store(Request $request) {

        $currentTimestamp = date('Y-m-d H:i:s');
        $validator = Validator::make(
                        $request->all(), [
                    'name' => 'required|max:40',
                    'route_id' => 'required',
                        ], [
                    'name.required' => ' Name Field is Required',
                    'route_id.required' => ' Route Field is Required',
                        ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with("alert", ['type' => 'danger', 'msg' => 'Error Occured in page !'])
                            ->with("errors", $validator->errors())
                            ->withInput()
                            ->with('page', $this->_data);
        } else {

            $dosageForm = new DosageForm();
            $dosageForm->id = $this->newID(DosageForm::class);
            $dosageForm->name = $request->name;
            $dosageForm->route_id = $request->route_id;
            $dosageForm->desc = $request->desc;
            $dosageForm->active = ($request->input('active') == 'on') ? 1 : 0;
            $dosageForm->concentration_req = $request->concentration_req;
            $dosageForm->save();
            return redirect(route($this->_data['listAll']))
                            ->with("alert", ['type' => 'success', 'msg' => 'Data inserted successfully']);
        }
    }

    public function create(Request $request) {
        $dosage = array();

        $dosage['dosageUnite'] = DosageUnit::where('active', '1')->get();
        $dosage['dosageRoute'] = DosageRoute::where('active', '1')->get();
        $dosage['dosageStrength'] = DosageStrength::where('active', '1')->get();
        $dosage['dosageForm'] = DosageForm::where('active', '1')->get();

        return view($this->_data['createView'])
                        ->with('active', 'create')
                        ->with('dosage', $dosage)
                        ->with('page', $this->_data);
    }

    public function ajaxlist() {

        $sql = DosageForm::Where('dosage_forms.active', '!=', null)
                ->join('dosage_routes', 'dosage_forms.route_id', '=', 'dosage_routes.id')
                ->select([
            'dosage_forms.id as id',
            'dosage_forms.active as active',
            'dosage_forms.name as name',
            'dosage_forms.concentration_req as concentration_req',
            'dosage_forms.created_at as created_at',
            'dosage_forms.updated_at as updated_at',
            'dosage_forms.desc as desc',
            'dosage_routes.name as route_name'
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
                ->addColumn('route_id', function ($row) {
                    return $row->route_name;
                })
                ->addColumn('active', function ($row) {
                    return $row->active == '1' ? '<span class="badge badge-success">Active
                </span>' : '<span class="badge badge-danger">
                Inactive
                </span>';
                })
                ->addColumn('concentration_req', function ($row) {
                    return $row->concentration_req == '1' ? '<span class="badge badge-success">
                        Yes
                        </span>' : '<span class="badge badge-danger">
                         No
                        </span>';
                })
                ->addColumn('desc', function ($row) {
                    return $row->desc;
                })
                ->addColumn('created_at', function ($row) {
                    return $row->updated_at->format(config('eac.date_format'));
                })
                ->addColumn('ops_btns', function ($row) {
                    return '
                    <a title="Edit Form" href="' . route('eac.portal.settings.manage.drug.dosage.form.edit', $row->id) . '">
                     <i class="far fa-edit" aria-hidden="true"></i> <span class="sr-only">Edit Form</span>
                    </a>
                    <a class="text-danger" href="#" onclick="ConfirmDoseDelete(' . "'" . $row->id . "'" . ')">
                     <i class="far fa-times" aria-hidden="true"></i> <span class="sr-only">Delete Form</span>
                    </a>
                    ';
                })
                ->rawColumns([
                    'name',
                    'route_id',
                    'active',
                    'concentration_req',
                    'desc',
                    'created_at',
                    'ops_btns'
                ])
                ->filterColumn('name', function ($query, $keyword) {
                    $query->where('dosage_forms.name', 'like', "%" . $keyword . "%");
                })
                ->filterColumn('route_id', function ($query, $keyword) {
                    $query->where('dosage_routes.name', 'like', "%" . $keyword . "%");
                })
                ->filterColumn('desc', function ($query, $keyword) {
                    $query->where('dosage_forms.desc', 'like', "%" . $keyword . "%");
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->where('dosage_forms.updated_at', 'like', "%" . $keyword . "%");
                })
                ->order(function ($query) {
                    $columns = [
                        'name' => 0,
                        'route_id' => 1,
                        'active' => 2,
                        'concentration_req' => 3,
                        'desc' => 4,
                        'created_at' => 5,
                    ];

                    $direction = request('order.0.dir');

                    if (request('order.0.column') == $columns['name']) {
                        $query->orderBy('dosage_forms.name', $direction);
                    }
                    if (request('order.0.column') == $columns['route_id']) {
                        $query->orderBy('dosage_routes.name', $direction);
                    }
                    if (request('order.0.column') == $columns['active']) {
                        $query->orderBy('dosage_forms.active', $direction);
                    }
                    if (request('order.0.column') == $columns['desc']) {
                        $query->orderBy('dosage_forms.desc', $direction);
                    }
                    if (request('order.0.column') == $columns['created_at']) {
                        $query->orderBy('dosage_forms.updated_at', $direction);
                    }
                })
                ->smart(0)
                ->toJson();
    }

    public function edit($id) {
        $dosage = array();
        $dosage['dosageUnite'] = DosageUnit::where('active', '1')->get();
        $dosage['dosageRoute'] = DosageRoute::where('active', '1')->get();
        $dosage['dosageStrength'] = DosageStrength::where('active', '1')->get();
        $dosage['dosageForm'] = DosageForm::where('id', $id)->get();

        if (!count($dosage['dosageForm'])) {
            return redirect(route($this->_data['listAll']));
        }

        return view($this->_data['editView'])
                        ->with('active', 'edit')
                        ->with('dosage', $dosage)
                        ->with('page', $this->_data);
    }

    public function delete(Request $request) {
        $id = $request->id;
        $resourceData = DosageForm::find($id);
        if ($resourceData):
            if ($resourceData->delete()):
                return [
                    'result' => 'success'
                ];
            endif;

        endif;
    }
    public function logs(){
            $logData = $this->getLogs(DosageForm::class);
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
