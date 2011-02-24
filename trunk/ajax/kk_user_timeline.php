<?php
	include_once('../inc/kk.php');
	
	if($_REQUEST['username']&&$_REQUEST['page'])
		get_user_timeline($_REQUEST['username'],$_REQUEST['page']);
	elseif($_REQUEST['username'])
		get_user_timeline($_REQUEST['username']);
	else{
		get_user_timeline($_COOKIE['kk_screen_name']);
		}
/* 	else
		get_user_timeline('kavin'); */
?>
