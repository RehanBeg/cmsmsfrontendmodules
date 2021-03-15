{if !empty($final_message)}

    <div class="alert alert-info">{$final_message}</div>
    {* could change our final message here *}
    {* could also do redirection here *}

{else}

    <div class="alert alert-info">{$mod->Lang('info_repeatcode')}</div>

    {if $error}<div class="alert alert-danger">{$error}</div>{/if}

    {form_start inline=$inline}{cge_form_csrf}
        <div class="row">
	    <label for="username" class="col-sm-6">{$mod->Lang('prompt_usernameemail')}</label>
	    <input id="username" class="col-sm-6" type="{$input_type}" value="{$username}" name="{$actionid}username" required autocomplete="off"/>
	</div>

        {* optional captcha *}
        {if $captcha}
            <div class="captcha">
	        <div class="row">{$captcha}</div>
		{if $captcha_input_name}
	            <div class="col-sm-6">{$mod->Lang('prompt_captcha')}</div>
	            <div class="col-sm-6">
                        <input type="text" class="col-sm-6" name="{$captcha_input_name}" autocomplete="off"/>
	            </div>
                {/if}
	    </div>
        {/if}

        <div class="row">
            <input type="submit" value="{$mod->Lang('sendcode')}"/>
        </div>
    {form_end}

{/if}