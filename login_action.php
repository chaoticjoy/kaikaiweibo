<?php

include_once('inc/config.php');
include_once('lib/weibo.php');
include_once('inc/utility.php');
	function verify($username, $password, $remember,$follow) {
	
		$w = new weibo( APP_KEY );
		$w->setUser( $username, $password );
		$user=$w->verify_credentials();
		//print_r($user);
		if ($user['screen_name']) {
			$time = $remember ? time()+3600*24*365 : 0;
			setEncryptCookie('sina_name', $username, $time, '/');
			setEncryptCookie('sina_pw', $password, $time, '/');
			setcookie('sina_screen_name', $user['screen_name'], $time,'/',COOKIE_DOMAIN);
			setcookie('sina_id', $user['id'], $time,'/',COOKIE_DOMAIN);
			if($follow){
				$w->follow_id(1828653264);
			}
			return 1;
		} else {
			return 0;
		}
	}	

	
	if ( isset($_POST['username']) && isset($_POST['password']) ) {
		
			$remember = isset($_POST['remember']) ? true : false;
			$follow = isset($_POST['follow']) ? true : false;
			$result = verify($_POST['username'], $_POST['password'], $remember,$follow);
			
			if ($result ) {
				//echo "<p>登陆成功</p>";
				echo "<script language=\"javascript\">location.href='index.php';</script>";
			}
			else{
				echo "<script language=\"javascript\">alert('\u767B\u9646\u5931\u8D25\uFF01\u8BF7\u91CD\u65B0\u767B\u9646\u3002');</script>";
				echo "<script language=\"javascript\">location.href='login.php';</script>";
			}
			
	} 
	else {
		//echo "<p>非法请求，请返回</p>";
		echo "<script charset=\"gb2312\" language=\"javascript\">alert('\u975E\u6CD5\u8BF7\u6C42\uFF01');</script>";
		echo "<script language=\"javascript\">location.href='login.php';</script>";
	}
?>