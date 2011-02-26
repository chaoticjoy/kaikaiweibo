<?php
	include_once('../inc/kk.php');
	
	if($_REQUEST['page']&&$_REQUEST['id'])
		get_user_timeline2($_REQUEST['page'],$_REQUEST['id']);
	elseif($_REQUEST['page'])
		get_user_timeline2($_REQUEST['page']);
	
	else{
		get_user_timeline2();
		}
/* 	else
		get_user_timeline('kavin'); */
?>
