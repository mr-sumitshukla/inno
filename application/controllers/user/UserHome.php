<?php

class UserHome extends CI_Controller
{
	public function index()
	{
		$this->load->view('user/home');
	}
}
