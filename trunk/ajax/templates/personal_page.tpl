<div id="userinfo">
	<img src="{$sina_user_info['profile_image_url']}" class="avatar"/>
	<span class="username">{$sina_user_info['screen_name']}</span>
	<span class="location">{$sina_user_info['location']}</span><br />
	{if $kk_user_info}
	<div class="btn">已登录开开: {$kk_user_info['userspace']['user']['screen_name']}</div>
	{else}
	<div class="btn" onclick="kk.loginFromPersonalPage(this)">登录开开</div>
	{/if}
	<div class="clean"></div>
</div>
<ul class="tab-bar"> 
    <li onClick="gui.showPersonal(this,'message')"  class="on">消息</li>        
    <li onClick="gui.showPersonal(this,'event')">动态</li> 
	<li onClick="gui.showPersonal(this,'rel')">关系</li> 
	<div class="clean"></div>
</ul> 