<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Traits\AuthenticatesUsers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;
use App\Rid;
use App\RidVisit;
use Session;
use App\RidShipment;
/**
 * Class LoginController
 * @package App\Http\Controllers\Auth
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class RidTrackController extends Controller
{
	// public function __construct(Request $request){
	 	
	// 	dd($request->session();
	// 	// if(!$request->session())
 //  //       {
 //  //           return redirect()->route('eac.auth.getSignIn');
 //  //       }

	// }

	public function show(Request $request){


		$rid_id =$_POST['rid_id'];
		$password =$_POST['password'];
		// dd($_POST);
		$rid = Rid::where('username',$rid_id)
				->where('password',$password)
				->firstOrFail();
		// dd();
		if($rid){
			$request->session()->put('userName', $rid->username);
			// $request->session()->put('password', $rid->password);
			// return view('ridtrack', ['rid' => $rid]);
			return redirect()->route('eac.auth.ridtrack.details',$rid->id);

		}	
		else{
			return redirect()->route('eac.auth.getSignIn');
		}

	}

	public function logout(Request $request){
		$request->session()->flush();
		return redirect()->route('eac.auth.getSignIn');
	}

	public function ridtrackdetails($id){
		if(session('userName')){
			$rid = Rid::where('id',$id)
				->firstOrFail();
			$visit = RidVisit::where('parent_id', $id)->latest()->first();
			// dd($visit);
			return view('ridtrack', ['rid' => $rid, 'visit' => $visit]);
		}
		else{
			return redirect()->route('eac.auth.getSignIn');
		}
	
	}
}
