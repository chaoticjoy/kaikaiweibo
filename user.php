<?php

//sae_set_display_errors(true);
include_once('lib/smarty/Smarty.class.php');
include_once('lib/weibo.php');
include_once('inc/config.php');
include_once('inc/utility.php');
include_once('inc/sina.php');

if(!(getEncryptCookie('sina_name') && getEncryptCookie('sina_pw')))
header('location: login.php');

$w = new weibo( APP_KEY );
$w->setUser( getEncryptCookie('sina_name') , getEncryptCookie('sina_pw') );

$user=$w->user_info($_REQUEST['username']);

$smarty = new Smarty;

$smarty->compile_dir = 'saemc://smartytpl/';
$smarty->cache_dir = 'saemc://smartytpl/';
$smarty->compile_locking = false; // 防止调用touch,saemc会自动更新时间，不需要touch

//$smarty->force_compile = true;
$smarty->debugging = false;
$smarty->caching = false;
$smarty->cache_lifetime = 120;

$smarty->assign("user",$user);
//$smarty->assign("emotions",$emotions[1]);

$smarty->display('user.tpl');

?>
