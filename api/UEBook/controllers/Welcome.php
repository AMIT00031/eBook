<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Welcome extends CI_Controller {

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
		
	    $this->load->database();
		//$this->load->library("layouts");
		
       /*  $this->load->model('admin/blog_model');
        $this->load->model('admin/banner_model');
        $this->load->model('admin/home_wiget_model');
        $this->load->model('admin/testimonial_model');
        $this->load->model('admin/footer_wiget_model');
        $this->load->model('admin/subscriber_model');
        $this->load->model('admin/menu_manager_model');
        $this->load->model('frontend/customer_inquiry_model');		*/
		$this->load->model('user_model');
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
	    
	    echo "Coming soon..."; die;
		if(!empty(trim($this->session->userdata('userId')))){
		  	redirect(base_url().'dashboard'); 
	  	} 
		$data 		= 	array();
        $userData 	= 	array();
        $postData 	= 	$this->input->post();
		//$userId     =   $this->checkUser(); 
        if ($postData) {
			//$user_detail =  $this->User_model->where( 'email','rahul@seoessence.com')->get_all();
			$user_detail = $this->user_model->checkAccountExist($this->input->post('email'));
			if($this->input->post('email') == $user_detail->email) {
			   $is_unique =  '|is_unique[users.email]';
			} else {
			   $is_unique =  '';
			} 
			
            $this->form_validation->set_rules('company_name', 'Company name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('user_type', 'User Type', 'trim|required|xss_clean');
			if($is_unique){
               $this->form_validation->set_rules('email', 'email already exists', 'trim|required|valid_email|xss_clean'.$is_unique);
			}else{
				$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
			}
            $this->form_validation->set_rules('location', 'Password', 'trim|required|xss_clean');
          
 		    if($this->form_validation->run()== TRUE){
			  
				$userData = array(
					'company_name' 	=> strip_tags($this->input->post('company_name')),
					'username' 		=> strip_tags($this->input->post('first_name')),
					'email' 		=> strip_tags($this->input->post('email')),
					'last_name'  	=> $this->input->post('last_name'),
					'user_type'  	=> $this->input->post('user_type'),
					'password' 		=> md5($this->input->post('location')),
					//'location' 		=> md5($this->input->post('location'))
					'location' 		=> $this->input->post('location'),
					'status' 		=> 1,
					'device_id' 	=> $this->input->ip_address()
				);
                
				$otp 						 = mt_rand(100000, 999999);
				$userData['activation_code'] = $otp;
				$user_id 					 = $this->user_model->insert($userData);
				if ($user_id) {
					//Send activation code
					$subject = "User Activation Code";
					$link = "<a href=".base_url()."activate-account/".$user_id."/".$otp."> Click here</a>";
					$message = "
						<html>
						<head>
						<title>Activatio code</title>
						</head>
						<body>
						<p>Hi " . $userData['username'] . ",</p>
						<h3>Your one time activation code is : " . $otp . "</h3>
						<h3>To activate account ".$link." </h3>
						<br><br>
						 Regards Team:<br>Oilbiz Global
						</body>
						</html>";
                    
					// Always set content-type when sending HTML email
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

					// More headers
					$headers .= 'From: Oilbiz Global <projectsdemoserver.com@noreply>' . "\r\n";
                    
					mail(trim($email), $subject, $message, $headers);
					
					$this->session->set_flashdata('message_success','You have been successfully registered, but require to activate your email');
					redirect(base_url().'login'); 
					
				}else{
					$this->session->set_flashdata('message_error','Opps, something went wrong! pleaes try again');
					//redirect(base_url().'login'); 
				}					
			}
				

		}
		$this->template->load('front/front_layout', 'frontend/index', $data);		
		   /*  if (!empty($_FILES['image']['name'])) {
				$userImages['image'] = $_FILES['image'];

				$condition_array = array(
					'path' => $this->userDir,
					'extention' => 'jpeg|jpg|png',
					'redirect_url' => '',
				);

				$user_image = $this->Common_Model->uploadFile($userImages, $condition_array);
				$postData['photo'] = $user_image;
			} */

    } 

    function design(){

    	$data 		= 	array();
        $userData 	= 	array();
        $postData 	= 	$this->input->post();
		//$userId     =   $this->checkUser(); 
        if ($postData) {
			//$user_detail =  $this->User_model->where( 'email','rahul@seoessence.com')->get_all();
			$user_detail = $this->user_model->checkAccountExist($this->input->post('email'));
			if($this->input->post('email') == $user_detail->email) {
			   $is_unique =  '|is_unique[users.email]';
			} else {
			   $is_unique =  '';
			} 
			
            $this->form_validation->set_rules('company_name', 'Company name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('user_type', 'User Type', 'trim|required|xss_clean');
			if($is_unique){
               $this->form_validation->set_rules('email', 'email already exists', 'trim|required|valid_email|xss_clean'.$is_unique);
			}else{
				$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
			}
            $this->form_validation->set_rules('location', 'Password', 'trim|required|xss_clean');
          
 		    if($this->form_validation->run()== TRUE){
			  
				$userData = array(
					'company_name' 	=> strip_tags($this->input->post('company_name')),
					'username' 		=> strip_tags($this->input->post('first_name')),
					'email' 		=> strip_tags($this->input->post('email')),
					'last_name'  	=> $this->input->post('last_name'),
					'user_type'  	=> $this->input->post('user_type'),
					'password' 		=> md5($this->input->post('location')),
					//'location' 		=> md5($this->input->post('location'))
					'location' 		=> $this->input->post('location'),
					'status' 		=> 1,
					'device_id' 	=> $this->input->ip_address()
				);
				$otp 						 = mt_rand(100000, 999999);
				$userData['activation_code'] = $otp;
				$user_id 					 = $this->user_model->insert($userData);
				
					 // $this->session->set_flashdata('message_error','Opps, something went wrong! pleaes try again');
					//redirect(base_url().'login'); 				
			}
		}
		$this->template->load('front/front_layout', 'frontend/design', $data);		
		  
		   /*  if (!empty($_FILES['image']['name'])) {
				$userImages['image'] = $_FILES['image'];

				$condition_array = array(
					'path' => $this->userDir,
					'extention' => 'jpeg|jpg|png',
					'redirect_url' => '',
				);

				$user_image = $this->Common_Model->uploadFile($userImages, $condition_array);
				$postData['photo'] = $user_image;
			} */


    }

    function steps(){
        
    	$data 		= 	array();
        $userData 	= 	array();
        $postData 	= 	$this->input->post(); 
		//$userId     =   $this->checkUser(); 
        
		$this->template->load('front/front_layout', 'frontend/steps', $data);		
		  

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
		if(!empty(trim($this->session->userdata('userId')))){
		  	redirect(base_url().'dashboard'); 
	  	}

        $data 		= array();
        
		$postData 	= $this->input->post();
        if ($postData) {
			//            dump($postData);die;
            $this->form_validation->set_rules('email_login', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('location_code', 'location', 'required');

            $email	  	= $postData['email_login'];
            $location 	= md5($postData['location_code']);
           
		    if ($this->form_validation->run() == true) {
                $checkLogin = $this->user_model->where(array('email' => $email, 'password' => $location, 'status' => 1, 'active' => 0))->get();
                if (!empty($checkLogin)) {
                    $userEmail = !empty($checkLogin->email) ? $checkLogin->email : '';
                    $user_name = !empty($checkLogin->username) ? $checkLogin->username.' '.$checkLogin->last_name : '';
                    $this->session->set_userdata('isUserLoggedIn', TRUE);
                    $this->session->set_userdata('userEmail', $checkLogin->email);
                    $this->session->set_userdata('userId', $checkLogin->id);
                    $this->session->set_userdata('userType', $checkLogin->user_type);
			        $this->session->set_userdata('profilePhoto', $profilephoto);
			        if( $this->session->userdata('userEmail') && $this->session->userdata('isUserLoggedIn' ) ) {
			        	if ($this->session->userdata('userType') == 1) {
							redirect(base_url().'global-recruitment-joblist'); 
			        	}else{
							redirect(base_url().'userprofile'); 
			        	}
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
	
	public function upload(){
		
		$userId     =   $this->checkUser();
		$data = array(
				'title' => 'Upload files',
		);
		$this->template->load('front/front_layout', 'frontend/user/upload', $data);	
	}

    function logout() {
        
        $this->session->unset_userdata('isUserLoggedIn');
        $this->session->unset_userdata('userType');
        $this->session->unset_userdata('userId');
        $this->session->unset_userdata('userName');
		$this->session->unset_userdata('userEmail');
        $this->session->unset_userdata('oauth_provider');
        $this->session->unset_userdata('oauth_uid');
		
		$this->session->set_flashdata('message_success','logout successfully');
		redirect(base_url().'login');
					
       
    }
    function loginjob() {

        $this->session->unset_userdata('isUserLoggedIn');
        $this->session->unset_userdata('userType');
        $this->session->unset_userdata('userId');
        $this->session->unset_userdata('userName');
		$this->session->unset_userdata('userEmail');
        $this->session->unset_userdata('oauth_provider');
        $this->session->unset_userdata('oauth_uid');
		redirect(base_url().'login');
	}
	public function register(){
		if(!empty(trim($this->session->userdata('userId')))){
		  	redirect(base_url().'dashboard'); 
	  	}
		$data 		= 	array();
        $userData 	= 	array();
        $postData 	= 	$this->input->post();
		//$userId     =   $this->checkUser(); 
        if ($postData) {
			//$user_detail =  $this->User_model->where( 'email','rahul@seoessence.com')->get_all();
			$user_detail = $this->user_model->checkAccountExist($this->input->post('email'));
			if($this->input->post('email') == $user_detail->email) {
			   $is_unique =  '|is_unique[users.email]';
			} else {
			   $is_unique =  '';
			} 
			
            $this->form_validation->set_rules('company_name', 'company name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('first_name', 'first Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('user_type', 'user Type', 'trim|required|xss_clean');
			if($is_unique){
               $this->form_validation->set_rules('email', 'email already exists', 'trim|required|valid_email|xss_clean'.$is_unique);
			}else{
				$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|xss_clean');
			}
            $this->form_validation->set_rules('password', 'password', 'trim|required|xss_clean');
          
 		    if($this->form_validation->run()== TRUE){
			  
				$userData = array(
					'company_name' 	=> strip_tags($this->input->post('company_name')),
					'username' 		=> strip_tags($this->input->post('first_name')),
					'email' 		=> strip_tags($this->input->post('email')),
					'last_name'  	=> $this->input->post('last_name'),
					'user_type'  	=> $this->input->post('user_type'),
					'password' 		=> md5($this->input->post('password')),
					'location' 		=> $this->input->post('location'),
					'location' 		=> $this->input->post('location'),
					'status' 		=> 1,
					'device_id' 	=> $this->input->ip_address()
				);
                
				$otp 						 = mt_rand(100000, 999999);
				$userData['activation_code'] = $otp;
				$user_id 					 = $this->user_model->insert($userData);
				if ($user_id) {
					//Send activation code
					$subject = "User Activation Code";
					$link = "<a href=".base_url()."activate-account/".$user_id."/".$otp."> Click here</a>";
					$message = "
						<html>
						<head>
						<title>Activatio code</title>
						</head>
						<body>
						<p>Hi " . $userData['username'] . ",</p>
						<h3>Your one time activation code is : " . $otp . "</h3>
						<h3>To activate account ".$link." </h3>
						<br><br>
						 Regards Team:<br>Oilbiz Global
						</body>
						</html>";
                    
					// Always set content-type when sending HTML email
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

					// More headers
					$headers .= 'From: Oilbiz Global <projectsdemoserver.com@noreply>' . "\r\n";
                    
					mail(trim($email), $subject, $message, $headers);
					
					$this->session->set_flashdata('message_success','You have been successfully registered, but require to activate your email');
					redirect(base_url().'login'); 
					
				}else{
					$this->session->set_flashdata('message_error','Opps, something went wrong! pleaes try again');
					//redirect(base_url().'login'); 
				}					
			}
				

		}
		$this->template->load('front/front_layout', 'frontend/home/signup', $data);		
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
		
	
}
