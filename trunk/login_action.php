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
				echo "<script language=\"javascript\">location.href='index.php';</script>";
			}
			else{
				echo "<script language=\"javascript\">alert('登陆失败，请重新登录。');</script>";
				echo "<script language=\"javascript\">location.href='login.php';</script>";
			}
			
	} 
	else {
		//echo "<p>非法请求，请返回</p>";
		echo "<script language=\"javascript\">alert('非法请求!');</script>";
		echo "<script language=\"javascript\">location.href='index.php';</script>";
	}
?>