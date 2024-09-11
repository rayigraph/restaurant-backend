<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Kolkata');
class Orders extends CI_Controller {

		
    function __construct()
    {
        parent::__construct();
		$this->load->library('session');
        $this->load->database();
        $this->load->model('OrderModel');
		if(!$this->session->userdata("username"))
		{
			redirect(base_url());
		}
    }
	public function index()
	{
		if(!$this->session->userdata("username"))
		{
			redirect(base_url());
		}
		$current_user=$this->session->userdata();
		
	    $curr_user=$current_user['user_id'];

		$data['user']=$current_user;
		

		$this->db->order_by(ORDER_TABLE.".order_id","DESC");
		$this->db->select(ORDER_TABLE.".*,".USER_TABLE.".name");
		$this->db->where(ORDER_TABLE.".is_deleted","N");
		$this->db->join(USER_TABLE,USER_TABLE.".id = ".ORDER_TABLE.".customer_id");
		$data['Orders']=$this->db->get(ORDER_TABLE)->result();
		$this->load->view("nav",$data);
		$this->load->view('orders/view_orders');
		$this->load->view("footer");
	}
	function view_details($order_id)
	{
		$current_user=$this->session->userdata();
		
	    $curr_user=$current_user['user_id'];
		$data['user']=$current_user;
		if(!$order_id)
			redirect("orders");
		$this->db->select(ORDER_TABLE.".*,".USER_TABLE.".name");
		$this->db->where(ORDER_TABLE.".uid",$order_id);
		$this->db->where(ORDER_TABLE.".is_deleted","N");
		$this->db->join(USER_TABLE,USER_TABLE.".id = ".ORDER_TABLE.".customer_id");
		$order=$this->db->get(ORDER_TABLE)->row();
		if(!$order)
			redirect("orders");
		$this->db->where(ORDER_ITEM_TABLE.".order_id",$order->order_id);
		$this->db->where(ORDER_ITEM_TABLE.".is_deleted","N");
		$this->db->join(ITEMS_TABLE,ITEMS_TABLE.".id = ".ORDER_ITEM_TABLE.".product_id");
		$this->db->join(SUPPLIER_TABLE,SUPPLIER_TABLE.".id = ".ITEMS_TABLE.".supplier_id");
		$data['order_items']=$this->db->get(ORDER_ITEM_TABLE)->result();
		$data['order']=$order;
		$this->load->view("nav",$data);
		$this->load->view('orders/order_details');
		$this->load->view("footer");
	}
	public function update_status() {
        // Load the order model
        $this->load->model('OrderModel');

		if($this->input->post())
		{
			$status = $this->input->post('status');
			$order_id = $this->input->post('uid');

			// Update the order status
			$this->OrderModel->update_order_status($order_id, $status);

			// Set a flash message to indicate success
			$this->session->set_flashdata('success', 'Order status updated successfully.');
			redirect('orders/view_details/'.$order_id);
		}
		redirect('orders');
    }
	public function delete_order_item()
	{
		$current_user=$this->session->userdata();
		if($this->input->post())
		{
			$order_uid=$this->input->post('order_id');
			$item_id=$this->input->post('item_id');

			$this->db->where(ORDER_TABLE.".uid",$order_uid);
			$order_details = $this->db->get(ORDER_TABLE)->row();
			
			if($order_details){
				if($order_details->status == "cancelled" || $order_details->status == "completed"){
					$this->session->set_flashdata('error', "You can't update this order");
					redirect('orders/view_details/'.$order_uid);
				}
				$order_id = $order_details->order_id;
				$this->db->trans_start();
				$this->db->where(ORDER_ITEM_TABLE.".order_id",$order_id);
				$this->db->where(ORDER_ITEM_TABLE.".item_id",$item_id);
				$this->db->update(ORDER_ITEM_TABLE,array("is_deleted"=>"Y"));

				$this->db->select_sum('total_price', 'total');
				$this->db->where(ORDER_ITEM_TABLE.".is_deleted","N");
				$this->db->where('order_id', $order_id);
				$query = $this->db->get(ORDER_ITEM_TABLE);
				$new_total = $query->row()->total;

				$this->db->where(ORDER_TABLE.".order_id",$order_id);
				$this->db->where(ORDER_TABLE.".is_deleted","N");
				$this->db->update(ORDER_TABLE,array("total_price"=>$new_total));

				$this->db->trans_complete();

				if($this->db->trans_status())
					$this->session->set_flashdata('success', 'Order item deleted successfully.');
				redirect('orders/view_details/'.$order_uid);
			}
		}
		redirect('orders');
	}
	public function update_order_item()
	{
		$current_user=$this->session->userdata();
		if($this->input->post())
		{
			$order_uid=$this->input->post('order_id');
			$item_id=$this->input->post('item_id');
			$quantity=$this->input->post('quantity');

			$this->db->where(ORDER_TABLE.".uid",$order_uid);
			$order_details = $this->db->get(ORDER_TABLE)->row();
			
			if($order_details){
				if($order_details->status == "cancelled" || $order_details->status == "completed"){
					$this->session->set_flashdata('error', "You can't update this order");
					redirect('orders/view_details/'.$order_uid);
				}
				$order_id = $order_details->order_id;
				
				$this->db->where(ORDER_ITEM_TABLE.".item_id",$item_id);
				$order_item_details = $this->db->get(ORDER_ITEM_TABLE)->row();
				if($order_item_details)
				{
					$unit_price = $order_item_details->unit_price;
					$new_total = $unit_price * $quantity;
					$this->db->trans_start();
					$this->db->where(ORDER_ITEM_TABLE.".order_id",$order_id);
					$this->db->where(ORDER_ITEM_TABLE.".item_id",$item_id);
					$this->db->update(ORDER_ITEM_TABLE,array("quantity"=>$quantity, "total_price" => $new_total));

					$this->db->select_sum('total_price', 'total');
					$this->db->where(ORDER_ITEM_TABLE.".is_deleted","N");
					$this->db->where('order_id', $order_id);
					$query = $this->db->get(ORDER_ITEM_TABLE);
					$new_total = $query->row()->total;

					$this->db->where(ORDER_TABLE.".order_id",$order_id);
					$this->db->where(ORDER_TABLE.".is_deleted","N");
					$this->db->update(ORDER_TABLE,array("total_price"=>$new_total));

					$this->db->trans_complete();

					if($this->db->trans_status())
						$this->session->set_flashdata('success', 'Order item deleted successfully.');
				}
				redirect('orders/view_details/'.$order_uid);
			}
		}
		redirect('orders');
	}
}