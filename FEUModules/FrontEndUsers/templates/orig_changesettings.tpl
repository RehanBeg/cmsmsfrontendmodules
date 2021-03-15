<!-- change settings template -->
<div id="feu_changesettingsform">
    <h4>{$mod->Lang('user_settings')}</h4>

    {if !empty($final_message)}
        <div class="alert alert-info">{$final_message}</div>
	{* we could also redirect somewhere from here *}
    {elseif !empty($error)}
        {* some kind of form message occurred *}
        <div class="alert alert-danger">{$error}</div>
    {/if}

    {form_start}{cge_form_csrf}
        {if !empty($controls)}
  	{foreach $controls as $key=>$field}
	    {* there will be no data(9) fields here *}
            <div class="row">
	        <label for="{$field->input_id}" class="col-sm-3 text-right" style="color: {$field->color|default:'inherit'}">{$field->marker|default:''} {$field->prompt}:</label>
                <div class="col-sm-9">
        	    {$field->hidden|default:''}
        	    {if isset($field->hidden)}{$field->hidden}{/if}

		    {* build the field itself *}
		    {if $field->type == '0'} {* text *}
	  	    	<input type="text" id="{$field->input_id}" class="form-control" name="{$field->input_name}" maxlength="{$field->maxlength}" value="{$field->value}" {if $field->readonly}readonly{/if} placeholder="{$field->placeholder}" {if !empty($field->pattern)}pattern="{$field->pattern}"{/if} {if $field->required}required{/if}/>
		    {elseif $field->type == 'password'} {* text *}
	  	    	<input type="password" id="{$field->input_id}" class="form-control" name="{$field->input_name}" maxlength="{$field->maxlength}" value="{$field->value}" {if $field->readonly}readonly{/if} {if $field->required}required{/if}/>
		    {elseif $field->type == 2} {* email *}
	  	    	<input type="email" id="{$field->input_id}" class="form-control" name="{$field->input_name}" maxlength="{$field->maxlength}" value="{$field->value}" {if $field->readonly}readonly{/if} placeholder="{$field->placeholder}" {if $field->required}required{/if}/>
		    {elseif $field->type == 3} {* textarea *}
          	    	{cge_textarea id=$field->input_id wysiwyg=$field->wysiwyg name=$field->input_name content=$field->value class="form-control"}
		    {elseif $field->type == 1} {* checkbox *}
	  	        <input type="hidden" name="{$field->input_name}" value="0"/>
	  		<input type="checkbox" id="{$field->input_id}" class="checkbox" name="{$field->input_name}" value="1" {if $field->value}checked{/if}/>
	            {elseif $field->type == 4} {* dropdown *}
	   	    	<select id="{$field->input_id}" class="form-control" name="{$field->input_name}" {if $field->readonly}readonly{/if} {if $field->required}required{/if}>
	      		    {html_options options=$field->options selected=$field->value}
	   		</select>
		    {elseif $field->type == 5} {* multiselect *}
	   	        <select id="{$field->input_id}" class="form-control" name="{$field->input_name}[]" {if $field->readonly}readonly{/if}  {if $field->required}required{/if} multiple>
	      		    {html_options options=$field->options selected=$field->selected}
	                </select>
		    {elseif $field->type == 7} {* radio group *}
	   	        {foreach $field->options as $key => $val}
	      		    <label><input type="radio" class="form-control" name="{$field->input_name}" value="{$key}" {if $key==$field->value}checked="checked"{/if} {if $field->required}required{/if}>
			        {$val}
			    </label>
	   		{/foreach}
		    {elseif $field->type == 6} {* image *}
	   	        {if isset($field->image_url) && $field->image_url}<img src="{$field->image_url}" alt="{$field->image_url}" width="100" height="100"/>{/if}
	   		{if isset($field->prompt2) && $field->prompt2}
			    <label><input type="checkbox" class="checkbox" name="{$field->input_name2}" value="clear"/> {$field->prompt2}</label>
			{/if}
	   		<input type="hidden" name="{$field->input_name}" value="{$field->value}"/>
 	   		<input type="file" id="{$field->input_id}" class="form-control" name="{$field->input_name}" {if $field->readonly}readonly{/if}/>
		    {elseif $field->type == 8} {* date *}
	   	        {$sy=$field->start_year|default:'-5'}
	   		{$ey=$field->end_year|default:'+10'}
	   		{html_select_date prefix=$field->input_name start_year=$sy end_year=$ey time=$field->value}
		    {elseif $field->type == 10} {* phone *}
	  	    	<input type="tel" id="{$field->input_id}" class="form-control" name="{$field->input_name}" maxlength="{$field->maxlength}" value="{$field->value}" {if $field->readonly}readonly{/if} placeholder="{$field->placeholder}" {if !empty($field->pattern)}pattern="{$field->pattern}"{/if} {if $field->required}required{/if}/>
	            {/if}
                    {$field->addtext|default:''}
      		</div>
    	    </div>
  	{/foreach}
        {/if}

  	<div class="row">
    	    <div class="col-sm-3"></div>
    	    <div class="col-sm-9">
      	    	<button type="submit" class="btn btn_active" name="{$actionid}submit">{$mod->Lang('submit')}</button>
            </div>
        </div>
    {form_end}
</div>
