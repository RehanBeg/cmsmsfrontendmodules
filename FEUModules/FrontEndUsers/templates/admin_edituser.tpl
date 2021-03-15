<script>
$(function(){
   $('button').button()
   $('#anonimize').on('click', function( ev ) {
       ev.preventDefault();
       var url = $(this).data('url');
       cms_confirm( '{$mod->Lang('confirm_anonimize')}' ).done( function() {
           window.location.href = url;
       })
   });
})
</script>

{if $user->id}
<h3>{$mod->Lang('edituser')}</h3>
{else}
<h3>{$mod->Lang('adduser')}</h3>
{/if}

{* password is readonly for non standard accounts, but required for new, standard accounts *}
{$pwreadonly=''}
{if $user->nonstd}{$pwreadonly='readonly'}{/if}
{$pwrequired=''}
{if !$pwreadonly && $user->id < 1}{$pwrequired='required'}{/if}

{form_start user_id=$user->id}
<div class="c_full cf">
    <input type="submit" name="{$actionid}submit" value="{$mod->Lang('next')}"/>
    <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}" formnovalidate/>
    {if $user->id > 0}
    <button id="anonimize" data-url="{cms_action_url action=admin_anonimize_user uid=$user->id}">{$mod->Lang('anonimize')}</button>
    {*<button id="editanyway" name="{$actionid}editanyway" formnovalidate>{$mod->Lang('continue_nochun')}</button>*}
    {/if}
</div>
<br/>

<div class="c_full cf">
   <label class="grid_4 text-right">*{$prompt_username}:</label>
   <p class="grid_8">
     <input type="text" name="{$actionid}username" value="{$user->new_username}" size="{$unfldlen}" maxlength="{$max_unfldlen}" autocomplete="new-password" required/>
   </p>
</div>
<div class="c_full cf">
   <label class="grid_4 text-right">{if $pwrequired}*{/if}{$mod->Lang('password')}:</label>
   <p class="grid_8">
     <input type="password" name="{$actionid}password" value="{$user->new_password}" size="{$pwfldlen}" maxlength="{$max_pwfldlen}" {$pwreadonly}{$pwrequired} autocomplete="new-password"/>
     {if $user->id > 0}{$mod->Lang('info_admin_password')}{/if}
   </p>
</div>
<div class="c_full cf">
   <label class="grid_4 text-right">{if $pwrequired}*{/if}{$mod->Lang('repeatpassword')}:</label>
   <p class="grid_8">
     <input type="password" name="{$actionid}repeatpassword" value="{$user->repeat_password}" size="{$pwfldlen}" maxlength="{$max_pwfldlen}" {$pwreadonly}{$pwrequired} autocomplate="new-password"/>
     {if $user->id > 0}{$mod->Lang('info_admin_repeatpassword')}{/if}
   </p>
</div>
<div class="c_full cf">
   <label class="grid_4 text-right"><span style="color: red;">!!</span>&nbsp; {$mod->Lang('prompt_disabled')}:</label>
   <p class="grid_8">
     {cge_yesno_options prefix=$actionid name=disabled selected=$user->disabled}
   </p>
</div>

{if !$user->nonstd}
    <div class="c_full cf">
        <label class="grid_4 text-right">{$mod->Lang('prompt_force_chsettings')}:</label>
        <p class="grid_8">
            {cge_yesno_options prefix=$actionid name=force_chsettings selected=$user->force_chsettings}
        </p>
    </div>
    <div class="c_full cf">
        <label class="grid_4 text-right">{$mod->Lang('prompt_force_newpw')}:</label>
        <p class="grid_8">
            {cge_yesno_options prefix=$actionid name=force_newpw selected=$user->force_newpw}
        </p>
    </div>

    {if $user->id > 0}
        <div class="c_full cf">
            <label class="grid_4 text-right"><span style="color: orange;">**</span>&nbsp; {$mod->Lang('prompt_force_revalidate2')}:</label>
            <p class="grid_8">
                {cge_yesno_options prefix=$actionid name=must_validate selected=$user->must_validate}
                {if $user->verify_code}<span style="color: orange;">{$mod->Lang('info_hasverifycode')}{/if}
            </p>
        </div>
    {/if}
{/if}

<div class="c_full cf">
   <label class="grid_4 text-right">{$mod->Lang('expires')}:</label>
   <p class="grid_8">
     {$y=date('Y',$user->expires)}
     {html_select_date prefix="{$actionid}expires" time="{$user->expires}" start_year=2000 end_year=2100}
   </p>
</div>

<div class="warning">{$mod->Lang('warn_strongpassword')}</div>
{if $user->nonstd}
    <div class="warning">{$mod->Lang('warn_nonstduser')}</div>
{/if}

{if $groups}
<table class="pagetable">
  <thead>
    <tr>
      <th>{$mod->Lang('id')}</th>
      <th>{$mod->Lang('name')}</th>
      <th>{$mod->Lang('description')}</th>
      <th class="pageicon"></th>
    </tr>
  </thead>
  <tbody>
  {foreach $groups as $group}
    {$checked=0}
    {if $user->id > 0 && $user->memberof($group.id)}
      {$checked=1}
    {elseif $user->id < 1 && $default_group == $group.id}
      {$checked=1}
    {/if}
    <tr class="{cycle values='row1,row2'}">
       <td>{$group.id}</td>
       <td>{$group.groupname}</td>
       <td>{$group.groupdesc}</td>
       <td>
          <input type="checkbox" name="{$actionid}memberof[]" value="{$group.id}" {if $checked}checked{/if}/>
       </td>
    </tr>
  {/foreach}
  </tbody>
</table>
{/if}
{form_end}
