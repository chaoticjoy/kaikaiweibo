{foreach from=$db_event item=item}
<div class="single">
	<img src="../image/acti.png" class="acti-avatar"/>
	<div class="single-name">{$item['title']}</div>
	<p>地点：{$item['where']['@attributes']['valueString']}</p>
	<p>{$item['when']['@attributes']['startTime']} - {$item['when']['@attributes']['endTime']}</p>
	<div class="single-operate"><span><a href="{$item['link']['1']['@attributes']['href']}" target="_blank">详情</a></span> | <span onclick="gui.sendMsg('douban','{$item['title']}','{$item['link']['1']['@attributes']['href']}')">分享</span></div>
	<br class="clean"/>
</div>
{/foreach}