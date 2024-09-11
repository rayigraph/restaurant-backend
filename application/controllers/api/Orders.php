<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('UserModel');
        $this->load->model('OrderModel');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->load->helper('jwt');

        $token = $this->input->get_request_header('Authorization');
        $decodedToken = verify_jwt($token);

        if (!$decodedToken) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['error' => 'Unauthorized']))
                ->_display();
            exit;
        }

        // Token is valid, you can access the user data
        $this->user_data = $decodedToken;
    }
    public function createOrder() {
        $user_data = $this->user_data;
        $table_id = $this->input->post('table_id');
        $total_price = $this->input->post('total_price');
        $shipping_address = $this->input->post('shipping_address');
        $billing_address = $this->input->post('billing_address');
        $payment_method = $this->input->post('payment_method');
        $created_by = $this->input->post('created_by');
        $order_items = $this->input->post('order_items'); // Assuming order_items is sent as JSON string

        // Validate the input
        if (empty($table_id) || empty($order_items)) {
            $this->output->set_status_header(400)->set_content_type('application/json')->set_output(json_encode(['status' => 'fail', 'message' => 'Invalid input data']));
            return;
        }

        // Convert order_items to an array
        $order_items = json_decode($order_items, true);

        $uid = strtotime("now");
        // Extract order details
        $orderData = [
            'uid' => $uid,
            'table_id' => $table_id,
            'total_price' => $total_price,
            'order_date' => date('Y-m-d H:i:s'),
            'status' => 'pending',
            'payment_method' => $payment_method,
            'created_by' => $user_data['id'],
            'customer_id' => $user_data['id'],
        ];

        // Save order and order items
        $order_id = $this->OrderModel->create_order($orderData, $order_items);

        if ($order_id) {
            $this->output->set_status_header(201)->set_content_type('application/json')->set_output(json_encode(['status' => 'success', 'order_id' => $uid]));
        } else {
            $this->output->set_status_header(500)->set_content_type('application/json')->set_output(json_encode(['status' => 'fail', 'message' => 'Order creation failed']));
        }
    }
    public function orderDetails($order_id) {
        // Retrieve order details using the OrderModel
        $order = $this->OrderModel->get_order_details($order_id);

        if ($order) {
            $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode(['status' => 'success', 'order' => $order]));
        } else {
            $this->output->set_status_header(404)->set_content_type('application/json')->set_output(json_encode(['status' => 'fail', 'message' => 'Order not found']));
        }
    }

    public function viewOrders() {
        // Retrieve all orders using the OrderModel
        $orders = $this->OrderModel->get_all_orders();

        if ($orders) {
            $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode(['status' => 'success', 'orders' => $orders]));
        } else {
            $this->output->set_status_header(404)->set_content_type('application/json')->set_output(json_encode(['status' => 'fail', 'message' => 'No orders found']));
        }
    }
}