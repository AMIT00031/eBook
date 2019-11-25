<?php

Class Model extends CI_Controller {

    function __construct() {

        parent::__construct();

        $this->load->library(array('form_validation'));
       // $this->lang->load('english');
	    $this->load->model('admin/Product_model');
        $this->load->model('admin/Model_model');
        //$this->load->model('admin/Category_gallery_model');
        //$this->categoryDir = $this->config->item('upload_product_image');
    }

    public function index() {
		
        /* if (!$this->ion_auth->logged_in()) {

            redirect('admin/auth/login', 'refresh');

        } */
        $list = $this->Model_model->get_all();

        $data = array(

            'title' => 'Model',

            'list_heading' => 'Model',

            'lists' => $list,

        );
        $this->template->load('admin/base', 'admin/model/list', $data);
    }


    function addedit($id = null) {

        if (!empty($id)) {
            $edit_data = $this->Model_model->get($id);     
        }
        $data = $this->input->post();
        if (!empty($data)) {
		
            $all_data = returnValidData('model', $data);

            $name = !empty($data['name']) ? $data['name'] : '';
			
            $slug = url_title($name, 'dash', true);
			
            $all_data['slug'] = $slug;
			
            try {
				if($id!=''){
					$ab = $this->Model_model->update($all_data, $id);
				}else{
					$ab = $this->Model_model->insert($all_data, FALSE);
				}

                if ($ab) {

                    setMessage('Record submitted successfully', 'success');

                    redirect('admin/model', 'refresh');

                }else{
                     setMessage('Record not submitted successfully ! something went wrong', 'warning');

                     redirect('admin/model', 'refresh');
                }

            } catch (Exception $ex) {

                setMessage('Model not updated! please try again','warning');

                redirect('admin/model', 'refresh');

            }

        }
        
        $data = array(

            'title' => 'Add/Edit Model',
            'list_heading' => 'Update Model',
            'edit_data' => $edit_data,
        );

		$this->template->load('admin/base', 'admin/model/addedit', $data);

    }
	
	function changeStatus($id,$status=''){
	 
	    if(is_numeric($id)){
			if($status==1){   
				$update_data  = array('status'=>1);
				$ab = $this->Model_model->update($update_data, $id);
				echo 1;
			}else{
				$update_data  = array('status'=>0);
				$ab = $this->Model_model->update($update_data, $id);
				echo 0;
			}
			
		}else{
			 return false;
		}
		
	}
   
   /* function deleteCustomeAttribute(){
   
   
   } */
	
	


}



?>