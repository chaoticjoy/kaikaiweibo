	<div id="userinfo">
			<img src="{$user['profile_image_url']}" class="avatar"/>
			<span class="username">{$user['screen_name']}</span>
			<span class="location">{$user['location']}</span><br />
			<div class="btn">加关注</div>
			<div class="btn" onClick="gui.sendMsg('dm','123','Kavin')">私信</div>
			<div class="clean"></div>
	</div>
		<ul class="tab-bar"> 
	        <li onClick="gui.showUser(this,'events')" >动态</li>        
	        <li onClick="gui.showUser(this,'following')">关注</li> 
			<li onClick="gui.showUser(this,'followers')" class="on">粉丝</li> 
			<div class="clean"></div>
	    </ul> 