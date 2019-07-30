<?php

namespace App\Http\Controllers\Rid;

use App\Address;
use App\DataTables\DataTableResponse;
use App\DataTables\DataTableRow;
use App\RidShipment;
use App\Drug;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rid\ResupplyCreateRequest;
use App\Pharmacy;
use App\Rid;
use App\RidVisit;
use App\Traits\AuthAssist;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\WorksWithRIDs;

/**
 * Class RidController
 * @package App\Http\Controllers\Rid
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class RidShipmentController extends Controller
{
	use WorksWithRIDs, AuthAssist;

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$shipment = RidShipment::where('id', $id)->firstOrFail();
		$rid = Rid::where('id', $shipment->rid_id)->first();
		$access = $this->ridAuth($rid);
		$couriers = \App\ShippingCourier::all();
		$pharmacies = \App\Pharmacy::all();
		$countries = \App\Country::all()->sortBy('name');
		$states = \App\State::all()->sortBy('name');
		return view('portal.rid.edit.shipment', [
			'rid' => $rid,
			'shipment' => $shipment,
			'couriers' => $couriers,
			'pharmacies' => $pharmacies,
			'pageTitle' => 'Edit Visit',
			'states' => $states,
			'countries' => $countries,
			'access' => $access
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function updateDates(Request $request)
	{
		$shipment = new RidShipment();
		$shipment = RidShipment::where('id', $request->input('id'))->first();
		$shipment->deliver_by_date = $request->input('deliver_by_date');
		$shipment->ship_by_date = $request->input('ship_by_date');
		$shipment->shipped_on_date = $request->input('shipped_on_date');
		$shipment->delivery_date = $request->input('delivery_date');
		$shipment->save();

		return redirect()->back();
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function updateInfo(Request $request)
	{
		$shipment = RidShipment::where('id', $request->input('id'))->first();
		$shipment->courier_id = $request->input('courier_id');
		$shipment->tracking_number = $request->input('tracking_number');
		$shipment->save();

		return redirect()->back();
	}


	public function ridawaitinglist(Request $request)
	{

		$shipments = RidShipment::all();
		$response = new DataTableResponse(Rid::class, $request->all());
		foreach ($shipments as $shipment) {
			$row = new DataTableRow($shipment->id);

			if(!$shipment->rid || !$shipment->deliver_by_date)
				continue;

			$row->setColumn('number', $shipment->rid->number,
				'<a title="RID Number" href="' . route('eac.portal.rid.show', $shipment->rid->id) . '">' .
				$shipment->rid->number .
				'</a>'
			);
			$row->setColumn('drug', $shipment->rid->drug->name,
				'<a title="Drug Requested" href="' . route('eac.portal.drug.show', $shipment->rid->drug_id) . '">' .
				$shipment->rid->drug->name .
				'</a>'
			);
			$row->setColumn('deliver_by_date', strtotime($shipment->deliver_by_date),
				'<span style="display: none">' . Carbon::parse($shipment->deliver_by_date)->format('Y-m-d') . '</span>' . Carbon::parse($shipment->deliver_by_date)->format(config('eac.date_format'))
			);
			$row->setColumn('ship_by_date', strtotime($shipment->ship_by_date),
				'<span style="display: none">' . Carbon::parse($shipment->ship_by_date)->format('Y-m-d') . '</span>' . Carbon::parse($shipment->ship_by_date)->format(config('eac.date_format'))
			);
			$row->setColumn('created_at', strtotime($shipment->created_at),
				'<span style="display: none">' . $shipment->created_at->format('Y-m-d') . '</span>' . $shipment->created_at->format(config('eac.date_format'))
			);
			$row->setColumn('btns', $shipment->id,
				'<a class="btn btn-success" title="Ship" href="' . route('eac.portal.rid.shipment.edit', $shipment->id) . '">' .
				'<i class="fal fa-fw fa-ambulance"></i> Ship' .
				'</a>'
			);
			$response->addRow($row);
		}
		return $response->toJSON();
	}

		/**
		 * Remove the specified resource from storage.
		 *
		 * @param int $id
		 * @return mixed
		 */
		public
		function destroy($id)
		{
			//
		}
	}