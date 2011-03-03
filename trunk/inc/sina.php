<?php
include_once('../lib/smarty/Smarty.class.php');
include_once('../lib/weibo.php');
include_once('config.php');
include_once('utility.php');
	
	function formatText($text) {
		$text=htmlspecialchars($text);
		
		//添加url链接
		$urlReg = '(((http|https|ftp)://){1}([[:alnum:]\-\.])+(\.)([[:alnum:]]){2,4}([[:alnum:]/+=%&_\.~?\:\-]*))';
		preg_match_all($urlReg, $text,$out);
		for($i=0;$i<count($out[0]);$i++)
			$text=str_replace($out[0][$i],"<a href='".$out[0][$i]."' target='_blank'>".$out[0][$i]."</a>", $text);

		//添加@链接
		if (!preg_match('/\w+(@\w*\.)*\w+@\w+(\.\w+)+/', $text)) {
			$matches = array();
			preg_match_all('/@([\x{4e00}-\x{9fa5}0-9A-Za-z_-]+)/u', $text, $matches);
			if (!empty($matches)) {
				for($i=0;$i<count($matches[0]);$i++)
				$text=str_replace($matches[0][$i],"<a href=\"javascript:gui.openUserInfo('','".$matches[1][$i]."','sina')\">@".$matches[1][$i]."</a>", $text);
			}
		}
		

		//添加标签链接
		$tagReg = "/#(.+?)#/";
		preg_match_all($tagReg, $text,$out);
		for($i=0;$i<count($out[0]);$i++)
			$text=str_replace($out[0][$i],"<a href='http://t.sina.com.cn/k/".$out[1][$i]."' target='_blank'>".$out[0][$i]."</a>", $text);
		return trim($text);
	}
	
	function formatTime($created_at) {
		$created_at=strtotime($created_at);
		$time=(time()-$created_at);		
		if($time<60){
			if($time==0)
				$time=1;
			$time=$time."秒前";
		}
		elseif(($time=$time/60)<=59)
			$time=ceil($time)."分钟前";
		elseif(date("Y年n月j日",$created_at)==date("Y年n月j日",time()))
			$time=date("今天 G:i",$created_at);
		elseif(date("Y",$created_at)==date("Y",time()))
			$time=date("n月j日 G:i",$created_at);
		else
			$time=date("Y-n-j G:i",$created_at);
		return $time;
	}
	
	function get_ids($timeline){
		$ids = "";
		foreach( $timeline as $id )
			$ids=$ids.$id['id'].",";
		$ids= substr($ids, 0,-1);
		return $ids;
	}
	
	function get_friends_timeline($max_id=0){
		$w = new weibo( APP_KEY );
		$w->setUser( getEncryptCookie('sina_name') , getEncryptCookie('sina_pw') );
		$friends_timeline=$w->friends_timeline($max_id);
		if($max_id)
			array_shift($friends_timeline);
		//$emotions=$w->emotions();
		if($friends_timeline){
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
				$friends_timeline[$key]['retweeted_status']['text']=formatText($msg['retweeted_status']['text']);
			 
		}
		}

		$smarty = new Smarty;

		$smarty->compile_dir = 'saemc://smartytpl/';
		$smarty->cache_dir = 'saemc://smartytpl/';
		$smarty->compile_locking = false; // 防止调用touch,saemc会自动更新时间，不需要touch

		//$smarty->force_compile = true;
		$smarty->debugging = false;
		$smarty->caching = false;
		$smarty->cache_lifetime = 120;

		$smarty->assign("friends_timeline",$friends_timeline);
		$smarty->display('friends_timeline.tpl');
	}
	
	function get_user_timeline($screen_name=0,$max_id=0){
		$w = new weibo( APP_KEY );
		$w->setUser( getEncryptCookie('sina_name') , getEncryptCookie('sina_pw') );
		$user_timeline=$w->user_timeline($screen_name,$max_id);
		if($max_id)
			array_shift($user_timeline);
		
		//$emotions=$w->emotions();
		if($user_timeline){
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
				$user_timeline[$key]['retweeted_status']['text']=formatText($msg['retweeted_status']['text']);
			 
		}
		}

		$smarty = new Smarty;

		$smarty->compile_dir = 'saemc://smartytpl/';
		$smarty->cache_dir = 'saemc://smartytpl/';
		$smarty->compile_locking = false; // 防止调用touch,saemc会自动更新时间，不需要touch

		//$smarty->force_compile = true;
		$smarty->debugging = false;
		$smarty->caching = false;
		$smarty->cache_lifetime = 120;

		$smarty->assign("user_timeline",$user_timeline);
		$smarty->display('user_timeline.tpl');
	}
	
	function get_user_info($screen_name=0){
		$w = new weibo( APP_KEY );
		$w->setUser( getEncryptCookie('sina_name') , getEncryptCookie('sina_pw') );
		if($screen_name===0){
			$screen_name=$w->verify_credentials();
			$screen_name=$screen_name['screen_name'];
		}
		$user=$w->user_info($screen_name);
		if($screen_name==$_COOKIE['sina_screen_name']){
			$is_follow=1;
		}
		else{
			$is_follow=$w->is_follow($screen_name);
			//print_r($is_follow);
			$is_follow=$is_follow['source']['following'];
		}

		$smarty = new Smarty;

		$smarty->compile_dir = 'saemc://smartytpl/';
		$smarty->cache_dir = 'saemc://smartytpl/';
		$smarty->compile_locking = false; // 防止调用touch,saemc会自动更新时间，不需要touch

		//$smarty->force_compile = true;
		$smarty->debugging = false;
		$smarty->caching = false;
		$smarty->cache_lifetime = 120;

		$smarty->assign("user",$user);
		$smarty->assign("is_follow",$is_follow);
		//$smarty->assign("emotions",$emotions[1]);

		$smarty->display('userinfo.tpl');
	}
	
	function get_followers($screen_name="",$count=20,$cursor=-1){
		$w = new weibo( APP_KEY );
		$w->setUser( getEncryptCookie('sina_name') , getEncryptCookie('sina_pw') );
		$followers=$w->followers($screen_name,$count,$cursor);
		$smarty = new Smarty;

		$smarty->compile_dir = 'saemc://smartytpl/';
		$smarty->cache_dir = 'saemc://smartytpl/';
		$smarty->compile_locking = false; // 防止调用touch,saemc会自动更新时间，不需要touch

		//$smarty->force_compile = true;
		$smarty->debugging = false;
		$smarty->caching = false;
		$smarty->cache_lifetime = 120;

		$smarty->assign("followers",$followers['users']);
		$smarty->assign("next_cursor",$followers['next_cursor']);
		$smarty->display('followers.tpl');
	}
	
	function get_friends($screen_name="",$count=20,$cursor=-1){
		$w = new weibo( APP_KEY );
		$w->setUser( getEncryptCookie('sina_name') , getEncryptCookie('sina_pw') );
		$friends=$w->friends($screen_name,$count,$cursor);
		
		$smarty = new Smarty;

		$smarty->compile_dir = 'saemc://smartytpl/';
		$smarty->cache_dir = 'saemc://smartytpl/';
		$smarty->compile_locking = false; // 防止调用touch,saemc会自动更新时间，不需要touch

		//$smarty->force_compile = true;
		$smarty->debugging = false;
		$smarty->caching = false;
		$smarty->cache_lifetime = 120;

		$smarty->assign("friends",$friends['users']);
		$smarty->assign("next_cursor",$friends['next_cursor']);
		$smarty->display('friends.tpl');
	}
	
	function get_comments_list($id=0,$count=20,$page=1){
		$w = new weibo( APP_KEY );
		$w->setUser( getEncryptCookie('sina_name') , getEncryptCookie('sina_pw') );
		$comments_list=$w->comments($id,$count,$page);
		
		//$emotions=$w->emotions();
		if($comments_list)
		foreach($comments_list as $key=>$msg){
		
		/*
			foreach($emotions as $emotion){
				if(strpos($msg['text'],$emotion['phrase'])!==false)
					if($emotion['phrase']=="image")
						$comments_list[$key]['text']=str_replace($emotion['phrase'],"<img src=".$emotion['url'].">", $msg['text']);
					else
						$comments_list[$key]['text']=str_replace($emotion['phrase'],$emotion['url'], $msg['text']);
			}
		*/
			
			$comments_list[$key]['created_at']=formatTime($msg['created_at']);
			$comments_list[$key]['text']=formatText($msg['text']);
			 
		}

		$smarty = new Smarty;

		$smarty->compile_dir = 'saemc://smartytpl/';
		$smarty->cache_dir = 'saemc://smartytpl/';
		$smarty->compile_locking = false; // 防止调用touch,saemc会自动更新时间，不需要touch

		//$smarty->force_compile = true;
		$smarty->debugging = false;
		$smarty->caching = false;
		$smarty->cache_lifetime = 120;

		$smarty->assign("comments_list",$comments_list);
		$smarty->assign("id",$id);
		$smarty->assign("cpage",$page);//当前页
		
		if(count($comments_list)<$count)
			$smarty->assign("hasMore",false);
		else $smarty->assign("hasMore",true);
		
		$smarty->display('comments_list.tpl');
	}

	function get_mentions($max_id=0){
		$w = new weibo( APP_KEY );
		$w->setUser( getEncryptCookie('sina_name') , getEncryptCookie('sina_pw') );
		$mentions=$w->mentions($max_id);
		if($max_id)
			array_shift($mentions);
		
		//$emotions=$w->emotions();
		if($mentions){
		$ids=get_ids($mentions);
		$counts=$w->counts($ids);
		
		foreach($mentions as $key=>$msg){
		
			foreach($counts as $count){			
				if($count['id']==$msg['id']){
					$mentions[$key]['comments_count']=$count['comments'];
					$mentions[$key]['rt_count']=$count['rt'];
				}				
			}
			
			$mentions[$key]['created_at']=formatTime($msg['created_at']);
			$mentions[$key]['text']=formatText($msg['text']);
			
			if($msg['retweeted_status'])
				$mentions[$key]['retweeted_status']['text']=formatText($msg['retweeted_status']['text']);
			 
		}
		}

		$smarty = new Smarty;

		$smarty->compile_dir = 'saemc://smartytpl/';
		$smarty->cache_dir = 'saemc://smartytpl/';
		$smarty->compile_locking = false; // 防止调用touch,saemc会自动更新时间，不需要touch

		//$smarty->force_compile = true;
		$smarty->debugging = false;
		$smarty->caching = false;
		$smarty->cache_lifetime = 120;

		$smarty->assign("mentions",$mentions);
		$smarty->display('mentions.tpl');
	}

	function get_direct_messages($max_id=0){
		$w = new weibo( APP_KEY );
		$w->setUser( getEncryptCookie('sina_name') , getEncryptCookie('sina_pw') );
		$direct_messages=$w->direct_messages($max_id);
		if($max_id)
			array_shift($direct_messages);
		
		if($direct_messages){
		foreach($direct_messages as $key=>$msg){
			
			$direct_messages[$key]['created_at']=formatTime($msg['created_at']);
			$direct_messages[$key]['text']=formatText($msg['text']);
			 
		}
		}

		$smarty = new Smarty;

		$smarty->compile_dir = 'saemc://smartytpl/';
		$smarty->cache_dir = 'saemc://smartytpl/';
		$smarty->compile_locking = false; // 防止调用touch,saemc会自动更新时间，不需要touch

		//$smarty->force_compile = true;
		$smarty->debugging = false;
		$smarty->caching = false;
		$smarty->cache_lifetime = 120;

		$smarty->assign("direct_messages",$direct_messages);
		$smarty->display('direct_messages.tpl');
	}

	function get_comments_timeline($page=1){
		$w = new weibo( APP_KEY );
		$w->setUser( getEncryptCookie('sina_name') , getEncryptCookie('sina_pw') );
		$comments_timeline=$w->comments_timeline($page);
		
		if($comments_timeline){
		foreach($comments_timeline as $key=>$msg){
			
			$comments_timeline[$key]['created_at']=formatTime($msg['created_at']);
			$comments_timeline[$key]['text']=formatText($msg['text']);
			$comments_timeline[$key]['status']['text']=formatText($msg['status']['text']);
			 
		}
		}

		$smarty = new Smarty;

		$smarty->compile_dir = 'saemc://smartytpl/';
		$smarty->cache_dir = 'saemc://smartytpl/';
		$smarty->compile_locking = false; // 防止调用touch,saemc会自动更新时间，不需要touch

		//$smarty->force_compile = true;
		$smarty->debugging = false;
		$smarty->caching = false;
		$smarty->cache_lifetime = 120;

		$smarty->assign("comments_timeline",$comments_timeline);
		$smarty->display('comments_timeline.tpl');
	}
	
	function get_comments_to_me($page=1){
		$w = new weibo( APP_KEY );
		$w->setUser( getEncryptCookie('sina_name') , getEncryptCookie('sina_pw') );
		$comments_timeline=$w->comments_to_me($page);
		
		if($comments_timeline){
		foreach($comments_timeline as $key=>$msg){
			
			$comments_timeline[$key]['created_at']=formatTime($msg['created_at']);
			$comments_timeline[$key]['text']=formatText($msg['text']);
			$comments_timeline[$key]['status']['text']=formatText($msg['status']['text']);
			 
		}
		}

		$smarty = new Smarty;

		$smarty->compile_dir = 'saemc://smartytpl/';
		$smarty->cache_dir = 'saemc://smartytpl/';
		$smarty->compile_locking = false; // 防止调用touch,saemc会自动更新时间，不需要touch

		//$smarty->force_compile = true;
		$smarty->debugging = false;
		$smarty->caching = false;
		$smarty->cache_lifetime = 120;

		$smarty->assign("comments_timeline",$comments_timeline);
		$smarty->assign("me",$_COOKIE['sina_screen_name']);
		$smarty->display('comments_timeline.tpl');
	}

	function get_favorites($page=1){
		$w = new weibo( APP_KEY );
		$w->setUser( getEncryptCookie('sina_name') , getEncryptCookie('sina_pw') );
		$favorites=$w->get_favorites($page);
		//print_r($favorites);
		
		if($favorites){
		$ids=get_ids($favorites);
		$counts=$w->counts($ids);
		
		foreach($favorites as $key=>$msg){
			
			foreach($counts as $count){			
				if($count['id']==$msg['id']){
					$favorites[$key]['comments_count']=$count['comments'];
					$favorites[$key]['rt_count']=$count['rt'];
				}				
			}
			
			$favorites[$key]['created_at']=formatTime($msg['created_at']);
			$favorites[$key]['text']=formatText($msg['text']);
			
			if($msg['retweeted_status'])
				$favorites[$key]['retweeted_status']['text']=formatText($msg['retweeted_status']['text']);
			 
		}
		}

		$smarty = new Smarty;

		$smarty->compile_dir = 'saemc://smartytpl/';
		$smarty->cache_dir = 'saemc://smartytpl/';
		$smarty->compile_locking = false; // 防止调用touch,saemc会自动更新时间，不需要touch

		//$smarty->force_compile = true;
		$smarty->debugging = false;
		$smarty->caching = false;
		$smarty->cache_lifetime = 120;

		$smarty->assign("favorites",$favorites);
		$smarty->display('favorites.tpl');
	}	
?>