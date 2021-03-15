{* login form template *}
{* variables available:
   $actionid - The 'id' of the module call that this template originated from.  This must be sepcified as the prefix to all input fields
   $error - After submission, this will contain any error message generated when login was unsuccessful
   $final_msg - If not empty this variable indicates that the user has logged in, and contains a friendly message that can be displayed.
   $user_info - If not empty this variable indicates that the user has logged in, and is an object containing the user details.
   $further_action_required - If not empty this variable indicates that the user has logged in, and contains the name of an action that should be displayed
   $requested_url - If not empty, this variable contains the URL of the page that the user should be redirected to if no further action is required
   $username_is_email - A boolean indicating that the username field should be of type email.
   $captcha - If not empty it indicates that captcha is enabled.  This variable contains the HTML Img tag to display.
   $need_captcha_input - A boolean indicating that for captcha, an input field with the name {$actionid}feu_input_captcha should be provided.
   $fldname_username - A string containing the name of the username field.
   $username_maxlength - An integer indicating the maximum length of required usernames
   $username - A string containing the users entered username.  This is only non-empty if an error occurred.
   $fldname_password - A string containing the name of the password field.
   $password_maxlength - An integer indicating the maximum length of passwords.
   $password - A string containing the users entered password.  This is only non empty if an error occurred.
   $fldname_rememberme - A string containing the name of the rememberme input field.  If rememberme is disabled, this will be empty or not set.
   $rememberme - A boolean indicating whether the user has selected to remember his credentials on this computer over the long term.  Only true if selected when an error occurred.
*}

{if $user_info && $user_info->id > 0 && $final_msg}
     {* we are logged in, here we decide what to display, and where to go. *}
     {if !empty($further_action_required)}
         {* some kind of action is required (change settings, change password) *}
         <a id="further_action" href="{module_action_url action=$further_action_required uid=$user_info->id}">
<script>
var further_action = document.getElementByID('further_action')
window.location.href = further_action.href
</script>
     {elseif !empty($requested_url)}
         {* we have logged in... but we originally requested a different URL.  We can go back there *}
	 {redirect_url to=$requested_url}
     {else}
         {* After login, we display a final message *}
         {* note: you could also redirect somewhere here:  see the redirect_page, redirect_url plugin, cms_selflink, cms_action_url and module_action_url plugins *}
         <div class="alert alert-info">{$final_msg}</div>
     {/if}

{else}


    <div id="loginbox">
        <h2>Login</h2>
        {form_start inline=$inline onlygroups=$onlygroups}{cge_form_csrf}

   	{*
   	 * a simple honeypot captcha....if this field has a value after submit an error will be thrown
   	 * deleting this field will simply disable the honeypot.
   	 * it is important that the field be hidden with CSS rather than using a hidden input field.
   	 *}
  	 <input type="text" name="{$actionid}feu__data" value="" style="display: none;"/>

  	 {if $error}<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {$error}</div>{/if}

  	 <div class="loginfield username">
	      {$prompt_username=$FrontEndUsers->Lang('prompt_username')}
	      {if $username_is_email}{$prompt_username=$FrontEndUsers->Lang('prompt_email')}{/if}
    	      <p class="col-md-4 text-right"><label for="feu_username">{$prompt_username}</label></p>
    	      <p class="col-md-8">
      	      	 <input type="{if $username_is_email}email{else}text{/if}" id="feu_username" name="{$fldname_username}" value="{$username}" maxlength="{$username_maxlength}" autocapitalize="off" autocorrect="off" required/>
    	      </p>
  	 </div>

  	 <div class="loginfield password">
    	      <p class="col-md-4 text-right"><label for="feu_password">{$mod->Lang('prompt_password')}</label></p>
    	      <p class="col-md-8">
      	      	 <input type="password" id="feu_password" name="{$fldname_password}" value="{$password}" maxlength="{$password_maxlength}" required/>
    	      </p>
  	 </div>

  	 {if isset($captcha)}
  	 <div class="row">
    	      <p class="col-md-4 text-right">{$FrontEndUsers->Lang('captcha_title')}</p>
    	      <div class="col-md-8">
	           {$captcha}
      	           {if $need_captcha_input}
      		   <div class="row">
        	   	<input type="text" name="{$actionid}feu_input_captcha" required autocomplete="off"/>
      		   </div>
      		   {/if}
    	      </div>
  	 </div>
  	 {/if}
  

  	 {if !empty($fldname_rememberme)}
     <!--
  	 <div class="row">
    	      <p class="col-md-4"></p>
    	      <p class="col-md-8">
      	         <label><input type="checkbox" name="{$fldname_rememberme}" value="1" {if $rememberme==1}checked{/if}/> {$mod->Lang('prompt_rememberme')}</label>
    	      </p>
  	 </div>
  	 -->
     {/if}

  	 <div class="row">
    	      <p class="col-md-4"></p>
    	      <p class="col-md-8">
      	      	 <button class="btn btn-active" name="{$actionid}feu_submit">{$FrontEndUsers->Lang('login')}</button>
    	      </p>
         </div>

         {if $reverify}
    	     <div class="row">
    	         <p class="col-md-4">&nbsp;</p>
    	         <p class="col-sm-8">
		      <a href="{module_action_url action=reverify}" title="{$FrontEndUsers->Lang('info_reverify')}">
		          {$FrontEndUsers->Lang('prompt_reverify')}
		      </a>
		 </p>
	     </div>
  	 {elseif $allow_forgotpw || $allow_lostusername}
  	     <div class="row">
    	         <p class="col-sm-8">
      	      	     {* note: you can specify the page parameter here to specify an alternate page id or alias *}
      		     {if $allow_forgotpw}
        	         <a href="{module_action_url action=forgotpw}" title="{$FrontEndUsers->Lang('info_forgotpw')}"><i class="fas fa-question-circle"></i> {$FrontEndUsers->Lang('forgotpw')}</a>
      		     {/if}
      		     {if $allow_lostusername}
        	       <!--   
                   <a href="{module_action_url action=lostusername}" title="{$FrontEndUsers->Lang('info_lostun')}">{$FrontEndUsers->Lang('lostusername')}</a>
                 -->
      		     {/if}
    	         </p>
  	     </div>
  	 {/if}
	 {form_end}
  </div>

<div id="registerbox">
  <h2>Register</h2>
  <p>If you don't have an account, please create one and click on the link below.</p>
  <p><a href="register">Register</a></p>
  <p><i class="fas fa-exclamation-circle"></i> Please be aware, to enter only true informations.</p>
</div>

{/if}
