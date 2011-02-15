<?php
	include_once('../lib/weibo.php');
	include_once('../inc/config.php');
	include_once('../inc/utility.php');
	
	$w = new weibo( APP_KEY );
	$w->setUser( getEncryptCookie('sina_name') , getEncryptCookie('sina_pw') );
	if($_REQUEST['with_new_status']&&$_REQUEST['since_id'])
		$unread=$w->unread($_REQUEST['with_new_status'],$_REQUEST['since_id']);
	else
		$unread=$w->unread();
	//print_r($unread);
	echo "followers:".$unread['followers'];
	echo "<br>";
	echo "dm:".$unread['dm'];
	echo "<br>";
	echo "mentions:".$unread['mentions'];
	echo "<br>";
	echo "comments:".$unread['comments'];
	echo "<br>";
	echo "new_status:".$unread['new_status'];
	echo "<br>";
?>
