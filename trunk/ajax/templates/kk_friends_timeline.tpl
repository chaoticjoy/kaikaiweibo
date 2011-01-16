{foreach from=$friends_timeline item=item}
			<div class="single">
				<div class="single-date">{$item['status']['create_at']}</div>
				<img onclick="gui.openUserInfo('{$item['status']['user_concise']['id']}','{$item['status']['user_concise']['name']}','kk')" src="{$item['status']['user_concise']['profile_image_url']}" class="single-avatar"/>
				<div class="single-name">{$item['status']['user_concise']['screen_name']}</div>
				<p>{$item['status']['text']}</p>
				<br class="clean" />
			</div>
{/foreach}
