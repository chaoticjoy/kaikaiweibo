<div id="userinfo">
	<img src="{$sina_user_info['profile_image_url']}" class="avatar"/>
	<span class="username">{$sina_user_info['screen_name']}</span>
	<span class="location">{$sina_user_info['location']}</span><br />
	{if $kk_user_info}
	<div class="btn">开开帐号: {$kk_user_info['userspace']['user']['screen_name']}</div>
	{else}
	<div class="btn">绑定开开</div>
	{/if}
	<div class="clean"></div>
</div>
<ul class="tab-bar"> 
    <li onClick="gui.showUser(this,'events')" loaded="true" class="on">动态</li>        
    <li onClick="gui.showUser(this,'following')">关注</li> 
	<li onClick="gui.showUser(this,'followers')" >粉丝</li> 
	<div class="clean"></div>
</ul> 