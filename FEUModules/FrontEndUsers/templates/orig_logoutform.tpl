{* logout form template *}
{if isset($message)}<div class="alert alert-info">{$message}</div>{/if}

<div id="loggedinuserinfo">
	<div id="loggedinuser">
		{$user->username} |
	</div>
	<div id="usersettings">
		<a href="{cms_action_url action=changesettings}" title="{$mod->Lang('info_changesettings')}">User Settings</a>
	</div>
</div>
<!-- <p><a href="{cms_action_url action=logout}" title="{$mod->Lang('info_logout')}">{$mod->Lang('logout')}</a></p> -->
