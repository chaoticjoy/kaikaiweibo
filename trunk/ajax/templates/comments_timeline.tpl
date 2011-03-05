{foreach from=$comments_timeline item=item}
{if $item['user']['screen_name'] ne $me}
<div class="single">
	<div class="single-date">{$item['created_at']}</div>
	<img onclick="gui.openUserInfo('{$item['user']['id']}','{$item['user']['screen_name']}','sina')" src="{$item['user']['profile_image_url']}" class="single-avatar"/>
	<div class="single-name">{$item['user']['screen_name']}</div>
	<p>{$item['text']}</p>
	<p class="quote"><b>回复原文：</b>{$item['status']['text']}</p>
	<div class="single-operate" ><span onclick="gui.sendMsg('comment','{$item['status']['id']}+{$item['id']}','{$item['user']['screen_name']}')">回复TA</span></div>
</div>
{/if}
{/foreach}