<?php

namespace App\Http\Controllers\Rid;

use App\DrugLot;
use App\Http\Controllers\Controller;
use App\RidRegimen;
use App\RidShipment;
use App\Traits\WorksWithRIDs;

/**
 * Class RidController
 * @package App\Http\Controllers\Rid
 * @author Andrew Mellor <andrew@quasars.com>
 */
class RidRegimenController extends Controller
{
	use WorksWithRIDs;

	/**
	 * Display a listing of the resource.
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('portal.rid.list');
	}

	/**
	 * Store a newly created resource in storage.
	 * @return \Illuminate\Http\Response
	 */
	public function store()
	{
		$RidShipment = RidShipment::where('id', $_POST['rid_shipment_id'])->firstOrFail();
		$regimen = new RidRegimen();
		$regimen->id = $this->newID(RidRegimen::class);
		$regimen->shipment_id = $_POST['rid_shipment_id'];

		if ($_POST['drug_lot_id'] == '0') {
			$regimen->is_applicable = 0;
		} else {
			$regimen->is_applicable = 1;
		}
		$regimen->drug_lot_id = $_POST['drug_lot_id'];
		if ($regimen->drug_lot_id) {
			$regimen->quantity = $_POST['quantity'];
			$regimen->frequency = $_POST['frequency_1'] . ' ' . $_POST['frequency_2'];
			$regimen->length = $_POST['length_1'] . ' ' . $_POST['length_2'];
			$regimen->total_count = 0;
			$regimen->component_id = $_POST['component_id'];
		}
		$regimen->save();
		$RidShipment->depot_id = DrugLot::where('id', $_POST['drug_lot_id'])->first()->depot->id ?? '0';
		$RidShipment->save();
		return redirect()->back()->with("alerts", ['type' => 'success', 'msg' => 'Rid Regimen Added']);
	}

	/**
	 * Update the specified resource in storage.
	 * @return \Illuminate\Http\Response
	 */
	public function update()
	{

		// dd($_POST['drug_lot_id']);
		$regimen = RidRegimen::where("id", $_POST['id'])->first();
		if ($_POST['drug_lot_id'] == '0' || $_POST['drug_lot_id'] == '') {
			$regimen->is_applicable = 0;
		} else {
			$regimen->is_applicable = 1;
		}
		$regimen->drug_lot_id = $_POST['drug_lot_id'];
		$regimen->quantity = $_POST['quantity'];
		$regimen->frequency = $_POST['frequency_1'] . ' ' . $_POST['frequency_2'];
		$regimen->length = $_POST['length_1'] . ' ' . $_POST['length_2'];
		$regimen->total_count = 0;
		$regimen->save();
		// dd($regimen);
		$RidShipment = RidShipment::where('id', $_POST['rid_shipment_id'])->first();
		$depot = DrugLot::where('id', $_POST['drug_lot_id'])->first();
		if ($depot) {
			$RidShipment->depot_id = $depot->depot->id;
		} else {
			$RidShipment->depot_id = 0;
		}
		$RidShipment->saveOrFail();


		return redirect()->back()->with("alerts", ['type' => 'success', 'msg' => 'Rid regimen Updated']);
	}

	/**
	 * Remove the specified resource from storage.
	 * @param  int $id
	 * @return mixed
	 */
	public function destroy($id)
	{
		//
	}
}
