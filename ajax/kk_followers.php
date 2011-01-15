<?php

include_once('../inc/kk.php');
	
	if($_REQUEST['id']&&$_REQUEST['page'])
		get_followers($_REQUEST['id'],$_REQUEST['page']);
	elseif($_REQUEST['id'])
		get_followers($_REQUEST['id']);
/* 	else
		get_followers(183911); */
?>
