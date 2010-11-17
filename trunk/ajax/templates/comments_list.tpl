{foreach from=$comments_list item=item}
	<p><span class="author">{$item['user']['screen_name']}</span>{$item['text']}<span class="reply" onClick="gui.reply('{$item['id']}','{$item['user']['screen_name']}')">回复</span></p>
{/foreach}
<div class="main-button" onClick="sinaApp.moreComments('{$id}')">更多评论</div>
