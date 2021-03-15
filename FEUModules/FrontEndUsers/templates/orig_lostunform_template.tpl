{* lost username confirm template form *}
<h4>{$mod->Lang('title_lostusername')}</h4>
{if !empty($found_username)}

    <div class="alert">{$mod->Lang('lostunconfirm_premsg')}</div>
    <p><strong>{$mod->Lang('your_username_is')}</strong> <span>{$found_username}</span></p>
    <div class="alert">{$mod->Lang('lostunconfirm_postmsg')}</div>

{else}

    {if !empty($error)}<div class="alert alert-danger">{$error}</div>{/if}

    <div class="alert alert-info">{$mod->Lang('info_lostusername')}</div>
    {form_start feu_gid=$feu_gid}{cge_form_csrf}
        {foreach from=$controls item='entry'}
            <div class="row">
            	<div class="col-sm-4 text-right">{$entry->prompt}</div>
          	<div class="col-sm-8">
		    {* there will be no data(9) or image(6) fields here *}
	    	    {if $entry->type == '_password'}
	      	    	<input type="password" name="{$entry->fldname}" value="{$entry->val}" maxlength="{$entry->maxlength}"/>
	      		<br/>{$mod->Lang('info_lostun_pwfield')}
	    	    {else if $entry->type == 0}
	      	        {* text *}
	      		<input type="text" name="{$entry->fldname}" value="{$entry->val}" maxlength="{$entry->maxlength}" placholder="{$entr->extra.placeholder|default:''}" pattern="{$entry->extra.pattern|default:''}"/>
	      		<br/>{$mod->Lang('info_lostun_textfield')}
	            {elseif $entry->type == 1}
	      	        {* checkbox *}
	      		<input type="checkbox" name="{$entry->fldname}" value="1" {if $entry->val}checked{/if}/>
	            {elseif $entry->type == 2}
	      	        {* email *}
	      		<input type="email" name="{$entry->fldname}" value="{$entry->val}" maxlength="{$entry->maxlength}" placholder="{$entr->extra.placeholder|default:''}" pattern="{$entry->extra.pattern|default:''}"/>
	            {elseif $entry->type == 3}
	      	    	{* textarea *}
	      		<textarea name="{$entry->fldname}" rows="3" cols="50">{$entry->val}</textarea>
	      		<br/>{$mod->Lang('info_lostun_textarea')}
	            {elseif $entry->type == 4}
		        {* dropdown *}
	      		<select name="{$entry->fldname}">
	        	   <option value="">{$mod->Lang('donotknow')}</option>
			   {html_options options=$entry->options selected=$entry->val}
	                </select>
	    	    {elseif $entry->type == 5}
	      	        {* multiselect *}
	      		<select name="{$entry->fldname}[]" multiple size="{$entry->length}">
			    {html_options options=$entry->options selected=$entry->val}
	                </select>
	            {elseif $entry->type == 7}
	      	        {* radiobtns *}
	      		{foreach $entry->options as $key => $val}
	        	    <label><input type="radio" name="{$entry->fldname}" value="{$key}" {if $key == $entry->val}checked{/if}/> {$val}</label>
	        	    {if !$val@last}<br/>{/if}
	               {/foreach}
	    	   {elseif $entry->type == 8}
	      	       {* date *}
	      	       {html_select_date prefix=$entry->fldname start_year=$entry->start_year end_year=$entry->end_year time=$entry->val all_empty='--'}
	    	    {else if $entry->type == 10}
	      	        {* text *}
	      		<input type="tel" name="{$entry->fldname}" value="{$entry->val}" maxlength="{$entry->maxlength}" placholder="{$entr->extra.placeholder|default:''}" pattern="{$entry->extra.pattern|default:''}"/>
	      		<br/>{$mod->Lang('info_lostun_textfield')}
	           {/if}
	        </div>
            </div>
        {/foreach}

        {if isset($captcha)}
            <div class="row">
                <p class="col-sm-4 text-right">{$captcha_title}</p>
        	<div class="col-sm-8">{$captcha}
          	    {if $need_captcha_input}
          	        <div class="row col-sm-12">
            		    <input type="text" name="{$actionid}feu_input_captcha" size="10" required autocomplete="off"/>
                        </div>
                    {/if}
	        </div>
            </div>
        {/if}

        <div class="row">
            <div class="col-sm-4 text-right"></div>
      	    <div class="col-sm-8">
                <input type="submit" name="{$actionid}feu_submit" value="{$mod->Lang('submit')}"/>
            </div>
        </div>
    {form_end}
{/if}
