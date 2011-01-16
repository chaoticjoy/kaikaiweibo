<?php
	include_once('../lib/tuan.php');
	include_once('../lib/smarty/Smarty.class.php');
	
	function get_tuan($city='全国'){
		$cityid=tuan_get_cityid($city);
		$tuan=tuan_city($cityid);
		
		//print_r($tuan);
		
		$smarty = new Smarty;

		$smarty->compile_dir = 'saemc://smartytpl/';
		$smarty->cache_dir = 'saemc://smartytpl/';
		$smarty->compile_locking = false; // 防止调用touch,saemc会自动更新时间，不需要touch

		//$smarty->force_compile = true;
		$smarty->debugging = false;
		$smarty->caching = false;
		$smarty->cache_lifetime = 120;

		$smarty->assign("tuan",$tuan);
		$smarty->display('tuan.tpl');
	}
	
	if($_REQUEST['city'])
		get_tuan($_REQUEST['city']);
	else
		get_tuan("全国");

?>
