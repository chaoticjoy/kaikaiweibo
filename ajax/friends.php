<?php

	function get_friends($screen_name=0,$count=10,$page=1){
		global $w;
		$friends=$w->friends($screen_name,$count,$page);
		
		$smarty = new Smarty;

		$smarty->compile_dir = 'saemc://smartytpl/';
		$smarty->cache_dir = 'saemc://smartytpl/';
		$smarty->compile_locking = false; // ��ֹ����touch,saemc���Զ�����ʱ�䣬����Ҫtouch

		//$smarty->force_compile = true;
		$smarty->debugging = false;
		$smarty->caching = false;
		$smarty->cache_lifetime = 120;

		$smarty->assign("users",$friends);
		$smarty->display('user.tpl');
	}
	
	if($_REQUEST['count']&&$_REQUEST['page'])
		get_friends($_REQUEST['screen_name'],$_REQUEST['count'],$_REQUEST['page']);
	else
		get_friends();
?>
