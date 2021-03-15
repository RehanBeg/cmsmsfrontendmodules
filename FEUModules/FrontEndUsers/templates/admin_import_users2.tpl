<h3>{$mod->Lang('prompt_importusers')}</h3>

{cms_jquery}

<script>
var progress_max = 100;
function import_progress_max(val) {
  progress_max = parseInt(val);
  if( progress_max < 1 ) progress_max = 1;
  progress_val = 0;
  $('#progress').width(0);
}
function import_progress_set(n) {
  n = parseInt(n);
  if( n < 1 ) n = 1;
  var v = Math.round(n / progress_max * 100.0);
  $('#progress').width(v+'%').html(v+'%');
}
function import_status(msg) {
  $('#status_area').append('<p>'+msg+'</p>');
}
function import_warning(msg) {
  $('#status_area').append('<p class="import_warning">'+msg+'</p>');
}
function import_error(msg) {
  $('#status_area').append('<p class="import_error">'+msg+'</p>');
}
function import_finish() {
  alert('all done');
  $('#finish_area').show('slow');
}
</script>

<style type="text/css">
#meter {
  margin-left: auto;
  margin-right: auto;
  border: 1px solid black;
  background-color: #fff;
  color: gray;
  height: 2em;
  margin-bottom: 2em;
  text-align: center;
}
#progress {
  display: block;
  overflow: hidden;
  height: 100%;
  background-color:  cyan;
  vertical-align: center;
  line-height: 2em;
}
#status_area > p {
  font-size: 11px;
  line-height: 1.1em;
}
#status_area > p.import_warning {
  background: #faf6d4;
  border: 1px solid #e6c26e;
}
#status_area > p.import_error {
  background: #f2d4ce;
  border: 1px solid #ae432e;
}
#finish_area {
  margin-top: 1em;
  margin-bottom: 1em;
}
</style>

<div id="meter">
  <span id="progress"></span>
</div>

<div id="status_area"></div>

<div id="finish_area" class="pageoverflow" style="display: none;">
  <div class="pageinput">
    <a href="{$return_url}">{$mod->Lang('prompt_return')}</a>
  </div>
</div>
<iframe id="import_iframe" style="display: none;" src="{$iframe_src}"></iframe>