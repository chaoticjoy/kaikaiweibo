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
				echo "<script language=\"javascript\">alert('\u767B\u9646\u5931\u8D25\uFF01\u8BF7\u91CD\u65B0\u767B\u9646\u3002');</script>";
				echo "<script language=\"javascript\">location.href='login.php';</script>";
			}
			
	} 
	else {
		//echo "<p>非法请求，请返回</p>";
		echo "<script charset=\"gb2312\" language=\"javascript\">alert('\u975E\u6CD5\u8BF7\u6C42\uFF01');</script>";
		echo "<script language=\"javascript\">location.href='index.php';</script>";
	}
?>