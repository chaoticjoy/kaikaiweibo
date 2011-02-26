<?php 
	include_once('inc/utility.php');
	delCookie('sina_name');
	delCookie('sina_pw');
	delCookie('sina_screen_name');
	delCookie('sina_id');
	delCookie('kk_name');
	delCookie('kk_pw');
	delCookie('kk_screen_name');
	delCookie('kk_id');
	header('location: login.php');
?>