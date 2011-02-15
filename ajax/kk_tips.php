<?php
	include_once('../inc/kk.php');

	if($_REQUEST['poi_id']&&$_REQUEST['page'])
		get_tips($_REQUEST['poi_id'],$_REQUEST['page']);
	elseif($_REQUEST['poi_id'])
		get_tips($_REQUEST['poi_id']);
		
	//get_tips(14751887);



?>
