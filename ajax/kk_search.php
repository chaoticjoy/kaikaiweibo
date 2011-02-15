<?php
	include_once('../inc/kk.php');
	
	if($_REQUEST['lat']&&$_REQUEST['lon']&&$_REQUEST['query']){
		if($_REQUEST['page'])
			get_search($_REQUEST['lat'],$_REQUEST['lon'],$_REQUEST['query'],$_REQUEST['page']);
		else
			get_search($_REQUEST['lat'],$_REQUEST['lon'],$_REQUEST['query']);
	}
	elseif($_REQUEST['lat']&&$_REQUEST['lon'])
	{
		if($_REQUEST['page'])
			get_search($_REQUEST['lat'],$_REQUEST['lon'],'',$_REQUEST['page']);
		else
			get_search($_REQUEST['lat'],$_REQUEST['lon']);
	}
/* 	else
		get_search(23.164746,113.346076); */
?>
