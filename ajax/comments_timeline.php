<?php
	include_once('../inc/sina.php');
	
	if($_REQUEST['page'])
		get_comments_timeline($_REQUEST['page']);
	else
		get_comments_timeline();	
?>
