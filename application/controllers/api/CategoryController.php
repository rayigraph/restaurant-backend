<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CategoryController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('CategoryModel');
    }

    public function list_categories($supplier_id) {
        $categories = $this->CategoryModel->get_all_categories($supplier_id);

        if ($categories) {
            $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode(['status' => 'success', 'categories' => $categories]));
        } else {
            $this->output->set_status_header(404)->set_content_type('application/json')->set_output(json_encode(['status' => 'fail', 'message' => 'No categories found']));
        }
    }
}
