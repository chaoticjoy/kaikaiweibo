{foreach from=$friends_timeline item=item}
<div style="padding:10px;margin:5px;border:1px solid #ccc">
<a href="user.php?username={$item['user']['screen_name']}"><img src={$item['user']['profile_image_url']}>{$item['user']['screen_name']}</a>:{$item['text']}
{if $item['thumbnail_pic']}
<img src={$item['thumbnail_pic']}>
{/if}
{if $item['retweeted_status']}
<br/>-转发:<a href=user.php?username={$item['retweeted_status']['user']['screen_name']}><img src={$item['retweeted_status']['user']['profile_image_url']}>{$item['retweeted_status']['user']['screen_name']}</a>:{$item['retweeted_status']['text']}
{if $item['retweeted_status']['thumbnail_pic']}
<img src={$item['retweeted_status']['thumbnail_pic']}>
{/if}
{/if}
</div>
{/foreach}
</body></html>