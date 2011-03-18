{if $tuan['goods']['goods_title']}<div class="single">
	<img src="../image/tuangou.png" class="acti-avatar"/>
	<div class="single-name">{$tuan['goods']['goods_sp_name']}</div>
	<p>原价：￥{$tuan['goods']['goods_value']} 现价：￥{$tuan['goods']['goods_price']} 折扣：{$tuan['goods']['goods_rebate']}折</p>
	<p>电话：{$tuan['goods']['goods_phone']}</p>
	<p class="quote">{$tuan['goods']['goods_title']}<br /><img src="{$tuan['goods']['goods_image_url']}" class="thumbnail" /></p>
	<div class="single-operate"><span><a href="{$tuan['goods']['goods_site_url']}" target="_blank">详情</a></span> | <span 
	onclick="gui.sendMsg('tuangou','{$tuan['goods']['goods_sp_name']}'+' '+'{$tuan['goods']['goods_site_url']}','{$tuan['goods']['goods_image_url']}');">分享</span></div>
	<br class="clean"/>
</div>
{else}
<div class="single">
	<img src="../image/tuangou.png" class="acti-avatar"/>
	<div class="single-name">无团购信息</div>
	<p>无团购信息</p>
	<p>无团购信息</p>
	<p class="quote">无团购信息<br /></p>
	<br class="clean"/>
</div>
{/if}