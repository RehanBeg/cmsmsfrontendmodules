{* forgot password template *}

{if !empty($final_message)}
    <div class="alert alert-info">{$final_message}</div>
    {* we could also redirect here *}
{else}
    {if !empty($error)}
        <div class="alert alert-danger">{$error}</div>
    {/if}

    <div id="forgotpasswordbox">
        <h2>Reset password</h2>
        <p>We recommend to use a password manager to keep your credentials safe and available anytime.</p>
        {form_start}{cge_form_csrf}
        <div class="row">
            <div class="col-sm-2 text-right">
                <p>
                    {if $username_is_email}
                         {$mod->Lang('prompt_email')}
                    {else}
                         {$mod->Lang('prompt_username')}
                    {/if}
                </p>
            </div>
            <input class="col-sm-10" name="{$actionid}feu_username" type="{if $username_is_email}email{else}text{/if}" maxlength="{$max_unfldlen}" value="{$username}" required autocomplete="off"/>
        </div>

        {if isset($captcha)}
    	    <div class="row">
      	        <div class="col-sm-2 text-right">{$mod->Lang('captcha_title')}:</div>
                <div class="col-sm-10">{$captcha}
                    {if isset($input_captcha)}
		        <div class="row">
          	   	    <input type="text" name="{$actionid}feu_input_captcha" required autocomplete="off"/>
			</div>
		     {/if}
                </div>
            </div>
        {/if}

        <div class="row">
            <input class="col-sm-2 submitbutton" type="submit" name="{$actionid}feu_submit" value="{$mod->Lang('submit')}"/>
        </div>
    {form_end}
    </div>
{/if}
