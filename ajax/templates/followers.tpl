{foreach from=$followers item=user}
<div class="single">
	<img onclick="gui.openUserInfo('{$user['id']}','{$user['screen_name']}','sina')" src="{$user['profile_image_url']}" class="single-avatar"/>
	<div class="single-name"><a href="javascript:gui.openUserInfo('{$user['id']}','{$user['screen_name']}','sina')">{$user['screen_name']}</a></div>
	<p>{$user['location']}</p>
</div>
{/foreach}
{if $next_cursor}<div  id="morefollowers" class="more-button" onclick="sinaApp.moreFollowers({$next_cursor})">更多粉丝</div>{/if}