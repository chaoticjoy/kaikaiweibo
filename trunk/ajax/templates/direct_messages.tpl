{foreach from=$direct_messages item=item}
<div class="single">
	<div class="single-date">{$item['created_at']}</div>
	<img src="{$item['sender']['profile_image_url']}" class="single-avatar"/>
	<div class="single-name">{$item['sender']['screen_name']}</div>
	<p>{$item['text']}</p>
	<div class="single-operate"><span>回复TA</span></div>
</div>
{/foreach}