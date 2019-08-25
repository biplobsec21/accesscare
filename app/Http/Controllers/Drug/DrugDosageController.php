<?php

namespace App\Http\Controllers\Drug;

use App\Dosage;
use App\DrugComponent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Drug\Dosage\CreateRequest;
use App\Http\Requests\Drug\Dosage\UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class DrugDosageController
 * @package App\Http\Controllers\Settings\Manage\Drug
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class DrugDosageController extends Controller
{
	/**
	 * DrugDosageController constructor.
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request)
	{
		$dosage = Dosage::where('id', '=', $request->id)->firstOrFail();
		$dosage->form_id = $request->input('form_id');
		$dosage->amount = $request->input('amount');
		$dosage->unit_id = $request->input('unit_id');
		$dosage->strength_id = $request->input('strength_id');
		$dosage->component_id = $request->input('component_id');
		$dosage->temperature = $request->input('temperature');
		$dosage->active = ($request->input('active') == 'on') ? 1 : 0;
		$dosage->save();

		return redirect()->back()->with('confirm', 'Dosage Has Been Updated.');
	}

	public function store(CreateRequest $request)
	{
		$dosage = new Dosage();
		$dosage->id = $this->newID(Dosage::class);
		$dosage->component_id = $request->input('component_id');
		$dosage->form_id = $request->input('form_id');
		$dosage->temperature = $request->input('temperature');
		$dosage->amount = $request->input('amount');
		$dosage->unit_id = $request->input('unit_id');
		$dosage->strength_id = $request->input('strength_id');
		$dosage->active = ($request->input('active') == 'on') ? 1 : 0;
		$dosage->save();
		// modal info 
		
		return redirect()->back()->with('confirm', 'Dosage Has Been Set.');
	}

	public function storeComponent(Request $request)
	{
		$temp = DrugComponent::where('drug_id', $request->input('drug_id'))->orderBy('index','desc')->first();
		$lastIndex = $temp->index;
		$component = new DrugComponent();
		$component->id = $this->newID(DrugComponent::class);
		$component->drug_id = $request->input('drug_id');
		$component->name = $request->input('name');
		$component->index = $lastIndex + 1;
		$component->save();

		return redirect()->back();
	}
	public function editComponent(Request $request)
	{
		$component = DrugComponent::where('drug_id', $request->input('drug_id'))->where('id', $request->input('componentId'))->firstOrFail();
		$component->name = $request->input('name');
		$component->active = ($request->input('active') == 'on') ? 1 : 0;
		$component->save();
		return redirect()->back();
	}

	/**
	 * Display the management page
	 */
	public function index()
	{
		$rows = Dosage::all();

		return view('portal.settings.manage.drug.dosage.index', ['rows' => $rows]);
	}

	public function deleteComponent(Request $request){
		$id = $request->id;
        $resourceData = DrugComponent::find($id);
        $dosageData = Dosage::where('component_id',$id);
        if ($resourceData){
        	if ($resourceData->delete()){

        		$dosageData->delete();
        		return [
                    'result' => 'success'
                ];
        	}

        }
	}

	public function deleteComponentDosage(Request $request){
		$id = $request->id;
        $dosageData = Dosage::find($id);
          if ($dosageData){
        	if ($dosageData->delete()){
        		return [
                    'result' => 'success'
                ];
        	}

        }

	}
}
