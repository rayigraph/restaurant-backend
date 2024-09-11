<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ItemsModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_items($sub_category) {
        $this->db->where("uid",$sub_category);
        $this->db->where('is_deleted', 'N');
        $sub_cat_det = $this->db->get(SUB_CATEGORY_TABLE)->row();
        if(!$sub_cat_det)
            return null;
        $sub_cat_id = $sub_cat_det->id;
        $this->db->select('uid, item_name, unit_price, supplier_id, CONCAT("'.base_url().ITEM_PATH.'", item_image) as item_image');
        $this->db->from(ITEMS_TABLE);
        $this->db->where('is_deleted', 'N');
        $this->db->where('availability', 1);
        $this->db->where('sub_category_id', $sub_cat_id);
        $query = $this->db->get();
        return $query->result_array();
    }
}
