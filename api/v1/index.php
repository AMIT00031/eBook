<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
require_once '../include/DbOperation.php';
require_once '../include/Braintree_lib.php';
require '.././libs/Slim/Slim.php';
\Slim\Slim::registerAutoloader();
define('API_ACCESS_KEY','AAAA2RSvweQ:APA91bEnwlkf53HXU4559AUAIgsoEgnPLwDT3tw1cpju0WIPPdguWgmYEHHWGONZ4aNaxn8jAw0s5lbNbbJqFd1w-aEnHJ-5G-36bw3m5lj3u53e15RoERzNBoUX8O8cam40Qmy77d8G'); 

/*define("ROOT_FOLDER","/ebooks/development/");
define("DOCUMENTROOT",$_SERVER['DOCUMENT_ROOT'].ROOT_FOLDER);*/

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
    $about_me = $app->request->post('about_me');
        $upload_path = 'upload/';
        $fileinfo = pathinfo($_FILES['image']['name']);
        $extension = $fileinfo['extension'];
        $file_url = $upload_url . 'pic_' . time() . '.' . $extension;
        $file_path = $upload_path . 'pic_' . time() . '.' . $extension;
        move_uploaded_file($_FILES['image']['tmp_name'], $file_path);

    $db = new DbOperation();
    $res = $db->createUser($full_name, $password, $email, $phone_no,$file_url, $device_token, $device_type, $random_number, $country, $gender, $publisher_type, $user_name,$about_me);
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
    /*echo "<pre>";print_r($_FILES);*/
    	/*$_POST = json_decode($_POST['questiondata']);
    echo "<pre>";print_r($_POST);exit;*/
    verifyRequiredParams(array('user_id','category_id','book_title'));
    $response = array();  
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
        $questionData = $db->addAssignment($bookId,$user_id,$question);
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
	echo "<pre>";print_r($res);
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
    if(!empty($arr)){
        $bookList = $db->getAuthorBooklist($arr->id);
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
    $description = $app->request->post('description');

        $db = new DbOperation();
        $arr = array();
        $arr = $db->craeteNoteBook($user_id,$description);

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
    $description = $app->request->post('description');

        $db = new DbOperation();
        $arr = array();
        $arr = $db->UpdateNote($note_id,$description);

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


$app->post('/user_list', function () use ($app){
	
    $userid = $app->request->post('user_id');
    $response = array();
    $db = new DbOperation();
    $arr = array();

    $arr = $db->getAuthorDetails($userid); 
	$userList = array();
	
    if(!empty($arr)){
		
		$fields = "id,user_name,chat_id,url,email,about_me, publisher_type,device_token, device_type,phone_no,status";
		$whrcond = " id != $arr->id "; 
        $userList = $db->getDetails("user_login_table",$fields,$whrcond);
       // echo "<pre>";print_r($userList);exit; 

		 if(!empty($userList))
		 { 
			foreach($userList as $row)
			{
				$img = "";

				if($row['avatar']) $img = 'upload/chats/'.$row['avatar'];
				$channelId = "";
				$channelId = $db->has_channel($row['id'], $userid);
				
				$is_delete = "";
				if($channelId){
					$wherecond_rem =" user_id = ".$row['id']." and channel_id = $channelId ";  
					$is_delete = $db->select_value("user_chats_removed", "user_id", $wherecond_rem);
				}/* else{
					$wherecond_rem =" user_id = ".$row['id'];
				
				} */
				
				if($is_delete) $channelId = "";
				
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



//require to work on this
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

	//echo "<pre>";print_r($UserDetails);exit;
	
	$userList = array();
	
    if(!empty($arr)){ 
		
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
			
			
				/* if(isset($_FILES['message'])){
				  $errors= array();
				  $newFileName ="";
				  $file_name ="";
				  $file_size ="";
				  $file_tmp ="";
				  $file_type ="";
				  $file_ext ="";
				  
				  $file_name = $_FILES['message']['name'];
				  $file_size =$_FILES['message']['size'];
				  $file_tmp =$_FILES['message']['tmp_name'];
				  $file_type=$_FILES['message']['type'];
				  $file_ext= strtolower(pathinfo($_FILES['message']['name'], PATHINFO_EXTENSION));
				  
				  if(empty($errors)==true){
					$newFileName = uniqid('uploaded-', true) . '.' . strtolower(pathinfo($_FILES['message']['name'], PATHINFO_EXTENSION));
					move_uploaded_file($_FILES['message']['tmp_name'], 'upload/chats/' . $newFileName);
					 //move_uploaded_file($file_tmp,"images/".$file_name);
					$message = $newFileName;
					
				  }else{
					//print_r($errors);
					$response["error"] = true;
					$response["message"] = "file size must not be more than 2 MB";
					echoResponse(201, $response);
					exit();
					
				  }
				} */
			}else{ 
				$message = $app->request->post('message');
			}
			
			$query_state = "set channel_id='".$channelId."',sender='".$userid."',receiver='".$app->request->post('sendTO')."',type='".$app->request->post('type')."',message='".$message."' "; 
			if($message!=''){
				$insId = $db->addEditRecord("user_chats", $query_state);	
			}
			
			$user_details = array();
			$user_details = $arr;
			
			//$fields = "id,user_name,chat_id,url,email,about_me, publisher_type,device_token, device_type,phone_no";
			//$whrcond = " id != $arr->id "; 
			//$userList = $db->getDetails("user_login_table",$fields,$whrcond);
			
			$fields_token = "id,deviceid,pushtoken";
			$whrcond_token = " user_id = '".$app->request->post('sendTO')."' "; 
			$user_tokens = $db->getDetails("user_device_token",$fields_token,$whrcond_token);
			
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
						'channel_id' => $UserDetails->channel_id, 
						'noti_msg' => $message,
					];
					
					//echo "<pre>";print_r($notification);exit;

					$extraNotificationData = ["message" => $notification];        
					$fcmNotification = [
						//'registration_ids' => $tokenList, //multple token array
						'to'        => $token, //single token
						'notification' => $notification,
						'data' => $extraNotificationData
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
					//echo "<pre>";print_r($arr);exit('push data');
					
					$response["error"] = false;
					$response["data"] = $arr;
					$response["chat_list"] = $chat_list;
					$response['status'] = 'success';
					$response["message"] = "Successfully fetch";
					echoResponse(200, $response); 
					
				}
			
		}
		
		elseif($userid && $app->request->post('channelId')){
			
			
			$chats = array(); 
		
			$chats = $db->user_chats($app->request->post('channelId'));               
			
			
			if($chats)
			{       
		 
                //delete case
				$where_del_cond = "user_id='".$app->request->post('sendTO')."' and channel_id='".$app->request->post('channelId')."' ";
				$db->delete_data("user_chats_removed", $where_del_cond);

				//$this->Api_model->update_data('user_chats',array("read_msg"=>"1"), array("receiver"=>$this->input->post('userId'), "channel_id"=>$this->input->post('channelId')));
				
				//$this->Api_model->delete_data("user_chats_removed", array("user_id"=>$this->input->post('userId'), "channel_id"=>$this->input->post('channelId')));
	 
				$update_stmt = "set read_msg=1"; 
				$update_whrcond = "set receiver = '".$userid."',channel_id ='".$app->request->post('channelId')."' ";
				
				if($message!=''){
					$db->addEditRecord('user_chats',$update_stmt,$update_whrcond);
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
    $response = array();
    $db = new DbOperation();
    $arr = array();
    $arr = $db->getAuthorDetails3($userid);
	$channelId = $arr->channel_id;
    $UpdateUerchat = $db->UpdateUserChat($userid,$channelId);
	
	
    if(!empty($arr)){
		$response["error"] = false;
		$response["status"] = "Success";
		$response["userData"] = $arr;
		$response["message"] = "Data listed successfully.";
		echoResponse(201, $response);		
	 }else{
	   $response["error"] = true;
       $response["message"] = "Failed";
	   $response["message"] = "Something went wrong! please try again";
       echoResponse(200, $response);
	
	}
	
});

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
