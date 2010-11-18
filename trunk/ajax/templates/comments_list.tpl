{foreach from=$comments_list item=item}
	<p><span class="author">{$item['user']['screen_name']}</span>{$item['text']}<span class="reply" onClick="gui.reply('{$item['id']}','{$item['user']['screen_name']}')">回复</span></p>
{/foreach}

{if $hasMore}
	<div id="moreComments-{$id}" class="main-button" onClick="sinaApp.moreComments('{$id}',{$page})">更多评论</div>
{/if}
