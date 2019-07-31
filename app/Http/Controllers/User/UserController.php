<?php


namespace App\Http\Controllers\User;

use App\Address;
use App\DataTables\DataTableResponse;
use App\DataTables\DataTableRow;
use App\DEVUPDATESCRIPTTABLE;
use App\File;
use App\Http\Requests\User\UserCertificationRequest;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Permission;
use App\Phone;
use App\Rid;
use App\Traits\AuthAssist;
use App\Traits\Filer;
use App\Traits\Notifier;
use App\User;
use App\UserCertificate;
use App\UserGroup;
use App\UserType;
use Illuminate\Http\Request;
use Session;

/**
 * Class UserController
 * @package App\Http\Controllers\User
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class UserController extends PermissionsController
{
	use Notifier, AuthAssist, Filer;

	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('user.approved');

	}

	public function listUsers(Request $request)
	{
		if ($request->has('user_status')) {
			if ($request->input('user_status') == 'Approved') {

				$title = $request->input('user_status') . ' ' . UserType::where('id', '=', $request->input('user_type'))->firstOrFail()->name;
			} else {
				$title = $request->input('user_status');
			}
		} else {
			$title = 'All';
		}
		return view('portal.user.list', [
			'users' => User::all(),
			'title' => $title
		]);
	}

	public function show(string $id)
	{
		$user = User::where('id', '=', $id)->firstOrFail();
		$access = $this->userAuth($user);
		$rids = $this->listRidAccess($user);
		$drugs = $this->listDrugAccess($user);
		return view('portal.user.show', [
			'user' => $user,
			'access' => $access,
			'rids' => $rids,
			'drugs' => $drugs
		]);
	}

	public function create()
	{
		if (isset($_SERVER['HTTP_REFERER'])) {
			$originalRef = $_SERVER['HTTP_REFERER'];
			$referrer = substr($originalRef, -17);
			if ($referrer == 'user/group/create') {
				Session::put('redirect_url', 'eac.portal.user.group.create');
			} else {
				Session::forget('redirect_url');
			}
		}

		$roles = \App\Role::all();
		$userType = \App\UserType::all();
		$countries = $this->getCountry();
		return view('portal.user.create', [
			'roles' => $roles,
			'countries' => $countries,
			'user_types' => $userType
		]);
	}

	public function postCreate(UserCreateRequest $request)
	{
		$address = new Address();
		$user = new User();

		$user->id = $this->newID(User::class);

		/*
		 * Fill user data
		 */
		$user->title = $request->input('title');
		if ($request->input('type') == UserType::where('name', 'physician')->first()->id && !$request->input('is_delegate'))
			$user->status = 'Registering';
		else
			$user->status = 'Approved';
		$user->type_id = $request->input('type');
		$user->first_name = $request->input('first_name');
		$user->last_name = $request->input('last_name');
		$user->email = $request->input('email');
		$user->password = \Hash::make($user->id);
		$user->is_delegate = $request->input('is_delegate') ?? 0;

		/*
		 * Fill address data
		 */
		$user->address_id = $address->id = $this->newID(Address::class);
		$address->addr1 = $request->input('addr1');
		$address->addr2 = $request->input('addr2');
		$address->city = $request->input('city');
		$address->zipcode = $request->input('zipcode');
		$address->state_province = $request->input('state');
		$address->country_id = $request->input('country');

		/*
		 * Fill phone data
		 */
		if ($request->input('phone')) {
			$phone = new Phone();
			$phone->id = $this->newID(Phone::class);
			$phone->country_id = $request->input('country');
			$phone->number = $request->input('phone');
			$phone->is_primary = true;
			$user->phone_id = $phone->id;
			$phone->save();
		} else {
			$user->phone_id = 0;
		}

		$user->save();
		$address->save();

		$this->createNotice('user_registration_submitted', $user, $user);
		if (Session::has('redirect_url')) {
			$redirect_url = Session::get('redirect_url');
			Session::forget('redirect_url');
			return redirect()->route($redirect_url);
		} else {
			return redirect()->route('eac.portal.user.show', $user->id);
		}
	}

	/**
	 * CreateRequest a new user instance after a valid registration.
	 *
	 * @param UserCertificationRequest $request
	 * @return \App\User
	 */
	public function sendCertification(UserCertificationRequest $request)
	{
		$user = User::where('id', $request->input('user_id'))->firstOrFail();
		if (!$request->has('emergency_register')) {
			$cert = new UserCertificate();
			$cert->id = $this->newID(UserCertificate::class);
			$cert->user_id = $request->input('user_id');
			$cvFile = $request->file('cv_file');
			$file = $this->createFile($request->file('cv_file'), 'user.cv');
			$cert->cv_file = $file->id;
			$licenseFile = $request->file('license_file');
			$file = $this->createFile($request->file('license_file'), 'user.license');
			$cert->license_file = $file->id;
			$cert->user_signature = $request->input('user_signature');
			$cert->save();
		}

		$user->status = 'Pending';
		$user->save();
		$this->createNotice('user_registration_submitted', $user, $user);
		$this->createNotice('user_registration_needs_attention', $user, 'eac');

		return redirect()->route('eac.portal.getDashboard');
	}

	public function changePassword($id)
	{
		if ($_POST['pass_1'] !== $_POST['pass_2'])
			return redirect()->back()->with('alert', 'Passwords Did Not Match.');
		$user = User::where('id', $id)->firstOrFail();
		$user->password = \Hash::make($_POST['pass_1']);
		$user->save();
		$this->createNotice('user_reset_password', $user, $user);
		return redirect()->back()->with('confirm', 'Password Has Been Changed.');
	}

	public function approve($id)
	{
		$user = User::where('id', '=', $id)->firstOrFail();
		if ($user->status == 'Pending') {
			$this->createNotice('user_approved', $user, $user);
		}
		$user->status = 'Approved';
		$user->save();
        if ($user->type->name == 'Physican' && !$user->groups_leading->count()) {
            $group = new UserGroup();
            $group->id = $this->newID(UserGroup::class);
            $group->type_id = $user->type->id;
            $group->parent_user_id = $user->id;
            $group->name = trim($user->full_name) . '\'s Group';
            $group->group_members = json_encode(array_values($users));
            $group->saveOrFail();
        }
		return redirect()->back()->with('confirm', '<h5 class="text-primary"><i class="fas fa-check-circle"></i> Authorized</h5><p class="text-dark "><strong>' . $user->full_name . '</strong> is able to access content.</p>');
	}

	public function deny($id)
	{
		$user = User::where('id', '=', $id)->firstOrFail();
		$user->status = 'Suspended';
		$user->save();
		return redirect()->back();
	}

	public function pend($id)
	{
		$user = User::where('id', '=', $id)->firstOrFail();
		$user->status = 'Pending';
		$user->save();
		return redirect()->back();
	}

	public function edit($id)
	{
		$countries = $this->getCountry();
		$user = User::where('id', '=', $id)->firstOrFail();
		$access = $this->userAuth($user);
		$userType = \App\UserType::all();
		$rids = $this->listRidAccess($user);
		$drugs = $this->listDrugAccess($user);
		return view('portal.user.edit', [
			'user' => $user,
			'countries' => $countries,
			'user_types' => $userType,
			'rids' => $rids,
			'drugs' => $drugs,
			'access' => $access
		]);
	}

	public function postEdit(UserUpdateRequest $request)
	{
		$userId = $request->id;
		$user = User::find($userId);


		$address = Address::find($request->address_id);
		if (!empty($address)) {
			$address->addr1 = $request->input('addr1');
			$address->addr2 = $request->input('addr2');
			$address->city = $request->input('city');
			$address->zipcode = $request->input('zipcode');
			$address->state_province = $request->input('state');
			$address->country_id = $request->input('country');
		} else {
			$address = new Address();
			$user->address_id = $address->id = $this->newID(Address::class);
			$address->addr1 = $request->input('addr1');
			$address->addr2 = $request->input('addr2');
			$address->city = $request->input('city');
			$address->zipcode = $request->input('zipcode');
			$address->state_province = $request->input('state');
			$address->country_id = $request->input('country');
		}
		$address->save();

		$phone = Phone::find($request->phone_id);
		if ($request->input('phone')) {
			$phone = new Phone();
			$phone->id = $user->phone_id = $this->newID(Phone::class);
			$phone->country_id = $request->input('country');
			$phone->number = $request->input('phone');
			$phone->is_primary = 1;
			$phone->save();
		} else {
			$user->phone_id = null;
		}


		$user->title = $request->input('title');
		$user->first_name = $request->input('first_name');
		$user->last_name = $request->input('last_name');
		$user->email = $request->input('email');
		if ($request->input('type') !== $user->type) {
			$user->type_id = $request->input('type');
			// $user->role_id = 0;
		}
		$user->status = $request->input('status');
		$user->save();

		return redirect()->route('eac.portal.user.show', $user->id);
	}

	public function ajaxUserData(Request $request)
	{
		$users = $this->listUserAccess();
		$response = new DataTableResponse(User::class, $request->all());

		if (Request()->input('user_status'))
			$users = $users->where('status', Request()->input('user_status'));

		if (Request()->input('user_type'))
			$users = $users->where('type_id', Request()->input('user_type'));

		foreach ($users as $user) {
			$row = new DataTableRow($user->id);

			$row->setColumn('name', $user->number,
				"<a href=" . route('eac.portal.user.show', $user->id) . ">" . $user->full_name . "</a>"
			);
			$row->setColumn('status', $user->status,
				'<span class="badge badge-' . config('eac.user.status')[$user->status] . '">' . $user->status . '</span>'
			);
			$row->setColumn('email', $user->email,
				'<a href="mailto:' . $user->email . '">' . $user->email . '</a>'
			);
			$row->setColumn('user_type', $user->type->name
			);
			$row->setColumn('created_at', strtotime($user->created_at),
				'<span style="display: none">' . $user->created_at->format('Y-m-d') . '</span>' . $user->created_at->format(config('eac.date_format')),
				$user->created_at->format(config('eac.date_format'))
			);
			$row->setColumn('btns', $user->id,
				'<div class="btn-group" role="group">
				 <div class="btn-group dropleft">
				  <a class="btn btn-link" href="#" id="dropdownMenuButton' . $user->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				   <span class="far fa-fw fa-ellipsis-v"></span> <span class="sr-only">Actions</span>
				  </a>
				  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $user->id . '">
				   <a class="dropdown-item" title="Edit User" href="' . route('eac.portal.user.edit', $user->id) . '">
					<span class="fal fa-fw fa-edit"></span> Edit User
				   </a>
				   <a class="dropdown-item" title="View User" href="' . route('eac.portal.user.show', $user->id) . '">
					<span class="fal fa-fw fa-search-plus"></span> View User
				   </a>
				  </div>
				 </div>
				</div>'
			);
			$response->addRow($row);
		}
		return $response->toJSON();
	}


	public function ajaxAssociatedRids($id)
	{

		$sql = Rid::Where('rids.id', '!=', '')
			->Leftjoin('rid_records', 'rids.id', '=', 'rid_records.parent_id')
			->Leftjoin('drug', 'drug.id', '=', 'rids.drug_id')
			->Leftjoin('users', 'users.id', '=', 'rid_records.physician_id')
			->Leftjoin('rid_master_statuses', 'rid_master_statuses.id', '=', 'rids.status_id')
			->where('users.id', '=', $id)
			->groupBy('rids.id')
			->select([
				'rids.id as id',
				'rids.number as number',
				'drug.name as drug_name',
				'drug.id as drug_id',
				'rid_master_statuses.name as status',
				'users.first_name as first_name',
				'users.last_name  as last_name',
				'users.id  as uid', 'rids.req_date as req_date',
				'rids.created_at as created_at']);

		// $users = User::where('id', '=', $id)->firstOrFail();
		// $rids = $users->rids;

		return \DataTables::of($sql)->addColumn('number', function ($row) {
			// return $row->number;
			return '<a title="RID Number" href="' . route('eac.portal.rid.show', $row->id) . '">' .
				$row->number
				. '</a>';

		})->addColumn('status', function ($row) {
			return '<span class="badge badge-' . config('eac.rid.status')[$row->status] . '">' . $row->status . '</span>';
		})->addColumn('physician_name', function ($row) {
			// return $row->first_name . " " . $row->last_name;
			return '<a title="Assigned User" href="' . route('eac.portal.user.show', $row->uid) . '">' .
				$row->first_name . " " . $row->last_name
				. '</a>';

		})->addColumn('drug_name', function ($row) {
			// return $row->drug_name;
			return '<a title="Assigned User" href="' . route('eac.portal.drug.show', $row->drug_id) . '">' .
				$row->drug_name
				. '</a>';
		})->addColumn('ops_btns', function ($row) {
			return '
			      <a title="Edit RID" href="' . route('eac.portal.rid.edit', $row->id) . '">
			       <i class="far fa-edit" aria-hidden="true"></i> <span class="sr-only">Edit RID</span>
			      </a>
									<a title="View RID" href="' . route('eac.portal.rid.show', $row->id) . '">
			 						<i class="far fa-search-plus" aria-hidden="true"></i> <span class="sr-only">View RID</span>
									</a>
			 		<a title="Post Approval Document" href="' . route('eac.portal.rid.postreview', $row->id) . '">
			       <i class="far fa-plus" aria-hidden="true"></i> <span class="sr-only">Post Approval Document</span>
			      </a>
						';
		})->rawColumns(['number', 'name', 'status', 'physician_name', 'drug_name', 'req_date', 'created_date', 'ops_btns'])->filterColumn('number', function ($query, $keyword) {
			$query->where('rids.number', 'like', "%" . $keyword . "%");
		})->filterColumn('status', function ($query, $keyword) {
			$query->where('rid_master_statuses.name', 'like', "%" . $keyword . "%");
		})->filterColumn('physician_name', function ($query, $keyword) {
			$query->where('users.first_name', 'like', "%" . $keyword . "%");
		})->filterColumn('drug_name', function ($query, $keyword) {
			$query->where('drug.name', 'like', "%" . $keyword . "%");
		})->order(function ($query) {
			$columns = ['number' => 0, 'status' => 1, 'physician_name' => 2, 'drug_name' => 3];

			$direction = request('order.0.dir');

			if (request('order.0.column') == $columns['number']) {
				$query->orderBy('rids.number', $direction)->orderBy('rids.number', $direction);
			}
			if (request('order.0.column') == $columns['status']) {
				$query->orderBy('rid_master_statuses.name', $direction);
			}
			if (request('order.0.column') == $columns['physician_name']) {
				$query->orderBy('users.first_name', $direction);
			}
			if (request('order.0.column') == $columns['drug_name']) {
				$query->orderBy('drug.name', $direction);
			}
			// if (request('order.0.column') == $columns['req_date']) {
			// 	$query->orderBy('rids.req_date', $direction);
			// }
			// if (request('order.0.column') == $columns['created_at']) {
			// 	$query->orderBy('rids.created_at', $direction);
			// }
		})->smart(0)->toJson();
	}

	public function ajaxlistmerge(Request $request)
	{

		$sql = User::Where('users.status', '!=', '')
			->leftjoin('user_types', 'users.type_id', '=', 'user_types.id')
			->groupBy('users.id')
			// ->with('company')
			->select([
					'users.id as id',
					'user_types.name as type',
					'users.first_name as first_name',
					'users.last_name as last_name',
					'users.status as status',
					'users.email as email',
					'users.created_at as created_at']
			);
		return \DataTables::of($sql)
			->addColumn('primary', function ($row) {
				return '<input type="radio" name="primary" value="' . $row->id . '" />';
			})
			->addColumn('merge', function ($row) {
				return '<input type="checkbox" name="merge[]" value="' . $row->id . '" />';
			})
			->addColumn('name', function ($row) {
				return "<a href=" . route('eac.portal.user.show', $row->id) . ">" . $row->full_name . "</a>";
			})
			->addColumn('status', function ($row) {
				return '<span class="badge badge-' . config('eac.user.status')[$row->status] . '">' . $row->status . '</span>';
			})
			->addColumn('email', function ($row) {
				return '<a href="mailto:' . $row->email . '">' . $row->email . '</a>';
			})
			->addColumn('user_type', function ($row) {
				return $row->type;
			})
			->rawColumns([
				'primary',
				'merge',
				'name',
				'status',
				'email',
				'user_type'
			])
			->filterColumn('name', function ($query, $keyword) {
				$query->whereRaw("CONCAT(users.first_name,' ',users.last_name) like ?", ["%{$keyword}%"]);
			})
			->filterColumn('email', function ($query, $keyword) {
				$query->where('users.email', 'like', "%" . $keyword . "%");
			})
			->filterColumn('status', function ($query, $keyword) {
				$query->where('users.status', 'like', "%" . $keyword . "%");
			})
			->filterColumn('user_type', function ($query, $keyword) {
				$query->where('user_types.name', 'like', "%" . $keyword . "%");
			})
			->order(function ($query) {
				$columns = [
					'primary' => 0,
					'merge' => 1,
					'name' => 2,
					'status' => 3,
					'email' => 4,
					'user_type' => 5
				];

				$direction = request('order.0.dir');

				if (request('order.0.column') == $columns['name']) {
					$query->orderBy('users.first_name', $direction);
				}
				if (request('order.0.column') == $columns['status']) {
					$query->orderBy('users.status', $direction);
				}
				if (request('order.0.column') == $columns['email']) {
					$query->orderBy('users.email', $direction);
				}
				if (request('order.0.column') == $columns['user_type']) {
					$query->orderBy('user_types.name', $direction);
				}
			})
			->smart(1)
			->toJson();
	}

	// merge view load
	public function merge()
	{
		// $depots = Depot::all();
		return view('portal.user.listmerge');
	}

	// merge view selected
	public function mergeselected(Request $request)
	{

		if (!$request->primary) {
			return redirect()->back()->with("alerts", ['type' => 'danger', 'msg' => 'Please select a primary data!']);
		}
		if (empty($request->merge)) {
			return redirect()->back()->with("alerts", ['type' => 'danger', 'msg' => 'Please select a merge data!']);
		}
		$primary_id = $request->primary;
		$rowsPrimary = User::where('id', $primary_id);

		$merge_id = $request->merge;
		$rowsMerge = User::whereIn('id', $merge_id);

		return view('portal.user.selectedmerge', [
			'rowsPrimary' => $rowsPrimary,
			'rowsMerge' => $rowsMerge,
		]);

	}

	// merge selected data post

	public function mergepost(Request $request)
	{


		if (!$request->primary_id) {
			return redirect()->back()->with("alerts", ['type' => 'danger', 'msg' => 'Please select a primary data!']);
		}
		$primary_data = $request->primary_id;
		$merge_data = $request->merged_id;

		$merged_id = json_encode($merge_data);
		$table_name = "drug_lots";

		$data = new \App\MergeData();
		$data->id = $this->newID(MergeData::class);
		$data->primary_id = $primary_data;
		$data->primary_old_id = $this->findOldprimaryId($primary_data);
		$data->merge_id = $merged_id;
		$data->table_name = $table_name;
		// find out old ids
		array_push($merge_data, $primary_data);

		$migration_old_id = $this->findOldId($merge_data);
		$data->migration_old_id = $migration_old_id;
		$data->save();


		// replace pharmacies physicians
		$pharmacyPhysicians = \App\Pharmacy::whereIn('physician_id', $merge_data)->update(['physician_id' => $primary_data]);
		$pharmacyPhysiciansCount = \App\Pharmacy::whereIn('physician_id', $merge_data);

		// replace rids physicians
		$ridPhysicians = \App\Rid::whereIn('physician_id', $merge_data)->update(['physician_id' => $primary_data]);
		$ridPhysiciansCount = \App\Rid::whereIn('physician_id', $merge_data);


		// replace RidVisit physicians
		$ridVisit = \App\RidVisit::whereIn('physician_id', $merge_data)->update(['physician_id' => $primary_data]);
		$ridVisitCount = \App\RidVisit::whereIn('physician_id', $merge_data);

		// replace User Certificates
		$userCertificate = \App\UserCertificate::whereIn('user_id', $merge_data)->update(['user_id' => $primary_data]);
		$userCertificateCount = \App\UserCertificate::whereIn('user_id', $merge_data);


		// replace group member id
		$userMembers = \App\UserGroup::all();
		$newarr = array();
		$groupMember = 0;
		if ($userMembers->count() > 0) {
			foreach ($request->merged_id as $id) {
				foreach ($userMembers as $key => $val) {

					$arr = json_decode($val->group_members, TRUE);
					// dd(count($arr));
					if (!empty($arr)) {
						for ($i = 0; $i < count($arr); $i++) {
							if ($arr[$i]['id'] == $id) {
								$newarr[$i]['id'] = $request->primary_id;
								$newarr[$i]['role'] = $arr[$i]['role'];
								$groupMember++;
							} else {
								$newarr[$i] = $arr[$i];
							}
						}
					}

					\App\UserGroup::where('id', $val->id)->update(['group_members' => json_encode($newarr)]);
				}
			}
		}

		$string = $groupMember . " Group Member, ";
		$string .= $pharmacyPhysiciansCount->count() . " Physician Users, ";
		$string .= $ridPhysiciansCount->count() . " Master Rid Users, ";

		$string .= $ridVisitCount->count() . " Rid Visit Physician Users, ";
		$string .= $userCertificateCount->count() . " Users Certificates";
		// remove primary id from selected merge data
		$temparray = array($primary_data);
		$result = array_diff($merge_data, $temparray);
		$remove = User::whereIn('id', $result)->delete();

		// dd($string);
		return redirect(route('eac.portal.user.list.merge'))
			->with("alerts_merge", ['type' => 'success', 'msg' => $string . "  updated"])
			->with("alerts", ['type' => 'success', 'msg' => 'Users Merged successfully']);

	}

	// migration old_id
	public function findOldId($array)
	{
		$data = DEVUPDATESCRIPTTABLE::whereIn('id_new', $array)->select('id_old');
		// dd($data->toJson());
		$singleArray = [];
		if ($data->count() > 0) {
			foreach ($data as $key => $value) {
				$singleArray[$key] = $value->id_old;
			}
			return json_encode($singleArray, TRUE);
		}


		return json_encode($singleArray, TRUE);
	}

	public function findOldprimaryId($array)
	{
		$data = DEVUPDATESCRIPTTABLE::where('id_new', $array)->select('id_old')->first();

		if ($data) {
			return $data;
		} else {
			return '0';

		}

	}
}
