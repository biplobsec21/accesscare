<?php

namespace App\Http\Controllers;

use DB;
use App\Country;
use App\Drug;
use App\Ethnicity;
use App\Log;
use App\Rid;
use App\ShippingCourier;
use App\RidStatus;
use App\State;
use App\Traits\AuthAssist;
use App\User;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class DashboardController extends Controller
{
	use AuthAssist;
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('user.approved');

	}

	public function index()
	{
		$rids = $this->listRidAccess();
		$drugs = $this->listDrugAccess();
		$users = $this->listUserAccess();
		$groups = $this->listGroupAccess();
		return view('portal.dashboard', [
			'rids' => $rids,
			'drugs' => $drugs,
			'users' => $users,
			'groups' => $groups,
		]);
	}


	public function ajaxrecentactivity(Request $request)
	{
		// log = Logs::where(function ($query) use ($arr) {
		//                       ->orWhere('type', 'LIKE', '%' . $queryArr[0] . '%');
		//               });
		$keys = [

			// '%"table_name":"%notifications%"%',
			'%"table_name":"%documents%"%',
			'%"table_name":"%abilities%"%',
			'%"table_name":"%companies%"%',
			'%"table_name":"%countries%"%',
			'%"table_name":"%departments%"%',
			'%"table_name":"%documents%"%',

			'%"table_name":"%dosage_forms%"%',
			'%"table_name":"%dosage_routes%"%',
			'%"table_name":"%dosage_strength%"%',
			'%"table_name":"%dosage_units%"%',
			'%"table_name":"%drug%"%',
			'%"table_name":"%ethnicity%"%',

			'%"table_name":"%mailers%"%',
			'%"table_name":"%menus%"%',
			'%"table_name":"%pages%"%',
			'%"table_name":"%permissions%"%',

			'%"table_name":"%rids%"%',
			'%"table_name":"%rid_records%"%',
			'%"table_name":"%rid_shipments%"%',

			'%"table_name":"%shipping_couriers%"%',
			'%"table_name":"%states%"%',
			'%"table_name":"%users%"%',
			// '%"table_name":"%user_certifications%"%',
			'%"table_name":"%user_groups%"%'
		];
		$sql = Log::Where(function ($query) use ($keys) {
			foreach ($keys as $key => $value) {
				$query->orWhere('type', 'Like', $value);
			}

		})
			->orderby('created_at', 'desc');
		// dd($sql);
		return \DataTables::of($sql)
			->addColumn('date', function ($row) {
				return $row->created_at ? date('Y-m-d', strtotime($row->created_at)) : '';
				// return $row->created_at;
			})->addColumn('item', function ($row) {

				return $this->getItemStatusData($row, 'item');

			})->addColumn('status', function ($row) {

				return $this->getItemStatusData($row, 'status');

			})->addColumn('type', function ($row) {

				$typeData = json_decode($row->type);
				return $typeData->message;


			})->addColumn('activity', function ($row) {

				$typeData = json_decode($row->type);
				return $typeData->activity;

				// return  $row->type;
			})->addColumn('ops_btns', function ($row) {

				$typeData = json_decode($row->type);
				$table = $typeData->table_name;
				$subject_id = $row->subject_id;
				$logs = json_encode(json_decode($row->desc));
				$user = User::where('id', '=', $row->user_id)->first();
				if ($user && $user != 'SUPER_ADMI') {
					$userInfo = $user->first_name . " " . $user->last_name;
				} else {
					$userInfo = 'N/A';
				}

				return '
					<a title="View Details" class="veiw_details" data-user="' . $userInfo . '" data-id="' . $row->id . '">
						<i class="far fa-search-plus" aria-hidden="true"></i> <span class="sr-only">View Details</span>
					</a>';
			})->rawColumns([
				'date',
				'item',
				'status',
				'type',
				'activity',
				'ops_btns'])
			->order(function ($query) {
				$columns = ['date' => 0, 'item' => 1, 'status' => 2, 'type' => 3, 'activity' => 4];
			})
			->smart(0)->toJson();

	}

	public function getItemStatusData($row, $kind)
	{

		$subject_id = $row->subject_id;
		$model = json_decode($row->type);
		// rid shipments//
		if ($model->table_name == 'rid_shipments') {

			$sql = Rid::Where('rids.id', '!=', '')
				->Leftjoin('rid_master_statuses', 'rid_master_statuses.id', '=', 'rids.status_id')
				->Leftjoin('rid_shipments', 'rid_shipments.rid_id', '=', 'rids.id')
				->where('rid_shipments.id', '=', $subject_id)
				->select([
					'rids.id as id',
					'rids.number as number',
					'rid_master_statuses.name as status'
				])->first();

			if ($kind == 'status') {
				return $sql->status;
			}

			if ($kind == 'item') {
				return
					'<a title="RID Number" href="' . route('eac.portal.rid.show', $sql->id) . '">' .
					$sql->number
					. '</a>';
			}

		}

		// rid visit or rid record//
		if ($model->table_name == 'rid_records') {

			$sql = Rid::Where('rids.id', '!=', '')
				->Leftjoin('rid_master_statuses', 'rid_master_statuses.id', '=', 'rids.status_id')
				->Leftjoin('rid_records', 'rid_records.parent_id', '=', 'rids.id')
				->where('rid_records.id', '=', $subject_id)
				->select([
					'rids.id as id',
					'rids.number as number',
					'rid_master_statuses.name as status'
				])->first();

			if ($kind == 'status') {
				return $sql->status;
			}

			if ($kind == 'item') {
				return
					'<a title="RID Number" href="' . route('eac.portal.rid.show', $sql->id) . '">' .
					$sql->number
					. '</a>';
			}

		}

		// rids //
		if ($model->table_name == 'rids') {

			$sql = Rid::Where('rids.id', '!=', '')
				->Leftjoin('rid_master_statuses', 'rid_master_statuses.id', '=', 'rids.status_id')
				->where('rids.id', '=', $subject_id)
				->select([
					'rids.id as id',
					'rids.number as number',
					'rid_master_statuses.name as status'
				])->first();

			if ($kind == 'status') {
				return $sql->status;
			}

			if ($kind == 'item') {
				return
					'<a title="RID Number" href="' . route('eac.portal.rid.show', $sql->id) . '">' .
					$sql->number
					. '</a>';
			}
		}

		// drugs //
		if ($model->table_name == 'drug') {

			$sql = Drug::where('drug.id', '=', $subject_id)
				->leftJoin('companies', 'companies.id', '=', 'drug.company_id')
				->select([
					'drug.id as id',
					'drug.name as name',
					'drug.company_id as company_id',
					'companies.name as company_name',
					'drug.status as status'
				])->first();

			if ($kind == 'status') {
				return $sql->status;
			}

			if ($kind == 'item') {
				return "<a href=" . route('eac.portal.drug.show', $sql->id) . ">" . $sql->name . "</a>";

			}
		}
		// users
		if ($model->table_name == 'users') {

			$sql = User::where('id', '=', $subject_id)
				->get()->first();

			if ($kind == 'status') {
				return $sql->status;
			}

			if ($kind == 'item') {
				return "<a href=" . route('eac.portal.user.show', $sql->id) . ">" . $sql->full_name . "</a>";
			}
		}
		// supporting panel data
		if ($model->table_name == 'shipping_couriers') {

			$sql = ShippingCourier::where('id', '=', $subject_id)
				->get()->first();

			if ($kind == 'status') {
				// return $sql->active;
				return $sql->active == '1' ? '
                Active
                ' : '
                Inactive
                ';
			}

			if ($kind == 'item') {

				return '<a title="Edit Shipping Courier" href="' . route('eac.portal.settings.manage.rid.shipment.courier.edit', $sql->id) . '">
                 ' . $sql->name . '
                </a>';
			}
		}

		//******************* supporting panel data ***************//
		// shipping courier
		if ($model->table_name == 'shipping_couriers') {

			$sql = ShippingCourier::where('id', '=', $subject_id)
				->get()->first();

			if ($kind == 'status') {
				// return $sql->active;
				return $sql->active == '1' ? '
                Active
                ' : '
                Inactive
                ';
			}

			if ($kind == 'item') {

				return '<a title="Edit Shipping Courier" href="' . route('eac.portal.settings.manage.rid.shipment.courier.edit', $sql->id) . '">
                 ' . $sql->name . '
                </a>';
			}
		}

		// countries
		if ($model->table_name == 'countries') {

			$sql = Country::where('id', '=', $subject_id)
				->get()->first();

			if ($kind == 'status') {
				// return $sql->active;
				return $sql->active == '1' ? '
                Active
                ' : '
                Inactive
                ';
			}

			if ($kind == 'item') {

				return '<a title="Edit Shipping Courier" href="' . route('eac.portal.settings.manage.country.edit', $sql->id) . '">
                 ' . $sql->name . '
                </a>';
			}
		}
		// states
		if ($model->table_name == 'states') {

			$sql = State::where('id', '=', $subject_id)
				->get()->first();

			if ($kind == 'status') {
				// return $sql->active;
				return $sql->active == '1' ? '
                Active
                ' : '
                Inactive
                ';
			}

			if ($kind == 'item') {

				return '<a title="Edit Shipping Courier" href="' . route('eac.portal.settings.manage.states.edit', $sql->id) . '">
                 ' . $sql->name . '
                </a>';
			}
		}

		// ethnicity
		if ($model->table_name == 'ethnicity') {

			$sql = Ethnicity::where('id', '=', $subject_id)
				->get()->first();

			if ($kind == 'status') {
				// return $sql->active;
				return $sql->active == '1' ? '
                Active
                ' : '
                Inactive
                ';
			}

			if ($kind == 'item') {

				return '<a title="Edit Shipping Courier" href="' . route('eac.portal.settings.manage.ethnicity.edit', $sql->id) . '">
                 ' . $sql->name . '
                </a>';
			}
		}
		// drug dosage form
		if ($model->table_name == 'dosage_forms') {

			$sql = \App\DosageForm::where('id', '=', $subject_id)
				->get()->first();

			if ($kind == 'status') {
				// return $sql->active;
				return $sql->active == '1' ? '
                Active
                ' : '
                Inactive
                ';
			}

			if ($kind == 'item') {

				return '<a title="Edit Shipping Courier" href="' . route('eac.portal.settings.manage.drug.dosage.form.edit', $sql->id) . '">
                 ' . $sql->name . '
                </a>';
			}
		}
		// drug Strength manager
		if ($model->table_name == 'dosage_strength') {

			$sql = \App\DosageStrength::where('id', '=', $subject_id)
				->get()->first();

			if ($kind == 'status') {
				// return $sql->active;
				return $sql->active == '1' ? '
                Active
                ' : '
                Inactive
                ';
			}

			if ($kind == 'item') {

				return '<a title="Edit Drug" href="' . route('eac.portal.settings.manage.drug.dosage.strength.edit', $sql->id) . '">
                 ' . $sql->name . '
                </a>';
			}
		}


	}

	public function notificationAllRead($id)
	{
		$user_id = $id;
		$date = date('Y-m-d H:i:s');
		\App\Notification::where('user_id', $user_id)
			->where('read_at', null)
			->update(['read_at' => $date]);
		return redirect()->back();


	}

	public function singleNotification(Request $request)
	{

		$notification_id = $request->notificationid;
		$date = date('Y-m-d H:i:s');
		\App\Notification::where('id', $notification_id)
			->update(['read_at' => $date]);

	}
}
