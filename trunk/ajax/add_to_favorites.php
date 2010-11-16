<?php

include_once('../lib/weibo.php');

	$w = new weibo( APP_KEY );
	$w->setUser( getEncryptCookie('sina_name') , getEncryptCookie('sina_pw') );
	$w->add_to_favorites($_REQUEST['id']);

?>
