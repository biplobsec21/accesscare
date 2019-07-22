<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserApproved
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (Auth::user()->status == 'Pending') {
			return redirect()->route('eac.portal.user.wait');
		}
		if (Auth::user()->status == 'Registering') {
			if($request->route()->getActionMethod() == 'sendCertification')
				return $next($request);
			return redirect()->route('eac.portal.user.certify');
		}
		if (Auth::user()->status == 'Suspended') {
			return redirect()->route('eac.portal.user.hold');
		}

		return $next($request);
	}
}
