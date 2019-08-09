<?php

namespace App\Http\Controllers\Rid;

use App\Mailer;
use App\Traits\Filer;
use Carbon\Carbon;
use DB;
use App\Company;
use App\DataTables\DataTableResponse;
use App\DataTables\DataTableRow;
use App\Drug;
use App\DrugSupply;
use App\File;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rid\CreateRequest;
use App\Http\Requests\Rid\ResupplyCreateRequest;
use App\Rid;
use App\RidDocument;
use App\RidMasterStatus;
use App\RidPostApprovalActions;
use App\RidPostApprovalDocs;
use App\RidShipment;
use App\RidStatus;
use App\RidSubStatus;
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
class RidController extends Controller
{
    use WorksWithRIDs, Notifier, AuthAssist, Filer;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user.approved');

    }

    /**
     * Display a listing of rids.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->has('rid_status')) {
            $sql = RidMasterStatus::Where('id', '=', $request->input('rid_status'))->first();
            $title = $sql->name;
        } else {
            $title = 'All';
        }
        $params = [];
        if ($request->input('rid_status'))
            $params['filter']['status'] = $request->input('rid_status');

        return view('portal.rid.list', [
            'title' => $title,
            'filter' => http_build_query($params)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     * @throws 403
     */
    public function create()
    {
        $this->ridInitiate();
        $countries = $this->getCountry(); //\App\Country::all()->sortBy('name');
        $states = \App\State::all()->sortBy('name');
        $companies = \App\Company::all()->sortBy('name');
        $pharmacies = \App\Pharmacy::all();
        // $drugs = \App\Drug::where('status', 'Approved')->where('countries_available', 'like', '%' . \Auth::user()->getCountryID() . '%')->sortBy('name');
        $drugs = \App\Drug::where('status', 'Approved')->get()->sortBy('name');

        return view('portal.rid.create', ['countries' => $countries, 'states' => $states, 'companies' => $companies, 'drugs' => $drugs, 'pharmacies' => $pharmacies,]);
    }

    public function review(CreateRequest $request)
    {
        $str = '';
        $data = $request->all();
        $data['patient_gender'] = $data['patient_gender'] == '1' ? 'Male' : 'Female';
        $data['patient_dob'] = $data['patient_dob']['year'] . '-' . $data['patient_dob']['month'] . '-' . $data['patient_dob']['day'];
        return view('portal.rid.review', ['request' => $data, 'pharmacyStr' => $str, 'drug' => Drug::where('id', $request->input('drug_id'))->first(),]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $pass = substr(str_shuffle($permitted_chars), 0, 10);
        $data = json_decode($_POST['data'], true);
        $drug = Drug::where('id', $data['drug_id'])->firstOrFail();
        $company = Company::where('id', $drug->company_id)->firstOrFail();
        $newMasterStatus = \App\RidMasterStatus::where('index', '0')->firstOrFail();
        $newSubstatus = \App\RidSubStatus::where('index', '0')->firstOrFail();
        $newStatus = $newSubstatus->status;

        $rid = new Rid();
        $rid->id = $this->newID(Rid::class);
        $rid->number = $this->generateRidNumber($company);
        $rid->physician_id = $data['physician_id'];
        $rid->drug_id = $drug->id;
        $rid->status_id = $newMasterStatus->id;
        $rid->patient_gender = strtolower($data['patient_gender']);
        $rid->patient_dob = $data['patient_dob'];
        $rid->username = $rid->number;
        $rid->password = $pass;
        $rid->reason = $data['reason'];
        $rid->patient_country_id = NULL;
        $rid->proposed_treatment_plan = $data['proposed_treatment_plan'];
        $rid->req_date = $data['req_date'];
        $rid->signature = $request->input('signature');
        $rid->sign_date = date('Y-m-d');
        $rid->ip_address = $_SERVER['REMOTE_ADDR'] ? $_SERVER['REMOTE_ADDR'] : 'UNKNOWN';
        $rid->save();

        $visit = new RidVisit();
        $visit->id = $this->newID(RidVisit::class);
        $shipment = new RidShipment();
        $shipment->id = $visit->shipment_id = $this->newID(RidShipment::class);
        $visit->parent_id = $shipment->rid_id = $rid->id;
        $visit->index = 1;
        $visit->physician_id = $data['physician_id'];
        $visit->visit_date = $data['req_date'];
        $visit->status_id = RidStatus::where('index', 0)->first()->id;
        $visit->sub_status = RidSubStatus::where('index', 0)->first()->id;
        $visit->save();
        $visit->loadDocs();
        $shipment->save();

        $this->createNotice('rid_docs_needed', $rid, $rid->physician);

        return redirect()->route('eac.portal.rid.show', $rid->id)->with('success', 'Successfully Updated!');
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws 403
     */
    public function show($id)
    {
        $rid = Rid::where('id', $id)->firstOrFail();
        $access = $this->ridAuth($rid);
        $countries = \App\Country::all()->sortBy('name');

        return view('portal.rid.show.index', [
            'rid' => $rid,
            'countries' => $countries,
            'access' => $access,
        ]);
    }

    /*
     * Show the form for editing the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rid = Rid::where('id', $id)->firstOrFail();
        $access = $this->ridAuth($rid);
        //$this->authorize('rid.index.update', $id);
        $rid = Rid::where('id', $id)->firstOrFail();
        $roles = \App\Role::all()->sortBy('name');
        $countries = $this->getCountry();
        $states = \App\State::all()->sortBy('name');
        $groups = \App\UserGroup::all()->sortBy('name');
        $statuses = \App\RidStatus::all();
        $couriers = \App\ShippingCourier::all();
        $ethnicities = \App\Ethnicity::all();
        $doc = \App\RidDocument::all();
        $rid_shipment = RidShipment::where('rid_id', $id)->first();
        return view('portal.rid.edit.master', ['rid' => $rid, 'access' => $access, 'ethnicities' => $ethnicities, 'rid_shipment_data' => $rid_shipment, 'states' => $states, 'roles' => $roles, 'countries' => $countries, 'groups' => $groups, 'statuses' => $statuses, 'couriers' => $couriers, 'doc' => $doc,]);
    }

    public function basicedit($id)
    {
        $rid = Rid::where('id', $id)->firstOrFail();
        $rid_record = RidVisit::where('parent_id', $id)->firstOrFail();
        // dd($rid);
        return view('portal.rid.edit.basicedit', ['rid' => $rid, 'rid_record' => $rid_record]);

    }

    public function basicstore(Request $request)
    {
        $patient_gender = $request->patient_gender;
        $rid = $request->rid_id;
        if ($patient_gender == 1) {
            $gender = 'male';
        } else {
            $gender = 'female';
        }
        $patient_dob_month = $request->patient_dob_month;
        $patient_dob_year = $request->patient_dob_year;
        $patient_dob_day = $request->patient_dob_day;
        $dob = $patient_dob_year . '-' . $patient_dob_month . '-' . $patient_dob_day;

        $rid = Rid::where('id', '=', $rid)->firstOrFail();
        $rid->patient_gender = $gender;
        $rid->patient_dob = $dob;
        $rid->save();
        return redirect()->route('eac.portal.rid.basicedit', $rid);


    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return mixed
     */
    public function destroy($id)
    {
        //
    }

    public function ajaxRidData(Request $request)
    {
        $rids = $this->listRidAccess();
        $response = new DataTableResponse($rids, $request->all());
        return $response->toJSON();

        $response = new DataTableResponse(Rid::class, $request->all());

        if (Request()->input('rid_status'))
            $rids = $rids->where('status_id', Request()->input('rid_status'));

        foreach ($rids as $rid) {
            $row = new DataTableRow($rid->id);

            $row->setColumn('number', $rid->number,
                '<a title="RID Number" href="' . route('eac.portal.rid.show', $rid->id) . '">' .
                $rid->number .
                '</a>'
            );
            $row->setColumn('status', $rid->status->name,
                '<span class="badge badge-' . $rid->status->badge . '">' . $rid->status->name . '</span>'
            );
            $row->setColumn('physician', $rid->physician->full_name,
                '<a title="Physician" href="' . route('eac.portal.user.show', $rid->physician->id ?? '') . '">' .
                $rid->physician->full_name .
                '</a>'
            );
            $row->setColumn('visits', $rid->visits->count()
            );
            $row->setColumn('drug', $rid->drug->name,
                '<a title="Drug Requested" href="' . route('eac.portal.drug.show', $rid->drug_id) . '">' .
                $rid->drug->name .
                '</a>'
            );
            $row->setColumn('created_at', strtotime($rid->created_at),
                '<span style="display: none">' . $rid->created_at->format('Y-m-d') . '</span>' . $rid->created_at->format(config('eac.date_format')),
                $rid->created_at->format(config('eac.date_format'))
            );
            $row->setColumn('btns', $rid->id,
                '<div class="btn-group dropleft" role="group">' .
                '<a class="btn btn-link" href="#" id="dropdownMenuButton' . $rid->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' .
                '<span class="far fa-fw fa-ellipsis-v"></span> <span class="sr-only">Actions</span>' .
                '</a>' .
                '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $rid->id . '">' .
                '<a class="dropdown-item" title="Edit RID" href="' . route('eac.portal.rid.edit', $rid->id) . '">' .
                '<i class="fal fa-fw fa-edit"></i> Edit RID' .
                '</a>' .
                '<a class="dropdown-item" title="View RID" href="' . route('eac.portal.rid.show', $rid->id) . '">' .
                '<i class="fal fa-fw fa-search-plus"></i> View RID' .
                '</a>' .
                '<a class="dropdown-item" title="Post Approval Document" href="' . route('eac.portal.rid.postreview', $rid->id) . '">' .
                '<i class="fal fa-fw fa-file-upload"></i> Post Approval Docs' .
                '</a>' .
                '</div>' .
                '</div>'
            );
            $response->addRow($row);
        }

//		$direction = request('order.0.dir');
//		if (request('order.0.column') == $columns['number']) {
//			$query->orderBy('rids.number', $direction)->orderBy('rids.number', $direction);
//		}
//		if (request('order.0.column') == $columns['status']) {
//			$query->orderBy('rid_master_statuses.name', $direction);
//		}
//		if (request('order.0.column') == $columns['physician_name']) {
//			$query->orderBy('users.first_name', $direction);
//		}
//		if (request('order.0.column') == $columns['drug_name']) {
//			$query->orderBy('drug.name', $direction);
//		}
//		if (request('order.0.column') == $columns['req_date']) {
//			$query->orderBy('rids.created_at', $direction);
//		}
//		if (request('order.0.column') == $columns['visits']) {
//			$query->orderBy('visits', $direction);
//		}
        return $response->toJSON();
    }

    public function setStatus()
    {
        $rid = Rid::where('id', $_POST['rid_id'])->firstOrFail();
        $sub_status = RidSubStatus::where('id', $_POST['sub_status'])->firstOrFail();
        $status = $sub_status->status;
        $rid->sub_status = $sub_status->id;
        $rid->status_id = $status->id;
        $rid->save();
        return redirect()->back();
    }

    public function setDOB()
    {
        $rid = Rid::where('id', $_POST['rid_id'])->firstOrFail();
        $rid->patient_dob = $_POST['patient_dob']['year'] . '-' . $_POST['patient_dob']['month'] . '-' . $_POST['patient_dob']['day'];
        $rid->save();
        return redirect()->back();
    }

    public function editReason()
    {
        $rid = Rid::where('id', '=', $_POST['rid_id'])->firstOrFail();
        $rid->reason = $_POST['reason'];
        $rid->save();
        return redirect()->back();
    }

    public function editTreatmentPlan()
    {
        $rid = Rid::where('id', '=', $_POST['rid_id'])->firstOrFail();
        $rid->proposed_treatment_plan = $_POST['proposed_treatment_plan'];
        $rid->save();
        return redirect()->back();
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

    public function approve($id)
    {
        return view('portal.rid.letter.edit', [
            'rid' => Rid::where('id', $id)->firstOrFail(),
            'status' => RidMasterStatus::where('name', 'Approved')->firstOrFail(),
            'title' => 'Approved Letter',
            'template' => Mailer::where('name', 'rid_approved')->first(),
        ]);
    }

    public function deny($id)
    {
        return view('portal.rid.letter.edit', [
            'rid' => Rid::where('id', $id)->firstOrFail(),
            'status' => RidMasterStatus::where('name', 'Completed')->firstOrFail(),
            'title' => 'Denied Letter',
            'template' => Mailer::where('name', 'rid_not_approved')->first(),
        ]);
    }

    public function moreinfo($id)
    {
        return view('portal.rid.letter.edit', [
            'rid' => Rid::where('id', $id)->firstOrFail(),
            'status' => RidMasterStatus::where('name', 'Pending')->firstOrFail(),
            'title' => 'More Info Letter',
            'template' => Mailer::where('name', 'rid_more_info')->first(),
        ]);
    }

    public function letterSend(Request $request)
    {
        $this->validate($request, [
            'subject' => 'required',
            'from_email' => 'required|email',
            'from_name' => 'required',
            'html' => 'required'
        ], [
            'subject.required' => ' The subject field is required.',
            'from_email.required' => ' The from address field is required.',
            'from_name.required' => ' The from name field is required.',
            'html.required' => 'The html body field is required.',
        ]);

        $rid = Rid::where('id', $request->input('rid'))->firstOrFail();
        $rid->status_id = $request->input('status');
        $rid->save();

        $mail = new \stdClass();
        $mail->name = $request->input('name');
        $mail->subject = $request->input('subject');
        $mail->from_email = $request->input('from_email');
        $mail->from_name = $request->input('from_name');
        $mail->reply_to = $request->input('reply_to');
        $mail->cc = $request->input('cc');
        $mail->bcc = $request->input('bcc');
        $mail->html = $request->input('html');

        $this->customNotice($mail, $rid, $rid->physician);

        return redirect()->route('eac.portal.rid.show', $rid->id)->with("alert", ['type' => 'success', 'msg' => 'Letter send to physician!']);
    }

    public function autoUpdate()
    {
        $request = $_POST;
        $rid = Rid::where('id', $request['key'])->firstOrFail();
        if (is_array($request['value']))
            $rid[$request['name']] = json_encode($request['value']);
        else
            $rid[$request['name']] = $request['value'];
        $rid->saveOrFail();
        return json_encode($request);
    }

    public function resupply($id)
    {
        $rid = Rid::where('id', $id)->first();
        $country = $rid->visits->sortBy('index')->last()->physician->address->country ?? null;
        $drug_supply = $rid->drug->visitSupplyLength($rid->visits->count());

        return view('portal.rid.resupply.create', ['rid' => $rid, 'country' => $country, 'drug_supply' => $drug_supply]);
    }

    public function storeResupply(ResupplyCreateRequest $request)
    {
        $next_visit_date = Carbon::parse($request->first_visit_date);

        $rid = Rid::where('id', $request->rid_id)->firstOrFail();
        $prev_visit = $rid->last_visit();
        $prev_shipment = RidShipment::where('rid_id', $request->rid_id)->latest()->first();
        $new_shipment = $prev_shipment ? $prev_shipment->replicate() : new RidShipment();
        $new_shipment->id = $this->newID(RidShipment::class);
        $new_shipment->rid_id = $request->rid_id;
        $new_shipment->deliver_by_date = $next_visit_date->toDateTimeString();
        $new_shipment->ship_by_date = $next_visit_date->copy()->subDays($request->days_to_deliver)->toDateTimeString();
        $new_shipment->shipped_on_date = null;
        $new_shipment->delivery_date = null;
        $new_shipment->courier_id = null;
        $new_shipment->tracking_number = null;
        $new_shipment->save();

        $last_visit = $prev_visit;
        for ($i = 0; $i < $request->number_of_visits; $i++) {
            if (!$last_visit) {
                $new_visit = new RidVisit();
                $new_visit->parent_id = $request->rid_id;
                $new_visit->physician_id = $rid->physician_id;
            } else {
                $new_visit = $last_visit->replicate();
                $new_visit->parent_id = $request->rid_id;
                $new_visit->physician_id = $last_visit->physician_id;
            }
            $new_visit->id = $this->newID(RidVisit::class);
            $new_visit->shipment_id = $new_shipment->id;
            $new_visit->supply_length = $request->supply_length;
            $new_visit->visit_date = $next_visit_date->toDateTimeString();;
            $new_visit->status_id = RidStatus::where('index', '0')->firstOrFail()->id;
            $new_visit->sub_status = RidSubStatus::where('index', '0')->firstOrFail()->id;
            $new_visit->save();
            $new_visit->loadDocs();
            $next_visit_date->addDays($request->supply_length);
            $last_visit = $new_visit;
        }

        $i = 1;
        foreach ($rid->visits->sortBy('visit_date') as $visit) {
            $visit->index = $i;
            $visit->save();
            $i++;
        }
        return redirect()->back()->with("alert", ['type' => 'success', 'msg' => 'Rid resupply visit added successfully']);
    }

    public function updateSupply(Request $request)
    {
        $rid = Rid::where('id', $request->input('rid_id'))->first();
        $i = 1;
        foreach ($request->input('shipments') as $shipment => $val) {
            if (!$val)
                RidShipment::where('id', $shipment)->first()->delete();
        }
        foreach ($rid->visits->sortBy('visit_date') as $visit) {
            $visit->shipment_id = $request->input('visits')[$visit->id];
            $visit->index = $i;
            $visit->save();
            $i++;
        }
        return redirect()->back();
    }

    public function ridstatus($id)
    {

        // $sql = Rid::Where('rids.id', '!=', '')->Leftjoin('rid_records', 'rids.id', '=', 'rid_records.parent_id')->Leftjoin('drug', 'drug.id', '=', 'rids.drug_id')->Leftjoin('users', 'users.id', '=', 'rid_records.physician_id')->Leftjoin('rid_master_statuses', 'rid_master_statuses.id', '=', 'rids.status_id')->where('rid_master_statuses.name', '=', 'New')->groupBy('rids.id')->select(['rids.id as id', 'rids.number as number', 'drug.name as drug_name', 'drug.id as drug_id', 'rid_master_statuses.name as status', 'users.first_name as first_name', 'users.last_name  as last_name', 'users.id  as uid', 'rids.req_date as req_date', 'rids.created_at as created_at']);
        $rid = Rid::where('rids.status_id', '=', $id);
        return view('portal.rid.ridstatus');

    }

    public function postreview($id)
    {
        $rid = Rid::where('id', $id)->firstOrFail();
        $postApprovalActions = RidPostApprovalActions::where('is_active', 1)->orderBy('serial', 'asc')->get();

        return view('portal.rid.post.index', ['rid' => $rid, 'postApprovalActions' => $postApprovalActions]);

    }

    public function postApprovalAction(Request $request)
    {
        if ($request->action == 'upload') {
            $rid_id = $request->rid_id;
            $doc_id = $request->document_id;
            $postApprovalDoc = RidPostApprovalDocs::where('rid_id', $rid_id)->where('doc_id', $doc_id)->first();
            if (!$postApprovalDoc) {
                $postApprovalDoc = new RidPostApprovalDocs();
                $postApprovalDoc->id = $this->newID(RidPostApprovalDocs::class);
                $postApprovalDoc->rid_id = $request->rid_id;
                $postApprovalDoc->doc_id = $request->document_id;
            }
            $postApprovalDoc->upload_notes = $request->up_notes;
            $file = $this->createFile($request->file('upload_file'), 'rid.doc');
            $postApprovalDoc->uploaded_file_id = $file->id;
            $postApprovalDoc->save();
        } else if ($request->action == 'review') {

            $rid_id = $request->rid_id;
            $doc_id = $request->document_id;

            $postApprovalReview = RidPostApprovalDocs::where('rid_id', $rid_id)->where('doc_id', $doc_id)->first();
            $postApprovalReview->is_matched = $request->is_match == 'yes' ? 'yes' : 'no';
            $postApprovalReview->record_no = $request->record_no;
            $postApprovalReview->expiration_date = $request->exp_date;
            $postApprovalReview->review_notes = $request->review_notes;
            $postApprovalReview->save();

        } else {
            $rid_id = $request->rid_id;
            $doc_id = $request->document_id;
            $data = RidPostApprovalDocs::where('rid_id', $rid_id)->where('doc_id', $doc_id)->first();
            if ($data) {
                $postApprovalAction = $data;
            } else {
                $postApprovalAction = new RidPostApprovalDocs();
                $postApprovalAction->id = $this->newID(RidPostApprovalDocs::class);
                $postApprovalAction->rid_id = $request->rid_id;
                $postApprovalAction->doc_id = $request->document_id;
            }

            $postApprovalAction->is_acknowledged = 1;
            $postApprovalAction->save();
        }

        return redirect()->back()->with("alert", ['type' => 'success', 'msg' => 'Data updated successfully']);
    }

    public function reviewdocdelete(Request $request)
    {
        // dd($request->id);
        $reviewDocID = $request->id;
        $document = RidPostApprovalDocs::where('id', $reviewDocID)->firstOrFail();
        $document->uploaded_file_id = NULL;
        $document->saveOrFail();
    }

    public function changestatus($rid_id, $status)
    {
        $rid = Rid::find($rid_id);
        $rid->status_id = $status;
        $rid->save();
        return redirect()->back()->with("alert", ['type' => 'success', 'msg' => 'Status changed successfully']);
    }

    public function updateColors()
    {
        foreach ($_POST['status'] as $id => $val) {
            $status = RidMasterStatus::where('id', $id)->first();
            $status->name = $val['name'];
            $status->badge = $val['badge'];
            $status->save();
        }

        return redirect()->back()->with("alert", ['type' => 'success', 'msg' => 'Badge colors changed successfully']);
    }

    public function reassign(Request $request)
    {
        $rid = RidVisit::find($request->visit_id);
        $rid->physician_id = $request->physician_id;
        $rid->save();
        return redirect()->back()->with("alert", ['type' => 'success', 'msg' => 'Rid assign successfully']);

    }
}
