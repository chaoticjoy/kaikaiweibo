{foreach from=$direct_messages item=item}
<div class="single" id="sina-dms-{$item['id']}">
	<div class="single-date">{$item['created_at']}</div>
	<img onclick="gui.openUserInfo('{$item['sender']['id']}','{$item['sender']['screen_name']}','sina')" src="{$item['sender']['profile_image_url']}" class="single-avatar"/>
	<div class="single-name"><a href="javascript:gui.openUserInfo('{$item['sender']['id']}','{$item['sender']['screen_name']}','sina')">{$item['sender']['screen_name']}</a></div>
	<p>{$item['text']}</p>
	<div class="single-operate"><span onclick="gui.sendMsg('dm','{$item['id']}','{$item['sender_screen_name']}')">回复TA</span></div>
</div>
{/foreach}