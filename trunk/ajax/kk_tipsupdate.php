<?php

include_once('../lib/kaikai.php');
include_once('../inc/config.php');
include_once('../inc/utility.php');
	$k = new kaikai( KAIKAI_KEY );
	$k->setUser( getEncryptCookie('kk_name') , getEncryptCookie('kk_pw') );
	$k->tipsupdate($_REQUEST['id'],$_REQUEST['text']);

?>
