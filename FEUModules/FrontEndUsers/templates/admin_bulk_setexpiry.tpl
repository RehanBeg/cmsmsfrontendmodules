<h3>{$mod->Lang('hdr_bulk_setexpiry')}</h3>
<div class="information">{$mod->Lang('info_bulk_setexpiry')}</div>

{form_start job=$job uids=$uids}
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('expires')}:</p>
  <p class="pageinput">
    {html_select_date prefix="{$actionid|cat:'expires'}" start_year="-10" end_year="2038" time="{strtotime('+5 years')}"}
  </p>
</div>
<div class="pageoptions">
  <p class="pageinput">
    <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
    <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}" formnovalidate/>
  </p>
</div>
{form_end}