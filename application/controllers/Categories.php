<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Kolkata');
class Categories extends CI_Controller {

		
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
	public function index($supplier_id = null)
	{
		if(!$this->session->userdata("username"))
		{
			redirect(base_url());
		}
		$current_user=$this->session->userdata();
		
	    $curr_user=$current_user['user_id'];

		$data['user']=$current_user;
		
		if($supplier_id)
		{
			$sup_details = $this->db->where("uid",$supplier_id)->get(SUPPLIER_TABLE)->row();
			if($sup_details){
				$this->db->where(CATEGORY_TABLE.".supplier_id",$sup_details->id);
			}
			else
				redirect("sub_categories");
		}

		$this->db->select(CATEGORY_TABLE.".*,".SUPPLIER_TABLE.".supplier_name");
		$this->db->where(CATEGORY_TABLE.".is_deleted","N");
		$this->db->join(SUPPLIER_TABLE,SUPPLIER_TABLE.".id=".CATEGORY_TABLE.".supplier_id");
		$this->db->where(CATEGORY_TABLE.".is_deleted","N");
		$data['Categories']=$this->db->get(CATEGORY_TABLE)->result();
		$data['supplier_id'] = $supplier_id;
		$this->load->view("nav",$data);
		$this->load->view('categories/view_categories');
		$this->load->view("footer");
	}
    public function add_new($supplier_id = null)
	{
		$sup_id = "";
		if($supplier_id)
		{
			$sup_details = $this->db->where("uid",$supplier_id)->get(SUPPLIER_TABLE)->row();
			if($sup_details){
				$sup_id = $sup_details->id;
			}
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
                    $file_name = "category_image".'_'.time().'.'.$ext;
                    $config['upload_path']         = CATEGORY_PATH;
                    
                    $config['allowed_types']     = "jpg|png|jpeg";
                    $config['max_size']             = 3000;
                
                    $config['file_name']  = $file_name;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                
                    if ($this->upload->do_upload('image')) 
                    {
                        $category['category_image']=$file_name;
						$category['uid']=strtotime("now");
						$category['supplier_id']=$this->input->post("supplier_id");
						$category['category_name']=$this->input->post("category_name");
						$category['created_by']=$curr_user;
						$category['created_at']=date("Y-m-d H:i:s");
						$this->db->insert(CATEGORY_TABLE,$category);
						$this->session->set_flashdata('success', 'Category Added Successfully'); 
                    } 
                    else 
                    {
                        $message= '<br>'.strip_tags($this->upload->display_errors());
						$this->session->set_flashdata('error', $message);
                        $status =1;
                    }
                    
                }
            }
			redirect("categories/".$supplier_id);
		}
		$this->db->where("is_deleted","N");
		$suppliers = $this->db->get(SUPPLIER_TABLE)->result();
		$data['suppliers'] = $suppliers;
		$data['sup_id'] = $sup_id;
		$this->load->view("nav",$data);
		$this->load->view('categories/add_category');
		$this->load->view("footer");
	}
	function edit_category($category_id)
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
                    $file_name = "category_image".'_'.time().'.'.$ext;
                    $config['upload_path']         = CATEGORY_PATH;
                    
                    $config['allowed_types']     = "jpg|png|jpeg";
                    $config['max_size']             = 3000;
                
                    $config['file_name']  = $file_name;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                
                    if ($this->upload->do_upload('image')) 
                    {
                        $category['category_image']=$file_name;
                    } 
                    else 
                    {
                        $message= '<br>'.strip_tags($this->upload->display_errors());
						$this->session->set_flashdata('error', $message);
                        $status =1;
                    }
                    
                }
            }
			$category['category_name']=$this->input->post("category_name");
			$category['updated_by']=$curr_user;
			$category['updated_at']=date("Y-m-d H:i:s");
			
			$this->db->where("uid",$category_id);
			if($this->db->update(CATEGORY_TABLE,$category))
				$this->session->set_flashdata('success', 'Category Updated Successfully');
			else
				$this->session->set_flashdata('error', 'Category Updated Failed');
			redirect("categories");
		}
		$category = $this->db->where(["uid" => $category_id,"is_deleted" => "N"])->get(CATEGORY_TABLE)->row();
		if(!$category)
			redirect("categories");

		$data['user']=$current_user;
		$message="";
		$data['category']=$category;
		$data['curr_user']=$curr_user;
		$this->load->view("nav",$data);
		$this->load->view('categories/edit_category');
		$this->load->view("footer");
	}
	function delete_category()
	{
		$current_user=$this->session->userdata();
		
	    $curr_user=$current_user['user_id'];

		$data['user']=$current_user;
		if($this->input->post())
		{
			$category_id=$this->input->post("category_id");
			$this->db->where("uid",$category_id);
			$this->db->update(CATEGORY_TABLE,array("is_deleted" => "Y","deleted_by" => $curr_user,"deleted_date" => date("Y-m-d H:i:s")));
		}
		redirect("categories");

	}
	public function update_category_availability() {
		if($this->input->post()){
			$availability = $this->input->post("availability");
			$category_id = $this->input->post("CategoryId");
			$data = array(
				'availability' => $availability
			);
			$this->db->where('uid', $category_id);
			return $this->db->update(CATEGORY_TABLE, $data);
		}
    }
}