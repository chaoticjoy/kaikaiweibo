<?php

	function get_friends_timeline($count=10,$page=1){
		global $w;
		$friends_timeline=$w->friends_timeline($count,$page);
		
		//$emotions=$w->emotions();
		$ids=get_ids($friends_timeline);
		$counts=$w->counts($ids);
		
		foreach($friends_timeline as $key=>$msg){
		
		/*
			foreach($emotions as $emotion){
				if(strpos($msg['text'],$emotion['phrase'])!==false)
					if($emotion['phrase']=="image")
						$friends_timeline[$key]['text']=str_replace($emotion['phrase'],"<img src=".$emotion['url'].">", $msg['text']);
					else
						$friends_timeline[$key]['text']=str_replace($emotion['phrase'],$emotion['url'], $msg['text']);
			}
		*/
		
			foreach($counts as $count){			
				if($count['id']==$msg['id']){
					$friends_timeline[$key]['comments_count']=$count['comments'];
					$friends_timeline[$key]['rt_count']=$count['rt'];
				}				
			}
			
			$friends_timeline[$key]['created_at']=formatTime($msg['created_at']);
			$friends_timeline[$key]['text']=formatText($msg['text']);
			
			if($msg['retweeted_status'])
				$friends_timeline[$key]['retweeted_status']['text']=formatText($msg['text']);
			 
		}

		$smarty = new Smarty;

		$smarty->compile_dir = 'saemc://smartytpl/';
		$smarty->cache_dir = 'saemc://smartytpl/';
		$smarty->compile_locking = false; // 防止调用touch,saemc会自动更新时间，不需要touch

		//$smarty->force_compile = true;
		$smarty->debugging = false;
		$smarty->caching = false;
		$smarty->cache_lifetime = 120;

		$smarty->assign("timeline",$friends_timeline);
		$smarty->display('timeline.tpl');
	}
	
	if($_REQUEST['count']&&$_REQUEST['page'])
		get_friends_timeline($_REQUEST['count'],$_REQUEST['page']);
	else
		get_friends_timeline();
?>
