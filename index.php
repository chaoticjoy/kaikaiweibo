<?php

//sae_set_display_errors(true);
include_once('lib/smarty/Smarty.class.php');
include_once('lib/weibo.php');
include_once('inc/config.php');
include_once('inc/utility.php');
include_once('inc/sina.php');

if(!(getEncryptCookie('sina_name') && getEncryptCookie('sina_pw')))
header('location: login.php');
$w = new weibo( APP_KEY );
$w->setUser( getEncryptCookie('sina_name') , getEncryptCookie('sina_pw') );
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

<div id="header">
开开围脖1.0
<img src="image/arrow_left.png" id="back" onClick="gui.back()" class="back"/>
<img src="image/exit.png" id="exit" class="exit"/>
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
		<div class="timeline">
			<?php include  ('ajax/friends_timeline.php'); ?>
		</div>
		
		<div class="more-button">更多动态</div>
		</div> 

		<div id="kkEvents">
		<div class="timeline">
			<div class="single">
			<div class="single-date">1 mins</div>
			<img src="http://tp2.sinaimg.cn/1246147933/50/1281260689/0" class="single-avatar"/>
			<div class="single-name">Kavin</div>
			<p>这是开开动态</p>
			
			<div class="single-operate"><span>收藏</span> | <span>转发</span> | <span >评论(3)</span></div>
			<br class="clean"/></div>
			
			<div class="single">
			<div class="single-date">1 mins</div>
			<img src="http://tp2.sinaimg.cn/1246147933/50/1281260689/0" class="single-avatar"/>
			<div class="single-name">Kavin</div>
			<p>测试评论按钮</p>
			<div class="single-operate"><span>收藏</span> | <span>转发</span> | <span onClick="gui.openComments('123456')">评论(3)</span></div>
			<br class="clean"/></div>
			<div class="comments" id="comments-123456" style="display:none">
				<form>
				<textarea rows="2" id="comment-content-123456"></textarea>
				<input type="button" onClick="sinaApp.sendComment('123456')" class="submit-button" value="评论" />
				</form>
				<p><span class="author">Kavin</span>评论评论评论<span class="reply" onClick="gui.reply('123456','Kavin')">回复</span></p>
				<p><span class="author">Kavin</span>评论评论评论<span class="reply">回复</span></p>
				<p><span class="author">Kavin</span>评论评论评论<span class="reply">回复</span></p>
				<div class="main-button" onClick="sinaApp.moreComments('123456')">更多评论</div>
			</div>
			
			
			
			<div class="single">
			<div class="single-date">1 mins</div>
			<img src="http://tp2.sinaimg.cn/1246147933/50/1281260689/0" class="single-avatar"/>
			<div class="single-name">Kavin</div>
			<p>测试测试测试转发
			<br /><img onClick="gui.openImage(this)" src="http://ss16.sinaimg.cn/thumbnail/6628711bg93832cab169f&690" class="thumbnail"/></p>
			<div class="single-operate"><span>收藏</span> | <span onClick="gui.openRetweet('123456')">转发</span> | <span>评论(3)</span></div>
			<br class="clean"/></div>
			<div class="retweet" id="retweet-123456" style="display:none">
				<form>
				<textarea rows="2" id="retweet-content-123456">测试测试测试转发。</textarea>
				<input type="button" onClick="sinaApp.sendRetweet('123456')" class="submit-button" value="转发" />
				</form>
			</div>
			
			<div class="single">
			<div class="single-date">1 mins</div>
			<img src="http://tp2.sinaimg.cn/1246147933/50/1281260689/0" class="single-avatar"/>
			<div class="single-name">Kavin</div>
			<p>FourSquare 和 Seesmic Twitter 两大社交程序现身 WP7 #Facebook# #Foursquare# #Landscape# #Seesmic# #Twitter# #WP7# http://sinaurl.cn/h67KnU</p>
			<div class="single-operate"><span>收藏</span> | <span>转发</span> | <span>评论(3)</span></div>
			<br class="clean"/></div>
			
			<div class="single">
			<div class="single-date">1 mins</div>
			<img src="http://tp2.sinaimg.cn/1246147933/50/1281260689/0" class="single-avatar"/>
			<div class="single-name">Kavin</div>
			<p>FourSquare 和 Seesmic Twitter 两大社交程序现身 WP7 #Facebook# #Foursquare# #Landscape# #Seesmic# #Twitter# #WP7# <a href="#" target="_blank">http://sinaurl.cn/h67KnU</a></p>
			<div class="single-operate"><span>收藏</span> | <span>转发</span> | <span>评论(3)</span></div>
			<br class="clean"/></div>
		</div>
		
		<div class="more-button">更多动态</div>
		</div> 
  </div> 
	
	<div id="checkin-panel" class="wrapper"> 
		<div class="timeline">
			<div class="single">
			<div class="single-date">23 mins</div>
			<img src="http://tp2.sinaimg.cn/1246147933/50/1281260689/0" class="single-avatar"/>
			<div class="single-name">VVVV</div>
			<p>我说我以后结婚，一定要找爱人当伴娘，因为她比我还着急比我还操心嘛~ 恩……明天几点起来呢，我有10张明信片要去邮局寄。晚上再去看个电影。</p>
			<div class="quote">转发 <a href="#">@经纬张颖</a> : 要想在创业板上市的创业者们可以认真读下这篇文章。虽然有些细节过于夸张，但总体来说，在国内上市，不管是创业板，中小板还是主板，都是“千军万马过独木桥”的艰难和未知！其过程对老总的综合素质，全面化，应急，执行和变通能力要求都非常高！《我是这样闯过创业板的》http://sinaurl.cn/h9BiCk<br /><img src="http://ss9.sinaimg.cn/thumbnail/69c5ad72t932f08465668&690" class="thumbnail" /></div>
			<div class="single-operate"><span>收藏</span> | <span>转发</span> | <span>评论(3)</span></div>
			<br class="clean"/></div>
			
			<div class="single">
			<div class="single-date">1 mins</div>
			<img src="http://tp2.sinaimg.cn/1246147933/50/1281260689/0" class="single-avatar"/>
			<div class="single-name">Kavin</div>
			<p>我说我以后结婚，一定要找爱人当伴娘，因为她比我还着急比我还操心嘛~ 恩……明天几点起来呢，我有10张明信片要去邮局寄。晚上再去看个电影。</p>
			<div class="single-operate"><span>收藏</span> | <span>转发</span> | <span>评论(3)</span></div>
			<br class="clean"/></div>
			<div class="comments">
				<form>
				<textarea rows="2"></textarea>
				<input type="submit" class="submit-button" value="评论" />
				</form>
				<p><span class="author">Kavin</span>评论评论评论<span class="reply">回复</span></p>
				<p><span class="author">Kavin</span>评论评论评论<span class="reply">回复</span></p>
				<p><span class="author">Kavin</span>评论评论评论<span class="reply">回复</span></p>
				<div class="main-button">更多评论</div>
			</div>
			
			
			
			<div class="single">
			<div class="single-date">1 mins</div>
			<img src="http://tp2.sinaimg.cn/1246147933/50/1281260689/0" class="single-avatar"/>
			<div class="single-name">Kavin</div>
			<p>FourSquare 和 Seesmic Twitter 两大社交程序现身 WP7 #Facebook# #Foursquare# #Landscape# #Seesmic# #Twitter# #WP7# http://sinaurl.cn/h67KnU
			<br /><img src="http://ss9.sinaimg.cn/thumbnail/69c5ad72t932f08465668&690" class="thumbnail"/></p>
			<div class="single-operate"><span>收藏</span> | <span>转发</span> | <span>评论(3)</span></div>
			<br class="clean"/></div>
			<div class="retweet">
				<form>
				<textarea rows="2">测试测试测试转发。</textarea>
				<input type="submit" class="submit-button" value="转发" />
				</form>
			</div>
			
			<div class="single">
			<div class="single-date">1 mins</div>
			<img src="http://tp2.sinaimg.cn/1246147933/50/1281260689/0" class="single-avatar"/>
			<div class="single-name">Kavin</div>
			<p>FourSquare 和 Seesmic Twitter 两大社交程序现身 WP7 #Facebook# #Foursquare# #Landscape# #Seesmic# #Twitter# #WP7# http://sinaurl.cn/h67KnU</p>
			<div class="single-operate"><span>收藏</span> | <span>转发</span> | <span>评论(3)</span></div>
			<br class="clean"/></div>
			
			<div class="single">
			<div class="single-date">1 mins</div>
			<img src="http://tp2.sinaimg.cn/1246147933/50/1281260689/0" class="single-avatar"/>
			<div class="single-name">Kavin</div>
			<p>FourSquare 和 Seesmic Twitter 两大社交程序现身 WP7 #Facebook# #Foursquare# #Landscape# #Seesmic# #Twitter# #WP7# <a href="#" target="_blank">http://sinaurl.cn/h67KnU</a></p>
			<div class="single-operate"><span>收藏</span> | <span>转发</span> | <span>评论(3)</span></div>
			<br class="clean"/></div>
		</div>
		<div class="more-button">更多动态</div>
		
	</div> 
	
	<div id="city-panel" class="wrapper"> 
	<div class="timeline">
			<div class="single">
			<div class="single-date">23 mins</div>
			<img src="http://tp2.sinaimg.cn/1246147933/50/1281260689/0" class="single-avatar"/>
			<div class="single-name">VVVV</div>
			<p>我说我以后结婚，一定要找爱人当伴娘，因为她比我还着急比我还操心嘛~ 恩……明天几点起来呢，我有10张明信片要去邮局寄。晚上再去看个电影。</p>
			<div class="quote">转发 <a href="#">@经纬张颖</a> : 要想在创业板上市的创业者们可以认真读下这篇文章。虽然有些细节过于夸张，但总体来说，在国内上市，不管是创业板，中小板还是主板，都是“千军万马过独木桥”的艰难和未知！其过程对老总的综合素质，全面化，应急，执行和变通能力要求都非常高！《我是这样闯过创业板的》http://sinaurl.cn/h9BiCk<br /><img src="http://ss9.sinaimg.cn/thumbnail/69c5ad72t932f08465668&690" class="thumbnail" /></div>
			<div class="single-operate"><span>收藏</span> | <span>转发</span> | <span>评论(3)</span></div>
			<br class="clean"/></div>
			
			<div class="single">
			<div class="single-date">1 mins</div>
			<img src="http://tp2.sinaimg.cn/1246147933/50/1281260689/0" class="single-avatar"/>
			<div class="single-name">Kavin</div>
			<p>我说我以后结婚，一定要找爱人当伴娘，因为她比我还着急比我还操心嘛~ 恩……明天几点起来呢，我有10张明信片要去邮局寄。晚上再去看个电影。</p>
			<div class="single-operate"><span>收藏</span> | <span>转发</span> | <span>评论(3)</span></div>
			<br class="clean"/></div>
			<div class="comments">
				<form>
				<textarea rows="2"></textarea>
				<input type="submit" class="submit-button" value="评论" />
				</form>
				<p><span class="author">Kavin</span>评论评论评论<span class="reply">回复</span></p>
				<p><span class="author">Kavin</span>评论评论评论<span class="reply">回复</span></p>
				<p><span class="author">Kavin</span>评论评论评论<span class="reply">回复</span></p>
				<div class="main-button">更多评论</div>
			</div>
			
			
			
			<div class="single">
			<div class="single-date">1 mins</div>
			<img src="http://tp2.sinaimg.cn/1246147933/50/1281260689/0" class="single-avatar"/>
			<div class="single-name">Kavin</div>
			<p>FourSquare 和 Seesmic Twitter 两大社交程序现身 WP7 #Facebook# #Foursquare# #Landscape# #Seesmic# #Twitter# #WP7# http://sinaurl.cn/h67KnU
			<br /><img src="http://ss9.sinaimg.cn/thumbnail/69c5ad72t932f08465668&690" class="thumbnail"/></p>
			<div class="single-operate"><span>收藏</span> | <span>转发</span> | <span>评论(3)</span></div>
			<br class="clean"/></div>
			<div class="retweet">
				<form>
				<textarea rows="2">测试测试测试转发。</textarea>
				<input type="submit" class="submit-button" value="转发" />
				</form>
			</div>
			
			<div class="single">
			<div class="single-date">1 mins</div>
			<img src="http://tp2.sinaimg.cn/1246147933/50/1281260689/0" class="single-avatar"/>
			<div class="single-name">Kavin</div>
			<p>FourSquare 和 Seesmic Twitter 两大社交程序现身 WP7 #Facebook# #Foursquare# #Landscape# #Seesmic# #Twitter# #WP7# http://sinaurl.cn/h67KnU</p>
			<div class="single-operate"><span>收藏</span> | <span>转发</span> | <span>评论(3)</span></div>
			<br class="clean"/></div>
			
			<div class="single">
			<div class="single-date">1 mins</div>
			<img src="http://tp2.sinaimg.cn/1246147933/50/1281260689/0" class="single-avatar"/>
			<div class="single-name">Kavin</div>
			<p>FourSquare 和 Seesmic Twitter 两大社交程序现身 WP7 #Facebook# #Foursquare# #Landscape# #Seesmic# #Twitter# #WP7# <a href="#" target="_blank">http://sinaurl.cn/h67KnU</a></p>
			<div class="single-operate"><span>收藏</span> | <span>转发</span> | <span>评论(3)</span></div>
			<br class="clean"/></div>
	  </div>
		<div class="more-button">更多动态</div>
	</div> 
	
<div id="user-panel" class="wrapper"> 
			<?php include  ('ajax/userinfo.php'); ?>
		<div id="user-events" >
			<?php include  ('ajax/user_timeline.php'); ?>
		</div>
		
		<div id="user-following" >
			<?php include  ('ajax/friends.php'); ?>
			<div class="more-button">更多关注</div>
		</div>
		
		<div id="user-followers" class="timeline">
			<?php include  ('ajax/followers.php'); ?>
			<div class="more-button">更多粉丝</div>
		</div>
  </div> 

</div>
</body>
</html>
