{if !count($users)}
    <div class="information">{$mod->Lang('msg_nousers')}</div>
{else}
    <table class="pagetable">
        <thead>
	    <tr>
	        <th>{$mod->Lang('lbl_username')}</th>
	        <th>{$mod->Lang('lbl_created')}</th>
	        <th>{$mod->Lang('lbl_expired')}</th>
		<th class="pageicon"></th>
	    </tr>
	</thead>
	<tbody>
	    {foreach $users as $user}
	        {cms_action_url action=admin_edit_user uid=$user->id assign='edit_url'}
	        <tr class="{cycle values='row1,row2'}">
		    <td><a href="{$edit_url}" title="{$mod->Lang('lbl_edit')}">{$user->username}</a></td>
		    <td>{$user->created|date_format:'%x %H:%M'}</td>
		    <td>TODO</td>
		    <td><a href="{$edit_url}">{admin_icon icon='edit.gif' title=$mod->Lang('lbl_edit')}</a></td>
		</tr>
	    {/foreach}
	</tbody>
    </table>
{/if}