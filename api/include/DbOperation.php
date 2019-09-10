<?php
require_once('DbConnect.php');
require_once('PHPMailerAutoload.php');

$db = new DbConnect();
class DbOperation {
    /*
    *User registration............
    *
    */

    public function createUser($full_name, $pass, $email, $phone_no, $file_url, $device_token, $device_type, $random_number, $country="",$gender,$publisher_type,$user_name){
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
                                                        user_name      ='".$user_name."'";
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
    function userEdit($address, $user_id, $file_url, $country="",$password,$publisher_type,$email) {
        $password = base64_encode($password);
        $mysql = "update user_login_table set  address ='".$address."',
                                               country ='".$country."',
                                               password ='".$password."',
                                               publisher_type ='".$publisher_type."',
                                               email ='".$email."' where id='".$user_id."'";
        
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

public function getBookbyCategoryId($cat_id) {

    //echo "<pre>";print_r($_POST);exit();
        date_default_timezone_set('America/Los_Angeles');
        $rows = array();
        $mysql = "SELECT id ,book_title, thubm_image, author_name FROM tbl_books WHERE category_id='".$cat_id."' and status=1";
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
            return 1;
        }
    }



/*
*
*Get book details by id ...........
*
*/

 public function getbooksDetailByid($bookId) {
        $mysql = "SELECT * FROM tbl_books WHERE  id='".$bookId."'";
        $run = mysql_query($mysql);
        $row = mysql_fetch_object($run);
        $row->book_title = strip_tags($row->book_title);
        $row->book_description = strip_tags($row->book_description);
        $row->thubm_image = $_SERVER['HTTP_HOST'].'/ebooks/api/v1/upload/books/'.$row->thubm_image;
        $row->book_image = $_SERVER['HTTP_HOST'].'/ebooks/api/v1/upload/books/'.$row->book_image;
        $row->video_url = $_SERVER['HTTP_HOST'].'/ebooks/api/v1/upload/books/'.$row->video_url;
        $row->audio_url = $_SERVER['HTTP_HOST'].'/ebooks/api/v1/upload/books/'.$row->audio_url;
        $row->pdf_url = $_SERVER['HTTP_HOST'].'/ebooks/api/v1/upload/books/'.$row->pdf_url;
        return $row;
    }



/*
*
*Get book details by id ...........
*
*/


public function addUpdateBookmark($bookId, $bookmarStatus) {
        if($bookId!=='' && $bookmarStatus == 1){
            $date_edited = date("Y-m-d H:i:s");
                $mysql = "update tbl_books set bookMark ='1',updated_at ='".$date_edited."' WHERE  id='".$bookId."'";
                $result = mysql_query($mysql);
                //echo "<pre>";print_r($result);exit();
                return 'active';
            }else{
                $date_edited = date("y-m-d h:i:s");
                $mysql = "update tbl_books set bookMark ='0',updated_at ='".$date_edited."' WHERE  id='".$bookId."'";
                $result = mysql_query($mysql);
                return 'deactive';
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
