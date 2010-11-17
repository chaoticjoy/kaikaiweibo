<?php

include_once('../lib/weibo.php');
include_once('../inc/config.php');
include_once('../inc/utility.php');
	$w = new weibo( APP_KEY );
	$w->setUser( getEncryptCookie('sina_name') , getEncryptCookie('sina_pw') );
	if($_REQUEST['screen_name']&&$_REQUEST['text'])
		$w->send_direct_messages($_REQUEST['screen_name'],$_REQUEST['text']);

?>
