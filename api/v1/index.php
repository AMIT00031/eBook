<?php
/*ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
require_once '../include/DbOperation.php';
require_once '../include/Braintree_lib.php'; 
require '.././libs/Slim/Slim.php';
\Slim\Slim::registerAutoloader();
define('API_ACCESS_KEY','AAAA2RSvweQ:APA91bEnwlkf53HXU4559AUAIgsoEgnPLwDT3tw1cpju0WIPPdguWgmYEHHWGONZ4aNaxn8jAw0s5lbNbbJqFd1w-aEnHJ-5G-36bw3m5lj3u53e15RoERzNBoUX8O8cam40Qmy77d8G'); 

require_once "FaceDetector.php";

/*define("ROOT_FOLDER","/ebooks/development/");
define("DOCUMENTROOT",$_SERVER['DOCUMENT_ROOT'].ROOT_FOLDER);*/

$app = new \Slim\Slim(); 


/**
 * URL: http://dnddemo.com/ebooks/api/v1/userFaceLogin
 * Parameters: user_id, image_name
 * Method: POST
 * */
 
$app->post('/userFaceLogin', function () use ($app) {
    $_['en_login_msg'] = "Invalid image";
    $_['en_login_user_msg'] = "Please provide user image";
    
	//verifyRequiredParams(array('password'));

	$upload_path = 'upload/';
	
	$fileinfo = pathinfo($_FILES['face_detect_image']['name']);
	
	$extension = $fileinfo['extension'];
	
	if ( !empty($extension) && !empty($fileinfo['filename'])){
		//$file_url = $upload_url . 'face_' . time() . '.' . $extension;
		
		$file_path = $upload_path . 'face_'.$fileinfo['filename'].'_' . time() . '.' . $extension;
		move_uploaded_file($_FILES['face_detect_image']['tmp_name'], $file_path);
	}
			
	if(!empty($fileinfo['filename'])) {
		
		$face_detect = new Face_Detector('detection.dat');
		
		//$img = 'ebooks/api/v1/vansh.jpg';
		
		$img = $_SERVER['DOCUMENT_ROOT'].'/ebooks/api/v1/'.$file_path;
		
		$user_image_detail = $face_detect->face_detect($img); //get user cordination with script
		
		//print_r($user_image_detail); die;

		$lang = 'en';
		
		$db = new DbOperation(); 
		
		$response = array();
		
		unlink($_SERVER['DOCUMENT_ROOT'].'/ebooks/api/v1/'.$file_path); 
		
		$user_deatil = $db->userfacelogin($user_image_detail['x'], $user_image_detail['y'], $user_image_detail['w']);
	   
	   //print_r($user_deatil);  die;
	   
		if(!empty($user_deatil)){
			
			$email = $user_deatil->email;
			$user_name = $user_deatil->user_name;
			$password = $user_deatil->password;
			//$device_token = $user_deatil->device_token;
			//$device_type = $user_deatil->device_type;
		   //if ($db->userlogin($email, $user_name, $password, $device_token, $device_type)){
			$users = $db->getFaceUser($email, $user_name, $password);
			//echo "<pre>";print_r($users);exit();
			$response['error'] = false;
			$response['response'] = $users;
		   
		}else{
			$response['error'] = true;
			$response['message'] = $_[$lang . '_login_msg']; //"Invalid username or password";
		}
	
	}else{
		
		$response['error'] = true;
		$response['message'] = $_[$lang . '_login_user_msg']; //"Invalid Image";
		
	}
    echoResponse(200, $response);
});


/* apli create user login http://dnddemo.com/ebooks/api/v1/createUser */

$app->post('/createUser', function () use ($app) {

 ///echo "<pre>";print_r($_POST);exit('signup');
    $_['en_create_user_msg1'] = "You are successfully registered";
    $_['en_create_user_msg2'] = "Oops! An error occurred while registereing";
    $_['en_create_user_msg3'] = "Sorry, this user  already existed";
    $_['en_create_user_msg4'] = "Email id not exists";
    verifyRequiredParams(array('email','user_name'));
    $response = array();
    $full_name = $app->request->post('full_name');
    
    $email = $app->request->post('email');
    $phone_no = $app->request->post('phone_no');
    $device_token = $app->request->post('device_token');
    $device_type = $app->request->post('device_type');
    $random_number = mt_rand(100000, 999999);
	
	$login_type = $app->request->post('login_type');
	if($login_type=="facebook" || $login_type=="google"){
		$password  = time();
	}else {
		$password = $app->request->post('password');
	}
	
    $lang = 'en';
    $country = $app->request->post('country');
    $gender = $app->request->post('gender');
    $publisher_type = $app->request->post('publisher_type');
    $user_name = $app->request->post('user_name');
	
    $about_me = $app->request->post('about_me');
	$upload_path = 'upload/';
	$fileinfo = pathinfo($_FILES['image']['name']);
	$extension = $fileinfo['extension'];
	$file_url = $upload_url . 'pic_' . time() . '.' . $extension;
	$file_path = $upload_path . 'pic_' . time() . '.' . $extension;
	move_uploaded_file($_FILES['image']['tmp_name'], $file_path);
	
	
	//$upload_path = 'upload/';
	
	$fileinfo = pathinfo($_FILES['face_detect_image']['name']);
	$extension = $fileinfo['extension'];
	if ( !empty($extension) && !empty($fileinfo['filename'])){
		//$file_url = $upload_url . 'face_' . time() . '.' . $extension;
		$file_path = $upload_path . 'face_'.$fileinfo['filename'].'_' . time() . '.' . $extension;
		move_uploaded_file($_FILES['face_detect_image']['tmp_name'], $file_path);
	}
			
	if(!empty($fileinfo['filename'])) {
		$face_detect = new Face_Detector('detection.dat');
		//$img = 'ebooks/api/v1/vansh.jpg';
		$img = $_SERVER['DOCUMENT_ROOT'].'/ebooks/api/v1/'.$file_path;
		$user_image_detail = $face_detect->face_detect($img); //get user cordination with script
		unlink($_SERVER['DOCUMENT_ROOT'].'/ebooks/api/v1/'.$file_path); 
	}	
		
    $db = new DbOperation();
    $res = $db->createUser($full_name, $password, $email, $phone_no,$file_url, $device_token, $device_type, $random_number, $country, $gender, $publisher_type, $user_name,$about_me,$user_image_detail['x'],$user_image_detail['y'],$user_image_detail['w'],$login_type);
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
		 
        
		$updateUser = $db->updateUser($device_type,$device_token,$login_type,$email);
		if($updateUser){
			
			$users = $db->getUserInfoByEmail($email);
			$response["error"] = false;
			$response['user_data'] = $users;
			$response["message"] = $_[$lang .'_create_user_msg3'];
			echoResponse(200, $response);
		}else{
			$response["error"] = true;
			$response["message"] = $_[$lang . '_create_user_msg4'];
			echoResponse(200, $response);
		}
        
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
 * URL: http://dnddemo.com/ebooks/api/v1/dictionaryWord
 * Parameters: user_id
 * Method: POST
 * */

$app->post('/dictionaryWord', function() use ($app) {
    $wordData = $app->request->post('word');
    $_['en_successword'] = "successfull";
    $lang = 'en';
    $db = new DbOperation();
    $response = array();
    $res = $db->DictionaryData($wordData);
    if($res!= 1){
        $response['error'] = false;
        $response['response'] = $res;
        $response['message'] = $_[$lang . '_successword'];
        echoResponse(200, $response);
    }else{
        $response['error'] = true;
        $response['response'] = NULL;
        $response['message'] = "Words not found";
        echoResponse(201, $response);
    }
    
});


/**
 * URL: http://dnddemo.com/ebooks/api/v1/getBookById
 * Parameters: user_id
 * Method: POST
 * */

$app->post('/getBookById', function() use ($app) {
    verifyRequiredParams(array('books_id'));
    $BookId = $app->request->post('books_id');
    $_['en_bookInfo'] = "Book listed successfully";
    $_['en_bookerrorInfo'] = "Book id is missing, please try again";
    $lang = 'en';
    $db = new DbOperation();
    $response = array();
    $res = $db->getBookdatabyid($BookId);
    if($res!== 1){
        $response['error'] = false;
        $response['response'] = $res;
        $response['message'] = $_[$lang . '_bookInfo'];
        echoResponse(200, $response);
    }else{
        $response['error'] = true;
        $response['response'] = NULL;
        $response['message'] = $_[$lang . '_bookerrorInfo'];
        echoResponse(200, $response);
    }
});


/**
 * URL: http://dnddemo.com/ebooks/api/v1/DeleteBook
 * Parameters: 
 * Method: POST
 * */

$app->post('/DeleteBook', function () use ($app) {
    $books_id = $app->request->post('books_id');
    $response = array();
    if (empty($books_id)) {
        $response["error"] = true;
        $response["data"] = "";
        $response["message"] = "Please enter book id.";
        echoResponse(200, $response);
    }else{
        $db = new DbOperation();
        $arr = array();
        $arr = $db->deleteBookbyId($books_id);
        if ($arr == 1) {
            $response["error"] = false;
            $response["message"] = "Book deleted successfully.";
            echoResponse(200, $response);
        } else {
            $response["error"] = true;
            $response["message"] = "Please enter valid book id.";
            echoResponse(201, $response);
        }
    }
});


/**
 * URL: http://dnddemo.com/ebooks/api/v1/sendFrndReq
 * Parameters: user_id
 * Method: POST
 * */


$app->post('/sendFrndReq', function() use ($app) {
    verifyRequiredParams(array('user_id', 'frnd_id'));    
    $user_id = $app->request->post('user_id');
    $frnd_id = $app->request->post('frnd_id');
    $_['en_sendFrndReq'] = "Friend Requset already sent. Pls wait..";
    $lang = 'en';
    $db = new DbOperation();
    $response = array();
    $res = $db->sendFrndReq($user_id, $frnd_id);
	
    if($res== 1){
		
		$senduser 	= $db->getAuthorDetails2($user_id);
		
		if(!empty($senduser)){ 
			
			$groupid 	=  $group_id;          
			$sendtoid 	=  $frnd_id;
			$rec_user_detail 	= $db->getAuthorDetails2($sendtoid);
			//echo "<pre>";print_r($rec_user_detail); die;
	
			if(is_numeric($sendtoid) && $user_id && $rec_user_detail->device_token!=''){
				
				/* $user_details = array();
				$user_details = $rec_user_detail;
				$chats = array(); */
				
				//'channel_id' => $channelId, 
				$fcmUrl = 'https://fcm.googleapis.com/fcm/send';
				//$token = $senduser->device_token; 
				$token = $rec_user_detail->device_token; 
				$notification = [
					'user_id' => $senduser->id, 
					'UserName' => $senduser->user_name, 
					'Avtar' => $senduser->url, 
					'channel_id' => $frnd_id,
					'noti_msg' => 'friend_req', 
				];
				$extraNotificationData = ["message" => $notification];        
				$fcmNotification = [
					//'registration_ids' => $tokenList, //multple token array
					'to'        => $token, //single token
					'notification' => $notification,
					'data' => $notification
				];

				//echo "<pre>";print_r($fcmNotification);exit;

				$headers = [
				'Authorization: key='.API_ACCESS_KEY,
				'Content-Type: application/json'
				];

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,$fcmUrl);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
				$result = curl_exec($ch);
				curl_close($ch);
				$response['pushMessaage'] = json_decode($result);
				
				$noti_send = $sendtoid;	
				
			} 
			//echo "<pre>";print_r($chats);exit('pf');
		
		}else { $noti_send = '';} 		

        $response['error'] = false;
        $response['response'] = 'Friend Request Sent Successfully...';        
    }else{
        $response['error'] = true;
        $response['message'] = $_[$lang . '_sendFrndReq'];
    }
    echoResponse(200, $response);
});

/**
 * URL: http://dnddemo.com/ebooks/api/v1/createChatId
 * Parameters: user_id, chat_id
 * Method: POST
 * */


$app->post('/createChatId', function() use ($app) {
    verifyRequiredParams(array('user_id', 'chat_id'));    
    $user_id = $app->request->post('user_id');
    $chat_id = $app->request->post('chat_id');
    $_['en_createChatId'] = "Some error occurred..";
    $lang = 'en';
    $db = new DbOperation();
    $response = array();
    $res = $db->createChatId($user_id, $chat_id);
    if($res== 1){
        $response['error'] = false;
        $response['response'] = 'Chat Room Created...';        
    }else{
        $response['error'] = true;
        $response['message'] = $_[$lang . '_createChatId'];
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
        $about_me = $app->request->post('about_me');
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
        $res = $db->userEdit($address, $user_id, $file_url, $country, $password,$publisher_type, $email,$about_me);
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
	
	$datas = array();
    if($res!= 1){
		foreach($res as $key=>$result){ 
			$datas[$key]['id'] = $result->id; 
            $datas[$key]['category_name'] = $result->category_name; 
            $datas[$key]['slug_url'] = $result->slug_url; 
            $datas[$key]['description'] =utf8_decode($result->description);
            $datas[$key]['status'] = $result->status; 
            $datas[$key]['thum_image'] = $result->thum_image; 
            $datas[$key]['created'] = $result->created; 
            $datas[$key]['created_at'] = $result->created_at; 
            $datas[$key]['updated_at'] = $result->updated_at; 
		}
        $response['error'] = false;
        $response['response'] = $datas;
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
    /*echo "<pre>";print_r($_FILES);*/
    	/*$_POST = json_decode($_POST['questiondata']);
    echo "<pre>";print_r($_POST);exit;*/
    verifyRequiredParams(array('user_id','category_id','book_title'));
    $response = array();
	$book_id='';
	if($app->request->post('book_id')){	
		$book_id = $app->request->post('book_id');
	}
    $user_id = $app->request->post('user_id');
    $category_id = $app->request->post('category_id');
    $book_title = $app->request->post('book_title');
    $book_description = $app->request->post('book_description');
    $author_name = $app->request->post('author_name');
    $isbn_number = $app->request->post('isbn_number');
    $questiondata = $app->request->post('questiondata');
    $status = $app->request->post('status');
	
		/****Cover image*/
		if(!empty($_FILES['thubm_image'])){
			//$upload_path = '../../uploads/product/';
			$upload_path = 'upload/books/';
			$fileinfo = pathinfo($_FILES['thubm_image']['name']); 
			$extension = $fileinfo['extension'];
			$file_url = $upload_url.'book_'.time().'.'.$extension;
			$file_path = $upload_path .'book_'.time().'.'.$extension;
			move_uploaded_file($_FILES['thubm_image']['tmp_name'], $file_path);
		}
		else{
			 $file_url = $app->request->post('cover_url'); 
		}
		/****Document file*/
		if(!empty($_FILES['pdf_url'])){
			$upload_path = 'upload/books/document/';
			$fileinfo = pathinfo($_FILES['pdf_url']['name']);
			$extension = $fileinfo['extension'];
			$pdf_url = $upload_url.'document_'.time().'.'.$extension;
			$file_path = $upload_path .'document_'.time().'.'.$extension;
			move_uploaded_file($_FILES['pdf_url']['tmp_name'], $file_path);
		}
		/****audio file*/
		if(!empty($_FILES['audio_url'])){
			$upload_path = 'upload/books/audio/';
			$fileinfo = pathinfo($_FILES['audio_url']['name']);
			$extension = $fileinfo['extension'];
			$audio_url = $upload_url.'audio_'.time().'.'.$extension;
			$file_path = $upload_path .'audio_'.time().'.'.$extension;
			move_uploaded_file($_FILES['audio_url']['tmp_name'], $file_path);
		}

		/****gallery file*/
		if(!empty($_FILES['book_image'])){
			$upload_path = 'upload/books/gallery/';
			$fileinfo = pathinfo($_FILES['book_image']['name']);
			$extension = $fileinfo['extension'];
			$book_image = $upload_url.'gallery_'.time().'.'.$extension;
			$file_path = $upload_path .'gallery_'.time().'.'.$extension;
			move_uploaded_file($_FILES['book_image']['tmp_name'], $file_path);
		}

		/****video file*/
		 if(!empty($_FILES['video_url'])){
			$upload_path = 'upload/books/video/';
			$fileinfo = pathinfo($_FILES['video_url']['name']);
			$extension = $fileinfo['extension'];
			$video_url = $upload_url.'video_'.time().'.'.$extension;
			$file_path = $upload_path .'video_'.time().'.'.$extension;
			move_uploaded_file($_FILES['video_url']['tmp_name'], $file_path);
		}
		if(is_numeric($book_id) && $book_id!=''){ $status =1; }
		$sendData = array( 
			'book_id' => ($book_id)?$book_id:'',
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
			'questiondata' => $questiondata,
			'isbn_number' => $isbn_number,
			'status' => $status
		);

		$db = new DbOperation();
		$res = $db->publishNewBook($sendData);
		if($res){
			$arr = array();
			$arr = $db->getbookByid($res);
			//echo "<pre>";print_r($arr);exit();
			$bookId = $arr->id;
			$user_id = $arr->user_id;
			$question = $arr->question_data; 
			
			if($question!=''){ 
				$questionData = $db->addAssignment($bookId,$user_id,$question);
			}
			
			$response["error"] = false;
			$response["data"] = $arr;
			$response["message"] = "Book published successfully.";
			echoResponse(200, $response);
		}else if($res == false){
			$response["error"] = true;
			$response["message"] = "failed.";
			echoResponse(201, $response);
		}
	});

/**
 * URL: http://dnddemo.com/ebooks/api/v1/updateBookByid
 * Parameters: book_id
 * Method: POST
 * */

$app->post('/updateBookByid', function () use ($app) {
    /*echo "<pre>";print_r($_FILES);*/
    	/*$_POST = json_decode($_POST['questiondata']);
    echo "<pre>";print_r($_POST);exit;*/
    verifyRequiredParams(array('book_id'));
    $response = array();  
    $book_id = $app->request->post('book_id');
    $category_id = $app->request->post('category_id');
    $book_title = $app->request->post('book_title');
    $book_description = $app->request->post('book_description');
    $author_name = $app->request->post('author_name');
    $isbn_number = $app->request->post('isbn_number');
    $status = $app->request->post('status');
	/****Cover image*/
	if(!empty($_FILES['thubm_image'])){
		$upload_path = 'upload/books/';
		$fileinfo = pathinfo($_FILES['thubm_image']['name']);
		$extension = $fileinfo['extension'];
		$file_url = $upload_url.'book_'.time().'.'.$extension;
		$file_path = $upload_path .'book_'.time().'.'.$extension;
		move_uploaded_file($_FILES['thubm_image']['tmp_name'], $file_path);
	}

	/****Document file*/
	if(!empty($_FILES['pdf_url'])){
		$upload_path = 'upload/books/document/';
		$fileinfo = pathinfo($_FILES['pdf_url']['name']);
		$extension = $fileinfo['extension'];
		$pdf_url = $upload_url.'document_'.time().'.'.$extension;
		$file_path = $upload_path .'document_'.time().'.'.$extension;
		move_uploaded_file($_FILES['pdf_url']['tmp_name'], $file_path);
	}
	/****audio file*/
	if(!empty($_FILES['audio_url'])){
		$upload_path = 'upload/books/audio/';
		$fileinfo = pathinfo($_FILES['audio_url']['name']);
		$extension = $fileinfo['extension'];
		$audio_url = $upload_url.'audio_'.time().'.'.$extension;
		$file_path = $upload_path .'audio_'.time().'.'.$extension;
		move_uploaded_file($_FILES['audio_url']['tmp_name'], $file_path);
	}

	/****gallery file*/
	 if(!empty($_FILES['book_image'])){
		$upload_path = 'upload/books/gallery/';
		$fileinfo = pathinfo($_FILES['book_image']['name']);
		$extension = $fileinfo['extension'];
		$book_image = $upload_url.'gallery_'.time().'.'.$extension;
		$file_path = $upload_path .'gallery_'.time().'.'.$extension;
		move_uploaded_file($_FILES['book_image']['tmp_name'], $file_path);
	}

	/****video file*/
	 if(!empty($_FILES['video_url'])){
		$upload_path = 'upload/books/video/';
		$fileinfo = pathinfo($_FILES['video_url']['name']);
		$extension = $fileinfo['extension'];
		$video_url = $upload_url.'video_'.time().'.'.$extension;
		$file_path = $upload_path .'video_'.time().'.'.$extension;
		move_uploaded_file($_FILES['video_url']['tmp_name'], $file_path);
	}

    $sendData = array(
        'book_id' => $book_id,
        'category_id' => $category_id,
        'book_title' => htmlspecialchars_decode(html_entity_decode($book_title)),
        'book_description' => htmlspecialchars_decode(html_entity_decode($book_description)),
        'author_name' => $author_name,
        'thubm_image' => $file_url,
        'pdf_url' => $pdf_url,
        'audio_url' => $audio_url,
        'book_image' => $book_image,
        'video_url' => $video_url,
        'isbn_number' => $isbn_number,
        'status' => $status
    );

    $db = new DbOperation();
    $res = $db->updateBook($sendData);
	//echo "<pre>";print_r($res);
    if($res){
        $arr = array();
        $arr = $db->getbookByid($res);
        //echo "<pre>";print_r($arr);exit();
        $response["error"] = false;
        $response["data"] = $arr;
        $response["message"] = "Book updated successfully.";
        echoResponse(200, $response);
    }else if($res == false){
        $response["error"] = true;
        $response["message"] = "failed.";
        echoResponse(201, $response);
    }
});

/**
 * URL: http://dnddemo.com/ebooks/api/v1/validateIsbn
 * Parameters: 
 * Method: POST
 * */

$app->post('/validateIsbn', function () use ($app) {
    $isbn_number = $app->request->post('isbn_number');
    $response = array();
    $db = new DbOperation();
    $arr = $db->isIsbnExists($isbn_number);
    if($arr){
		$response["error"] = false;
		$response["data"] = $arr;
		$response["message"] = "Vailid Isbn number";
		echoResponse(200, $response);
    }else{
		$response["error"] = true;
		$response["data"] = false;
		$response["message"] = "In Vailid Isbn number";
		echoResponse(201, $response);
    }
});




/**
 * URL: http://dnddemo.com/ebooks/api/v1/getBooksByTypes
 * Parameters: 
 * Method: POST
 * */

$app->post('/getBooksByTypes', function () use ($app) {
    $cat_id = $app->request->post('category_id');
    $response = array();
    $db = new DbOperation();
    $arr = array();
    $arr = $db->getBookbyCategoryId($cat_id);
    if($arr){
    $response["error"] = false;
    $response["data"] = $arr;
    $response["message"] = "success";
    echoResponse(200, $response);
    }else{
        $response["error"] = true;
        $response["data"] = NULL;
        $response["message"] = "False";
        echoResponse(201, $response);
}
});

/**
 * URL: http://dnddemo.com/ebooks/api/v1/getBookDetail
 * Parameters: 
 * Method: POST
 * */

$app->post('/getBookDetail', function () use ($app) {
    $bookId = $app->request->post('book_id');
    $userid = $app->request->post('user_id');
    $response = array();
    $db = new DbOperation();
    $arr = array();
    $arr = $db->getbooksDetailByid($bookId);
    $reviewData = $db->getReviewbyBookid($arr->id);
    $Boomark = $db->getbookMarkByBookid($bookId,$userid);
    $allQuestion = $db->getallQustionbyBook($bookId);
    $ansbyUser = $db->gteAnsweredbyuser($userid,$bookId);
    
    if (isset($reviewData)) {
        $rating = 0;
        foreach ($reviewData as $reviewVal) {
            $totalRating[] = $reviewVal->rating;
            $rating += $reviewVal->rating;
        }
        $averrageRating = round($rating/count($totalRating), 1);
    }
    unset($arr->question_data);
    
    $response["error"] = false;
    $response["data"] = $arr;
    $response["bookMark"] = $Boomark;
    $response["review"] = $reviewData;
    $response["averaVal"] = isset($averrageRating) ? $averrageRating :0;
    $response["assignment"] = $allQuestion;
    $response["user_answer"] = $ansbyUser;
    $response["message"] = "success";
    echoResponse(200, $response);
});


/**
 * URL: http://dnddemo.com/ebooks/api/v1/updateAssignment
 * Parameters: 
 * Method: POST
 * */

$app->post('/updateAssignment', function () use ($app){
    $response = array();
    $assignment_id = $app->request->post('assignment_id');
    $answer = $app->request->post('answer');
    $answered_by = $app->request->post('answered_by');

        $db = new DbOperation();
        $arr = array();
        $arr = $db->UpdateAssignment($assignment_id,$answer,$answered_by);

        if (!empty($arr)){
            $response["error"] = false;
            $response["message"] = "Assignment Updated successfully.";
            $response["data"] = $arr;
            echoResponse(200, $response);
          }else{
            $response["error"] = true;
            $response["message"] = NULL;
            echoResponse(201, $response);
        }
});


/**
 * URL: http://dnddemo.com/ebooks/api/v1/answerQuestion
 * Parameters: 
 * Method: POST
 * */

$app->post('/answerQuestion', function () use ($app){
    $response = array();
    $answer = $app->request->post('answer');
        $db = new DbOperation();
        $arr = array();
        $arr = $db->addAnswer($answer);

        if (!empty($arr)){
            $response["error"] = false;
            $response["message"] = "Answered saved successfully.";
            echoResponse(200, $response);
          }else{
            $response["error"] = true;
            $response["message"] = NULL;
            echoResponse(201, $response);
        }
});


/**
 * URL: http://dnddemo.com/ebooks/api/v1/getUserDetails
 * Parameters: 
 * Method: POST
 * */

$app->post('/getUserDetails', function () use ($app){
    $userid = $app->request->post('user_id');
    $response = array();
    $db = new DbOperation();
    $arr = array();
    $arr = $db->getAuthorDetails($userid); 
	//echo "<pre>";print_r($arr);exit;
    if(!empty($arr)){
        $bookList = $db->getAuthorBooklist($arr[id]);
        //echo "<pre>";print_r($bookList);exit;  
        $response["error"] = false;
        $response["data"] = $arr;
        $response["booklist"] = $bookList;
        $response["message"] = "success";
        echoResponse(200, $response);
    }else{
        $response["error"] = true;
        $response["message"] = "Failed";
        echoResponse(201, $response);
   }
});


/**
 * URL: http://dnddemo.com/ebooks/api/v1/getPendingBookByUser
 * Parameters: 
 * Method: POST
 * */

$app->post('/getPendingBookByUser', function () use ($app){
    $userid = $app->request->post('user_id');
    $response = array();
    $db = new DbOperation();
    $arr = array();
    $arr = $db->getPendingBooklist($userid);
    if(!empty($arr)){
        $response["error"] = false;
        $response["data"] = $arr;
        $response["message"] = "success";
        echoResponse(200, $response);
    }else{
        $response["error"] = true;
        $response["message"] = "Failed";
        echoResponse(201, $response);
   }
});


/**
 * URL: http://dnddemo.com/ebooks/api/v1/bookMark
 * Parameters: 
 * Method: POST
 * */


$app->post('/bookMark', function () use ($app) {
    $response = array();
    $user_id = $app->request->post('user_id');
    $bookId = $app->request->post('book_id');
    if ($user_id == "") {
        $response["error"] = false;
        $response["message"] = "Please login first";
        echoResponse(201, $response);
    } elseif($bookId == "") {
        $response["error"] = false;
        $response["message"] = "error! please try again";
        echoResponse(201, $response);
    } else {
        $db = new DbOperation();
        $arr = array();
        $arr = $db->addUpdateBookmark($user_id, $bookId);
        if ($arr == 'deactive') {
            $response["error"] = true;
            $response["message"] = "Success.";
             $response["data"] = 0;
            echoResponse(200, $response);
        } else if ($arr == 'active') {
            $response["error"] = true;
            $response["message"] = "Success.";
            $response["data"] = 1;
            echoResponse(200, $response);
        } else {
            $response["error"] = false;
            $response["message"] = "Failed.";
            echoResponse(201, $response);
        }
    }
});

/**
 * URL: http://dnddemo.com/ebooks/api/v1/getAllbookMarkByUser
 * Parameters: 
 * Method: POST
 * */


$app->post('/getAllbookMarkByUser', function () use ($app) {
    $response = array();
    $user_id = $app->request->post('user_id');
    if ($user_id == "") {
        $response["error"] = false;
        $response["message"] = "Please login first";
        echoResponse(201, $response);
    }else{
        
        $db = new DbOperation();
        $arr = array();
        $arr = $db->getUserBookMark($user_id);
        //echo $arr;
        if (!empty($arr)) {
            $response["error"] = false;
            $response["message"] = "Success.";
            $response["data"] = $arr;
            echoResponse(200, $response);
          }else{
            $response["error"] = true;
            $response["message"] = NULL;
            echoResponse(201, $response);
        }
    }
});


/**
 * URL: http://dnddemo.com/ebooks/api/v1/addNote
 * Parameters: 
 * Method: POST
 * */

$app->post('/addNote', function () use ($app){
    $response = array();
    $user_id = $app->request->post('user_id');
	$title 	 = $app->request->post('title');
    $description = $app->request->post('description');

        $db = new DbOperation();
        $arr = array();
        $arr = $db->craeteNoteBook($user_id,$description,$title);

        if (!empty($arr)){
            $response["error"] = false;
            $response["message"] = "Note added successfully.";
            $response["data"] = $arr;
            echoResponse(200, $response);
          }else{
            $response["error"] = true;
            $response["message"] = NULL;
            echoResponse(201, $response);
        }
});

/**
 * URL: http://dnddemo.com/ebooks/api/v1/getAllNotebyUser
 * Parameters: 
 * Method: POST
 * */

$app->post('/getAllNotebyUser', function () use ($app){
    $response = array();
    $user_id = $app->request->post('user_id');

        $db = new DbOperation();
        $arr = array();
        $arr = $db->gteNoteByUser($user_id); 

        if (!empty($arr)){
            $response["error"] = false;
            $response["message"] = "Note added successfully.";
            $response["data"] = $arr;
            echoResponse(200, $response);
          }else{
            $response["error"] = true;
            $response["message"] = NULL;
            echoResponse(201, $response);
        }
});

/**
 * URL: http://dnddemo.com/ebooks/api/v1/UpdateNoteBook
 * Parameters: 
 * Method: POST
 * */

$app->post('/UpdateNoteBook', function () use ($app){
    $response = array();
    $note_id = $app->request->post('note_id');
	$title = $app->request->post('title');
    $description = $app->request->post('description');

        $db = new DbOperation();
        $arr = array();
        $arr = $db->UpdateNote($note_id,$description,$title);

        if (!empty($arr)){
            $response["error"] = false;
            $response["message"] = "Note Updated successfully.";
            $response["data"] = $arr;
            echoResponse(200, $response);
          }else{
            $response["error"] = true;
            $response["message"] = NULL;
            echoResponse(201, $response);
        }
});


/**
 * URL: http://dnddemo.com/ebooks/api/v1/DeleteNote
 * Parameters: 
 * Method: POST
 * */

$app->post('/DeleteNote', function () use ($app) {
    $note_id = $app->request->post('note_id');
    $response = array();
    if (empty($note_id)) {
        $response["error"] = true;
        $response["data"] = "";
        $response["message"] = "Please enter note id.";
        echoResponse(200, $response);
    }else{
        $db = new DbOperation();
        $arr = array();
        $arr = $db->deleteNoteBook($note_id);
        if ($arr == 1) {
            $response["error"] = false;
            $response["message"] = "success.";
            echoResponse(200, $response);
        } else {
            $response["error"] = true;
            $response["message"] = "Please enter valid note id.";
            echoResponse(200, $response);
        }
    }
});


/**
 * URL: http://dnddemo.com/ebooks/api/v1/getAllpopularBook
 * Parameters: 
 * Method: POST
 * */

$app->post('/getAllpopularBook', function () use ($app){ 
	
	  
       $response = array();
        $db = new DbOperation();
        $arr = array();
        $arr = $db->GetPopularBook();

        if (!empty($arr)){
            $response["error"] = false;
            $response["message"] = "Listed successfully.";
            $response["data"] = $arr;
            echoResponse(200, $response);
          }else{
            $response["error"] = true;
            $response["message"] = NULL;
            echoResponse(201, $response);
        }
});

/**
 * URL: http://dnddemo.com/ebooks/api/v1/getAllRequestbyUser
 * Parameters: 
 * Method: POST
 * */

$app->post('/getAllRequestbyUser', function () use ($app){
       $response = array();
       $userId = $app->request->post('user_id');

        $db = new DbOperation();
        $arr = array();
        $arr = $db->getRequestedUsers($userId);

        if (!empty($arr)){
            $response["error"] = false;
            $response["message"] = "Listed requested users.";
            $response["data"] = $arr;
            echoResponse(200, $response);
          }else{
            $response["error"] = true;
            $response["message"] = NULL;
            $response["data"] = NULL;
            echoResponse(201, $response);
        }
});

//URL: http://dnddemo.com/ebooks/api/v1/getFollowStatus

$app->post('/getFollowStatus', function () use ($app){
       $response = array();
       $userId = $app->request->post('user_id');
	   $friend_id = $app->request->post('friend_id');
        $db = new DbOperation();
        $arr = array();
        $arr = $db->getFollowUsersStaus($userId,$friend_id);
		//$chats_hist = array();
        if (!empty($arr)){
			
			$response["error"] = false;
			if($arr[0]->status==1){
				$channelId = $db->getChannelId($userId,$friend_id);
				$response["channelId"] = $channelId;
			}else{
				$response["channelId"] = '';
			}
            $response["message"] = "Listed requested users.";
            $response["data"] = $arr;
			
            echoResponse(200, $response);
          }else{
            $response["error"] = true;
            $response["message"] = NULL;
            $response["data"] = NULL;
            echoResponse(201, $response);
        }
});



/**
 * URL: http://dnddemo.com/ebooks/api/v1/acceptedRequest
 * Parameters: 
 * Method: POST
 * */

$app->post('/acceptedRequest', function () use ($app){
    //echo "<pre>";print_r($_POST);exit();
       $response = array();
       $friendId = $app->request->post('friend_id');
       $status = $app->request->post('status');

        $db = new DbOperation();
        $arr = array();
        $arr = $db->acceptedUserreuest($friendId,$status);

        if ($arr == true){
            $response["error"] = false;
            $response["message"] = "Accepted request.";
            echoResponse(200, $response);
          }else{
            $response["error"] = false;
            $response["message"] = "Request not accepted";
            echoResponse(200, $response);
        }
});


/**
 * URL: http://dnddemo.com/ebooks/api/v1/getAllAcceptedFriend
 * Parameters: 
 * Method: POST
 * */

$app->post('/getAllAcceptedFriend', function () use ($app){
       $response = array();
       $userId = $app->request->post('user_id');

        $db = new DbOperation();
        $arr = array();
        $arr = $db->getAcceptedList($userId);

        if (!empty($arr)){
            $response["error"] = false;
            $response["message"] = "Accepted friend list.";
            $response["data"] = $arr;
            echoResponse(200, $response);
          }else{
            $response["error"] = true;
            $response["message"] = NULL;
            $response["data"] = NULL;
            echoResponse(201, $response);
        }
});


/**
 * URL: http://dnddemo.com/ebooks/api/v1/saerchAllbooks
 * Parameters: 
 * Method: POST
 * */

$app->post('/saerchAllbooks', function () use ($app){
    $response = array();
   
        $db = new DbOperation();
        $arr = array();
        $arr = $db->SearchBook();

        if (!empty($arr)){
            $response["error"] = false;
            $response["message"] = "searched successfully.";
            $response["data"] = $arr;
            echoResponse(200, $response);
          }else{
            $response["error"] = true;
            $response["message"] = NULL;
            echoResponse(201, $response);
        }
});


/**
 * URL: http://dnddemo.com/ebooks/api/v1/addReview
 * Parameters: 
 * Method: POST
 * */

$app->post('/addReview', function () use ($app){
    $response = array();
    $userId = $app->request->post('user_id');
    $booksId = $app->request->post('books_id');
    $comment = $app->request->post('comment');
    $rating = $app->request->post('rating');

        $db = new DbOperation();
        $arr = array();
        $arr = $db->craeteReviewaBook($userId,$booksId,$comment,$rating);

        if (!empty($arr)){
            $response["error"] = false;
            $response["message"] = "Review added successfully.";
            $response["data"] = $arr;
            echoResponse(200, $response);
          }else{
            $response["error"] = true;
            $response["message"] = NULL;
            echoResponse(201, $response);
        }
});

/**
 * URL: http://dnddemo.com/ebooks/api/v1/contact_us
 * Parameters: 
 * Method: POST
 * */

$app->post('/contact_us', function () use ($app) {
    $user_id = $app->request->post('user_id');
    $name = $app->request->post('name');
    $email = $app->request->post('email');
    $phone = $app->request->post('phone');
    $contadata = strip_tags($app->request->post('contatMessage')); 
    
    $db = new DbOperation();
    $response = array();

    $res = $db->sendContact($user_id, $name, $email, $phone, $address ,$contadata);
    if ($res) {
        $response["error"] = false;
        $response["message"] = "success";
        echoResponse(200, $response);
    } else if ($res == 0) {
        $response["error"] = true;
        $response["message"] = "failed";
        echoResponse(200, $response);
    }
});

//http://dnddemo.com/ebooks/api/v1/user_list
$app->post('/user_list', function () use ($app){
	
    $userid 			= $app->request->post('user_id');
    $is_all_users_list  = $app->request->post('is_all_users_list');
    $response 			= array();
    $db 				= new DbOperation();
    $arr 				= array();

    $arr = $db->getAuthorDetails($userid); 
	
	/*  echo "<pre>";print_r($arr); */
	$userList = array();
    if(!empty($arr)){
		
		$user_id = $arr['id'];
		if($is_all_users_list=="Yes"){
			$fields = "id,user_name,url,email,about_me, publisher_type,device_token, device_type,phone_no,status";
			$whrcond = " status = 1 ";  
			$userList = $db->getDetails2("user_login_table",$fields,$whrcond);
			
		}else{
			
			$fields = "ult.id,ult.user_name,ult.url,ult.email,ult.about_me, ult.publisher_type,ult.device_token, ult.device_type,ult.phone_no,ult.status";
			$whrcond = " ult.id != $arr[id] "; 
			$userList = $db->getDetailsOther("user_login_table",$fields,$whrcond,$user_id);
		}
		
		if(!empty($userList))
		{ 
			foreach($userList as $row)
			{   
				$img = "";
				$channelId = "";

				//if($is_all_users_list!="Yes"){
					
				if($row['avatar']) $img = 'upload/chats/'.$row['avatar'];
				
				$channelId = $db->has_channel($row['id'], $userid);
				
				$is_delete = "";
				if($channelId){
					$wherecond_rem =" user_id = ".$row['id']." and channel_id = $channelId ";  
					$is_delete = $db->select_value("user_chats_removed", "user_id", $wherecond_rem);
				}/* else{
					$wherecond_rem =" user_id = ".$row['id'];
				
				} */
				
				if($is_delete) $channelId = "";
				//}
				
				$user_list_arr[] = array(
					'userId' => $row['id'],
					'name' => $row['user_name'],
					'email' => $row['email'],
					'phone' => $row['phone_no'],
					'channelId' => $channelId,
					'url' => $row['url'],
					'publisher_type' => $row['publisher_type'],
					'device_token' => $row['device_token'],
					'device_type' => $row['device_type'],
					'avatar' => $img
				);
			}
			//print_r($user_list_arr); die;
		} 
		
        $response["error"] = false;
        //$response["data"] = $arr;
        $response["userList"] = $user_list_arr;
        $response["message"] = "success";
        echoResponse(200, $response);
    }else{
        $response["error"] = true;
        $response["message"] = "Failed";
        echoResponse(201, $response);
   }
   
});



/* user chat function start here */ 

$app->post('/user_chat', function () use ($app){
	verifyRequiredParams(array('user_id', 'sendTO')); 
    $userid = $app->request->post('user_id');
    $sendTO = $app->request->post('sendTO');
    $response = array();
    $db = new DbOperation();
    $arr = array();
	$insertData = array();
	$channelId = "";
	$message = "";          

    $UserDetails = $db->getAuthorDetails3($userid);
    $arr = $db->getAuthorDetails2($sendTO);

	//echo "<pre>";print_r($arr); die;
	
	$userList = array();
	
    if(!empty($arr)){ 
		//echo "fd";die;
		if($userid && $app->request->post('sendTO') && $app->request->post('type')){
			
			if($app->request->post('channelId')) {
				$channelId = $app->request->post('channelId');
			}else {
				$channelId = rand(100000, 999999); 
			}
			
			if($app->request->post('type') != "text"){
				 /****Document file*/
				if(!empty($_FILES['pdf_file'])){
					$errors= array();
					if(empty($errors)==true){
						$upload_path = 'upload/chats/document/';
						$fileinfo = pathinfo($_FILES['pdf_file']['name']);
						$extension = $fileinfo['extension'];
						$message = $upload_path.'document_'.time().'.'.$extension;
						$file_path = $upload_path .'document_'.time().'.'.$extension;
						move_uploaded_file($_FILES['pdf_file']['tmp_name'], $file_path);
					}else{
						$response["error"] = true;
						$response["message"] = "file size must not be more than 2 MB";
						echoResponse(201, $response);
						exit();
					}
				}
				
				/****image file*/
				 if(!empty($_FILES['image_file'])){ 
					 $errors= array();
					if(empty($errors)==true){
						$upload_path = 'upload/chats/gallery/'; 
						$fileinfo = pathinfo($_FILES['image_file']['name']);
						$extension = $fileinfo['extension']; 
						$message = $upload_path.'gallery_'.time().'.'.$extension; 
						$file_path = $upload_path .'gallery_'.time().'.'.$extension;
						move_uploaded_file($_FILES['image_file']['tmp_name'], $file_path);
					}else{
						$response["error"] = true;
						$response["message"] = "file size must not be more than 2 MB";
						echoResponse(201, $response);
						exit();
					}
				}
                
				/****audio file*/
				if(!empty($_FILES['audio_file'])){
					$errors= array();
					if(empty($errors)==true){
						$upload_path = 'upload/chats/audio/';
						$fileinfo  = pathinfo($_FILES['audio_file']['name']);
						$extension = $fileinfo['extension'];
						$message   =  $upload_path.'audio_'.time().'.'.$extension;
						$file_path = $upload_path .'audio_'.time().'.'.$extension;
						move_uploaded_file($_FILES['audio_file']['tmp_name'], $file_path);
					}else{
						$response["error"] = true;
						$response["message"] = "file size must not be more than 2 MB";
						echoResponse(201, $response);
						exit();
					}
				}
				
				/****video file*/
				 if(!empty($_FILES['video_file'])){
					 $errors= array();
					if(empty($errors)==true){
						$upload_path = 'upload/chats/video/';
						$fileinfo   = pathinfo($_FILES['video_file']['name']);
						$extension = $fileinfo['extension'];
						$message   = 	 $upload_path.'video_'.time().'.'.$extension;
						$file_path = $upload_path .'video_'.time().'.'.$extension;
						move_uploaded_file($_FILES['video_file']['tmp_name'], $file_path);
					}else{
						$response["error"] = true;
						$response["message"] = "file size must not be more than 2 MB";
						echoResponse(201, $response);
						exit();
					}
				}
			
			
			}else{ 
				$message = $app->request->post('message'); 
			}
			
			
			$query_state = "set channel_id='".$channelId."',sender='".$userid."',receiver='".$app->request->post('sendTO')."',type='".$app->request->post('type')."',message='".addslashes($message)."' "; 
			if($message!=''){
				$insId = $db->addEditRecord("user_chats", $query_state);	
			}
			
			$user_details = array();
			$user_details = $arr;
			
			//$fields = "id,user_name,url,email,about_me, publisher_type,device_token, device_type,phone_no";
			//$whrcond = " id != $arr->id "; 
			//$userList = $db->getDetails("user_login_table",$fields,$whrcond);
			
			$fields_token = "id,deviceid,pushtoken";
			$whrcond_token = " user_id = '".$app->request->post('sendTO')."' "; 
			$user_tokens = $db->getDetails("user_device_token",$fields_token,$whrcond_token);
			//print_r($user_tokens); die;
			if(!empty($user_tokens)){
					$sendTO = $app->request->post('sendTO');
					$chats_hist = array();
					$chats_hist = $db->user_chat_history($sendTO);
					$chat_filter = array();
					$chat_filter2 = array();//print_r($chats_hist);

					 if($chats_hist){
						foreach($chats_hist as $row){
							if(!in_array($row['chid'],$chat_filter) && ($sendTO !=$row['user_id']) )
							{
								$chat_filter[] = $row['chid'];
								$chat_filter2[] = $row;
							}
						}
					} 
					 
					//print_r($chat_filter2); die;
					if(!empty($chat_filter2)){
						 $user_list_arr = array();
						foreach($chat_filter2 as $row){
							//print_r($row);  die;
							$is_delete = "";
							
							$wherecond_rem =" user_id = ". $sendTO." and channel_id = '".$row['chid']."' "; 
							$is_delete = $db->select_value("user_chats_removed", "user_id", $wherecond_rem);
							
							if( (!$is_delete) && ($sendTO != $row['user_id'])){
								
								$img = "";
								if($row['avatar']) 
									$img = 'upload/chats/'.$row['avatar'];
								
								$user_list_arr[] = array(
									'userId' => $row['id'],
									'name' => $row['name'],
									'email' => $row['email'],
									'channelId' => $row['chid'],
									'created' => $row['created'],
									'unread' => $db->has_unread($row['id'], $sendTO, $row['chid']),
									'avatar' => $img
								);
							} 
						} 
						
						
					}
					$badge = 0;
					//var_dump($user_list_arr);
					
					/* foreach ($user_tokens as $key => $value) {
						$this->send_push(@$value["pushtoken"], $app->request->post('type'), @$user_details->name, $message,$badge);
					} */
				}
				
				//delete user chat
				$where_del_cond = "user_id='".$app->request->post('sendTO')."' and channel_id='".$channelId."' "; 
				$db->delete_data("user_chats_removed", $where_del_cond);				
				$chats = array();
				
				$chats = $db->user_chats($channelId);
				
				$typedata = $app->request->post('type');
				
				 if(!empty($typedata)){
					if($typedata == 'file'){
						$message = 'File';
					}elseif($typedata == 'image'){
						$message = 'Image';
					}elseif($typedata == 'audio'){
						$message = 'Audio';
					}elseif($typedata == 'video'){
						$message = 'Video';
					}elseif($typedata == 'docfile'){
						$message = 'Docfile';
					}
					
					$fcmUrl = 'https://fcm.googleapis.com/fcm/send';
					$token = $arr->device_token; 
					$notification = [
						'user_id' => $UserDetails->id, 
						'UserName' => $UserDetails->user_name, 
						'Avtar' => $UserDetails->url, 
						'channel_id' => $channelId, 
						'noti_type' => "individual",
						'noti_msg' => $message,
					];
					

					$extraNotificationData = ["message" => $notification];        
					$fcmNotification = [
						//'registration_ids' => $tokenList, //multple token array
						'to'        => $token, //single token
						'notification' => $notification,
						'data' => $notification
					];

					//echo "<pre>";print_r($fcmNotification);exit;

					$headers = [
					'Authorization: key='.API_ACCESS_KEY,
					'Content-Type: application/json'
					];

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,$fcmUrl);
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
					$result = curl_exec($ch);
					curl_close($ch);
					$response['pushMessaage'] = json_decode($result);
					} 
				 
				 //echo "<pre>";print_r($chats);exit('pf');
					
					
				if($chats){
					 $chat_list = array(); 
					foreach($chats as $row)
					{
						$msg = "";
						if($row["type"] == "file") 
							$msg =$row['message'];
						else  $msg = $row["message"];
							
						$chat_list[] = array(
							"id" => $row["id"],
							"sender" => $row["sender"],
							"receiver" => $row["receiver"],
							"channelId" => $row["channel_id"],
							"type" => $row["type"],
							'created' => $row['created'],							
							"message" => $msg
						);
					}
					//echo "<pre>";print_r($chat_list);exit('push data');
					
					$response["error"] = false;
					$response["data"] = $arr;
					$response["chat_list"] = $chat_list;
					$response['status'] = 'success';
					$response["message"] = "Successfully fetch";
					echoResponse(200, $response); 
					
				}
		  }elseif($userid && $app->request->post('channelId')){
			
			$chats = array(); 
			$chats = $db->user_chats($app->request->post('channelId'));               
			if($chats){       
                //delete case
				$where_del_cond = "user_id='".$app->request->post('sendTO')."' and channel_id='".$app->request->post('channelId')."' ";
				$db->delete_data("user_chats_removed", $where_del_cond);

				//$this->Api_model->update_data('user_chats',array("read_msg"=>"1"), array("receiver"=>$this->input->post('userId'), "channel_id"=>$this->input->post('channelId')));
				
				//$this->Api_model->delete_data("user_chats_removed", array("user_id"=>$this->input->post('userId'), "channel_id"=>$this->input->post('channelId')));
	 
				$update_stmt = "set read_msg='1'";
				$update_whrcond = "receiver='".$userid."' AND channel_id ='".$app->request->post('channelId')."'";
				
				if($chats!=''){
					$readdata = $db->addEditRecord('user_chats',$update_stmt,$update_whrcond);
				}
				
				$chat_list = array();
				
				foreach($chats as $row)
				{
					$msg = "";
					if($row["type"] == "file")  
						$msg = $row['message'];
					else  $msg = $row["message"];					
					
					$chat_list[] = array(
						"id" => $row["id"],
						"sender" => $row["sender"],
						"receiver" => $row["receiver"],
						"channelId" => $row["channel_id"],
						"type" => $row["type"],
						'created' => $row['created'],
						"message" => $msg
					);
				}
				
				$response["error"] = false;
				//$response["data"] = $arr;
				$response["chat_list"] = $chat_list;
				$response['status'] = 'success';
				$response["message"] = "Successfully fetch";
				echoResponse(200, $response); 	
			} 
		}
		
		else{
			$response["error"] = false;
			//$response["data"] = $arr;
			$response["chat_list"] = $chat_list;
			$response['status'] = 'success';
			$response["message"] = "Successfully fetch";
			echoResponse(200, $response); 	
		}
	
	}else{
        $response["error"] = true;
        $response["message"] = "Failed";
        echoResponse(201, $response);
   }
   
});


$app->post('/user_chat_history', function () use ($app){
	
    $userId = $app->request->post('user_id');
    $response = array();
    $db = new DbOperation();
    $arr = array();
	$insertData = array();
	$channelId = "";
	$message = "";          

    $arr = $db->getAuthorDetails($userId); 
	$userList = array();
	
    if(!empty($arr)){
		
		$chats_hist = array();
		$chats_hist = $db->user_chat_history($userId);
		$chat_filter = array();
		$chat_filter2 = array();
		
		
		if($chats_hist){
			foreach($chats_hist as $row){
			if( !in_array($row['chid'],$chat_filter) && ($userId !=$row['user_id']) )
				{
					$chat_filter[] = $row['chid'];
					$chat_filter2[] = $row;
				}
			}
		}
		
		if($chat_filter2){
			$user_list_arr = array();
			foreach($chat_filter2 as $row){
				$is_delete = "";
				
				$wherecond_rem =" user_id = ". $userId." and channel_id = '".$row['chid']."' "; 
				$is_delete = $db->select_value("user_chats_removed", "user_id", $wherecond_rem);
							
				//$is_delete = $db->select_value("user_chats_removed", "user_id", array("user_id" => $this->input->post('userId'),"channel_id" => $row['chid']));
				
				if( (!$is_delete) && ($userId != $row['id'])){
					$img = "";
					if($row['avatar']) $img = 'upload/chats/'.$row['avatar'];
					
					$user_list_arr[] = array(
						'userId' => $row['user_id'],
						'name' => $row['name'],
						'email' => $row['email'],
						'channelId' => $row['chid'],
						'created' => $row['created'],
						'unread' => $db->has_unread($row['id'], $userId, $row['chid']),
						'avatar' => $img
					);
				}
			}
			
			$response["error"] = false;
			$response["data"] = $arr;
			$response["userList"] = $user_list_arr;
			$response["message"] = "success"; 
			echoResponse(200, $response);
		}

	}else{
		$response["error"] = true;
		$response["message"] = "Failed";
		echoResponse(201, $response);
   }
   
});


$app->post('/user_chat_list', function () use ($app){
	
    $userId = $app->request->post('user_id');
    $response = array();
    $db = new DbOperation();
    $arr = array();
	$message = "";          
    $arr = $db->getAuthorDetails($userId); 
	$userList = array();
	//echo "123";print_r($arr);exit;

    if(!empty($arr)){
		$chats_hist = array();
		$chats_hist = $db->user_chat_list_history($userId);
		//$group_detil = $db->getGropDetail($userId);
		
		/*if(!empty($group_detil)){
			
			 foreach($chats_hist as $key=>$chats_histry){
				$group_detil->is_group = "Yes";
				$chats_hist[$key]->group_detil= $group_detil;
			} 
			//$res->group_detail = $group_detil;
		}*/
		
		
		$response["error"] = false;
		$response["data"] = $arr;
		$response["userList"] = $chats_hist;
		$response["message"] = "success"; 
		echoResponse(200, $response);
	}else{
		$response["error"] = true;
		$response["message"] = "Failed";
		echoResponse(201, $response);
   }
   
});

	
	
$app->post('/delete_chat', function () use ($app){
    
	$userid = $app->request->post('user_id');
    $receiver = $app->request->post('receiver');
    $response = array();
    $db = new DbOperation();
	$receiverDetail = array();
    $arr = array();
    $arr = $db->getAuthorDetails3($userid);
	
	/* echo "<pre> reciver data";print_r($receiverDetail);
	echo "<pre>";print_r($arr);exit('sender data'); */
	
	$channelId = $arr->channel_id;
    $UpdateUerchat = $db->UpdateUserChat($userid,$channelId,$receiver);
	
    if(!empty($arr)){
		$response["error"] = false;
		$response["status"] = "Success";
		$response["userData"] = $arr;
		$response["message"] = "Chat is deleted successfully.";
		echoResponse(201, $response);		
	 }else{
	   $response["error"] = true;
       $response["message"] = "Failed";
	   $response["message"] = "Something went wrong! please try again";
       echoResponse(200, $response);
	
	}
	
});


/* user chat function start here */ 


/* public function send_push($device_id="", $messagetype="", $username="", $message="",$badge)
	{
		//$badge = (int)$userId;
		if ( $device_id!="") {				
			$apnsHost = 'gateway.sandbox.push.apple.com';	
			
			//$apnsCert = FCPATH.'application/third_party/pushcert.pem';					
			$apnsCert = FCPATH.'application/third_party/pushcert.pem';					
			$apnsPort = 2195;					
			$apnsPass = '1234';					
			$token = $device_id;	
			if($messagetype=='text'){ 	$mst = $username." :\r\n ".$message; }
			elseif($messagetype=='file'){ 	$mst = $username." has sent a file "; }
			 
			
			$payload['aps'] = array('alert' => $mst, 'badge' => $badge, 'sound' => 'default');			
			$payload['api_type'] = 'one2oneuser_chat';					
			$output = json_encode($payload);						
			$token = pack('H*', str_replace(' ', '', $token));			
			$apnsMessage = chr(0).chr(0).chr(32).$token.chr(0).chr(strlen($output)).$output;	
			$streamContext = stream_context_create();						
			stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);	
			stream_context_set_option($streamContext, 'ssl', 'passphrase', $apnsPass);			
			$apns = stream_socket_client('ssl://'.$apnsHost.':'.$apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);
			//echo json_encode($apns); die;	
			fwrite($apns, $apnsMessage);						
			fclose($apns);			
		///////////////////////////////////////////////////////////					
		}
	} */
	
/**
 * URL: http://dnddemo.com/ebooks/api/v1/sendEmailData
 * Parameters: 
 * Method: POST
 * */

$app->post('/sendEmailData', function () use ($app) {
    $emailFrom = $app->request->post('from');
    $emailto = $app->request->post('emailto');
    $subject = $app->request->post('subject');
    $message = $app->request->post('message');
    $db = new DbOperation();
    $response = array();
    $res = $db->sendEmail($emailFrom, $emailto, $subject, $message);
    if($res){
        $response["error"] = false;
        $response["message"] = "success";
        echoResponse(200, $response);
    } else if ($res == 0) {
        $response["error"] = true;
        $response["message"] = "failed";
        echoResponse(200, $response);
    }
});


	//calling api

	//URL: http://dnddemo.com/ebooks/api/v1/user_calling
	//params: user_id, sendTO, channelId
	$app->post('/user_calling', function () use ($app){
		
		verifyRequiredParams(array('user_id', 'sendTO')); 
		$userid = $app->request->post('user_id');
		$sendTO = $app->request->post('sendTO');
		$type   = $app->request->post('type');
		$channelId = $app->request->post('channelId');
		$response = array();
		$db = new DbOperation();
		$arr = array();
		$insertData = array();
		
		$message = "";          

		$UserDetails = $db->getAuthorDetails3($userid);
		$arr = $db->getAuthorDetails2($sendTO);

		//echo "<pre>";print_r($arr); die;
		
		$userList = array();
		
		if(!empty($arr)){ 
			//echo "fd";die;
			if($userid && $app->request->post('sendTO') && $channelId!=''){

				$user_details = array();
				$user_details = $arr;
				
				//$fields = "id,user_name,url,email,about_me, publisher_type,device_token, device_type,phone_no";
				//$whrcond = " id != $arr->id "; 
				//$userList = $db->getDetails("user_login_table",$fields,$whrcond);
				
				$fields_token = "id,device_token,device_type";
				$whrcond_token = " id = '".$app->request->post('sendTO')."' "; 
				$user_tokens = $db->getDetails("user_login_table",$fields_token,$whrcond_token);
				
				if($type=="audioCall") $slogon = "audioCall"; else  $slogon = "videoCall"; 
				
				if(!empty($user_tokens)){
		
					$fcmUrl = 'https://fcm.googleapis.com/fcm/send';
					$token = $arr->device_token; 
					$notification = [
						'user_id' => $UserDetails->id, 
						'UserName' => $UserDetails->user_name, 
						'Avtar' => $UserDetails->url, 
						'channel_id' => $channelId, 
						'noti_type' => "user_calling",
						'noti_msg' => $slogon,
					];						

					$extraNotificationData = ["message" => $notification];        
					$fcmNotification = [
						//'registration_ids' => $tokenList, //multple token array
						'to'        => $token, //single token
						'notification' => $notification,
						'data' => $notification
					];

					//echo "<pre>";print_r($fcmNotification);exit;

					$headers = [
					'Authorization: key='.API_ACCESS_KEY,
					'Content-Type: application/json'
					];

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,$fcmUrl);
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
					$result = curl_exec($ch);
					curl_close($ch);
					$response['pushMessaage'] = json_decode($result);
				} 
					 
					 //echo "<pre>";print_r($chats);exit('pf');	
				$response["error"] = false;
				//$response["data"] = $arr;
				$response["message_data"] = 'Message for calling';
				$response['status'] = 'success';
				$response["message"] = "Successfully fetch";
				echoResponse(200, $response); 		
			
			}else{
				
				$response["error"] = true;
				$response["message"] = "Channel Id does not exists";
				echoResponse(201, $response);
			}
		
		}else{
			
			$response["error"] = true;
			$response["message"] = "Failed";
			echoResponse(201, $response);
		}
	   
	});

	/*==============strt to group calling/message =======*/

	//URL: http://dnddemo.com/ebooks/api/v1/addEditGroups
	$app->post('/addEditGroups', function () use ($app) { 
		verifyRequiredParams(array('user_id')); 
		$group_id  			= $app->request->post('group_id');
		$group_name  		= $app->request->post('group_name');
		$user_id	 		= $app->request->post('user_id');
		$group_user_ids		= $app->request->post('group_user_id');
		
	    $group_uids	=	explode(',',$group_user_ids); 
	   
		
		$response 		= array();
		$totalMember = 10;
		$db = new DbOperation();
 
        //  echo count($exp);
        //$is_group = $db->checkGroup($group_name,$user_id);
		$is_group = array();
		if($group_id){
			$is_group = $db->checkGroup($group_id);  
		}
        
        if(!empty($is_group)) { 	
		    
			if( $user_id==$is_group->userid || in_array($user_id,explode(",",$is_group->groupuserid)) ){
				
				if(is_numeric($group_id) && $group_id!=''){
					
					//$is_group_recheck = $db->recheckGroup($group_name,$user_id);  
					$is_group_recheck = $db->recheckGroup($group_name,$group_id);  
					
					if(!$is_group_recheck){				
						$whrecond = " id ='".$group_id."'";
						$updateData = " set name='".$group_name."', updated_at='".date("Y-m-d h:i:s")."'"; 
						$res = $db->addEditRecord('groups_calling',$updateData,$whrecond);
						if($res === FALSE){
							$res = FALSE;
						}else{
							
							$res ="update_group_user_id";
						}
					}else{
						$res ="groupuserid";
					}
					
				}else{
					$res ="groupuserid";
				}
			}else{ 
				$res ="usernotallowed";
			
			}
		} 
		elseif(count($group_uids)>$totalMember) { $res = 'userid';}
        else {   
			$insData = " set name='".$group_name."', userid='".$user_id."',groupuserid='".$group_user_ids."', status='1', created_at='".date("Y-m-d h:i:s")."', type='video'"; 
			$res = $db->addEditRecord('groups_calling',$insData); 
		}

        if($res === 'userid'){
			
			$response["error"] = true;
			$response["message"] = "Not More Then 10 Member Allowed";
			echoResponse(201, $response);
           
           
        }elseif($res === 'groupuserid'){
                
			$response["error"] = true;
			$response["message"] = "Group name already exists";
			echoResponse(201, $response);
           
        }elseif($res === FALSE){
               
			$response["error"] = true;
			$response["message"] = "Group not added";
			echoResponse(201, $response);
           
        } else if($res === 'update_group_user_id'){
			
			$response["error"] = false;
			//$response["data"] = $arr;
			$response["message_data"] = 'Grop name updates sucessfully sucessfully';
			$response['status'] = 'success';
			$response["message"] = "Successfully fetch";
			echoResponse(200, $response); 		

        } elseif($res =="usernotallowed"){
			$response["error"] = true;
			$response["message"] = "You are not allowed to update group.";
			echoResponse(201, $response);
		}
		else{
			$response["error"] = false;
			//$response["data"] = $arr;
			$response["message_data"] = 'Group Added Sucessfully';
			$response['status'] = 'success';
			$response["message"] = "Successfully fetch";
			echoResponse(200, $response); 	
		}			
     
    });
	
	//http://dnddemo.com/ebooks/api/v1/groupList
	$app->post('/groupList', function () use ($app) { 
		
		verifyRequiredParams(array('user_id'));
		
		$group_id  			= $app->request->post('group_id');
		$user_id	 		= $app->request->post('user_id'); 
		$arr = array();
		$message = "";          
		
		$response 	= array();
		$db = new DbOperation();
        //$arr = $db->getAuthorDetails($user_id); 
		//$group_details = $db->getGroupDetails($user_id); 
		$group_details = $db->getGroupDetailsOK($user_id); 
		$arr['group_details']    = $group_details;
		
		if(!empty($group_details)){
			
			$response["error"] = false;
			//$response["data"] = $arr;
			$response["data"] = $group_details ;
			$response['status'] = 'success';
			$response["message"] = 'Group listed Sucessfully';
			echoResponse(200, $response); 			

        } else{
			
			$response["error"] = true;
			//$response["data"] = $arr;
			$response['status'] = 'failed';
			$response["message"] = "Group not found";
			echoResponse(200, $response); 
		}			
     
    });
	
	//http://dnddemo.com/ebooks/api/v1/groupsChat
	$app->post('/groupsChat', function () use ($app){ //used
		
		verifyRequiredParams(array('send_by', 'group_id')); 
		$send_by  		= $app->request->post('send_by'); //sender user id
		$group_id 		= $app->request->post('group_id'); //group id
		$messagetype 	= $app->request->post('message_type'); //image | text | voice | video 
		$message 		= $app->request->post('message'); 
		$sender_name 	= $app->request->post('sender_name'); 
		//$message 		= $app->request->post('video'); 
		
		//$userid = $app->request->post('user_id');
		//$sendTO = $app->request->post('sendTO');
		$response = array();
		$db = new DbOperation();
		$arr = array();
		$insertData = array();
		$channelId = "";
		
		$group_details = $db->selUserMessageGroupData($send_by,$group_id);
		
		if(!empty($group_details)){
			
			if($messagetype != "text")
			{	
				//Document file
				if(!empty($_FILES['pdf_file'])){
					$errors= array();
					if(empty($errors)==true){
						$upload_path = 'upload/chats/document/';
						$fileinfo = pathinfo($_FILES['pdf_file']['name']);
						$extension = $fileinfo['extension'];
						$message = $upload_path.'document_'.time().'.'.$extension;
						$file_path = $upload_path .'document_'.time().'.'.$extension;
						move_uploaded_file($_FILES['pdf_file']['tmp_name'], $file_path);
					}else{
						$response["error"] = true;
						$response["message"] = "file size must not be more than 2 MB";
						echoResponse(201, $response);
						exit();
					}
				}
				
				//image file
				 if(!empty($_FILES['image_file'])){ 
					 $errors= array();
					if(empty($errors)==true){
						$upload_path = 'upload/chats/gallery/'; 
						$fileinfo = pathinfo($_FILES['image_file']['name']);
						$extension = $fileinfo['extension']; 
						$message = $upload_path.'gallery_'.time().'.'.$extension; 
						$file_path = $upload_path .'gallery_'.time().'.'.$extension;
						move_uploaded_file($_FILES['image_file']['tmp_name'], $file_path);
					}else{
						$response["error"] = true;
						$response["message"] = "file size must not be more than 2 MB";
						echoResponse(201, $response);
						exit();
					}
				}
				
				//audio file
				if(!empty($_FILES['audio_file'])){
					$errors= array();
					if(empty($errors)==true){
						$upload_path = 'upload/chats/audio/';
						$fileinfo  = pathinfo($_FILES['audio_file']['name']);
						$extension = $fileinfo['extension'];
						$message   =  $upload_path.'audio_'.time().'.'.$extension;
						$file_path = $upload_path .'audio_'.time().'.'.$extension;
						move_uploaded_file($_FILES['audio_file']['tmp_name'], $file_path);
					}else{
						$response["error"] = true;
						$response["message"] = "file size must not be more than 2 MB";
						echoResponse(201, $response);
						exit();
					}
				}
				
				//video file
				 if(!empty($_FILES['video_file'])){
					 $errors= array();
					if(empty($errors)==true){
						$upload_path = 'upload/chats/video/';
						$fileinfo   = pathinfo($_FILES['video_file']['name']);
						$extension = $fileinfo['extension'];
						$message   = 	 $upload_path.'video_'.time().'.'.$extension;
						$file_path = $upload_path .'video_'.time().'.'.$extension;
						move_uploaded_file($_FILES['video_file']['tmp_name'], $file_path);
					}else{
						$response["error"] = true;
						$response["message"] = "file size must not be more than 2 MB";
						echoResponse(201, $response);
						exit();
					}
				}
			
			}else{ 
			  
				$message = addslashes($message);  
			}	
			
			$senduser 	= $db->getAuthorDetails2($send_by); //get sender user details
			
			$sendername = $senduser->user_name;
			//print_r($postDatanew); exit;
			$user_groups_ids=	explode(",",$group_details->groupuserid);
			$groupid 		=	$group_id;           
			$userid 		= 	$send_by;
			$sendtoid 		= 	$group_details->userid; //groupname
			$created_date   =   date("Y-m-d h:i:s");
			//channel_id='".$channelId."',
			
			$ins_query_goups = "set userid='".$userid."',sendtoid='".$sendtoid."',groupid='".$group_id."',messagetype='".$messagetype."',unreadmessage=0,message='".addslashes($message)."',created_at='".$created_date."',sendername='".$sender_name."' "; 
			if($message!=''){
				$group_insId = $db->addEditRecord("groupsuserschat", $ins_query_goups);	
			} 
			
			if($group_insId){
				
				//$senduser 			= $db->getAuthorDetails2($send_by);
				
				foreach($user_groups_ids as $groups_ids) {  //grus
					
					$groupid 	=  $group_id;          
					$userid     =  $send_by;
					$sendtoid 	=  $groups_ids;
					$sendername =  $sendername; 
					$rec_user_detail 	= $db->getAuthorDetails2($sendtoid);
					//echo "<pre>";print_r($rec_user_detail); die;
					$userList = array();
					//echo $rec_user_detail->device_token; die;
					if($userid && $sendtoid && $messagetype && $rec_user_detail->device_token){
						
						if($app->request->post('channelId')) {
							$channelId = $app->request->post('channelId');
						}else {
							$channelId = rand(100000, 999999); 
						}
						
						$ins_query_goups = "set userid='".$userid."',sendtoid='".$sendtoid."',groupid='".$group_id."',messagetype='".$messagetype."',unreadmessage=0,message='".addslashes($message)."',created_at='".$created_date."',sendername='".$sender_name."'"; 
						if($message!=''){
							$group_idd = $db->addEditRecord("groupsuserschat", $ins_query_goups);	
						}
						
						$user_details = array();
						$user_details = $rec_user_detail;
						
						if(!empty($rec_user_detail)){
							
								//$sendTO = $sendtoid;
								
								
								$badge = 0;
								//var_dump($user_list_arr);
								
								/* foreach ($user_tokens as $key => $value) {
									$this->send_push(@$value["pushtoken"], $app->request->post('type'), @$user_details->name, $message,$badge);
								} */
						//}
										 
							$chats = array();
							//$chats = $db->user_chats($channelId);
							if(!empty($messagetype)){
								
								if($messagetype == 'file'){
									$messagetype = 'File';
								}elseif($messagetype == 'image'){
									$messagetype = 'Image';
								}elseif($messagetype == 'audio'){
									$messagetype = 'Audio';
								}elseif($messagetype == 'video'){
									$messagetype = 'Video';
								}elseif($messagetype == 'docfile'){
									$messagetype = 'Docfile';
								}else if($messagetype=="text"){
									$messagetype = addslashes($app->request->post('message'));
								}
								
								//'channel_id' => $channelId, 
								$fcmUrl = 'https://fcm.googleapis.com/fcm/send';
								//$token = $senduser->device_token; 
								$token = $rec_user_detail->device_token; 
								$notification = [
									'user_id' => $senduser->id, 
									'UserName' => $senduser->user_name, 
									'Avtar' => $senduser->url, 
									'channel_id' => $group_id, 
									'noti_type' => "group", 
									'noti_msg' => $messagetype,
									
								];
								$extraNotificationData = ["message" => $notification];        
								$fcmNotification = [
									//'registration_ids' => $tokenList, //multple token array
									'to'        => $token, //single token
									'notification' => $notification,
									'data' => $notification
								];

								//echo "<pre>";print_r($fcmNotification);exit;

								$headers = [
								'Authorization: key='.API_ACCESS_KEY,
								'Content-Type: application/json'
								];

								$ch = curl_init();
								curl_setopt($ch, CURLOPT_URL,$fcmUrl);
								curl_setopt($ch, CURLOPT_POST, true);
								curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
								curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
								$result = curl_exec($ch);
								curl_close($ch);
								$response['pushMessaage'] = json_decode($result);
								
								
							}  
						
						}
						   //echo "<pre>";print_r($chats);exit('pf');
					}
					
					$response["error"] = false;
					$response["data"] = $arr;
					$response["chat_list"] = $rec_user_detail->device_token;
					$response['status'] = 'success';
					$response["message"] = "Successfully sent";
					echoResponse(200, $response);
				} //end of foeach loop
			
			}else{
					$response["error"] = true;
					$response["message"] = "Failed";
					echoResponse(201, $response);
			}
		
		}else{
			$response["error"] = true;
			$response['status'] = 'failed';
			$response["message"] = "Group does not exists";
			echoResponse(201, $response);
		}

	});
	
	//http://dnddemo.com/ebooks/api/v1/getGroupChatLists
	$app->post('/getGroupChatLists', function () use ($app) {  // getgroupsmessgaebyuserid
		
		verifyRequiredParams(array('user_id','group_id')); 
		$group_id  			= $app->request->post('group_id');
		$user_id	 		= $app->request->post('user_id'); 
		$unreadmessage      = 1;
		$arr = array();
		$response 	= array();
		if(is_numeric($user_id) && $user_id!='' && is_numeric($group_id) && $group_id!=''){
			
			$db = new DbOperation();
			
			/* $datan = array('unreadmessage' => 1);  
			$this->db->where('groupid', $data['groupid']);
			$this->db->where('sendtoid', $data['userid']);
			$this->db->update('groupsuserschat', $datan); 
			$groupupdate = $this->group_model->selectuserreadstatus($postDatavals);*/
			
			$fields_token = "";
			$whrcond_token = " (sendtoid = '".$user_id."' or userid = '".$user_id."') AND groupid = '".$group_id."' AND status = '1'"; 
			$group_user_chat_list = $db->getGroupChats($user_id,$group_id);
			
			if(!empty($group_user_chat_list)){
				
				$response["error"] = false;
				//$response["data"] = $arr;
				$response["data"] = $group_user_chat_list ;
				$response['status'] = 'success';
				$response["message"] = 'Group chat listed sucessfully';
				echoResponse(200, $response); 
				
			} else {
				$response["error"] = true;
				//$response["data"] = $arr;
				$response['status'] = 'failed';
				$response["message"] = "Message not found";
				echoResponse(200, $response); 
			}
		}else{
			$response["error"] = true;
			//$response["data"] = $arr;
			$response['status'] = 'failed';
			$response["message"] = "Something went wrong! user not found.";
			echoResponse(200, $response); 
		}

    });
	
	
	//http://dnddemo.com/ebooks/api/v1/removeGroupChatByUser
	$app->post('/removeGroupChatByUser', function () use ($app) {  // removegroupsmessgaebyuserid
		
		verifyRequiredParams(array('user_id','group_id')); 
		$group_id  			= $app->request->post('group_id');
		$user_id	 		= $app->request->post('user_id'); 
		$action	 			= $app->request->post('action');  //all,selected,single
		$chat_id	 		= $app->request->post('chat_id');  
		$unreadmessage      = 1;
		$arr = array(); 
		$response 	= array();
		
		if(is_numeric($user_id) && $user_id!='' && is_numeric($group_id) && $group_id!=''){
			
			$db = new DbOperation();

		    $group_row_data = $db->selRecordByGroupId($group_id);
			
			$res='';
			//if($group_row_data->userid==$user_id && $action=="all"){
			if($group_row_data->userid && $action=="all"){
				
				$whrecond = " groupid ='".$group_id."'";
				$updateData = " set userdelete='1', deleted_at='".date("Y-m-d h:i:s")."'"; 
				$res = $db->addEditRecord('groupsuserschat',$updateData,$whrecond);

			//}else if($group_row_data->userid==$user_id && $action=="selected"){
			}else if($group_row_data->userid && $action=="selected" && $chat_id!=''){
				
				//$whrecond = " groupid ='".$chat_id."'";
				$whrecond = " groupid in('".$chat_id."')";
				$updateData = " set userdelete='1', deleted_at='".date("Y-m-d h:i:s")."'"; 
				$res = $db->addEditRecord('groupsuserschat',$updateData,$whrecond);
			}
			
			if(!empty($res)){
				
				$response["error"] = false;
				//$response["data"] = $group_user_chat_list ;
				$response['status'] = 'success';
				$response["message"] = 'Group chat deleted sucessfully';
				echoResponse(200, $response); 
				
			} else {
				$response["error"] = true;
				//$response["data"] = $arr;
				$response['status'] = 'failed';
				$response["message"] = "Message not deleted";
				echoResponse(200, $response); 
			}
		}else{
			$response["error"] = true;
			//$response["data"] = $arr;
			$response['status'] = 'failed';
			$response["message"] = "Something went wrong! user not found.";
			echoResponse(200, $response); 
		}

    });
	
	
	//http://dnddemo.com/ebooks/api/v1/groupMemberList	
	$app->post('/groupMemberList', function () use ($app) {  //used  
		
		verifyRequiredParams(array('user_id','group_id'));
		
		$group_id  			 = $app->request->post('group_id');
		$user_id  			 = $app->request->post('user_id');
		$add_mem_id_in_group = $app->request->post('add_mem_id_in_group');
		$action  			 = $app->request->post('action'); 
		//$type  				= $app->request->post('type');
		$arr = array();
		$message = "";   
		$final_data   = array(); 
		$response 	= array();
		$db = new DbOperation();
		$senduser 		  =  $db->getAuthorDetails2($user_id);
		$user_groups_list =  $db->selUserMessageGroupData($user_id,$group_id);
        	
		$is_admin_id 	  =  $user_groups_list->userid;
		
		if($add_mem_id_in_group && $user_groups_list->groupuserid!='' && $action=="delete_member"){//delete member
			
			$group_member_array = explode(",",$user_groups_list->groupuserid);
			
			$delete_member_id	= array($add_mem_id_in_group);

			$user_groups_ids    = array_diff($group_member_array, $delete_member_id);
			
			$array_without_id   = implode(",",$user_groups_ids);
			
			if($user_groups_list->removegroupuserid!=''){
				if(in_array($add_mem_id_in_group,explode(",",$user_groups_list->removegroupuserid))){
					$removed_user_ids = $user_groups_list->removegroupuserid;
				}else{
					$removed_user_ids = $user_groups_list->removegroupuserid.",".$add_mem_id_in_group;
				}
			}else{
				$removed_user_ids = $add_mem_id_in_group;
			}
			
			$all_groups_mem_lists = implode(",",$user_groups_ids);
			$whrecond = " id ='".$group_id."'";
			$updateData = " set groupuserid='".$all_groups_mem_lists."',removegroupuserid ='".$removed_user_ids."'"; 
			$res 	   = $db->addEditRecord('groups_calling',$updateData,$whrecond); //update user group
			if($res === FALSE){
				//$user_groups_ids  =  explode(",",$user_groups_list->groupuserid);
				$user_groups_ids  =  $group_member_array;
				$action_message   = "Member not deleted, please try again.";
			}else{
				
				$user_groups_ids  =  $user_groups_ids;
				$action_message   = "Member has been deleted sucessfully.";
			} //&& $user_groups_list->groupuserid!=''
		} else if($add_mem_id_in_group  && $action=="add_member"){ //add member
			
			$removed_user_ids  		 =  '';
			$removed_user_ids        = $user_groups_list->removegroupuserid;
			$removed_user_ids_array  =  explode(",",$user_groups_list->removegroupuserid);
			$add_member_id			 =  array($add_mem_id_in_group);
			
			if($removed_user_ids!=''){
				
				$new_removed_user_ids   =  array_diff($removed_user_ids_array, $add_member_id);
				//echo $position = array_search($add_mem_id_in_group,$new_removed_user_ids); 
				$position = array_search($add_mem_id_in_group,$removed_user_ids_array);		
				unset($removed_user_ids_array[$position]);  //remove existing 
				if(count($removed_user_ids_array)>0){
					$removed_user_ids       =  implode(",",$removed_user_ids_array);
				}else{
					$removed_user_ids       =  '';
				}
			}else{
				$removed_user_ids   = '';	
			}
			if($user_groups_list->groupuserid!=''){
				$user_groups_ids_array  =  explode(",",$user_groups_list->groupuserid);
				if(in_array($add_mem_id_in_group,$user_groups_ids_array)){
					$all_groups_mem_lists = $user_groups_list->groupuserid;
				}else{
					$all_groups_mem_lists = $user_groups_list->groupuserid.",".$add_mem_id_in_group;
				}
			}else{
				$all_groups_mem_lists = $add_mem_id_in_group; 
			}
			$whrecond = " id ='".$group_id."'";
			
			$updateData = " set groupuserid='".$all_groups_mem_lists."',removegroupuserid ='".$removed_user_ids."'"; 
			
			$res = $db->addEditRecord('groups_calling',$updateData,$whrecond); //update user group
			if($res === FALSE){
				$user_groups_ids  =  explode(",",$all_groups_mem_lists);
				$action_message  = "Sorry, member has not been added please try again.";
			}else{
				
				$user_groups_ids =  explode(",",$all_groups_mem_lists);
				$action_message  = "Member has been added sucessfully.";
			}
		}else{
			$user_groups_list =  $db->selUserMessageGroupData($user_id,$group_id);
			if($user_groups_list->groupuserid!=''){
				$user_groups_ids  =  explode(",",$user_groups_list->groupuserid); //list member
			}else{
				$user_groups_ids  =  explode(",",$user_groups_list->userid);
			}

		}
		
		
		if(!empty($user_groups_list)){
			
			$removedUserId = explode(",", $user_groups_list->removegroupuserid);
			
			
			if(!in_array($is_logged_id,$user_groups_ids)){
				array_push($user_groups_ids, $is_admin_id);
			}
			
			sort($user_groups_ids);
			
			$user_groups_idsss = implode(',',$user_groups_ids);
			
			//if (!in_array($user_id, $removedUserId)) {
				//if( $user_groups_list->groupuserid!='') {
					
				$groupuser = $db->selectUsersByGroup($user_groups_idsss);
				
				if(!empty($groupuser)){	
					
					foreach($groupuser as $key=>$gusers){ 
						
						if($gusers->id==$is_admin_id){
							$final_data[$key]['is_admin'] = "Yes"; 
						}else{
							$final_data[$key]['is_admin'] = "No"; 
						}
						$final_data[$key]['id'] = $gusers->id; 
						$final_data[$key]['user_name'] = $gusers->user_name;
						$final_data[$key]['url'] = $gusers->url;
						$final_data[$key]['device_token'] = $gusers->device_token;
						$final_data[$key]['android'] = $gusers->android;
						/* $final_data[$key]->user_name = $gusers->user_name;
						$final_data[$key]->url = $gusers->url;
						$final_data[$key]->device_token = $gusers->device_token;
						$final_data[$key]->android = $gusers->android;  */
					}
					
					  //  print_r($groupuser);
					/* $final_group[] = array(
					    "id" => $user_groups_list[$key]->id,
						"name" => $user_groups_list[$key]->name,
						"userid" => $user_groups_list[$key]->userid,
						"groupuserid" => $groupuser,
						"status" => $user_groups_list[$key]->status,
						"created_at" => $user_groups_list[$key]->created_at,
						"removegroupuserid"=>$user_groups_list[$key]->removegroupuserid,
						
						
					); */
				   $final_data =  $final_data;     
				}else{
					$final_data = '';
				}
			//}
			
		
		}else{$final_data='';}
		
		if($final_data!=''){
			
			$response["error"] = false;
			$response["data"] = $senduser;
			$response["user_list"] = $final_data;
			$response['status'] = 'success';
			$response["action_message"] = $action_message;
			$response["message"] = "Group user lists";
			echoResponse(200, $response);
			
		}else{
			
			$response["error"] = true;
			//$response["data"] = $arr;
			$response['status'] = 'failed';
			$response["message"] = "Group not available";
			echoResponse(200, $response); 
		}
				
    });
	
	//http://dnddemo.com/ebooks/api/v1/exitMemberFromGroup	
	
	$app->post('/exitMemberFromGroup', function () use ($app) {  //used  
		
		verifyRequiredParams(array('user_id','group_id'));
		
		$group_id  			 = $app->request->post('group_id');
		$user_id  			 = $app->request->post('user_id');
		$tomake_admin_id     = $app->request->post('tomake_admin_id');
		//$action  			 = $app->request->post('action'); 
		//$type  				= $app->request->post('type');
		$arr = array();
		$message = "";   
		$final_data   = array(); 
		$response 	= array();
		$db = new DbOperation();
		//$senduser 		  =  $db->getAuthorDetails2($user_id);
		//$user_groups_list =  $db->selUserMessageGroupData($user_id,$group_id);
		$user_groups_list =  $db->selRecordByGroupId($group_id);
        	
		$is_admin_id 	  =  $user_groups_list->userid; 
		
	
		if( ($user_id===$is_admin_id)){
			
			if($tomake_admin_id){
				$tomake_admin_id = $tomake_admin_id;
				$remove_id_from_groupid = $tomake_admin_id;
				$remove_mem_id 	 = "Yes";
			}else{  
				$tomake_admin_id = '';
				$remove_id_from_groupid = '';
				$remove_mem_id 	 = "No";
			}
		}else{ 
			$tomake_admin_id = '';
			$remove_id_from_groupid = $user_id;
			$remove_mem_id 	 = "Yes";
			
		}
		
		if($remove_mem_id=="Yes"){
			
			if( ($remove_id_from_groupid) && ( in_array($user_id, explode(",",$user_groups_list->groupuserid)) || in_array($user_id, explode(",",$user_groups_list->userid))) ){ 
				 
				$all_groups_mem_lists  		 =  '';
				$all_groups_mem_lists        =  $user_groups_list->groupuserid;
				$removed_user_ids_array  	=  explode(",",$user_groups_list->groupuserid);
				$add_member_id			 	=  array($remove_id_from_groupid);
				
				if($all_groups_mem_lists!=''){
					 
					$position = array_search($remove_id_from_groupid,$removed_user_ids_array);		
					unset($removed_user_ids_array[$position]);  //remove existing 
					if(count($removed_user_ids_array)>0){
						$all_groups_mem_lists       =  implode(",",$removed_user_ids_array);
					}else{
						$all_groups_mem_lists       =  '';
					}
				}else{
					$all_groups_mem_lists   = '';
					 
				}
				//echo $all_groups_mem_lists; 
				if($user_groups_list->removegroupuserid!=''){
					
					if($tomake_admin_id) 
						$remove_id_from_groupid	=	$user_id; 
					else 
						$remove_id_from_groupid	=	$remove_id_from_groupid;
					
					$removed_group_ids_array  =  explode(",",$user_groups_list->removegroupuserid);
					if(in_array($remove_id_from_groupid,$removed_group_ids_array)){
						$removed_user_ids = $user_groups_list->removegroupuserid;
					}else{
						$removed_user_ids = $user_groups_list->removegroupuserid.",".$remove_id_from_groupid;
					}
				}else{
					$removed_user_ids = $remove_id_from_groupid;
				}
				
				if(is_numeric($tomake_admin_id) && $tomake_admin_id!=''){
					
					$updateData = " set userid='".$tomake_admin_id."', groupuserid='".$all_groups_mem_lists."',removegroupuserid ='".$removed_user_ids."'"; 
				}else {
					
					$updateData = " set groupuserid='".$all_groups_mem_lists."',removegroupuserid ='".$removed_user_ids."'"; 
				}
				
				$whrecond = " id ='".$group_id."'";
				
				$res = $db->addEditRecord('groups_calling',$updateData,$whrecond); //update user group
				if($res === FALSE){
					//$user_groups_ids  =  explode(",",$all_groups_mem_lists);
					
					$response["error"] = true;
					//$response["data"] = $arr;
					$response['status'] = 'failed';
					$response["message"] = "Something went wrong! please try again.";
					echoResponse(200, $response); 
				
				}else{
					
					//$user_groups_ids =  explode(",",$all_groups_mem_lists);
					$response["error"] = true;
					//$response["data"] = $arr;
					$response['status'] = 'failed';
					$response["message"] = "Member has been removed sucessfully.";
					echoResponse(200, $response); 
				}
			}else{
				
				$response["error"] = true;
				//$response["data"] = $arr;
				$response['status'] = 'failed';
				$response["message"] = "Pleae provide member id.";
				echoResponse(200, $response); 
	
				/* $user_groups_list->groupuserid; 
				$user_groups_ids  =  explode(",",$user_groups_list->groupuserid); //list member */
			  
			}
		}else{
			$response["error"] = true;
			//$response["data"] = $arr;
			$response['status'] = 'failed';
			$response["message"] = "Please create admin to any member then exit.";
			echoResponse(200, $response); 
		}	
					
    });

	//http://dnddemo.com/ebooks/api/v1/groupMemberCallingNotification	
	$app->post('/groupMemberCallingNotification', function () use ($app) {  //used 
		
		verifyRequiredParams(array('user_id','group_id'));
		
		$group_id  			= $app->request->post('group_id');
	
		$user_id  			= $app->request->post('user_id');
	
		$type  				= $app->request->post('type');
		
		$group_call_users_id= $app->request->post('group_call_users_id');
		
		
		$arr = array();
	
		$response 	= array();
		$db = new DbOperation();
		$senduser 		  =  $db->getAuthorDetails2($user_id );
		
		//$user_groups_list =  $db->selUserMessageGroupData($user_id,$group_id);
	    $user_groups_ids  =  explode(",",$group_call_users_id);
		
		if(!empty($user_groups_ids)){ 
			
			//$groupuser = $db->selectUsersByGroup($user_groups_list->groupuserid); //get users list based on ids
			$receiver_details = array();
			
			foreach($user_groups_ids as $members_id) {  
				 
				$groupid 	=  $group_id;          
				$sendtoid 	=  $members_id;
				$sendername =  $senduser->user_name; 
				$rec_user_detail 	= $db->getAuthorDetails2($sendtoid);
				
			
				//echo "<pre>";print_r($rec_user_detail); die;
				$userList = array();
				//echo $rec_user_detail->device_token; die;
				
				if(is_numeric($sendtoid) && $user_id && $rec_user_detail->device_token!=''){
					
					$receiver_details[] = $rec_user_detail;
					
					$user_details = array();
					$user_details = $rec_user_detail;
					
					$chats = array();
					
					if($type=="audioCall") $slogon = "audioCall"; else  $slogon = "videoCall"; 
					
					
					//'channel_id' => $channelId, 
					$fcmUrl = 'https://fcm.googleapis.com/fcm/send';
					//$token = $senduser->device_token; 
					$token = $rec_user_detail->device_token; 
					$notification = [
						'user_id' => $senduser->id, 
						'UserName' => $senduser->user_name, 
						'Avtar' => $senduser->url, 
						'channel_id' => $groupid,  
						'noti_msg' => $slogon, 
					];
					$extraNotificationData = ["message" => $notification];        
					$fcmNotification = [
						//'registration_ids' => $tokenList, //multple token array
						'to'        => $token, //single token
						'notification' => $notification,
						'data' => $notification
					];

					//echo "<pre>";print_r($fcmNotification);exit;

					$headers = [
					'Authorization: key='.API_ACCESS_KEY,
					'Content-Type: application/json'
					];

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,$fcmUrl);
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
					$result = curl_exec($ch);
					curl_close($ch);
					$response['pushMessaage'] = json_decode($result);
					
					$noti_send[] = $sendtoid;	
					
				} 
				//echo "<pre>";print_r($chats);exit('pf');
			} //end of foeach loop
		}else { $noti_send[] = '';} 		
		
		if(!empty($noti_send)){
			
			$response["error"] = false;
			$response["sender_data"] = $senduser;
			$response["rece_deta"] = $receiver_details;
			$response['status'] = 'success';
			$response["message"] = "Successfully sent";
			echoResponse(200, $response);
			
		}else{
			
			$response["error"] = true;
			//$response["data"] = $arr;
			$response['status'] = 'failed';
			$response["message"] = "Call not allowed because member not available.";
			echoResponse(200, $response);
		}

     
    });
	
	//http://dnddemo.com/ebooks/api/v1/uploadGroupPic	
	$app->post('/uploadGroupPic', function () use ($app) {
		
		verifyRequiredParams(array('user_id','group_id'));
		
		$group_id  			 = $app->request->post('group_id');
		$user_id  			 = $app->request->post('user_id');
		$action  			 = $app->request->post('action'); 
		$message = "";   
		$lang = 'en';
		$response 	= array();
		$db = new DbOperation();
		//$senduser 		  =  $db->getAuthorDetails2($user_id);
		$user_groups_list =  $db->selUserMessageGroupData($user_id,$group_id);	
		
		$is_admin_id 	  =  $user_groups_list->userid;
		
		if( $user_id==$user_groups_list->userid || in_array($user_id,explode(",",$user_groups_list->groupuserid)) ){
		//if($is_admin_id==$user_id){
			
			$upload_path = 'upload/group/';
		    
			if($action=="delete"){
				//delete image code here
				
				 if(file_exists($_SERVER['DOCUMENT_ROOT'].'/ebooks/api/v1/'.$user_groups_list->group_image)){	
					if($user_groups_list->group_image!=''){
						unlink($_SERVER['DOCUMENT_ROOT'].'/ebooks/api/v1/'.$user_groups_list->group_image);
					}
					$updateData = " set group_image=''"; 
					$whrecond = " id ='".$group_id."'";
					$res = $db->addEditRecord('groups_calling',$updateData,$whrecond); //update group
					if($res === FALSE){
						$uploaded="No";
						$_['en_message'] = "Group profile has not been deleted, please try again.";						
					}else{
						$uploaded="Yes"; 
						$_['en_message'] = "Group profile deleted sucessfully.";
					}
				}
				$user_groups_list =  $db->selUserMessageGroupData($user_id,$group_id);
				$group_pic = '';
				if($user_groups_list->group_image!=''){
					$group_pic = $_SERVER['HTTP_HOST'].'/ebooks/api/v1/'.strip_tags($user_groups_list->group_image);
				}
				
				
			}
			else
			{
				
				$fileinfo = pathinfo($_FILES['group_image']['name']);
				
				$extension = $fileinfo['extension'];
				if ( !empty($extension) && !empty($fileinfo['filename'])){
					//$file_url = $upload_url . 'face_' . time() . '.' . $extension;
					$file_path = $upload_path . 'group_'.$fileinfo['filename'].'_' . time() . '.' . $extension;
					$is_uploaded = move_uploaded_file($_FILES['group_image']['tmp_name'], $file_path);
					if($is_uploaded){
						$updateData = " set group_image='".$file_path."'"; 
						$whrecond = " id ='".$group_id."'";
						$res = $db->addEditRecord('groups_calling',$updateData,$whrecond); //update user group
						if($res === FALSE){
							$uploaded="No"; 
							
						}else{ 
							if(file_exists($_SERVER['DOCUMENT_ROOT'].'/ebooks/api/v1/'.$user_groups_list->group_image)){
								 
								if($user_groups_list->group_image!=''){ 
									unlink($_SERVER['DOCUMENT_ROOT'].'/ebooks/api/v1/'.$user_groups_list->group_image);
								}
								
							}
							$user_groups_list =  $db->selUserMessageGroupData($user_id,$group_id);
							$group_pic = '';
							if($user_groups_list->group_image!=''){
								$group_pic = $_SERVER['HTTP_HOST'].'/ebooks/api/v1/'.strip_tags($user_groups_list->group_image);
							}
							
							$uploaded="Yes"; 
							$_['en_message'] = "Group profile add/update sucessfully.";
						}

					}else{
						$uploaded="No";
						$_['en_message'] = "Image has not been upload pleae try again.";						
					}
				}else{
					$_['en_message'] = "Image should not empty.";
					$uploaded="No"; 
				}
				
			}
			
			if($uploaded=="No"){

				$response["error"] = true;
				//$response["data"] = $arr;
				$response['status'] = 'failed';
				$response["message"] = $_[$lang . '_message'];
				echoResponse(200, $response);
			}else{
				$response["error"] = false;
				$response["group_image"] = $group_pic;
				$response['status'] = 'success';
				$response['message'] = $_[$lang . '_message'];
				echoResponse(200, $response);
			}

		}else{
			$response["error"] = true;
			//$response["data"] = $arr;
			$response['status'] = 'failed';
			$response["message"] = "You can\'t upload/delete group picture.";
			echoResponse(200, $response);
		}
	});

	//http://dnddemo.com/ebooks/api/v1/displayGroupNameAndPic	
	$app->post('/displayGroupNameAndPic', function () use ($app) {
		
		verifyRequiredParams(array('user_id','group_id'));
		$group_id  			 = $app->request->post('group_id');
		$user_id  			 = $app->request->post('user_id');
		$message = "";   
		$lang = 'en';
		$response 	= array();
		$db = new DbOperation();
		//$senduser 		  =  $db->getAuthorDetails2($user_id);
		$user_groups_list =  $db->selUserMessageGroupData($user_id,$group_id);	
		$is_admin_id 	  =  $user_groups_list->userid;
		
		if( $user_id==$user_groups_list->userid || in_array($user_id,explode(",",$user_groups_list->groupuserid)) ){
		//if($is_admin_id==$user_id){
			
			$upload_path = 'upload/group/';
		    $group_pic = '';
			if(file_exists($_SERVER['DOCUMENT_ROOT'].'/ebooks/api/v1/'.$user_groups_list->group_image)){ 
				if($user_groups_list->group_image!=''){
					$group_pic = $_SERVER['HTTP_HOST'].'/ebooks/api/v1/'.strip_tags($user_groups_list->group_image);
				}
			}
			
			$_['en_message'] = "Group profile listed below.";
			$user_groups_list->group_image = $group_pic;
			$response["error"] = false;
			$response["group_detail"] = $user_groups_list;
			$response['status'] = 'success';
			$response['message'] = $_[$lang . '_message'];
			echoResponse(200, $response);	
		}else{
			$_['en_message'] = "No data available.";
			$response["error"] = true;
			//$response["data"] = $arr;
			$response['status'] = 'failed';
			$response["message"] = $_[$lang . '_message'];
			echoResponse(200, $response);
		}
	});
	


/*==============end to group calling/message =======*/

//not used yet
//http://dnddemo.com/ebooks/api/v1/groupMessageList
	$app->post('/groupMessageList', function () use ($app) {  // getgroupsuserdata groupsmessagelist
		
		verifyRequiredParams(array('user_id')); 
		$group_id  			= $app->request->post('group_id');
		//$group_name  		= $app->request->post('group_name');
		$user_id	 		= $app->request->post('user_id'); 
		$arr = array();
		$response 	= array();
		if(is_numeric($user_id) && $user_id!=''){
			
			$db = new DbOperation();
			
			$user_list_group = $db->userGroupList($user_id);         
			
			if(!empty($user_list_group)){
				
				foreach($user_list_group as $key => $value){ 
					$removedUserId = explode(",", $user_list_group[$key]->removegroupuserid);
					if (!in_array($user_id, $removedUserId)) {
						if( $user_list_group[$key]->groupuserid!='') {
							$groupuser = $db->selectUsersByGroup($user_list_group[$key]->groupuserid);  
							  //  print_r($groupuser);
							$final_group[] = array(
								"id" => $user_list_group[$key]->id,
								"name" => $user_list_group[$key]->name,
								"userid" => $user_list_group[$key]->userid,
								"groupuserid" => $groupuser,
								"status" => $user_list_group[$key]->status,
								"created_at" => $user_list_group[$key]->created_at,
								"removegroupuserid"=>$user_list_group[$key]->removegroupuserid,
							);
						   $final_data =  $final_group;     
						}
					}
				}
			
			}else{$final_data='';}
			
			if (!empty($final_data)) {
				 $response["error"] = false;
				//$response["data"] = $arr;
				$response["data"] = $group_details ;
				$response['status'] = 'success';
				$response["message"] = 'Group listed Sucessfully';
				echoResponse(200, $response); 
			} else {
				$response["error"] = true;
				//$response["data"] = $arr;
				$response['status'] = 'failed';
				$response["message"] = "Group not found";
				echoResponse(200, $response); 
			}
		}else{
			$response["error"] = true;
			//$response["data"] = $arr;
			$response['status'] = 'failed';
			$response["message"] = "Something went wrong! user not found.";
			echoResponse(200, $response); 
		}

    });

/********************************************************************************/

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
