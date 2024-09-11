<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('UserModel');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function index() {
        $users = $this->UserModel->get_all_users();
        echo json_encode($users);
    }

    public function show($id) {
        $user = $this->UserModel->get_user($id);
        if ($user) {
            echo json_encode($user);
        } else {
            echo json_encode(['message' => 'User not found']);
        }
    }

    public function store() {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['error' => validation_errors()]);
        } else {
            $data = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email')
            ];
            $this->UserModel->insert_user($data);
            $this->output->set_status_header(404)->set_content_type('application/json')->set_output(json_encode(['status' => 'fail', 'message' => 'User created']));        
        }
    }

    public function update($id) {
        parse_str(file_get_contents("php://input"), $put_vars);

        $this->form_validation->set_data($put_vars);
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $response = ['error' => validation_errors()];
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
        } else {
            $data = [
                'name' => $put_vars['name'],
                'email' => $put_vars['email']
            ];
            $this->UserModel->update_user($id, $data);
            $this->output->set_status_header(404)->set_content_type('application/json')->set_output(json_encode(['status' => 'fail', 'message' => 'User updated']));
        }
    }

    public function delete($id) {
        $this->UserModel->delete_user($id);
        $this->output->set_status_header(404)->set_content_type('application/json')->set_output(json_encode(['status' => 'fail', 'message' => 'User deleted']));
    }
    public function signUp() {
        // Set validation rules
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[tb_users.email]');
        $this->form_validation->set_rules('phone', 'Phone', 'required|is_unique[tb_users.phone]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        
        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'status' => "failed",
                'message' => $this->form_validation->error_array()
            );
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
            return;
        }
        $uid = strtotime("now");
        // Insert user into the database
        $data = array(
            'uid' => $uid,
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
            'photo' => $this->_uploadPhoto()
        );

        $insert_id = $this->UserModel->insertUser($data);

        if ($insert_id) {
            // Send verification email (Implementation of email sending is required)
            // $this->_sendVerificationEmail($insert_id);

            $response = array(
                'status' => "success",
                'uid' => $uid,
                // 'message' => 'Verification message sent'
                'message' => 'Sign up successful'
            );
        } else {
            $response = array(
                'status' => "failed",
                'message' => 'Failed to create user'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    private function _uploadPhoto() {
        if (!empty($_FILES['photo']['name'])) {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('photo')) {
                return $this->upload->data('file_name');
            }
        }
        return null;
    }

    private function _sendVerificationEmail($user_id) {
        // Email sending logic here
        // e.g., Use CI's email library to send an OTP or verification link
    }
    public function login() {
        $this->form_validation->set_rules('email_or_phone', 'Email or Phone', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'status' => "failed",
                'message' => $this->form_validation->error_array()
            );
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
            return;
        }
    
        $email_or_phone = $this->input->post('email_or_phone');
        $password = $this->input->post('password');
    
        $user = $this->UserModel->getUserByEmailOrPhone($email_or_phone);
    
        if ($user && password_verify($password, $user['password'])) {
            // Generate Auth Token
            $auth_token = $this->_generateToken($user['id']);
            $auth_token = generate_jwt($user);
    
            $response = array(
                'status' => "success",
                'message' => 'Login successful',
                'auth_token' => $auth_token
            );
        } else {
            $response = array(
                'status' => "failed",
                'message' => 'Invalid email/phone or password'
            );
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    
    private function _generateToken($user_id) {
        // Create a simple token for demo (Consider using JWT in production)
        $token = bin2hex(random_bytes(16)) . $user_id;
        $this->UserModel->saveToken($user_id, $token);
        return $token;
    }
    public function verifyEmail() {
        $this->form_validation->set_rules('unique_id', 'Unique ID', 'required');
        $this->form_validation->set_rules('otp', 'OTP', 'required');
    
        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'status' => "failed",
                'message' => validation_errors()
            );
            
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
            return;
        }
    
        $unique_id = $this->input->post('unique_id');
        $otp = $this->input->post('otp');
    
        $verification = $this->UserModel->verifyOTP($unique_id, $otp);
    
        if ($verification) {
            $response = array(
                'status' => "success",
                'message' => 'Email verified successfully'
            );
        } else {
            $response = array(
                'status' => "failed",
                'message' => 'Invalid OTP or Unique ID'
            );
        }
    
        
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
    
    
}
