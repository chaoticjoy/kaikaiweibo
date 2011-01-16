<?php
	include_once('../lib/tuan.php');
	include_once('../lib/smarty/Smarty.class.php');
	
	function get_tuan($location='beijing'){
		$tuan=tuan();
		print_r($tuan);
		//return 0;
		$smarty = new Smarty;

		$smarty->compile_dir = 'saemc://smartytpl/';
		$smarty->cache_dir = 'saemc://smartytpl/';
		$smarty->compile_locking = false; // 防止调用touch,saemc会自动更新时间，不需要touch

		//$smarty->force_compile = true;
		$smarty->debugging = false;
		$smarty->caching = false;
		$smarty->cache_lifetime = 120;

		$smarty->assign("tuan",$tuan['url']);
		//$smarty->assign("db_event_title",$douban['title']);
		$smarty->display('tuan.tpl');
	}
	
	if($_REQUEST['location'])
		get_tuan($_REQUEST['location']);
	else
		get_tuan();

?>
