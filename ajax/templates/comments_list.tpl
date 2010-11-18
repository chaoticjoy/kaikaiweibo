{foreach from=$comments_list item=item}
	<p><span class="author">{$item['user']['screen_name']}</span>{$item['text']}<span class="reply" onClick="gui.reply('{$item['id']}','{$item['user']['screen_name']}')">回复</span></p>
{/foreach}

	<ul class="comment-bar">         
		<li {if $cpage>1}class="available pre"  onclick="sinaApp.moreComments('{$id}',{$cpage-1})"{/if} >上一页</li> 
		<li {if $hasMore}class="available next" onclick="sinaApp.moreComments('{$id}',{$cpage+1})"{/if} >下一页</li>        
		<div class="clean"></div>
	</ul>

