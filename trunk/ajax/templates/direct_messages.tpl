{foreach from=$direct_messages item=item}
<div class="single" id="sina-dms-{$item['id']}">
	<div class="single-date">{$item['created_at']}</div>
	<img src="{$item['sender']['profile_image_url']}" class="single-avatar"/>
	<div class="single-name">{$item['sender']['screen_name']}</div>
	<p>{$item['text']}</p>
	<div class="single-operate"><span onclick="gui.sendMsg('dm','{$item['id']}','{$item['sender_screen_name']}')">回复TA</span></div>
</div>
{/foreach}