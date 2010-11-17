<?php
	include_once('../inc/sina.php');
	if($_REQUEST['id']&&$_REQUEST['count']&&$_REQUEST['page'])
		get_comments_list($_REQUEST['id'],$_REQUEST['count'],$_REQUEST['page']);
	else
		get_comments_list($_REQUEST['id']);
?>
