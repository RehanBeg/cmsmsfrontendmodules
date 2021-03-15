{if isset($message) }<div class="information">{$message}</div>{/if}

{* A form (simple button) for exporting users to csv *}
{$startform}{$input_hidden}

<fieldset>
<legend>{$legend_userhistorymaintenance}</legend>
<div class="pageoverflow">
  <p class="pagetext">{$prompt_exportuserhistory}:</p>
  <p class="pageinput">{$input_exportuserhistory}&nbsp;{$button_exportuserhistory}</p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$prompt_clearuserhistory}:</p>
  <p class="pageinput">{$input_clearuserhistory}&nbsp;{$button_clearuserhistory}</p>
</div>
</fieldset>
{$endform}