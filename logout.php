<?php 
	include_once('inc/utility.php');
	delCookie('sina_name');
	delCookie('sina_pw');
	header('location: login.php');
?>