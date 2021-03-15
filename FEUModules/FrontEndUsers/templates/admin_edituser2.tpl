{if $user->id > 0 }
<h3>{$mod->Lang('edituser')} {$user->username} / {$user->id}</h3>
{else}
<h3>{$mod->Lang('adduser')}</h3>
{/if}

{form_start}
<div class="c_full cf">
    <input type="submit" name="{$actionid}back" value="{$mod->Lang('back')}" formnovalidate/>
    <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
    <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}" formnovalidate/>
</div>
<br/>

{foreach $fields as $field}
  {$fldid="fld_{$field->name}"}
  {$pattern=''}{if $field->pattern}{$pattern="pattern=\"{$field->pattern}\""}{/if}
  <div class="c_full cf" id="cont_{$field->name}">
     <label class="grid_3" {if $field->color}style="color: {$field->color}"{/if}>{$field->marker}{$field->prompt}:</label>
     {if $field->type == 0}
        {* text field *}
	<input class="grid_8" type="text" id="{$fldid}" name="{$actionid}prop_{$field->name}" value="{$field->value}" maxlen="{$field->maxlen}" {if $field->required}required{/if} placeholder="{$field->placeholder|default:''}" {$pattern} />
     {elseif $field->type == 1}
        {* checkbox *}
	<div class="grid_8">
	    <input type="hidden" name="{$actionid}prop_{$field->name}" value="0"/>
	    <input type="checkbox" id="{$fldid}" name="{$actionid}prop_{$field->name}" value="1" {if $field->value}checked{/if}/>
	</div>
     {elseif $field->type == 2}
        {* email *}
	<input class="grid_8" type="email" id="{$fldid}" name="{$actionid}prop_{$field->name}" value="{$field->value}" maxlen="{$field->maxlen}" {if $field->required}required{/if} placeholder="{$field->placeholder|default:''}"/>
     {elseif $field->type == 3}
        {* textarea *}
        {cge_textarea class="grid_8" id=$fldid name="{$actionid}prop_{$field->name}" value=$field->value wysiwyg=$field->wysiwyg}
     {elseif $field->type == 4}
        {* dropdown *}
	<select class="grid_8" id="{$fldid}" name="{$actionid}prop_{$field->name}" {if $field->required}required{/if}>
	  {html_options options=$field->options selected=$field->value}
	</select>
     {elseif $field->type == 5}
        {* multiselect *}
	{$tmp=count($field->options)}{if $tmp > 8}{$tmp=8}{/if}
	<input type="hidden" name="{$actionid}prop_{$field->name}" value=""/>
	<select class="grid_8" id="{$fldid}" name="{$actionid}prop_{$field->name}[]" size="{$tmp}" multiple>
	  {html_options options=$field->options selected=$field->value}<br/>
	</select>
     {elseif $field->type == 6}
        {* image *}
        <div class="grid_8">
  	    {$tmp=$field->image_url}
	    {if $tmp}
	        <img src="{$tmp}" width="100" alt="{$field->value}"/>
                <label>
	            <input type="checkbox" name="{$actionid}propdel_{$field->name}" value="1"/>
	            {$mod->Lang('prompt_clear')}
	        </label>
	        <br/>
	    {/if}
	    <input type="hidden" name="{$actionid}prop_{$field->name}" value="**FILE**"/>
	    <input type="file" name="{$actionid}prop_{$field->name}"/>
	</div>
     {elseif $field->type == 7}
        {* radiobuttons *}
	<div class="grid_8">
	    {foreach $field->options as $key => $val}
	        <label><input type="radio" name="{$actionid}prop_{$field->name}" value="{$key}" {if $key == $field->value}checked{/if}/> {$val}</label>
		{if !$val@last}<br/>{/if}
	    {/foreach}
	</div>
     {elseif $field->type == 8}
        {* date *}
	<div class="grid_8">
	    {$tmp="{$actionid}prop_{$field->name}"}
	    {$sy=$field->startyear|default:1900}
	    {$ey=$field->endyear|default:2050}
	    {html_select_date prefix=$tmp time=$field->value start_year=$sy end_year=$ey}
	</div>
     {elseif $field->type == 10}
        {* phone *}
	<input class="grid_8" type="tel" id="{$fldid}" name="{$actionid}prop_{$field->name}" value="{$field->value}" maxlen="{$field->maxlen}"
	    {if $field->required}required{/if} "{$pattern}" placeholder="{$field->placeholder}"
	/>
     {/if}
  </div>
{/foreach}

<br/>
<div class="c_full cf">
    <input type="submit" name="{$actionid}back" value="{$mod->Lang('back')}" formnovalidate/>
    <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
    <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}" formnovalidate/>
</div>
{form_end}