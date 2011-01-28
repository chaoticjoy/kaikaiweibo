<?php
	include_once('../inc/sina.php');
	
	if($_REQUEST['screen_name']&&$_REQUEST['max_id']){
		get_user_timeline($_REQUEST['screen_name'],$_REQUEST['max_id']);
}		
	elseif($_REQUEST['max_id']){
		get_user_timeline(0,$_REQUEST['max_id']);
}	
	elseif($_REQUEST['screen_name']){
		get_user_timeline($_REQUEST['screen_name']);
		}
	else{
		get_user_timeline();
		}
?>
