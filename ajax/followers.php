﻿<?php

include_once('../inc/sina.php');
	
	if($_REQUEST['count']&&$_REQUEST['page'])
		get_followers($_REQUEST['screen_name'],$_REQUEST['count'],$_REQUEST['page']);
	else
		get_followers();
?>
