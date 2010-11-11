<?php

	include_once('../inc/sina.php');
	
	if($_REQUEST['count']&&$_REQUEST['page'])
		get_friends_timeline($_REQUEST['count'],$_REQUEST['page']);
	else
		get_friends_timeline();
?>
