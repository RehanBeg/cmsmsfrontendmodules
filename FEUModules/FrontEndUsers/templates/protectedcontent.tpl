{strip}
{if $feu_authorized == 0}
    {if $action == 'redirect'} 
      {if $feu_page == -1}
        {$mod->Lang('pagetype_unauthorized')}
      {else}
        {redirect_page page=$feu_page}
      {/if}
    {elseif $show_what == 'content_en'}
      {if $docaptcha == 1}
        {FrontEndUsers form=login}
      {else}
        {FrontEndUsers form=login nocaptcha=1}
      {/if}
    {/if}
{else}
   {$output|default:''}
{/if}
{/strip}