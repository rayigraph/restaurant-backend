<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Kolkata');
class Items extends CI_Controller {

		
    function __construct()
    {
        parent::__construct();
		$this->load->library('session');
        $this->load->database();
		if(!$this->session->userdata("username"))
		{
			redirect(base_url());
		}
    }
	public function index($sub_category_id=null)
	{
		if(!$this->session->userdata("username"))
		{
			redirect(base_url());
		}
		$current_user=$this->session->userdata();
		
	    $curr_user=$current_user['user_id'];

		$data['user']=$current_user;
		
		if($this->input->post())
		{
			$sub_category_id = $this->input->post("sub_category_id");
			$data['sub_category_id'] = $sub_category_id;
			if($sub_category_id)
				$this->db->where(ITEMS_TABLE.".sub_category_id",$sub_category_id);
			$category_id = $this->input->post("category_id");
			$data['category_id'] = $category_id;
			if($category_id)
				$this->db->where(ITEMS_TABLE.".category_id",$category_id);
			$supplier_id = $this->input->post("supplier_id");
			$data['supplier_id'] = $supplier_id;
			if($supplier_id)
				$this->db->where(ITEMS_TABLE.".supplier_id",$supplier_id);
		}else{
			$sub_category_details = $this->db->where("uid",$sub_category_id)->get(SUB_CATEGORY_TABLE)->row();
			if($sub_category_details)
				$this->db->where(ITEMS_TABLE.".sub_category_id",$sub_category_details->id);
		}
		$this->db->select(ITEMS_TABLE.".*,".CATEGORY_TABLE.".category_name,".SUB_CATEGORY_TABLE.".sub_category_name,".SUPPLIER_TABLE.".supplier_name");
		$this->db->join(SUB_CATEGORY_TABLE,SUB_CATEGORY_TABLE.".id=".ITEMS_TABLE.".sub_category_id");
		$this->db->join(CATEGORY_TABLE,CATEGORY_TABLE.".id=".ITEMS_TABLE.".category_id");
		$this->db->join(SUPPLIER_TABLE,SUPPLIER_TABLE.".id=".ITEMS_TABLE.".supplier_id");
		$this->db->where(ITEMS_TABLE.".is_deleted","N");
		$data['Items']=$this->db->get(ITEMS_TABLE)->result();
		$data['sub_category_id'] = $sub_category_id;
		$this->load->view("nav",$data);
		$this->load->view('items/view_items');
		$this->load->view("footer");
	}
    public function add_new($sub_category_id=null)
	{
		$sub_cat_id = "";
		if($sub_category_id)
		{
			$sub_cat_details = $this->db->where("uid",$sub_category_id)->get(SUB_CATEGORY_TABLE)->row();
			if($sub_cat_details){
				$sub_cat_id = $sub_cat_details->id;
			}
		}
		if(!$this->session->userdata("username"))
		{
			redirect(base_url());
		}
		$current_user=$this->session->userdata();
		
	    $curr_user=$current_user['user_id'];

		$data['user']=$current_user;
		$message="";
		if($this->input->post())
		{
            if (count($_FILES) > 0) 
            {
                $msg="";
            
                if ($_FILES['image']['name'] != '' && $_FILES['image']['error'] != 4) 
                {
                    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $file_name = "item_image".'_'.time().'.'.$ext;
                    $config['upload_path']         = ITEM_PATH;
                    
                    $config['allowed_types']     = "jpg|png|jpeg";
                    $config['max_size']             = 3000;
                
                    $config['file_name']  = $file_name;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                
                    if ($this->upload->do_upload('image')) 
                    {
						$sub_category = $this->input->post("sub_category_id");
						$this->db->select("supplier_id,category_id");
						$this->db->where(SUB_CATEGORY_TABLE.".id",$sub_category);
						$this->db->where(SUB_CATEGORY_TABLE.'.is_deleted', 'N');
						$this->db->join(CATEGORY_TABLE,CATEGORY_TABLE.".id=".SUB_CATEGORY_TABLE.".category_id");
						$sub_cat_det = $this->db->get(SUB_CATEGORY_TABLE)->row();
						$supplier_id = $sub_cat_det->supplier_id;
						$category_id = $sub_cat_det->category_id;

                        $item['item_image']=$file_name;
						$item['uid']=strtotime("now");
						$item['unit_price']=$this->input->post("unit_price");
						$item['item_name']=$this->input->post("item_name");
						$item['sub_category_id']=$sub_category;
						$item['supplier_id']=$supplier_id;
						$item['category_id']=$category_id;
						$item['created_by']=$curr_user;
						$item['created_at']=date("Y-m-d H:i:s");
						$this->db->insert(ITEMS_TABLE,$item);
						$this->session->set_flashdata('success', 'Item Added Successfully'); 
                    } 
                    else 
                    {
                        $message= '<br>'.strip_tags($this->upload->display_errors());
						$this->session->set_flashdata('error', $message);
                        $status =1;
                    }
                    
                }
            }
			redirect("items/".$sub_category_id);
		}
		$this->db->where("is_deleted","N");
		$sub_categories = $this->db->get(SUB_CATEGORY_TABLE)->result();
		$data['sub_categories'] = $sub_categories;
		$data['sub_cat_id'] = $sub_cat_id;
		$this->load->view("nav",$data);
		$this->load->view('items/add_item');
		$this->load->view("footer");
	}
	function edit_item($item_id)
	{
		$current_user=$this->session->userdata();
		
	    $curr_user=$current_user['user_id'];
		if($this->input->post())
		{
            if (count($_FILES) > 0) 
            {
                $msg="";
            
                if ($_FILES['image']['name'] != '' && $_FILES['image']['error'] != 4) 
                {
                    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $file_name = "item_image".'_'.time().'.'.$ext;
                    $config['upload_path']         = "uploads/item_image";
                    
                    $config['allowed_types']     = "jpg|png|jpeg";
                    $config['max_size']             = 3000;
                
                    $config['file_name']  = $file_name;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                
                    if ($this->upload->do_upload('image')) 
                    {
                        $item['item_image']=$file_name;
                    } 
                    else 
                    {
                        $message= '<br>'.strip_tags($this->upload->display_errors());
						$this->session->set_flashdata('error', $message);
                        $status =1;
                    }
                    
                }
            }
			$item['item_name']=$this->input->post("item_name");
			$item['unit_price']=$this->input->post("unit_price");
			$item['updated_by']=$curr_user;
			$item['updated_at']=date("Y-m-d H:i:s");
			
			$this->db->where("uid",$item_id);
			if($this->db->update(ITEMS_TABLE,$item))
				$this->session->set_flashdata('success', 'Item Updated Successfully');
			else
				$this->session->set_flashdata('error', 'Item Updated Failed');
			redirect("items");
		}
		$item = $this->db->where(["uid" => $item_id,"is_deleted" => "N"])->get(ITEMS_TABLE)->row();
		if(!$item)
			redirect("items");

		$data['user']=$current_user;
		$message="";
		$data['item']=$item;
		$data['curr_user']=$curr_user;
		$this->load->view("nav",$data);
		$this->load->view('items/edit_item');
		$this->load->view("footer");
	}
	function delete_item($sub_category_id=null)
	{
		$current_user=$this->session->userdata();		
	    $curr_user=$current_user['user_id'];
		$data['user']=$current_user;
		if($this->input->post())
		{
			$item_id=$this->input->post("item_id");
			$this->db->where("uid",$item_id);
			$this->db->update(ITEMS_TABLE,array("is_deleted" => "Y","deleted_by" => $curr_user,"deleted_date" => date("Y-m-d H:i:s")));
		}
		redirect("items/".$sub_category_id);
	}
	public function update_item_availability() {
		if($this->input->post()){
			$availability = $this->input->post("availability");
			$item_id = $this->input->post("itemId");
			$data = array(
				'availability' => $availability
			);
			$this->db->where('uid', $item_id);
			return $this->db->update(ITEMS_TABLE, $data);
		}
    }
}