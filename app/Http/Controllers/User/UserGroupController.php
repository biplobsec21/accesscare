<?php


namespace App\Http\Controllers\User;

use App\DataTables\DataTableResponse;
use App\DataTables\DataTableRow;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\GroupCreateRequest;
use App\Traits\AuthAssist;
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
	use Notifier, AuthAssist;

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
        $this->groupInitiate();
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

		$access = $this->groupAuth($group);
		if(!$access->gate('group.index.update'))
            return $this->abortNow();

		return view('portal.user.group.edit', [
			'users' => $users,
			'group' => $group,
            'access' => $access
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

	public function ajaxlist(Request $request)
	{
		$groups = $this->listGroupAccess();
		$response = new DataTableResponse($groups, $request->all());
		return $response->toJSON();
	}
}
