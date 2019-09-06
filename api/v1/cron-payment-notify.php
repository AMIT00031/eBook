<?php

//connection to DB
$conn =@mysql_connect("localhost" ,"dnddemo_dnd" ,"dnd@123") or die("Error:".mysql_error()); 
@mysql_select_db("dnddemo_story_app",$conn) or  die("Error:".mysql_error());


function sendHTMLMail($to,$subject,$matter,$from)
  {
    $headers  = "MIME-Version: 1.0\r\n"; 
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
    $headers .= "From:$from\r\n";
    //echo "to->".$to."<br>subject->".$subject."<br>matter->".$matter."<br>from->".$from;
    //die;
    if(mail($to,$subject,$matter,$headers))
    {
      return true;
    }
    else
    {
      return false;
    }

  }

$current_month=date("m",mktime(0,0,0,date("m"),date("d"),date("Y")));
$current_date=date("d",mktime(0,0,0,date("m"),date("d"),date("Y")));
$current_year=date("Y",mktime(0,0,0,date("m"),date("d"),date("Y")));

  $query1="select * from user_login_table where 1=1 and year(expire_on)=$current_year  and month(expire_on)=$current_month and day(expire_on)=$current_date order by id desc ";
$tribute1=mysql_query($query1);

while ($value = mysql_fetch_array($tribute1)) {


/////////////////////////////////////////////////////////////


$apnsHost = 'gateway.sandbox.push.apple.com';
$apnsCert = 'apns-dev.pem';
$apnsPort = 2195;
$apnsPass = '12345';
 $token = $value['device_token'];
 $mst = 'Hello '.$value['full_name'].'.Your subscription for Itsstorytime App is expires in one day.You can renew it right now. !';

$payload['aps'] = array('alert' => $mst, 'badge' => 1, 'sound' => 'default');
$payload['api_type'] = 'renew_payment_info';
$payload['user_id'] = $value['id'];
$payload['subscription'] = $value['subscription'];

$output = json_encode($payload);
$token = pack('H*', str_replace(' ', '', $token));
$apnsMessage = chr(0).chr(0).chr(32).$token.chr(0).chr(strlen($output)).$output;

$streamContext = stream_context_create();
stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
stream_context_set_option($streamContext, 'ssl', 'passphrase', $apnsPass);

$apns = stream_socket_client('ssl://'.$apnsHost.':'.$apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);
fwrite($apns, $apnsMessage);
fclose($apns);


///////////////////////////////////////////////////////////     



//For sending mail script are written here
	$to=$value['email'];
	$subject=$value['full_name']." - ItsStorytimeApp Plan Renewal Reminder";
	$from="support@itsstorytimeapp.com";
  $rurl='http://www.itsstorytimeapp.com/';
	echo  $matter='
	

<html>
  <head>
  <title>'.$subject.'</title>
  </head>
   <body style="padding:20px;height:400px;width:768px;">
   <div style="width:88%;margin:0 auto;padding:5px;">

  <div style="display: block;width:100%;padding:10px;background:#F4F7F9;border:solid 1px maroon;">
    <div style="display: block;width:100%;text-align:right"><img src="http://www.itsstorytimeapp.com/img/logo/logo-2.png"/></div>
  Hi '.$value['full_name'].',<br><br>
  
     This is an automated itsstorytimeapp.com subscription renewal reminder .You are requested to kindly renew subscription immediately to keep the above profile active . Click on the button below to renew your membership now.

<br/><br/>
    <a style="background: rgba(0, 0, 0, 0) linear-gradient(to bottom, #fcfff4 0%, #f4c22f 100%) repeat scroll 0 0;
    border: 1px solid #ddd;
    color: #333;
    height: 33px;
    line-height: 32px;
    margin-bottom: 12px;
    text-align: center;
    width: 98%;font-family:tahoma;padding:10px;text-decoration:none" href="'.$rurl.'">Renew Your Subscription</a>
  <br><br><br>
<b>
Thank you,<br>
Team - Itsstorytime<br>
An Exclusive Service by itsstorytimeapp.com<br>
</b>
  
  
</div>
</div>
  </body>
  </html>
	';
	//sendHTMLMail($to,$subject,$matter,$from);


}

	


