{foreach from=$friends_timeline item=item}
<div id="sina-event-{$item['id']}" username="{$item['user']['screen_name']}">
	<div class="single">
		<div class="single-date">{$item['created_at']}</div>
		<img onclick="gui.openUserInfo('{$item['user']['id']}','{$item['user']['screen_name']}','sina')" src="{$item['user']['profile_image_url']}" class="single-avatar"/>
		<div class="single-name"><a href="javascript:gui.openUserInfo('{$item['user']['id']}','{$item['user']['screen_name']}','sina')">{$item['user']['screen_name']}</a></div>
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
				 <a href="javascript:gui.openUserInfo('','{$item['retweeted_status']['user']['screen_name']}','sina')">@{$item['retweeted_status']['user']['screen_name']}</a> : 
				  {$item['retweeted_status']['text']}
				 <br />
				{if $item['retweeted_status']['thumbnail_pic']}
					<img onClick="gui.openImage(this)" src="{$item['retweeted_status']['thumbnail_pic']}" class="thumbnail" />
				{/if}
			</div>
		{/if}
		<div class="single-operate">
			<span onClick="gui.addFavourite('sina','event','{$item['id']}')">收藏</span> | 
			<span onClick="gui.openRetweet('sina','event','{$item['id']}'
			
			{if $item['retweeted_status']},true{/if}
			
			)">转发{if {$item['rt_count']}}({$item['rt_count']}){/if}</span> | 
			<span onClick="gui.openComments('sina','event','{$item['id']}')">评论{if {$item['comments_count']}}({$item['comments_count']}){/if}</span>
		</div>
		<br class="clean"/>
	</div>
</div>
{/foreach}