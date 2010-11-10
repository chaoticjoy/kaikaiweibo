<?php

	function get_user_info($screen_name){
		global $w;
		$user=$w->user_info($screen_name);

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

		$smarty->display('userinfo.tpl');
	}
	
	if($_REQUEST['screen_name'])
		get_user_info($_REQUEST['screen_name']);
	else{
		$user=$w->verify_credentials();
		get_user_info($user['screen_name']);	
	}



?>
