<?php

namespace App\Http\Controllers\Company;

use App\Company;
use App\Address;
use App\Department;
use App\Phone;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class CompanyController
 * @package App\Http\Controllers\Company
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class DepartmentController extends Controller
{

	public function store()
	{
		$department = new Department();
		$phone = new Phone();

		$department->id = $this->newID(Department::class);
		$department->name = $_POST['name'];
		$department->company_id = $_POST['company_id'];
		$department->email = ($_POST['email']) ? $_POST['email'] : null;

		if ($_POST['phone']) {
			$phone->id = $this->newID(Phone::class);
			$phone->country_id = 0;
			$phone->number = $_POST['phone'];
			$phone->save();
			$department->phone_id = $phone->id;
		}


		$department->save();
		return redirect()->route('eac.portal.company.edit', $_POST['company_id']);
	}
	 public function update(Request $request){
		// dd($request);
		$department = new Department();
		$department = Department::where('id', $request->department_id)->first();
		$phone = Phone::where('id', $request->phone_id)->first();

		$department->name = $_POST['name'];
		$department->email = ($_POST['email']) ? $_POST['email'] : null;

		if ($_POST['phone']) {
			$phone->country_id = 0;
			$phone->number = $_POST['phone'];
			$phone->save();
			$department->phone_id = $phone->id;
		}


		$department->save();
		return redirect()->route('eac.portal.company.edit', $_POST['company_id']);
    }

    public function delete(Request $request) {
        $id = $request->id;
        $resourceData = Department::find($id);
        if ($resourceData):
            if ($resourceData->delete()):
                return [
                    'result' => 'success'
                ];
            endif;
        endif;
    }
}
