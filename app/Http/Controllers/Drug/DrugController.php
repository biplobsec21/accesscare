<?php

namespace App\Http\Controllers\Drug;

use App\DataTables\DataTableResponse;
use App\DataTables\DataTableRow;
use App\DocumentType;
use App\Dosage;
use App\DosageForm;
use App\DosageStrength;
use App\DosageUnit;
use App\Drug;
use App\DrugComponent;
use App\DrugSupply;
use App\File;
use App\Http\Controllers\Controller;
use App\Traits\AuthAssist;
use App\Traits\Notifier;
use Illuminate\Http\Request;
use Validator;

/**
 * Class DrugController
 * @package App\Http\Controllers\Drug
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class DrugController extends Controller
{
	use Notifier, AuthAssist;

	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('user.approved');

//		$this->middleware(function ($request, $next) {
//			$title = str_replace(array("\r\n", "\r", "\n", "\t"), '', \View::getSection('title'));
//			$url = $request->url();
//			if ($title == 'Dashboard')
//				$request->session()->forget('history');
//
//			if (!$request->session()->has('history'))
//				$request->session()->put('history', []);
//
//			$slice_offset = array_search($title, array_column(session('history'), 'title'));
//			if ($slice_offset !== false)
//				$request->session()->put('history', array_slice(session('history'), 0, $slice_offset));
//
//			$request->session()->push('history', [
//				'title' => $title,
//				'url' => $url,
//				'time' => time()
//			]);
//
//			return $next($request);
//		});
	}

	/*
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if ($request->has('drug_status')) {
			$title = $request->input('drug_status');
		} else {
			$title = 'All';
		}
		return view('portal.drug.list', ['title' => $title]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function create()
	{
		$this->drugInitiate();
		$dosageForm = DosageForm::where('active', '=', 1)->get();
		$dosageUnit = DosageUnit::where('active', '=', 1)->get();
		$dosageStrength = DosageStrength::where('active', '=', 1)->get();

		$companies = \App\Company::where('active', '=', 1)->get()->sortBy('name');
		$countries = $this->getCountry(); //\App\Country::all()->sortBy('name');
		return view('portal.drug.create', [
			'companies' => $companies,
			'countries' => $countries,
			'dosageForm' => $dosageForm,
			'dosageUnit' => $dosageUnit,
			'dosageStrength' => $dosageStrength
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if ($request->input('component_name')) {
			$request->session()->put('components', $request->input('component_name'));
		} else {
			$request->session()->forget('components');
		}

		$validator = Validator::make(
			$request->all(), [
			'name' => [
				'required',
				'min:4',
				'max:200',
			],
			'lab_name' => [
				'required',
				'min:4',
				'max:200',
			],
			'company_id' => [
				'required',
			],
			'component_main' => [
				'required',
			],
			'short_desc' => [
				'required',
			],
			'desc' => [
				'required',
			],
			'form_id' => [
				'required',
			],
			'amount' => [
				'required',
			],
			'unit_id' => [
				'required',
			],
			'strength_id' => [
				'required',
			],
			'component_main' => [
				'required',
			],
			'temperature' => [
				'required',
			],
			'countries_available' => [
				'required',
			],
			'countries_available.*' => [
				'required',
			],
		], [
				'name.required' => 'The drug name is required.',

				'lab_name.required' => 'The drug lab name is required.',

				'company_id.required' => 'Selecting the manufacturer is required.',

				'component_name.required' => 'Component Name is required.',
			]
		);
		// dd( $validator->errors());
		if ($validator->fails()) {
			return redirect()->back()->with("errors", $validator->errors())->withInput();
		}
		$request->session()->forget('components');

		$drug = new Drug();
		$drug->id = $this->newID(Drug::class);
		$drug->company_id = $request->input('company_id');
		$drug->added_by = \Auth::user()->id;
		$drug->approved_by = 0;
		$drug->name = $request->input('name');
		$drug->lab_name = $request->input('lab_name');
		$drug->short_desc = (!is_null($request->input('short_desc'))) ? $request->input('short_desc') : 0;
		$drug->desc = $request->input('desc') !== null ? $request->input('desc') : 0;
		$drug->status = 'Pending';

		$drug->hide_countries = ($request->input('hide_countries')) ? 1 : 0;
		$drug->pre_approval_req = ($request->input('pre_approval_req')) ? 1 : 0;
		$drug->ship_without_approval = ($request->input('ship_without_approval')) ? 1 : 0;
		$drug->allow_remote = ($request->input('allow_remote')) ? 1 : 0;
		$drug->countries_available = json_encode($request->input('countries_available'));
		$drug->active = 1;
		// drug image file 
		if ($request->file('drug_image')) {

			$file = new File();
			$file->id = $this->newID(File::class);

			$requestFile = $request->file('drug_image');
			$dir = public_path() . "/images/";
			// dd($dir);
			// $new_dir=str_replace("public", "public_html", $dir)."/images/";
			// dd($new_dir);
			$filename = str_replace(' ', '_', $request->input('name')) . rand(10000000, 99999999) . '.' . $requestFile->getClientOriginalExtension();
			$path = $requestFile->move($dir, $filename);
			$file->path = $dir;
			$file->name = $filename;
			$file->save();
			$drug->logo = $file->id;
		} else {
			$file = new File();
			$file->id = $this->newID(File::class);

			$dir = public_path() . "/images/";
			// dd($dir);
			// $new_dir=str_replace("public", "public_html", $dir)."/images/";
			// dd($new_dir);
			$filename = "default.png";

			$file->path = $dir;
			$file->name = $filename;
			$file->save();
			$drug->logo = $file->id;
		}

		$drug->save();

		//component store
		// dd($request->input('active'));
		$component = new DrugComponent();
		$component->id = $this->newID(DrugComponent::class);
		$component->drug_id = $drug->id;
		$component->name = $request->input('component_main');
		// dosage added accroding to component_main
		$dosage = new Dosage();
		$dosage->id = $this->newID(Dosage::class);
		$dosage->component_id = $component->id;
		$dosage->form_id = $request->input('form_id');
		$dosage->temperature = $request->input('temperature');
		$dosage->amount = $request->input('amount');
		$dosage->unit_id = $request->input('unit_id');
		$dosage->strength_id = $request->input('strength_id');
		$dosage->active = $request->input('active') ? 1 : 0;
		$dosage->save();

		$component->index = DrugComponent::where('drug_id', $drug->id)->count() + 1;
		$component->save();

		if ($request->input('component_name')) {
			$componentArray = $request->input('component_name');
			for ($i = 0; $i < count($componentArray); $i++) {
				$component = new DrugComponent();
				$component->id = $this->newID(DrugComponent::class);
				$component->drug_id = $drug->id;
				$component->name = $componentArray[$i];
				$component->index = DrugComponent::where('drug_id', $drug->id)->count() + 1;
				$component->save();


				$dosIndex = $i + 2;
				if ($request->input('form_id' . $dosIndex)) {

					$dosage = new Dosage();
					$dosage->id = $this->newID(Dosage::class);
					$dosage->component_id = $component->id;
					$dosage->form_id = $request->input('form_id' . $dosIndex);
					$dosage->temperature = $request->input('temperature' . $dosIndex);
					$dosage->amount = $request->input('amount' . $dosIndex);
					$dosage->unit_id = $request->input('unit_id' . $dosIndex);
					$dosage->strength_id = $request->input('strength_id' . $dosIndex);
					$dosage->active = ($request->input('active' . $dosIndex)) ? 1 : 0;
					$dosage->save();
				}
			}
		}


		return redirect()->route('eac.portal.drug.edit', $drug->id);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 * @throws 403
	 */
	public function edit($id)
	{
		$drug = Drug::where('id', $id)->firstOrFail();
		$access = $this->drugAuth($drug);
		$isComplete = array('completeDpotLot' => 1, 'completeCmpDsg' => 1);
		$dosgCount = collect();
		$depotInit = new \App\Depot;

		$drugLogo = File::where('id', $drug->logo)->first();
		$roles = \App\Role::all()->sortBy('name');
		$users = \App\User::all()->sortBy('first_name');
		$groups = \App\UserGroup::all()->sortBy('name');
		$countries = $this->getCountry();
		$companies = \App\Company::all()->sortBy('name');
		$depots = \App\Depot::all();
		$rowcount = DrugSupply::where('drug_id', '=', $id)
			// ->orderBy('created_at', 'asc')
			->orderByRaw('CONVERT(supply_start, SIGNED INTEGER) asc')
			->get();
		// check active or inactive pill for depots and lots
		$depotWithDrug = $depotInit->allWithDrug($id);
		if ($depotWithDrug->count() > 0) {
			foreach ($depotWithDrug as $lotWdpt) {
				if ($lotWdpt->lotsWithDrug($drug->id) && ($lotWdpt->lotsWithDrug($drug->id)->count() > 0)) {

					continue;
				} else {

					$isComplete['completeDpotLot'] = 0;
				}
			}
		} else {
			$isComplete['completeDpotLot'] = 0;
		}
		// check active or inactive pill for dosage and component
		if ($drug->components->count() > 0) {
			foreach ($drug->components as $component) {
				if ($component->activeDosages->count() == 0) {
					$isComplete['completeCmpDsg'] = 0;
				}
				foreach ($component->dosages as $dosage) {
					if ($dosage->active == 1) {
						$dosgCount->push($dosage);
					}
				}

			}
		} else {
			$isComplete['completeCmpDsg'] = 0;
		}
		// dd($isComplete);
		return view('portal.drug.edit.index', [
			'drug' => $drug,
			'access' => $access,
			'drugLogo' => $drugLogo,
			'countries' => $countries,
			'roles' => $roles,
			'users' => $users,
			'companies' => $companies,
			'depots' => $depots,
			'groups' => $groups,
			'isComplete' => $isComplete,
			'dosg' => $dosgCount,
			'supply_info' => $rowcount

		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 * @throws 403
	 */
	public function show($id)
	{
		$drug = Drug::where('id', $id)->firstOrFail();
		$access = $this->drugAuth($drug);

		$drugLogo = File::where('id', $drug->logo)->first();


		// dd($drugLogo->name);
		$countries = \App\Country::all()->sortBy('index');
		$depots = \App\Depot::allWithDrug($drug->id);
		$lots = \App\DrugLot::allWithDrug($drug->id);
		$rids = \App\Rid::where('drug_id', $id);

		$isComplete = array('completeDpotLot' => 1, 'completeCmpDsg' => 1);
		$dosgCount = collect();
		$depotInit = new \App\Depot;
		$rowcount = DrugSupply::where('drug_id', '=', $id)
			// ->orderBy('created_at', 'asc')
			->orderByRaw('CONVERT(supply_start, SIGNED INTEGER) asc')
			->get();
		// check active or inactive pill for depots and lots 
		// $depotWithDrug = $depotInit->allWithDrug($id);
		if ($depots->count() > 0) {
			foreach ($depots as $lotWdpt) {
				if ($lotWdpt->lotsWithDrug($drug->id) && ($lotWdpt->lotsWithDrug($drug->id)->count() > 0)) {
					continue;
				} else {
					$isComplete['completeDpotLot'] = 0;
				}
			}
		} else {
			$isComplete['completeDpotLot'] = 0;
		}
		// check active or inactive pill for dosage and component
		if ($drug->components->count() > 0) {
			foreach ($drug->components as $component) {
				if ($component->activeDosages->count() == 0) {
					$isComplete['completeCmpDsg'] = 0;
				}
				foreach ($component->dosages as $dosage) {
					if ($dosage->active == 1) {
						$dosgCount->push($dosage);
					}
				}

			}
		} else {
			$isComplete['completeCmpDsg'] = 0;
		}

		return view('portal.drug.show.index', [
			'drug' => $drug,
			'access' => $access,
			'drugLogo' => $drugLogo,
			'countries' => $countries,
			'depots' => $depots,
			'lots' => $lots,
			'rids' => $rids,
			'isComplete' => $isComplete,
			'dosg' => $dosgCount,
			'supply_info' => $rowcount
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		$drug = Drug::where('id', $request->input('drug_id'))->firstOrFail();
		$drug->name = $request->input('name');
		$drug->lab_name = $request->input('lab_name');
		$drug->company_id = $request->input('company_id');
		$drug->desc = $request->input('desc');
		$drug->save();
		return redirect()->back();
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function updateAvailibility(Request $request)
	{
		$drug = Drug::where('id', $request->input('drug_id'))->firstOrFail();
		$drug->countries_available = json_encode($request->input('countries_available'));
		$drug->hide_countries = $request->input('hide_countries');
		$drug->pre_approval_req = $request->input('pre_approval_req');
		$drug->ship_without_approval = $request->input('ship_without_approval');
		$drug->allow_remote = $request->input('allow_remote');
		$drug->save();
		return redirect()->back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}

	public function ajaxDrugData(Request $request)
	{
		$drugs = $this->listDrugAccess();
		$response = new DataTableResponse(Drug::class, $request->all());

		if (Request()->input('drug_status'))
			$drugs = $drugs->where('status', Request()->input('drug_status'));

		foreach ($drugs as $drug) {
			$row = new DataTableRow($drug->id);

			$row->setColumn('drug_name', $drug->name,
				"<a href=" . route('eac.portal.drug.show', $drug->id) . ">" . $drug->name . "</a>"
			);
			$row->setColumn('company_name', $drug->company->name,
				'<a title="Physician" href="' . route('eac.portal.company.show', $drug->company->id ?? '') . '">' .
				$drug->company->name .
				'</a>'
			);
			$row->setColumn('status', $drug->status,
				'<span class="badge badge-' . $drug->status . '">' . $drug->status . '</span>'
			);
			$row->setColumn('created_at', $drug->created_at->format('Y-m-d'),
				'<span style="display: none">' . $drug->created_at->format('Y-m-d') . '</span>' . $drug->created_at->format(config('eac.date_format')),
				$drug->created_at->format(config('eac.date_format'))
			);
			$row->setColumn('btns', $drug->id,
				'<div class="btn-group dropleft" role="group">' .
				'<a class="btn btn-link" href="#" id="dropdownMenuButton' . $drug->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' .
				'<span class="far fa-fw fa-ellipsis-v"></span> <span class="sr-only">Actions</span>' .
				'</a>' .
				'<div class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $drug->id . '">' .
				'<a class="dropdown-item" title="Edit Drug" href="' . route('eac.portal.drug.edit', $drug->id) . '">' .
				'<i class="fal fa-fw fa-edit"></i> Edit Drug' .
				'</a>' .
				'<a class="dropdown-item" title="View Drug" href="' . route('eac.portal.drug.show', $drug->id) . '">' .
				'<i class="fal fa-fw fa-search-plus"></i> View Drug' .
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

	public function writeDB()
	{
		$save_data = $_POST['save_data'];
		try {
			$row = Drug::where('id', "=", $save_data['id'])->firstOrFail();

			foreach ($save_data as $field => $val) {
				$row->$field = $val;
			}
			$row->saveOrFail();
			return [
				"result" => "success",
				"data" => $_POST['save_data']
			];

		} catch (\Throwable $e) {
			if (config('app.debug')) {
				throw $e;
			} else {
				return [
					'result' => 'error'
				];
			}
		}
	}

	// ajax request for getting document type template
	public function getDocumentTypeTemplate(Request $request)
	{

		$id = $request->id;
		$document = DocumentType::find($id);
		$file = File::find($document->template);
		if (!empty($file) && isset($file->id)) {

			$template_name = $file->name;
			$template_url = $file->path . $file->name;

			$returnHTML = view('portal.drug.edit.ajax_view')
				->with('template_name', $template_name)
				->with('template_url', $template_url)
				->with('file_id', $file->id)
				->with('template_id', $document->template)
				->render();

			return response()->json(array('result' => "Success", 'html' => $returnHTML));
		} else {

			$template_name = "Upload files";
			$template_url = "not_found";

			$returnHTML = view('portal.drug.edit.ajax_view')
				->with('template_name', $template_name)
				->with('template_url', $template_url)
				->render();

			return response()->json(array('result' => "blank", 'html' => $returnHTML));
		}


	}

	public function druginfo($id)
	{
		$drug_id = $id;
		$rowcount = DrugSupply::where('drug_id', '=', $drug_id)
			// ->orderBy('created_at', 'asc')
			->orderByRaw('CONVERT(supply_start, SIGNED INTEGER) asc')
			->get();

		$drugname = Drug::select('name')->where('id', $drug_id);
		$dname = $drugname[0]->name;

		// dd(($rowcount));
		// echo $rowcount;
		// dd();
		// if($rowcount == 0){
		return view('portal.drug.supply')->with('drug_id', $drug_id)->with('drugname', $dname)->with('supply_info', $rowcount);
		// }
		// else{
		// $drugs_info = DrugSupply::where('drug_id',$drug_id);
		// return view('portal.drug.addDrug')
		// 		->with('drugs_info',$drugs_info)
		// 		->with('drug_id',$drug_id);
		// }
	}

	public function addInterval()
	{
		$last_supply = DrugSupply::where('drug_id', $_POST['drug_id'])->where('supply_end', 'Ongoing')->first();
		$drugSupply = new DrugSupply();
		$drugSupply->id = $this->newID(DrugSupply::class);
		$drugSupply->drug_id = $_POST['drug_id'];
		$drugSupply->supply_start = $_POST['supply_start'];
		$drugSupply->supply_qty = $_POST['supply_qty'];
		$drugSupply->supply_end = 'Ongoing';
		$drugSupply->saveOrFail();

		if ($last_supply) {
			$last_supply->supply_end = $_POST['supply_start'];
			$last_supply->saveOrFail();
		}
		return json_encode(['status' => 'Success', 'supply_id' => $drugSupply->id]);
	}

	public function removeInterval()
	{
		$id = $_POST['id'];
		$supplies = DrugSupply::where('drug_id', $_POST['drug_id'])->orderBy('supply_start')->get();
		$index = $supplies->search(function ($supply) use ($id) {
			return $supply->id === $id;
		});

		$target = $supplies[$index];

		// if index is not null, and not 0
		if ($index) {
			$previous = $supplies[$index - 1];
			$previous->supply_end = $target->supply_end;
			$previous->save();
		}

		$target->delete();
		return json_encode(['status' => 'Success']);
	}

	public function loadIntervals()
	{

		return json_encode(DrugSupply::where('drug_id', $_POST['drug_id'])->orderBy('supply_start')->get()->toArray());
	}

	public function druginfolist()
	{
		$drugs_info = DrugSupply::where('drug_id', $drug_id);
	}

	public function descriptionupdate(Request $request)
	{
		$drugInfo = Drug::find($request->id);
		$drugInfo->short_desc = $request->short_desc;
		$drugInfo->save();
		return redirect()->back()->with("alerts", ['type' => 'success', 'msg' => 'Information Updated successfully']);

	}

	public function imageupdate(Request $request)
	{
		// dd($request->drug_id);
		$drug = Drug::find($request->drug_id);
		$previouslogo = $drug->logo;
		if ($request->file('drug_image')) {

			$file = new File();
			$file->id = $this->newID(File::class);

			$requestFile = $request->file('drug_image');
			$dir = public_path() . "/images/";
			// dd($dir);
			// $new_dir=str_replace("public", "public_html", $dir)."/images/";
			// dd($new_dir);
			$filename = str_replace(' ', '_', $request->input('name')) . rand(10000000, 99999999) . '.' . $requestFile->getClientOriginalExtension();
			$path = $requestFile->move($dir, $filename);
			$file->path = $dir;
			$file->name = $filename;
			$file->save();
			$drug->logo = $file->id;
			$drug->save();
		} else {
			$drug->logo = $previouslogo;
			$drug->save();
		}

		return redirect()->back()->with("alerts", ['type' => 'success', 'msg' => 'Image Updated successfully']);

	}

	public function changestatus($status, $id)
	{

		$drugInfo = Drug::find($id);
		if ($status == '0') {
			$drugInfo->status = 'Not Approved';
		}
		if ($status == '1') {


			$drug = Drug::where('id', $id)->firstOrFail();
			$DpLot = $this->checkDepotsLot($id);
			$DosCmp = $this->checkDosagesComponents($drug);
			$DrgDis = $this->checkDrugDistrubution($id);

			// dd($DosCmp);
			if ($DosCmp == 1 && $DpLot == 1 && ($DrgDis->count() > 0)) {
				$drugInfo->status = 'Approved';
			} else {

				$dosagesComponents = '';
				$drugDistribution = '';
				$depotsLots = '';

				if ($DosCmp == 0) {
					$dosagesComponents = 'Components and Dosages';
				}
				if ($DpLot == 0) {
					$depotsLots = 'Depots and Lots';
				}
				if ($DrgDis->count() == 0) {
					$drugDistribution = 'Drug Distribution Schedule';
				}
				return redirect()->back()->with("alerts", ['type' => 'warning', 'msg' => $dosagesComponents . ' ' . $depotsLots . ' ' . $drugDistribution . ' needs to be completed before drug can be approved']);
			}

		}
		if ($status == '2') {
			$drugInfo->status = 'Pending';
		}
		$drugInfo->save();
		return redirect()->back()->with("alerts", ['type' => 'success', 'msg' => 'Information Updated successfully']);
	}

	private function checkDepotsLot($id)
	{
		$isComplete = 1;
		$depotInit = new \App\Depot;
		// check active or inactive pill for depots and lots
		$depotWithDrug = $depotInit->allWithDrug($id);
		if ($depotWithDrug->count() > 0) {
			foreach ($depotWithDrug as $lotWdpt) {
				if ($lotWdpt->lotsWithDrug($id) && ($lotWdpt->lotsWithDrug($id)->count() > 0)) {

					continue;
				} else {

					$isComplete = 0;
				}
			}
		} else {
			$isComplete = 0;
		}

		return $isComplete;
	}

	private function checkDosagesComponents($drug)
	{
		$isComplete = 1;
		$dosgCount = collect();
		// check active or inactive pill for dosage and component
		if ($drug->components->count() > 0) {
			foreach ($drug->components as $component) {
				if ($component->activeDosages->count() == 0) {
					$isComplete = 0;
				}
				foreach ($component->dosages as $dosage) {
					if ($dosage->active == 1) {
						$dosgCount->push($dosage);
					}
				}

			}
		} else {
			$isComplete = 0;
		}

		return $isComplete;
	}

	private function checkDrugDistrubution($id)
	{
		$drugSupply = DrugSupply::where('drug_id', '=', $id)
			// ->orderBy('created_at', 'asc')
			->orderByRaw('CONVERT(supply_start, SIGNED INTEGER) asc')
			->get();
		return $drugSupply;
	}
}
