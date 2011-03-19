<?php
	include_once('inc/utility.php');
	delCookie('sina_name');
	delCookie('sina_pw');
	delCookie('sina_screen_name');
	delCookie('sina_id');
	delCookie('kk_name');
	delCookie('kk_pw');
	delCookie('kk_screen_name');
	delCookie('kk_id');
?>
<!DOCTYPE html> 
<html> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="apple-mobile-web-app-capable" content="yes" /> 
<meta name="apple-mobile-web-app-status-bar-style" content="black" />  
<meta name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/> 
<link href="image/favicon.ico" rel="shortcut icon" type="image/x-icon"> 
<link rel="stylesheet" href="css/main.css" type="text/css">
<script src="js/jquery/jquery-1.4.2.js"></script>
<script src="js/ajax/index.js"></script>
<title>团团</title> 
</head>
<body>
<div id="header">团团 beta</div>
<div id="wrapper"> 

	<h1 id="intro">开始分享你的大城小事</h1>
	<form onsubmit="return onSubmit()" class="loginform" method="post" action="login_action.php"> 
		<p>
		<label class="username-label" for="username">帐号</label>
		<input type="text" tabindex="1" autocapitalize="off" autocorrect="off" class="main-field" id="username" name="username">
		</p>
	  	<p>
		<label class="password-label" for="password">密码</label>
		<input type="password" tabindex="2" autocapitalize="off" autocorrect="off" class="main-field" id="password" name="password">
		</p>
		<input type="checkbox" class="main-checkbox" name="remember" checked="true"/><label class="checkbox-label" for="checkbox">保存密码</label>
		<input type="checkbox" class="main-checkbox" name="follow" /><label class="checkbox-label" for="checkbox">关注 @团团官方</label>
		<input type="submit"  class="main-button" value="登陆新浪微博" readonly/>
	</form>
	<p id="meta">请用Firefox、Chrome浏览器，或使用智能手机访问 | <a href="http://kaikai.sinaapp.com/apk/TuanTuan.apk" target="_blank">下载Android版团团</a></p>

</div> 
<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fb2bf01d6c3c46625530024bc7b3907a5' type='text/javascript'%3E%3C/script%3E"));
</script>
</body>
</html>