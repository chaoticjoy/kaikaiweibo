{foreach from=$friends_timeline item=item}
			<div class="single">
				<div class="single-date">{$item['status']['create_at']}</div> <!-- 动态发表时间 -->
				<img src="{$item['status']['user_concise']['profile_image_url']}" class="single-avatar"/> <!-- 用户头像 -->
				<div class="single-name">{$item['status']['user_concise']['screen_name']}</div> <!-- 用户昵称screen_name -->
				<p>{$item['status']['text']}</p> <!-- 动态内容 -->
				<br class="clean"/>
			</div>
{/foreach}
