<div id="userinfo">
	<img src="{$user['profile_image_url']}" class="avatar"/>
	<span class="username">{$user['screen_name']}</span>
	<span class="location">{$user['location']}</span><br />
	{if $is_follow}
	<div class="btn" onclick="sinaApp.unfollow('{$user['screen_name']}',this)">取消关注</div>
	{else}
	<div class="btn" onclick="sinaApp.follow('{$user['screen_name']}',this)">加关注</div>
	{/if}
	<div class="btn" onClick="gui.sendMsg('dm','{$user['id']}','{$user['screen_name']}')">私信</div>
	<div class="clean"></div>
</div>
<ul class="tab-bar"> 
    <li onClick="gui.showUser(this,'events')" loaded="true" class="on">动态</li>        
    <li onClick="gui.showUser(this,'following')">关注</li> 
	<li onClick="gui.showUser(this,'followers')" >粉丝</li> 
	<div class="clean"></div>
</ul> 