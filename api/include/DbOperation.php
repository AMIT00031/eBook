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
        if (!$this->isUserExists($email)){
            $password = md5($pass);
            date_default_timezone_set('Asia/Calcutta');

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
                        //$return_data=array(email=>$email,suseremail=>$suseremail,full_name=>$full_name);
                        $return_data = $user_login_id.'&'.$email.'&'.$phone_no.'&'.$full_name;

                        if($result){
                            $data = 'Now you can login with this email and password';
                            $to = $email;
                            $subject = 'Your registration is completed';
                            /* Let's Prepare The Message For The E-mail */
                            $message = 'Hello '.$username.'
                            Your email and password is following:
                            E-mail: '.$email.'
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
        $password = md5($pass);
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
    function userEdit($full_name, $address, $user_id, $file_url, $phone , $country="",$password,$publisher_type,$gender) {
        $password = md5($password);
        if(!empty($file_url)){
            $mysql = "update user_login_table set full_name      ='".$full_name."',
		                                             address      ='".$address."',
		                                             country     ='".$country."',
											         thumb_image ='".$file_url."',
											         phone_no    ='".$phone."',
                                                     password    ='".$password."',
                                                     publisher_type ='".$publisher_type."',
                                                     gender ='".$gender."' where id='".$user_id."'";
        }else{

            $mysql = "update user_login_table set full_name ='".$full_name."',
                                                    address ='".$address."',
                                                    country ='".$country."',
											       phone_no ='".$phone."',
                                                   password ='".$password."',
                                                   publisher_type ='".$publisher_type."',
                                                   gender ='".$gender."' where id='".$user_id."'";
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
        $password = md5($npass);
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
        $password = md5($pass);

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

    private function isUserExists($email) {
        $mysql = "SELECT id from user_login_table WHERE email ='".$email."'";
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
        $password = md5($pass);
        $rows = array();
        $mysql = "SELECT * FROM user_login_table WHERE (user_name = '".$user_name."') and password='".$password."'";
        $run = mysql_query($mysql);
        $user = mysql_fetch_object($run);
        $rows[] = $user;
        return $rows;
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
