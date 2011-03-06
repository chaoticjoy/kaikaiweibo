{foreach from=$friends_timeline item=item}
			<div class="single">
				<div class="single-date">{$item['status']['create_at']}</div>
				<img onclick="gui.openUserInfo('{$item['status']['user_concise']['id']}','{$item['status']['user_concise']['name']}','kk')" src="{$item['status']['user_concise']['profile_image_url']}" class="single-avatar"/>
				<div class="single-name"><a href="javascript:gui.openUserInfo('{$item['status']['user_concise']['id']}','{$item['status']['user_concise']['name']}','kk')">{$item['status']['user_concise']['screen_name']}</a></div>
				<p>{$item['status']['text']}</p>
				{if $item['status']['photo_thumb_url']}
				<img src="{$item['status']['photo_thumb_url']}" class="thumbnail">
				{/if}
				{if $item['status']['in_reply_to_status']}
				<div class="quote">
				<a href="javascript:gui.openUserInfo('{$item['status']['in_reply_to_status']['user_concise']['id']}','{$item['status']['in_reply_to_status']['user_concise']['name']}','kk')">@{$item['status']['in_reply_to_status']['user_concise']['name']}</a> : {$item['status']['in_reply_to_status']['text']}<br>
				{if $item['status']['in_reply_to_status']['photo_thumb_url']}
				<img src="{$item['status']['in_reply_to_status']['photo_thumb_url']}" class="thumbnail">
				{/if}
				</div>
				{/if}
				<br class="clean" />
			</div>
{/foreach}
