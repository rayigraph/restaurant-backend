<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_all_users() {
        $query = $this->db->get(USER_TABLE);
        return $query->result_array();
    }

    public function get_user($id) {
        $query = $this->db->get_where(USER_TABLE, ['id' => $id]);
        return $query->row_array();
    }

    public function insertUser($data) {
        $this->db->insert(USER_TABLE, $data);
        return $this->db->insert_id();
    }

    public function getUserById($id) {
        return $this->db->get_where(USER_TABLE, array('id' => $id))->row_array();
    }
    public function getUserByEmailOrPhone($email_or_phone) {
        $this->db->where('email', $email_or_phone);
        $this->db->or_where('phone', $email_or_phone);
        return $this->db->get(USER_TABLE)->row_array();
    }
    public function getAdminUser($email_or_phone) {
        $this->db->where('email', $email_or_phone);
        return $this->db->get(USER_TABLE)->row_array();
    }
    
    public function saveToken($user_id, $token) {
        $data = array('auth_token' => $token);
        $this->db->where('id', $user_id);
        $this->db->update(USER_TABLE, $data);
    }
    
    public function update_user($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update(USER_TABLE, $data);
    }

    public function delete_user($id) {
        $this->db->where('id', $id);
        return $this->db->delete(USER_TABLE);
    }
    public function verifyOTP($user_id, $otp) {
        // Assuming you store OTP in your users table (You might need to modify this based on your OTP storage logic)
        $this->db->where('id', $user_id);
        $this->db->where('otp', $otp); // Assuming `otp` column exists
        $this->db->update(USER_TABLE, array('is_verified' => 1));
        
        return $this->db->affected_rows() > 0;
    }
    
}
