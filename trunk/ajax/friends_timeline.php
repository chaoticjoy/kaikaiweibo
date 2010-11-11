<?php

	include_once('../inc/sina.php');
	
	if($_REQUEST['max_id'])
		get_friends_timeline($_REQUEST['max_id']);
	else
		get_friends_timeline();
?>
