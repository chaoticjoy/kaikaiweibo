<?php

include_once('../inc/sina.php');
	
	if($_REQUEST['count']&&$_REQUEST['cursor'])
		get_followers($_REQUEST['screen_name'],$_REQUEST['count'],$_REQUEST['cursor']);
	else
		get_followers();
?>
