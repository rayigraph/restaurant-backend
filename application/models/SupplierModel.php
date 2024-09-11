<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SupplierModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_suppliers() {
        $this->db->select('uid,supplier_name, CONCAT("'.base_url().SUPPLIER_PATH.'", supplier_image) as supplier_image');
        $this->db->from('tb_suppliers');
        $this->db->where('is_deleted', 'N');
        $this->db->where('availability', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
}
