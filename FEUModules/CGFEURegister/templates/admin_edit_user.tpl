<h3>{$mod->Lang('hdr_manage_user')}</h3>

{form_start uid=$user->id}
    <div class="c_full cf">
        <input type="submit" name="submit" value="{$mod->Lang('lbl_submit')}"/>
        <input type="submit" name="cancel" value="{$mod->Lang('lbl_cancel')}"/>
        <input type="submit" name="deleteuser" value="{$mod->Lang('lbl_delete')}"/>
        <input type="submit" name="pushuser" value="{$mod->Lang('lbl_pushlive')}"/>
        <input type="submit" name="newcode" value="{$mod->Lang('lbl_newcode')}"/>
    </div>
    <br/>

    {foreach $fields as $name => $field}
        {$required=''}{if $field->required==2}{$required='required'}{/if}
        {$pattern=''}{if !empty($field->extra.pattern)}{$pattern="pattern={$field->extra.pattern}"}{/if}
        {$placeholder=''}{if !empty($field->extra.placeholder)}{$placeholder="placeholder={$field->extra.placeholder}"}{/if}
        <div class="c_full cf {if $required}required{/if}">
            {if $field->type == 0}{* text *}
    	        <label for="prop_{$name}" class="grid_3">{$field->prompt}:</label>
    		<input id="prop_{$name}" type="text" class="grid_8" name="{$name}" value="{$user->get($name)}" {$required} {$pattern} {$placeholder} />
    	    {else if $field->type == 1}{* checkbox *}
    	        <label for="prop_{$name}" class="grid_3">{$field->prompt}:</label>
    		<span class="grid_8">
    		    <input type="hidden" name="{$name}" value="0"/>
    		    <input id="prop_{$name}" type="checkbox" class="grid_8" name="{$name}" value="1" {if $user->get($name)}checked{/if} {$required} />
    		</span>
    	    {else if $field->type == 2}{* email *}
    	        <label for="prop_{$name}" class="grid_3">{$field->prompt}:</label>
    		<input id="prop_{$name}" type="email" class="grid_8" name="{$name}" value="{$user->get($name)}" {$required} {$pattern} {$placeholder} />
    	    {else if $field->type == 3}{* textarea *}
    	        <label for="prop_{$name}" class="grid_3">{$field->prompt}:</label>
    		<textarea id="prop_{$name}" class="grid_8" name="{$name}" {$required}>{$user->get($name)}</textarea>
    	    {else if $field->type == 4}{* dropdown *}
    	        <label for="prop_{$name}" class="grid_3">{$field->prompt}:</label>
    		<select id="prop_{$name}" class="grid_8" name="{$name}" {$required}>
    		    {html_options options=$field->options selected=$user->get($name)}
    		</select>
    	    {else if $field->type == 5}{* multiselect *}
    	        <label for="prop_{$name}" class="grid_3">{$field->prompt}:</label>
    		<select id="prop_{$name}" class="grid_8" name="{$name}[]" multiple {$required}>
    		    {html_options options=$field->options selected=$user->get($name)}
    		</select>
    	    {else if $field->type == 7}{* radiobutns *}
    	        <label for="prop_{$name}" class="grid_3">{$field->prompt}:</label>
    		<span class="grid_8">
    		    {foreach $field->options as $val => $lbl}
		       <span class="radiobtn">
		           <input {if $lbl@first}id="prop_{$name}"{/if} type="radio" name="{$name}[]" value="{$val}" {if $user->get($name) == $val}checked{/if} {$required}>
			   <span>{$lbl}</span>
		       </span>
    		       {if !$lbl@last}<br/>{/if}
    		    {/foreach}
    		</span>
    	    {else if $field->type == 8}{* date *}
    	        <label class="grid_3">{$field->prompt}:</label>
		<span class="grid_8">
		    {html_select_date time=$user->get($name) start_year=$field->extra.start_year|default:1900 end_year=$field->extra.end_year|default:'+20' prefix="{$name}"}
	        </span>
            {else if $field->type == 10}{* tel *}
    	        <label for="prop_{$name}" class="grid_3">{$field->prompt}:</label>
    		<input id="prop_{$name}" type="text" class="grid_8" name="{$name}" value="{$user->get($name)}" {$required} {$pattern} {$placeholder} />
            {/if}
        </div>
    {/foreach}

{form_end}