<?php


namespace App\Http\Controllers\User;

use App\DataTables\DataTableResponse;
use App\DataTables\DataTableRow;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\GroupCreateRequest;
use App\Traits\Notifier;
use App\User;
use App\UserGroup;
use Illuminate\Http\Request;

/**
 * Class UserGroupController
 * @package App\Http\Controllers\User
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class UserGroupController extends Controller
{
	use Notifier;

	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('user.approved');
	}

	public function list()
	{
		$users = User::all();
		$groups = UserGroup::all();
		return view('portal.user.group.list', [
			'users' => $users,
			'groups' => $groups,
		]);
	}

	public function create()
	{
		$users = User::all()->sortBy('first_name');
		return view('portal.user.group.create', [
			'users' => $users,
		]);
	}

	public function store(GroupCreateRequest $request)
	{
		$group = new UserGroup();
		$group->id = $this->newID(UserGroup::class);
		$group->type_id = $request->input('type_id');
		$group->parent_user_id = $request->input('parent_id');
		$group->name = $request->input('name');
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
		return redirect()->route('eac.portal.user.group.list')->with('confirm', 'User Group Has Been Created');
	}

	public function edit($id)
	{
		$group = UserGroup::where('id', $id)->first();
		$users = User::all()->sortBy('first_name');
		return view('portal.user.group.edit', [
			'users' => $users,
			'group' => $group,
		]);
	}

	public function update(Request $request, $id)
	{
		$group = UserGroup::where('id', $id)->firstOrFail();
		$group->type_id = $_POST['type_id'];
		$group->parent_user_id = $_POST['parent_id'];
		$group->name = $_POST['name'];

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
		return redirect()->route('eac.portal.user.group.list')->with('confirm', 'User Group Has Been Updated');
	}

	public function addMember($id)
	{
		$group = UserGroup::where('id', $id)->firstOrFail();

		$user = new \stdClass();
		$user->id = $_GET['member'];
		$user->role = $_GET['role'];

		$members = json_decode($group->group_members);
		if (!$members)
			$members = [];
		array_push($members, $user);
		$group->group_members = json_encode($members);
		$group->saveOrFail();
		return $group->group_members;
	}

	public function removeMember($id)
	{
		$group = UserGroup::where('id', $id)->firstOrFail();
		$members = json_decode($group->group_members, true);

		for($i = 0; $i < count($members); $i++) {
			if ($_GET['user'] == $members[$i]['id']) {
				unset($members[$i]);
			}
		}
		$group->group_members = json_encode(array_values($members));
		$group->saveOrFail();
		return json_encode($members);
	}


	public function ajaxDelete(Request $request)
	{

		$id = $request->id;
		$userGroup = UserGroup::find($id)->delete();
		return [
			"result" => "Success"
		];
	}

	public function ajaxlist()
	{

		$groups = UserGroup::all();
		$response = new DataTableResponse(User::class, null);

		foreach ($groups as $group) {
			$row = new DataTableRow($group->id);

			$row->setColumn('name', $group->name,
				'<a href="' . route('eac.portal.user.group.edit', $group->id) . '">' . $group->name . '</a>'
			);
			$row->setColumn('type', $group->type->name
			);
			$row->setColumn('parent', $group->parent->full_name,
				'<a href="' . route("eac.portal.user.show", $group->parent->id) . '">' . $group->parent->full_name . '</a>'
			);
			$row->setColumn('members', $group->users()->count(),
				'<span class="badge badge-mw badge-outline-info" title="' . str_replace('"', '', json_encode($group->users()->pluck('full_name'))) . '">' . $group->users()->count() . '</span>'
			);
			$row->setColumn('created_at', strtotime($group->created_at),
				'<span style="display: none">' . $group->created_at->format('Y-m-d') . '</span>' . $group->created_at->format(config('eac.date_format')),
				$group->created_at->format(config('eac.date_format'))
			);
			$row->setColumn('btns', $group->id,
				'<div class="btn-group dropleft" role="group">
				 <a class="btn btn-link" href="#" id="dropdownMenuButton' . $group->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  <span class="far fa-fw fa-ellipsis-v"></span> <span class="sr-only">Actions</span>
				 </a>
				 <div class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $group->id . '">
				  <a class="dropdown-item" title="Edit User Group" href="' . route('eac.portal.user.group.edit', $group->id) . '">
				   <i class="fal fa-fw fa-edit"></i> Edit User Group
				  </a>
				 </div>
				</div>'
			);
			$response->addRow($row);
		}
		return $response->toJSON();
	}
}
