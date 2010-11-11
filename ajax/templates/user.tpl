{foreach from=$users item=user}
<div class="single">
	<img src="{$user['profile_image_url']}" class="single-avatar"/>
	<div class="single-name">{$user['screen_name']}</div>
	<p>{$user['location']}</p>
</div>
{/foreach}