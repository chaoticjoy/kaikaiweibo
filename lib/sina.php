<?php

	function verify($username, $password, $remember) {
	
		$w = new weibo( APP_KEY );
		$w->setUser( $username, $password );
		$user=$w->verify_credentials();
		//print_r($user);
		if ($user[1]['screen_name']) {
			$time = $remember ? time()+3600*24*365 : 0;
			setEncryptCookie('sina_name', $username, $time, '/');
			setEncryptCookie('sina_pw', $password, $time, '/');
			return 1;
		} else {
			return 0;
		}
	}
	
	function formatText($text) {
		//如果开启了魔术引号\" \' 转回来
		/*if (get_magic_quotes_gpc()) {
			$text = stripslashes($text);
		}*/

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
		$tagReg = "/(\#{1}([\S]{1,10}))([\s]*)/u";
		//$text = preg_replace($tagReg, '<a href="search.php?q=\2">\1</a>', $text);
		return $text;
	}
?>