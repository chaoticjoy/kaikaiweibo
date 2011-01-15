{foreach from=$user_timeline item=item}
<div class="single">
	<div class="single-date">{$item['status']['create_at']}</div> 
	<img src="{$item['status']['user_concise']['profile_image_url']}" class="single-avatar"/>
	<div class="single-name">{$item['status']['user_concise']['screen_name']}</div> 
	<p>{$item['status']['text']}</p>
	<br class="clean"/>
</div>
{/foreach}