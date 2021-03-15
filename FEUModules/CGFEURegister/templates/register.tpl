{if !empty($final_message)}

    <div class="alert alert-info">{$final_message}</div>
    {* could change our final message here *}
    {* could also do redirection here *}

{else}

    {if $error}<div class="alert alert-danger">{$error}</div>{/if}

<div id="registerform">
    <h2>Register</h2>
    <p><i class="fas fa-exclamation-circle"></i> Please be aware, that all form fields are required.</p>
    {form_start group=$group.groupname inline=$inline}{cge_form_csrf}
    {if !empty($properties)}
        {foreach $properties as $name => $property}
            {$required=''}{if $property->required==2}{$required='required'}{/if}
	    {$pattern=''}{if !empty($property->extra.pattern)}{$pattern="pattern={$property->extra.pattern}"}{/if}
	    {$placeholder=''}{if !empty($property->extra.placeholder)}{$placeholder="placeholder={$property->extra.placeholder}"}{/if}
            <div class="row {if $required}required{/if}">
            {if $property->type == -100}{* password *}
    	        <p><label for="prop_{$name}" class="col-sm-2">{$property->prompt}</label></p>
    		<input id="prop_{$name}" type="password" class="col-sm-10" name="{$name}" value="{$user->get($name)}" {$required} />
            {else if $property->type == 0}{* text *}
    	        <p><label for="prop_{$name}" class="col-sm-2">{$property->prompt}</label></p>
    		<input id="prop_{$name}" type="text" class="col-sm-10" name="{$name}" value="{$user->get($name)}" {$required} {$pattern} {$placeholder} />
    	    {else if $property->type == 1}{* checkbox *}
    	        <p><label for="prop_{$name}" class="col-sm-2">{$property->prompt}:</label></p>
    		<span class="col-sm-10">
    		    <input type="hidden" name="{$name}" value="0"/>
    		    <input id="prop_{$name}" type="checkbox" class="col-sm-10" name="{$name}" value="1" {if $user->get($name)}checked{/if} {$required} />
    		</span>
    	    {else if $property->type == 2}{* email *}
    	        <p><label for="prop_{$name}" class="col-sm-2">{$property->prompt}</label></p>
    		<input id="prop_{$name}" type="email" class="col-sm-10" name="{$name}" value="{$user->get($name)}" {$required} {$pattern} {$placeholder} />
    	    {else if $property->type == 3}{* textarea *}
    	        <p><label for="prop_{$name}" class="col-sm-2">{$property->prompt}:</label></p>
    		<textarea id="prop_{$name}" class="col-sm-10" name="{$name}" {$required}>{$user->get($name)}</textarea>
    	    {else if $property->type == 4}{* dropdown *}
    	        <p><label for="prop_{$name}" class="col-sm-2">{$property->prompt}:</label></p>
    		<select id="prop_{$name}" class="col-sm-10" name="{$name}" {$required}>
    		    {html_options options=$property->options selected=$user->get($name)}
    		</select>
    	    {else if $property->type == 5}{* multiselect *}
    	        <p><label for="prop_{$name}" class="col-sm-2">{$property->prompt}:</label></p>
    		<select id="prop_{$name}" class="col-sm-10" name="{$name}[]" multiple {$required}>
    		    {html_options options=$property->options selected=$user->get($name)}
    		</select>
    	    {else if $property->type == 7}{* radiobutns *}
    	        <p><label for="prop_{$name}" class="col-sm-2">{$property->prompt}:</label></p>
    		<span class="col-sm-10">
    		    {foreach $property->options as $val => $lbl}
		       <span class="radiobtn">
		           <input {if $lbl@first}id="prop_{$name}"{/if} type="radio" name="{$name}[]" value="{$val}" {if $user->get($name) == $val}checked{/if} {$required}>
			   <span>{$lbl}</span>
		       </span>
    		       {if !$lbl@last}<br/>{/if}
    		    {/foreach}
    		</span>
    	    {else if $property->type == 8}{* date *}
    	        <label class="col-sm-2">{$property->prompt}:</label>
		<span class="col-sm-10">
		    {html_select_date time=$user->get($name) start_year=$property->extra.start_year|default:1900 end_year=$property->extra.end_year|default:'+20' prefix="{$name}"}
	        </span>
            {else if $property->type == 10}{* tel *}
    	        <label for="prop_{$name}" class="col-sm-2">{$property->prompt}:</label>
    		<input id="prop_{$name}" type="text" class="col-sm-10" name="{$name}" value="{$user->get($name)}" {$required} {$pattern} {$placeholder} />
            {/if}
    	    </div>
        {/foreach}
    {/if}

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
        <input type="submit" class="submitbutton" name="{$actionid}submit" value="{$mod->Lang('register')}"/>
    </div>
    {form_end}
</div>
{/if}