{foreach from=$user_timeline item=item}
<div id="sina-user-{$item['id']}" username="{$item['user']['screen_name']}">
	<div class="user-tread">
		<div class="single-date">{$item['created_at']}</div>
		<div class="single-name">{$item['user']['screen_name']}</div>
		<p class="status">
			<span id="sina-status-{$item['id']}">
			{$item['text']}
			</span>
			{if $item['thumbnail_pic']}
				<br />
				<img onClick="gui.openImage(this)" src="{$item['thumbnail_pic']}" class="thumbnail"/>
			{/if}
		</p>
		{if $item['retweeted_status']}
			<div class="quote">
				 <a href="#">@{$item['retweeted_status']['user']['screen_name']}</a> : 
				  {$item['retweeted_status']['text']}
				 <br />
				{if $item['retweeted_status']['thumbnail_pic']}
					<img onClick="gui.openImage(this)" src="{$item['retweeted_status']['thumbnail_pic']}" class="thumbnail" />
				{/if}
			</div>
		{/if}
		<div class="single-operate">
			<span onClick="gui.addFavourite('sina','user','{$item['id']}')">收藏</span> | 
			<span onClick="gui.openRetweet('sina','user','{$item['id']}'
			{if $item['retweeted_status']},true{/if}
			)">转发{if {$item['rt_count']}}({$item['rt_count']}){/if}</span> | 
			<span onClick="gui.openComments('sina','user','{$item['id']}')">评论{if {$item['comments_count']}}({$item['comments_count']}){/if}</span>
		</div>
		<br class="clean"/>
	</div>
</div>
{/foreach}