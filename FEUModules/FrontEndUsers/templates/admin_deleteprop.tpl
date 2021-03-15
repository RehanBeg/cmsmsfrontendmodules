<h3>{$mod->Lang('hdr_deleteprop')}:</h3>
<div class="warning">{$mod->Lang('warn_deleteprop')}</div>

<fieldset>
  <legend>{$defn.prompt} <em>({$defn.name})</em></legend>
  <p>Type: {$fieldtypes[$defn.type]}</p>
</fieldset>

{$formstart}
  <div class="pageoptions">
    <p class="pagetext">{$mod->Lang('prompt_confirm_deleteprop')}:</p>
    <p class="pageinput">
       <select id="feu_confirm" name="{$actionid}feu_confirm">
          <option value="0">{$mod->Lang('no')}</option>
          <option value="1">{$mod->Lang('yes')}</option>
       </select>
    </p>
  </div>
  <div class="pageoptions">
    <p class="pageinput">
      <input type="submit" id="feu_submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
      <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}"/>
    </p>
  </div>

{$formend}
