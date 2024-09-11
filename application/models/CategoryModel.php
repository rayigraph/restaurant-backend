<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CategoryModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_categories($supplier_id) {
        $this->db->where("uid",$supplier_id);
        $this->db->where('is_deleted', 'N');
        $sup_det = $this->db->get(SUPPLIER_TABLE)->row();
        if(!$sup_det)
            return null;
        $sup_id = $sup_det->id;
        $this->db->select('uid,category_name,, CONCAT("'.base_url().CATEGORY_PATH.'", category_image) as category_image');
        $this->db->from(CATEGORY_TABLE);
        $this->db->where('is_deleted', 'N');
        $this->db->where('supplier_id', $sup_id);
        $this->db->where(CATEGORY_TABLE.'.availability', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
}
