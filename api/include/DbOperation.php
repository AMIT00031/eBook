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

    public function createUser($full_name, $pass, $email, $phone_no, $file_url, $device_token, $device_type, $random_number, $country="",$gender,$publisher_type,$user_name,$about_me,$face_cordX='',$face_cordY='',$face_width='',$login_type='' ){
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
                                                        login_type      ='".$login_type."',
                                                        gender         ='".$gender."',
                                                        publisher_type ='".$publisher_type."',
                                                        user_name      ='".$user_name."',
                                                        face_cordX       ='".$face_cordX."',
                                                        face_cordY       ='".$face_cordY."',
                                                        face_width       ='".$face_width."'";
                        $result = mysql_query($mysql);
						//print_r($result);  
                       
						$user_login_id = mysql_insert_id();
                        $return_data = $user_login_id.'&'.$email.'&'.$phone_no.'&'.$full_name;
                        if(is_numeric($user_login_id) && $user_login_id!=''){
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
	function updateUser($device_type,$device_token,$login_type,$email,$userid='') {
        //$password = base64_encode($password);
		if($email!=''){
			$mysql = "update user_login_table set device_type ='".$device_type."', device_token ='".$device_token."', login_type  ='".$login_type ."' where email ='".$email."'";
			$run = mysql_query($mysql);
            return 1;
        }else{
            return 0;
        }
    }
	
	
    public function userlogin($email, $user_name, $pass, $device_token, $device_type){
        $password = base64_encode($pass);
        $mysql = "SELECT * FROM user_login_table WHERE (user_name='".$user_name."') and password='".$password."'";
        $run = mysql_query($mysql);
        $num_rows = mysql_num_rows($run);
        $mysql = mysql_query("update user_login_table set device_token='".$device_token."' ,device_type='".$device_type."' where user_name='".$user_name."' and password='".$password."'");		
        return $num_rows > 0;
    }
	
	public function userfacelogin($face_cordX, $face_cordY, $face_width,$device_token='',$device_type=''){
		
        //$password = base64_encode($pass);
         //$mysql = "SELECT * FROM user_login_table WHERE face_cordX='".$face_cordX."' and face_cordY='".$face_cordY."' and face_width = '".$face_width."' ";
		 
       $mysql = "SELECT * FROM user_login_table WHERE face_width like '%".$face_width."%' limit 1";
		
		$run = mysql_query($mysql);
        $num_rows = mysql_num_rows($run);
		
		if($num_rows<1){
			$facewidth = explode(".",$face_width);
			$face_width = $facewidth[0];
			$mysql = "SELECT * FROM user_login_table WHERE face_width like '%".$face_width."%' limit 1";
			$run = mysql_query($mysql);
			$num_rows = mysql_num_rows($run);
		}
		
        //$run = mysql_query($mysql);
        //$num_rows = mysql_num_rows($run);
		if($num_rows==1){
			
			$user = mysql_fetch_object($run);
			//print_r($user); die;
			return $user;
        //$mysql = mysql_query("update user_login_table set device_token='".$device_token."' ,device_type='".$device_type."' where user_name='".$user_name."'");	
		//return $num_rows > 0;
		}else{
          return 0;
		}			
        
    }

/*
*
*User profile updation...........
*
*/
    function userEdit($address, $user_id, $file_url, $country="",$password,$publisher_type,$email,$about_me) {
        $password = base64_encode($password);
        $mysql = "update user_login_table set address ='".$address."',
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
        //$mysql = "SELECT id from user_login_table WHERE email ='".$email."'";
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
	
	  public function getFaceUser($email, $user_name, $pass) {
        $password = $pass;
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



/*select Definition from DEFINITIONS where wordID = (select wordID from WORDS where lower(word) = lower("simple"))
SELECT * FROM `DEFINITIONS` as df left join WORDS as w on df.WordID=w.WordID where df.Definition like '%simple%'*/

public function DictionaryData($wordData) {
        if(!empty($wordData)){
           $mysql = 'select Definition from DEFINITIONS where wordID = (select wordID from WORDS where Word = "'.$wordData.'")';
           //echo $mysql;exit();
            $result = mysql_query($mysql);
            $num_rows = mysql_num_rows($result);
            $rows = array();
            if ($num_rows > 0) {
                while ($res = mysql_fetch_object($result)) {
                    $rows[] = $res;
                }
                return $rows;
            } else {
                return 1;
            }
         }
     }


/*
*
*Get book by id ...........
*
*/

    public function getBookdatabyid($BookId) {
		
        $mysql = "SELECT * FROM tbl_books WHERE id ='".$BookId."'";
        $result = mysql_query($mysql);
        $num_rows = mysql_num_rows($result);

        if($num_rows > 0) {
            while ($res = mysql_fetch_object($result)) {
                $rows[] = $res;
            }
            $rows = array(
                'id' => $rows[0]->id,
                'user_id' => $rows[0]->user_id,
                'category_id' => $rows[0]->category_id,
                'book_title' => $rows[0]->book_title,
                'thubm_image' => $rows[0]->thubm_image,
                'book_description' => $rows[0]->book_description,
                'author_name' => $rows[0]->author_name,
                'book_image' => $rows[0]->book_image,
                'video_url' => $rows[0]->video_url,
                'audio_url' => $rows[0]->audio_url,
                'pdf_url' => $rows[0]->pdf_url,
                );
            return $rows;
        }else{
            return 1;
        }
    }

/*
*
*Delete book  ...........
*
*/

public function deleteBookbyId($books_id) {
    $mysql = "Update tbl_books set status ='0' WHERE id= '".$books_id."'";
    $result = mysql_query($mysql);
    return $t = mysql_affected_rows();
}


/*
*
*Get user info by user email id ...........
*
*/

    public function getUserInfoByEmail($email){
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
				$mysql_cate = "SELECT count(*) as cate_count FROM tbl_books where status=1 and category_id='".$res->id."'"; 
				$result_cate = mysql_query($mysql_cate);
				$num_rows_cate = mysql_num_rows($result_cate); 
				if($num_rows_cate>0){
					$res_cate = mysql_fetch_object($result_cate);
					$res->book_count = $res_cate->cate_count;
				}else $res->book_count=0;
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
        $book_update_id   = $data['book_id'];
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
        $questiondata     = $data['questiondata'];
        $isbn_number      = $data['isbn_number'];
        $date             = date('Y-m-d');
        $status           = $data['status'];
        $book_slug = $replaced = str_replace(' ', '-', strtolower($data['book_title'])); 
   
       if(is_numeric($book_update_id) && $book_update_id!=''){
		   
		   $mysql = "update tbl_books set user_id     = '".$user_id."',
                                       category_id      = '".$category_id."',
                                       book_title       ='".$book_title."',
                                       book_slug        =  '".$book_slug."',
                                       thubm_image      = '".$thubm_image."',
                                       pdf_url          = '".$pdf_url."',
                                       audio_url        = '".$audio_url."',
                                       book_image       = '".$book_image."',
                                       video_url        = '".$video_url."',
                                       question_data    = '".$questiondata."',
                                       isbn_number      = '".$isbn_number."',
                                       book_description = '".$book_description."',
                                       author_name      = '".$author_name."',
                                       status           = '".$status."',
                                       created_at       = '".$date."' where id='".$book_update_id."' ";   
		  
	   }else{
		   
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
                                       isbn_number      = '".$isbn_number."',
                                       book_description = '".$book_description."',
                                       author_name      = '".$author_name."',
                                       status           = '".$status."',
                                       created_at       = '".$date."'";  
	   }									   

        $result = mysql_query($mysql);

        $books_id = mysql_insert_id();
		
		if($books_id) $books_id = $books_id;  else  $books_id = $book_update_id;
        
		if ($result){
			 
			 return $books_id;
			 
        } else {
            return false;
        }
    }
	
	
/*
*
*Update book ...........
*
*/

public function updateBook($data){
        date_default_timezone_set('America/Los_Angeles');
        $book_id          = $data['book_id'];
        $category_id      = $data['category_id'];
        $book_title       = $data['book_title'];
        $book_description = $data['book_description'];
        $author_name      = $data['author_name'];
        $thubm_image      = $data['thubm_image'];
        $pdf_url          = $data['pdf_url'];
        $audio_url        = $data['audio_url'];
        $book_image       = $data['book_image'];
        $video_url        = $data['video_url'];
        $questiondata     = $data['questiondata'];
        $isbn_number      = $data['isbn_number'];
        $date             = date('Y-m-d');
        $status           = $data['status'];
        $book_slug = strtolower($data['book_title']);
		$mysql = "update tbl_books set category_id      = '".$category_id."',
                                       book_title       ='".$book_title."',
                                       book_slug        =  '".$book_slug."',
                                       thubm_image      = '".$thubm_image."',
                                       pdf_url          = '".$pdf_url."',
                                       audio_url        = '".$audio_url."',
                                       book_image       = '".$book_image."',
                                       video_url        = '".$video_url."',
                                       question_data    = '".$questiondata."',
                                       isbn_number      = '".$isbn_number."',
                                       book_description = '".$book_description."',
                                       author_name      = '".$author_name."',
                                       status           = '".$status."',
                                       updated_at       = '".$date."' where id='".$book_id."'";

									   

        $result = mysql_query($mysql);
        if ($result){
            return $book_id ;
        } else {
            return false;
        }
    }

/*
*
*Isbn nummer vailidation ...........
*
*/

public function ValidIsbn($isbn_number){
    $regex = '/\b(?:ISBN(?:: ?| ))?((?:97[89])?\d{9}[\dx])\b/i';
    if (preg_match($regex, str_replace('-', '', $isbn_number), $matches)) {
        return (10 === strlen($matches[1]))
            ? 1   // ISBN-10
            : 2;  // ISBN-13
    }
    return false; // No valid ISBN found
}


/*
*
*book isbn nummer vailidation ...........
*
*/

public function isIsbnExists($isbn_number) {
	if($this->ValidIsbn($isbn_number)){
		$mysql = "SELECT id from tbl_books WHERE isbn_number='".$isbn_number."'";
		$result = mysql_query($mysql);
		$num_rows = mysql_num_rows($result);
		if($num_rows > 0){
			return false;
		}else{
			return true;
		}
	}else{
		return false;
	}
}
	


/*
*
*add assignment new book ...........
*
*/

public function addAssignment($bookId,$user_id,$question){
	
	if(!empty($question)){ 
		$bookData = json_decode($question);
		
		if(count($bookData)>1){
			foreach($bookData as $key => $value){
				 $mysql = "INSERT INTO tbl_faq set book_id = '".$bookId."',
												question  = '".$value."',
												questioned_by ='".$user_id."'"; 
				 $result = mysql_query($mysql);
			}
		}else{ 
			  $mysql = "INSERT INTO tbl_faq set book_id = '".$bookId."',
											question  = '".$question."',
											questioned_by ='".$user_id."'"; 
			 $result = mysql_query($mysql);
			
			 
		}

        if ($result == 1){ 
            return true;
        } else {
            return false;
		}
	}
	else{ 
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
        //$mysql = "SELECT id ,book_title, thubm_image, author_name,mostView FROM tbl_books WHERE category_id='".$cat_id."' AND status='1'";
		
        $mysql = "SELECT tbl_books.id ,tbl_books.book_title, tbl_books.thubm_image, tbl_books.author_name,tbl_books.book_description,tbl_review.rating FROM tbl_books LEFT JOIN tbl_review on tbl_books.id = tbl_review.books_id WHERE tbl_books.category_id='".$cat_id."' AND tbl_books.status='1' group by tbl_books.id ORDER BY tbl_books.id DESC"; 
        //echo $mysql;die;
        $result = mysql_query($mysql);
        $num_rows = mysql_num_rows($result);
        if ($num_rows > 0) {
            while($res = mysql_fetch_object($result)){
                $res->book_title = strip_tags($res->book_title);
                $res->thubm_image = $_SERVER['HTTP_HOST'].'/ebooks/api/v1/upload/books/'.strip_tags($res->thubm_image);
                
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
        $mysql = "SELECT tbl_books.* , user_login_table.id AS userId,user_login_table.url as profile_pic, user_login_table.user_name FROM tbl_books LEFT JOIN user_login_table ON tbl_books.user_id = user_login_table.id WHERE tbl_books.id ='".$bookId."' ORDER BY tbl_books.id DESC";
        $run = mysql_query($mysql);
        $row = mysql_fetch_object($run);
        $row->book_title = strip_tags($row->book_title);
        $row->book_description = strip_tags($row->book_description);
        if($row->thubm_image)
        $row->thubm_image = !empty($row->thubm_image) ? $_SERVER['HTTP_HOST'].'/ebooks/api/v1/upload/books/'.$row->thubm_image: '';
	
        $row->book_image = !empty($row->book_image) ? $_SERVER['HTTP_HOST'].'/ebooks/api/v1/upload/books/gallery/'.$row->book_image: '';
        $row->video_url = !empty($row->video_url) ? $_SERVER['HTTP_HOST'].'/ebooks/api/v1/upload/books/video/'.$row->video_url : '';
        $row->audio_url = !empty($row->audio_url) ? $_SERVER['HTTP_HOST'].'/ebooks/api/v1/upload/books/audio/'.$row->audio_url : '';
        $row->pdf_url = !empty($row->pdf_url) ? $_SERVER['HTTP_HOST'].'/ebooks/api/v1/upload/books/document/'.$row->pdf_url : '';
		 $row->profile_pic = !empty($row->profile_pic) ? $_SERVER['HTTP_HOST'].'/ebooks/api/v1/upload/'.strip_tags($row->profile_pic) : '';
     
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
	public function ChatMessageCount($userid,$channelId){
        if($userid !==''){
            $mysql = "SELECT COUNT(message) AS totalMessagecount  FROM user_chats WHERE receiver= '".$userid."' AND channel_id='".$channelId."' AND read_msg ='0'";
            $run = mysql_query($mysql);
            $row = mysql_fetch_object($run);
            return $row;
        }else{
            return NULL;
        }
    }



	public function getAuthorDetails($userid){
        if($userid !==''){
			
            $mysql = "SELECT id,user_name,url,email,about_me, publisher_type,device_token, device_type FROM user_login_table WHERE id ='".$userid."'";
            $run = mysql_query($mysql);
            $row = mysql_fetch_array($run);
            return $row;
        }else{
            return NULL;
        }
    }
	
	
	
	
	public function getAuthorDetails2($userid) {
        if($userid !==''){
            $mysql = "SELECT id,user_name,url,email,about_me, publisher_type,device_token, device_type FROM user_login_table WHERE id ='".$userid."'";
            $run = mysql_query($mysql);
            $row = mysql_fetch_object($run);
            return $row;
        }else{
            return NULL;
        }
    }
	

	public function getAuthorDetails3($userid) {
        if($userid !==''){
            $mysql = "SELECT DISTINCT(user_login_table.id),user_login_table.user_name, user_login_table.url, user_chats.channel_id FROM user_login_table LEFT JOIN user_chats ON user_login_table.id = user_chats.sender WHERE user_chats.sender ='".$userid."'";
            $run = mysql_query($mysql);
            $row = mysql_fetch_object($run);
            return $row;
        }else{
            return NULL;
        }
    }
	
	public function getAuthorDetails4($receiver) {
        if($userid !==''){
            $mysql = "SELECT DISTINCT(user_login_table.id),user_login_table.user_name, user_login_table.url, user_chats.channel_id FROM user_login_table LEFT JOIN user_chats ON user_login_table.id = user_chats.sender WHERE user_chats.receiver ='".$receiver."'";
            $run = mysql_query($mysql);
            $row = mysql_fetch_object($run);
            return $row;
        }else{
            return NULL;
        }
    }
	
	
	function UpdateUserChat($userid, $channelId, $receiver,$chat_id,$action){ 
		
		if($action=="all"){
				$mysql = "UPDATE user_chats SET is_deleted = '1', WHERE sender ='".$userid."' AND receiver='".$receiver."'";
				//$mysql = "UPDATE user_chats SET is_deleted = '1',deleted_msg_from_user = '".$mess_delete_from_users."' WHERE sender ='".$userid."' AND receiver='".$receiver."'";
		}else{
			$mysqlRecord = "SELECT deleted_msg_from_user from user_chats WHERE id ='".$chat_id."'";
			$runRecord = mysql_query($mysqlRecord);
            $rowRecord = mysql_fetch_object($runRecord);
			
			if($rowRecord->deleted_msg_from_user!=''){
				$mess_delete_from_users = $rowRecord->deleted_msg_from_user.",".$userid;
			}else{
				$mess_delete_from_users = $userid;
			}
			$mess_delete_from_users; 
			//$mysql = "UPDATE user_chats SET deleted_msg_from_user = '".$mess_delete_from_users."' WHERE sender ='".$userid."' AND receiver='".$receiver."'";
			$mysql = "UPDATE user_chats SET deleted_msg_from_user = '".$mess_delete_from_users."' WHERE id='".$chat_id."'";
			
		}
		//echo $mysql;exit;
		$run = mysql_query($mysql);
		if($run > 0){
			return 0;
		}else{
			return 1;
		}
		
    }
	


/*
*
*Get all books author by user id ...........
*
*/

 public function getAuthorBooklist($userid) {
	 //echo $userid;exit();
        $mysql = "SELECT tbl_books.id ,tbl_books.book_title, tbl_books.thubm_image, tbl_books.author_name,tbl_books.book_description,tbl_review.rating FROM tbl_books LEFT JOIN tbl_review on tbl_books.id = tbl_review.books_id WHERE tbl_books.user_id= '".$userid."' AND tbl_books.status ='1' GROUP BY tbl_books.id ORDER BY tbl_books.id DESC";
           
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
*Get all pending books list ...........
*
*/

 public function getPendingBooklist($userid){ 
        $mysql = "SELECT id ,book_title, thubm_image, author_name,book_description FROM tbl_books WHERE user_id= '".$userid."' AND status ='0' ORDER BY id DESC";
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
        $mysql = "SELECT id,book_id,question FROM tbl_faq WHERE book_id ='".$bookId."'";
        //echo $mysql;exit();
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

 public function craeteNoteBook($user_id,$description,$title){
            if(!empty($user_id)){
                $mysql = "INSERT INTO tbl_note set user_id ='".$user_id."', description ='".$description."', title ='".$title."',status ='1'";
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
        $mysql = "SELECT id,title,description, created_at FROM tbl_note WHERE user_id='".$user_id."'";
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

 public function UpdateNote($note_id,$description,$title){
        if(!empty($note_id)){
            $updated_at = date("Y-m-d H:i:s");
            $mysql = "update tbl_note set description ='".$description."',title ='".$title."',created_at ='".$updated_at."' WHERE id='".$note_id."'";
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

 public function addAnswer($answer){
        $answerData = json_decode($answer);
        foreach($answerData as $key => $value){
            $qid[] = $value->assignment_id;
            $ansby[] = $value->answered_by;
        }
        $qid = implode(",", $qid);
        $ansby = implode(",", $ansby);

        $mysql = "SELECT * FROM tbl_answer WHERE question_id IN ($qid) AND answered_by IN ($ansby)";
            $assignmentData = mysql_query($mysql);
             while($ansdata = mysql_fetch_object($assignmentData)){
                $rows[] = $ansdata->id;
             }
        if(empty($rows)){
          foreach($answerData as $key => $value){
            $mysql = "INSERT INTO tbl_answer set answer ='".$value->answer."', answered_by='".$value->answered_by."', question_id='".$value->assignment_id."', books_id='".$value->books_id."'";
                 $result = mysql_query($mysql);
             }
             return true;
         }else{
            $updateData = array_combine($rows, $answerData);
            foreach($updateData as $key => $value){
                    $mysql = "update tbl_answer set answer ='".$value->answer."' WHERE id=".$key;
                    $result = mysql_query($mysql);
           }
           return true;
         }
            
  }


  /*
*
*Create note book  ...........
*
*/

 public function gteAnsweredbyuser($user_id,$bookId){
        $mysql = "SELECT tbl_answer.question_id, tbl_answer.books_id , tbl_answer.answer,tbl_faq.question FROM tbl_answer RIGHT JOIN tbl_faq ON tbl_answer.question_id = tbl_faq.id WHERE tbl_answer.answered_by='".$user_id."' AND tbl_answer.books_id='".$bookId."' ORDER BY tbl_answer.question_id ASC";
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

 public function GetPopularBook() { //tbl_books.category_id,
        $mysql = "SELECT tbl_books.id ,tbl_books.book_title, tbl_books.thubm_image, tbl_books.author_name,tbl_books.category_id,tbl_books.book_description,tbl_books.mostView,tbl_review.rating FROM tbl_books LEFT JOIN tbl_review on tbl_books.id = tbl_review.books_id WHERE tbl_books.status='1' group by tbl_books.id  ORDER BY tbl_books.mostView DESC";
        //echo $mysql;exit();
           $result = mysql_query($mysql);
            $num_rows = mysql_num_rows($result);
            if ($num_rows > 0) {
                while($res = mysql_fetch_object($result)){
					$res->book_title = strip_tags($res->book_title);
					 
					 
					$cateNameQ = mysql_query("select category_name from tbl_category where id='".$res->category_id."' ");
					$restultCate = mysql_fetch_array($cateNameQ);
                    $category_name = ($restultCate['category_name'])?$restultCate['category_name']:"NULL";
                     $res->category_name = $category_name; 
					
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


	public function getFollowUsersStaus($userId,$friend_id) {
        $mysql = "SELECT tbl_frnds.id,tbl_frnds.user_id,tbl_frnds.status,tbl_frnds.request_date,user_login_table.url, user_login_table.user_name,user_login_table.publisher_type FROM tbl_frnds INNER JOIN user_login_table ON tbl_frnds.user_id = user_login_table.id WHERE tbl_frnds.frnd_id='".$friend_id."' AND tbl_frnds.user_id='".$userId."'"; 
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
	
	public function getChannelId($userId,$friendId) {
		
		$sql  = "SELECT distinct(user_chats.channel_id) as chid,user_chats.* FROM  user_chats as user_chats  WHERE ( (user_chats.sender = '".$userId."' and user_chats.receiver = '".$friendId."') or (user_chats.sender = '".$friendId."' and user_chats.receiver = '".$userId."')) and is_active='1' and id IN ( SELECT MAX(id) FROM user_chats GROUP BY channel_id order by created desc ) GROUP BY channel_id ORDER  BY user_chats.created desc limit 1"; 
		 
		// WHERE user_chats.id != '".$user_id."'
		$result = mysql_query($sql);
		$otherA = array();
		$num_rows = mysql_num_rows($result);
		if ($num_rows > 0) {
			$key=0;
			while($res = mysql_fetch_object($result)){
				$channelId = $res->channel_id;
			}
			return $channelId; 
		}
	}
	
/*
*
*Get All Requested user ...........
*
*/

 public function getAcceptedList($userId) {
        $mysql = "SELECT tbl_frnds.id,tbl_frnds.user_id,tbl_frnds.status,tbl_frnds.request_date,user_login_table.url, user_login_table.user_name, user_login_table.publisher_type FROM tbl_frnds INNER JOIN user_login_table ON tbl_frnds.user_id = user_login_table.id WHERE tbl_frnds.frnd_id='".$userId."' AND tbl_frnds.status=1";
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
                    $mail->FromName = "ueBook";
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


/*
*function to send the mail
*/

    public function sendEmail($emailFrom, $emailto, $subject, $message){
                   
                    $from = $emailFrom;
                    $message = '<b>Hello Admin <br/><br/></b>
                            New User contacted you having below details:<br/><br/>
                            E-mail:' . $emailFrom . '<br/>
                            Message : ' . $message . '</b><br/><br/>
                            .<br/><br/>
                            Thanks<br/>
                            Team eBooks';
                    $to['email'] = $emailto;
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
                    $mail->From = $emailFrom;
                    $mail->FromName = "ueBook";
                    $mail->AddReplyTo($emailFrom, 'eBooks');
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
                
                return TRUE;

    }



 //stated new function by developer/d
 	
	public function addEditRecord($tbl, $inseditquery, $whrecond=''){ 
		if($tbl!='' && $whrecond!='' && $inseditquery!=''){
			$query_state = "UPDATE ".$tbl." ".$inseditquery." WHERE ".$whrecond; 
			//echo $query_state;exit;
			$result = mysql_query($query_state);
			return true;
		}else if($tbl!='' && $inseditquery!='' && $whrecond==''){
			$query_state = "INSERT INTO ".$tbl." " .$inseditquery; 
			$result = mysql_query($query_state);
			return mysql_insert_id();
		}else{
			return false;
		}
    } 
	
	
	
	 public function getDetails($tbl,$fields='', $whrcond='',$order_by='', $order='', $orWhere='', $limit='', $start='') {
        
		$fields  = ($fields)?$fields:"*"; 
		
		if($tbl!=''){
			$query = "select $fields from $tbl where 1";
			if($whrcond) $query .= " and ".$whrcond;
			//echo $query; die;
			$result = mysql_query($query);
			$num_rows = mysql_num_rows($result);
            if ($num_rows > 0) {
                while($res = mysql_fetch_object($result)){
                   
                    //$res->thubm_image = $_SERVER['HTTP_HOST'].'/ebooks/api/v1/upload/books/'.strip_tags($res->thubm_image);
                    //$res->book_description = strip_tags($res->book_description);
                    $rows[] = $res;
					
                }
                return $rows;
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
    }
	
	 public function getDetails2($tbl,$fields='', $whrcond='',$order_by='', $order='', $orWhere='', $limit='', $start='') {
        
		$fields  = ($fields)?$fields:"*"; 
		
		if($tbl!=''){
			$query = "select $fields from $tbl where 1";
			if($whrcond) $query .= " and ".$whrcond;
			//echo $query; die;
			$result = mysql_query($query);
			$num_rows = mysql_num_rows($result);
            if ($num_rows > 0) {
                while($res = mysql_fetch_array($result)){
                   
                    //$res->thubm_image = $_SERVER['HTTP_HOST'].'/ebooks/api/v1/upload/books/'.strip_tags($res->thubm_image);
                    //$res->book_description = strip_tags($res->book_description);
                    $rows[] = $res;
					
                }
                return $rows;
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
    }
	
	public function getDetailsOther($tbl,$fields='', $whrcond='',$user_id='') {
        
		$fields  = ($fields)?$fields:"*"; 
		
		if($tbl!=''){
			//$query = "select $fields from $tbl where 1"; 
			//( tbl_frnds.user_id = ult.id OR tbl_frnds.frnd_id = ult.id )
			$query = "select $fields from $tbl as ult left join tbl_frnds ON ( tbl_frnds.user_id = ult.id OR tbl_frnds.frnd_id = ult.id )  WHERE 1 and ( tbl_frnds.user_id = $user_id OR tbl_frnds.frnd_id = $user_id ) and tbl_frnds.status=1 and ult.id != $user_id  group by ult.id";
			//tbl_frnds.frnd_id='".$userId."' AND
			//if($whrcond) $query .= " and ".$whrcond."  group by ult.id"; die;
			//echo $query; die;
			$result = mysql_query($query);
			$num_rows = mysql_num_rows($result);
            if ($num_rows > 0) {
                while($res = mysql_fetch_array($result)){
                   
                    //$res->thubm_image = $_SERVER['HTTP_HOST'].'/ebooks/api/v1/upload/books/'.strip_tags($res->thubm_image);
                    //$res->book_description = strip_tags($res->book_description);
                    $rows[] = $res;
					
                }
				
                return $rows;
				
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
    }
	
	public function has_channel($user_id="", $user_id2="")
    {
        if($user_id){
			 $sql   = "SELECT  distinct(user_chats.channel_id) as chid
					FROM user_chats  				
					WHERE ( user_chats.sender  = '" . $user_id . "' AND  user_chats.receiver  = '" . $user_id2 . "')
					OR ( user_chats.sender  = '" . $user_id2 . "' AND  user_chats.receiver  = '" . $user_id . "')
					limit 0,1
					";
			$run = mysql_query($sql);
			$row = mysql_fetch_object($run);
			if(!empty($row)){
				return $row->chid;
			}else{
				return NULL;
			}
		}else{
			return NULL;
       }
       
        
    }
	
	
	public function user_chat_history($user_id="")
    {  
		$sql   = "SELECT  distinct(user_chats.channel_id) as chid, user.id, user.email, user.full_name, user.user_name, user.url as user_pic, user.publisher_type, user_chats.created, user_chats.type, user_chats.message, user_chats.channel_id  FROM user_login_table as user LEFT JOIN user_chats ON ( user_chats.sender  = user.id OR user_chats.receiver  = user.id) WHERE user_chats.sender  = '" . $user_id . "' OR user_chats.receiver  = '" . $user_id . "' ORDER BY user_chats.id DESC ";
		$result = mysql_query($sql);
		$num_rows = mysql_num_rows($result);
		if ($num_rows > 0) {
			while($res = mysql_fetch_array($result)){
			 
				$rows[] = $res;
			}
			return $rows;
			
		}else{
			return NULL;
		}
    }
	
	
	public function user_chat_list_history($user_id="")
    {  
		//echo $sql   = "SELECT distinct(user_chats.channel_id) as chid, user.id, user.email, user.full_name, user.user_name, user.url as user_pic, user.publisher_type, user_chats.created, user_chats.type, user_chats.message, user_chats.channel_id FROM user_chats LEFT JOIN user_login_table  as user  ON (user_chats.sender = user.id or user_chats.receiver = user.id) WHERE is_active='1' group by id desc ORDER BY user_chats.created DESC";
		
		//$sql   = "SELECT distinct(user_chats.channel_id) as chid,user_chats.* FROM  user_chats as user_chats  WHERE (user_chats.sender = '2' or user_chats.receiver = '2') and is_active='1' and id IN ( SELECT MAX(id) FROM user_chats GROUP BY user_chats.channel_id order by created desc )  GROUP BY user_chats.channel_id ORDER  BY user_chats.created desc";
		
		//$sql  = "SELECT distinct(user_chats.channel_id) as chid,user_chats.* FROM  user_chats as user_chats  WHERE (user_chats.sender = '".$user_id."' or user_chats.receiver = '".$user_id."') and is_active='1' and id IN ( SELECT MAX(id) FROM user_chats GROUP BY channel_id order by created desc ) GROUP BY channel_id ORDER  BY user_chats.created desc";  
		
		$musql_check ="SELECT max(id) as maxid FROM user_chats where FIND_IN_SET('".$user_id."', deleted_msg_from_user)";
		$result_check = mysql_query($musql_check);
		$num_rows_check = mysql_num_rows($result_check);
		$res_check = mysql_fetch_object($result_check);	
      
		if($res_check->maxid!='' && $num_rows_check>0){
			
			$sql  = "SELECT distinct(user_chats.channel_id) as chid,user_chats.* FROM  user_chats as user_chats  WHERE (user_chats.sender = '".$user_id."' or user_chats.receiver = '".$user_id."') and is_active='1' and id IN ( SELECT MAX(id) FROM user_chats where id not in (SELECT max(id) FROM user_chats where FIND_IN_SET('".$user_id."', deleted_msg_from_user)) GROUP BY channel_id order by created desc ) GROUP BY channel_id ORDER  BY user_chats.created desc";   
		}else{
			$sql  = "SELECT distinct(user_chats.channel_id) as chid,user_chats.* FROM  user_chats as user_chats  WHERE (user_chats.sender = '".$user_id."' or user_chats.receiver = '".$user_id."') and is_active='1' and id IN ( SELECT MAX(id) FROM user_chats GROUP BY channel_id order by created desc ) GROUP BY channel_id ORDER  BY user_chats.created desc"; 
		}
			 
		 
	
		$result = mysql_query($sql);
		
		$otherA = array();
		
		$num_rows = mysql_num_rows($result);
		
		if ($num_rows > 0) {
			$key=0;
			while($res = mysql_fetch_object($result)){
				//$res->is_group = "No";
				$sender 	= $this->getAuthorDetails2($res->sender);
				$receiver 	= $this->getAuthorDetails2($res->receiver);
				
				
				
				$messageCount = $this->ChatMessageCount($res->receiver,$res->channel_id);
				
				//$otherA['sender'] = $sender ;
				//$otherA['receiver'] = $receiver ;
				//$otherA = $res;
				
				$res->send_detail = $sender;
				$res->rec_detail = $receiver;
				$res->mess_count = $messageCount;
				$rows[] = $res;
				$key++; 
			}
			//print_r($rows); die;
			
			//$rows = array_merge($rows,$group_detilss);
			
			return $rows;
			
		/* }else if(!empty($group_detil)){
			return $group_detilss; */
		}else{
			return NULL;
		}
    }
	
	
	public function select_value($table, $data, $where)
    {
		
		if($table && $where){ 
		     $query = "select $data from $table where 1"; 
			 if($where) $query .= " and ".$where; 
				$run = mysql_query($query);
				$row = mysql_fetch_object($run);
			
			if(!empty($row)){
				return $row->$data;
			}else{
				return NULL;
			}
		}else{
            return NULL;
        }
       
        
    }
 
	public function user_chats($channel_id='',$user_id){
		$chats = array();
		//$sql   = "SELECT * from user_chats WHERE user_chats.channel_id  = '".$channel_id."' and user_chats.is_active='1' ORDER BY user_chats.id ASC";
		
		//$sql   = "SELECT * from user_chats WHERE user_chats.channel_id  = '".$channel_id."' and user_chats.is_active='1' AND user_chats.is_deleted !='1' ORDER BY user_chats.id ASC";
		
		$sql   = "SELECT * from user_chats WHERE user_chats.channel_id  = '".$channel_id."' and user_chats.is_active='1' AND user_chats.id not in (SELECT id FROM user_chats where FIND_IN_SET('".$user_id."', deleted_msg_from_user)) ORDER BY user_chats.id ASC";
		
		
		$result = mysql_query($sql);
		$num_rows = mysql_num_rows($result);
		if ($num_rows > 0) {
			while($res = mysql_fetch_array($result)){
			 
				$chats[] = $res;
			}
			return $chats;
			
		}else{
			return NULL;
		}
	}
	
	public function delete_data($table,$where)
    {	
		if($table && $where){ 
		  $query = "delete from $table where $where";
			$run = mysql_query($query);
			return  true;
		}else{
            return NULL;
        }
       
    }
	
	public function has_unread($user_id="", $user_id2="", $chid="")
    {
        if($user_id="" && $user_id2="" && $chid=""){
		
		$query   = "SELECT  count(user_chats.id) as unread
				FROM user_chats  				
				WHERE ( user_chats.sender  = '" . $user_id . "' AND  user_chats.receiver  = '" . $user_id2 . "')
				AND ( user_chats.channel_id  = '" . $chid . "') AND user_chats.read_msg ='0'
				";
				
				$run = mysql_query($query);
			$row = mysql_fetch_object($run);
			 
			if(!empty($row)){
				return $row->unread;
			}else{
				return NULL;
			}
		}else{
            return NULL;
        }
		
       /*  $query = $this->db->query($sql)->result();
        $this->db->last_query();
        if (($query)) {
            return $query[0]->unread;
        } else {
            return "";
        }
        return ""; */
    }
   
 
 
 /* ====Created by  Developer====
	  Group message/calling 
 */
 
    public function checkGroup($groupid,$name='') {
        
		//$query = 'select a.* from groups_calling as a where a.name="'.$name.'" and a.userid='.$usid.'  and a.status=1   ';
		$query = 'select a.* from groups_calling as a where a.id="'.$groupid.'" and a.status=1'; 
		$run = mysql_query($query);
		$row = mysql_fetch_object($run);
		if(!empty($row)){
			return $row;
		}else{
			return NULL;
		}	
	} 
	 public function recheckGroup($name,$groupid) {
        
		//$query = 'select a.* from groups_calling as a where a.name="'.$name.'" and a.userid !='.$usid.'  and a.status=1 ';
		$query = 'select a.* from groups_calling as a where a.name="'.$name.'" and a.id !='.$groupid.'  and a.status=1 ';
		$run = mysql_query($query);
		$row = mysql_fetch_object($run);
		if(!empty($row)){
			return 1;
		}else{
			return NULL;
		}	
	}
	
	public function getGropDetail($user_id, $name='') {
		//$query = 'select a.* from groups_calling as a where a.userid='.$usid.' and a.status=1 and a.id='.$grid.'  order by a.id desc   ';
		if($user_id!=''){
			
			$query = 'select a.* from groups_calling as a where a.userid='.$user_id.' and a.status=1 '; 
			$run = mysql_query($query);
			$row = mysql_fetch_object($run);
			if(!empty($row)){
				return $row;
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
	} 
	
	public function  getGroupDetails($user_id){
		
		if($user_id!=''){
			
			$query = 'select a.* from groups_calling as a where a.userid='.$user_id.' and a.status=1 '; 
			
			$result = mysql_query($query);
			$num_rows = mysql_num_rows($result);
			if ($num_rows > 0) {
				while($res = mysql_fetch_object($result)){
				 
					$groupchats[] = $res;
				}
				return $groupchats;
				
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
	}
	
	public function  getGroupDetailsOK($user_id){ 
		
		if($user_id!=''){
			
			$query = 'select a.*,guc.messagetype,guc.message,guc.unreadmessage,guc.groupid,guc.created_at as message_date from groups_calling as a left join groupsuserschat as guc on (a.id=guc.groupid) where (a.userid='.$user_id.'  || FIND_IN_SET('.$user_id.',a.groupuserid) ) group by a.id order by guc.created_at desc'; 
			
			//$query = 'select a.* from groups_calling as a where   (a.userid='.$user_id.'  || FIND_IN_SET('.$user_id.',a.groupuserid) )  and a.status=1 order by a.id desc ';  
			
			//echo $query = 'select a.*,guc.messagetype,guc.message from groups_calling as a left join groupsuserschat as guc  where (a.userid='.$user_id.' || FIND_IN_SET('.$user_id.',a.groupuserid) )  and a.status=1  order by guc.id desc ';  die;
			
			$result = mysql_query($query);
			$num_rows = mysql_num_rows($result);	
			if ($num_rows > 0) {
				while($res = mysql_fetch_object($result)){
					
					$group_pic = '';
					if(file_exists($_SERVER['DOCUMENT_ROOT'].'/ebooks/api/v1/'.$res->group_image)){ 
						if($res->group_image!=''){
							//$group_pic = $_SERVER['HTTP_HOST'].'/ebooks/api/v1/'.strip_tags($res->group_image);
							$group_pic = strip_tags($res->group_image);
						}
					} 
					$res->group_image = $group_pic; 
					
					/* $queryMessage = 'select guc.messagetype,guc.message,guc.unreadmessage from groupsuserschat as guc where (guc.userid='.$user_id.'  || FIND_IN_SET('.$user_id.',guc.sendtoid) )  and guc.status=1 order by guc.uschid desc limit 1 '; 
					
					$resultMessage = mysql_query($queryMessage);
					$num_rows_message = mysql_num_rows($resultMessage);
					if ($num_rows_message > 0) {
						while($resMessage = mysql_fetch_object($resultMessage)){		
							$res->messagetype = $resMessage->messagetype;
							$res->message = $resMessage->message;
							$res->unreadmessage = $resMessage->unreadmessage;
						}
					}else {
						$res->messagetype = $resMessage->messagetype;
						$res->message = $resMessage->message;
						$res->unreadmessage = $resMessage->unreadmessage;
					} */						
					
					$allGrops[] = $res;
				}
				return $allGrops;
				
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
	}
	
	
	public function  selUserMessageGroupData($user_id,$group_id){
		
		if($user_id!='' && $group_id!=''){
			
			$query = 'select a.* from groups_calling as a where   (a.userid='.$user_id.'  || FIND_IN_SET('.$user_id.',a.groupuserid) )  and a.status=1 and a.id='.$group_id.' order by a.id desc'; 
			
			$run = mysql_query($query);
			$num_rows = mysql_num_rows($run);
			if($num_rows>0){
				$row = mysql_fetch_object($run);
				return $row;
			}else{
				return NULL;
			
			}
			
		}else{
			return NULL;
		}
	}
	
	public function mess_delete_by_user($chat_id, $group_id){
		
		if($chat_id!='' && $group_id!=''){
			
			$query  = "SELECT * FROM groupsuserschat WHERE uschid = '".$chat_id."' AND groupid= '".$group_id."' and status=1 "; 
			
			$run = mysql_query($query);
			$num_rows = mysql_num_rows($run);
			if($num_rows > 0){
				$row = mysql_fetch_object($run);
				return $row;
			}else{
				return NULL;
			}
			
		}
	}
	
	public function  selRecordByGroupId($group_id){
		
		if($group_id!=''){
			
			$query = 'select a.* from groups_calling as a where a.status=1 and a.id='.$group_id.' '; 
			
			$run = mysql_query($query);
			$num_rows = mysql_num_rows($run);
			if($num_rows>0){
				$row = mysql_fetch_object($run);
				return $row;
			}else{
				return NULL;
			
			}
			
		}else{
			return NULL;
		}
	}
	
	public function userGroupList($user_id) {
		
		if($user_id!=''){
			
			$query = 'select a.* from groups_calling as a where (a.userid='.$user_id.'  || FIND_IN_SET('.$user_id.',a.groupuserid) )  and a.status=1 order by a.id desc  ';
			$run = mysql_query($query);
			$num_rows = mysql_num_rows($run);
			if ($num_rows > 0) {
				while($res = mysql_fetch_object($run)){
				 
					$userListGroup[] = $res;
				}
				return $userListGroup;
				
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
	}
	
	public function selectUsersByGroup($user_id) {
		
		if($user_id!=''){
			$query = 'select a.id,a.user_name,a.url,a.device_token,a.device_type from user_login_table as a where a.id IN ('.$user_id.')'; 
			$run = mysql_query($query);
			$num_rows = mysql_num_rows($run);
			if ($num_rows > 0) {
				while($res = mysql_fetch_object($run)){
				 
					$userListGroup[] = $res;
				}
				return $userListGroup;
				
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
	}
	
	public function getGroupChats($user_id,$group_id) {
		
		if($user_id && $group_id){
			
			 //$query = "select * from groupsuserschat where 1 and (sendtoid = '".$user_id."' or userid = '".$user_id."') AND groupid = '".$group_id."' AND status = '1'"; 
			

			//$query = "select * from groupsuserschat where 1 AND groupid = '".$group_id."' AND status = '1' and userdelete group by message,created_at order by uschid asc"; 
			
			 //$query = "select * from groupsuserschat where 1 AND groupid = '".$group_id."' AND status = '1' and if(`userdelete`!= if(userid=$user_id) group by message,created_at order by uschid asc"; 
			//$query = "select * from groupsuserschat where 1 AND groupid = '".$group_id."' AND status = '1' group by message,created_at order by uschid asc"; 
			  
			//$query = "select * from groupsuserschat where 1 AND groupid =  '".$group_id."' AND status = '1' AND uschid NOT IN (SELECT uschid FROM groupsuserschat where FIND_IN_SET('".$user_id."', message_deleted_by_user)) group by message,created_at order by uschid asc"; 


			$query = "select * from groupsuserschat where 1 AND groupid =  '".$group_id."' AND status = '1' AND (sendtoid = '".$user_id."' or userid = '".$user_id."') AND uschid NOT IN (SELECT uschid FROM groupsuserschat where FIND_IN_SET('".$user_id."', message_deleted_by_user)) group by message,created_at order by uschid asc"; 	

			
			
			$result = mysql_query($query);
			$num_rows = mysql_num_rows($result);
            if ($num_rows > 0) {
                while($res = mysql_fetch_object($result)){
                    $rows[] = $res;
					
                }
                return $rows;
				
			}else{
				return NULL;
			}
		}else{
			return NULL;
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
