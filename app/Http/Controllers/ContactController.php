<?php

namespace App\Http\Controllers;
use Mail;
use Request;
use Validator;


class ContactController extends Controller 
{

	//Server Contact view:: we will create view in next step
	public function getContact()
	{
		return view('contact');
	}

	//Contact Form
	public function getContactUsForm()
	{
		//Get all the data and store it inside Store Variable
		$data = Request::all();

		//Validation rules
		$rules = array (
		'name' => 'required',
		'email' => 'required|email',
		'subject' => 'required',
		'message' => 'required'
		);

		//Validate data
		$validator = Validator::make ($data, $rules);

		//If everything is correct than run passes.
		if ($validator -> passes())
		{

			//Send email to me
			Mail::send('emails.hello', $data, function($message) use ($data)
			{
				//email 'From' field: Get users email add and name
				$message->from($data['email'] , $data['name']);
				//email 'To' field: 
				$message->to('robert.smith@ebob.uk', 'Robert Smith')->subject($data['subject']);

			});

			//Send notification email to sender
			Mail::send('emails.notify', $data, function($message) use ($data)
			{
				//email 'From' field: Get users email add and name
				$message->from('robert.smith@ebob.uk' , 'Robert Smith');
				//email 'To' field: cahnge this to emails that you want to be notified.
				$message->to($data['email'], $data['name'])->subject('Thank you for contacting me');

			});

			return view('thankyou');
		}
		else
		{
			//return contact form with errors
			return view('contact')->with(array(
				'messages' => $validator->messages(),
				'old_input' => $data));
		}
	}
}
