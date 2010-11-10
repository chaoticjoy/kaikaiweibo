<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>开开测试程序</title></head><body>
{foreach from=$usertimeline item=item}
<div style="padding:10px;margin:5px;border:1px solid #ccc">
{$item['text']}
{if $item['bmiddle_pic']}
<img src={$item['bmiddle_pic']}>
{/if}
{if $item['retweeted_status']}
<br/>-转发{$item['retweeted_status']['text']}
{/if}
</div>
{/foreach}
</body></html>