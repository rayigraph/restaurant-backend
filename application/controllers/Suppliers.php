<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Kolkata');
class Suppliers extends CI_Controller {

		
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
	public function index()
	{
		if(!$this->session->userdata("username"))
		{
			redirect(base_url());
		}
		$current_user=$this->session->userdata();
		
	    $curr_user=$current_user['user_id'];

		$data['user']=$current_user;
		

		$this->db->where("is_deleted","N");
		$data['Suppliers']=$this->db->get(SUPPLIER_TABLE)->result();
		$this->load->view("nav",$data);
		$this->load->view('suppliers/view_suppliers');
		$this->load->view("footer");
	}
    public function add_new()
	{
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
                    $file_name = "supplier_image".'_'.time().'.'.$ext;
                    $config['upload_path']         = SUPPLIER_PATH;
                    
                    $config['allowed_types']     = "jpg|png|jpeg";
                    $config['max_size']             = 3000;
                
                    $config['file_name']  = $file_name;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                
                    if ($this->upload->do_upload('image')) 
                    {
                        $supplier['supplier_image']=$file_name;
						$supplier['uid']=strtotime("now");
						$supplier['supplier_name']=$this->input->post("supplier_name");
						$supplier['created_by']=$curr_user;
						$supplier['created_at']=date("Y-m-d H:i:s");
						$this->db->insert(SUPPLIER_TABLE,$supplier);
						$this->session->set_flashdata('success', 'Supplier Added Successfully'); 
                    } 
                    else 
                    {
                        $message= '<br>'.strip_tags($this->upload->display_errors());
						$this->session->set_flashdata('error', $message);
                        $status =1;
                    }
                    
                }
            }
			redirect("suppliers");
		}
		$this->load->view("nav",$data);
		$this->load->view('suppliers/add_supplier');
		$this->load->view("footer");
	}
	function edit_supplier($supplier_id)
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
                    $file_name = "supplier_image".'_'.time().'.'.$ext;
                    $config['upload_path']         = SUPPLIER_PATH;
                    
                    $config['allowed_types']     = "jpg|png|jpeg";
                    $config['max_size']             = 3000;
                
                    $config['file_name']  = $file_name;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                
                    if ($this->upload->do_upload('image')) 
                    {
                        $supplier['supplier_image']=$file_name;
                    } 
                    else 
                    {
                        $message= '<br>'.strip_tags($this->upload->display_errors());
						$this->session->set_flashdata('error', $message);
                        $status =1;
                    }
                    
                }
            }
			$supplier['supplier_name']=$this->input->post("supplier_name");
			$supplier['updated_by']=$curr_user;
			$supplier['updated_at']=date("Y-m-d H:i:s");
			
			$this->db->where("uid",$supplier_id);
			if($this->db->update(SUPPLIER_TABLE,$supplier))
				$this->session->set_flashdata('success', 'Supplier Updated Successfully');
			else
				$this->session->set_flashdata('error', 'Supplier Updated Failed');
			redirect("suppliers");
		}
		$supplier = $this->db->where(["uid" => $supplier_id,"is_deleted" => "N"])->get(SUPPLIER_TABLE)->row();
		if(!$supplier)
			redirect("suppliers");

		$data['user']=$current_user;
		$message="";
		$data['supplier']=$supplier;
		$data['curr_user']=$curr_user;
		$this->load->view("nav",$data);
		$this->load->view('suppliers/edit_supplier');
		$this->load->view("footer");
	}
	function delete_supplier()
	{
		$current_user=$this->session->userdata();
		
	    $curr_user=$current_user['user_id'];

		$data['user']=$current_user;
		if($this->input->post())
		{
			$supplier_id=$this->input->post("supplier_id");
			$this->db->where("uid",$supplier_id);
			$this->db->update(SUPPLIER_TABLE,array("is_deleted" => "Y","deleted_by" => $curr_user,"deleted_date" => date("Y-m-d H:i:s")));
		}
		redirect("suppliers");

	}
	public function update_supplier_availability() {
		if($this->input->post()){
			$availability = $this->input->post("availability");
			$supplier_id = $this->input->post("SupplierId");
			$data = array(
				'availability' => $availability
			);
			$this->db->where('uid', $supplier_id);
			return $this->db->update(SUPPLIER_TABLE, $data);
		}
    }
}