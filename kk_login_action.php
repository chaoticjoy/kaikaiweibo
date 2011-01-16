<?php

include_once('inc/config.php');
include_once('lib/kaikai.php');
include_once('inc/utility.php');
	function verify($username, $password, $remember) {
	
		$k = new kaikai( KAIKAI_KEY );
		$k->setUser( $username, $password );
		$user=$k->verify_credentials();
		//print_r($user);
		if ($user['login']['user']['screen_name']) {
			$time = $remember ? time()+3600*24*365 : 0;
			setEncryptCookie('kk_name', $username, $time, '/');
			setEncryptCookie('kk_pw', $password, $time, '/');
			return 1;
		} else {
			return 0;
		}
	}	

	
	if ( isset($_POST['username']) && isset($_POST['password']) ) {
		
			$remember = isset($_POST['remember']) ? true : false;
			$result = verify($_POST['username'], $_POST['password'], $remember);
			
			if ($result ) {
				//echo "<p>��½�ɹ�</p>";
				echo "<script language=\"javascript\">location.href='index.php';</script>";
			}
			else{
				echo "<script language=\"javascript\">alert('\u767B\u9646\u5931\u8D25\uFF01\u8BF7\u91CD\u65B0\u767B\u9646\u3002');</script>";
				echo "<script language=\"javascript\">location.href='kk_login.php';</script>";
			}
			
	} 
	else {
		//echo "<p>�Ƿ������뷵��</p>";
		echo "<script charset=\"gb2312\" language=\"javascript\">alert('\u975E\u6CD5\u8BF7\u6C42\uFF01');</script>";
		echo "<script language=\"javascript\">location.href='kaikai_login.php';</script>";
	}
?>