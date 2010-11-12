<?php
include_once('../lib/smarty/Smarty.class.php');
include_once('../lib/weibo.php');
include_once('config.php');
include_once('utility.php');
	
	function formatText($text) {
		//如果开启了魔术引号\" \' 转回来
		/*if (get_magic_quotes_gpc()) {
			$text = stripslashes($text);
		}*/
		$text=$text." ";
		
		//添加url链接
		$urlReg = '(((http|https|ftp)://){1}([[:alnum:]\-\.])+(\.)([[:alnum:]]){2,4}([[:alnum:]/+=%&_\.~?\:\-]*))';
		//$text = eregi_replace($urlReg, '<a href="\1" target="_blank">\1</a>', $text);
		preg_match_all($urlReg, $text,$out);
		for($i=0;$i<count($out[0]);$i++)
			$text=str_replace($out[0][$i],"<a href='".$out[0][$i]."' target='_blank'>".$out[0][$i]."</a>", $text);

		//添加@链接
		//$atReg = '@{1}(([a-zA-Z0-9\_\.\-])+)';
		//$text = eregi_replace($atReg,  '<a href="user.php?id=\1" target="_blank">\0</a>', $text);
		$atReg ='/@(.+?)([: ])/';
		//$atReg ='/@(\w+)/';
		preg_match_all($atReg, $text,$out);
		for($i=0;$i<count($out[0]);$i++)
			$text=str_replace($out[0][$i],"<a href='user.php?username=".$out[1][$i]."' target='_blank'>@".$out[1][$i]."</a>".$out[2][$i], $text);
		

		//添加标签链接
		//$tagReg = "/(\#{1}([\S]{1,10}))([\s]*)/u";
		//$text = preg_replace($tagReg, '<a href="search.php?q=\2">\1</a>', $text);
		$tagReg = "/#(.+?)#/";
		preg_match_all($tagReg, $text,$out);
		for($i=0;$i<count($out[0]);$i++)
			$text=str_replace($out[0][$i],"<a href='http://t.sina.com.cn/k/".$out[1][$i]."' target='_blank'>".$out[0][$i]."</a>", $text);
		return trim($text);
	}
	
	function formatTime($created_at) {
		$created_at=strtotime($created_at);
		$time=(time()-$created_at)/60;		
		if($time<=60)
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

		$smarty->assign("user_timeline",$user_timeline);
		$smarty->display('user_timeline.tpl');
	}
	
	function get_user_info($screen_name=0){
		$w = new weibo( APP_KEY );
		$w->setUser( getEncryptCookie('sina_name') , getEncryptCookie('sina_pw') );
		if($screen_name==0){
			$screen_name=$w->verify_credentials();
			$screen_name=$screen_name['screen_name'];
		}
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
	
	function get_followers($screen_name=0,$count=10,$page=1){
		$w = new weibo( APP_KEY );
		$w->setUser( getEncryptCookie('sina_name') , getEncryptCookie('sina_pw') );
		$followers=$w->followers($screen_name,$count,$page);
		
		$smarty = new Smarty;

		$smarty->compile_dir = 'saemc://smartytpl/';
		$smarty->cache_dir = 'saemc://smartytpl/';
		$smarty->compile_locking = false; // 防止调用touch,saemc会自动更新时间，不需要touch

		//$smarty->force_compile = true;
		$smarty->debugging = false;
		$smarty->caching = false;
		$smarty->cache_lifetime = 120;

		$smarty->assign("users",$followers);
		$smarty->display('user.tpl');
	}
	
	function get_friends($screen_name=0,$count=10,$page=1){
		$w = new weibo( APP_KEY );
		$w->setUser( getEncryptCookie('sina_name') , getEncryptCookie('sina_pw') );
		$friends=$w->friends($screen_name,$count,$page);
		
		$smarty = new Smarty;

		$smarty->compile_dir = 'saemc://smartytpl/';
		$smarty->cache_dir = 'saemc://smartytpl/';
		$smarty->compile_locking = false; // 防止调用touch,saemc会自动更新时间，不需要touch

		//$smarty->force_compile = true;
		$smarty->debugging = false;
		$smarty->caching = false;
		$smarty->cache_lifetime = 120;

		$smarty->assign("users",$friends);
		$smarty->display('user.tpl');
	}
?>