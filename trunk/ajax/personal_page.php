<?php
	include_once('../lib/smarty/Smarty.class.php');
	include_once('../lib/weibo.php');
	include_once('../lib/kaikai.php'); 
	include_once('../inc/config.php');
	include_once('../inc/utility.php');
		
	function get_personal_page(){
		$w = new weibo( APP_KEY );
		$w->setUser( getEncryptCookie('sina_name') , getEncryptCookie('sina_pw') );
		$sina_user_info=$w->verify_credentials();
		//$screen_name=$sina_user_info['screen_name'];
		print_r($sina_user_info);
		if(!(getEncryptCookie('kk_name') && getEncryptCookie('kk_pw'))){
			$kk_user_info="";
		}
		else{
			$k = new kaikai( KAIKAI_KEY );
			$k->setUser( getEncryptCookie('kk_name') , getEncryptCookie('kk_pw') );
			$kk_user_info=$k->user_info();
			print_r($kk_user_info);
		}
		
		$smarty = new Smarty;

		$smarty->compile_dir = 'saemc://smartytpl/';
		$smarty->cache_dir = 'saemc://smartytpl/';
		$smarty->compile_locking = false; // 防止调用touch,saemc会自动更新时间，不需要touch

		//$smarty->force_compile = true;
		$smarty->debugging = false;
		$smarty->caching = false;
		$smarty->cache_lifetime = 120;

		$smarty->assign("sina_user_info",$sina_user_info);
		$smarty->assign("kk_user_info",$kk_user_info);

		$smarty->display('personal_page.tpl');
	}
	get_personal_page();

?>
