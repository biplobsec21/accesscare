<?php

namespace App\Http\Controllers\Drug;

use App\Drug;
use App\DrugGroup;
use App\User;
use App\UserGroup;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class DrugGroupController
 * @package App\Http\Controllers\Drug
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class DrugGroupController extends Controller
{
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$groupExist = DrugGroup::where('drug_id',$request->input('drug_id'))->where('user_group_id',$request->input('user_group_id'))->first();
		if($groupExist){
			return redirect()->back()->with("alert", ['type' => 'danger', 'msg' => 'Group Already Added!']);
		}
		$drugGroup = new DrugGroup();
		$drugGroup->id = $this->newID(DrugGroup::class);
		$drugGroup->drug_id = $request->input('drug_id');
		$drugGroup->user_group_id = $request->input('user_group_id');
		$drugGroup->save();
		return redirect()->back()->with("alert", ['type' => 'success', 'msg' => 'Information Updated successfully']);
	}
	public function newgroupstore(Request $request){

		$group = new UserGroup();
		$group->id = $this->newID(UserGroup::class);
		$group->type_id = $request->input('type_id');
		$group->parent_user_id = $request->input('parent_id');
		$group->name = $request->input('name');
		// $members = new \stdClass();
		// if($request->input('member')){
		// 	$member=array_values($request->input('member'));
		// 	$roles=array_values($request->input('role'));
		// 	for ($i = 0; $i < count($member); $i++) {
		// 	$members->{$member[$i]} = $roles[$i];
		// 	}
		// }
		// $group->group_members = json_encode($members);
		// $group->saveOrFail();
		$users = [];
		if ($request->input('member')) {
			$members = array_values($request->input('member'));
			$roles = array_values($request->input('role'));

			for ($i = 0; $i < count($members); $i++) {
				$user = new \stdClass();
				$user->id = $members[$i];
				$user->role = $roles[$i];
				$users[$i] = $user;
			}
		}
		$group->group_members = json_encode(array_values($users));
		$group->saveOrFail();

		$drugGroup = new DrugGroup();
		$drugGroup->id = $this->newID(DrugGroup::class);
		$drugGroup->drug_id = $request->input('drug_id');
		$drugGroup->user_group_id = $group->id;
		$drugGroup->save();
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

		$drugUser = DrugUser::find($request->id);

		if ($request->input('role_id')) {
			$role = Role::where('id', $request->input('role_id'))->first();
			$user = User::where('id', $drugUser->user_id)->first();
			$user->role_id = $request->input('role_id');
			$drugUser->level = json_encode(json_decode($role->base_level)->drug);
			// $drugUser->save();
			$user->save();

		}

		if($request->level){
			$levelJSON = json_encode($request->level);
			$drugUser->level = str_replace('"on"', '"1"', $levelJSON);
		}

		$drugUser->save();
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
		$drugGroup = DrugGroup::where('id', $id)->first();
		$drugGroup->delete();
		return redirect()->back()->with("alert", ['type' => 'success', 'msg' => 'Group Unassigned']);
	}
}
