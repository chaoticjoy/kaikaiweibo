<?php
	include_once('../inc/sina.php');
	
	if($_REQUEST['page'])
		get_favorites($_REQUEST['page']);
	else
		get_favorites();	
?>
