<?php

namespace App\Http\Controllers\Rid;

use App\Rid;
use App\RidGroup;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class RidGroupController
 * @package App\Http\Controllers\Rid
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class RidGroupController extends Controller
{
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$isGroupAdded = RidGroup::where('user_group_id','=',$request->input('user_group_id'))->where('rid_id','=',$request->input('rid_id'))->first();
		if($isGroupAdded){
			return redirect()->back()->with("alert", ['type' => 'danger', 'msg' => 'Group Already added']);
		}
		$ridGroup = new RidGroup();
		$ridGroup->id = $this->newID(RidGroup::class);
		$ridGroup->rid_id = $request->input('rid_id');
		$ridGroup->user_group_id = $request->input('user_group_id');
		$ridGroup->save();
		return redirect()->back()->with("alert", ['type' => 'success', 'msg' => 'Information Updated successfully']);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{

		$ridUser = RidUser::find($request->id);

		if ($request->input('role_id')) {
			$role = Role::where('id', $request->input('role_id'))->first();
			$user = User::where('id', $ridUser->user_id)->first();
			$user->role_id = $request->input('role_id');
			$ridUser->level = json_encode(json_decode($role->base_level)->rid);
			// $ridUser->save();
			$user->save();

		}

		if($request->level){
			$levelJSON = json_encode($request->level);
			$ridUser->level = str_replace('"on"', '"1"', $levelJSON);
		}

		$ridUser->save();
		return redirect()->back()->with("alert", ['type' => 'success', 'msg' => 'Information Updated successfully']);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  string $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$ridGroup = RidGroup::where('id', $id)->first();
		$ridGroup->delete();
		return redirect()->back()->with("alert", ['type' => 'success', 'msg' => 'Group Unassigned']);
	}
}
