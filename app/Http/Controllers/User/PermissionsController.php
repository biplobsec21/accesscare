<?php

namespace App\Http\Controllers\User;

use App\Drug;
use App\DrugUser;
use App\Http\Controllers\Controller;
use App\Permission;
use App\Rid;
use App\RidUser;
use App\Role;
use App\Traits\GeneratesModals;
use App\User;

/**
 * Class PermissionsController
 * @package App\Http\Controllers\Settings\Manage
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class PermissionsController extends Controller
{
	use GeneratesModals;

	/**
	 * PermissionsController constructor.
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return view('portal.settings.manage.user.permission.index');
	}

	/**
	 * Set the user's application permissions
	 * @deprecated 2019-05-16
	 */
	public function setGlobalPermission()
	{
		$perms = Permission::where('id', $_POST['id'])->firstOrFail();
		$level = json_decode($perms->level, true);
		$level[$_POST['page']] = json_decode(str_replace('"on"', '"1"', json_encode($_POST['level'])));
		$perms->level = json_encode($level);
		$perms->save();
		return redirect()->back();
	}

	/**
	 * Set the user's permissions in assignment
	 * @deprecated 2019-05-16
	 */
	public function setBasePermission()
	{
		$perms = DrugUser::where('id', $_POST['id'])->firstOrFail();
		$perms->level = str_replace('"on"', '"1"', json_encode($_POST['base_level']));
		$perms->save();
		return redirect()->back();

		$perms = RidUser::where('id', $_POST['id'])->firstOrFail();
		$perms->level = str_replace('"on"', '"1"', json_encode($_POST['base_level']));
		$perms->save();
		return redirect()->back();
	}

	/**
	 * Store customized permissions for specific rid and user instance
	 * @deprecated 2019-05-16
	 */
	public function setAssignedPermission()
	{
		$perms = DrugUser::where('id', $_POST['id'])->firstOrFail();
		$perms->level = str_replace('"on"', '"1"', json_encode($_POST['base_level']));
		$perms->save();
		return redirect()->back();

		$perms = RidUser::where('id', $_POST['id'])->firstOrFail();
		$perms->level = str_replace('"on"', '"1"', json_encode($_POST['base_level']));
		$perms->save();
		return redirect()->back();
	}

	/**
	 * Set the user's overall role
	 * @deprecated 2019-05-16
	 */
	public function setUserRole($id)
	{
		$user = User::where('id', $id)->firstOrFail();
		$user->role_id = $_POST["role"];
		$user->save();

		if ($user->role_id) {
			if ($user->permission) {
				$perms = $user->permission;
				$rolePerms = Role::where('id', $user->role_id)->firstOrFail()->base_level;
				$perms->level = $rolePerms;
				$perms->save();
			} else {
				$perms = new Permission();
				$perms->id = $this->newID(Permission::class);
				$perms->user_id = $user->id;
				$rolePerms = Role::where('id', $user->role_id)->firstOrFail()->base_level;
				$perms->level = $rolePerms;
				$perms->save();
			}
		}

		if ($_POST['set'] == 'Assigned')
			$this->setRoleWhereAssigned($id);
		elseif ($_POST['set'] == 'All')
			$this->setRoleAll($id);

		return redirect()->back();
	}

	/**
	 * Set the user's role on a drug
	 * @deprecated 2019-05-16
	 */
	public function setDrugRole()
	{
		$drug = Drug::where('id', $_POST['drug'])->first();
		$user = User::where('id', $_POST['user'])->first();
		$drugUser = $drug->hasUser($user->id);
		if ($drugUser) {
			if ($_POST['role'] === "0") {
				$drugUser->delete();
			} elseif ($_POST['role'] === "Inherited") {
				$drugUser->role_id = $user->role_id;
				$drugUser->level = json_encode("Inherited");
				$drugUser->save();
			} else {
				$role = Role::where('id', $_POST['role'])->first();
				$drugUser->role_id = $role->id;
				$drugUser->level = json_encode(json_decode($role->base_level, true)['drug']);
				$drugUser->save();
			}
		} else {
			$drugUser = new DrugUser();
			$drugUser->id = $this->newID(DrugUser::class);
			if ($_POST['role'] === "Inherited") {
				$drugUser->user_id = $user->id;
				$drugUser->drug_id = $drug->id;
				$drugUser->role_id = $user->role_id;
				$drugUser->level = json_encode("Inherited");
				$drugUser->save();
			} else {
				$role = Role::where('id', $_POST['role'])->first();
				$drugUser->user_id = $user->id;
				$drugUser->drug_id = $drug->id;
				$drugUser->role_id = $role->id;
				$drugUser->level = json_encode(json_decode($role->base_level, true)['drug']);
				$drugUser->save();
			}
		}
		return redirect()->back();
	}

	/**
	 * Set the user's role on a rid
	 * @deprecated 2019-05-16
	 */
	public function setRidRole()
	{
		$rid = Rid::where('id', $_POST['rid'])->first();
		$user = User::where('id', $_POST['user'])->first();
		$ridUser = $rid->hasUser($user->id);
		if ($ridUser) {
			if ($_POST['role'] === "0") {
				$ridUser->delete();
			} elseif ($_POST['role'] === "Inherited") {
				$ridUser->role_id = $user->role_id;
				$ridUser->level = json_encode("Inherited");
				$ridUser->save();
			} else {
				$role = Role::where('id', $_POST['role'])->first();
				$ridUser->role_id = $role->id;
				$ridUser->level = json_encode(json_decode($role->base_level, true)['rid']);
				$ridUser->save();
			}
		} else {
			$ridUser = new DrugUser();
			$ridUser->id = $this->newID(RidUser::class);
			if ($_POST['role'] === "Inherited") {
				$ridUser->user_id = $user->id;
				$ridUser->rid_id = $rid->id;
				$ridUser->role_id = $user->role_id;
				$ridUser->level = json_encode("Inherited");
				$ridUser->save();
			} else {
				$role = Role::where('id', $_POST['role'])->first();
				$ridUser->user_id = $user->id;
				$ridUser->rid_id = $rid->id;
				$ridUser->role_id = $role->id;
				$ridUser->level = json_encode(json_decode($role->base_level, true)['rid']);
				$ridUser->save();
			}
		}
		return redirect()->back();
	}

	/**
	 * Set the user's role where an assignment record exists
	 * @deprecated 2019-05-16
	 */
	public function setRoleWhereAssigned($id)
	{
		$user = User::where('id', $id)->firstOrFail();
		if ($user->type == "Pharmaceutical") {
			foreach ($user->assignedDrugs as $assignedDrug) {
				$assignedDrug->role_id = $user->role_id;
				$assignedDrug->level = json_encode('Inherited');
				$assignedDrug->save();
			}
		} elseif ($user->type == "Physician") {
			foreach ($user->assignedRids as $assignedRid) {
				$assignedRid->role_id = $user->role_id;
				$assignedRid->level = json_encode('Inherited');
				$assignedRid->save();
			}
		}
	}

	/**
	 * Set the user's role for all assignments
	 * @deprecated 2019-05-16
	 */
	public function setRoleAll($id)
	{
		$this->setRoleWhereAssigned($id);
		$user = User::where('id', $id)->firstOrFail();
		if ($user->type == "Pharmaceutical") {
			foreach ($user->company->drugs as $drug) {
				if (!$drug->hasUser($user->id)) {
					$drugUser = new DrugUser();
					$drugUser->id = $this->newID(DrugUser::class);
					$drugUser->drug_id = $drug->id;
					$drugUser->user_id = $id;
					$drugUser->role_id = $user->role_id;
					$drugUser->level = json_encode('Inherited');
					$drugUser->save();
				}
			}
		} elseif ($user->type == "Physician") {
			//Does not include physician team
			foreach ($user->rids as $rid) {
				if (!$rid->hasUser($user->id)) {
					$ridUser = new RidUser;
					$ridUser->id = $this->newID(RidUser::class);
					$ridUser->rid_id = $rid->id;
					$ridUser->user_id = $id;
					$ridUser->role_id = $user->role_id;
					$ridUser->level = json_encode('Inherited');
					$ridUser->save();
				}
			}
		}
	}
}
