{foreach from=$friends item=user}
<div class="single">
	<img onclick="gui.openUserInfo('{$user['id']}','{$user['screen_name']}','sina')" src="{$user['profile_image_url']}" class="single-avatar"/>
	<div class="single-name">{$user['screen_name']}</div>
	<p>{$user['location']}</p>
</div>
{/foreach}
{if $next_cursor}<div id="morefollowing" class="more-button" onclick="sinaApp.moreFollowing({$next_cursor})">更多关注</div>{/if}