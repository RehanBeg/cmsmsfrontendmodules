<script>
$(function(){
    let input_type = $('[name=input_type]')
    let input_unique = $('#prop_unique')
    let propname = '{$propname}'
    input_type.change(function(ev){
        let curtype = $(this).val()
	let odis = input_unique.prop('disabled') // originally disabled
        $('.propfield').hide()
        let tclass = '.type_' + $(this).val()
	if( curtype != 0 && curtype != 3 && curtype != 2 ) {
	   // only text fields and textarea fields and email fields can be encrypted and unique
	   // email fields cannot be encrypted, but they can be unique.
	   input_unique.prop('disabled',true)
        } else {
	   if( !odis ) input_unique.removeAttr('disabled')
        }
	$(tclass).show()
    }).trigger('change')

})
</script>
{if $propname}
  <h3>{$mod->Lang('editprop',$propname)}</h3>
{else}
  <h3>{$mod->Lang('addprop')}</h3>
{/if}

{if !empty($error)}<div class="red">{$error}</div>{/if}

{form_start propname=$propname}
    <div class="c_full cf">
        <label class="grid_3">*{$mod->Lang('name')}:</label>
	<input class="grid_8" name="input_name" value="{$defn.name}" {if $propname}disabled{/if} required/>
    </div>
    <div class="c_full cf">
    	 <label class="grid_3">{$mod->Lang('prompt')}:</label>
    	 <input class="grid_8" name="input_prompt" value="{$defn.prompt}"/>
    </div>
    <div class="c_full cf">
    	 <label class="grid_3">{$mod->Lang('type')}:</label>
	 <select class="grid_8" name="input_type">
	     {html_options options=$fieldtypes selected=$defn.type}
	 </select>
    </div>
    <div id="propfields">
        <div class="c_full cf propfield type_0 type_2 type_10">
	    {* text field *}
	    <label class="grid_3">{$mod->Lang('maxlength')}:</label>
	    <input class="grid_2" type="number" name="input_maxlength" value="{$defn.maxlength}"/>
	</div>
	<div class="c_full cf propfield type_1">
	    {* checkbox field, input_attrib_checked *}
	    <label class="grid_3">{$mod->Lang('prompt_dflt_checked')}:</label>
	    <select name="input_attrib_checked" class="grid_2">{cge_yesno_options selected=$attribs.checked|default:0}</select>
	</div>
	<div class="c_full cf propfield type_3">
	    {* textarea: input_attrib_wysiwyg *}
	    <label class="grid_3">{$mod->Lang('prop_textarea_wysiwyg')}:</label>
	    <select name="input_textarea_wysiwyg" class="grid_2">{cge_yesno_options selected=$attribs.wysiwyg|default:0}</select>
	</div>
	<div class="c_full cf propfield type_4 type_5 type_7">
	    {* dropdown/multiselect: input_seloptions *}
	    <label class="grid_3">{$mod->Lang('seloptions')}:</label>
	    <textarea class="grid_8" name="input_seloptions" rows="5""">{$seloptions_text}</textarea>
	</div>
	<div class="propfield type_8">
	    {* date: input_attrib_startyear, input_attrib_endyear *}
	    <div class="c_full cf">
	        <label class="grid_3">{$mod->Lang('start_year')}:</label>
		<input class="grid_8" name="input_attrib_startyear" value="{$attribs.startyear|default:'-5'}"/>
	    </div>
	    <div class="c_full cf">
	        <label class="grid_3">{$mod->Lang('end_year')}:</label>
		<input class="grid_8" name="input_attrib_endyear" value="{$attribs.endyear|default:'+10'}"/>
	    </div>
	</div>
        <div class="c_full cf propfield type_0 type_10">
	    {* text field *}
	    <label class="grid_3">{$mod->Lang('pattern')}:</label>
	    <input class="grid_8" type="text" name="input_attrib_pattern" value="{$attribs.pattern|default:''}"/>
	</div>
        <div class="c_full cf propfield type_0 type_2 type_10">
	    {* text field *}
	    <label class="grid_3">{$mod->Lang('placeholder')}:</label>
	    <input class="grid_8" type="text" name="input_attrib_placeholder" value="{$attribs.placeholder|default:''}"/>
	</div>
    </div>

    <hr/>
    <div class="c_full cf">
        <label class="grid_3" for="prop_unique">{$mod->Lang('prompt_force_unique')}:</label>
        <select class="grid_2" id="prop_unique" name="input_force_unique" {if $propname}disabled data-disabled=1{/if}>
            {cge_yesno_options selected=$defn.force_unique}
        </select>
    </div>
    <div class="c_full cf">
        <input type="submit" name="submit" value="{$mod->Lang('submit')}"/>
        <input type="submit" name="cancel" value="{$mod->Lang('cancel')}" formnovalidate/>
    </div>
{form_end}
