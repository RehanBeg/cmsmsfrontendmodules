<ul>
	<li>3.1.1
	<ul>
		<li>Fixes caching issue in the admin userlist.</li>
		<li>Now builtin authentication now checks the database roughly every 2 minutes to see if the token is still valid.</li>
	</ul>
	</li>

	<li>3.1
	<ul>
		<li>Adds a new decorator to cache userSet objects.</li>
	</ul>
	</li>

	<li>3.0<
		<div class="warning">
			<p><strong>THIS IS A MAJOR UPDATE!</strong></p>
			<p>You should have a backup before upgrading! Please ensure that everything works properly on your staging site before pushing these changes to your live site.</p>
			<p>There is some breakage in this release. Some actions have been removed, and all frontend templates have changed. Some functionality has been removed completely, though most has new ways of accompishing the same result.</p>
			<p>All frontend templates have changed. You will probably need to restyle your templates. Also, if you are calling FEU with parameters to specify templates, you will need to begin using {cms_module_hint} or other similar plugins.</p>
			<p>Since the authentication storage mechanism now uses cookies formatted differently, any users that were logged in, or had long term cookies (rememberme functionality) will be forced to re-login. Though their information will not have changed.</p>
			<p>Settings and options have changed. You should grab screenshots of the settings pages before upgrade so that you can know how to adjust config entries and templates to the new methodologies.</p>

			<p>The SelfRegistration module will no longer work with the v3.0 series of FrontEndUsers see the CGFEURegister module.</p>
		</div>

		<ul>
			<li>No longer install template types for DesignManager. It is still possible to use DesignManager to manage templates.</li>
			<li>All frontend templates now assume file templates by default. Unless parameters are specified with a smarty resource to indicate a different location or do not end with a .tpl extension.</li>
			<li>Clean up all frontend and most admin forms. The templates have changed.</li>
			<li>The emails for forgot password functionality and verification now use CGExtensions based 'eml' file.</li>
			<li>All frontend forms now support redirect-after-post. Determining which page to redirect to after each form is now done in the templates.</li>
			<li>Remove the setting panels completely. Now use config options as these options rarely change after initial setup, and were designed not to. Therefore the better location for these options was a config file.</li>
			<li>Refactor authentication to use authtokens and cookies, and NOT session data. On login users get an authtoken that has an expiry timestamp. Authtokens can be long term (+90 days) or short term (session cookies). Short term authtokens are regularly extended as the user accesses various pages, but are removed when the browser is closed.</li>
			<li>REMOVE all support for different auth consumers. This breaks the FEU_Auth_* modules which may or may not see replacements in the future.</li>
			<li>REMOVE all hooks and events for Ecommerce functionality.</li>
			<li>REMOVE all support for encrypted fields. The data for any existing encrypted fields is not explicitly decrypted. So admins and users can only see the encrypted strings. Developers can choose to store data encrypted if they wish before saving the property. Or can use external tables.</li>
			<li>REMOVE the inline parameter. This can still be specified on the {form_start} tag of most templates.</li>
			<li>REMOVE the returnto parameter.</li>
			<li>REMOVE cancel buttons from frontend forms. If you would like cancel functionality, include a link in your templates.</li>
			<li>REMOVE the viewuser action.</li>
			<li>REMOVE the reset_session action. As we do not use sessions anymore, just cookies.</li>
			<li>REMOVE the silent action: use {$feu_smarty->get_user()}</li>
			<li>Adds new number field type.</li>
			<li>Field definitions allow setting a field size and placeholder.</li>
			<li>Refactor the API functions to use Decorators and increased type hinting.</li>
			<li>Some seldom used API functions were removed.</li>
			<li>The prototypes of various API functions have been changed</li>
			<li>Refactor all caching</li>
			<li>Refactor the user class, create new userSet and Filter and FilterResultset classes.</li>
			<li>Remove the feu_user_query_resultset class. Now uses the userSet functionality.</li>
			<li>Refactor the user_edit_assistant class (replaced with a renamed class)</li>
			<li>Remove the verification_assistant classes... no longer necessary.</li>
			<li>Rewrite admin actions for efficiency.</li>
			<li>More hooks and and calling of hooks.</li>
			<li>- more...	</li>
		</ul>
	</li>

<li>2.0<br/>
   <div class="warning"><strong>Note:</strong> This version and any subsequent versions of FrontEndUsers will require a supported version of CMSMS 2.x.</div>
   <div class="warning"><strong>Note:</strong> This is a major refactoring of the FrontEndUsers module.  Though most frontend templates have not changed, many admin templates have.  If you have any overrides for admin templates then you must remove them before upgrading.</div>
	<ul>
		<li>Remove all template management functionality.  Templates are now in DesignManager.  This also means that there is the possibility of different templates for each type.
		<p>Templates are moved en-masse into DesignManager and given new names.  No other changes are made to templates.</p>
		<p>Add parameters to some actions to allow specifying alternate templates.</p>
		</li>
		<li>Split the settings action(s) to their own menu item in the admin navigation.</li>
		<li>Refactor the redirection after form completion:
		<ul>
			<li>If the returnto parameter is specified (either a page id or page alias) use it to redirect to a content page.</li>
			<li>If a PostActionURL was specified and exists in the session, then redirect to that URL.</li>
			<li>Otherwise use the preferences and templates specified in the admin nav.</li>
		</ul>
		</li>
		<li>Remove the returnlast parameter.</li>
		<li>Remove dependency on CMSMailer.</li>
		<li>Remove the separate permission for editing FEU Templates.</li>
		<li>Remove the separate permission for editing FEU module settings.</li>
		<li>Fixes to the protected section header.</li>
		<li>Improvements to user import to handle multi-line records.</li>
		<li>Refactor the admin side add/edit user functionality.
			<p>You can now upload images for users when creating users.</p>
			<p>Renaming a user account now works much better.</p>
		</li>
		<li>Adjust styling on some admin templates.</li>
		<li><strong>Note:</strong> Fixes to lost username template stuff... you will need to reset the template types to factory defaults and verify the contents of your various lost-username templates. (v2.0.7)</li>
	</ul>
</li>

<li>2.1
	<ul>
	<li>Re-factors the bulk actions and adds numerous bulk actions for users.</li>
	<li>Adds the FEU Logout Link content type.</li>
	<li>Deprecate the notification email functionality... better to use event handlers.</li>
	<li>Send the OnDeleteUser event before the user is physically deleted from the database.</li>
        <li>Minor bug fixes</li>
	</ul>
</li>

<li>2.2
	<ul>
	<li>Adds administrative option to require a user to verify themselves before the next login.</li>
	<li>Re-factor the verify email template.</li>
	<li>Fix bug in user history action.</li>
	<li>Improvements to edituser and edituser2 actions.</li>
	<li>New preferences for verify page.</li>
	<li>Now display users that need to verify themselves differently in userlist.</li>
	<li>Added OnBeforeLogin Event, which is fired after password is validated, but before things are setup.</li>
	<li>Adds feu_smarty::preload_users()</li>
	<li>Adds the ability to redirect back to the originally requested URL (GET ONLY) if direct access to protected content resulted in a 403 error,  and an error page exists to handle the request, with {FrontEndUsers} called on it.</li>
	</ul>
</li>

<li>2.3
	<ul>
	  <li>Improvements to default group functionality.  Though a user is not required to be a member of any groups, (will see about this later).  If there is no default group selected, the first group will automatically be checked.</li>
	</ul>
</li>

<li>2.4
        <ul>
          <li>Rationalize permissions to fix some problems.  There are a reduced set of permissions searched and the custom permissions have changed names and purpose.
              <p><strong>NOTE:</strong> If using custom permissions or fine-grained normal permissions you may need to adjust your settings.</p>
          </li>
          <li>Bug fixes and minor improvements.</li>
        </ul>
</li>

<li>2.5
        <ul>
        <li>Now requires CMSMS 2.2.2 or greater</li>
	<li>Now uses Hooks instead of directly triggering events.
	    <p>No further events will be added to FEU, but they will remain functional for some time.</p>
	  </li>
        <li>Remove the additional email notification method that has been long deprecated.</li>
        <li>Minor fixes to the upgrade routine.</li>
        </ul>
</li>

<li>2.6
	<ul>
	<li>Improvements to subscription handling.</li>
	<li>User list tweaks.</li>
	</ul>
</li>

<li>2.7
	<ul>
	<li>Improvements to the feu_user_query options.</li>
	<li>Improvements to expiry handling, for 64 bit sytems.</li>
	</ul>
</li>

<li>2.7.3
	<ul>
        <li>Converts all encrypted properties to use openssl encryption instead of mcrypt which is deprecated in PHP 7.1.x+
            <p><strong>Note:</strong> If you have any encrypted properties, Your host installation must have mcrypt and openssl enabled and functioning in order to upgrade.</p>
        </li>
	</ul>
</li>

<li>2.8
    <ul>
        <li>Can now filter on checkbox value 0 in the userlist.</li>
        <li>Adds a "None" option to the top of the bulk action list to prevent accidental bulk disabling of users</li>
        <li>Improvements to the feu_user_query can now filter on user NOT having a property.</li>
        <li>Adds auditing for bulk actions.</li>
	<li>Minor tweak to edit user expiry dates.</li>
    </ul>
</li>

<li>2.9
    <ul>
    <li>Adds a quick find feature to the user list tab.</li>
    <li>Adds session based CSRF tokens to each frontend form.
        <p><strong>Note:</strong> You will need to add {cge_form_csrf} inside the form of each of your template.</p>
    </li>
    <li>Begin adding functionality to allow for 2FA mechanisms.</li>
    <li>Minor bug fixes.</li>
    </ul>
</li>

<li>2.10
	<ul>
	  <li>Refactors the do_changesettings action to use exceptions.</li>
	  <li>Adds new hooks to the do_changesetttings action to allow for custom validations.</li>
	</ul>
	</li>

<li>2.11
	<ul>
	<li>Users tab now remembers your page number till session clears or filter reset.</li>
	<li>Adds new action to anonimize a user account, with accompanying hooks.</li>
	<li>Adds a new regular task, and a preference to clear user history older than a specified number of days.  With appropriate hooks.</lI>
	<li>Reorganize tabs in the primary view to put users first.</li>
	<li>Minor tweak to initial expiry date calculations when creating a new user.</li>
	<li>Now delete files when deleting a user.</li>
	<li>Fixes to redirection issues in admin.</li>
	<li>Fixes pretty urls for the change settings action.</li>
	<li>Fixes and improvements in change settings, for date fields.</li>
	<li>Fixes to expiry date when creating a new user in the admin.</li>
	<li>Bug fixes</li>
	</ul>
</li>

<li>2.12
	<ul>
           <li>massive refactoring to verify functionality.  Template changes are probably not necessary.</li>
	   <li>improvements to the feu_user_query options.</li>
           <li>minor fixes.</li>
	</ul>
</li>

<li>2.13
	<ul>
	   <li>Now use bcrypt for password hashes, and PHP's builtin hashing.
   	       <p>Backwards compatibility is maintained.</p>
	   </li>
	   <li>Now display users that have unsafe password hashes in the admin user list.</li>
	   <li>Adds numerous commands for managing FEU with CMSCLI.
	       <p>This is the first iteration of these commands.  They are subject to change as I use them or receive input.</p>
	   </li>
	   <li>Now hide the anonimize button when adding users.</li>
	   <li>Improvements to the feu_user_query and feu_user_query_resultset classes.</li>
	   <li>Refactor the way cookie data and session data is saved.</li>
	   <li>Fix to the rememberme functionality.</li>
           <li>minor fixes.</li>
	</ul>
</li>

<li>2.14
	<ul>
	<li>Now require PHP 7.2.1+</li>
	<li>Adds the {feu_user_options} smarty plugin.</li>
	</ul>
</li>

<li>3.0
	<div class="warning"><h4>THIS IS A MAJOR UPDATE</h4>
	    <p><strong>You should have a backup before upgrading!</strong>  Please ensure that everything works properly on your staging site before pushing these changes to your live site.</p>
	    <p>There is some breakage in this release.  Some actions have been removed, and all frontend templates have changed.  Some functionality has been removed completely, though most has new ways of accompishing the same result.</p>
	    <p>All frontend templates have changed.  You will probably need to restyle your templates.  Also,  if you are calling FEU with parameters to specify templates, you will need to begin using {cms_module_hint} or other similar plugins.</p>

	    <p>Since the authentication storage mechanism now uses cookies formatted differently, any users that were logged in, or had long term cookies (rememberme functionality) will be forced to re-login. Though their information will not have changed.</p>
	    <p>Settings and options have changed.  You should grab screenshots of the settings pages before upgrade so that you can know how to adjust config entries and templates to the new methodologies.</p>
	</div>

	<div class="information">
	<p>This revision of FEU was done to allow for future development.  I started this project as a way to clean up FEU so that I could add external authentication via twitter or facebook,  and allow for two factor authentication.  This required a cleaner, more stable API.  And breaking a few eggs.<p>
	<p>I also wanted to remove some complexity from the module interface,  and make application development using FEU simpler for professional developers.  To accomplish that I removed the settings and placed them into the CMSMS config file, and made changes so that for templates we preferred files rather than Design Manager.</p>
	<p>I took advantage of what was already a major change to cleanup some past difficulties in FEU.  This involved removing E-commerce functionality as it was implemented badly, and seldom used, preferring hooks over events, and other tasks.</p>
	</div>

	<ul>
        <li>No longer install template types for DesignManager.  It is still possible to use DesignManager to manage templates.</li>
	<li>All frontend templates now assume file templates by default.  Unless parameters are specified with a smarty resource to indicate a different location or do not end with a .tpl extension.</li>
	<li>Clean up all frontend and most admin forms.  The templates have changed.</li>
        <li>The emails for forgot password functionality and verification now use CGExtensions based 'eml' file.</li>
	<li>All frontend forms now support redirect-after-post.  Determining which page to redirect to after each form is now done in the templates.</li>
	<li>Remove the setting panels completely.  Now use config options as these options rarely change after initial setup, and were designed not to.  Therefore the better location for these options was a config file.</li>
        <lI>Refactor authentication to use authtokens and cookies, and NOT session data.  On login users get an authtoken that has an expiry timestamp.  Authtokens can be long term (+90 days) or short term (session cookies).  Short term authtokens are regularly extended as the user accesses various pages, but are removed when the browser is closed.</p>
	<li>REMOVE all support for different auth consumers.  This breaks the FEU_Auth_* modules which may or may not see replacements in the future.</li>
	<li>REMOVE all hooks and events for Ecommerce functionality.</li>
	<li>REMOVE all support for encrypted fields.  The data for any existing encrypted fields is not explicitly decrypted.  So admins and users can only see the encrypted strings.  Developers can choose to store data encrypted if they wish before saving the property.  Or can use external tables.</li>
	<li>REMOVE the inline parameter.  This can still be specified on the {form_start} tag of most templates.</li>
	<li>REMOVE the returnto parameter.</li>
	<li>REMOVE cancel buttons from frontend forms.  If you would like cancel functionality, include a link in your templates.</li>
	<li>REMOVE the viewuser action.</li>
	<li>REMOVE the reset_session action.   As we do not use sessions anymore, just cookies.</li>
	<li>REMOVE the silent action: use {$feu_smarty->get_user()}</li>
	<li>Adds new number field type.</li>
	<li>Field definitions allow setting a field size and placeholder.</li>
	<li>Refactor the API functions to use Decorators and increased type hinting.</li>
	<li>Some seldom used API functions were removed.</li>
	<li>The prototypes of various API functions have changed.  But ussually in a minor way.  Type hinting is now used extensively.</li>
	<li>Refactor all caching</li>
	<li>Refactor the user class, create new userSet and Filter and FilterResultset classes.</li>
	<li>Remove the feu_user_query_resultset class.  Now uses the userSet functionality.</li>
	<li>Refactor the user_edit_assistant class (replaced with a renamed class)</li>
	<li>Remove the verification_assistant classes... no longer necessary.</li>
	<li>Rewrite admin actions for efficiency.</li>
	<li>More hooks and and calling of hooks.</li>
        <li>more...</li>
	</ul>
</li>

<li>Version 3.2
    <ul>
    <li>Adds a new function to feu_smarty.</li>
    <li>bug fixes.</li>
    </ul>
</li>

<li>Version 3.2.1
    <ul>
    <li>Tweaks for CMSMS 2.3 and the PreSave() method.</li>
    <li>Minor fix to the protected content page.</li>
    <li>Changes to the logout form template to better use {cms_action_url} etc.</li>
    <li>Help improvements.</li>
    </ul>
</li>
</ul>
