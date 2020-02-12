<?php

/*
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License version 2 as
 *  published by the Free Software Foundation
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston,
 *  MA 02111-1307, USA.
 *
 *  SendSMS 0.5 <info@mypapit.net>
 *  Copyright 2009 Mohammad Hafiz bin Ismail (9W2WTF). All rights reserved.
 *
 *  SendSMS.php
 *  PHP class: Send SMS to Clickatell server using HTTP POST API
 *
 *  Requires: php-cURL or libcurlemu ( http://code.blitzaffe.com/ )
 *
 */



class SendSMS {


	private $username,$password,$api;
	protected $api_url = "http://api.clickatell.com/http/auth";
	protected $send_url = "http://api.clickatell.com/http/sendmsg";
	private $session_id;

	public function __construct($username,$password,$api){

		$this->username = $username;
		$this->password = $password;
		$this->api = $api;

	}


	public function login () {
			$ch = curl_init();


			curl_setopt($ch, CURLOPT_URL,$this->api_url);
			curl_setopt($ch, CURLOPT_POST, 3);
			curl_setopt($ch, CURLOPT_POSTFIELDS,"user=" . $this->username . "&password=" . $this->password . "&api_id=" . $this->api);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);
			$result= curl_exec ($ch);
			curl_close ($ch);

			$ret = split(":",$result);
			//echo $ret[0];

/* if there's failure, return 0 */
			if (strcmp(trim($ret[0]),"OK") !=0 ) {
				return 0;

			}


/*if it's ok, then return 1 */
			$this->session_id = trim($ret[1]);

			return 1;


	}


	public function send($number,$text){

			$sendtext=urlencode($text);
			$phone=urlencode($number);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$this->send_url);
			curl_setopt($ch, CURLOPT_POST, 3);
			curl_setopt($ch, CURLOPT_POSTFIELDS,"session_id=" . $this->session_id . "&to=$phone&text=$sendtext");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);
			$result= curl_exec ($ch);
			curl_close ($ch);

			/*
			echo $result;
			echo "<br /><br />" . $this->session_id;
			*/
/* if there's failure, return 0 */
			$ret = split(":",$result);
			if (strcmp(trim($send[0]),"ID") !=0 )
			{
				return 0;

			}
/* if its ok, return 1 */
			return 1;



	}




}

?>
