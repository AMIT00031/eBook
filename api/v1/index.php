<?php
require_once '../include/DbOperation.php';
require_once '../include/Braintree_lib.php';
require '.././libs/Slim/Slim.php';
\Slim\Slim::registerAutoloader();

define("ROOT_FOLDER","/ebooks/development/");
define("DOCUMENTROOT",$_SERVER['DOCUMENT_ROOT'].ROOT_FOLDER);

$app = new \Slim\Slim();
$app->post('/createUser', function () use ($app) {

 ///echo "<pre>";print_r($_POST);exit('signup');
    $_['en_create_user_msg1'] = "You are successfully registered";
    $_['en_create_user_msg2'] = "Oops! An error occurred while registereing";
    $_['en_create_user_msg3'] = "Sorry, this user  already existed";
    verifyRequiredParams(array('email','user_name'));
    $response = array();
    $full_name = $app->request->post('full_name');
    $password = $app->request->post('password');
    $email = $app->request->post('email');
    $phone_no = $app->request->post('phone_no');
    $device_token = $app->request->post('device_token');
    $device_type = $app->request->post('device_type');
    $random_number = mt_rand(100000, 999999);
    $lang = 'en';
    $country = $app->request->post('country');
    $gender = $app->request->post('gender');
    $publisher_type = $app->request->post('publisher_type');
    $user_name = $app->request->post('user_name');
        $upload_path = 'upload/';
        $fileinfo = pathinfo($_FILES['image']['name']);
        $extension = $fileinfo['extension'];
        $file_url = $upload_url . 'pic_' . time() . '.' . $extension;
        $file_path = $upload_path . 'pic_' . time() . '.' . $extension;
        move_uploaded_file($_FILES['image']['tmp_name'], $file_path);

    $db = new DbOperation();
    $res = $db->createUser($full_name, $password, $email, $phone_no,$file_url, $device_token, $device_type, $random_number, $country, $gender, $publisher_type, $user_name);
        $resParse = explode('&', $res);
        $user_id = $resParse[0];
        $email = $resParse[1];
        $phone_no = $resParse[2];
        $full_name = $resParse[3];
        $res = $resParse[4];

    if($res == 0){
        $response["error"] = false;
        $response["user_id"] = $user_id;
        $response["email"] = $email;
        $response["phone_no"] = $phone_no;
        $response["full_name"] = $full_name;
        $users = $db->getUserInfo($user_id);
        $response['user_data'] = $users;
        $response["message"] = $_[$lang . '_create_user_msg1'];
        echoResponse(201, $response);
    } else if($res == 1){
        $response["error"] = true;
        $response["message"] = $_[$lang . '_create_user_msg2'];
        echoResponse(200, $response);
    } else if($res == 2){
        $response["error"] = true;
        $response["user_id"] = $user_id;
        $response["email"] = $email;
        $response["phone_no"] = $phone_no;
        $response["full_name"] = $full_name;
        $users = $db->getUserInfoOnEmail($email);
        $response['user_data'] = $users;
        $response["message"] = $_[$lang . '_create_user_msg3'];
        echoResponse(200, $response);
    }
});


/**
 * URL: http://dnddemo.com/ebooks/api/v1/userLogin
 * Parameters: user_name, password
 * Method: POST
 * */

$app->post('/userLogin', function () use ($app) {
    $_['en_login_msg'] = "Invalid username or password";
    verifyRequiredParams(array('password'));
    $email = $app->request->post('email');
    $user_name = $app->request->post('user_name');
    $password = $app->request->post('password');
    $device_token = $app->request->post('device_token');
    $device_type = $app->request->post('device_type');
    $lang = 'en';
    $db = new DbOperation();
    $response = array();
    if ($db->userlogin($email, $user_name, $password, $device_token, $device_type)){
        $users = $db->getUser($email, $user_name, $password);
        $response['error'] = false;
        $response['response'] = $users;
       
    }else{
        $response['error'] = true;
        $response['message'] = $_[$lang . '_login_msg']; //"Invalid username or password";
    }
    echoResponse(200, $response);
});

/**
 * URL: http://dnddemo.com/ebooks/api/v1/getUserInfo
 * Parameters: user_id
 * Method: POST
 * */

$app->post('/getUserInfo', function() use ($app) {
    verifyRequiredParams(array('user_id'));
    $user_id = $app->request->post('user_id');
    $_['en_getUserInfo'] = "Invalid username or password";
    $lang = 'en';
    $db = new DbOperation();
    $response = array();
    $res = $db->getUserInfo($user_id);
    if($res!= 1){
        $response['error'] = false;
        $response['response'] = $res;
    }else{
        $response['error'] = true;
        $response['message'] = $_[$lang . '_getUserInfo'];
    }
    echoResponse(200, $response);
});


/**
 * URL: http://dnddemo.com/ebooks/api/v1/userEdit
 * Parameters: user_id
 * Method: POST
 * */

$app->post('/userEdit', function () use ($app) {
    verifyRequiredParams(array('user_id'));
    $_['en_oops_error'] = "Oops! some error occurs.";
    $_['en_userEdit'] = " Profile successfully updated.";

        $user_id = $app->request->post('user_id');
        $full_name = $app->request->post('full_name');
        $phone = $app->request->post('phone');
        $address = $app->request->post('address');
    	$country = $app->request->post('country');
        $password = $app->request->post('password');
        $publisher_type = $app->request->post('publisher_type');
        $gender = $app->request->post('gender');
        $lang = 'en';
        $upload_path = 'upload/';
        $fileinfo = pathinfo($_FILES['profile_image']['name']);
        $extension = $fileinfo['extension'];
            if (!empty($extension)){
                $file_url = $upload_url . 'pic_' . time() . '.' . $extension;
                $file_path = $upload_path . 'pic_' . time() . '.' . $extension;
                move_uploaded_file($_FILES['profile_image']['tmp_name'], $file_path);
            }

        $db = new DbOperation();
        $response = array();
        $res = $db->userEdit($full_name, $address, $user_id, $file_url, $phone, $country, $password,$publisher_type, $gender);
        if ($res == 0) {
            $response["error"] = false;
            $response["message"] = $_[$lang . '_userEdit'];
            $users = $db->getUserInfo($user_id);
            $response['user_data'] = $users;
            echoResponse(201, $response);
        } else if ($res == 1) {
            $response["error"] = true;
            $response["message"] = $_[$lang . '_oops_error'];
            echoResponse(200, $response);
        }
});


/**
 * URL: http://dnddemo.com/ebooks/api/v1/updatePassword
 * Parameters: user_id,opass,npass
 * Method: POST
 * */

$app->post('/updatePassword', function () use ($app) {
    verifyRequiredParams(array('user_id'));
    $_['en_oops_error'] = "Oops! some error occurs.";
    $_['en_updatePassword'] = "Your password is updated successfully.";

    $user_id = $app->request->post('user_id');
    $opass = $app->request->post('opass');
    $npass = $app->request->post('npass');
    if ($app->request->post('language') != "") {
        $lang = $app->request->post('language');
    } else {
        $lang = 'en';
    }
    $db = new DbOperation();
    $response = array();

    $res = $db->updatePassword($user_id, $opass, $npass);
    if ($res == 0) {
        $response["error"] = false;
        $response["message"] = $_[$lang . '_updatePassword'];
        echoResponse(201, $response);
    } else if ($res == 1) {
        $response["error"] = true;
        $response["message"] = $_[$lang . '_oops_error'];
        echoResponse(200, $response);
    }
});


/**
 * URL: http://dnddemo.com/ebooks/api/v1/forgetPassword
 * Parameters: email,pass
 * Method: POST
 * */

$app->post('/forgetPassword', function () use ($app) {
    verifyRequiredParams(array('email'));
    $_['en_oops_error'] = "Oops! some error occurs.";
    $_['en_userEdit'] = "You are successfully updated.";
    $email = $app->request->post('email');
    $pass = $app->request->post('pass');
    $lang = 'en';
    $db = new DbOperation();
    $response = array();

    $res = $db->forgetPassword($email, $pass);
    if ($res == 0) {
        $response["error"] = false;
        $response["message"] = $_[$lang . '_userEdit'];
        echoResponse(201, $response);
    } else if ($res == 1) {
        $response["error"] = true;
        $response["message"] = $_[$lang . '_oops_error'];
        echoResponse(200, $response);
    }
});



/******************************************************************************* */

function echoResponse($status_code, $response){
    $app = \Slim\Slim::getInstance();
    $app->status($status_code);
    $app->contentType('application/json; charset=utf-8');
    echo json_encode($response);
}

function verifyRequiredParams($required_fields){
    $error = false;
    $error_fields = "";
    $request_params = $_REQUEST;

    if ($_SERVER['REQUEST_METHOD'] == 'PUT'){
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }

    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }
    if ($error) {
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error"] = true;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echoResponse(400, $response);
        $app->stop();
    }
}

$app->run();
