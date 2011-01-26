<?php
	include_once('../lib/address.php');
		
	if($_REQUEST['latlng'])
		echo Address_Lookup($_REQUEST['latlng']);
	else($_REQUEST['latlng']&&$_REQUEST['pinying'])
		echo Address_Lookup($_REQUEST['latlng'],$_REQUEST['pinying']);
?>
