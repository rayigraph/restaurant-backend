<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SubCategoryController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('SubCategoryModel');
    }

    public function list_sub_categories($category_id) {
        $sub_categories = $this->SubCategoryModel->get_all_sub_categories($category_id);

        if ($sub_categories) {
            $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode(['status' => 'success', 'sub_categories' => $sub_categories]));
        } else {
            $this->output->set_status_header(404)->set_content_type('application/json')->set_output(json_encode(['status' => 'fail', 'message' => 'No sub_categories found']));
        }
    }
}
