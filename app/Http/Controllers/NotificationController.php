<?php


namespace App\Http\Controllers;

use App\User;
use App\Notification;
use App\Traits\Notifier;

/**
 * Class UserController
 * @package App\Http\Controllers\User
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class NotificationController extends Controller
{

	public function show(string $id)
	{
//		$user = User::where('id', '=', $id)->firstOrFail();
//		return view('portal.user.show', [
//			'user' => $user,
//		]);
	}

	public function create($data)
	{
		$notice = new Notification();
		$notice->id = $this->newID(Notification::class);
		$notice->id = $data->user_id;
		$notice->id = $data->user_id;
	}
}