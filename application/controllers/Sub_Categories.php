<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Kolkata');
class Sub_Categories extends CI_Controller {

		
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
	public function index($category_id=null)
	{
		$current_user=$this->session->userdata();
		
	    $curr_user=$current_user['user_id'];

		$data['user']=$current_user;
		if($category_id)
		{
			$cat_details = $this->db->where("uid",$category_id)->get(CATEGORY_TABLE)->row();
			if($cat_details){
				$this->db->where(SUB_CATEGORY_TABLE.".category_id",$cat_details->id);
			}
			else
				redirect("sub_categories");
		}
		$this->db->select(SUB_CATEGORY_TABLE.".*,".CATEGORY_TABLE.".category_name");
		$this->db->where(SUB_CATEGORY_TABLE.".is_deleted","N");
		$this->db->join(CATEGORY_TABLE,CATEGORY_TABLE.".id=".SUB_CATEGORY_TABLE.".category_id");
		$data['Sub_Categories']=$this->db->get(SUB_CATEGORY_TABLE)->result();
		$data['category_id'] = $category_id;
		$this->load->view("nav",$data);
		$this->load->view('sub_categories/view_sub_categories');
		$this->load->view("footer");
	}
    public function add_new($category_id=null)
	{
		$cat_id = "";
		if($category_id)
		{
			$cat_details = $this->db->where("uid",$category_id)->get(CATEGORY_TABLE)->row();
			if($cat_details){
				$cat_id = $cat_details->id;
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
                    $file_name = "sub_category_image".'_'.time().'.'.$ext;
                    $config['upload_path']         = SUB_CATEGORY_PATH;
                    
                    $config['allowed_types']     = "jpg|png|jpeg";
                    $config['max_size']             = 3000;
                
                    $config['file_name']  = $file_name;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                
                    if ($this->upload->do_upload('image')) 
                    {
                        $sub_category['sub_category_image']=$file_name;
						$sub_category['uid']=strtotime("now");
						$sub_category['sub_category_name']=$this->input->post("sub_category_name");
						$sub_category['category_id']=$this->input->post("category_id");
						$sub_category['created_by']=$curr_user;
						$sub_category['created_at']=date("Y-m-d H:i:s");
						$this->db->insert(SUB_CATEGORY_TABLE,$sub_category);
						$this->session->set_flashdata('success', 'Sub Category Added Successfully'); 
                    } 
                    else 
                    {
                        $message= '<br>'.strip_tags($this->upload->display_errors());
						$this->session->set_flashdata('error', $message);
                        $status =1;
                    }
                    
                }
            }
			redirect("sub_categories/".$category_id);
		}
		$this->db->where("is_deleted","N");
		$categories = $this->db->get(CATEGORY_TABLE)->result();
		$data['categories'] = $categories;
		$data['cat_id'] = $cat_id;
		$this->load->view("nav",$data);
		$this->load->view('sub_categories/add_sub_category');
		$this->load->view("footer");
	}
	function edit_sub_category($sub_category_id)
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
                    $file_name = "sub_category_image".'_'.time().'.'.$ext;
                    $config['upload_path']         = SUB_CATEGORY_PATH;
                    
                    $config['allowed_types']     = "jpg|png|jpeg";
                    $config['max_size']             = 3000;
                
                    $config['file_name']  = $file_name;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                
                    if ($this->upload->do_upload('image')) 
                    {
                        $sub_category['sub_category_image']=$file_name;
                    } 
                    else 
                    {
                        $message= '<br>'.strip_tags($this->upload->display_errors());
						$this->session->set_flashdata('error', $message);
                        $status =1;
                    }
                    
                }
            }
			$sub_category['sub_category_name']=$this->input->post("sub_category_name");
			$sub_category['updated_by']=$curr_user;
			$sub_category['updated_at']=date("Y-m-d H:i:s");
			
			$this->db->where("uid",$sub_category_id);
			if($this->db->update(SUB_CATEGORY_TABLE,$sub_category))
				$this->session->set_flashdata('success', 'Sub Category Updated Successfully');
			else
				$this->session->set_flashdata('error', 'Sub Category Updated Failed');
			redirect("sub_categories");
		}
		$sub_category = $this->db->where(["uid" => $sub_category_id,"is_deleted" => "N"])->get(SUB_CATEGORY_TABLE)->row();
		if(!$sub_category)
			redirect("sub_categories");

		$data['user']=$current_user;
		$message="";
		$data['sub_category']=$sub_category;
		$data['curr_user']=$curr_user;
		$this->db->where("is_deleted","N");
		$categories = $this->db->get(CATEGORY_TABLE)->result();
		$data['categories'] = $categories;
		$this->load->view("nav",$data);
		$this->load->view('sub_categories/edit_sub_category');
		$this->load->view("footer");
	}
	function delete_sub_category()
	{
		$current_user=$this->session->userdata();
		
	    $curr_user=$current_user['user_id'];

		$data['user']=$current_user;
		if($this->input->post())
		{
			$sub_category_id=$this->input->post("sub_category_id");
			$this->db->where("uid",$sub_category_id);
			$this->db->update(SUB_CATEGORY_TABLE,array("is_deleted" => "Y","deleted_by" => $curr_user,"deleted_date" => date("Y-m-d H:i:s")));
		}
		redirect("sub_categories");

	}
	public function update_sub_category_availability() {
		if($this->input->post()){
			$availability = $this->input->post("availability");
			$sub_category_id = $this->input->post("subCategoryId");
			$data = array(
				'availability' => $availability
			);
			$this->db->where('uid', $sub_category_id);
			return $this->db->update(SUB_CATEGORY_TABLE, $data);
		}
    }
}