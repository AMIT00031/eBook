<?php

Class AdminInventory extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library(array('form_validation'));
        $this->load->model('admin/user_model');
        // $this->load->model('admin/support_model');
        //$this->load->model('admin/support_model');
		$this->load->model('admin/inventory_model');
		$this->load->model('common_model');
    }

    public function index() {
		  $checklogin = $this->user_model->check_admin_login_status();
        if (!$checklogin) {
            redirect(base_url('admin/auth/login'));
        }

		 //$user_id 	= $this->input->get('id');
		 $inventory_list 	=  $this->inventory_model->getAllInventroy();
		 //$listuser  =  $this->user_model->getUserDetail($user_id);	
        $data = array(
            'title' => 'Inventory List',
            'list_heading' => 'Inventory List',
             //'username' => $listuser[0]->username,
            'inventory_list' => $inventory_list
        );
        $this->template->load('admin/base', 'admin/inventory/inventory_list', $data);
    }
	
    
	function edit($inv_id){
		  $checklogin = $this->user_model->check_admin_login_status();
        if (!$checklogin) {
            redirect(base_url('admin/auth/login'));
        }
  $checklogin = $this->user_model->check_admin_login_status();
        if (!$checklogin) {
            redirect(base_url('admin/auth/login'));
        }

		$tbl_name = 'inventory';
		$tbl_inventory_images = 'inventory_images';
		$insertedArray = array();
		$data = array( 'title' => 'Edit Inventory', 'list_heading' => 'Edit Inventory');
       
	   if ($inv_id!='') {
			$data['inv_detail']     =  $this->inventory_model->getRecord($tbl_name,$inv_id);
			//$data['inv_detail']     =  $this->inventory_model->getInventroy(array('id',$inv_id));
        }
		$data['country'] 			=  $this->common_model->get_country();
		$data['category'] 			=  $this->common_model->get_category();		
		
	    $postData = $this->input->post();	
        
		if (!empty($postData)) {			
			//$insertedArray = !empty($data) ? $data : '';
            //$name = !empty($insertedArray['page_title']) ? $insertedArray['page_title'] : 'Update Inventory';
            //$descriptions = !empty($insertedArray['desc']) ? $insertedArray['desc'] : 'Update Inventory';
            //$slug = url_title($name, 'dash', true);
            //$insertedArray['url'] = $slug;
            	
			$this->form_validation->set_rules('inv_cate_id', 'category', 'trim|required|xss_clean');
			$this->form_validation->set_rules('inv_country_id', 'country', 'trim|required|xss_clean');
			$this->form_validation->set_rules('inv_type', 'type', 'trim|required|xss_clean');
			$this->form_validation->set_rules('title', 'title', 'trim|required|xss_clean');
			$this->form_validation->set_rules('description', 'description', 'trim|required|xss_clean');
			
			$this->form_validation->set_rules('price', 'price', 'trim|required|xss_clean');
			$this->form_validation->set_rules('city', 'city', 'trim|required|xss_clean');
			//$this->form_validation->set_rules('tags', 'tags', 'trim|required|xss_clean');
			$this->form_validation->set_rules('seller_name', 'seller name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('seller_email', 'seller email', 'trim|required|valid_email|xss_clean');
			$this->form_validation->set_rules('seller_phone', 'seller phone', 'trim|required|xss_clean');
		    
		    if($this->form_validation->run()== TRUE){
											   
				$country_data 	=  explode(",",$this->input->post('inv_country_id'));
				$category_data  =  explode("=====",$this->input->post('inv_cate_id'));
								
				$insert_data = array(
					'user_id' 		=> trim($data['inv_detail']->user_id), //user_id
					'city_id' 		=> trim($this->input->post('city')),
					'country_id' 	=> trim($country_data[0]),
					'country_name' 	=> trim($country_data[1]),
					'inv_cate_id' 	=> trim($category_data[0]),
					'inv_cate_name' => trim($category_data[1]),
					'currency' 		=> trim($this->input->post('currency')),
					
					'inv_type' 		=> trim($this->input->post('inv_type')),
					'title' 		=> trim($this->input->post('title')),
					'description'  	=> $this->input->post('description'),
					'tags'  		=> $this->input->post('tags'),
					'price'  		=> $this->input->post('price'),						
					'seller_name'  	=> $this->input->post('seller_name'),
					'seller_email'  => $this->input->post('seller_email'),
					'seller_phone'  => $this->input->post('seller_phone'),
					'negotiable'    => $this->input->post('negotiable'),
					'is_hide'       => $this->input->post('is_hide'),
					//'status' 		=> 1
					//'ip_address' 	=> $this->input->ip_address()
				);
				
				$updateTrue 		= $this->inventory_model->updateRecord($tbl_name,$insert_data,$inv_id);
				
				if($updateTrue){
					
					$upload_path = 'uploads/inventory/'; 
					
					if(!empty($_FILES['image'])) {
						
						for ($x = 0; $x < count($_FILES['image']); $x++) {
							 if (!empty($_FILES['image']['name'][$x])) {
								 $userImages['image'] = $_FILES['image']['name'][$x];
								 $fileinfo = pathinfo($_FILES['image']['name'][$x]);
								 $extension = $fileinfo['extension'];
								 $allowedExt = array("jpg", "JPG", "png", "PNG","gif","GIF");

								 if (in_array($extension, $allowedExt)){
									 
									 $file_name = 'class_' . rand() . '.' . $extension;
									 $file_path = $upload_path . $file_name;
									 move_uploaded_file($_FILES['image']['tmp_name'][$x], $file_path);
									 $insertdata = array(
										'filename' => $file_name,
										'inv_id' =>  $inv_id,
										'active' =>  1,
										'created_at' =>  date("Y-m-d h:i:s"),
										'updated_at' =>  date("Y-m-d h:i:s")
									 ); 
									 if($x==0){
										 $insert_update_pic = array('image' => $file_name);
										 $this->inventory_model->updateRecord($tbl_name,array('image' => $file_name),$inv_id) ;
										 //$this->inventory_model->update($insert_update_pic, $this->session->userdata('inv_id'));										
									    $this->inventory_model->deleteRecord($tbl_inventory_images,$inv_id);
									 }									 	
									 $resfileupload = $this->inventory_model->insertRecord($tbl_inventory_images,$insertdata);							
								}else{ 
									$this->session->set_flashdata('message_error','Only jpg,png & gif extension allowed');
								}									 
							 }
						}
						//$data['imagesData'] = $this->inventory_model->getAllRecord('inventory_images','',array('inv_id' => $this->session->userdata('inv_id')) );						
					}
					$this->session->set_flashdata('message_error','Data has been successfully updated');
					redirect(base_url().'admin/AdminInventory');					
				}else{
					$this->session->set_flashdata('message_error','Opps! something went wrong, please try again');
					$data['message_error'] = 'Opps! something went wrong, please try again';
					//redirect(base_url().'admin/AdminInventory');
				}						
			}				
		}
			
		$this->template->load('admin/base', 'admin/inventory/invenotry_edit', $data);
		
	}
	
    function changeStatus($id='',$type='')
	{   
	     $checklogin = $this->user_model->check_admin_login_status();
        if (!$checklogin) {
            redirect(base_url('admin/auth/login'));
        }

		$tbl_name = 'inventory';
		if($type == "1"):
			$params = array('status'=>'1');
			$this->inventory_model->updateRecord($tbl_name,$params,$id);
			echo $status=1;
			die;
		elseif($type == "0"):
			$params = array('status'=>'0');
			$this->inventory_model->updateRecord($tbl_name,$params,$id);
			echo $status=0;
			die;
		endif;
		//redirect(base_url().'helpcenter/managehelpcenter/');
	}
	
	
	 function deleteRecord() {
	       $checklogin = $this->user_model->check_admin_login_status();
        if (!$checklogin) {
            redirect(base_url('admin/auth/login'));
        }

		$id 	  = $this->input->post('id');
		if($id!=''){
			$tbl_name = 'inventory';
			$deleted  = $this->inventory_model->ajaxDeleteRecord($tbl_name,$id);
			if($deleted){
				echo "Yes";	
			}else{
				echo "No";
			}
		}else{
            echo "NoId";
		}			
	 }
    
	function get_city_by_ajax(){  ////country: id,asciiname,code,currency_code
	    //$this->load->model('common_model');
	      $checklogin = $this->user_model->check_admin_login_status();
        if (!$checklogin) {
            redirect(base_url('admin/auth/login'));
        }

		$city_data = $this->input->post('city_val');
		$city_mix_data = explode(",",$city_data); 
		
		 if($city_mix_data[2]!=''){
			$county_code = $city_mix_data[2];
		}else{
			$county_code = '';
		}
		
		$city_data = $this->common_model->get_city($county_code);
		
		$data = '';
		if(!empty($city_data)){
			$data .='<select class="form-control" id="city" name="city" required>';
			$data .='<option value="">Select City</option>';
			foreach($city_data as $city){
				$data .='<option value="'.$city->id.'">'.$city->asciiname.'</option>';
			}
			echo $data .='</select>';
		}else{
			echo "No";
		} 			
								
	}
	
	
	
	function get_currency_by_ajax(){  ////country: id,asciiname,code,currency_code
	     $checklogin = $this->user_model->check_admin_login_status();
        if (!$checklogin) {
            redirect(base_url('admin/auth/login'));
        }

		$country_currency_code = $this->input->post('country_currency_code'); 
		$currency_data = $this->common_model->get_currencies($country_currency_code);
		if(!empty($currency_data)){		
			echo $currency_data->html_entity.','.$currency_data->name;
		}else{
			echo "No";
		} 			
								
	}
	
	

}
