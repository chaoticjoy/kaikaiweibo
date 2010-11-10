<?php

	function get_user_timeline($screen_name=0,$count=10,$page=1){
		global $w;
		$user_timeline=$w->user_timeline($screen_name,$count,$page);
		
		//$emotions=$w->emotions();
		$ids=get_ids($user_timeline);
		$counts=$w->counts($ids);
		
		foreach($user_timeline as $key=>$msg){
		
		/*
			foreach($emotions as $emotion){
				if(strpos($msg['text'],$emotion['phrase'])!==false)
					if($emotion['phrase']=="image")
						$user_timeline[$key]['text']=str_replace($emotion['phrase'],"<img src=".$emotion['url'].">", $msg['text']);
					else
						$user_timeline[$key]['text']=str_replace($emotion['phrase'],$emotion['url'], $msg['text']);
			}
		*/
		
			foreach($counts as $count){			
				if($count['id']==$msg['id']){
					$user_timeline[$key]['comments_count']=$count['comments'];
					$user_timeline[$key]['rt_count']=$count['rt'];
				}				
			}
			
			$user_timeline[$key]['created_at']=formatTime($msg['created_at']);
			$user_timeline[$key]['text']=formatText($msg['text']);
			
			if($msg['retweeted_status'])
				$user_timeline[$key]['retweeted_status']['text']=formatText($msg['text']);
			 
		}

		$smarty = new Smarty;

		$smarty->compile_dir = 'saemc://smartytpl/';
		$smarty->cache_dir = 'saemc://smartytpl/';
		$smarty->compile_locking = false; // 防止调用touch,saemc会自动更新时间，不需要touch

		//$smarty->force_compile = true;
		$smarty->debugging = false;
		$smarty->caching = false;
		$smarty->cache_lifetime = 120;

		$smarty->assign("timeline",$user_timeline);
		$smarty->display('timeline.tpl');
	}
	
	if($_REQUEST['count']&&$_REQUEST['page'])
		get_user_timeline($_REQUEST['screen_name'],$_REQUEST['count'],$_REQUEST['page']);
	else
		get_user_timeline();
?>
