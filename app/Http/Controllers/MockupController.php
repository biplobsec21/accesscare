<?php

namespace App\Http\Controllers;

use App\Address;
use App\Company;
use App\Drug;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rid\CreateRequest;
use App\Pharmacy;
use App\Rid;
use App\RidVisitStatus;
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
class MockupController extends Controller
{
	use WorksWithRIDs, Notifier, AuthAssist;

	/**
	 * Show the form for editing the specified resource.
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request)
	{
		$warning = false;
		if($request->warning){
			$warning = true;
		}
		$visit = RidVisit::all()->first();
		$rid = $visit->rid;
		$access = $this->ridAuth($rid);
		//$this->authorize('rid.visit.update');
		$roles = \App\Role::all()->sortBy('name');
		$countries = \App\Country::all()->sortBy('name');
		$states = \App\State::all()->sortBy('name');
		$users = \App\User::all()->sortBy('first_name');
		$statuses = \App\RidStatus::all();
		$couriers = \App\ShippingCourier::all();
		$pharmacies = \App\Pharmacy::all();
		return view('portal.mockup.rid-edit-visit', [
			'rid' => $rid,
			'visit' => $visit,
			'states' => $states,
			'roles' => $roles,
			'countries' => $countries,
			'users' => $users,
			'statuses' => $statuses,
			'couriers' => $couriers,
			'pharmacies' => $pharmacies,
			'pageTitle' => 'Edit Visit',
			'warning' => $warning,
			'access' => $access
		]);
	}
}
