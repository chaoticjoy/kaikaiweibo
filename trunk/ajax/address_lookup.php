<?php
	include_once('../lib/address.php');
		
	if($_REQUEST['latlng']&&$_REQUEST['pinying'])
		echo Address_Lookup($_REQUEST['latlng'],$_REQUEST['pinying']);
	else
		echo Address_Lookup($_REQUEST['latlng']);
?>
