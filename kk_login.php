<!DOCTYPE html> 
<html> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="apple-mobile-web-app-capable" content="yes" /> 
<meta name="apple-mobile-web-app-status-bar-style" content="black" />  
<meta name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/> 
<link rel="stylesheet" href="css/main.css" type="text/css">
<script src="js/jquery/jquery-1.4.2.js"></script>
<script src="js/ajax/index.js"></script>
<title>开开围脖</title> 
</head>
<body>
<div id="header"></div>

<div id="wrapper"> 


	<form  onsubmit="return onSubmit()" class="loginform" method="post" action="kk_login_action.php"> 
		<p>
		<label class="username-label" for="username">帐号</label>
		<input type="text" tabindex="1" autocapitalize="off" autocorrect="off" class="main-field" id="username" name="username">
		</p>
	  	<p>
		<label class="password-label" for="password">密码</label>
		<input type="password" tabindex="2" autocapitalize="off" autocorrect="off" class="main-field" id="password" name="password">
		</p>
		<input type="checkbox" class="main-checkbox" name="remember"/><label class="checkbox-label" for="checkbox">保存密码</label>
		<input type="submit"  class="main-button" value="登陆开开" readonly/>
	</form>

</div> 

</body>
</html>