<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

/**
 * @author : Jeevan<jeevan@seoessenc.com>
 * @date : 29-oct-2018
 * @objective : Get all information about an user 
 */
class Users extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->userDir = $this->config->item('upload_user_image');
    }

    public function getuser_get() {
        $id = $this->get('id');
        $id = (int) $id;
        if ($id <= 0) {
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $user = $this->user_model->get($id);
        if (!empty($user->photo)) {
            $user->image_path = base_url('uploads/users/' . $user->photo);
        } else {
            $user->image_path = NULL;
        }
        if (!empty($user)) {
            $this->set_response($user, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response([
                'status' => '0',
                'message' => 'User could not be found'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function create_user_post() {
        $postData = $this->input->post();
        $email = !empty($postData['email']) ? $postData['email'] : '';

        $username = !empty($postData['username']) ? $postData['username'] : '';
        $password = !empty($postData['password']) ? md5($postData['password']) : '';

        $condition = array('email' => trim($email));
        $user = $this->user_model->where($condition)->get();

        if (!empty($user)) {
            $this->set_response([
                'status' => '0',
                'message' => 'This email id already exist! please try another one.'
                    ], REST_Controller::HTTP_CONFLICT);
            return;
        }

        $postData['password'] = $password;
        $user_id = $this->user_model->insert($postData);
        if ($user_id) {

            $response = array(
                'id' => $user_id, // Automatically generated by the model
                'status' => '1',
                'message' => 'User created successfully'
            );
            $this->set_response($response, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        } else {
            $response = array(
                'status' => '0',
                'message' => 'User not created.Something went wrong'
            );
            $this->set_response($response, REST_Controller::HTTP_BAD_REQUEST); // CREATED (201) being the HTTP response code
        }
    }

    public function login_post() {
        $postData = $this->input->post();

        $email = !empty($postData['email']) ? trim($postData['email']) : '';
        $password = !empty($postData['password']) ? md5($postData['password']) : '';
        $device_id = !empty($postData['device_id']) ? $postData['device_id'] : '';
          $device_uid = !empty($postData['device_uid']) ? $postData['device_uid'] : '';
            $device_VOIPID = !empty($postData['device_VOIPID']) ? $postData['device_VOIPID'] : '';
 $device_type = !empty($postData['device_type']) ? $postData['device_type'] : '';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->set_response([
                'status' => '0',
                'message' => 'Invalid email format'
                    ], REST_Controller::HTTP_OK); // NOT_FOUND (40) being the HTTP response code
        }

        $accountExist = $this->user_model->checkAccountExist($email);
        if (!$accountExist) {
            $this->set_response([
                'status' => '0',
                'message' => 'your account has been unavailable please contact to support representative.'
                    ], REST_Controller::HTTP_OK); // NOT_FOUND (40) being the HTTP response code
        }

        $checkLogin = $this->user_model->where(array('email' => $email, 'password' => $password))->get();
//        dump($checkLogin);
//        die;  

        if ($checkLogin) {
// print_r($device_id); exit;
            if (!empty($device_id)) {
                $updateData = array('device_id' => $device_id,'device_uid' => $device_uid,'device_VOIPID' => $device_VOIPID,'device_type' => $device_type);
               
                $result = $this->user_model->where('id', $checkLogin->id)->update($updateData);
            }
$checkLoginup = $this->user_model->where(array('email' => $email, 'password' => $password))->get();
            $this->set_response([
                'status' => '1',
                'response' => $checkLoginup
                    ], REST_Controller::HTTP_OK);
        } else {
            $this->set_response([
                'status' => '0',
                'message' => 'Invalid credentials please try again'
                    ], REST_Controller::HTTP_OK);
        }
    }

    public function update_user_post() {
        $postData = $this->input->post();

        $id = !empty($postData['user_id']) ? $postData['user_id'] : '';

        $email = !empty($postData['email']) ? $postData['email'] : '';
        $username = !empty($postData['username']) ? $postData['username'] : '';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->set_response([
                'status' => '0',
                'message' => 'Invalid email format'
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (40) being the HTTP response code
        }


        if (!empty($_FILES['image']['name'])) {
            $userImages['image'] = $_FILES['image'];

            $condition_array = array(
                'path' => $this->userDir,
                'extention' => 'jpeg|jpg|png',
                'redirect_url' => '',
            );

            $user_image = $this->Common_Model->uploadFile($userImages, $condition_array);
            $postData['photo'] = $user_image;
        }

        $user_id = $this->user_model->update($postData, $id);
        $userData = $this->user_model->get($id);
        if (!empty($userData->photo)) {
            $userData->image_path = base_url('uploads/users/' . $userData->photo);
        }

        if ($user_id) {
            $response = array(
                'result' => $userData, // Automatically generated by the model
                'status' => '1',
                'message' => 'User updated successfully'
            );
            $this->set_response($response, REST_Controller::HTTP_OK);
        } else {
            $response = array(
                'result' => $userData, // Automatically generated by the model
                'status' => '0',
                'message' => 'Something went wrong'
            );
            $this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function change_password_post() {
        $postData = $this->input->post();

        $id = !empty($postData['user_id']) ? $postData['user_id'] : '';
        $current_password = !empty($postData['current_password']) ? $postData['current_password'] : '';
        
        $userExist = $this->user_model->get($id);
        
        if(empty($userExist)){
            $this->set_response([
                'status' => '0',
                'message' => 'User not exist with this id please try again.'
                    ], REST_Controller::HTTP_OK); // NOT_FOUND (40) being the HTTP response code
            return;
        }
        
        $updateArray = array(
            'password' => md5($current_password)
        );
        $res = $this->user_model->update($updateArray, $id);

        if ($res) {
            $response = array(
                'status' => '1',
                'message' => 'password changed successfully'
            );
            $this->set_response($response, REST_Controller::HTTP_OK);
        } else {
            $response = array(
                'status' => '1',
                'message' => 'password not changed something went wrong'
            );
            $this->set_response($response, REST_Controller::HTTP_OK);
        }
    }

    public function update_activation_code_post() {

        $postData = $this->input->post();
        $code = !empty($postData['code']) ? $postData['code'] : '';
        $user_id = !empty($postData['id']) ? $postData['id'] : '';

        $user_data = array();
        $code_valid = $this->user_model->isValidCode($code, $user_id);

        $already_active = $this->user_model->isUserAlreadyActivated($user_id);
        if (!$code_valid) {
            $response = array(
                'status' => '0',
                'message' => 'Code is not valid! Please try again'
            );
            $this->set_response($response, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
            return;
        } elseif ($already_active) {
            $response = array(
                'status' => '0',
                'message' => 'User already activated'
            );
            $this->set_response($response, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
            return;
        } else {


            $update = array('active' => 1);
            $this->user_model->update($update, $user_id);

            $user_data = $this->user_model->get($user_id);

            if (!empty($user_data->photo)) {
                $user_data->image_path = base_url('uploads/users/' . $user_data->photo);
            } else {
                $user_data->image_path = NULL;
            }

            $response = array(
                'result' => $user_data,
                'status' => '1',
                'message' => 'Your account is successfully activated'
            );
            $this->set_response($response, REST_Controller::HTTP_OK);
        }
    }

    public function forget_password_post() {
        $updateArray = array();
        $postData = $this->input->post();
        $email = !empty($postData['email']) ? $postData['email'] : '';
        $where = array('email' => $email);
        $user = $this->user_model->fields('id,email,username')->where($where)->get();

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->set_response([
                'status' => '0',
                'message' => 'Invalid email format'
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (400) being the HTTP response code
            return;
        }

        if (empty($user)) {
            $response = array(
                'status' => '0',
                'message' => 'User not exist please try another one.'
            );
            $this->set_response($response, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
            return;
        }

        //sent mail to user
        $uname = $user->username;
        $uId = $user->id;
        $password = mt_rand(10000, 99999);
        $hashpassword = md5($password);
        $admin_email = $this->config->item('admin_email');

        $subject = "Oilbizz-Password Recovery";
        $message = "
                <html>
                <head>
                <title>Password Recovery</title>
                </head>
                <body>
                <p>Hi, " . $uname . "</p>
                <h3 style='text-align:center;'>Your new password is :</h3><br> <p style='padding:10px;font-size:25px;text-align:center;'>" . $password . "<p>
                 Regards Team:<br>Oilbizz
                </body>
                </html>";

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: Oilbizz <dnddemo.com@noreply>' . "\r\n";
        $headers .= 'Reply-To: ' . $admin_email . "\r\n";
        $headers .= 'X-Mailer: PHP/' . phpversion();
        $sent = mail(trim($email), $subject, $message, $headers);
        if ($sent) {
            $updateArray = array('password' => $hashpassword);
            $res = $this->user_model->update($updateArray, $uId);
            if ($res) {
                $response = array(
                    'status' => '1',
                    'message' => 'An password recovery mail is sent to your email address please check it.'
                );
                $this->set_response($response, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
            } else {
                $response = array(
                    'status' => '0',
                    'message' => 'something went wrong.'
                );
                $this->set_response($response, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
            }



            return;
        } else {
            $response = array(
                'status' => '0',
                'message' => 'mail not sent something went wrong.'
            );
            $this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function social_login_post() {
        $postData = $this->input->post();

        $email = !empty($postData['email']) ? trim($postData['email']) : '';
        $provider = !empty($postData['oauth_provider']) ? trim($postData['oauth_provider']) : '';
        $oauth_uid = !empty($postData['oauth_uid']) ? trim($postData['oauth_uid']) : '';
        $device_id = !empty($postData['device_id']) ? $postData['device_id'] : '';
    $device_uid = !empty($postData['device_uid']) ? $postData['device_uid'] : '';
     $device_type = !empty($postData['device_type']) ? $postData['device_type'] : '';
            $device_VOIPID = !empty($postData['device_VOIPID']) ? $postData['device_VOIPID'] : '';
        $accountExist = $this->user_model->checkAccountExist($email);

        try {
            if (!$accountExist) {
                $user_id = $this->user_model->insert($postData, false);
                $result = $this->user_model->get($user_id);

                $this->set_response([
                    'status' => '1',
                    'response' => $result
                        ], REST_Controller::HTTP_OK);
            } else {
                $updateArray = array(
                    'oauth_provider' => $provider,
                    'oauth_uid' => $oauth_uid,
                    'device_id' => $device_id,
                      'device_uid' => $device_uid,
                        'device_VOIPID' => $device_VOIPID,
                         'device_type' => $device_type,
                );

                $this->user_model->where('email', $email)->update($postData);

                $result = $this->user_model->where('email', $email)->get();
                $this->set_response([
                    'status' => '1',
                    'response' => $result
                        ], REST_Controller::HTTP_OK);
            }
        } catch (Exception $exc) {
            $this->set_response([
                'status' => '0',
                'message' => 'something went wrong'
                    ], REST_Controller::HTTP_OK);
        }
    }

    public function change_password_by_email_post() {
        $postData = $this->input->post();
        $email = !empty($postData['email']) ? $postData['email'] : '';
        $current_password = !empty($postData['password']) ? $postData['password'] : '';
        
        $accountExist = $this->user_model->checkAccountExist(trim($email));
        if (!$accountExist) {
            $this->set_response([
                'status' => '0',
                'message' => 'your account has been unavailable please contact to support representative.'
                    ], REST_Controller::HTTP_OK);
            return;
        }
        
        $updateArray = array(
            'password' => md5($current_password)
        );
        $res = $this->user_model->where('email', $email)->update($updateArray);

        if ($res) {
            $response = array(
                'status' => '1',
                'message' => 'password changed successfully'
            );
            $this->set_response($response, REST_Controller::HTTP_OK);
        } else {
            $response = array(
                'status' => '0',
                'message' => 'password not changed something went wrong'
            );
            $this->set_response($response, REST_Controller::HTTP_OK);
        }
    }

    function create_payload_json($message, $title) {
        $badge = "0";
        $sound = 'default';
        $payload = array();
        $payload['aps'] = array('message' => $message, 'title' => $title, 'badge' => intval($badge), 'sound' => $sound);
        return json_encode($payload);
    }
   public function getuserdetails_get() {
       $user_id = $this->input->get('user_id');
      $userdetails = $this->user_model->getuserdetails_select($user_id); 
   //   print_r( $userdetails); exit;
           if (!empty($userdetails)) {
            $this->set_response([
                'status' => '1',
                'total_records' => count($userdetails),
                'result' => $userdetails,
                    ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        } else {
            $this->set_response([
                'status' => '0',
                'message' => 'No Users found'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
   }
   
    public function edituserdetail_post() {
        $postData = $this->input->post();
        $user_id = !empty($postData['user_id']) ? $postData['user_id'] : '';
            $upload_path = 'uploads/img/';
            $userdetails = $this->user_model->getuserdetails_select($user_id);
            
            if (!empty($_FILES['profilephoto']['name'])) {
           
                $fileinfo = pathinfo($_FILES['profilephoto']['name']);
                $extension = $fileinfo['extension'];

                $file_name = 'prof_' . time() . '.' . $extension;
                $file_path = $upload_path . $file_name;
                move_uploaded_file($_FILES['profilephoto']['tmp_name'], $file_path);
            } else { $file_name=$userdetails->profilephoto;}
            if (!empty($_FILES['resume']['name'])) {
                $upload_pathres = 'uploads/resume/';
                $fileinfores = pathinfo($_FILES['resume']['name']);
                $extensionres = $fileinfores['extension'];
                $file_nameres = 'res_' . time() . '.' . $extensionres;
                $file_pathres = $upload_pathres . $file_nameres;
                move_uploaded_file($_FILES['resume']['tmp_name'], $file_pathres);
            } else { 
                $file_pathres=$userdetails->resume;
            }
            $user_id = !empty($postData['user_id']) ? $postData['user_id'] : $userdetails->id;
            $username = !empty($postData['username']) ? $postData['username'] : $userdetails->username;
            $email = !empty($postData['email']) ? $postData['email'] : $userdetails->email;
            $phone = !empty($postData['phone']) ? $postData['phone'] : $userdetails->phone;
            $user_type = !empty($postData['user_type']) ? $postData['user_type'] : $userdetails->user_type;
            $profilephoto = !empty($file_name) ? $file_name : $userdetails->profilephoto;
            $resume = !empty($file_nameres) ? $file_nameres : $userdetails->resume;
            $data = array(
                'user_id' => $user_id,
                'username' =>  $username,
                'email' =>  $email,
                'phone' =>  $phone,
                'user_type' =>  $user_type,
                'profilephoto' =>  $profilephoto,
                'resume' =>  $resume,
            );
            $res = $this->user_model->edituser_update($data);
            if($res === FALSE){
       
               $response = array(
                    'status' => '0',
                    'message' => 'Update Un successfully'
                );
                $this->set_response($response, REST_Controller::HTTP_BAD_REQUEST); // CREATED (201) being the HTTP response code
            } else {
           
                $response = array(
                    'status' => '1',
                    'message' => 'Update successfully.'
                );
                $this->set_response($response, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
            }      
        }
    
    
    public function contactuser_post() {
        $postData = $this->input->post();
        $id = !empty($postData['user_id']) ? $postData['user_id'] : '';
        $userdetails = $this->user_model->getusercontactusdetails_select($id);
        if (!empty($userdetails)) {
            $this->set_response([
                'status' => '1',
                'total_records' => count($userdetails),
                'result' => $userdetails,
                    ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        } else {
            $this->set_response([
                'status' => '0',
                'message' => 'No job found'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
}