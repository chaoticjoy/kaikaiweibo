<?php

include_once('../inc/sina.php');
	
	if($_REQUEST['count']&&$_REQUEST['cursor'])
		get_friends($_REQUEST['screen_name'],$_REQUEST['count'],$_REQUEST['cursor']);
	elseif($_REQUEST['screen_name'])
		get_friends($_REQUEST['screen_name']);
	else
		get_friends();
?>
