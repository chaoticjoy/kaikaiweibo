<div id="userinfo">
	<img src="{$user['userspace']['user']['profile_image_url']}" class="avatar"/>
	<span class="username">{$user['userspace']['user']['screen_name']}</span><span class="location"></span><br />
	<a href="http://k.ai/{$user['userspace']['user']['name']}" target="_blank"><div class="btn">开开主页</div></a>
	<div class="clean"></div>
</div>

<ul class="tab-bar"> 
    <li onClick="gui.showUser(this,'events')" class="on" loaded="true">动态</li>        
    <li onClick="gui.showUser(this,'following')">好友</li> 
	<li onClick="gui.showUser(this,'followers')" >粉丝</li> 
	<div class="clean"></div>
</ul> 
	