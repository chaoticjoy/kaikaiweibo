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
				echo "<script language=\"javascript\">location.href='index.php';</script>";
			}
			else{
				echo "<script language=\"javascript\">alert('��½ʧ�ܣ������µ�¼��');</script>";
				echo "<script language=\"javascript\">location.href='login.php';</script>";
			}
			
	} 
	else {
		//echo "<p>�Ƿ������뷵��</p>";
		echo "<script language=\"javascript\">alert('�Ƿ�����!');</script>";
		echo "<script language=\"javascript\">location.href='index.php';</script>";
	}
?>