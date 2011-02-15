{foreach from=$tips item=item}
<p><span class="author">{$item['tip']['nickname']}</span>{$item['tip']['message']}</p>
{/foreach}