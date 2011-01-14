<?php

	include_once('../inc/kk.php');
	
	if($_REQUEST['page'])
		get_friends_timeline($_REQUEST['page']);
	else
		get_friends_timeline();
?>
