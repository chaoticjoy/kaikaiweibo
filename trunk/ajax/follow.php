<?php

include_once('../lib/weibo.php');
include_once('../inc/config.php');
include_once('../inc/utility.php');
	$w = new weibo( APP_KEY );
	$w->setUser( getEncryptCookie('sina_name') , getEncryptCookie('sina_pw') );
	$w->follow($_REQUEST['screen_name']);

?>
