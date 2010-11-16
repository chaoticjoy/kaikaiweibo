<?php

include_once('../lib/weibo.php');

	$w = new weibo( APP_KEY );
	$w->setUser( getEncryptCookie('sina_name') , getEncryptCookie('sina_pw') );
	$w->send_comment($_REQUEST['id'],$_REQUEST['status'],$_REQUEST['cid']);

?>
