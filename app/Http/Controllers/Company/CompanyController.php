<?php

namespace App\Http\Controllers\Company;

use App\Address;
use App\Company;
use App\Country;
use App\DataTables\DataTableResponse;
use App\DataTables\DataTableRow;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CreateRequest;
use App\Http\Requests\Company\UpdateRequest;
use App\Phone;
use App\RidVisit;
use App\Traits\AuthAssist;
use App\User;
use Illuminate\Http\Request;

/**
 * Class CompanyController
 * @package App\Http\Controllers\Company
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class CompanyController extends Controller
{
    use AuthAssist;

	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('user.approved');

	}

	public function listCompanies()
	{
		return view('portal.company.list');
	}

	public function create()
	{
		$countries = $this->getCountry(); //\App\Country::all()->sortBy('name');
		$state = \App\State::all()->sortBy('name');
		return view('portal.company.create', [
			'countries' => $countries,
			'state' => $state,
		]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$company = Company::where('id', $id)->first();
		return view('portal.company.show', [
			'company' => $company,
		]);
	}

	/**
	 * Edit the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$company = Company::where('id', $id)->first();
		$countries = $this->getCountry();
		$state = \App\State::all()->sortBy('name');
		// dd($countries);
		return view('portal.company.edit', [
			'company' => $company,
			'countries' => $countries,
			'state' => $state,
		]);
	}

	/**
	 * Remove user from company
	 *
	 * @param  string $company_id
	 * @param  string $user_id
	 * @return \Illuminate\Http\Response
	 */
	public function assignUser($company_id, $user_id)
	{
		$user = User::where('id', $user_id)->first();
		$user->company_id = $company_id;
		$user->save();
		return redirect()->back()->with('confirm', 'User was added to company');
	}
	public function PostassignUser(Request $request)
	{
		$select_user = $request->select_users;
		// dd($select_user);
		$company_id = $request->company_id;

		if(count($select_user) > 0){
			foreach($select_user as $val){
				$user = User::where('id', $val)->first();
				$user->company_id = $company_id;
				$user->save();
			}

		}


		return redirect()->back()->with('confirm', 'User was added to company');
	}

	/**
	 * Remove user from company
	 *
	 * @param  string $company_id
	 * @param  string $user_id
	 * @return \Illuminate\Http\Response
	 */
	public function removeUser($company_id, $user_id)
	{
		$user = User::where('id', $user_id)->first();
		if ($company_id !== $user->company_id) {
			return redirect()->back()->with('error', 'Failed to remove user from company: user is not associated with this company.');
		} else {
			$user->company_id = 0;
			$user->save();
			return redirect()->back()->with('confirm', 'User was removed from company');
		}
	}

	public function postCreate(CreateRequest $request)
	{
		$company = new Company();
		$address = new Address();
		$phone = new Phone();
		$company->id = $this->newID(Company::class);
		$company->country_id = $request->input('country');
		$company->email_main = $request->input('email');
		$company->name = $request->input('name');
		$company->abbr = $request->input('abbr');
		$company->site = is_null($request->input('website')) ? 0 : $request->input('website');


		/*
		 * Fill phone data
		 */

		if ($request->input('phone')) {
			$phone->id = $this->newID(Phone::class);
			$phone->country_id = $request->input('country');
			// $phone->company_id = $company->id;
			$phone->number = $request->input('phone');
			$phone->is_primary = true;
			$phone->save();
			$company->phone_main = $phone->id;
		}

		/*
		 * Fill Address data
		 */
		$company->address_id = $address->id = $this->newID(Address::class);
		$address->addr1 = $request->input('addr1');
		$address->addr2 = $request->input('addr2');
		$address->city = $request->input('city');
		$address->state_province = $request->input('company_state');
		$address->country_id = $request->input('country');
		$address->zipcode = $request->input('zipcode');
		$address->save();

		$company->save();
		return redirect()->route('eac.portal.company.show', $company->id)->with("alert", ['type' => 'success', 'msg' => ' Company named<i>'. $request->input('name').'</i> added successfully']);
	}

	public function ajaxCompanyData()
	{
	    $companies = $this->listCompanyAccess();
        $response = new DataTableResponse(Company::class, $companies);
        foreach ($companies as $company) {
            $row = new DataTableRow($company->id);
            $row->setColumn('name', $company->name,
                '<a href="' . route('eac.portal.company.show', $company->id) . '">' .
                $company->name .
                '</a>'
            );
            $row->setColumn('status', $company->status,
                $company->status
            );
            $row->setColumn('drug_count', $company->drugs->count(),
                '<a href="' . route('eac.portal.company.show', $company->id) . '#xdrugs" class="badge badge-mw badge-outline-warning"> ' . $company->drugs->count() . '</a>'
            );
            $row->setColumn('user_count', $company->users->count(),
                '<a href="' . route('eac.portal.company.show', $company->id) . '#xusers" class="badge badge-mw badge-outline-info"> ' . $company->users->count() . '</a>'
            );
            $row->setColumn('rid_count', $company->rids->count(),
                '<a href="' . route('eac.portal.company.show', $company->id) . '#xrequests" class="badge badge-mw badge-outline-primary"> ' . $company->rids->count() . '</a>'
            );
            $row->setColumn('created_at', strtotime($company->created_at),
                '<span style="display: none">' . $company->created_at->format('Y-m-d') . '</span>' . $company->created_at->format(config('eac.date_format'))
            );
            $row->setColumn('btns', $company->id,
                '<div class="btn-group dropleft" role="group">' .
                '<a class="btn btn-link" href="#" id="dropdownMenuButton' . $company->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' .
                '<span class="far fa-fw fa-ellipsis-v"></span> <span class="sr-only">Actions</span>' .
                '</a>' .
                '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $company->id . '">' .
                '<a class="dropdown-item" title="Edit Company" href="' . route('eac.portal.company.edit', $company->id) . '">' .
                '<i class="fal fa-fw fa-edit"></i> Edit Company' .
                '</a>' .
                '<a class="dropdown-item" title="View Company" href="' . route('eac.portal.company.show', $company->id) . '">' .
                '<i class="fal fa-fw fa-search-plus"></i> View Company' .
                '</a>' .
                '</div>' .
                '</div>'
            );
            $response->addRow($row);
        }
        return $response->toJSON();
	}


	public function ajaxUserList($id)
	{

		$users = Company::Where('companies.id', '=', $id)
			->Leftjoin('users', 'users.company_id', '=', 'companies.id')
			->select([
				'users.id as id',
				'users.status as status',
				'users.first_name as first_name',
				'users.last_name as last_name',
				'users.email  as email',
				'users.created_at as created_at']);

		return \DataTables::of($users)
			->addColumn('name', function ($row) {
				return '<a href="' . route('eac.portal.user.show', $row->id ? $row->id : '') . '">' . $row->first_name . " " . $row->last_name . '</a>';
			})
			->addColumn('email', function ($row) {
				return '<span>' . $row->email . '</span>';
			})
			->addColumn('status', function ($row) {
				return '<span class="badge badge-' . config('eac.user.status')[$row->status] . '">' . $row->status . '</span>';
			})
			// ->addColumn('created_at', function ($row) {
			// 	return $row->created_at->toDateString();
			// })
			->addColumn('ops_btns', function ($row) {
				return '
    <a title="Edit User" href="' . route('eac.portal.user.edit', $row->id ? $row->id : '') . '">
     <i class="far fa-edit" aria-hidden="true"></i> <span class="sr-only">Edit User</span>
    </a>
    <a title="View User" href="' . route('eac.portal.user.show', $row->id ? $row->id : '') . '">
     <i class="far fa-search-plus" aria-hidden="true"></i> <span class="sr-only">View User</span>
    </a>
    ';
			})
			->rawColumns([
				'name',
				'email',
				'status',
				'ops_btns',
			])
			->filterColumn('name', function ($query, $keyword) {
				$query->where('users.first_name', 'like', "%" . $keyword . "%");
			})->filterColumn('email', function ($query, $keyword) {
				$query->where('users.email', 'like', "%" . $keyword . "%");
			})
			->order(function ($query) {
				$columns = ['name' => 0, 'email' => 1, 'status' => 2];

				$direction = request('order.0.dir');
				if (request('order.0.column') == $columns['name']) {
					$query->orderBy('users.first_name', $direction);
				}

				if (request('order.0.column') == $columns['email']) {
					$query->orderBy('users.email', $direction);
				}
			})
			->smart(0)->toJson();
	}

	public function ajaxAssociatedRids($id)
	{
		$company = Company::where('id', '=', $id)->firstOrFail();

		return \DataTables::collection($company->rids)
			//return \DataTables::of(Rid::query()->with('physician', 'drug'))
			->addColumn('number', function ($row) {
				return "<a href=" . route('eac.portal.rid.show', $row->id) . ">" . $row->number . "</a>";
			})
			->addColumn('status', function ($row) {
				return "<span class='badge badge-" . config('eac.rid.status')[$row->status] . "'>" . $row->status->name . "</span>";
			})
			// ->addColumn('physician_name', function ($row) {
			// 	return "<a href=" . route('eac.portal.user.show', $row->physician->id) . ">" . $row->physician->full_name . "</a>";
			// })
			// ->addColumn('physician_name', function ($row) {
			// 	$ridVisitDetail = RidVisit::where('parent_id', $row->id)->first();
			// 	return "<a href=" . route('eac.portal.user.show', $ridVisitDetail->physician->id) . ">" . $ridVisitDetail->physician->full_name . "</a>";
			// })
			->addColumn('drug_name', function ($row) {
				return '<a href="' . route('eac.portal.drug.show', $row->drug ? $row->drug->id : '') . '">' . $row->drug->name . '</a>';
			})
			->addColumn('rid_shipment_status', function ($row) {
				return '! SHIP STATUS !';
			})
			->addColumn('created_at', function ($row) {
				return $row->created_at->toDateString();
			})
			->addColumn('ops_btns', function ($row) {
				return '
    <a title="Edit RID" href="' . route('eac.portal.rid.edit', $row->id) . '">
     <i class="far fa-edit" aria-hidden="true"></i> <span class="sr-only">Edit RID</span>
    </a>
    <a title="View RID" href="' . route('eac.portal.rid.show', $row->id) . '">
     <i class="far fa-search-plus" aria-hidden="true"></i> <span class="sr-only">View RID</span>
    </a>
    ';
			})
			->rawColumns([
				'number',
				'status',
				'physician_name',
				'drug_name',
				'ops_btns',
			])
			/*->filterColumn('physician.fullname', function ($query, $keyword) {
			 $query->whereHas('users', function ($query) use ($keyword) {
				$query->whereRaw("CONCAT(first_name,' ',last_name) like ?", ["%{$keyword}%"]);
			 });
			})
			->filterColumn('drug.fullname', function ($query, $keyword) {
			 $query->whereHas('drug', function ($query) use ($keyword) {
				$keyword = str_replace('(', ' ', $keyword);
				$keyword = str_replace(')', ' ', $keyword);
				$query->whereRaw("CONCAT(name,' ',lab_name) like ?", ["%{$keyword}%"]);
			 });
			})
			->filterColumn('number', function ($query, $keyword) {
			 $query->where('number', 'like', "%" . $keyword . "%");
			})
			->filterColumn('created_at', function ($query, $keyword) {
			 $query->where('created_at', 'like', "%" . $keyword . "%");
			})*/
			->smart(0)
			->toJson();
	}

	public function ajaxDrugList($id)
	{
		$company = Company::where('id', '=', $id)->firstOrFail();

		return \DataTables::collection($company->drugs)
			//return \DataTables::of(Rid::query()->with('physician', 'drug'))
			->addColumn('name', function ($row) {
				return "<a href=" . route('eac.portal.drug.show', $row->id) . ">" . $row->name . "</a>";
			})
			->addColumn('company_name', function ($row) {
				return "<a href=" . route('eac.portal.company.show', $row->company->id) . ">" . $row->company->name . "</a>";
			})
			->addColumn('status', function ($row) {
				return '<span class="badge badge-' . config('eac.drug.status')[$row->status] . '"> ' . $row->status . ' </span>';
			})
			->addColumn('created_at', function ($row) {
				return $row->created_at->toDateString();
			})
			->addColumn('ops_btns', function ($row) {
				return '
    <a title="Edit Drug" href="' . route('eac.portal.drug.edit', $row->id) . '">
     <i class="far fa-edit" aria-hidden="true"></i> <span class="sr-only">Edit Drug</span>
    </a>
    <a title="View Drug" href="' . route('eac.portal.drug.show', $row->id) . '">
     <i class="far fa-search-plus" aria-hidden="true"></i> <span class="sr-only">View Drug</span>
    </a>
    ';
			})
			->rawColumns([
				'name',
				'company_name',
				'status',
				'ops_btns'
			])
			/*->filterColumn('physician.fullname', function ($query, $keyword) {
			 $query->whereHas('users', function ($query) use ($keyword) {
				$query->whereRaw("CONCAT(first_name,' ',last_name) like ?", ["%{$keyword}%"]);
			 });
			})
			->filterColumn('drug.fullname', function ($query, $keyword) {
			 $query->whereHas('drug', function ($query) use ($keyword) {
				$keyword = str_replace('(', ' ', $keyword);
				$keyword = str_replace(')', ' ', $keyword);
				$query->whereRaw("CONCAT(name,' ',lab_name) like ?", ["%{$keyword}%"]);
			 });
			})
			->filterColumn('number', function ($query, $keyword) {
			 $query->where('number', 'like', "%" . $keyword . "%");
			})
			->filterColumn('created_at', function ($query, $keyword) {
			 $query->where('created_at', 'like', "%" . $keyword . "%");
			})*/
			->smart(0)
			->toJson();
	}

	public function updatestore(UpdateRequest $request)
	{
		// dd($request->company_id);
		// dd($request);
		$company = \App\Company::where('id', $request->company_id)->first();
		$address = \App\Address::where('id', $request->address_id)->first();
		$phone = \App\Phone::where('country_id', $request->company_id)->first();

		// $address = new Address();
		// $phone = new Phone();

		$company->country_id = $request->input('country');
		$company->name = $request->input('name');
		$company->abbr = $request->input('abbr');
		$company->site = is_null($request->input('website')) ? 0 : $request->input('website');


		/*
		 * Fill phone data
		 */
		if ($request->input('phone')) {
			$phone->country_id = $request->input('country');
			// $phone->company_id = $company->id;
			$phone->number = $request->input('phone');
			$phone->is_primary = true;
			$phone->save();
			$company->phone_main = $phone->id;
		}

		/*
		 * Fill Address data
		 */
		if ($address) {

			$address->addr1 = $request->input('addr1');
			$address->addr2 = $request->input('addr2');
			$address->city = $request->input('city');
			$address->state_province = $request->input('company_state');
			$address->country_id = $request->input('country');
			$address->zipcode = $request->input('zipcode');
			$address->save();
		}


		$company->save();
		return redirect()->back()->with("alert", ['type' => 'success', 'msg' => ' Company details information updated  successfully']);

	}

	public function deptupdate(Request $request)
	{
		// dd($request);
		$company = Company::where('id', $request->company_id)->first();
		$phone = Phone::where('country_id', $request->country_id)->first();


		if ($request->input('phone')) {
			// $phone->id = $this->newID(Phone::class);
			$phone->country_id = $request->input('country_id');
			// $phone->company_id = $company->id;
			$phone->number = $request->input('phone');
			$phone->is_primary = true;
			$phone->save();
			$company->phone_main = $phone->id;
		}
		$company->email_main = ($_POST['email']) ? $_POST['email'] : null;

		$company->save();
		return redirect()->back();
	}

	public function suspend($id)
	{
		$company_id = $id;
		$company = Company::where('id', $company_id)->first();
		$company->status = "Not Approved";
		$company->save();
		return redirect()->back()->with("alert", ['type' => 'success', 'msg' => 'Suspend successfully']);
	}

	public function reactivate($id)
	{
		$company_id = $id;
		$company = Company::where('id', $company_id)->first();
		$company->status = "Approved";
		$company->save();
		return redirect()->back()->with("alert", ['type' => 'success', 'msg' => 'Reactivate successfully']);
	}

	public function approve($id)
	{
		$company_id = $id;
		$company = Company::where('id', $company_id)->first();
		$company->status = "Approved";
		$company->save();
		return redirect()->back()->with("alert", ['type' => 'success', 'msg' => 'Approval successfully']);
	}

	public function updatedesc(Request $request){
		$company_id = $request->input('company_id');
		$company = Company::where('id', $company_id)->first();
		$company->desc = $request->input('desc');
		$company->save();
		return redirect()->back()->with("alert", ['type' => 'success', 'msg' => 'Description updated successfully']);
	}
}
