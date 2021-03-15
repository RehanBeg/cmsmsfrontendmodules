{* forgot password verification template *}

{if $final_msg}
   <div class="alert alert-info">{$final_msg}</div>
   {* we could redirect here too *}
{else}
  {if !empty($error) }<div class="alert alert-danger">{$error}</div>{/if}

<div id="createnewpasswordbox">
  <h2>Reset password</h2>
  {form_start uid=$uid}{cge_form_csrf}
  <div class="row">
    <p><label class="col-sm-2">{$mod->Lang('prompt_username')}</label></p>
      <input type="{if $username_is_email}email{else}text{/if}" name="{$actionid}username" maxlength="{$max_unfldlen}" value="{$username}" disabled/>

    <p><label class="col-sm-2">{$mod->Lang('prompt_code')}</label></p>
      <input type="text" name="{$actionid}code" value="{$code}" maxlength="40" required />

    <p><label class="col-sm-2">{$mod->Lang('prompt_password')}</label></p>
      <input type="password" name="{$actionid}password1" value="{$password1}" maxlength="{$max_pwfldlen}" required/> 

    <p><label class="col-sm-2">{$mod->Lang('repeatpassword')}</label></p>
      <input type="password" name="{$actionid}password2" value="{$password2}" maxlength="{$max_pwfldlen}" required/> 
  </div>

  <div class="row">
      <input type="submit" class="submitbutton" name="{$actionid}feu_submit" value="{$mod->Lang('submit')}"/>
  </div>
  {form_end}
</div>

{/if}