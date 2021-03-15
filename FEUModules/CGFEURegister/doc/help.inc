<h3>What Does This Do?</h3>
<p>This module is a companion module to FrontEndusers to allow users to create their own account on your website.</p>

<h3>Features:</h3>
<ul>
   <li>Works with FEU Groups and Properties</li>
   <li>Works with FrontEndUsers' email and password policies.</li>
   <li>Stores temporary user information securely</li>
   <li>Sends email reminders to users who have not registered.</li>
   <li>Requires users to verify their registration by clicking on a link in an email before being pushed live.</p>
   <li>Flexible templates</li>
   <li>Customizable email templates</li>
   <li>Username blacklist and whitelist</li>
   <li>works with captcha</li>
   <li>CSRF protection</li>
   <li>An admin interface to allow managers to manage users who have not completed the registration process.</li>
   <li>more..</li>
</ul>

<h3>How do I use it</h3>
<p>To properly use this module, you need to have the FrontEndUsers module properly configured with at least one group.  You should have already created and tested login, and logout functionality.</p>
<p>Next, after installing the module, add the <code>{CGFEURegister group='THEGROUP'}</code> tag to a content page.  You must specify the name of a valid FrontEndUsers group.</p>
<p>You should adjust your config.php file with appropriate settings <em>(see below)</em> to configure this module to your liking.</p>
<p>Other than the group parameter, most other parameters that this module utilizes should be set using the {cms_module_hint} plugin in your page template or page specific smarty logic field,  before the module is called.</p>

<div class="warning">
    <h3 id="privacy">Privacy Warning:</h3>
    <p>Administrators are responsible for managing the safety and security of any personal information collected.</p>
    <p>This module does log the IP address of users. This is not compatible with Do-Not-Track policies, and may break some laws.</p>
</div>

<h3>Parameters</h3>
<ul>
   <li><code>action</code> <em>(optional string="register")</em>
       <ul>
           <li><code>register</code> - This is the default action.  It provides the registration form.</li>
	   <li><code>repeatcode</code> - This action provides a form allowing the user to request another verification code.</li>
       </ul>
       <p>This parameter, unlike the other parameters, should be specified on the module tag.</p>
   </li>

   <li><code>group</code> <strong>required string</strong>
       <p>Used ony by the "register" action, you must specify the name of a valid FrontEndUsers group for users to register to.</p>
       <p>This parameter, unlike the other parameters, should be specified on the module tag, when calling the register action.</p>
   </li>

   <li><code>inline</code> <em>(optional boolean=false)</em>
       <p>Used by the "register" and "repeatcode" actions, this parameter indicates that the output from the module action, for example after the form is submitted, should replace the original tag.   This may be useful for example to place a registration form in a sidebar, etc.</p>
       <p>This parameter has no effect on the verify form action.</p>
   </li>

   <li><code>nocaptcha</code> <em>(optional boolean=false)</em>
       <p>Used by the "register" and "repeatcode" actions, this parameter indicates that captcha should not be used (even if it is available) for those actions.</p>
   </li>

   <li><code>regtemplate</code> <em>(optional string='register.tpl')</em>
       <p>Used by the default "register" action, this parameter allows specifying the name of an alternate template.  See the section about templates below.</p>
   </li>

   <li><code>afterverifytemplate</code> <em>(optional string='after_verify.tpl')</em>
       <p>Used by the "verify" action, this parameter allows specifying the name of an alternate template for data that is displayed after attempts at verification.</p>
       <p>See the section about templates below.</p>
   </li>

   <li><code>repeatcodetemplate</code> <em>(optional string='repeatcode.tpl')</em>
       <p>Used by the "repeatcode" action, this parameter allows specifying an alternate template for the repeat code form.</p>
       <p>See the section about templates below.</p>
   </li>
</ul>

<h3>Config entries</h3>
<p>This module will read some settings from the CMSMS config.php file, it can also utilize some config entries from the FrontEndusers module.</p>
<p><strong>Note:</strong> This module will not read the optional assets/configs/feu_settings.json file.</p>
<ul>
    <li><code>cgfr_login_after_verify</code> - <em>(bool=false)</em>
        <p>If enabled, after the user completes the verification of his email account, he will be immediately logged in to FEU.</p>
    </li>
    <li><code>cgfr_username_whitelist</code> - <em>(string=null)</em>
        <p>A string containing username patterns (wildcards are supported) that should be allowed to register.  If you wish to have multiple patterns separate each pattern on separate lines. i.e.:</p>
	<pre><code>$config['cgfr_username_whitelist'] = '*@mydomain.com<br/>
*@myotherdomain.com';</code></pre>
        <p>If this config entry is specified and the cgfr_username_blacklist is not, then ONLY users matching these patterns will be able to register.</p>
    </li>
    <li><code>cgfr_username_blacklist</code> - <em>(string=null)</em>
        <p>A string containing username patterns (wildcards are supported) that are absolutely not allowed to register.  If you wish to have multiple patterns, separate each pattern on separate lines.  i.e.:</p>
	<pre><code>$config['cgfr_username_blacklist'] = 'root@*<br/>
*@baddomain.com';</code></pre>
    </li>
    <li><code>cgfr_onregister_notify_admingroup</code> - <em>(string=null)</em>
         <p>If this is the name of a valid admin group <em>(case sensitive)</em> Then the members of this group will be notified that a user has registered
	   using the "admin_notify_userregistered.eml" template.
	 </p>
    </li>
    <li><code>cgfr_onpush_notify_admingroup</code> - <em>(string=null)</em>
         <p>If this is the name of a valid admin group <em>(case sensitive)</em> Then the members of this group will be notified that a user has completed
	   the registration process, and has been pushed to FEU using the "admin_notify_userregistered.eml" template.
	 </p>
    </li>
    <li><code>cgfr_disable_repeatcode</code> - <em>(bool=false)</em>
         <p>Use this config entry to completely disable the repeatcode action.</p>
    </li>
    <li><code>cgfr_verifycode_expire_hours</code> - <em>(int=24*7)</em>
         <p>This config entry specifies the number of hours that an expiry code is valid for.  If set to 0 then codes do not expire on their own.</p>
    </li>
    <li><code>cgfr_user_expire_hours</code> - <em>(int=24*7)</em>
         <p>This config entry specifies the number of hours that user has to complete the registration process.  If set to 0 then user accounts never expire.</p>
    </li>
    <li><code>cgfr_repeatcode_page</code> - <em>(string="")</em>
        <p>This config entry is used by the task that reminds users to register to specify a page to returnto in the link that is provided within that email.  It specifies a page alias of a content page.</p>
	<p>If not specified, the default content page will be used.</p>
	<p>This config entry is not specifically needed, you can specify the page in the on_remind.eml template.</p>
    </li>
    <li><code>cgfr_remindusers_after_hours</code> - <em>(int=24)</em>
         <p>This config entry enables functionality that will send emails to users who have registered, but have not verified their account with a registration code.  By default the email will be sent every 24 hours after registration UNTIL the user is pushed live into FEU.  If this value is set to 0 then no reminders will be sent.</p>
    </li>
    <li><code>feu_username_is_email</code> - <em>(bool=true)</em>
         <p>This is the boolean setting used by the FrontEndUsers module that controls the type of field used for the username.</p>
    </li>
    <li><code>feu_expireage_months</code> - <em>(int=520)</em>
         <p>This is the integer setting used by the FrontEndUsers module to indicate the number of months beofre new user accounts expire.</p>
	 <p>This is used when creating the user account in the FrontEndUsers module. User expiry can be adjusted on a per-user basis from within FEU.</p>
    </li>
</ul>

<h3>Templates</h3>
<p>Using a custom template for a frontend action of CGFEURegister is a three step process:</>
<ol>
   <li>Copy the desired template file to a new location.
       <p>When CGFEURegister is shipped, it's factory templates will be located in /modules/CGFEURegister/templates.  Each different action has a different default template:</p>
       <ul>
           <li>The registration form
	       <p>Location:  <code>/modules/CGFEURegister/templates/register.tpl</code></p>
	   </li>
	   <li>The verify message
	       <p>Location:  <code>/modules/CGFEURegister/templates/after_verify.tpl</code></p>
	   </li>
	   <li>The requestcode form
	       <p>Location:  <code>/modules/CGFEURegister/templates/requestcode.tpl</code></p>
	   </li>
       </ul>
       <p>You should <strong>NEVER</strong> modify these source files.  These files can be overwritten when the module is upgraded.  Always copy them to a new location.</p>

       <p>There are numerous locations where you can locate your custom templates:</p>
       <ul>
	   <li>Into the <code>/assets/module_custom/CGFEURegister/templates</code> directory <strong>(recommended)</strong>.
	       <p>You may need to create this directory structure, as it does not exist by default.  Files in the module_custom directory will not be overwritten when the module is upgraded.</p>
	       <p>Files in this directory MUST end with a .tpl extension, and are accessed by just specifying the filename.  i.e.:  <code>my_login_template.tpl</code></p>
	   </li>
           <li>Into the <code>/assets/templates</code> directory.
	       <p>Copy the factory template to a desired filename in <code>/assets/templates</code>.  Give the new file a .tpl extension.</p>
	       <p>Files in this directory are accessed by specifying the cms_file resource.   i.e:  <code>cms_file:my_login_template.tpl</code></p>
	   </li>
	   <li>Into Design Manager
	       <p>Open the file in your favorite editor, and 'copy' the text into the clipboard.</p>
	       <p>Create a new template of any type in the DesignManager module. and 'paste' the contents from the clipboard into the textarea</p>
	       <p>Give the new template a name WITHOUT a .tpl extension.</p>
	       <p>Templates in design manager are accessed by just specifying the template name.  i.e: <code>registertemplate=""my login template"</code></p>
	   </li>
       </ul>
   </li>

   <li>Tell CGFEURegister to use the new template
       <p>In a parent page template, or in the 'smarty logic that is specific to this page' field in a content page you should use the <code>{cms_module_hint}</code> plugin to tell CGFEURegister to use the new template.  i.e.:</p>
       <pre><code>{cms_module_hint module=CGFEURegister logintemplate="my_register_template.tpl"}</code></pre>
       <p>The example above assumes that the path to the file is:  <code>/assets/module_custom/CGFEURegister/templates/my_login_template.tpl</code>
       <p>The {cms_module_hint} plugin tells CMS to provide that parameter to the module by default when it is called.  This plugin must be called BEFORE the primary content block in your template.   You may call this plugin multiple times to preset parameters for different modules. i.e:</p>
       <pre><code>{cms_module_hint module=CGFEURegister logintemplate='my_register_template.tpl'}<br/>
{cms_module_hint module=CGFEURegister afterverifytemplate='my_verify_template.tpl'}<br/>
   </li>

   <li>Modify and test your new template
       <p>If the template is stored in the filesystem you can now use your favorite editor, and source code management system to manage this file.</code>
   </li>
</ol>

<h3>Emails</h3>
<p>This module uses the templatable email functionality provided by the CGExtensions module to send email messages.  The following email templates are provided:</p>
<ul>
    <li><code>emails/on_register.eml
        <p>This email template is used to send a message to the user with information as to how to verify his email address and complete the registration process.</p>
    </li>
    <li><code>emails/on_repeatcode.eml
	<p>This email template is used to send a message to the user when they have requested another verification code.</p>
    </li>
    <li><code>emails/on_remind.eml
	<p>This email template is used to send a message to the user who has registered, but has not yet completed the registratin process by verifying the registration code.</p>
	<p>Note: this email is triggered from a background task.  It is not possible to determine a users language.</p>
    </li>
    <li><code>emails/admin_notify_userregistered.eml
        <p>This email template is used to send a message to members of a named admin group indicating that a new user has registered.</p>
    </li>
    <li><code>emails/admin_notify_userpushed.eml
        <p>This email template is used to send a message to members of a named admin group indicating that a new user has completed the registration process and is now in the FrontEndUsers module.</p>
    </li>
</ul>
<p>To customize these templates, you should copy the appropriate file to the <code>/assets/module_custom/CGFEURegister/emails</code> directory below the CMSMS root path.  Create the directory if necessary.   You should NEVER modify the files in the module's source code directory.</p>
<p>See the help in the CGExtensions module for information about the structure of .eml files.</p>

<h3>Hooks</h3>
<ul>
   <li><code>CGFEURegister::PreRender()</code>
       <p>This hook sends no parameters.</p>
       <p>This hook is triggered before rendering of any frontend action.  It allows third party code to do permissions check, rate limiting etc.</p>
       <p>To stop processing, handlers should throw runtime exceptions.</p>
   </li>
   <li><code>CGFEURegister::BeforeRegister(User)</code>
       <p>This hook is triggered prior to saving the new user information to the database.  It is useful for validating data before registering a user or sending emails.</p>
       <p>Parameters:</p>
       <ul>
	    <li><code>User</code> - A user object coontaining the user registration data.</li>
       </ul>
   </li>
   <li><code>CGFEURegister::AfterRegister(User)</code>
       <p>This hook is triggered immediately after saving the new user information to the database. It is useful for triggering other third party functionality.</p>
       <p>Parameters:</p>
       <ul>
	    <li><code>User</code> - A user object coontaining the user registration data.</li>
       </ul>
   </li>
   <li><code>CGFEURegister::AfterRepeatCode(array)</code>
       <p>This hook is triggered immediately after a repeat code is sent from the repeat code action.  It is useful to tie in other third party functionality.</p>
       <p>Parameters <em>(as an associative array)</em>:</p>
       <ul>
	    <li><code>fields</code> - <em>(type=RegFieldSet)</em> - The set of fields associated with the group that the user is associated with.</li>
	    <li><code>user</code> - <em>(type=User)</em> - The user object</li>
       </ul>
   </li>
   <li><code>CGFEURegister::AfterUserPushed(array)</code>
       <p>This hook is triggered immediately after a repeat code is pushed from this module into FEU.  It is useful to tie in other third party functionality.</p>
       <p>Parameters <em>(as an associative array)</em>:</p>
       <ul>
	    <li><code>fields</code> - <em>(type=RegFieldSet)</em> - The set of fields associated with the group that the user is associated with.</li>
	    <li><code>feu_uid</code> - <em>(type=int)</em> - The new feu user id.</li>
       </ul>
   </li>
</ul>


<h3>Requirements</h3>
<ul>
    <li>Open SSL libraries for encryption.</li>
    <li>FrontEndUsers 3.0+</li>
    <li>CGExtensions</li>
</ul>

<h3>Important Classes</h3>
<ul>
     <li>The User class
         <p>This class is used to represent information about a user that is registering.  It is provided to hooks, and to various templates.</p>
         <p>Standard properties:</p>
	 <ul>
             <li><code>id</code> - <em>(type=int)</em> - The unique id within this module of the registration.  This is NOT the FEU uid.</li>
	     <li><code>created</code> - <em>(type=int)</em> - The unix timestamp of the time that this user initially registered.</li>
	     <li><code>gid</code> - <em>(type=int)</em> - The FEU group id of the group the user is registering to.</li>
	 </ul>
	 <p>Additionally, the user will have different properties associated with them such as username, password, and whatever other properties are associated with the FEU group that users are registering to.  They can be addressed such as <code>{$user->username}</code>.</p>
     </li>

     <li>The RegField class
         <p>This class is used to represent information about a particular field that a user must complete when registering.  There are a few standard fields such as username/email, password and repeat password.  There may also be additional fields that are stipulated by the FEU group that the user is registering to.</p>
	 <p>Standard properties:</p>
	 <ul>
	     <li><code>name</code> - <em>(type=string)</em> - The name of the field.</li>
	     <li><code>type</code> - <em>(type=int)</em> - The type of the field.
	          <ul>
			<li>0 == Text field</li>
			<li>1 == Checkbox field</li>
			<li>2 == Email field</li>
			<li>3 == TextArea field</li>
			<li>4 == Dropdown field</li>
			<li>5 == Multiselect field</li>
			<li>6 == Image field <em>(You should never see these fields in CGFEURegister)</em></li>
			<li>7 == Radio button group</li>
			<li>8 == Date field</li>
			<li>9 == Data field <em>(You should never see these fields in CGFEURegister)</em></li>
			<li>10 == Tel field</li>
		  </ul>
             </li>
	     <li><code>prompt</code> - <em>(type=string)</em> - A prompt to use for the field.
	         <p>It is not mandatory that you use the prompt in emails or templates.</p></li>
	     <li><code>required</code> - <em>(type=int)</em> - Indicates the required status for this field.
	          <p>0 == off, 1 = optional, 2 == required, 3 == hidden, 4 == readonly.</p>
		  <p>Normally you should only see properties that are required or optional.</p>
             </li>
	     <li><code>options</code> - <em>(type=hash)</em> - For select, dropdown, radiobutton and multiselect fields this property will contain an associative array of options.</li>
	     <li><code>unique</code> - <em>(type=bool)</em> - Whether the value for this property must be unique across all users.</li>
	     <li><code>extra</code> - <em>(type=hash)</em></li>
	 </ul>
     </li>

     <li>The RegFieldSet class
         <p>This class represents a collection of RegField objects.  It is countable and iteratable.  So <code>{count($set)}</code> and <code>{foreach $set as $field}...{/foreach}</code> will work properly.</p>
	 <p>Additional methods:</p>
	 <ul>
	     <li><code>has_field(string $fieldname) : bool</code>
	         <p>This method can be used on a RegFieldSet to test if a specific field (by name) is contained in the set.</li>
	     </li>
	     <li><code>get_email_field() : RegField</code>
	         <p>This method can be used on a RegFieldSet to return the field definition of the first field that is of type 'email'.</p>
	     </li>
	 </ul>
     </li>
</ul>

<h3>Background Tasks</h3>
<p>This module performs some tasks in the backgound:</p>
<ul>
    <li>Remind users who have not completed registering.</li>
    <li>Clean up user registration data that has expired.</li>
</ul>

<h3>Support</h3>
<p>The module author is in no way obligated to provide support for this code in any fashion.  However, there are a number of resources available to help you with it:</p>
<ul>
<li>A bug tracking and feature request system has been created for this module <a href="http://dev.cmsmadesimple.org/projects/frontendusers">here</a>.  Please be verbose and descriptive when submitting bug reports and feature requests, and for bug reports ensure that you have provided sufficient information to reliably reproduce the issue.</li>
<li>Additional discussion of this module may also be found in the <a href="http://forum.cmsmadesimple.org">CMS Made Simple Forums</a>.  When describing an issue please make an effort to provide all relavant information, a thorough description of your issue, and steps to reproduce it or your discussion may be ignored.</li>
<li>The author, calguy1000, can often be found in the <a href="irc://irc.freenode.net/#cms">CMS IRC Channel</a>.</li>
<li>Lastly, you may have some success emailing the author directly.  However, please use this as a last resort, and ensure that you have followed all applicable instructions on the forge, in the forums, etc.</li>
</ul>

<h3>Copyright and License</h3>
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
