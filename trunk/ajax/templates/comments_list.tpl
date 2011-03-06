{foreach from=$comments_list item=item}
	<p><span class="author"><a href="javascript:gui.openUserInfo('{$item['user']['id']}','{$item['user']['screen_name']}','sina')">{$item['user']['screen_name']}</a></span>{$item['text']}<span class="reply" onClick="gui.reply('{$id}','{$item['user']['screen_name']}','{$item['id']}')">回复</span></p>
{/foreach}
{if $hasMore  || ($cpage>1)}
	<ul class="comment-bar">         
		<li class="{if $cpage>1}available{/if} pre"  {if $cpage>1}onclick="sinaApp.moreComments('{$id}',{$cpage-1})"{/if} >上一页</li> 
		<li class="{if $hasMore}available{/if} next" {if $hasMore}onclick="sinaApp.moreComments('{$id}',{$cpage+1})"{/if} >下一页</li>        
		<div class="clean"></div>
	</ul>
{/if}
