<?php
require('SendSMS.php');

$sendsms = new SendSMS("admin@gmail.com","*****","iPOpQbiUTD");


/* if the login return 0, means that login failed, you cant send sms after this */
if  (  ($sendsms->login()) == 0  ) {
	die( "failed");
}

/*other wise, you can send sms using the simple send() call*/

$sendsms->send("+92123456789","please update me, when you receive any message?");


?>
