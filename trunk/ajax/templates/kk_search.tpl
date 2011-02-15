{foreach from=$search item=item}
<div class="poi-single">
	<div class="single" onclick="gui.openCheckin(this.parentNode,'{$item['poi_concise']['id']}')">
	<img src="../image/poi.png" class="poi-avatar"/>
	<div class="poi-name">{$item['poi_concise']['name']}</div>
	<p>{$item['poi_concise']['address']}</p>
	<p class="clean"></p>
	</div>
	
</div>
{/foreach}