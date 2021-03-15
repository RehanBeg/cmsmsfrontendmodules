{if isset($message)}
  {if isset($error)}
    <font color="red"><h4>{$message}</h4></font>
  {else}
    <div class="information">{$message}</div>
  {/if}
{/if}

{if !isset($multiuser)}
  <h4>{$title_userhistory}&nbsp;{$for}&nbsp;{$user->username}</h4>
{/if}
{$formstart}
<div class="c_full">
<fieldset class="grid_6">
<legend>{$title_legend_filter}:</legend>
  <div class="c_full">
     <p class="grid_3">{$prompt_filter_eventtype}:</p>
     <p class="grid_9">{$input_filter_eventtype}</p>
     <div class="clearb"></div>
  </div>
  {if isset($multiuser)}
  <div class="c_full">
     <p class="grid_3">{$prompt_username_regex}:</p>
     <p class="grid_9">{$input_username_regex}</p>
     <div class="clearb"></div>
  </div>
  {/if}
  <div class="c_full">
     <p class="grid_3">{$prompt_filter_date}:</p>
     <p class="grid_9">{$input_filter_date}</p>
     <div class="clearb"></div>
  </div>
  <div class="c_full">
     <p class="grid_3">{$prompt_pagelimit}:</p>
     <p class="grid_9">{$input_pagelimit}</p>
     <div class="clearb"></div>
  </div>
</fieldset>

<fieldset class="grid_6">
<legend>{$title_legend_groupsort}:</legend>
  <div class="c_full">
     <p class="grid_3">{$prompt_group_ip}:</p>
     <p class="grid_9">{$input_group_ip}</p>
     <div class="clearb"></div>
  </div>
  <div class="c_full">
     <p class="grid_3">{$prompt_sortorder}:</p>
     <p class="grid_9">{$input_sortorder}</p>
     <div class="clearb"></div>
  </div>
</fieldset>
</div>
<div class="c_full">
   <p class="grid_9">{$submit}&nbsp;{$reset}</p>
   <div class="clearb"></div>
</div>
{$formend}
<br/>

<div class="c_full">
  <div class="grid_6" style="margin-left: 0;">
    {$recordcount}&nbsp;{$prompt_recordsfound}
  </div>
  <div class="grid_6 text-right">
    {if $itemcount > 0}
      {if $pagecount > 1}
        {if $pagenumber > 1}{$firstpage}&nbsp;{$prevpage}&nbsp;{/if}
        {$pagenumber}&nbsp;{$oftext}&nbsp;{$pagecount}
        {if $pagenumber < $pagecount}
           &nbsp;{$nextpage}&nbsp;{$lastpage}
        {/if}
      {/if}
    {/if}
 </div>
</div>

<table class="pagetable">
  <thead>
    <tr>
        {if isset($multiuser)}
	<th>{$prompt_username}</th>
        {/if}
	<th>{$prompt_ipaddress}</th>
	<th>{$prompt_action}</th>
	<th>{$prompt_refdate}</th>
    </tr>
  </thead>
  <tbody>
  {foreach from=$items item=entry}
    <tr class="{$entry->rowclass}">
        {if isset($multiuser)}
        <td>{$entry->username}</td>
        {/if}
	<td>{$entry->ipaddress}</td>
	<td>{$entry->action}</td>
	<td>{$entry->refdate|date_format:"%b %e, %Y - %X"}</td>
  </tr>
  {/foreach}
  </tbody>
</table>
