<?php 
	include_once('lib/utility.php');
	delCookie('sina_name');
	delCookie('sina_pw');
	header('location: login.php');
?>