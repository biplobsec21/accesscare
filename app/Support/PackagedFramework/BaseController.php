<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as Controller;
use App\DataTables\DataTableResponse;

class BaseController extends Controller
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	/**
	 * Send Client to $route with any number of messages
	 * @param string $route - The route to send the client to, if null will send them back.
	 * @param array $messages (variadic) Messages to flash to session in the format of ['type', 'message'].
	 * @return RedirectResponse
	 */
	protected function clientRedirect($route, ...$messages)
	{
		if($messages)
			session()->flash('messages', $messages);

		if($route != null)
			return redirect()->route($route);
		else
			return redirect()->back();
	}
}
