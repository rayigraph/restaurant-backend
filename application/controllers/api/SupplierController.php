<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SupplierController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('SupplierModel');
    }

    public function list_suppliers() {
        $suppliers = $this->SupplierModel->get_all_suppliers();

        if ($suppliers) {
            $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode(['status' => 'success', 'suppliers' => $suppliers]));
        } else {
            $this->output->set_status_header(404)->set_content_type('application/json')->set_output(json_encode(['status' => 'fail', 'message' => 'No suppliers found']));
        }
    }
}
