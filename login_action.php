<?php

include_once('inc/config.php');
include_once('lib/weibo.php');
include_once('inc/utility.php');
include_once('inc/sina.php');	

	
	if ( isset($_POST['username']) && isset($_POST['password']) ) {
		
			$remember = isset($_POST['remember']) ? true : false;
			$result = verify($_POST['username'], $_POST['password'], $remember);
			
			if ($result ) {
				//echo "<p>��½�ɹ�</p>";
				header('location: index.php');
			}
			else{
				echo "<p>��½ʧ�ܣ�������</p>";
			}
			
	} 
	else {
		echo "<p>�Ƿ������뷵��</p>";
	}
?>