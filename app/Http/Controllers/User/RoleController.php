<?php

namespace App\Http\Controllers\User;

use App\Role;
use App\Traits\GeneratesModals;
use App\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

/**
 * Class RoleController
 * @package App\Http\Controllers\Settings\Manage
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class RoleController extends PermissionsController
{
	use GeneratesModals;

	/**
	 * RoleController constructor.
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return view('portal.settings.manage.user.role.index', [
			'roles' => Role::where('hidden', 0),
			'baseDefault' => Role::default_level(),
			'types' => UserType::all()->sortBy('name'),
		]);
	}

	public function create()
	{
		return view('portal.settings.manage.user.role.create', [
			'types' => UserType::all()->sortBy('name'),
		]);
	}

	public function store(Request $request)
	{
		$errors = [];
		if(!$request->input('role_name'))
			$errors['role_name'] = ['Please specify the name of the role.'];
		if(!$request->input('role_type'))
			$errors['role_type'] = ['Please specify the type of the role.'];
		if(Role::where('type_id', $request->input('role_type'))->where('name', $request->input('role_name'))->count())
			$errors['role_name'] = ['Identical role found: Please check the existing roles or try again with a different name.'];

		if($errors) {
			$request->flash();
			return Redirect::back()->withErrors($errors);
		}

		$role = new Role();
		$role->id = $this->newID(Role::class);
		$role->name = $request->input('role_name');
		$role->type_id = $request->input('role_type');
		$role->save();
		return redirect()->route('eac.portal.settings.manage.user.role.edit', $role->id);
	}

	public function update(Request $request)
	{
		$role = Role::where('id', '=', $request->input('role_id'))->firstOrFail();
		if ($request->input('level'))
			$role->base_level = json_encode($request->input('level'));
		else
			$role->base_level = null;
		$role->save();
		return redirect()->route('eac.portal.settings.manage.user.role')->with('confirm', ucwords($role->type->name) . ': ' . ucwords($role->name) . ' has been updated.');
	}

	public function delete($id)
	{
		throw new \Exception("Not yet implemented. Check RoleController@update");
	}

	public function edit($id)
	{
		return view('portal.settings.manage.user.role.edit', [
			'role' => Role::where('id', $id)->firstOrFail(),
			'permissions' => Role::default_level(),
		]);
	}

	public function getControlledAreas()
	{
		return array_keys((array)Role::default_level());
	}

	public function getAreaSections($area)
	{
		return Role::default_level()->{$area};
	}
}
