{foreach from=$favorites item=item}
<div class="single">
	<div class="single-date">{$item['created_at']}</div>
	<img onclick="gui.openUserInfo('{$item['user']['id']}','{$item['user']['screen_name']}','sina')" src="{$item['user']['profile_image_url']}" class="single-avatar"/>
	<div class="single-name">{$item['user']['screen_name']}</div>
	<p>{$item['text']}</p>
	<div class="single-operate">
	<span onClick="gui.openRetweet('sina','user','{$item['id']}'
	{if $item['retweeted_status']},true{/if}
	)">转发{if {$item['rt_count']}}({$item['rt_count']}){/if}</span> | 
	<span onClick="gui.openComments('sina','user','{$item['id']}')">评论{if {$item['comments_count']}}({$item['comments_count']}){/if}</span>
	</div>
	<br class="clean"/>
</div>
{/foreach}