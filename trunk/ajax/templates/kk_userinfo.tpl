	<div id="userinfo">
			<img src="{$user['profile_image_url']}" class="avatar"/>
			<span class="username">{$user['screen_name']}</span>
			<span class="location">{$user['location']}</span><br />
			<div class="btn">加关注</div>
			<div class="btn" onClick="gui.sendMsg('dm','{$user['id']}','{$user['screen_name']}')">私信</div>
			<div class="clean"></div>
	</div>
		<ul class="tab-bar"> 
	        <li onClick="gui.showUser(this,'events')" class="on">动态</li>        
	        <li onClick="gui.showUser(this,'following')">关注</li> 
			<li onClick="gui.showUser(this,'followers')" >粉丝</li> 
			<div class="clean"></div>
	    </ul> 
		
	<div id="userinfo">
		<img src="{$user['userspace']['user']['profile_image_url']}" class="avatar"/>
		<span class="username">{$user['userspace']['user']['screen_name']}</span><span class="location">{$user['userspace']['user']['location']}</span><br />
		<a href="http://k.ai/{$user['userspace']['user']['name']}"><div class="btn">开开主页</div></a>
		<div class="clean"></div>
	</div>
