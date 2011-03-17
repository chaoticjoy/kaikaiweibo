<?php

include_once('../lib/weibo.php');
include_once('../inc/config.php');
include_once('../inc/utility.php');
	$w = new weibo( APP_KEY );
	$w->setUser( getEncryptCookie('sina_name') , getEncryptCookie('sina_pw') );
	if($_REQUEST['status']&&$_REQUEST['url'])
		$w->upload($_REQUEST['status'],file_get_contents("$_REQUEST['status']"));
	elseif($_REQUEST['status'])
		$w->upload($_REQUEST['status'],file_get_contents("../image/logo.jpg"));

?>
