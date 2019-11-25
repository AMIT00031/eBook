<?php

Class Frontusers extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library(array('form_validation'));
        $this->load->model('admin/user_model');
        $this->load->model('admin/frontuser_model');
      
		$this->load->model('common_model');
    }

    public function index() {
		  $checklogin = $this->user_model->check_admin_login_status();
        if (!$checklogin) {
            redirect(base_url('admin/auth/login'));
        }

		 //$user_id 	= $this->input->get('id');
		 $user_list = $this->frontuser_model->get_all();
		  //echo "<pre>";print_r($company_list);exit;
		 //$listuser  =  $this->user_model->getUserDetail($user_id);	
        $data = array(
            'title' => 'Users List',
            'list_heading' => 'User List',
             //'username' => $listuser[0]->username,
            'user_list' => $user_list
        );
       
        $this->template->load('admin/base', 'admin/frontuser/user_list', $data);
    }
	function adduser(){
		    if(isset($_POST['submit']))
		    {				//echo "<pre>";print_r($_POST);exit;
				$postData['user_name']=$_POST['username'];
				$postData['full_name']=$postData['user_name'].' '.$_POST['lastname'];				$postData['lastname']=$_POST['lastname'];
				$postData['country']=$_POST['location'];
				$postData['email']=$_POST['email'];
				$postData['phone_no']=$_POST['phone'];
				$postData['company_name']=$_POST['company'];
		   		if (!empty(trim($_POST['password']))) {
					$password = base64_encode($_POST['password']);
					$postData['password'] = $password;
				}
		       $res = $this->frontuser_model->insert($postData);				redirect(base_url('admin/frontusers'));
		    }
		     $data = array(
            'title' => 'user Add',
            'list_heading' => 'User Add',
            //'username' => $listuser[0]->username,
        );
		   $this->template->load('admin/base', 'admin/frontuser/adduser', $data);
	}
    
	function edit($inv_id){
		$checklogin = $this->user_model->check_admin_login_status();
        if (!$checklogin) {
            redirect(base_url('admin/auth/login'));
        }

		$tbl_name = 'user_login_table';
		$insertedArray = array();
		$data = array( 'title' => 'Edit User', 'list_heading' => 'Edit User');
       
	   if($inv_id!=''){
			$data['inv_detail']     =  $this->frontuser_model->getRecord($tbl_name,$inv_id);						//echo "<pre>";print_r($data['inv_detail']);exit;
			//$data['inv_detail']     =  $this->inventory_model->getInventroy(array('id',$inv_id));
        }
        
		
	    $postData = $this->input->post();	
       
		if (!empty($postData)) {			
		
			/*$this->form_validation->set_rules('username', 'username', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|xss_clean');
			*/	
		    
		    if($this->form_validation->run('frontuser')== TRUE){
		
				$post = $this->input->post();
				unset($post['password']);
				if (!empty(trim($this->input->post('password')))) {
					$password = md5($this->input->post('password'));
					$post['password'] = $password;
				}
				$upload_path = 'uploads/img/';
	            if (!empty($_FILES['profilephoto']['name'])) {
                    $post['profilephoto'] = $this->uploadImage($_FILES,$upload_path,'profilephoto','prof_');
                }
                if (!empty($_FILES['resume']['name'])) {
                    $upload_path = 'uploads/resume/';
                    $post['resume'] = $this->uploadImage($_FILES,$upload_path,'resume','res_');
                } 
	            unset($post['submit']);
				$updateTrue = $this->frontuser_model->updateRecord($tbl_name,$post,$inv_id);
				if($updateTrue){
					$this->session->set_flashdata('message_error','Data has been successfully updated');
					redirect(base_url().'admin/frontusers');					
				}else{
					$this->session->set_flashdata('message_error','Opps! something went wrong, please try again');
					$data['message_error'] = 'Opps! something went wrong, please try again';
					redirect(base_url().'admin/frontusers');					
				}						
			}				
		}
			
		$this->template->load('admin/base', 'admin/frontuser/user_edit', $data);
		
	}
	function changeStatus($id='',$type='')
	{   
	     $checklogin = $this->user_model->check_admin_login_status();
        if (!$checklogin) {
            redirect(base_url('admin/auth/login'));
        }

		$tbl_name = 'users';
		if($type == "1"):
			$params = array('status'=>'1');
			$this->frontuser_model->updateRecord($tbl_name,$params,$id);
			echo $status=1;
			die;
		elseif($type == "0"):
			$params = array('status'=>'0');
			$this->frontuser_model->updateRecord($tbl_name,$params,$id);
			echo $status=0;
			die;
		endif;
		//redirect(base_url().'helpcenter/managehelpcenter/');
	}
    /*function changeStatus($id='',$type='')
	{   
	   // echo $id."--".$type;
	     $checklogin = $this->user_model->check_admin_login_status();
        if (!$checklogin) {
            redirect(base_url('admin/auth/login'));
        }

		$tbl_name = 'users';
		if($type == "1"):
			$params = array('clasifiedcompany_status'=>'1');
			
               
			$res =$this->globelrecuitmentcompany_model->updateRecord($tbl_name,$params,$id);
			echo $status=1;
			die;
		elseif($type == "0"):
			$params = array('clasifiedcompany_status'=>'0');
			$this->globelrecuitmentcompany_model->updateRecord($tbl_name,$params,$id);
			echo $status=0;
			die;
		endif;
		//redirect(base_url().'helpcenter/managehelpcenter/');
	}*/
	
	
	 function deleteRecord() {
	       $checklogin = $this->user_model->check_admin_login_status();
        if (!$checklogin) {
            redirect(base_url('admin/auth/login'));
        }

		$id 	  = $this->input->post('id');
		if($id!=''){
			$tbl_name = 'users';
			$deleted  = $this->frontuser_model->deleteRecord($tbl_name,$id);
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
