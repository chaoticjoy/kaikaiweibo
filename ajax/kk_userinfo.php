<?php
	include_once('../inc/kk.php');

	
	if($_REQUEST['id'])
		get_user_info($_REQUEST['id']);
	else{
		
		get_user_info();	
	}



?>
