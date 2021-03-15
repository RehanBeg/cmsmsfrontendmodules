{if $gid > 0}
   <h3>{$mod->Lang('editgroup')}</h3>
{else}
   <h3>{$mod->Lang('addgroup')}</h3>
{/if}

{if isset($error) }
    <div class="red">{$error}</div>
{else if isset($message) }
    <div class="information">{$message}<div>
{/if}

{form_start group_id=$gid}
<div class="c_full cf">
  <label for="gname" class="grid_2">{$mod->Lang('name')}:</label>
  <input id="gname" class="grid_9" name="{$actionid}input_groupname" value="{$groupname}" required/>
</div>
<div class="c_full cf">
  <label for="gdesc" class="grid_2">{$mod->Lang('description')}</label>
  <input id="gdesc" class="grid_9" name="{$actionid}input_groupdesc" value="{$groupdesc}"/>
</div>

{if $propcount > 0}
<br/>
<div class="pageoverflow">
<table class="pagetable">
  <thead>
    <tr>
      <th>{$mod->Lang('name')}</th>
      <th>{$mod->Lang('prompt')}</th>
      <th>{$mod->Lang('type')}</th>
      <th>{$mod->Lang('status')}</th>
      <th class="pageicon"></th>
      <th class="pageicon"></th>
    </tr>
  </thead>
  <tbody>
  {foreach $props as $prope}
    <tr class="{cycle values='row1,row2'}"/>
      <td>{$prope->hidden}{$prope->name}</td>
      <td>{$prope->prompt}</td>
      <td>{$prope->type}</td>
      <td>{$prope->required}</td>
      <td>
        {if isset($prope->moveup_idx)}
          <button name="{$actionid}moveup" title="{$mod->Lang('move_up')}" value="{$prope->moveup_idx}" formnovalidate>{$img_up}</button>
        {/if}
      </td>
      <td>
        {if isset($prope->movedown_idx)}
          <button name="{$actionid}movedown" title="{$mod->Lang('move_down')}" value="{$prope->movedown_idx}" formnovalidate>{$img_down}</button>
        {/if}
      </td>
    </tr>
  {/foreach}
  </tbody>
</table>
</div>
{/if}

<div class="c_full cf">
  <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
  <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}" formnovalidate/>
  {if $gid > 0}
      <a href="{cms_action_url action=admin_exportgroup group_id=$gid}" title="{$mod->Lang('export')}">{$mod->Lang('export')}</a>
  {/if}
</div>
{form_end}
