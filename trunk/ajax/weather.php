<?php
	include_once('../lib/weather.php');
	include_once('../lib/smarty/Smarty.class.php');
	
	function get_weather($city='北京'){
		$weather=gg_weather($city);
		//print_r($weather['weather']);
		//return 0;
		$smarty = new Smarty;

		$smarty->compile_dir = 'saemc://smartytpl/';
		$smarty->cache_dir = 'saemc://smartytpl/';
		$smarty->compile_locking = false; // 防止调用touch,saemc会自动更新时间，不需要touch

		//$smarty->force_compile = true;
		$smarty->debugging = false;
		$smarty->caching = false;
		$smarty->cache_lifetime = 120;

		$smarty->assign("weather",$weather['weather']);
		$smarty->display('weather.tpl');
	}
	
	if($_REQUEST['city'])
		get_weather($_REQUEST['city']);
	else
		get_weather();

?>
