{foreach from=$friends_timeline item=item}
<div id="sina-event-{$item['id']}" >
	<div class="single">
		<div class="single-date">{$item['created_at']}</div>
		<img src="{$item['user']['profile_image_url']}" class="single-avatar"/>
		<div class="single-name">{$item['user']['screen_name']}</div>
		<p class="status">
			{$item['text']}
			{if $item['thumbnail_pic']}
				<br />
				<img onClick="gui.openImage(this)" src="{$item['thumbnail_pic']}" class="thumbnail"/>
			{/if}
		</p>
		{if $item['retweeted_status']}
			<div class="quote">
				转发
				 <a href="#">@{$item['retweeted_status']['user']['screen_name']}</a> : 
				  {$item['retweeted_status']['text']}
				 <br />
				{if $item['retweeted_status']['thumbnail_pic']}
					<img onClick="gui.openImage(this)" src="{$item['retweeted_status']['thumbnail_pic']}" class="thumbnail" />
				{/if}
			</div>
		{/if}
		<div class="single-operate">
			<span onClick="gui.addFavourite('sina','event','{$item['id']}')">收藏</span> | 
			<span onClick="gui.openRetweet('sina','event','{$item['id']}')">转发{if {$item['rt_count']}}({$item['rt_count']}){/if}</span> | 
			<span onClick="gui.openComments('sina','event','{$item['id']}')">评论{if {$item['comments_count']}}({$item['comments_count']}){/if}</span>
		</div>
		<br class="clean"/>
	</div>
</div>
{/foreach}