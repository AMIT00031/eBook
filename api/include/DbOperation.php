<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

require_once('DbConnect.php');
require_once('PHPMailerAutoload.php');

$db = new DbConnect();
class DbOperation {
    /*
    *User registration............
    *
    */

    public function createUser($full_name, $pass, $email, $phone_no, $file_url, $device_token, $device_type, $random_number, $country="",$gender,$publisher_type,$user_name,$about_me){
        if (!$this->isUserExists($email,$user_name)){
            $password = base64_encode($pass);
            date_default_timezone_set('America/Los_Angeles');
            //echo "<pre>";print_r($_POST);exit();
            $mysql = "INSERT INTO user_login_table set full_name       ='".$full_name."',
                                                        email          ='".$email."',
                                                        phone_no       ='".$phone_no."',
                                                        url            ='".$file_url."',
                                                        device_token   ='".$device_token."',
                                                        device_type    ='".$device_type."',
                                                        register_id    ='".$random_number."',
                                                        country        ='".$country."',
                                                        date_edited    ='".time()."',
                                                        password       ='".$password."',
                                                        gender         ='".$gender."',
                                                        publisher_type ='".$publisher_type."',
                                                        user_name      ='".$user_name."',
                                                        about_me       ='".$about_me."'";
                        $result = mysql_query($mysql);
                        $user_login_id = mysql_insert_id();
                        $return_data = $user_login_id.'&'.$email.'&'.$phone_no.'&'.$full_name;
                        if($result){
                            $data = 'Now you can login with this email and password';
                            $to = $email;
                            $subject = 'Your registration is completed';
                            /* Let's Prepare The Message For The E-mail */
                            $message = 'Hello '.$username.'
                            Your email and password is following:
                            Username : '.$user_name.'
                            password: '.$pass.'';
                            /* Send The Message Using mail() Function */
                            if(mail($to, $subject, $message)){
                                return $user_login_id.'&'.$email.'&'.$phone_no.'&'.$full_name.'&'.'0';
                            }
                        }else{
                            return $user_login_id.'&'.$email.'&'.$phone_no.'&'.$full_name.'&'.'1';
                        }
                    }else{
                        return $user_login_id.'&'.$email.'&'.$phone_no.'&'.$full_name.'&'.'2';
                    }
                }

/*
*
*User login...........
*
*/

    public function userlogin($email, $user_name, $pass, $device_token, $device_type){
        $password = base64_encode($pass);
        $mysql = "SELECT * FROM user_login_table WHERE (user_name='".$user_name."') and password='".$password."'";
        $run = mysql_query($mysql);
        $num_rows = mysql_num_rows($run);
        $mysql = mysql_query("update user_login_table set device_token='".$device_token."' ,device_type='".$device_type."' where email='".$user_name."'");
        return $num_rows > 0;
    }

/*
*
*User profile updation...........
*
*/
    function userEdit($address, $user_id, $file_url, $country="",$password,$publisher_type,$email,$about_me) {
        $password = base64_encode($password);
        $mysql = "update user_login_table set  address ='".$address."',
                                               country ='".$country."',
                                               password ='".$password."',
                                               publisher_type ='".$publisher_type."',
                                               email ='".$email."',
                                               about_me ='".$about_me."' where id='".$user_id."'";
        
        $run = mysql_query($mysql);
        if($run > 0){
            return 0;
        }else{
            return 1;
        }
    }


/*
*
*User prfile pic updation...........
*
*/
    function userEditProfilePic($user_id, $file_url) {
        if($file_url){
            $mysql = "update user_login_table set url ='".$file_url."' where id='".$user_id."'";
        }
        $run = mysql_query($mysql);
        if($run > 0){
            return 0;
        }else{
            return 1;
        }
    }

/*
*
*User password updation...........
*
*/
    function updatePassword($user_id, $opass, $npass){
        $password = base64_encode($npass);
        $mysql = "update user_login_table set password='" . $password . "' where id='" . $user_id . "' and password='" . md5($opass) . "'";
        $run = mysql_query($mysql);
        if(mysql_affected_rows() > 0){
            return 0;
        }else{
            return 1;
        }
    }

/*
*
*Forget password ...........
*
*/

    function forgetPassword($email){
        $chars = "0123456789";
        $pass = substr(str_shuffle($chars), 0, 6);
        $password = base64_encode($pass);

        $mysql = "update user_login_table set password='".$password."' where email='".$email."'";

        $run = mysql_query($mysql);
        if (mysql_affected_rows() > 0){
            $tos = $email;
            $subject = 'Ebooks App - Forgot password';
            $from = 'info@dnddemo.com';
            $message = '<b>Hello  '.$email.'<br/><br/></b>
					Your email and password is following:<br/><br/>
					<b>E-mail: '.$email.'<br/>
					Your  password : '.$pass.'</b><br/><br/>
					Now you can login with this email and password.<br/><br/>
                    Thanks<br/>
                    Team eBooks';

            $to['email'] = $tos;
            $to['name'] = " User ";
            $subject = $subject;
            $str = $message;
            $mail = new PHPMailer;
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = 'mail.dnddemo.com';
            $mail->Port = 465;
            $mail->Username = 'info@dnddemo.com';
            $mail->Password = '#KC1A]Rgfa0C';
            $mail->SMTPSecure = 'ssl';
            $mail->From = 'info@dnddemo.com';
            $mail->FromName = "Ebooks";
            $mail->AddReplyTo('info@dnddemo.com', 'Ebooks');
            $mail->AddAddress($to['email'], $to['name']);
            $mail->Priority = 1;
            $mail->AddCustomHeader("X-MSMail-Priority: High");
            $mail->WordWrap = 50;
            $mail->IsHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $str;
            if (!$mail->Send()) {
                $err = 'Message could not be sent.';
                $err .= 'Mailer Error: ' . $mail->ErrorInfo;
                return 1;
            } else {
                return 0;
            }
            $mail->ClearAddresses();
        }else{
            return 1;
        }
    }

/*
*
*User email id vailidation ...........
*
*/

    private function isUserExists($email,$user_name) {
        $mysql = "SELECT id from user_login_table WHERE email ='".$email."' AND user_name='".$user_name."'";
        $result = mysql_query($mysql);
        $num_rows = mysql_num_rows($result);
        return $num_rows > 0;
    }

/*
*
*User email id vailidation ...........
*
*/

    private function isReqValidation($user_id,$frnd_id) {
        $mysql = "SELECT id from tbl_frnds WHERE user_id ='".$user_id."' AND frnd_id='".$frnd_id."'";
        $result = mysql_query($mysql);
        $num_rows = mysql_num_rows($result);
        return $num_rows > 0;
    }


/*
*
*Get user info ...........
*
*/

    public function getUser($email, $user_name, $pass) {
        $password = base64_encode($pass);
        $mysql = "SELECT * FROM user_login_table WHERE (user_name = '".$user_name."') and password='".$password."'";
        $run = mysql_query($mysql);
        $user = mysql_fetch_object($run);
        return $user;
    }

  
/*
*
*Clean string data from special chracter ...........
*
*/

   public function clean($string) {
       $string = str_replace(' ', ' ', $string); // Replaces all spaces with hyphens.
       return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
    }


/*
*
*Get user info by user id ...........
*
*/

    public function getUserInfo($user_id) {
        $mysql = "SELECT * FROM user_login_table WHERE   id ='" . $user_id . "'";
        $result = mysql_query($mysql);
        $num_rows = mysql_num_rows($result);
        $rows = array();
        if ($num_rows > 0) {
            while ($res = mysql_fetch_object($result)) {
                $rows[] = $res;
            }
            $rows = array(
                'id' => $rows[0]->id,
                'register_id' => $rows[0]->register_id,
                'full_name' => $rows[0]->full_name,
                'user_name' => $rows[0]->user_name,
                'url' => $rows[0]->url,
                'email' => $rows[0]->email,
                'gender' => $rows[0]->gender,
                'phone_no' => $rows[0]->phone_no,
                'country' => $rows[0]->country,
                'password' => base64_decode($rows[0]->password),
                'date_edited' => $rows[0]->date_edited,
                'status' => $rows[0]->status,
                'message_status' => $rows[0]->message_status,
                'publisher_type' => $rows[0]->publisher_type,
                'about_me' => $rows[0]->about_me,
                'device_token' => $rows[0]->device_token,
                'device_type' => $rows[0]->device_type,
                'address' => $rows[0]->address,
                'global_posting' => $rows[0]->global_posting,

                );
            
            return $rows;
        } else {
            return 1;
        }
    }


/*
*
*Get user info by user email id ...........
*
*/

    public function getUserInfoByEmail($email) {
        $mysql = "SELECT * FROM user_login_table WHERE email ='".$email."'";
        $result = mysql_query($mysql);
        $num_rows = mysql_num_rows($result);
      
        if ($num_rows > 0) {
            while ($res = mysql_fetch_object($result)) {
                $rows = $res;
            }
            return $rows;
        } else {
            return 1;
        }
    }


/*
*
*Get all category ...........
*
*/
    public function allCategoryList() {
        $mysql = "SELECT * FROM tbl_category";
        $result = mysql_query($mysql);
        $num_rows = mysql_num_rows($result);
        $rows = array();
        if ($num_rows > 0){
            while ($res = mysql_fetch_object($result)) {
                $rows[] = $res;
            }
            return $rows;
        } else {
            return 1;
        }
    }

/*
*
* Sending Friend Request  ...........
*
*/

 public function sendFrndReq($user_id, $frnd_id){
           if (!$this->isReqValidation($user_id,$frnd_id)){ 
                $mysql = "INSERT INTO tbl_frnds set user_id ='".$user_id."', frnd_id ='".$frnd_id."' ";
                $result = mysql_query($mysql);                
                return TRUE;
            }else{
            return FALSE;
        }
    }

/*
*
* Creating Chat Room...........
*
*/

 public function createChatId($user_id, $chat_id){
            if(!empty($user_id)){ 
                $mysql = "Update user_login_table set chat_id ='".$chat_id."' WHERE id= '".$user_id."' ";
                $result = mysql_query($mysql);                
                return TRUE;
            }else{
            return FALSE;
        }
    }


/*
*
*Publish new book ...........
*
*/

public function publishNewBook($data){
        date_default_timezone_set('America/Los_Angeles');
        $user_id          = $data['user_id'];
        $category_id      = $data['category_id'];
        $book_title       = $data['book_title'];
        $book_description = $data['book_description'];
        $author_name      = $data['author_name'];
        $thubm_image      = $data['thubm_image'];
        $pdf_url          = $data['pdf_url'];
        $audio_url        = $data['audio_url'];
        $book_image       = $data['book_image'];
        $video_url        = $data['video_url'];
        $questiondata        = $data['questiondata'];
        $date             = date('Y-m-d');
        $status           = $data['status'];
        $book_slug = strtolower($data['book_title']);
   
        $mysql = "INSERT INTO tbl_books set user_id     = '".$user_id."',
                                       category_id      = '".$category_id."',
                                       book_title       ='".$book_title."',
                                       book_slug        =  '".$book_slug."',
                                       thubm_image      = '".$thubm_image."',
                                       pdf_url          = '".$pdf_url."',
                                       audio_url        = '".$audio_url."',
                                       book_image       = '".$book_image."',
                                       video_url        = '".$video_url."',
                                       question_data    = '".$questiondata."',
                                       book_description = '".$book_description."',
                                       author_name      = '".$author_name."',
                                       status           = '".$status."',
                                       created_at       = '".$date."'";          

        $result = mysql_query($mysql);
        $books_id = mysql_insert_id();
        if ($result){
            return $books_id;
        } else {
            return false;
        }
    }



    /*
*
*Publish new book ...........
*
*/

public function addAssignment($bookId,$user_id,$question){

   $bookData = json_decode($question);
   foreach ($bookData as $key => $value) {
        $mysql = "INSERT INTO tbl_faq set book_id = '".$bookId."',
                                        question  = '".$value."',
                                        questioned_by ='".$user_id."'"; 
         $result = mysql_query($mysql);
        }

        if ($result == true){
            return true;
        } else {
            return false;
        }
    }

/*
*
*Get book by id ...........
*
*/

 public function getbookByid($id) {
        $mysql = "SELECT * FROM tbl_books WHERE  id='".$id."'";
        $run = mysql_query($mysql);
        $row = mysql_fetch_object($run);
        return $row;
    }

/*
*
*Get All books ...........
*
*/    

public function getBookbyCategoryId($cat_id){
        date_default_timezone_set('America/Los_Angeles');
        $rows = array();
        $mysql = "SELECT id ,book_title, thubm_image, author_name,book_description,mostView FROM tbl_books WHERE category_id='".$cat_id."'";
        //echo $mysql;die;
        $result = mysql_query($mysql);
        $num_rows = mysql_num_rows($result);
        if ($num_rows > 0) {
            while($res = mysql_fetch_object($result)){
                $res->book_title = strip_tags($res->book_title);
                $res->thubm_image = $_SERVER['HTTP_HOST'].'/ebooks/api/v1/upload/books/'.strip_tags($res->thubm_image);
                $res->book_description = strip_tags($res->book_description);
                $rows[] = $res;
            }
            return $rows;
        } else {
            return NULL;
        }
    }



/*
*
*Get book details by id ...........
*
*/

 public function getbooksDetailByid($bookId) {
        $mysql = "SELECT tbl_books.* , user_login_table.id AS userId, user_login_table.user_name FROM tbl_books LEFT JOIN user_login_table ON tbl_books.user_id = user_login_table.id WHERE tbl_books.id ='".$bookId."' ORDER BY tbl_books.id DESC";
        $run = mysql_query($mysql);
        $row = mysql_fetch_object($run);
        $row->book_title = strip_tags($row->book_title);
        $row->book_description = strip_tags($row->book_description);
        if($row->thubm_image)
        $row->thubm_image = !empty($row->thubm_image) ? $_SERVER['HTTP_HOST'].'/ebooks/api/v1/upload/books/'.$row->thubm_image: NULL;
        $row->book_image = !empty($row->book_image) ? $_SERVER['HTTP_HOST'].'/ebooks/api/v1/upload/books/gallery/'.$row->book_image: NULL;
        $row->video_url = !empty($row->video_url) ? $_SERVER['HTTP_HOST'].'/ebooks/api/v1/upload/books/video/'.$row->video_url : NULL;
        $row->audio_url = !empty($row->audio_url) ? $_SERVER['HTTP_HOST'].'/ebooks/api/v1/upload/books/audio/'.$row->audio_url : NULL;
        $row->pdf_url = !empty($row->pdf_url) ? $_SERVER['HTTP_HOST'].'/ebooks/api/v1/upload/books/document/'.$row->pdf_url : NULL;
     
        if($row->mostView >= 0){
            $MostVl = $row->mostView+1;
            $mysql = "update tbl_books set mostView ='".$MostVl."' WHERE id='".$bookId."'";
            $run = mysql_query($mysql);
        }
        return $row;
    }


    /*
*
*Get author details ...........
*
*/

 public function getAuthorDetails($userid) {
        if($userid !==''){
            $mysql = "SELECT id,user_name,chat_id,url,email,about_me FROM user_login_table WHERE id ='".$userid."'";
            $run = mysql_query($mysql);
            $row = mysql_fetch_object($run);
            return $row;
        }else{
            return NULL;
        }
    }


/*
*
*Get all books author by user id ...........
*
*/

 public function getAuthorBooklist($userid) {
        $mysql = "SELECT tbl_books.id ,tbl_books.book_title, tbl_books.thubm_image, tbl_books.author_name,tbl_books.book_description,tbl_review.rating FROM tbl_books LEFT JOIN tbl_review on tbl_books.id = tbl_review.books_id WHERE tbl_books.user_id= '".$userid."'ORDER BY tbl_books.id DESC";
           //echo $mysql;exit();
           $result = mysql_query($mysql);
            $num_rows = mysql_num_rows($result);
            if ($num_rows > 0) {
                while($res = mysql_fetch_object($result)){
                    $res->book_title = strip_tags($res->book_title);
                    $res->thubm_image = $_SERVER['HTTP_HOST'].'/ebooks/api/v1/upload/books/'.strip_tags($res->thubm_image);
                    $res->book_description = strip_tags($res->book_description);
                    $rows[] = $res;
                }
                return $rows;
            } else {
                return NULL;
            }
    }

/*
*
*Get book details by id ...........
*
*/

 public function getbookMarkByBookid($bookId,$userid) {        
        $mysql = "SELECT id AS bookmarkId, status AS bookmarkStatus FROM tbl_bookmark WHERE books_id ='".$bookId."' AND user_id ='".$userid."'";
        $run = mysql_query($mysql);
        $num_rows = mysql_num_rows($run);
        if ($num_rows > 0) {
        $markdata = mysql_fetch_object($run);
        $markdata->bookmarkId = $markdata->bookmarkId;
        $markdata->bookmarkStatus = $markdata->bookmarkStatus;
        return $markdata;
    }else{
        return NULL;
    }
}


/*
*
*Get All quetion ...........
*
*/

 public function getallQustionbyBook($bookId) {        
        $mysql = "SELECT id,book_id,question,answer FROM tbl_faq WHERE book_id ='".$bookId."'";
        $run = mysql_query($mysql);
        $num_rows = mysql_num_rows($run);
        if ($num_rows > 0) {
        while($qdata = mysql_fetch_object($run)){
         $questionData[] = $qdata;
       }
        return $questionData;
    }else{
        return NULL;
    }
}



/*
*
*Get bookmark details  ...........
*
*/

 public function addUpdateBookmark($user_id, $bookId){
        if ($user_id != '' && $bookId != '') {
            $mysql = "SELECT * FROM tbl_bookmark WHERE user_id='".$user_id."' and  books_id ='".$bookId."'";
            $run = mysql_query($mysql);
            $bookmark = mysql_fetch_object($run);
            $bmid = $bookmark->id;

            if($bmid != ''){
                if ($bookmark->status == 1) {
                    $updated_at = date("Y-m-d H:i:s");
                    $mysql = "update tbl_bookmark set status ='0',updated_at ='".$updated_at."' WHERE id='".$bmid."'";
                    $result = mysql_query($mysql);
                    return 'deactive';
                } else {
                    $updated_at = date("y-m-d h:i:s");
                    $mysql = "update tbl_bookmark set status ='1',updated_at ='".$updated_at."' WHERE id='".$bmid."'";
                    $result = mysql_query($mysql);
                    return 'active';
                }
            } else {
                $mysql = "INSERT INTO tbl_bookmark set  books_id ='".$bookId."',user_id ='".$user_id."',status ='1'";
                $result = mysql_query($mysql);
                return 'active';
            }
        } else {
            return 'failed';
        }
    }



    public function getUserBookMark($userId) {

        date_default_timezone_set('America/Los_Angeles');
        $rows = array();
        $mysql = "select tbl_books.id,tbl_books.book_title,tbl_books.thubm_image,tbl_books.author_name,tbl_books.book_description,tbl_bookmark.user_id as user_id, tbl_bookmark.id as bookmark_id,tbl_bookmark.status as bm_status, tbl_review.rating FROM tbl_bookmark inner join tbl_books on tbl_bookmark.books_id = tbl_books.id LEFT JOIN tbl_review ON tbl_books.id = tbl_review.books_id where tbl_bookmark.user_id = ".$userId." AND tbl_bookmark.status = 1 GROUP by tbl_bookmark.id desc";
    
 
        //echo $mysql;exit();
        $result = mysql_query($mysql);
        $num_rows = mysql_num_rows($result);
        
        if ($num_rows > 0) {
            while ($res = mysql_fetch_object($result)) {
                $res->book_title = strip_tags($res->book_title);
                $res->thubm_image = $_SERVER['HTTP_HOST'].'/ebooks/api/v1/upload/books/'.strip_tags($res->thubm_image);
                $res->book_description = strip_tags($res->book_description);
                $rows[] = $res;
            }
            return $rows;
        } else {
            return NULL;
        }

    }



/*
*
*Create note book  ...........
*
*/

 public function craeteNoteBook($user_id,$description){
            if(!empty($user_id)){
                $mysql = "INSERT INTO tbl_note set user_id ='".$user_id."', description ='".$description."',status ='1'";
                $result = mysql_query($mysql);
                return TRUE;
            }else{
            return FALSE;
        }
    }

/*
*
*Create note book  ...........
*
*/

 public function gteNoteByUser($user_id){
         $rows = array();
        $mysql = "SELECT id, description, created_at FROM tbl_note WHERE user_id='".$user_id."'";
        //echo $mysql;die;
        $result = mysql_query($mysql);
        $num_rows = mysql_num_rows($result);
        if ($num_rows > 0) {
            while($res = mysql_fetch_object($result)){
                $rows[] = $res;
            }
            return $rows;
        } else {
            return NULL;
        }     
}


/*
*
*Update note book  ...........
*
*/

 public function UpdateNote($note_id,$description){
        if(!empty($note_id)){
            $updated_at = date("Y-m-d H:i:s");
            $mysql = "update tbl_note set description ='".$description."',created_at ='".$updated_at."' WHERE id='".$note_id."'";
            $result = mysql_query($mysql);
            return true;
      }else{
        return false;
      }
  }

/*
*
*Update assignment  ...........
*
*/

 public function UpdateAssignment($assignment_id,$answer,$answered_by){
        if(!empty($assignment_id)){
            $updated_at = date("Y-m-d H:i:s");
            $mysql = "update tbl_faq set answer ='".$answer."', answered_by='".$answered_by."', updated_at ='".$updated_at."' WHERE id='".$assignment_id."'";
            $result = mysql_query($mysql);
            if($result == true){
              $mysql = "SELECT id, book_id, question, answer FROM tbl_faq WHERE id='".$assignment_id."' AND answered_by='".$answered_by."'";
                $assignmentData = mysql_query($mysql);
                $num_rows = mysql_num_rows($assignmentData);
                if ($num_rows > 0){
                    $rows =mysql_fetch_object($assignmentData);
                }}
             return $rows;
      }else{
        return false;
      }
  }

/*
*
*Update assignment  ...........
*
*/

 public function addAnswer($assignment_id,$answer,$answered_by,$books_id){
        $mysql = "SELECT * FROM tbl_answer WHERE question_id='".$assignment_id."' AND answered_by='".$answered_by."'";
                $assignmentData = mysql_query($mysql);
                $ansdata = mysql_fetch_object($assignmentData);
                $ansid = $ansdata->id;
        if(empty($ansid)){
             $mysql = "INSERT INTO tbl_answer set answer ='".$answer."', answered_by='".$answered_by."', question_id='".$assignment_id."', books_id='".$books_id."'";
                 $result = mysql_query($mysql);
                 $last_insert_id = mysql_insert_id();
                 if($result == true){
                  $mysql = "SELECT id, question_id, books_id,answered_by, answer FROM tbl_answer WHERE id='".$last_insert_id."'";
                    $assignmentData = mysql_query($mysql);
                    $num_rows = mysql_num_rows($assignmentData);
                    if ($num_rows > 0){
                        $rows =mysql_fetch_object($assignmentData);
                    }}
                 return $rows;
                
      }else{
         $mysql = "update tbl_answer set answer ='".$answer."' WHERE id='".$ansid."'";
         $result = mysql_query($mysql);
          if($result == true){
              $mysql = "SELECT id, question_id, books_id,answered_by, answer FROM tbl_answer WHERE id='".$ansid."'";
                $assignmentData = mysql_query($mysql);
                $num_rows = mysql_num_rows($assignmentData);
                if ($num_rows > 0){
                    $rows =mysql_fetch_object($assignmentData);
                }}
             return $rows;
      }
  }


  /*
*
*Create note book  ...........
*
*/

 public function gteAnsweredbyuser($user_id){
        $mysql = "SELECT tbl_answer.id, tbl_answer.question_id, tbl_answer.books_id ,tbl_answer.answered_by, tbl_answer.answer,tbl_faq.question FROM tbl_answer LEFT JOIN tbl_faq ON tbl_answer.question_id = tbl_faq.id WHERE tbl_answer.answered_by='".$user_id."'";
        $result = mysql_query($mysql);
        $num_rows = mysql_num_rows($result);
        if ($num_rows > 0) {
            while($res = mysql_fetch_object($result)){
                $rows[] = $res;
            }
            return $rows;
        } else {
            return NULL;
        }     
}

/*
*
*Delete note book  ...........
*
*/

public function deleteNoteBook($note_id) {
    $mysql = "DELETE from tbl_note where id='".$note_id."'";
    $result = mysql_query($mysql);
    return $t = mysql_affected_rows();
}

/*
*
*Get All Popular books ...........
*
*/

 public function GetPopularBook() {
        $mysql = "SELECT tbl_books.id ,tbl_books.book_title, tbl_books.thubm_image, tbl_books.author_name,tbl_books.book_description,tbl_books.mostView,tbl_review.rating FROM tbl_books LEFT JOIN tbl_review on tbl_books.id = tbl_review.books_id ORDER BY tbl_books.mostView DESC LIMIT 5";
        //echo $mysql;exit();
           $result = mysql_query($mysql);
            $num_rows = mysql_num_rows($result);
            if ($num_rows > 0) {
                while($res = mysql_fetch_object($result)){
                    $res->book_title = strip_tags($res->book_title);
                    $res->thubm_image = $_SERVER['HTTP_HOST'].'/ebooks/api/v1/upload/books/'.strip_tags($res->thubm_image);
                    $res->book_description = strip_tags($res->book_description);
                    $res->mostView = $res->mostView;
                    $rows[] = $res;
                }
                return $rows;
            } else {
                return NULL;
            }
    }


/*
*
*Get All Requested user ...........
*
*/

 public function getRequestedUsers($userId) {
        $mysql = "SELECT tbl_frnds.id,tbl_frnds.user_id,tbl_frnds.status,tbl_frnds.request_date,user_login_table.url, user_login_table.user_name,user_login_table.publisher_type FROM tbl_frnds INNER JOIN user_login_table ON tbl_frnds.user_id = user_login_table.id WHERE tbl_frnds.frnd_id='".$userId."' AND tbl_frnds.status=0";
        //echo $mysql;exit();
           $result = mysql_query($mysql);
            $num_rows = mysql_num_rows($result);
            if ($num_rows > 0) {
                while($res = mysql_fetch_object($result)){
                    $rows[] = $res;
                }
                return $rows;
            } else {
                return NULL;
            }
    }


/*
*
*Get All Requested user ...........
*
*/

 public function getAcceptedList($userId) {
        $mysql = "SELECT tbl_frnds.id,tbl_frnds.user_id,tbl_frnds.status,tbl_frnds.request_date,user_login_table.url, user_login_table.user_name, user_login_table.chat_id,user_login_table.publisher_type FROM tbl_frnds INNER JOIN user_login_table ON tbl_frnds.user_id = user_login_table.id WHERE tbl_frnds.frnd_id='".$userId."' AND tbl_frnds.status=1";
        //echo $mysql;exit();
           $result = mysql_query($mysql);
            $num_rows = mysql_num_rows($result);
            if ($num_rows > 0) {
                while($res = mysql_fetch_object($result)){
                    $rows[] = $res;
                }
                return $rows;
            } else {
                return NULL;
            }
    }


/*
*
*Get All Popular books ...........
*
*/

 public function acceptedUserreuest($friendId, $status){

            if(!empty($friendId) && $status == 1){
                $updated_at = date("Y-m-d H:i:s");
                $mysql = "update tbl_frnds set status ='".$status."',accepted_date ='".$updated_at."' WHERE id='".$friendId."'";
                $result = mysql_query($mysql);
                return TRUE;
            } else{
                $updated_at = date("Y-m-d H:i:s");
                $mysql = "update tbl_frnds set status ='".$status."',accepted_date ='".$updated_at."' WHERE id='".$friendId."'";
                $result = mysql_query($mysql);
                return FALSE;
            }
        }


/*
*
*Get All search books ...........
*
*/

 public function SearchBook() {
        $mysql="SELECT tbl_books.id ,tbl_books.book_title, tbl_books.thubm_image, tbl_books.author_name,tbl_books.book_description,tbl_books.mostView , tbl_review.rating FROM tbl_books LEFT JOIN tbl_review ON tbl_books.id = tbl_review.books_id ORDER BY tbl_books.id DESC";
        //echo $mysql;exit();
           $result = mysql_query($mysql);
            $num_rows = mysql_num_rows($result);
            if ($num_rows > 0) {
                while($res = mysql_fetch_object($result)){
                    $res->book_title = strip_tags($res->book_title);
                    $res->thubm_image = $_SERVER['HTTP_HOST'].'/ebooks/api/v1/upload/books/'.strip_tags($res->thubm_image);
                    $res->book_description = strip_tags($res->book_description);
                    $res->mostView = $res->mostView;
                    $rows[] = $res;
                }
                return $rows;
            } else {
                return NULL;
            }
    }


/*
*
*Create review book  ...........
*
*/

 public function craeteReviewaBook($userId,$booksId,$comment,$rating){
            if ($userId != '' && $booksId != '') {
            $mysql = "SELECT * FROM tbl_review WHERE user_id='".$userId."' and  books_id ='".$booksId."'";
            $run = mysql_query($mysql);

            $ReviewData = mysql_fetch_object($run);
            $rvid = $ReviewData->id;

            if($rvid != ''){
                if ($ReviewData->status == 1) {
                    $updated_at = date("Y-m-d H:i:s");
                    $mysql = "update tbl_review set status ='1', comment ='".$comment."', rating ='".$rating."',updated_at ='".$updated_at."' WHERE id='".$rvid."'";
                    $result = mysql_query($mysql);
                    return TRUE;
                } else {
                    $updated_at = date("y-m-d h:i:s");
                    $mysql = "update tbl_review set status ='1', comment ='".$comment."', rating ='".$rating."', updated_at ='".$updated_at."' WHERE id='".$rvid."'";
                    $result = mysql_query($mysql);
                    return TRUE;
                }
            } else {
                $mysql = "INSERT INTO tbl_review set user_id ='".$userId."', books_id ='".$booksId."', comment ='".$comment."', rating ='".$rating."',status ='1'";
                $result = mysql_query($mysql);
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }


/*
*
*get review by book id ...........
*
*/

 public function getReviewbyBookid($booksId){

            $mysql = "SELECT tbl_review.id AS ReviewId,tbl_review.comment,tbl_review.rating ,tbl_review.created_at ,user_login_table.user_name,user_login_table.url FROM tbl_review LEFT JOIN user_login_table ON tbl_review.user_id = user_login_table.id WHERE tbl_review.books_id ='".$booksId."' ORDER BY tbl_review.id DESC";
               // /echo $mysql;exit();
               $result = mysql_query($mysql);
                $num_rows = mysql_num_rows($result);
                if ($num_rows > 0) {
                    while($res = mysql_fetch_object($result)){
                       $res->url = $_SERVER['HTTP_HOST'].'/ebooks/api/v1/upload/'.strip_tags($res->url);
                       $rows[] = $res;
                    }
                    return $rows;
                } else {
            return NULL;
            }

         }


/*
*function to send the email of contact us users to admin
*/

    public function sendContact($user_id, $name, $email, $phone, $contadata){
           if(!empty($user_id)){
                $mysql = "INSERT INTO tbl_contact set user_id ='".$user_id."', name ='".$name."', email ='".$email."', phone ='".$phone."', message ='".$_POST['contatMessage']."', status ='1'";
                $result = mysql_query($mysql);
                    if($result == true){
                    $tos = "shyamsoft38@gmail.com";
                    $subject = 'eBooks App - Contact Us';
                    $from = 'info@dnddemo.com';
                    $message = '<b>Hello Admin <br/><br/></b>
                            New User contacted you having below details:<br/><br/>
                            E-mail:' . $email . '<br/>
                            Phone : ' . $phone . '</b><br/><br/>
                            Message : ' . $_POST['contatMessage'] . '</b><br/><br/>
                            .<br/><br/>
                            Thanks<br/>
                            Team eBooks';
                    $to['email'] = $tos;
                    $to['name'] = " User ";
                    $subject = $subject;
                    $str = $message;
                    $mail = new PHPMailer;
                    $mail->IsSMTP();
                    $mail->SMTPAuth = true;
                    $mail->Host = 'mail.dnddemo.com';
                    $mail->Port = 465;
                    $mail->Username = 'info@dnddemo.com';
                    $mail->Password = '#KC1A]Rgfa0C';
                    $mail->SMTPSecure = 'ssl';
                    $mail->From = 'info@dnddemo.com';
                    $mail->FromName = "ScamSom";
                    $mail->AddReplyTo('info@dnddemo.com', 'eBooks');
                    $mail->AddAddress($to['email'], $to['name']);
                    $mail->Priority = 1;
                    $mail->AddCustomHeader("X-MSMail-Priority: High");
                    $mail->WordWrap = 50;
                    $mail->IsHTML(true);
                    $mail->Subject = $subject;
                    $mail->Body = $str;
                    if (!$mail->Send()) {
                        $err = 'Message could not be sent.';
                        $err .= 'Mailer Error: ' . $mail->ErrorInfo;
                        return 0;
                    } else {
                        return 1;
                    }
                    $mail->ClearAddresses();
                }
                return TRUE;
                }else{
                return FALSE;
             }

    }

 
 


//Method to generate a unique api key every time
    private function generateApiKey() {
        return md5(uniqid(rand(), true));
    }

    function crypto_rand_secure($min, $max) {
        $range = $max - $min;
        if ($range < 1)
            return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd > $range);
        return $min + $rnd;
    }

    function getToken($length){
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet); // edited

        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[$this->crypto_rand_secure(0, $max - 1)];
        }
        return $token . time();
    }

}
