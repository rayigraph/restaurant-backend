<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SubCategoryModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_sub_categories($category_id) {
        $this->db->where("uid",$category_id);
        $this->db->where('is_deleted', 'N');
        $cat_det = $this->db->get(CATEGORY_TABLE)->row();
        if(!$cat_det)
            return null;
        $cat_id = $cat_det->id;
        $this->db->select('uid,sub_category_name,, CONCAT("'.base_url().SUB_CATEGORY_PATH.'", sub_category_image) as sub_category_image');
        $this->db->from(SUB_CATEGORY_TABLE);
        $this->db->where('is_deleted', 'N');
        $this->db->where('category_id', $cat_id);
        $this->db->where(SUB_CATEGORY_TABLE.'.availability', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
}
