<?php
Class Category extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library(array('form_validation'));
       // $this->lang->load('english');
        $this->load->model('admin/Category_model');
        //$this->load->model('admin/Category_gallery_model');
        $this->categoryDir = $this->config->item('upload_category_image');
    }

    public function index() {
      
        /* if (!$this->ion_auth->logged_in()) {

            redirect('admin/auth/login', 'refresh');

        } */

        $list = $this->Category_model->get_all();

		//   dump($list);die;

        $data = array(
            'title' => 'Category',
            'list_heading' => 'Category',
            'lists' => $list,
        );
        $this->template->load('admin/base', 'admin/category/list', $data);
    }

    

    function add(){
             
       /*  if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        } */
		
		
        $data = $this->input->post();
        if (!empty($data)){
            $categoryInfo = returnValidData('tbl_category', $data);
 		    $name = !empty($data['name']) ? $data['name'] : '';
            $slug = url_title($name, 'dash', true);
            $categoryInfo['category_name'] = $name;
            $categoryInfo['slug_url'] = $slug;
            $categoryInfo['description'] = !empty($data['description']) ? $data['description'] : '';
			
            
            if (!empty(trim($_FILES['image']['name']))) {
                $catImages['image'] = $_FILES['image'];
                $condition_array = array(
                    'path' => $this->categoryDir,
                    'extention' => 'jpeg|jpg|png',
                    'redirect_url' => 'admin/category/add',
                );
				//echo "<pre>";print_r($condition_array);exit;
                $iconImg = $this->Common_Model->uploadFile($catImages, $condition_array);
                $categoryInfo['thum_image'] = $iconImg;
            }try{
                $this->Category_model->insert($categoryInfo, FALSE);
                setMessage('Category added Successfully', 'success');
                redirect('admin/category', 'refresh');
            } catch (Exception $ex) {
                $sdata['message'] = 'Category not added! Please Try again';
                $flashdata = array(
                    'flashdata' => $sdata['message'],
                    'message_type' => 'error'
                );
                $this->session->set_userdata($flashdata);
                redirect('admin/category', 'refresh');
            }
        }

        $category = $this->Category_model->as_dropdown('category_name')->get_all();
         $data = array(
            'title' => 'Affiliate Category',
            'list_heading' => 'Add Category',
            'category' => $category
        );
		
        $this->template->load('admin/base', 'admin/category/add', $data);
    }

    

    function edit($id = null){
        if (!empty($id)) {
            $edit_data = $this->Category_model->get($id);
        }

        $data = $this->input->post();
        if (!empty($data)){
            $category_data = returnValidData('tbl_category', $data);
            $name = !empty($data['name']) ? $data['name'] : '';
            $slug = url_title($name, 'dash', true);
			$category_data['category_name'] = $name;
            $category_data['slug_url'] = $slug;
            $category_data['description'] = !empty($data['description']) ? $data['description'] : '';
             if(!empty(trim($_FILES['image']['name']))) { 
                $catImages['image'] = $_FILES['image'];
                $condition_array = array(
                    'path' => $this->categoryDir,
                    'extention' => 'jpeg|jpg|png',
                    'redirect_url' => 'admin/category/edit/'.$id,
                );

                $iconImg = $this->Common_Model->uploadFile($catImages, $condition_array);
                $category_data['thum_image'] = $iconImg;
            }

            try{
                $ab = $this->Category_model->update($category_data, $id);
                if ($ab) {
                    setMessage('Category Updated Successfully', 'success');
                    redirect('admin/category', 'refresh');
                }else{
                     setMessage('Category Not Updated Successfully ! Something went wrong', 'warning');
                     redirect('admin/category', 'refresh');
                }

            }catch(Exception $ex) {
                setMessage('Category not updated! Please Try again','warning');
                redirect('admin/category', 'refresh');
            }
        }
        $category = $this->Category_model->as_dropdown('category_name')->get_all();
        $data = array(
            'title' => 'Update Category',
            'list_heading' => 'Update Category',
            'category' => $category,
            'edit_data' => $edit_data,			
        );		
		$this->template->load('admin/base', 'admin/category/edit', $data);
    }
	
	
	function deleteCategory($id=''){
		$deteledRecord = $this->Category_model->deleteRecord($_POST[id]);
		return $deteledRecord;
	}

	function changeStatus($id,$status=''){
	    if(is_numeric($id)){
			if($status==1){   
				$update_data  = array('status'=>1);
				$ab = $this->Category_model->update($update_data, $id);
				echo 1;
			}else{
				$update_data  = array('status'=>0);
				$ab = $this->Category_model->update($update_data, $id); 
				echo 0;
			}
		}else{
			 return false;
		}
	}
}



?>