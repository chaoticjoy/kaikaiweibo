<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>开开测试程序</title></head><body>
<a href=logout.php>登出</a>
{foreach from=$friends_timeline item=item}
<div style="padding:10px;margin:5px;border:1px solid #ccc">
<a href={$item['user']['url']}><img src={$item['user']['profile_image_url']}>{$item['user']['screen_name']}</a>:{$item['text']}
{if $item['thumbnail_pic']}
<img src={$item['thumbnail_pic']}>
{/if}
{if $item['retweeted_status']}
<br/>-转发:<a href={$item['retweeted_status']['user']['url']}><img src={$item['retweeted_status']['user']['profile_image_url']}>{$item['retweeted_status']['user']['screen_name']}</a>:{$item['retweeted_status']['text']}
{if $item['retweeted_status']['thumbnail_pic']}
<img src={$item['retweeted_status']['thumbnail_pic']}>
{/if}
{/if}
</div>
{/foreach}
</body></html>