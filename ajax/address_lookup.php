<?php
	include_once('../lib/address.php');
		
	if($_REQUEST['latlng']&&$_REQUEST['pinying'])
		echo Address_Lookup($_REQUEST['latlng'],$_REQUEST['pinying']);
	elseif($_REQUEST['latlng'])
		echo Address_Lookup($_REQUEST['latlng']);
	else
		echo 'error';
?>
