{foreach from=$db_event item=item}
<div class="single">
	<img src="../image/tuangou.png" class="acti-avatar"/>
	<div class="single-name">{$item['data']['display']['shop']['name']}</div>
	<p>{$item['data']['display']['shop']['addr']}</p>
	<p>电话：</p>
	<p class="quote">{$item['data']['display']['title']}<br /><img src="{$item['data']['display']['image']}" class="thumbnail" /></p>
	<div class="single-operate"><span>详情</span> | <span>分享</span></div>
	<br class="clean"/>
</div>
{/foreach}