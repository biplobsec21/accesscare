<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;

/**
 * Class SettingsController
 * @package App\Http\Controllers\Settings
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class SettingsController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('user.approved');
	}
	/**
	 * Show the settings page
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		return view('portal.settings.settings');
	}
}
