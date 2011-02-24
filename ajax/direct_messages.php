<?php
	include_once('../inc/sina.php');
	
	if($_REQUEST['max_id'])
		get_direct_messages($_REQUEST['max_id']);
	else
		get_direct_messages();	
	
?>
