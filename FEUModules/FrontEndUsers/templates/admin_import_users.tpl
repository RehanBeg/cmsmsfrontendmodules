<h3>{$mod->Lang('prompt_importusers')}</h3>

<div class="information">{$mod->Lang('info_import_format')}</div>
{cge_helphandler}

{form_start}
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('prompt_delete_users')}:</p>
  <p class="pageinput">
    <select name="{$actionid}delete_users">
      {cge_yesno_options selected=$options.delete_users}
    </select>
    <br/>{$mod->Lang('info_import_delete_users')}
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('prompt_delimiter')}:</p>
  <p class="pageinput">
    <input type="text" name="{$actionid}delimiter" value="{$options.delimiter}" size="3" maxlength="1"/>
  </p>
</div>

<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('prompt_importfilename')}:&nbsp;{cge_helptag key='import_format'}</p>
  <p class="pageinput">
    <input type="file" name="{$actionid}file"/>
  </p>
</div>

<div class="pageoverflow">
  <p class="pageinput">
    <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
    <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}"/>
  </p>
</div>
{form_end}

<div style="display: none;">
{cge_helpcontent key='import_format' text=$mod->Lang('info_importusersfileformat2')}
</div>