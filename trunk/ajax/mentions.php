<?php
	include_once('../inc/sina.php');
	
	if($_REQUEST['max_id'])
		get_mentions($_REQUEST['max_id']);
	else
		get_mentions();	
	
?>
