<h3>{$mod->Lang('hdr_bulk_setpassword')}</h3>
<div class="information">{$mod->Lang('info_bulk_setpassword')}</div>

{form_start job=$job uids=$uids}
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('password')}:</p>
  <p class="pageinput"><input type="password" name="{$actionid}password"/></p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('repeatpassword')}:</p>
  <p class="pageinput"><input type="password" name="{$actionid}repeatpassword"/></p>
</div>
<div class="pageoptions">
  <p class="pageinput">
    <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
    <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}" formnovalidate/>
  </p>
</div>
{form_end}