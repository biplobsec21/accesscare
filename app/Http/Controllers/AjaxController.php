<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

/**
 * Class AjaxController
 * @package App\Http\Controllers\Note
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class AjaxController extends Controller
{
	public function index()
	{
		$args = $_GET;
		return view($args['view'])
			->with('id', $args['id'])
			->render();
	}
}
