<?php
	include_once('../inc/sina.php');

	
	if($_REQUEST['screen_name'])
		get_user_info($_REQUEST['screen_name']);
	else{
		
		get_user_info($_COOKIE['sina_screen_name']);	
	}



?>
