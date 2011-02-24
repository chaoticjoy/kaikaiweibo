<?php
sae_xhprof_start();
//sae_set_display_errors(true);
include_once('inc/config.php');
include_once('inc/utility.php');

if(!(getEncryptCookie('sina_name') && getEncryptCookie('sina_pw')))
//header('location: login.php');
echo "<script language=\"javascript\">location.href='login.php';</script>";
/* if(!(getEncryptCookie('kk_name') && getEncryptCookie('kk_pw')))
echo "<script language=\"javascript\">location.href='kk_login.php';</script>"; */

?>	
<!DOCTYPE html> 
<html> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="apple-mobile-web-app-capable" content="yes" /> 
<meta name="apple-mobile-web-app-status-bar-style" content="black" />  
<meta name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/> 
<link rel="stylesheet" href="css/main.css" type="text/css">
<script src="js/jquery/jquery-1.4.2.js"></script>
<script src="js/ajax/main.js"></script>
<script src="js/ajax/app.js"></script>

<title>开开围脖</title> 
</head>
<body>
<div id="pop-msg"><p>发送成功!</p></div>	
<div id="send">
<img id="close-btn" src="image/close.png" class="close" />
<div class="tips" id='send-title'>说说你的新鲜事</div>
<form>
	<textarea id="send-content" rows="5"></textarea>
	<input id="send-btn" type="button" class="main-button" value="发布围脖" />
</form>
</div>
<div id="mask"></div>
<div id="image">
<img  src="image/close.png" class="close" onclick="gui.closeImage()" />
<img id="image-content" class="set-center" />
</div>
<div id="kk_login_window">
<img id="close-btn" src="image/close.png" class="close" onclick="kk.hideLoginWin()"/>
<div class="tips" id='send-title'>登陆开开</div>
<form class="loginform" method="post" > 
		<label class="username-label" for="username">帐号</label>
		<input id="kk_un" type="text" tabindex="1" autocapitalize="off" autocorrect="off" class="main-field" id="username" name="username">

	  	<p>
		<label class="password-label" for="password">密码</label>
		<input id="kk_pw" type="password" tabindex="2" autocapitalize="off" autocorrect="off" class="main-field" id="password" name="password">
		</p>
		<input  onclick="kk.startLogin()" class="main-button" value="登陆开开" />
</form>
</div>
<div id="header">
开开围脖1.0
<img src="image/arrow_left.png" id="back" onClick="gui.back()" class="back"/>
<a href="logout.php"><img border=0 src="image/exit.png" id="exit" class="exit"/></a>
</div>

<ul id="main-menu">
		<li id="post-btn"><img src="image/post.png" /></li>
        <li id="events-btn" tab="events-panel" class="on"><img src="image/events.png" /></li>        
        <li id="checkin-btn" tab="checkin-panel"><img src="image/checkin.png" /></li> 
		<li id="city-btn" tab="city-panel"><img src="image/city.png" /></li> 
		<li id="user-btn" tab="user-panel"><img src="image/user.png" /></li> 	 
		<div class="clean"></div>
</ul>
<div class="clean"></div>
<div id="tabpanel" >
	
	<div id="events-panel"  class="wrapper"> 
		<ul class="tab-bar"> 
	        <li onClick="gui.showEvents(this,'sina',event);" class="on" id="eventsTagWidth">围脖动态</li>        
	        <li onClick="gui.showEvents(this,'kk',event);" id="eventsTagWidth">开开动态</li> 
			<div class="clean"></div>
	    </ul>
		
		<div id="sinaEvents">
		<div id="sinaEvents-content" class="timeline">
			
		</div>
		
		<div class="more-button" onclick="sinaApp.moreEvents(false)">更多动态</div>
		</div> 

		<div id="kkEvents" style="display:none">
			<div id="kkEvents-content" class="timeline">
			
			</div>
			<div class="more-button" onclick="kk.moreEvents(false)">更多动态</div>
		</div> 
  </div> 
	
	<div id="checkin-panel" class="wrapper"> 
		<div id="search-box">
			<form>
				 <input id="checkin-query" type="text" class="content" ><input onclick="kk.moreCheckin(true)" class="search-button" value=""/>
			</form>
		</div>
		<div id="checkin-panel-content">
			<div id="more-checkin" onclick="kk.moreCheckin(false)" class="more-button">更多地点</div>
		</div>
	</div> 
	
<div id="city-panel" class="wrapper">
	<!-- 天气开始 -->
	<div id="weather-box">
		<img src="image/weather/sunny.png" class="weather-icon"/>
		<div class="weather-content">
		<h2>未知</h2>
		<p>实时：xxxxx</p>
		<p>明天：xxxxx</p>
		</div>
	</div>
	<!-- 天气结束 -->
	<ul class="tab-bar"> 
        <li load="true" class="on" onclick='gui.getCityEvent(this,"event")'>活动</li>        
        <li load="false" onclick='gui.getCityEvent(this,"groupbuy")'>团购</li> 
		<div class="clean"></div>
	</ul> 
	<!-- 活动开始 -->
	<div id="acti" class="acti">
		<div id="more-acti" onclick="douban.moreEvents(false);" class="more-button">更多活动</div>
	</div> 
	<!-- 活动结束 -->
	<!-- 团购开始 -->
	<div id="group-buy" class="group-buy" style="display:none">
	</div>

</div> 
	
<div id="user-panel" class="wrapper"> 
		<div id="user-panel-header">
			
		</div>
		<div id="personal-page-content" style="display:none"></div>
		<div id="personal-page">
			<div id="personal-message">
				<li class="cat-item">微博评论</li>
				<li class="cat-item">微博@回复</li>
				<li class="cat-item">微博私信</li>
			</div>
			<div id="personal-event">
				<li class="cat-item" onclick="gui.showPersonalItem('sinaevent')">微博动态</li>
				<li class="cat-item" onclick="gui.showPersonalItem('fav')">微博收藏</li>
				<li class="cat-item" onclick="gui.showPersonalItem('kkevent')">开开动态</li>
			</div>
			<div id="personal-rel">
				<li class="cat-item">微博关注</li>
				<li class="cat-item">微博粉丝</li>
				<li class="cat-item">开开好友</li>
				<li class="cat-item">开开粉丝</li>
			</div>
		</div>
		<div id="user-events" >
			<div id="user-events-content"></div>
			<div class="more-button" onclick="sinaApp.moreUserEvents()">更多动态</div>
		</div>
		
		<div id="user-following" style="display:none" >
			<div  id="morefollowing" class="more-button" onclick="sinaApp.moreFollowing()">更多关注</div>
		</div>
		
		<div id="user-followers" style="display:none">
			<div  id="morefollowers" class="more-button" onclick="sinaApp.moreFollowers()">更多粉丝</div>
		</div>
  </div> 

</div>
</body>
</html>
<?php sae_xhprof_start();?>