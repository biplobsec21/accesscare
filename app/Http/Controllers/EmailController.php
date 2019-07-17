<?php

namespace App\Http\Controllers;

// use App\Mail\GenericEmail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class EmailController extends Controller
{
	public function send()
	{
		$objDemo = new \stdClass();
		$objDemo->demo_one = 'Demo One Value';
		$objDemo->demo_two = 'Demo Two Value';
		$objDemo->sender = 'SenderUserName';
		$objDemo->receiver = 'ReceiverUserName';

		Mail::to("andrew@quasars.com")->send(new GenericEmail($objDemo));
	}
	public function email_test(){

		$data = array(
			'name'=>'User  ',
			"body" => "This is a test  message from the dev system",
			"ml" => "office@quasars.com"
		);
		\Mail::send('mail.test_mail', $data, function($message){
			$message->to('office@quasars.com','Early Access Care')
			->subject('TEST EMAIL');
			$message->from('php@earlyaccesscare.com','Early Access Care');
		});
	}
}