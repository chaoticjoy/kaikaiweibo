<div class="comments" id="comments-{$id}" style="display:none">
	<form>
		<textarea rows="2" id="comment-content-{$id}"></textarea>
		<input type="button" onClick="sinaApp.sendComment('{$id}')" class="submit-button" value="评论" />
	</form>
	{foreach from=$comments_list item=item}
		<p><span class="author">{$item['user']['screen_name']}</span>{$item['text']}<span class="reply" onClick="gui.reply('{$item['id']}','{$item['user']['screen_name']}')">回复</span></p>
	{/foreach}
	<div class="main-button" onClick="sinaApp.moreComments('{$id}')">更多评论</div>
</div>