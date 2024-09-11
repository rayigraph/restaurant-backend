<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
		$this->load->library('session');
		$this->load->helper('security');
        $this->load->model('UserModel');
    }
	public function index()
	{
		if(!$this->session->userdata("username"))
		{
			redirect('login');
		}
		$current_user=$this->session->userdata();
	    $user=$current_user['user_id'];
		$data['user']=$current_user;
		$this->load->view("nav",$data);
		$this->load->view('dashboard');
		$this->load->view("footer");
	}
}
