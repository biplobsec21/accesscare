<?php

namespace App\Http\Controllers\Settings\Manage\Mail;

use App\Email;
use App\EmailToken;
use App\Http\Controllers\Controller;

/**
 * Class CountryController
 * @package App\Http\Controllers\Settings\Manage\Country
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class RegistrationMailController extends Controller
{
	/**
	 * CountryController constructor.
	 */
	public function __construct()
	{
		$this->middleware("auth");
	}

	public function index()
	{
		$templates = Email::where('type', 'Registration');
		$tokens = EmailToken::all();

		return view('portal.settings.manage.emails.registration-mail', ['templates' => $templates, 'tokens' => $tokens]);
	}

	public function ajaxUpdate()
	{
		$id = $_POST['id'];
		$field = $_POST['field'];
		$val = $_POST['val'];

		try {
			$country = Email::where('id', "=", $id)->firstOrFail();
			$country->$field = $val;
			$country->saveOrFail();

		} catch (\Exception $e) {
			throw $e;
		}

		return [
			"result" => "Success",
			"id" => $_POST['id'],
			"field" => $_POST['field'],
			"val" => $_POST['val']
		];
	}
}
