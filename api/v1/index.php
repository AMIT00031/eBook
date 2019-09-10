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
         //echo "<pre>";print_r($email);exit();
        $response["error"] = false;
        $users = $db->getUserInfoByEmail($email);
        $response['user_data'] = $users;
        $response["message"] = $_[$lang .'_create_user_msg3'];
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
        //echo "<pre>";print_r($users);exit();
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
        $address = $app->request->post('address');
    	$country = $app->request->post('country');
        $password = $app->request->post('password');
        $publisher_type = $app->request->post('publisher_type');
        $email = $app->request->post('email');
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
        $res = $db->userEdit($address, $user_id, $file_url, $country, $password,$publisher_type, $email);
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
 * URL: http://dnddemo.com/ebooks/api/v1/UpdatePrfilePic
 * Parameters: user_id
 * Method: POST
 * */ 

$app->post('/UpdatePrfilePic', function () use ($app) {
    verifyRequiredParams(array('user_id'));
    $_['en_oops_error'] = "Oops! some error occurs.";
    $_['en_userEdit'] = " Profile Picture updated successfully.";
        $user_id = $app->request->post('user_id');

        //echo "<pre>";print_r(base64_decode($_POST['profile_image']));exit('profile_image');
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
        $res = $db->userEditProfilePic($user_id, $file_url);
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


/**
 * URL: http://dnddemo.com/ebooks/api/v1/getAllCategory
 * Parameters: 
 * Method: POST
 * */

$app->post('/getAllCategory', function() use ($app) {
    $_['en_categorymsg'] = "listed all category successfully.";
    $lang = 'en';
    $db = new DbOperation();
    $response = array();
    $res = $db->allCategoryList();
    if($res!= 1){
        $response['error'] = false;
        $response['response'] = $res;
    }else{
        $response['error'] = true;
        $response['message'] = $_[$lang . '_categorymsg'];
    }
    echoResponse(200, $response);
});


/**
 * URL: http://dnddemo.com/ebooks/api/v1/addNewBook
 * Parameters: 
 * Method: POST
 * */


$app->post('/addNewBook', function () use ($app){
    /*echo "<pre>";print_r($_FILES);
    echo "<pre>";print_r($_POST);exit;*/
    verifyRequiredParams(array('user_id','category_id','book_title'));
    $response = array();  
    $user_id = $app->request->post('user_id');
    $category_id = $app->request->post('category_id');
    $book_title = $app->request->post('book_title');
    $book_description = $app->request->post('book_description');
    $author_name = $app->request->post('author_name');
    $status = $app->request->post('status');
            /****Cover image*/
            $upload_path = 'upload/books/';
            $fileinfo = pathinfo($_FILES['thubm_image']['name']);
            $extension = $fileinfo['extension'];
            $file_url = $upload_url.'book_'.time().'.'.$extension;
            $file_path = $upload_path .'book_'.time().'.'.$extension;
            move_uploaded_file($_FILES['thubm_image']['tmp_name'], $file_path);

            /****Document file*/
            $upload_path = 'upload/books/document/';
            $fileinfo = pathinfo($_FILES['pdf_url']['name']);
            $extension = $fileinfo['extension'];
            $pdf_url = $upload_url.'document_'.time().'.'.$extension;
            $file_path = $upload_path .'document_'.time().'.'.$extension;
            move_uploaded_file($_FILES['pdf_url']['tmp_name'], $file_path);

            /****audio file*/
            $upload_path = 'upload/books/audio/';
            $fileinfo = pathinfo($_FILES['audio_url']['name']);
            $extension = $fileinfo['extension'];
            $audio_url = $upload_url.'audio_'.time().'.'.$extension;
            $file_path = $upload_path .'audio_'.time().'.'.$extension;
            move_uploaded_file($_FILES['audio_url']['tmp_name'], $file_path);

            /****gallery file*/
            $upload_path = 'upload/books/gallery/';
            $fileinfo = pathinfo($_FILES['book_image']['name']);
            $extension = $fileinfo['extension'];
            $book_image = $upload_url.'gallery_'.time().'.'.$extension;
            $file_path = $upload_path .'gallery_'.time().'.'.$extension;
            move_uploaded_file($_FILES['book_image']['tmp_name'], $file_path);

            /****video file*/
            $upload_path = 'upload/books/video/';
            $fileinfo = pathinfo($_FILES['video_url']['name']);
            $extension = $fileinfo['extension'];
            $video_url = $upload_url.'video_'.time().'.'.$extension;
            $file_path = $upload_path .'video_'.time().'.'.$extension;
            move_uploaded_file($_FILES['video_url']['tmp_name'], $file_path);

    $sendData = array(
        'user_id' => $user_id,
        'category_id' => $category_id,
        'book_title' => htmlspecialchars_decode(html_entity_decode($book_title)),
        'book_description' => htmlspecialchars_decode(html_entity_decode($book_description)),
        'author_name' => $author_name,
        'thubm_image' => $file_url,
        'pdf_url' => $pdf_url,
        'audio_url' => $audio_url,
        'book_image' => $book_image,
        'video_url' => $video_url,
        'status' => $status
    );

    $db = new DbOperation();
    $res = $db->publishNewBook($sendData);
    if($res){
        $arr = array();
        $arr = $db->getbookByid($res);
        $response["error"] = false;
        $response["data"] = $arr;
        $response["message"] = "Book published successfully.";
        echoResponse(200, $response);
    }else if($res == false){
        $response["error"] = true;
        $response["message"] = "failed.";
        echoResponse(200, $response);
    }
});

/**
 * URL: http://dnddemo.com/ebooks/api/v1/getAllBooks
 * Parameters: 
 * Method: POST
 * */

$app->post('/getBooksByTypes', function () use ($app) {
    $cat_id = $app->request->post('category_id');
    $response = array();
    $db = new DbOperation();
    $arr = array();
    $arr = $db->getBookbyCategoryId($cat_id);
    $response["error"] = false;
    $response["data"] = $arr;
    $response["message"] = "success";
    echoResponse(200, $response);
});

/**
 * URL: http://dnddemo.com/ebooks/api/v1/getBookDetail
 * Parameters: 
 * Method: POST
 * */

$app->post('/getBookDetail', function () use ($app) {
    $bookId = $app->request->post('book_id');
    $response = array();
    $db = new DbOperation();
    $arr = array();
    $arr = $db->getbooksDetailByid($bookId);
    $response["error"] = false;
    $response["data"] = $arr;
    $response["message"] = "success";
    echoResponse(200, $response);
});


/**
 * URL: http://dnddemo.com/ebooks/api/v1/bookMark
 * Parameters: 
 * Method: POST
 * */

$app->post('/bookMark', function () use ($app) {
    $bookId = $app->request->post('book_id');
    $bookmarStatus = $app->request->post('bookmark_status');
    $response = array();
    $db = new DbOperation();
    $arr = array();
    $arr = $db->addUpdateBookmark($bookId,$bookmarStatus);
    
    if($arr == 'deactive') {
            $response["error"] = true;
            $response["message"] = "Bookmark deactive successfully";
             $response["data"] = 0;
            echoResponse(200, $response);
        }else if($arr == 'active') {
            $response["error"] = true;
            $response["message"] = "Bookmark Added successfully";
            $response["data"] = 1;
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
