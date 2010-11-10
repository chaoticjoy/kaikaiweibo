<?php

include_once('inc/config.php');
include_once('lib/weibo.php');
include_once('inc/utility.php');
include_once('inc/sina.php');	

	
	if ( isset($_POST['username']) && isset($_POST['password']) ) {
		
			$remember = isset($_POST['remember']) ? true : false;
			$result = verify($_POST['username'], $_POST['password'], $remember);
			
			if ($result ) {
				//echo "<p>登陆成功</p>";
				header('location: index.php');
			}
			else{
				echo "<p>登陆失败，请重试</p>";
			}
			
	} 
	else {
		echo "<p>非法请求，请返回</p>";
	}
?>