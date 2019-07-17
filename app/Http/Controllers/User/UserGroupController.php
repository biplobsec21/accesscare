<?php


namespace App\Http\Controllers\User;

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

		// $sql = UserGroup::where('id', '!=', null);
		$sql = UserGroup::Where('user_groups.id', '!=', '')
			->Leftjoin('users', 'users.id', '=', 'user_groups.parent_user_id')
			->Leftjoin('user_types', 'user_types.id', 'user_groups.type_id')
			->select([
				'user_groups.id as id',
				'user_groups.name as name',
				'user_types.name as type',
				'user_groups.parent_user_id as parent_user_id',
				'users.first_name as first_name',
				'users.last_name as last_name',
				'user_groups.group_members as group_members',
				'user_groups.created_at as created_at',
			]);
		return \DataTables::of($sql)
			->addColumn('name', function ($row) {
				return '<a href="' . route('eac.portal.user.group.edit', $row->id) . '">' . $row->name . '</a>';
			})
			->addColumn('type', function ($row) {
				return $row->type;
			})
			->addColumn('parent', function ($row) {
				return '<a href="' . route("eac.portal.user.show", $row->parent->id) . '">' .
					$row->first_name . ' ' . $row->last_name . '
						</a>';
			})
			->addColumn('members', function ($row) {
				$members = $row->users();
				$str = '';
				for ($i = 0; $i < $members->count(); $i++) {
					$str .= $members[$i]->full_name;
					if ($i < $members->count() - 1)
						$str .= ' + ';
				}
				return '<span class="badge badge-mw badge-outline-info" title="' . $str . '">' . $members->count() . '</span>';

			})
			->addColumn('created_at', function ($row) {
				if ($row->created_at == NULL) {
					return '<span>N/A</span>';
				} else {
					return $row->created_at->format(config('eac.date_format'));
				}
			})
			->addColumn('ops_btns', function ($row) {
				return '<div class="btn-group dropleft" role="group">
				 <a class="btn btn-link" href="#" id="dropdownMenuButton' . $row->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  <span class="far fa-fw fa-ellipsis-v"></span> <span class="sr-only">Actions</span>
				 </a>
				 <div class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $row->id . '">
				  <a class="dropdown-item" title="Edit User Group" href="' . route('eac.portal.user.group.edit', $row->id) . '">
				   <i class="fal fa-fw fa-edit"></i> Edit User Group
				  </a>
				 </div>
				</div>';
			})
			->rawColumns([
				'name',
				'type',
				'parent',
				'members',
				'created_at',
				'ops_btns'
			])
			->filterColumn('name', function ($query, $keyword) {
				$query->where('user_groups.name', 'like', "%" . $keyword . "%");
			})
			->filterColumn('type', function ($query, $keyword) {
				$query->where('user_types.name', 'like', "%" . $keyword . "%");
			})
			->filterColumn('parent', function ($query, $keyword) {
				$query->whereRaw("CONCAT(users.first_name,' ',users.last_name) like ?", ["%{$keyword}%"]);
			})
			->filterColumn('created_at', function ($query, $keyword) {
				$query->where('user_groups.created_at', 'like', "%" . $keyword . "%");
			})
			->order(function ($query) {
				$columns = [
					'name' => 0,
					'type' => 1,
					'parent' => 2,
					'members' => 3,
					'created_at' => 4,
				];
				$direction = request('order.0.dir');
				if (request('order.0.column') == $columns['type']) {
					$query->orderBy('user_types.name', $direction);
				}
				if (request('order.0.column') == $columns['name']) {
					$query->orderBy('user_groups.name', $direction);
				}
				if (request('order.0.column') == $columns['parent']) {
					$query->orderBy('users.first_name', $direction);
				}
				if (request('order.0.column') == $columns['created_at']) {
					$query->orderBy('user_groups.created_at', $direction);
				}
			})
			->smart(0)
			->toJson();

	}
}
