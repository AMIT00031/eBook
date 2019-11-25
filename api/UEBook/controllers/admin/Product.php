<?php
Class Product extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library(array('form_validation'));
       // $this->lang->load('english');
	    $this->load->model('admin/Product_model');
        $this->load->model('admin/Category_model');
        //$this->load->model('admin/Category_gallery_model');
        $this->productDir = $this->config->item('upload_product_image');
    }

    public function index() {
        /* if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        } */
		
        $list = $this->Product_model->get_all();
		//   dump($list);die;
        $data = array(
            'title' => 'Proudct',
            'list_heading' => 'Proudct',
            'lists' => $list,
        );
        $this->template->load('admin/base', 'admin/product/list', $data);
    }


    function addedit($id = null){
        if(!empty($id)) {
            $edit_data = $this->Product_model->get($id);
            //print_r($edit_data);die;
        }
        $data = $this->input->post();
		//echo"<pre>";print_r($data); die;
		
        if (!empty($data)){
            $all_data = returnValidData('tbl_books', $data);
            $name = !empty($data['name']) ? $data['name'] : '';
			$category_id = !empty($data['category_id']) ? $data['category_id'] : '';
			$category_data =  explode("=====",$category_id);
			$all_data['category_id']   = $category_data[0];
			$all_data['category_name'] = $category_data[1];
			$all_data['book_title'] = $name;
            $slug = url_title($name, 'dash', true);
            $all_data['book_slug'] = $slug;
            $all_data['book_description'] = !empty($data['description']) ? $data['description'] : '';
            $all_data['author_name'] = !empty($data['authorName']) ? $data['authorName'] : '';
            $all_data['isbn_number'] = !empty($data['ISBNNumber']) ? $data['ISBNNumber'] : '';
            $all_data['user_id'] = !empty($data['UserId']) ? $data['UserId'] : '';
           
             if(!empty(trim($_FILES['image']['name']))) { 
                $catImages['image'] = $_FILES['image'];
				if($id!=''){
					$red_url = 'admin/product/addedit/'.$id;
				}else{
				   $red_url = 'admin/product/addedit/';
				}
                $condition_array = array(
                    'path' => $this->productDir,
                    'extention' => 'jpeg|jpg|png',
                    'redirect_url' =>$red_url,
                );
				
                $iconImg = $this->Common_Model->uploadFile($catImages, $condition_array);
                $all_data['thubm_image'] = $iconImg;
            }
            try {
				if($id!=''){
					$ab = $this->Product_model->update($all_data, $id);
				}else{
					$ab = $this->Product_model->insert($all_data, FALSE);
				}

                if ($ab) {

                    setMessage('Proudct Updated Successfully', 'success');
                    redirect('admin/product', 'refresh');

                }else{
                     setMessage('Product Not Updated Successfully ! Something went wrong', 'warning');
                     redirect('admin/product', 'refresh');
                }

            } catch (Exception $ex) {
                setMessage('Category not updated! Please Try again','warning');
                redirect('admin/category', 'refresh');
            }
        }
		
        $category = $this->Category_model->as_dropdown('category_name')->get_all();
		
        $UserList = $this->Product_model->getAllUserList();
		$models = $this->Category_model->as_dropdown('category_name')->get_all();
		
        $data = array(
            'title' => 'Add/Edit Product',
            'list_heading' => 'Update Product',
            'category' => $category,
            'models' => $models,
            'edit_data' => $edit_data,
            'user_data' => $UserList,
        );
		
		//echo "<pre>";print_r($data);exit;
		$this->template->load('admin/base', 'admin/product/addedit', $data);
    }
	
	function changeStatus($id,$status=''){
	    if(is_numeric($id)){
			if($status==1){   
				$update_data  = array('status'=>1);
				$ab = $this->Product_model->update($update_data, $id);
				echo 1;
			}else{
				$update_data  = array('status'=>0);
				$ab = $this->Product_model->update($update_data, $id);
				echo 0;
			}
		}else{
			 return false;
		}
	}

}
?>