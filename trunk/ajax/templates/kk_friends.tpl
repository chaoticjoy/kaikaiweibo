{foreach from=$friends item=user}
<div class="single">
	<img onclick="gui.openUserInfo('{$user['user_concise']['id']}','{$user['user_concise']['screen_name']}','kk')" src="{$user['user_concise']['profile_image_url']}" class="single-avatar"/>
	<div class="single-name"><a href="javascript:gui.openUserInfo('{$user['user_concise']['id']}','{$user['user_concise']['screen_name']}','kk')">{$user['user_concise']['screen_name']}</a></div>
	<p>{$user['user_concise']['location']}</p>
</div>
{/foreach}