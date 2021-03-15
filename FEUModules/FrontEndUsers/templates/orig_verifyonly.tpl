{* original verification form *}
{if $final_msg}
   <div class="alert alert-info">{$final_msg}</div>
   {* could redirect here too *}
{else}
   {if $error}<div class="alert alert-danger">{$error}</div>{/if}

   <div class="alert alert-info">{$mod->Lang('info_verify_identity2')}</div>
   {form_start uid=$uid}{cge_form_csrf}
      <div class="row">
         <label>{$mod->Lang('code')}: <input type="text" class="form_control" name="{$actionid}code" value="{$code}" required/></label>
      </div>
      <div class="row">
         <button type="submit" name="{$actionid}feu_submit" class="btn btn_active">{$mod->Lang('verify')}</button>
      </div>
   {form_end}
{/if}
