<?php

include_once('../inc/kk.php');
	
	if($_REQUEST['id']&&$_REQUEST['page'])
		get_friends($_REQUEST['id'],$_REQUEST['page']);
	elseif($_REQUEST['id'])
		get_friends($_REQUEST['id']);
/* 	else
		get_friends(183911); */
?>
