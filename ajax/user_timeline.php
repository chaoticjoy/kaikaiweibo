<?php
	include_once('../inc/sina.php');
	
	
	if($_REQUEST['max_id'])
		get_user_timeline($_REQUEST['screen_name'],$_REQUEST['max_id']);
	else
		get_user_timeline();
?>
