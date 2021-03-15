<h3>{$mod->lang('importgroup')}</h3>

{form_start}
  <div class="c_full cf">
    <label class="grid_3">{$mod->Lang('prompt_importfile')}</label>
    <input class="grid_8" type="file" name="importfile" required/>
  </div>
  <div class="c_full cf">
    <label class="grid_3">{$mod->Lang('prompt_newgroupname')}</label>
    <input class="grid_8" type="text" name="input_newname"/>
  </div>
  <div class="c_full cf">
    <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
    <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}" formnovalidate/>
  </div>
{form_end}
