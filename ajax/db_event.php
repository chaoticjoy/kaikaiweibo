<?php
	include_once('../lib/douban.php');
	include_once('../lib/smarty/Smarty.class.php');
	
	function db_format_time($time){
		$time=strtotime($time);
		$week=array('周日','周一','周二','周三','周四','周五','周六');
		$w=date('w',$time);
		$date=date('Y年n月j日',$time);
		$date.=' '.$week[$w];
		$date.=' '.date('G:i',$time);
		return $date;
	}
	
	function get_db_event($location='beijing',$start_index=1,$max_results=5){
		$douban=douban_event($location,$start_index,$max_results);
		//print_r($douban);
		if(!$douban)
			return 0;
		foreach($douban['entry'] as $key=>$item){
			$douban['entry'][$key]['when']['@attributes']['startTime']=db_format_time($item['when']['@attributes']['startTime']);
			$douban['entry'][$key]['when']['@attributes']['endTime']=db_format_time($item['when']['@attributes']['endTime']);
		}
		$smarty = new Smarty;

		$smarty->compile_dir = 'saemc://smartytpl/';
		$smarty->cache_dir = 'saemc://smartytpl/';
		$smarty->compile_locking = false; // 防止调用touch,saemc会自动更新时间，不需要touch

		//$smarty->force_compile = true;
		$smarty->debugging = false;
		$smarty->caching = false;
		$smarty->cache_lifetime = 120;

		$smarty->assign("db_event",$douban['entry']);
		//$smarty->assign("db_event_title",$douban['title']);
		$smarty->display('douban.tpl');
	}
	
	if($_REQUEST['city']&&$_REQUEST['page'])
		get_db_event($_REQUEST['city'],5*($_REQUEST['page']-1)+1);
	elseif($_REQUEST['city'])
		get_db_event($_REQUEST['city']);
/* 	else
		get_db_event(); */

?>
