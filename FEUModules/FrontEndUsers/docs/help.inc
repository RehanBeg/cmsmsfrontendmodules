<div id="feu_help">
<a id="top"></a>

<style>
a.nav {
    display: inline-block;
    width: 30%;
}
</style>
<script>
$(function(){
    $('#feu_help a.nav').click(function(ev){
       ev.preventDefault()
       let target = $(this).prop('href')
       target = target.substring(target.indexOf('#'));
       $('html,body').animate({scrollTop: $(target).offset().top},'slow')
    })
})
</script>

<hr/>
<a class="nav" href="#features">Features</a>
<a class="nav" href="#howtouse">How do I use it</a>
<a class="nav" href="#privacy">Privacy</a>
<a class="nav" href="#params">Parameters</a>
<a class="nav" href="#smarty">Smarty Functions</a>
<a class="nav" href="#config">Config entries</a>
<a class="nav" href="#faq">FAQ</a>
<a class="nav" href="#templates">About templates<a>
<a class="nav" href="#emails">Emails</a>
<a class="nav" href="#auth">Authentication and Cookies</a>
<a class="nav" href="#hooks">Hooks</a>
<a class="nav" href="#requires">Requirements</a>
<a class="nav" href="#background">Background tasks</a>
<a class="nav" href="#support">Support</a>
<a class="nav" href="#license">Copyright and License</a>
<hr/>

<h3>What Does This Do?</h3>
<p>This module allows site visitors to authenticate themselves with your website.  This module provides extensive functionality to allow creating and managing user accounts.  It allows associating different properties with user groups, and asociating users with zero or more groups.</p>
<p>This module also allows you to display different content to authenticated users, or subsets of them.  Or to hide content from non authenticated visitors.</p>
<p>This module allows building applications that require user authentication and group membership or behave differently to different subsets of users.</p>

<h3 id="features">Features:</h3>
<ul>
<li>Users can be members of multiple groups.</li>
<li>User account expiration.  You can create temporary users</li>
<li>Group Properties.  You can ask for different information from members of different groups.</li>
<li>Lots of field types.</li>
<li>Provides a content type to make protecting content simple, if not trivial.</li>
<li>Capable of handling thousands of users</li>
<li>Forgotten password, and forgot username functionality... allows users to set a new password, and/or to recover their username if they completely forgot login details.</li>
<li>Account verification functionality so that admins can minimize the chance of hacked accounts.</li>
<li>Extensive security mechanisms.</li>
<li>Uses strong password hashing and security</li>
<li>Provides extensive import and export capabilities.</li>
<li>Has an extensive API for adding functionality into various other CMSMS addon modules.</li>
<li>Extensive administrative capabilities.</li>
<li>Strong Passwords:
    <p>This module, when freshly installed (not an upgrade) enables strong passwords.  At a minimum one upper case character and one digit are required to be in every password.  The site administrator can also specify other optional characters, one of which must be present in all passwords.</p>
</li>
</ul>
<a class="nav" href="#top">Back to top</a>

<h3 id="howtouse">How do I use it:</h3>
<p>After installation you can the access admin panel to the FrontEndUsers module under the &quot;Users &amp; Groups&quot; menu.</p>
<p>You need to define at least one property.  Properties are essentially field definitions.  They allow you to create fields for data that can be associated with users.  Here you specify the type of information you want to gather, and limits. i.e:  Name, Age, City, State, Country, etc.</p>
<p><b>Note:</b> You do not need to define properties for username (or email address) and password, these will be provided for you.  Though you can provide properties for additional email addresses.</p>
<p><b>Note:</b> New installations of the FEU module specify that the users email address is their username (this option can be changed in the config file.).  So if using this option you will not need to create an email address property.</p>
<p>Next you must create one or more user groups.  When you create a group, you are asked for a group name, a description and to associate one or more properties with that group, specify the properties sort order, and whether it is an optional, required, or hidden field.  At least one property must be associated with a group.</p>
<p>Thirdly you should create some users.  Adding users is a two step process.  When creating a user you are asked for the username/email and password, and an expiry date for that user.  You then must select the groups that that user is a member of, and click &quot;Next&quot;</p>
<p><em>Note: </em>This is a labour intensive and boring process, it is easier to let users register themselves <em>(See the SelfRegistration Module)</em>, and then you can edit their group information.  but for testing purposes, please create at least one user</p>
<p>Lastly, after the system has determined all of the information fields to be presented for that user, you are presented with a form asking for all of the required user information.  Complete this form to complete the user addition</p>
<p>You are now ready to add the front end functionality to your site.  This is as simple as adding the {FrontEndUsers} tag to your page or template.  You must ensure that this page is set to &quot;not cache&quot; when editing the content page(s) where the login form is displayed.  If you call the {FrontEndUsers} tag from within a page template, you must disable caching on all pages that use that template.</p>
<p>Adding protected content to your CMSMS site is as simple as creating new pages of type &quot;Protected Content&quot; and selecting which user groups (or all) that are allowed to view the page.</p>
<p><em>Optionally</em> Create another new content page of type 'Error Handler' and set the error handler to 403 error.  In the content area of that page, you could call {FrontEndUsers} to display a login form on the 403 error page.</p>
<a class="nav" href="#top">Back to top</a>

<div class="warning">
<h3 id="privacy">Privacy Warning:</h3>
<p>Administrators are responsible for managing the safety and security of any personal information collected.</p>

<p>This module does log the IP address of users. This is not compatible with Do-Not-Track policies, and may break some laws.  Additionally, this module sets a cookie when using the builtin authenticaton mechanism.  The cookie does not store or transmit any personal information.</p>

<p>This module provides some assistance in managing user privacy.  There is functionality to anonimize a users account, and functionality that will automatically clear old data from user history logs.</p>

<p>This module does NOT provide the ability for users to remove their accounts.  This is because other functionality (such as E-commerce) may require the user information for referential integrity.  However, there is an admin option to allow anonimizing a user.</p>
</div>
<a class="nav" href="#top">Back to top</a>

<h3 id="params">Parameters</h3>
<ul>
<li><em>(optional)</em> action="default"
  <p>Actions:</p>
  <ul>
    <li><em>default</em> - The default action.  If the user is logged in, the logoutform action will be displayed.  If the user is not logged in the login action will be called.
    <li><em>login</em> - Display the login form.</li>
    <li><em>logoutform</em> - Display output about your current username, and actions to change your settings, or logout.  If the user is not logged in, this action does nothing.</li>
    <li><em>changesettings</em> - Display the change settings form for logged in users.  If the user is not logged in, this action does nothing.</li>
    <li><em>forgotpw</em> - Display the forgot password form.</li>
    <li><em>lostusername</em> - Display the lostusername form (if the system is properly setup to handle lost username requests, and the user is not currently logged in.</li>
  </ul>
</li>

<li><em>(optional)</em> only_groups="group1, group2, group3"
   <p>Used with the login forms.  Basically only allows users to login if they belong to that particular group(s).</p>
</li>
<li><em>(optional)</em> nocaptcha="1"
  <p>Used with the login and verify forms, This will disable captcha on the form. By default, if the Captcha module is installed, validation of a captcha image will be required for login.  This is a security measure intented to prevent brute force attacks.</p>
</li>
<li><em>(optional)</em> logintemplate=string
  <p>This parameter allows specifying an alternate template for the login action.</p>
</li>
<li><em>(optional)</em> logouttemplate=string
  <p>This parameter allows specifying an alternate template for the logoutform action.</p>
</li>
<li><em>(optional)</em> post_logouttemplate=string
  <p>This parameter allows specifying an alternate template for the text displayed after logout.</p>
</li>
<li><em>(optional)</em> changesettingstemplate=string
  <p>This parameter allows specifying an alternate template for the changesettings action.</p>
</li>
<li><em>(optional)</em> forgotpwtemplate=string
  <p>This parameter allows specifying an alternate template for the forgotpw action.</p>
</li>
<li><em>(optional)</em> verifycodetemplate=string
  <p>This parameter allows specifying an alternate template for the verifycode action. This action is triggered when a user has clicked on the link in the email sent by the forgotpw action.</p>
</li>
<li><em>(optional)</em> lostuntemplate=string
  <p>This parameter allows specifying an alternate template for the lostusername action.<p>
</li>
<li><em>(optional)</em> verifyonlytemplate=string
  <p>This parameter allows specifying an alternate template for the verifyonly action, which is triggered when a user is sent an email to force them to verify their account.</p>
</li>
</ul>
<p><strong>Tip:</strong> You can use the <code>{cge_module_hint}</code> plugin from CGExtensions, or the <code>{cms_module_hint}</code> plugin in CMSMS 2.0 to set these parameters on a global, per-page-template, or per-page basis without having to adjust every call, and while still maintaining pretty URL's.</p>
<a class="nav" href="#top">Back to top</a>

<h3 id="smarty">Smarty Functions:</h3>
<h4>{feu_user_options}</h4>
<p>This function plugin provides a convenient method to generate options for a select element with users from the FEU module.  This is useful in admin interfaces.</p>
<h5>Usage:</h5>
<pre><code>{feu_user_options [group=string] [notdisabled=bool] [notexpired=bool] [use_userids=bool] [selected=mixed]}</code></pre>
<h5>Parameters:</h5>
<ul>
    <li><code>group=string</code> - Display only users that are members of the named group.</li>
    <li><code>notexpired=bool</code> - Display only users that are not expired.</li>
    <li><code>notdisabled=bool</code> - Display only users that arer not disabled.</li>
    <li><code>use_userids=bool</code> - (default false) The values for each option will be the userid, not the username.</li>
    <li><code>selected=mixed</code> - The value of the option to select.  If use_userids is enabled, this should be an integer uid.  Otherwise this should be a username string.</li>
</ul>

<h4>{feu_protect}</h4>
<p>The <strong>feu_protect</strong> block plugin provides a convenient method to hide some content from users on what is normally a public page.</p>
<p><strong style="color: red;">Warning:</strong> This plugin cannot be considered 100% secure, and should not at any time be used in the page template to protect the default {content} tag.  There are ways to access the default content property of a page, or to call a module action without processing the page template.  If you need to protect the content and ensure that no unauthorized users access the page, use the protected page content type provided by this module.</p>
<h5>Usage:</h5>
<pre><code>{feu_protect groups="group1,group2,grop3"}
  &lt;p&gt;Smarty content that should only be visible to members of those groups.&lt;/p&gt;
{/feu_protect}</code></pre>
<p><strong>Note:</strong> The user must be a member of at least one of the specified groups.  The group names are case sensitive.</p>

<h4>The feu_smarty class</h4>
<p>The <strong>feu_smarty</strong> class provides some functions to interact with the database and pull and test for user information.</p>
<p>Some interaction with the FrontEndUsers module database is possible with smarty and the feu_smarty class.</p>
<div class="information">
  <p><strong>Note:</strong> Behavior of the feu_smarty class changed significantly at version 1.29 resulting in compatibility problems.</p>
  <p>This is now a registered class with Smarty (for CMSMS 2.0 compatibility).  And all methods must be accessed statically.  Additionally, there is no assign param.  You must capture the output of the function into a smarty variable.</p>
</div>
<h5>Functions:</h5>
<ul>
<li><strong><code>{feu_smarty::get_current_userid()}</code></strong>
<p>This function returns the integer user id if the currently logged in user (if any).</p>
<p>Example:</p>
<pre><code>{$uid=feu_smarty::get_current_userid()}</code></pre>
</li>

<li><strong><code>{feu_smarty::get_current_username()}</code></strong>
<p>This function returns the user name if the currently logged in user (if any).</p>
<p>Example:</p>
<pre><code>{$username=feu_smarty::get_current_username()}</code></pre>
</li>

<li><strong><code>{feu_smarty::get_userid($username)}</code></strong>
<p>This function can be used to return the integer user id given a username.</p>
<p>Example:</p>
<pre><code>{$uid=feu_smarty::get_userid($username)}</code></pre>
</li>

<li><strong><code>{feu_smarty::get_username([$uid])}</code></strong>
<p>This function can be used to return the string username given an integer uid.  If no uid is specified, the current logged in uid is assumed.</p>
<p>Example:</p>
<pre><code>{feu_smarty::get_username($the_uid)}</code></pre>
</li>

<li><strong><code>{feu_smarty::get_email([$uid])}</code></strong>
<p>This function can be used to return an email adderess associated with the given integer uid.  If no uid is specified, the current logged in uid is assumed.</p>
<p>Example:</p>
<pre><code>{feu_smarty::get_email($the_uid)}</code></pre>
</li>

<li><strong><code>{feu_smarty::get_userinfo([$uid])}</code></strong>
<p>This function can be used to return the user information for a single user.  If no uid is specified, the current logged in uid is assumed.</p>
<p>Example:</p>
<pre><code>{$uinfo=feu_smarty::get_userinfo($something.userid)}<br/>{$uinfo|@print_r}</code></pre>
</li>

<li><strong><code>{feu_smarty::get_users_by_groupname($groupname[,$for_list])}</code></strong>
<p>This function can be used to extract an array of usernames and userids for all users that belong to the specified group.</p>
<p>The groupname parameter must be a single string groupname.</p>
<p>The for_list parameter is a boolean that indicates that the output should be suitable for use in a select list.</p>
<p>Example:</p>
<pre><code>{$mymembers=feu_smarty::get_users_by_groupname('members')}<br/>{$mymembers|@print_r}</code></pre>
</li>

<li><strong><code>{feu_smarty::get_group_memberlist($gid)}</code></strong>
  <p>This function returns an array of uid and usernames for all users that are members of the specified group (by group id).</p>
  <p>Example:</p>
  <pre><code>{html_options options=feu_smarty::get_group_memberlist($gid) selected=$uid}</code></pre>
</li>

<li><strong><code>{feu_smarty::get_user_expiry([$uid])}</code></strong>
<p>This function returns the unix timestamp that the specified uid account expires.  The function will return false if the uid cannot be found or some other error occurred.</p>
<p>Example:</p>
<pre><code>{$expiry=feu_smarty::get_user_expiry(25)}<br/>{$expiry|cms_date_format}</code></pre>
</li>

<li><strong><code>{feu_smarty::user_expired($uid)}</code></strong>
<p>This function returns a boolean indicating wether the specified user account has expired.  The method will also return false if the uid cannot be found or some other error occurred.</p>
<p>Example:</p>
<pre><code>{$expired=feu_smarty::user_expired(25)}<br/>{if $expired}UID 25 can no longer login to the system{/if}</code></pre>
</li>

<li><strong><code>{feu_smarty::get_user_properties($uid)}</code></strong>
<p>This function can be used to extract a list of properties for the specified user.  If the uid is not specified the current logged in uid is used.</p>
<p>Example:</p>
<pre><code>{$userprops=feu_smarty::get_user_properties(5)}<br/>{$userprops|@print_r}</code></pre>
</li>

<li><strong><code>{feu_smarty::get_user_property($property,[$uid])}</code></strong>
  <p>This function returns the value of a single property for the specified uid.  If the uid parameter is not specified, the current logged in uid is used.</p>
  <p>Example:</p>
  <pre><code>{feu_smarty::get_user_property('fullname',5)}</code></pre>
</li>

<li><strong><code>{feu_smarty::get_dropdown_text($propname,$propvalue)}</code></strong>
  <p>This function returns the text specified for a particular option value for a specified dropdown property.</p>
  <p>Example:</p>
  <pre><code>{feu_smarty::get_dropdown_text('age_range',$onepropvalue)}</code></pre>
</li>

<li><strong><code>{feu_smarty::get_multiselect_text($propname,$propvalue)}</code></strong>
  <p>This function returns an array of option texts corresponding to a comma separated list of option values.</p>
  <p>Example:</p>
  <pre><code>{$favorite_foods=feu_smarty::get_multiselect_text('favorite_foods',$onepropvalue)}<br/>{$favorite_foods|@print_r}</code></pre>
</li>

<li><strong><code>{feu_smarty::get_group_list()}</code></strong>
  <p>This function returns an array of FEU groups that is suitable for use in a dropdown.</p>
  <p>Example:</p>
<pre><code>&lt;select id="group"&gt;{html_options options=feu_smarty::get_group_list()}&lt;/select&gt;</code></pre>
</li>

<li><strong><code>{feu_smarty::get_user_groups([$uid])}</code></strong>
  <p>This function returns an array of FEU groups that this user belongs to (if any).  The output is an array suitable for use in a select list (the key is the groupid, value is the group name).</p>
  <p>Example:</p>
<pre><code>{$mygroups=feu_smarty::get_user_groups()}
{$mygroups|@print_r}</code></pre>
</li>

<li><strong><code>{feu_smarty::preload_users($uid_list[,$deep = false])}</code></strong>
  <p>This function will preload information for the specified users.  It does not return any output.</p>
  <p>Example:</p>
<pre><code>{$list=[ 5, 10, 11, 13, 18 ]}{feu_smarty::preload_users($list)}</code></pre>
</li>

<li><strong><code>{feu_smarty::is_user_memberof($groups[,$uid])}</code></strong>
  <p>This function returns a boolean if the user is a member of one the specified groups.</p>
  <p>The groups parameter can be a comma delimited string of group names, or an array of group names.</p>
  <p>If the uid parameter is not specified, the currently logged in userid is used.</p>
  <p>Example:</p>
<pre><code>{if feu_smarty::is_user_memberof('Staff,Managers')}Hello Customer{/if}</code></pre>

<li><strong><code>{feu_smarty::is_user_valid($uid)}</code></strong>
  <p>This function returns a boolean indicating whether the user account is both active and not expired.</p>
  <p>If the uid parameter is not specified, the currently logged in userid is used.</p>
  <p>Example:</p>
  <pre><code>{if !feu_smarty::is_user_valid(5)}User 5 is disabled or expired.{/if}</code></pre>
</li>

</ul>
<a class="nav" href="#top">Back to top</a>

<h3 id="config">Config entries</h3>
<p><strong>Note:</strong> This module can read settings from the CMSMS config.php file OR from a JSON file in assets/configs/feu_settings.json.  Depending on your situation, the module may create this file when upgrading.  Values in the config.php file will always override values in assets/configs.feu_settings.json.</p>
<ul>
   <li>feu_username_is_email - <em>(bool=true)</em>
       <p>Whether or not a valid email address must be entered whenever a user is asked for a username.</p>
       <p>If true, this value will also be used when sending an email to the user.</p>
   </li>
   <li>feu_disable_login - <em>(bool=false)</em>
       <p>Optionally disable the built in login form completely.  This may be necessary when using some alternate forms of authentication such as Two Factor Authentication.</p>
   </li>
   <li>feu_disable_forgotpw - <em>(bool=false)</em>
       <p>Optionally disable the forgot password functionality completely.</p>
   </li>
   <li>feu_disable_lostusername - <em>(bool=false)</em>
       <p>Optionally disable the functionality that allows users to retrieve their username.</p>
   </li>
   <li>feu_disable_rememberme - <em>(bool=false)</em>
       <p>Optionally disable functionality that allows users to remain logged in (from the same browser) for up to 90 days.</p>
       <p>If rememberme functionality is enabled, then forced logout times are disabled.</p>
   </li>
   <li>feu_allow_changeusername - <em>(bool=false)</em>
       <p>Optionally disable any functionality that allows users to change their username/email address.</p>
   </li>
   <li>feu_require_onegroup - <em>(bool=true)</em>
        <p>If enabled, a user must at all times be a member of at least one group.</p>
   </li>
   <li>feu_default_group - <em>(int)</em>
        <p>When adding new users, specify the id of the group that they should belong to by default.  If not specified, and require_onegroup is enabled
	   then the first found group will be used.</p>
   </li>
   <li>feu_min_passwordlength - <em>(int=6)</em>
        <p>Used when creating or editing users, or when users change their password, this specifies the minimum length of a password.</p>
	<p>Changing this has no effect on existing user passwords.</p>
   </li>
   <li>feu_max_passwordlength - <em>(int=80)</em>
        <p>Used when creating or editing users, or when users change their password, this specifies the maximum length of a password.</p>
	<p>Changing this has no effect on existing user passwords.</p>
   </li>
   <li>feu_enhanced_passwords = <em>(bool=true)</em>
        <p>Used when creating or editing users, or when users change their password, this specifies that entered passwords should contain at least one uppercase character, and one numeric.</p>
	<p>Changing this has no effect on existing user passwords.</p>
   </li>
   <li>feu_passwords_requiredchars = <em>(string='')</em>
        <p>Optionally specify a list of characters, at least one of which must be specified when creating or adjusting a password.</p>
	<p>Changing this has no effect on existing user passwords.</p>
   </li>
   <li>feu_min_usernamelength - <em>(int=3)</em>
        <p>Used when creating or editing users, or when users change their username, this specifies the minimum length of a username.</p>
   </li>
   <li>feu_max_usernamelength - <em>(int=128)</em>
        <p>Used when creating or editing users, or when users change their username, this specifies the maximum length of a username.</p>
   </li>
   <li>feu_login_after_verify - <em>(bool=false)</em>
        <p>When enabled, and a user successfully verifies their account, automatically log the user in.</p>
   </li>
   <li>feu_expireage_months - <em>(int=520)</em>
        <p>When creating a new user this specifies the default number of months until the user account expires.  This value must be greater than 1.</p>
	<p>If the value is greater than one, AND the system cannot calculate a date, then PHP_INT_MAX will be used as an expiry date, which could be different
	   on 32bit and 64bit systems.
	</p>
   </li>
   <li>feu_clearhistory_age - <em>(int=0)</em>
        <p>Automatically delete history entries that are older than a specified number of days.  If 0, then user history is never removed.</p>
   </li>
   <li>feu_image_destination_path - <em>(string='_feusers')</em>
        <p>A directory, relative to the CMSMS uploads directory where uploaded files associated with a user account should be stored.</p>
   	<p>Use caution when changing this value when you have existing files associated with users.</p>
   </li>
   <li>feu_allowed_image_extension - <em>(string='.png,.gif,.bmp,.jpg,.jpeg')</em>
        <p>The allowed file extensions (case insensitive) that users are allowed to upload for image fields.</p>
   </li>
   <li>feu_forcelogout_times - <em>(string='')</em>
        <p>An optional string of times (i.e: HH:MM,HH:MM,HH:MM) at which to automatically deauthenticate all users.</p>
	<p>This functionality is enabled via an automated task, so times are approximate minimums and should not be specified too close together.</p>
	<p>This option has no effect, if the rememberme functionality is enabled.</p>
   </li>
   <li>feu_pagetype_groups - <em>(string='')</em>
        <p>An optional comma separated list of group names to allow by default when creating a new protected page or protected section header.</p>
   </li>
   <li>feu_pageid_onverify = <em>(int)</em>
        <p>An optional integer pageid to use for the verification form.  If not specified, the default content page will be used.</p>
	<p>this preference exists because verification emails can be triggered from admin actions where there is no known 'current' known frontend page.</p>
   </li>
   <li>feu_authtoken_expiry_hours = <em>(int=8)</em>
        <p>The number of hours before normal (not rememberme) tokens expire.<p>
	<p>See the included documentation about authentication and cookies.</p>
   </li>
   <li>feu_tempcode_expiry_days = <em>(int=2)</em>
        <p>The number of days that a tempcode is valid for.</p>
	<p>Tempcodes are used when a user must verify their account.</p>
	<p>If this value is less than one, then tempcodes never expire.  This is not recommended.</p>
   </li>
</ul>
<a class="nav" href="#top">Back to top</a>


<h3 id="faq">FAQ</h3>
<ul>
  <li><strong>Q:</strong> Why can't I create a group
    <p><strong>A:</strong> Groups can't be created untill at least one property is created.</p>
  </li>
  <li><strong>Q:</strong> Why can't I delete a property
    <p><strong>A:</strong> A property can only be deleted if it is not associated with any groups as required or hidden.  Additionally, properties created by other modules cannot be deleted.</p>
  </li>
  <li><strong>Q:</strong> Setting property order doesn't seem to work
  <p><strong>A:</strong> The percieved property order will change each time the group is edited.  The properties that are marked as &quot;off&quot; will always be displayed at the bottom, but the sort order of other properties will be retained.</p>
  </li>
  <li><strong>Q:</strong> How do I use templates from Design Manager?
      <p>This module does not integrate directly with the DesignManager module <em>(but it used to)</em> Though you can still use Design Manager to manage your templates if you wish.  To do this, just use the 'cms_template' resource when specifying an alternate template and do not specify a .tpl extension.</p>
      <p>i.e: <code>{cms_module_hint module=FrontEndUsers logintemplate='cms_template:My Login Template'}</code></p>
  </li>
  <li><strong>Q:</strong> How do I redrect to a certain page after login?
      <p>when an action from the FrontEndUsers module completes it always processes the applicable smarty template.  In that template, there is usually a "final message" displayed indicating the success of the action.  If you wish to instead redirect to another content page,  you can use plugins such as <code>{cms_selflink}</code>, <code>{cms_action_url}</code>, <code>{redirect_page}</code> and <code>{redirect_url}</code> to achieve this redirection.  You could also use javascript or any other technique.</p>
      <p>Example:</p>
      <pre><code>{if !empty($final_message)}
    {cms_selflink href='members' assign='members_page_url'}
    {redirect_url to=$members_page_url}
{else}
...</code></pre>
  </li>
  <li><strong>Q:</strong> How do I adjust the forgot password email?
      <p>TODO</p>
  </li>
  <li><strong>Q:</strong> How do I adjust the email verification message?
      <p>TODO</p>
  </li>
  <li><strong>Q:</strong> How do I turn off captcha for FEU only?
      <p>Add <code>{cms_module_hint module=FrontEndUsers nocaptcha=1}</code> to your page template before the primary content block.</p>
  </li>
  <li><strong>Q:</strong> How do I display the login form inline?
      <p>To display the login form inline, you can add the inline param to the form_start tag of the login template. i.e:</p>
      <pre><code>{form_start inline=1}{cge_form_csrf}...</code></pre>
      <p><strong>Note:</strong> This will effect only the results of the immediate login form.  So only issues related to the login will be displayed in the same area.  Once login is successful, the template will be displayed again in non-inline form (replacing the contents of the default content block)</p>
  </li>
</ul>
<a class="nav" href="#top">Back to top</a>


<h3 id="templates">About templates</h3>
<p>Using a custom template for a frontend action of FEU is a three step process:</p>
<ol>

   <li>Copy the desired template file to a new location.
       <p>When FEU is shipped, it's factory templates will be located in /modules/FrontEndUsers/templates.  Each different action has a different default template:</p>
       <ul>
	   <li>The login form
	       <p>Location:  <code>/modules/FrontEndUsers/templates/orig_loginform.tpl</code></p>
	   </li>
	   <li>The change settings form
	       <p>Location:  <code>/modules/FrontEndUsers/templates/orig_changesettings.tpl</code></p>
	   </li>
	   <li>The forgot password form
	       <p>Location:  <code>/modules/FrontEndUsers/templates/orig_forgotpassword.tpl</code></p>
	   </li>
	   <li>The forgot password verification form
	       <p>Location:  <code>/modules/FrontEndUsers/templates/orig_verifycode.tpl</code></p>
	   </li>
	   <li>The logout form
	       <p>Location:  <code>/modules/FrontEndUsers/templates/orig_logoutform.tpl</code></p>
	   </li>
	   <li>The lost username form
	       <p>Location:  <code>/modules/FrontEndUsers/templates/orig_lostunform_template.tpl</code></p>
	   </li>
	   <li>the user verification form
	       <p>Location:  <code>/modules/FrontEndUsers/templates/orig_verifyonly.tpl</code></p>
	   </li>
	   <li>The force password change form
	       <p>Location:  <code>/modules/FrontEndUsers/templates/orig_force_newpw_form.tpl</code></p>
	   </li>
       </ul>
       <p>You should <strong>NEVER</strong> modify these source files.  These files can be overwritten when the module is upgraded.  Always copy them to a new location.</p>

       <p>There are numerous locations where you can locate your custom templates:</p>
       <ul>
           <li>In the <code>/assets/templates</code> directory.
	       <p>Copy the factory template to a desired filename in <code>/assets/templates</code>.  Give the new file a .tpl extension.</p>
	       <p>Files in this directory are accessed by specifying the cms_file resource.   i.e:  <code>cms_file:my_login_template.tpl</code></p>
	   </li>
	   <li>In the <code>/assets/module_custom/FrontEndUsers/templates</code> directory
	       <p>You may need to create this directory structure, as it does not exist by default.  Files in the module_custom directory will not be overwritten when the module is upgraded.</p>
	       <p>Files in this directory MUST end with a .tpl extension, and are accessed by just specifying the filename.  i.e.:  <code>my_login_template.tpl</code></p>
	   </li>
	   <li>In Design Manager
	       <p>Open the file in your favorite editor, and 'copy' the text into the clipboard.</p>
	       <p>Create a new template of any type in the DesignManager module. and 'paste' the contents from the clipboard into the textarea</p>
	       <p>Give the new template a name WITHOUT a .tpl extension.</p>
	       <p>Templates in design manager are accessed by just specifying the template name.  i.e: <code>my login template</code>
	   </li>
       </ul>
   </li>

   <li>Tell FEU to use the new template
       <p>In a parent page template, or in the 'smarty logic that is specific to this page' field in a content page you should use the <code>{cms_module_hint}</code> plugin to tell FEU to use the new template.  i.e.:</p>
       <pre><code>{cms_module_hint module=FrontEndUsers logintemplate="my_login_template.tpl"}</code></pre>
       <p>The example above assumes that the path to the file is:  <code>/assets/module_custom/FrontEndUsers/templates/my_login_template.tpl</code>
       <p>The {cms_module_hint} plugin tells CMS to provide that parameter to the module by default when it is called.  This plugin must be called BEFORE the primary content block in your template.   You may call this plugin multiple times to preset parameters for different modules. i.e:</p>
       <pre><code>{cms_module_hint module=FrontEndUsers logintemplate='my_login_template.tpl'}<br/>
{cms_module_hint module=FrontEndUsers changesettingstemplate='my_changesettings_template.tpl'}<br/>
{cms_module_hint module=FrontEndUsers logouttemplate='my_logoutsection_template.tpl'}</code></pre>
   </li>

   <li>Modify and test your new template
       <p>If the template is stored in the filesystem you can now use your favorite editor, and source code management system to manage this file.</code>
   </li>
</ol>
<a class="nav" href="#top">Back to top</a>

<h3 id="emails">About emails</h3>
<p>This module can send emails to various people at different times.  This uses the templatable email functionality provided by the CGExtensions module.  The following email templates are provided:</p>
<ul>
    <li><code>emails/forgotpassword.eml</code>
        <p>This email template is used to send a message to the user when the user completes the forgotten password form, and must reset their password.</p>
    </li>
    <li><code>notify_must_verify.eml</code>
        <p>This email template is used to send a message to the user when a user account is adjusted so that the user must verify their account ownership.</p>
    </li>
</ul>
<p>To customize these templates, you should copy the appropriate file to the <code>/assets/module_custom/FrontEndUsers/emails</code> directory below the CMSMS root path.  Create the directory if necessary.   You should NEVER modify the files in the module's source code directory.</p>
<p>See the help in the CGExtensions module for information about the structure of .eml files.</p>
<a class="nav" href="#top">Back to top</a>

<h3 id="auth">Authentication and Cookies</h3>
<p>This module, when using the built-in authentication mechanism, sets a cookie containing an authorization token.  The authorization token has no personal information.  It contains a user id, a token expiry date, and a token identifier.  For security purposes the token is digitally signed to prevent hacking.</p>
<p>If the rememberme functionality is enabled, and the user has clicked 'remember me'  then the authorization token is stored as a permanent cookie that expires after 90 days.  After which the user must re-login.  Otherwise, a session cookie is created which is deleted or expires when the user closes the browser or 8 hours has occurred.  Whichever comes first.</p>
<p>When using the session cookie, and the user regularly uses the website, the cookie will be regularly updated to extend its expiry.  This means that so long as the user keeps his browser window open AND regularly interacts with the website he sould never be logged out.</p>
<p>Authentication tokens are checked for validity against the database approximately every 2 minutes when a user is actively using your application.  Using the logout user functionality in the admin panel will delete the authentication tokens from the database.  It may take up to 2 minutes for the user to be 'logged out'.</p>
<p><strong>Note:</strong> The FEU User list is cached for up to 1 hour, or until a user is changed, created or deleted.</p>
<p><strong>Note:</strong> If your application only uses a small amount of FEU functionality, you should ensure that the FEU module is triggered on every content page.  A convenient way to do this is to call {$uid=feu_smarty::get_current_userid()} in even an anonymous page template.</p>
<a class="nav" href="#top">Back to top</a>

<h3 id="hooks">Hooks</h3>
<p>This module uses Hooks to tie in external functionality.  The following hooks are available:</p>
<ul>
    <li><code>FrontEndUsers::BeforeChangeSettings(array)</code>
        <p>Sent after the change settings form has been submitted, but before any validation occurs.</p>
	<p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>uid</code> : int - The user id</li>
	</ul>
    </li>
    <li><code>FrontEndUsers::ChangeSettingsAfterValidate(array)</code>
        <p>Sent after all validation is done in the change settings form, but before anything is saved to the database.</p>
	<p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>uid</code> : int - The user id</li>
	</ul>
    </li>
    <li><code>FrontEndUsers::OnCreateUser(array)</code>
        <p>Sent after a user is created in the database.</p>
        <p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>id</code> : int - The user id</li>
	   <li><code>name</code> : string - The username</li>
	</ul>
    </li>
    <li><code>FrontEndUsers::OnUpdateUser(array)</code>
        <p>Sent after a user information is edited in the database.</p>
        <p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>id</code> : int - The user id</li>
	</ul>
	<p><strong>Note:</strong> This hook may be called multiple times on the same request, for the same user if multiple properties are changed.</p>
    </li>
    <li><code>FrontEndUsers::OnDeleteUser(array)</code>
        <p>Sent before a user is removed from  the database.</p>
        <p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>id</code> : int - The user id</li>
	   <li><code>username</code> : string - The username</li>
	</ul>
    </li>
    <li><code>FrontEndUsers::AfterDeleteUser(array)</code>
        <p>Sent after a user is removed from  the database.</p>
        <p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>id</code> : int - The user id</li>
	   <li><code>username</code> : string - The username</li>
	</ul>
    </li>
    <li><code>FrontEndUsers::OnCreateGroup(array)</code>
        <p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>id</code> : int - The group id</li>
	   <li><code>name</code> : string - The group name</li>
	   <li><code>description</code> : string - The group description</li>
	</ul>
    </li>
    <li><code>FrontEndUsers::OnUpdateGroup(array)</code>
        <p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>id</code> : int - The group id</li>
	   <li><code>name</code> : string - The group name</li>
	   <li><code>description</code> : string - The group description</li>
	</ul>
    </li>
    <li><code>FrontEndUsers::OnDeleteGroup(array)</code>
        <p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>id</code> : int - The group id</li>
	   <li><code>name</code> : string - The group name</li>
	</ul>
    </li>
    <li><code>FrontEndUsers::BeforeLogin(array)</code>
        <p>Sent before a normal user, using the FEU built in login form, user is authenticated or logged in. Handlers can throw the <code>FeuLoginFailedException</code> to generate an error.</p>
        <p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>username</code> : string - The provided username.</li>
	   <li><code>groups</code> : string - A list of onlygroups (see the onlygroups param)</li>
	   <li><code>ip</code> : string - The IP address detected.</li>
	</ul>
    </li>

    <li><code>FrontEndUsers::AfterLoginAuth(array)</code>
        <p>Sent after a normal user, using a standard FEU login form, is authenticated, but before actually being logged in.  This hook is useful to allow other modules to do additional security checks.  Handlers can throw a <code>FeuLoginFailedException</code> to generate an error.</p>
        <p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>id</code> : int - The id detected for this username.</li>
	   <li><code>username</code> : string - The provided username.</li>
	   <li><code>groups</code> : string - A list of onlygroups (see the onlygroups param)</li>
	   <li><code>ip</code> : string - The IP address detected.</li>
	</ul>
    </li>

    <li><code>FrontEndUsers::OnLoginFailed(array)</code>
        <p>Sent from the standard FEU login form, when a login attempt has failed for some reason.</p>
        <p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>username</code> : string - The provided username.</li>
	   <li><code>uid</code> : int - The detected uid, if any.</li>
	   <li><code>msg</code> : string - The error message associated witht he failed login attempt.</li>
	</ul>
    </li>

    <li><code>FrontEndUsers::OnExpireUser(array)</code>
        <p>Sent when a user session is expired, and the user is logged out.</p>
        <p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>id</code> : int - The expired userid.</li>
	   <li><code>username</code> : string - The expired username.</li>
	</ul>
    </li>

    <li><code>FrontEndUsers::BeforeAnonimizeUser(int $uid)</code>
        <p>Sent immediately before a user is anonimized.</p>
	<p>Parameters:</p>
	<ul>
	    <li><code>$uid</code> : int - The userid to expire.</li>
	</ul>
    </li>

    <li><code>FrontEndUsers::AfterAnonimizeUser(int $uid)</code>
        <p>Sent immediately after a user is anonimized.</p>
	<p>Parameters:</p>
	<ul>
	    <li><code>$uid</code> : int - The userid to expire.</li>
	</ul>
    </li>

    <li><code>FrontEndUsers::AferVerify(array)</code>
        <p>Sent immediately after a user account is verified.</p>
        <p>Parameters (as an associative array)</p>
	<ul>
	    <li><code>uid</code> : int - The userid to expire.</li>
	</ul>
    </li>

    <li><code>FrontEndUsers::ClearUserHistory(int $older_than)</code>
        <p>Sent immediately before user history is cleared from the database.</li>
        <p>Parameters:</p>
	<ul>
	    <li><code>$older_than</code> : int - A unix timestamp containing the maximum time of records to keep.</li>
	</ul>
    </li>

    <li><code>FrontEndUsers::OnLogin(array)</code>
        <p>Sent after a successful login operation.  This hook is triggered from the API</p>
        <p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>id</code> : int - The userid.</li>
	   <li><code>ip</code> : string - The IP address detected.</li>
	</ul>
    </li>

    <li><code>FrontEndUsers::OnLogout(array)</code>
        <p>Sent after a user has been logged out of the system.</p>
        <p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>id</code> : int - The userid.</li>
	</ul>
    </li>

    <li><code>FrontEndUsers::LostUsernameQueryFailure())</code>
        <p>Sent when the lostusername form fails to find a unique user.</p>
        <p>Parameters: <strong>none</strong></p>
    </li>

    <li><code>FrontEndUsers::AfterVerify(array)</code>
        <p>Sent after a user has successfully finished the verifycode step.</p>
        <p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>uid</code> : int - The userid.</li>
	</ul>
    </li>
</ul>
<a class="nav" href="#top">Back to top</a>

<h3 id="requires">Requirements</h3>
<ul>
   <li>Openssl extensions</li>
</ul>

<h3>See Also:</h3>
<ul>
  <li>CGFEUAuth - Provides the ability to allow users to register themselves, including paid registration options.</li>
  <li>CGUserDirectory - Provides the ability to browse and search through the profile information of known users.</li>
</ul>
<a class="nav" href="#top">Back to top</a>

<h3 id="background">Background Tasks</h3>
<p>This module performs background processing via the CMSMS 'Regular task' mechanism to do regular administrative tasks.  These are:</p>
<ul>
   <li>Removing expired authentication tokens
       <p>Approximately every two hours, the system will delete authorization tokens from the database that have been expired for at least 5 minutes.</p>
   </li>
   <li>Cleaning user history
       <p>If configured, approximately once per day the module will remove all user history entries that are older than the specified (in the config file) number of days.</p>
       <p>Config file entry:  feu_clearhistory_age</p>
   </li>
   <li>Cleaning expired verification codes.
       <p>If configured, approximately every two hours, the module will remove temp codes that have expired.</p>
       <p>Config file entry:  feu_tempcode_expiry_days</p>
   </li>
   <li>Optional forced logout functionality
       <p>When configured the system will automatically remove authentication tokens for users at specific times essentially forcing users to revalidate</li>
       <p>Config file entries:  feu_disable_rememberme, feu_forcelogout_times</p>
   </li>
</ul>
<a class="nav" href="#top">Back to top</a>

<h3 id="support">Support</h3>
<p>The module author is in no way obligated to provide support for this code in any fashion.  However, there are a number of resources available to help you with it:</p>
<ul>
<li>A bug tracking and feature request system has been created for this module <a href="http://dev.cmsmadesimple.org/projects/frontendusers">here</a>.  Please be verbose and descriptive when submitting bug reports and feature requests, and for bug reports ensure that you have provided sufficient information to reliably reproduce the issue.</li>
<li>Additional discussion of this module may also be found in the <a href="http://forum.cmsmadesimple.org">CMS Made Simple Forums</a>.  When describing an issue please make an effort to provide all relavant information, a thorough description of your issue, and steps to reproduce it or your discussion may be ignored.</li>
<li>The author, calguy1000, can often be found in the <a href="irc://irc.freenode.net/#cms">CMS IRC Channel</a>.</li>
<li>Lastly, you may have some success emailing the author directly.  However, please use this as a last resort, and ensure that you have followed all applicable instructions on the forge, in the forums, etc.</li>
</ul>
<a class="nav" href="#top">Back to top</a>

<h3 id="license">Copyright and License</h3>
<p>Copyright &copy; 2008, Robert Campbell <a href="mailto:calguy1000@cmsmadesimple.org">&lt;calguy1000@cmsmadesimple.org&gt;</a>. All Rights Are Reserved.</p>
<p>This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.</p>
<p>However, as a special exception to the GPL, this software is distributed
as an addon module to CMS Made Simple.  You may not use this software
in any Non GPL version of CMS Made simple, or in any version of CMS
Made simple that does not indicate clearly and obviously in its admin
section that the site was built with CMS Made simple.</p>
<p>This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
Or read it <a href="http://www.gnu.org/licenses/licenses.html#GPL">online</a></p>
<a class="nav" href="#top">Back to top</a>

</div><!-- #feu_help -->
