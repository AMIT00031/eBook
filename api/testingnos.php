 <?php 
/*$deviceToken ='891273F265D9F471A56255A5270446868A9F812F618F6AACA77D7A1A2975A619';
$passphrase = '12345';
$message = 'A push notification has been sent!';
$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'v1/apns-dev.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
echo $fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
if (!$fp)
{ 
	exit("Failed to connect: $err $errstr" . PHP_EOL);
}
echo 'Connected to APNS' . PHP_EOL;
$body['aps'] = array(
	'alert' => array(
        'body' => $message,
		'action-loc-key' => 'Its Story Time App',
    ),
    'badge' => 3,
	);
var_dump($body);
$payload = json_encode($body);
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
$result = fwrite($fp, $msg, strlen($msg));
if (!$result)
	echo 'Message not delivered' . PHP_EOL;
else
	echo 'Message successfully delivered' . PHP_EOL;
fclose($fp);

*/



$apnsHost = 'gateway.sandbox.push.apple.com';
$apnsCert = 'v1/apns-dev.pem';
$apnsPort = 2195;
$apnsPass = '12345';
$token = '891273F265D9F471A56255A5270446868A9F812F618F6AACA77D7A1A2975A619';

$payload['aps'] = array('alert' => 'Oh hai!', 'badge' => 1, 'sound' => 'default');
$output = json_encode($payload);
$token = pack('H*', str_replace(' ', '', $token));
$apnsMessage = chr(0).chr(0).chr(32).$token.chr(0).chr(strlen($output)).$output;

$streamContext = stream_context_create();
stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
stream_context_set_option($streamContext, 'ssl', 'passphrase', $apnsPass);

$apns = stream_socket_client('ssl://'.$apnsHost.':'.$apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);
fwrite($apns, $apnsMessage);
fclose($apns);
?>