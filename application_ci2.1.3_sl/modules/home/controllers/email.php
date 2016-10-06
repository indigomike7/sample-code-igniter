<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email extends MX_Controller {

	public function index()
	{
		$this->load->library('email');

		$this->email->from('admin@studyratings.com', 'Michael');
		$this->email->to('agungshiro@gmail.com'); 

		$this->email->subject('Email Test');
		$this->email->message('Testing the email class.');	

		$this->email->send();

		echo $this->email->print_debugger();
	}

}
