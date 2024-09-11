<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrderModel extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
    public function create_order($orderData, $orderItems) {
        $this->db->trans_begin();

        // Insert order data
        $this->db->insert('tb_orders', $orderData);
        $order_id = $this->db->insert_id();

        // Insert order items
        foreach ($orderItems as $item) {
            $itemDet = $this->db->where("uid",$item['product_id'])->get(ITEMS_TABLE)->row();
            if($itemDet){
                $itemData = [
                    'order_id' => $order_id,
                    'product_id' => $itemDet->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $itemDet->unit_price,
                    'total_price' => $item['quantity'] * $itemDet->unit_price,
                    'created_by' => $orderData['created_by']
                ];
                $this->db->insert('tb_order_items', $itemData);
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $order_id;
        }
    }
    public function get_order_details($order_id) {
        // Fetch order details
        $this->db->select('*');
        $this->db->from('tb_orders');
        $this->db->where('uid', $order_id);
        $order = $this->db->get()->row_array();

        if (!$order) {
            return null;
        }

        // Fetch order items
        $this->db->select('tb_order_items.*,tb_items.item_name');
        $this->db->from('tb_order_items');
        $this->db->join('tb_items','tb_items.id = tb_order_items.product_id');
        $this->db->where('order_id', $order['order_id']);
        $order['items'] = $this->db->get()->result_array();

        return $order;
    }
    public function get_all_orders() {
        // Fetch all orders
        $this->db->select('uid,total_price,order_date,status,payment_method,delivery_date,created_at');
        $this->db->from('tb_orders');
        $this->db->where('is_deleted', 'N');
        $this->db->order_by("order_id","DESC");
        $orders = $this->db->get()->result_array();
        return $orders;
    }
    public function getOrdersByUser($id) {
        $query = $this->db->get_where(ORDER_TABLE, ['customer_id' => $id]);
        return $query->result_array();
    }

    public function get_order($id) {
        $query = $this->db->get_where(ORDER_TABLE, ['id' => $id]);
        return $query->row_array();
    }

    public function insertUser($data) {
        $this->db->insert(ORDER_TABLE, $data);
        return $this->db->insert_id();
    }

    public function getUserById($id) {
        return $this->db->get_where(ORDER_TABLE, array('id' => $id))->row_array();
    }
    public function getUserByEmailOrPhone($email_or_phone) {
        $this->db->where('email', $email_or_phone);
        $this->db->or_where('phone', $email_or_phone);
        return $this->db->get(ORDER_TABLE)->row_array();
    }
    public function getAdminUser($email_or_phone) {
        $this->db->where('email', $email_or_phone);
        return $this->db->get(ORDER_TABLE)->row_array();
    }
    
    public function saveToken($order_id, $token) {
        $data = array('auth_token' => $token);
        $this->db->where('id', $order_id);
        $this->db->update(ORDER_TABLE, $data);
    }
    
    public function update_order($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update(ORDER_TABLE, $data);
    }

    public function delete_order($id) {
        $this->db->where('id', $id);
        return $this->db->delete(ORDER_TABLE);
    }
    public function update_order_status($order_id, $status) {
        $data = array(
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')  // Update the timestamp as well
        );

        $this->db->where('uid', $order_id);
        $this->db->update(ORDER_TABLE, $data);
    }
    
}
