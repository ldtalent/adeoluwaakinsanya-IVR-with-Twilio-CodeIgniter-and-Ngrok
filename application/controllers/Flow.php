<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Flow extends CI_Controller {

	
	function __construct()
	{
		parent::__construct();
        $this->load->helper('url');		
	}

	/**
	 * Outputs welcome message to webhook using TwiML
	 */
	public function start()
	{
		/*After saying the welcome message and retrieving the caller’s input, Twilio will send the Digits parameter through an HTTP request to the action URL.*/
		header('Content-type: application/xml');
		echo '<?xml version="1.0" encoding="UTF-8"?>
		<Response>
		<Gather action="'.base_url().'index.php/flow/process" numDigits="1">
		<Say>Press one to talk to a sales agent or Press two to hang up now</Say>
		</Gather>
		<Say>We didn\'t receive any input. Goodbye!</Say>
		</Response>';
	}

	/**
	 * Respond to User's Input using TwiML
	 *
	 * @var int $input Should contain an integer
	 */
	public function process()
	{
		header('Content-type: application/xml');
		$input = $_REQUEST["Digits"];
  		if($input == 1){
			//if caller selects one, transfer the call to another number (sales agent). Replace xxxx-xxxx-xxxx with an actual phone number
			echo '<?xml version="1.0" encoding="UTF-8"?>
			<Response>
			<Dial>+2347052481090</Dial>
			</Response>';
		}
		elseif($input == 2){
			//if caller selects two, hangup the call
			echo '<?xml version="1.0" encoding="UTF-8"?>
			<Response>
			<Hangup/>
			</Response>';
		}
		else{
			//if caller selects anything else, redirect to main menu
			echo '<?xml version="1.0" encoding="UTF-8"?>
			<Response>
			<Say>Invalid Input</Say>
			<Redirect method="POST">'.base_url().'index.php/flow/start</Redirect>
			</Response>';
		}
	}
}
?>