<?php
include_once('../lib/smarty/Smarty.class.php');
include_once('../lib/kaikai.php');
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
				$text=str_replace($matches[0][$i],"<a >@".$matches[1][$i]."</a>", $text);
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
	
	function is_login_kk(){
		if(!(getEncryptCookie('kk_name') && getEncryptCookie('kk_pw'))){
			echo "Not login kaikai!";
			return 1;
		}
		return 0;
	}
	
	function get_friends_timeline($page=1){
		if(is_login_kk()){
			return 0;
		}
		$k = new kaikai( KAIKAI_KEY );
		$k->setUser( getEncryptCookie('kk_name') , getEncryptCookie('kk_pw') );
		$friends_timeline=$k->friends_timeline($page);

		$friends_timeline=$friends_timeline['statuses'];
		//print_r($friends_timeline);
		/* $ids=get_ids($friends_timeline);
		$counts=$k->counts($ids); */
		
		//$friends_timeline=array();
		if($friends_timeline)
		foreach($friends_timeline as $key1=>$item)
		foreach($item as $key=>$msg)
		{
			//print_r($msg);
			/* foreach($counts as $count){			
				if($count['id']==$msg['id']){
					$friends_timeline[$key]['comments_count']=$count['comments'];
					$friends_timeline[$key]['rt_count']=$count['rt'];
				}				
			} */
			
			//echo $friends_timeline[$key1][$key]['created_at'];
			/* print_r($friends_timeline[$key1][$key]['text']);
			return 0; */
			
			
			$friends_timeline[$key1][$key]['create_at']=formatTime($msg['create_at']);
			$friends_timeline[$key1][$key]['text']=formatText($msg['text']);
			
			if($msg['in_reply_to_status'])
				$friends_timeline[$key1][$key]['in_reply_to_status']['text']=formatText($msg['in_reply_to_status']['text']);
			 
		}
//print_r($friends_timeline);
		$smarty = new Smarty;

		$smarty->compile_dir = 'saemc://smartytpl/';
		$smarty->cache_dir = 'saemc://smartytpl/';
		$smarty->compile_locking = false; // 防止调用touch,saemc会自动更新时间，不需要touch

		//$smarty->force_compile = true;
		$smarty->debugging = false;
		$smarty->caching = false;
		$smarty->cache_lifetime = 120;

		$smarty->assign("friends_timeline",$friends_timeline);
		$smarty->display('kk_friends_timeline.tpl');
	}
	
	function get_user_timeline($username,$page=1){
		if(is_login_kk()){
			return 0;
		}
		$k = new kaikai( KAIKAI_KEY );
		$k->setUser( getEncryptCookie('kk_name') , getEncryptCookie('kk_pw') );
		$user_timeline=$k->user_timeline($username,$page);
		//print_r($user_timeline);
		$user_timeline=$user_timeline['statuses'];
/* 		//$emotions=$w->emotions();
		$ids=get_ids($user_timeline);
		$counts=$w->counts($ids); */
		if($user_timeline)
		foreach($user_timeline as $key1=>$item)
		foreach($item as $key=>$msg)
		{
		
		/*
			foreach($emotions as $emotion){
				if(strpos($msg['text'],$emotion['phrase'])!==false)
					if($emotion['phrase']=="image")
						$user_timeline[$key]['text']=str_replace($emotion['phrase'],"<img src=".$emotion['url'].">", $msg['text']);
					else
						$user_timeline[$key]['text']=str_replace($emotion['phrase'],$emotion['url'], $msg['text']);
			}
		*/
		
			/* foreach($counts as $count){			
				if($count['id']==$msg['id']){
					$user_timeline[$key]['comments_count']=$count['comments'];
					$user_timeline[$key]['rt_count']=$count['rt'];
				}				
			} */
			
			$user_timeline[$key1][$key]['create_at']=formatTime($msg['create_at']);
			$user_timeline[$key1][$key]['text']=formatText($msg['text']);
			
			if($msg['in_reply_to_status'])
				$user_timeline[$key1][$key]['in_reply_to_status']['text']=formatText($msg['in_reply_to_status']['text']);
			 
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
		$smarty->display('kk_user_timeline.tpl');
	}
	
	function get_user_info($id=0){
		if(is_login_kk()){
			return 0;
		}
		$k = new kaikai( KAIKAI_KEY );
		$k->setUser( getEncryptCookie('kk_name') , getEncryptCookie('kk_pw') );
		$user=$k->user_info($id);

		
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

		$smarty->display('kk_userinfo.tpl');
	}
	
	function get_followers($id,$page=1,$count=20){
		if(is_login_kk()){
			return 0;
		}
		$k = new kaikai( KAIKAI_KEY );
		$k->setUser( getEncryptCookie('kk_name') , getEncryptCookie('kk_pw') );
		$followers=$k->followers($id,$page,$count);
		$smarty = new Smarty;

		$smarty->compile_dir = 'saemc://smartytpl/';
		$smarty->cache_dir = 'saemc://smartytpl/';
		$smarty->compile_locking = false; // 防止调用touch,saemc会自动更新时间，不需要touch

		//$smarty->force_compile = true;
		$smarty->debugging = false;
		$smarty->caching = false;
		$smarty->cache_lifetime = 120;

		$smarty->assign("followers",$followers['users']);
		$smarty->display('kk_followers.tpl');
	}
	
	function get_friends($id,$page=1,$count=20){
		if(is_login_kk()){
			return 0;
		}
		$k = new kaikai( KAIKAI_KEY );
		$k->setUser( getEncryptCookie('kk_name') , getEncryptCookie('kk_pw') );
		$friends=$k->friends($id,$page,$count);
		//$friends=$friends['users'];
		//print_r($friends['users']);
		$smarty = new Smarty;

		$smarty->compile_dir = 'saemc://smartytpl/';
		$smarty->cache_dir = 'saemc://smartytpl/';
		$smarty->compile_locking = false; // 防止调用touch,saemc会自动更新时间，不需要touch

		//$smarty->force_compile = true;
		$smarty->debugging = false;
		$smarty->caching = false;
		$smarty->cache_lifetime = 120;

		$smarty->assign("friends",$friends['users']);
		$smarty->display('kk_friends.tpl');
	}
	
	function get_search($lat,$lon,$query='',$page=1){
		if(is_login_kk()){
			return 0;
		}
		$k = new kaikai( KAIKAI_KEY );
		$k->setUser( getEncryptCookie('kk_name') , getEncryptCookie('kk_pw') );
		$search=$k->search($lat,$lon,$query,$page);

		$smarty = new Smarty;

		$smarty->compile_dir = 'saemc://smartytpl/';
		$smarty->cache_dir = 'saemc://smartytpl/';
		$smarty->compile_locking = false; // 防止调用touch,saemc会自动更新时间，不需要touch

		//$smarty->force_compile = true;
		$smarty->debugging = false;
		$smarty->caching = false;
		$smarty->cache_lifetime = 120;

		$smarty->assign("search",$search['pois']);
		$smarty->display('kk_search.tpl');
	}
	
	function get_tips($poi_id,$page=1){
		if(is_login_kk()){
			return 0;
		}
		$k = new kaikai( KAIKAI_KEY );
		$k->setUser( getEncryptCookie('kk_name') , getEncryptCookie('kk_pw') );
		$tips=$k->tips($poi_id,$page);
		
		//print_r($tips['tips']);
		//return 0;

		$smarty = new Smarty;

		$smarty->compile_dir = 'saemc://smartytpl/';
		$smarty->cache_dir = 'saemc://smartytpl/';
		$smarty->compile_locking = false; // 防止调用touch,saemc会自动更新时间，不需要touch

		//$smarty->force_compile = true;
		$smarty->debugging = false;
		$smarty->caching = false;
		$smarty->cache_lifetime = 120;

		$smarty->assign("tips",$tips['tips']);
		$smarty->display('kk_tips.tpl');
	}
	
	function get_user_timeline2($page=1,$id=''){
		if(is_login_kk()){
			return 0;
		}
		$k = new kaikai( KAIKAI_KEY );
		$k->setUser( getEncryptCookie('kk_name') , getEncryptCookie('kk_pw') );
		$user_timeline=$k->user_timeline2($page,$id);
		//print_r($user_timeline);
		$user_timeline=$user_timeline['statuses'];
		

		if($user_timeline)
		foreach($user_timeline as $key1=>$item)
		foreach($item as $key=>$msg)
		{
			
			$user_timeline[$key1][$key]['create_at']=formatTime($msg['create_at']);
			$user_timeline[$key1][$key]['text']=formatText($msg['text']);
			 
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
		$smarty->display('kk_user_timeline2.tpl');
	}
?>