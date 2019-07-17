<?php

namespace App\Http\Controllers\Auth;

/**
 * Class EmulationController
 * @package App\Http\Controllers\Auth
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class EmulationController
{
	public function init($id)
	{
		$emuData = [];
		$isEmulating = false;
		if (session()->get('is_emulating')) {
			$isEmulating = true;
			$emuData = session()->get('emu_data');
		}

		$currentUser = \Auth::user();

		\Auth::logout();
		\Auth::loginUsingId($id);


		if (!$isEmulating) {
			$emuData = [
				'origin' => [
					'id' => $currentUser->id,
					'full_name' => $currentUser->full_name,
					'first_name' => $currentUser->first_name,
					'last_name' => $currentUser->last_name,
					'email' => $currentUser->email,
				],
				'history' => [
					0 => $currentUser->id,
				]
			];
		} else {
			$emuData['history'][count($emuData['history'])] = $currentUser->id;
		}

		session([
			'is_emulating' => true,
			'emu_data' => $emuData,
		]);

		return redirect()->route('eac.portal.getDashboard');
	}

	public function stop()
	{
		if (!session()->get('is_emulating')) return redirect()->route('eac.auth.logout');

		$emuData = session('emu_data');
		$newUser = array_pop($emuData['history']);

		\Auth::logout();
		\Auth::loginUsingId($newUser);

		if ($newUser == $emuData['origin']['id']) {
			session([
				'is_emulating' => false,
				'emu_data' => null,
			]);
			return redirect()->route('eac.portal.getDashboard');
		}

		session([
			'is_emulating' => true,
			'emu_data' => $emuData,
		]);

		return redirect()->route('eac.portal.getDashboard');
	}

	/**
	 * Sign in as original user
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function stopAll()
	{
		if (!session()->get('is_emulating')) return redirect()->route('eac.auth.logout');
		\Auth::logout();
		\Auth::loginUsingId(session(['emu_data.history'])[0]);
	}
}
