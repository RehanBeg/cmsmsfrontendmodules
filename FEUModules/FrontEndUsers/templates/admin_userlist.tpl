<style scoped>
#quickfind_dlg {
   width: 500px;
   height: 10em;
}
.unsafepassword {
   color: red;
}
.user_disabled:before {
   content: "!! ";
   color: red;
}
.user_mustvalidate:before {
   content: "** ";
   color: magenta;
}
.user_expired:before {
   content: "-- ";
   color: orange;
}

</style>
<script>
$(function(){
  $('#feu_filterbox').click(function(){
    if( this.checked ) {
      $('#feu_filterform').show();
    }
    else {
      $('#feu_filterform').hide();
    }
  })

  $('a.do_deluser').click(function(ev){
     ev.preventDefault();
     let url = $(this).prop('href')
     cms_confirm('{$mod->Lang('confirm_delete_user')}').then(function(){
        window.location.href = url
     })
  })

  $('#dobulk').click(function(ev){
     var len = $('input.bulkselect:checked').length;
     if( len == 0 ) {
        ev.preventDefault();
	cms_alert('{$mod->Lang('bulk_selectone'|cms_escape)}');
     }
  })

  $('#pagesel').change(function(ev){
     $(this).closest('form').submit();
  })

  $('#quickfind_form').submit(function(ev){
     ev.preventDefault();
     var id = $('#quickfind_dlg').data('sel_id');
     var url = '{cms_action_url action=admin_edituser user_id=xxxx forjs=1}';
     url = url.replace('xxxx',id);
     window.location.href = url;
  })
  $('#quickfind_fld').autocomplete({
      minLength: 2,
      appendTo: '#quickfind_dlg',
      source: function( request, response ) {
          $.ajax({
	      url: '{cms_action_url action=admin_ajax_quickfind forjs=1}',
	      data: {
	          term: request.term,
              },
	      success: function( data ) {
	          response( data );
              }
          })
      },
      select: function( event, ui ) {
          $('#quickfind_fld').val( ui.item.label );
          $('#quickfind_dlg').data('sel_id', ui.item.value);
	  return false;
      }
  });
  $('#quickfind').click(function(){
     $('#quickfind_dlg').dialog({
        width: '500',
	height: '150',
        modal: true,
     });
  })
});

function select_all()
{
  cb = document.getElementsByName('{$actionid}selected[]');
  el = document.getElementById('selectall');
  st = el.checked;
  for( i = 0; i < cb.length; i++ ) {
    if( cb[i].type == "checkbox" )  cb[i].checked=st;
  }
}

function confirm_delete()
{
  var cb = document.getElementsByName('{$actionid}selected[]');
  var count = 0;
  for( i = 0; i < cb.length; i++ ) {
     if( cb[i].checked ) count++;
  }

  if( count > 250 ) {
     alert('{$mod->Lang('error_toomanyselected')}'|cms_escape);
     return false;
  }
  return confirm('{$mod->Lang('confirm_delete_selected')}');
}
</script>

<div id="quickfind_dlg" title="{$mod->Lang('quickfind_user')}" style="display: none;">
    {form_start id=quickfind_form}
    <div class="pageoverflow">
        <label class="pagetext">{$mod->Lang('quickfind_idname')}</label>
        <input class="pageinput" id="quickfind_fld" placeholder="{$mod->Lang('quickfind_ph')}" size="60"/>
    </div>
    <div class="pageoverflow">
        <input class="pageinput" type="submit" value="{$mod->Lang('find')}"/>
    </div>
    {form_end}
</div>

{form_start}
<fieldset id="feu_filterform" style="display: none;">
    <legend>{$mod->Lang('filter')}:</legend>
    <div class="c_full cf">
        <div class="grid_6">
           {if isset($groups)}
               <div class="c_full cf">
                   <p class="grid_4">{$mod->Lang('group')}:</p>
                   <p class="grid_8">
                       <select class="grid_12" name="{$actionid}filter_group">
                           {html_options options=$groups selected=$filter.group}
                       </select>
                   </p>
               </div>
           {/if}
           <div class="c_full cf">
               <p class="grid_4">{$mod->Lang('userfilter')}:</p>
               <p class="grid_8">
                   <input class="grid_12" type="text" name="{$actionid}filter_regex" value="{$filter.regex}"/>
               </p>
           </div>
           <div class="c_full cf">
               <p class="grid_4">{$mod->Lang('propertyfilter')}:</p>
               <p class="grid_8">
                   <select class="grid_12" name="{$actionid}filter_propertysel">{html_options options=$defnlist selected=$filter.propsel}</select>
               </p>
           </div>
           <div class="c_full cf">
               <p class="grid_4">{$mod->Lang('propregex')}:</p>
               <div class="grid_8">
                   <input class="grid_12" type="text" name="{$actionid}filter_property" value="{$filter.propval}" size="30"/>
		   <p class="grid_12">{$mod->Lang('info_propregex')}</p>
               </div>
           </div>
           <div class="c_full cf">
               <p class="grid_4">{$mod->Lang('prompt_loggedinonly')}:</p>
               <p class="grid_8">
                   {cge_yesno_options prefix=$actionid name='filter_loggedinonly' selected=$filter.loggedinonly}
               </p>
           </div>
           <div class="c_full cf">
               <p class="grid_4">{$mod->Lang('prompt_disabledstatus')}:</p>
               <p class="grid_8">
	           {$opts=[''=>$mod->Lang('any'), 'dis'=>$mod->Lang('disabled'), 'en'=>$mod->Lang('enabled')] }
		   <select name="{$actionid}filter_disabled">
		       {html_options options=$opts selected=$filter.disabledstatus}
		   </select>
               </p>
           </div>
       </div>

       <div class="grid_6">
           <div class="c_full cf">
               <p class="grid_3">{$mod->Lang('prompt_viewprops')}:</p>
               <select class="grid_9" name="{$actionid}filter_viewprops[]" multiple="multiple" size="5">
                   {html_options options=$defnlist selected=$viewprops}
               </select>
           </div>
           <div class="c_full cf">
               <p class="grid_3">{$mod->Lang('sortby')}:</p>
               <select class="grid_9" name="{$actionid}filter_sortby">{html_options options=$sortlist selected=$filter.sortby}</select>
           </div>
           <div class="c_full cf">
               <p class="grid_3">{$mod->Lang('userlimit')}:</p>
               <select class="grid_9" name="{$actionid}filter_limit">{html_options options=$limits selected=$filter.limit}</select>
           </div>
       </div>
   </div>
   <div class="c_full cf grid_12">
       <input type="submit" name="{$actionid}filter" value="{$mod->Lang('applyfilter')}"/>
       <input type="submit" name="{$actionid}filter_reset" value="{$mod->Lang('reset')}"/>
   </div>
</fieldset>{* #feu_filterform *}
{form_end}

<div class="c_full cf">
    <div class="grid_10" style="margin-left: 0;">
        <input id="feu_filterbox" type="checkbox" value="1"/><label for="feu_filterbox">{$mod->Lang('view_filter')} {if $filter_applied}<span style="color: green;">({$mod->Lang('applied')}){/if}</span></label>&nbsp;
        <span title="{$mod->Lang('usersmatching')}">{cgimage image='users.gif' alt=""} = {$users->total}</span>&nbsp;
        {if isset($add_url)}
	    <a href="{$add_url}" title="{$mod->Lang('title_add_user')}">{admin_icon icon='newobject.gif'} {$mod->Lang('adduser')}</a>
	{/if}
        {if isset($import_url)}
	    <a href="{$import_url}" title="{$mod->Lang('title_import_users')}">{admin_icon icon='import.gif'} {$mod->Lang('prompt_importusers')}</a>
	{/if}
        {if isset($export_url)}
	    <a href="{$export_url}" title="{$mod->Lang('title_export_users')}">{admin_icon icon='export.gif'} {$mod->Lang('prompt_exportusers')}</a>
	{/if}
        <a id="quickfind" title="{$mod->Lang('quickfind_user')}">{admin_icon icon='view.gif'} {$mod->Lang('quickfind_user')}</a>
    </div>

    {if count($users) && $users->pagecount > 1}
        <div class="grid_2 text-right">
	    {form_start}
	        {$mod->Lang('page')}
		{$tmp=$users->pageList()}
		<select name="page" id="pagesel">
		   {html_options values=$tmp output=$tmp selected=$users->page}
		</select>
	    {form_end}
        </div>
    {/if}
</div>
{if !isset($groups)}

    <div class="red center">{$mod->Lang('nogroups')}</div>

{elseif count($users) > 0}

    {form_start}
    <table class="pagetable">
	<thead>
		<tr>
			<th>{$usernametext}</th>
			<th>{$mod->Lang('created')}</th>
			<th>{$mod->Lang('expires')}</th>
                        {if isset($viewprops) && is_array($viewprops)}
                        {foreach $viewprops as $one}
                        <th>{$alldefns[$one].prompt}</th>
                        {/foreach}
                        {/if}
			<th class="pageicon {literal}{sorter: false}{/literal}">&nbsp;</th>
			<th class="pageicon {literal}{sorter: false}{/literal}">&nbsp;</th>
			<th class="pageicon {literal}{sorter: false}{/literal}">&nbsp;</th>
			<th class="pageicon {literal}{sorter: false}{/literal}">&nbsp;</th>
			<th class="pageicon {literal}{sorter: false}{/literal}">&nbsp;</th>
			<th class="pageicon {literal}{sorter: false}{/literal}"><input id="selectall" type="checkbox" name="junk" onclick="select_all();"/></th>
		</tr>
	</thead>
	<tbody>
            {foreach $users as $user}
                {cms_action_url action=admin_edituser user_id=$user->id assign='edit_url'}
                <tr class="{cycle values='row1,row2'}">
	  	    <td>
			  {$tmplink=$user->username}
                          {if $mod->have_permission('editusers')}
			      {capture assign='tmplink'}<a href="{$edit_url}" title="{$mod->Lang('edit')}">{$user->username}</a>{/capture}
                          {/if}
			  {if strlen($user->password) == 32}<span class="unsafepassword" title="{$mod->Lang('info_unsafepassword')}">{$mod->Lang('unsafe')}</span>{/if}
			  {if $user->disabled}<span class="user_disabled" title="{$mod->Lang('info_disabled')}">{$tmplink}</span>
			  {else if $user->must_validate}
			     <span class="user_mustvalidate" title="{$mod->Lang('info_must_validate2')}">{$tmplink}</span>
			  {elseif $user->expires_ts < $smarty.now}
			     <span class="user_expired" title="{$mod->Lang('info_expired')}">{$tmplink}</span>
			  {else}
			     {$tmplink}
			  {/if}
			</td>
			<td>{$user->createdate_ts|date_format:'%x'}</td>
			<td>
			  {if $user->expires_ts < $smarty.now}
			     <span style="color: orange;" title="{$mod->Lang('info_expired')}">{$user->expires_ts|date_format:'%x'}</span>
			  {else}
  			     {$user->expires_ts|date_format:'%x'}
			  {/if}
			</td>
                        {if !empty($viewprops)}
                            {foreach $viewprops as $one}
                                <td>
				    {if $alldefns[$one].type == 8}
				        {$user->get_property($one)|date_format:'%x'}
				    {elseif $alldefns[$one].type == 4 || $alldefns[$one].type == 7}
				        {$v=$user->get_property($one)}
					{$alldefns[$one].options[$v]}
				    {else}
				        {$user->get_property($one)}
				    {/if}
				</td>
                            {/foreach}
                        {/if}
			<td>
			  {if $user->disabled}
			      <a href="{module_action_url action=admin_enable_user uid=$user->id state=1}">{cgimage image='icons/system/false.gif' alt=$mod->Lang('enable_user')}</a>
			  {else}
			      <a href="{module_action_url action=admin_enable_user uid=$user->id state=0}">{cgimage image='icons/system/true.gif' alt=$mod->Lang('disable_user')}</a>
			  {/if}
			</td>
			<td>{if $mod->have_permission('editusers') && $user->loggedin && !$user->nonstd}
			        <a href="{cms_action_url action=admin_logout user_id=$user->id}" title="{$mod->Lang('prompt_logout')}">{admin_icon icon='back.gif'}</a>
			    {/if}
			</td>
			<td>{if $mod->have_permission('listusers') && !$user->nonstd}
			        <a href="{cms_action_url action=admin_userhistory user_id=$user->id}" title="{$mod->Lang('history')}">{admin_icon icon='info.gif'}</a>
			    {/if}
			</td>
			<td>{if $mod->have_permission('editusers')}
			        <a href="{$edit_url}" title="{$mod->Lang('edit')}">{admin_icon icon='edit.gif'}</a>
			    {/if}
			</td>
			<td>{if $mod->have_permission('editusers')}
			        <a class="do_deluser" href="{cms_action_url action=do_deleteuser user_id=$user->id}" title="{$mod->Lang('delete')}">{admin_icon icon='delete.gif'}</a>
			    {/if}
			</td>
			<td><input type="checkbox" class="bulkselect" name="{$actionid}selected[]" value="{$user->id}"/></td>
		</tr>
            {/foreach}
	</tbody>
    </table>

    {if !empty($bulk_actions)}
    <div class="c_full cf text-right">
        <label>{$mod->Lang('with_selected')}:
            <select name="{$actionid}bulk_action">
 	        <option value="">{$mod->Lang('none')}</option>
	        {html_options options=$bulk_actions}
	    </select>
        </label>
        <button type="submit" id="dobulk" name="{$actionid}dobulk">{$mod->Lang('submit')}</button>
    </div>
    {/if}
    {form_end}

{/if}
