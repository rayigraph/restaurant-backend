<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ItemsController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ItemsModel');
    }

    public function list_items($sub_category_id) {
        $items = $this->ItemsModel->get_all_items($sub_category_id);

        if ($items) {
            $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode(['status' => 'success', 'items' => $items]));
        } else {
            $this->output->set_status_header(404)->set_content_type('application/json')->set_output(json_encode(['status' => 'fail', 'message' => 'No items found']));
        }
    }
}
