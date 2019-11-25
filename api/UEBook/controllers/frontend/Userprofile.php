<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Userprofile extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
   function __construct() {
        parent::__construct();
		
	   // $this->load->database();
		//$this->load->library("layouts");
		
       /*  $this->load->model('admin/blog_model');
        $this->load->model('admin/banner_model');
        $this->load->model('admin/home_wiget_model');
        $this->load->model('admin/testimonial_model');
        $this->load->model('admin/footer_wiget_model');
        $this->load->model('admin/subscriber_model');
        $this->load->model('admin/menu_manager_model');
        $this->load->model('frontend/customer_inquiry_model');
        //$this->load->model('inventory_model'); */
      //  $this->load->model('admin/frontuser_model');
		$this->load->model('frontuser_model');
		$this->load->model('common_model');
        $this->load->model('admin/cms_model');
        
    }
	
	public function checkUser(){
	  if($this->session->userdata('userId')==''){
		  redirect(base_url().'login'); 
	  }else{
         return $this->session->userdata('userId');	 
	  }
	}

	
	public function index(){
    	$userId     =   $this->checkUser();
    	$userprofile    =  $this->frontuser_model->getUserDetail($userId);
  
	
	
		$data = array(
				'title' => 'User Profile',
				'userprofi' => $userprofile,
		);
		$this->template->load('front/front_layout', 'frontend/user/profile', $data);	
	}
	
	public function user_list(){
		
		$userId     =   $this->checkUser();
		$data = array(
			'title' => 'Invenotry List',
		);
		//$this->session->userdata('inv_id');
		$data['inventory_list']     =  $this->inventory_model->getAllRecord('inventory','',array('user_id'=>$userId));
		//$data['inv_detail']    		 =  $this->inventory_model->getAllRecord($this->session->userdata('inv_id'));
		
		$this->template->load('front/front_layout', 'frontend/inventory/inventory_list_view', $data);	
	}
	
	
	public function thank_you() { 
	    $user_id     	=   $this->checkUser();	
		$data = array(
				'title' => 'Thank You',
		);
		$this->template->load('front/front_layout', 'frontend/inventory/thank-you', $data);
	}
	
	public function activate_account($user_id,$code) {

        $postData = $this->input->post();
        $code = !empty($code) ? $code : '';
        $user_id = !empty($user_id) ? $user_id : '';

        $user_data = array();
        $code_valid = $this->user_model->isValidCode($code, $user_id);
        $already_active = $this->user_model->isUserAlreadyActivated($user_id);
		
        if (!$code_valid) {
			
			$this->session->set_flashdata('message_error','Invalid code');
		    redirect(base_url().'login'); 
			
        } elseif ($already_active) {
			
            $this->session->set_flashdata('message_error','Already active, please login');
		    redirect(base_url().'login'); 
        
		} else {

            $update = array('active' => 1);
            $this->user_model->update($update, $user_id);
            $user_data = $this->user_model->get($user_id);
            if(!empty($user_data)){
				 $this->session->set_flashdata('message_success','Conguratulation! You are done please login here');
				 redirect(base_url().'login'); 
			}
            /* if (!empty($user_data->photo)) {
                $user_data->image_path = base_url('uploads/users/' . $user_data->photo);
            } else {
                $user_data->image_path = NULL;
            } 

            $response = array(
                'result' => $user_data,
                'status' => TRUE,
                'message' => 'Your account is successfully activated'
            );
            $this->set_response($response, REST_Controller::HTTP_OK);*/
        }
    }	
	
	public function login() {
        $data 		= array();
        
		$postData 	= $this->input->post();
		
		//$userId     =   $this->checkUser();
		
        if ($postData) {
//            dump($postData);die;
            $this->form_validation->set_rules('email_login', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('location_code', 'location', 'required');

            $email	  	= $postData['email_login'];
            $location 	= md5($postData['location_code']);
           
		   if ($this->form_validation->run() == true) {
				
                /* echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">';
                echo '<scriptsrc="https://code.jquery.com/jquery-2.2.4.min.js"integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="crossorigin="anonymous"></script>';
                echo '<script src="' . base_url('assets/front/js/sweetalert.min.js') . '"></script>'; */
				
                $checkLogin = $this->user_model->where(array('email' => $email, 'password' => $location, 'status' => 1, 'active' => 1))->get();
                if (!empty($checkLogin)) {
                    $userEmail = !empty($checkLogin->email) ? $checkLogin->email : '';
                    $this->session->set_userdata('isUserLoggedIn', TRUE);
                    $this->session->set_userdata('userEmail', $checkLogin->email);
                    $this->session->set_userdata('userId', $checkLogin->id);
                    //$this->session->set_userdata('userName', $user_name);
					if( $this->session->userdata('userEmail') && $this->session->userdata('isUserLoggedIn' ) ) {
						//$this->session->set_flashdata('message','Already active, please login');
						redirect(base_url().'dashboard'); 
					}else{
						$this->session->set_flashdata('message_error','Opps! Somethng went wrong, please try again');
						redirect(base_url().'login');
					}
				}else{
					
					$this->session->set_flashdata('message_error','Opps! Invalid email address or password');
					redirect(base_url().'login');
				}
			
			}

			$data = array(
				'title' => 'Login',
			);

		}
		$this->template->load('front/front_layout', 'frontend/home/index', $data);	
	}

    public function dashboard(){
		
		$userId     =   $this->checkUser();
		$data = array(
				'title' => 'My account',
		);
		$this->template->load('front/front_layout', 'frontend/user/dashboard', $data);	
	}
	
	

    function logout() {
        
        $this->session->unset_userdata('isUserLoggedIn');
        $this->session->unset_userdata('userId');
        $this->session->unset_userdata('userName');
		$this->session->unset_userdata('userEmail');
        $this->session->unset_userdata('oauth_provider');
        $this->session->unset_userdata('oauth_uid');
		
		$this->session->set_flashdata('message_success','logout successfully');
		redirect(base_url().'login');					
       
    }
	
	 public function login_old() {
        $data = array();
        $postData = $this->input->post();
        if ($postData) {
//            dump($postData);die;
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'password', 'required');

            $email = $postData['email'];
            $password = md5($postData['password']);
            if ($this->form_validation->run() == true) {
                echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">';
                echo '<scriptsrc="https://code.jquery.com/jquery-2.2.4.min.js"integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="crossorigin="anonymous"></script>';
                echo '<script src="' . base_url('assets/front/js/sweetalert.min.js') . '"></script>';
                $checkLogin = $this->agent_model->where(array('email' => $email, 'password' => $password))->get();
                if ($checkLogin) {
                    $user_name = !empty($checkLogin->username) ? $checkLogin->username : '';
                    $this->session->set_userdata('isUserLoggedIn', TRUE);
                    $this->session->set_userdata('userId', $checkLogin->id);
                    $this->session->set_userdata('userName', $user_name);
                    $redirectUrl = base_url() . '?login=true';
                    echo '<script>
                         swal({
                            title: "Success",
                            text: "You are successfully logged in",
                            type: "success"
                        }, function() {
                            window.location = "' . $redirectUrl . '"
                            });
                </script>';
                    exit;
                } else {
                    echo '<script>
                         swal({
                            title: "Error",
                            text: "Invalid email address and password",
                            type: "error"
                        }, function() {
                            window.location = "' . current_url() . '"
                            });
                </script>';
                    exit;
                }
            } else {
                echo '<script>
                         swal({
                            title: "Error",
                            text: "Oops something went wrong",
                            type: "error"
                        }, function() {
                            window.location = "' . current_url() . '"
                            });
                </script>';
                exit;
            }
        }

        $data = array(
            'title' => 'Agent Login',
        );

        $this->template->load('front/front_layout', 'frontend/agent/login', $data);
    }
    function edit($inv_id){
        $tbl_name = 'users';
        
        $userId     =   $this->checkUser();
        $post = $this->input->post();
        if (!empty($post)) {            
            if($this->form_validation->run('frontuser')== TRUE){
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
                $updateTrue = $this->frontuser_model->updateRecord($tbl_name,$post,$userId);
                if($updateTrue){
                    $this->session->set_flashdata('message_error','Data has been successfully updated');
                    redirect(base_url().'userprofile');                    
                }else{
                    $this->session->set_flashdata('message_error','Opps! something went wrong, please try again');
                    $data['message_error'] = 'Opps! something went wrong, please try again';
                    redirect(base_url().'userprofile/edit');                    
                }                       
            }               
        }
        $userprofile    =  $this->frontuser_model->getUserDetail($userId);
        $data = array(
                'title' => 'User Profile',
                'userprofi' => $userprofile,
        );
          
        $this->template->load('front/front_layout', 'frontend/user/profile-edit', $data);
        
    }
		
	
}
