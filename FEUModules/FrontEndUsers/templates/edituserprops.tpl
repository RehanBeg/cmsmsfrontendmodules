{$title}
{if isset($message) }
  {if isset($error) }
    <p><font color="red">{$message}</font></p>
  {else}
    <p>{$message}</p>
  {/if}
{/if}
{$startform}
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_propname}</p>
    <p class="pageinput">{$input_propname}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_propvalue}</p>
    <p class="pageinput">{$input_propvalue}</p>
  </div>
  <div class="pageoverflow">
    <p class="pageinput">{$hiddenparams}{$submit}</p>
  </div>
{$endform}
