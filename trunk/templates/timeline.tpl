{foreach from=$timeline item=item}
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
		<span onClick="gui.addFavourite('{$item['id']}')">收藏</span> | 
		<span onClick="gui.openRetweet('{$item['id']}')">转发{if {$item['rt_count']}}({$item['rt_count']}){/if}</span> | 
		<span onClick="gui.openComments('{$item['id']}')">评论{if {$item['comments_count']}}({$item['comments_count']}){/if}</span>
	</div>
	<br class="clean"/>
	<div class="comments" id="comments-{$item['id']}" style="display:none">
		<form>
		<textarea rows="2" id="comment-content-{$item['id']}"></textarea>
		<input type="button" onClick="sinaApp.sendComment('{$item['id']}')" class="submit-button" value="评论" />
		</form>
		<p>
			<span class="author">$someone</span>
			$someone_comment
			<span class="reply" onClick="gui.reply('$id','$name')">回复</span>
			//....
		</p>
		
		<div class="main-button" onClick="sinaApp.moreComments('{$item['id']}')">更多评论</div>
	</div>
	<div class="retweet" id="retweet-{$item['id']}" style="display:none">
		<form>
		<textarea rows="2" id="retweet-content-{$item['id']}">测试测试测试转发。</textarea>
		<input type="button" onClick="sinaApp.sendRetweet('{$item['id']}')" class="submit-button" value="转发" />
		</form>
	</div>
</div>
{/foreach}