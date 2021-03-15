{if !empty($final_message)}
    <h3>{$mod->Lang('msg_welcome')} <span>{$user->username}</span> <em>({$feu_uid})</em></h3>
    <div class="alert alert-info">
        {$final_message}
	{if $logged_in}
	    {* we are logged in, we could link to the members are, or redirect there *}
	{else}
	    {* we could use cms_selflink to link to a login page *}
	{/if}
    </div>
    {* we could also redirect here if we wished *}
{elseif !empty($error)}
    <div class="alert alert-danger">{$error}</div>
{else}
    <p>INTERNAL ERROR (this should not happen)</p>
{/if}
