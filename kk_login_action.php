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
				//echo "<p>登陆成功</p>";
				echo 'True';
			}
			else{
				echo 'False';
			}
			
	} 
	else {
		//echo "<p>非法请求，请返回</p>";
		echo 'False';
	}
?>