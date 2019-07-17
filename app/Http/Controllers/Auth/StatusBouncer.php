<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Class StatusBouncer
 * @package App\Http\Controllers\Auth
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class StatusBouncer extends Controller
{

	public function pendingScreen()
	{
		return view('auth.bouncer.wait');
	}
	public function registeringScreen()
	{
		return view('auth.bouncer.certify');
	}
	public function suspendedScreen()
	{
		return view('auth.bouncer.hold');
	}
}
