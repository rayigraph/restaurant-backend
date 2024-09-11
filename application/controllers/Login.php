<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Kolkata');
class Login extends CI_Controller {

	
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
		$data['message']="";
		if($this->input->post())
		{
		    $post = $this->input->post();
		    if($post != $this->security->xss_clean($post, TRUE)){
		        print_r("something went wrong");die;
		    }
			$username=$this->input->post("username");
			$password=$this->input->post("password");
			    
			$user = $this->UserModel->getAdminUser($username);
    
			if ($user && password_verify($password, $user['password'])) {
				// Generate Auth Token
				$auth_token = $this->_generateToken($user['id']);
				$userdata = array(
					'username'  => $user['name'],
					'email'     => $user['email'],
					'role'     => $user['role'],
					'user_id'     => $user['id'],
					'logged_in' => TRUE
				);
				$this->session->set_userdata($userdata);
				redirect(base_url());
			}
			else
			{
				$data['message']="Invalid Login";
				$this->load->view('login',$data);
			}
		}else{
		    $this->load->view('login',$data);
		}
	}
    private function _generateToken($user_id) {
        // Create a simple token for demo (Consider using JWT in production)
        $token = bin2hex(random_bytes(16)) . $user_id;
        $this->UserModel->saveToken($user_id, $token);
        return $token;
    }
	function logout()
	{
        $this->session->sess_destroy();
		redirect(base_url());
	}
}
