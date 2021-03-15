<?php
$lang['readonly'] = 'Irakurtzeko soilik';
$lang['prompt_usermanipulator'] = 'User Manipulator Class';
$lang['admin_loggout'] = 'Administratzaileak saiotik bota du';
$lang['prompt_loggedinonly'] = 'Saioa hasita duten erabiltzaileak erakutsi';
$lang['prompt_logout'] = 'Erabiltzailea saiotik atera';
$lang['user_properties'] = 'Erabiltzailearen Propietateak';
$lang['userhistory'] = 'Erabiltzailearen Historiala';
$lang['export'] = 'Exportatu';
$lang['clear'] = 'Garbitu';
$lang['prompt_exportuserhistory'] = 'Exportatu Erabiltzaile Historiala ASCII formatura';
$lang['prompt_clearuserhistory'] = 'Garbitu Erabiltzaile Historialaren erregistroak';
$lang['title_userhistorymaintenance'] = 'Erabiltzaile Historialaren Mantenua';
$lang['yes'] = 'Bai';
$lang['no'] = 'Ez';
$lang['prompt_of'] = 'Of';
$lang['date_allrecords'] = '** Mugarik gabe **';
$lang['date_onehourold'] = 'Ordubetekoa';
$lang['date_sixhourold'] = 'Sei ordutakoa';
$lang['date_twelvehourold'] = 'Hamabi ordutakoa';
$lang['date_onedayold'] = 'Egun batekoa';
$lang['date_oneweekold'] = 'Astebetekoa';
$lang['date_twoweeksold'] = 'Bi Astetakoa';
$lang['date_onemonthold'] = 'Hilabetekoa';
$lang['date_threemonthsold'] = 'Hiru Hilabetetakoa';
$lang['date_sixmonthsold'] = 'Sei Hilabetetakoa';
$lang['date_oneyearold'] = 'Urtebetakoa';
$lang['title_groupsort'] = 'Taldekaketa eta Sailkaketa';
$lang['prompt_recordsfound'] = 'Bilaketa-irizpidea betetzen duten erregistroak';
$lang['sortorder_username_desc'] = 'Erabiltzaile-izena beheranzka';
$lang['sortorder_username_asc'] = 'Erabiltzaile-izena goranzka';
$lang['sortorder_date_desc'] = 'Data beheranzka';
$lang['sortorder_date_asc'] = 'Data goranzka';
$lang['sortorder_action_desc'] = 'Gertaera-mota beheranzka';
$lang['sortorder_action_asc'] = 'Gertaera-mota goranzka';
$lang['sortorder_ipaddress_desc'] = 'IP helbidea beheranzka';
$lang['sortorder_ipaddress_asc'] = 'IP helbidea goranzka';
$lang['info_nohistorydetected'] = 'Ez da Historialik topatu';
$lang['reset'] = 'Berrezarri';
$lang['prompt_group_ip'] = 'IP helbidearen arabera Taldekatu';
$lang['prompt_filter_eventtype'] = 'Gertaera-mota iragazkia';
$lang['prompt_filter_date'] = 'Hau baino gutxiago diren gertaerak bakarrik erakutsi:';
$lang['prompt_pagelimit'] = 'Orrialde-muga';
$lang['for'] = 'for';
$lang['title_userhistory'] = 'Erabiltzaile Historialaren Txostena';
$lang['unknown'] = 'Ezezaguna';
$lang['prompt_ipaddress'] = 'IP Helbidea';
$lang['prompt_eventtype'] = 'Gertaera-mota';
$lang['prompt_date'] = 'Data';
$lang['prompt_return'] = 'Itzuli';
$lang['import_complete_msg'] = 'Inportasio-eragiketa Amaituta';
$lang['prompt_linesprocessed'] = 'Prozesaturiko lerroak';
$lang['prompt_errors'] = 'Erroreak aurkitu dira';
$lang['prompt_recordsadded'] = 'Erregistruak gehituta';
$lang['error_noresponsefromserver'] = 'Ezin izan da SMTP zerbitzaritik erantzunik jaso';
$lang['error_importfilenotfound'] = 'Ezin izan da adierazitako fitxategia (%s) topatu';
$lang['error_importfieldvalue'] = 'Invalid value for dropdown or multiselect field %s';
$lang['error_importfieldlength'] = 'Field %s exceeds maximum length';
$lang['error_importusers'] = 'Import Error (line %s): %s';
$lang['error_propertydefns'] = 'Could not get the property definitions (internal error)';
$lang['error_importrequiredfield'] = 'Could not find a column to match the required field %s';
$lang['error_nogroupproperties'] = 'Could not find properties for the specified group';
$lang['error_importfileformat'] = 'The file specified for import is not in the correct format';
$lang['error_couldnotopenfile'] = 'Could not open file';
$lang['info_importusersfileformat'] = '<h4>File Format Information</h4>
<p>The input file must be in ASCII format using comma separated values.  Each line in this input file (with the exception of the header line, discussed below) represents one user record.  Each line must contain the same number of fields, and the order of the fields in each line must be identical.</p>
<h5>Header line</h5>
<ul>
<li>The first line of the file must begin with two pound (\#) characters, and names each of the fields in the file.  The names of these fields is significant.  There are some required field names (see below), and other field names must match the property names associated with the group users are going to be added into.</li>
<li>The import process will fail if the fields in the input file does not match all of the required properties associated with the group that users are being added into</li>
<li>The input file may contain fields representing some of the optional properties in the specified group.</li>
<li>The import process will ignore any fields in the input file that are either not known, or map to properties that are <em>off</em> in the specified user group.</li>
</ul>
<h5>Columnar Data</h5>
<ul>
<li>The <strong>username</strong> Field - The desired username.
    <p>This field must exist in the headerline, and in eacn and every line of the input file. The record will fail if a user with that username already exists in the database.</p></li>
<li>The <strong>password</strong> Field - Todo</li>
<li>The <strong>expires</strong> Field - Todo</li>
<li>Dropdown Fields
    <p>The value of dropdown properties in an import file is represented as the string that is shown in the dropdown control in the FrontEndUsers module.</p>
</li>
<li>Multiselect Fields
    <p>Multiselect fields are contained within the ASCII file as a : separated list of strings, where each string represents the text shown in the multiselect list</p>
</li>
<li>Image Fields
    <p>Image are fields who&#039;s column name matches a property of type Image.  If this field is a required part of the destination group, then the name specified in these columns must exist in the uploads disrectory of the CMS installation.  If the image does not exist, and the field is required, then the record will fail.</p>
</ul>
<h5>Notes</h5>
<p>The import process is subject to the limitations imposed by the host provider, such as memory limitations, processing time, file size upload, and safe mode restrictions.  Any one of these limitations may cause the import to fail. Therefore it is advisable to ensure that import files are smaller in size, and simpler in nature.</p>
<p>Though every effort has been made to ensure that database corruption will not occur, it is advisable to perform a database backup before doing a user import.</p>
<h5>Example</h5>
<pre>
##username,first_name,last_name,email,city,state,country,zip
user1,test,user,user1@somedomain.com,somewhere,TX,US,12345
</pre>
';
$lang['prompt_importdestgroup'] = 'Import Users Into This Group';
$lang['prompt_importfilename'] = 'Input CSV File';
$lang['prompt_exportusers'] = 'Export Users';
$lang['prompt_importusers'] = 'Import Users';
$lang['prompt_clear'] = 'Clear';
$lang['prompt_image_destination_path'] = 'Image Destination Path';
$lang['error_missing_upload'] = 'A problem occurred with a missing (but required) upload';
$lang['error_notemptygroup'] = 'Cannot delete a group that still has users';
$lang['error_norepeatedlogins'] = 'This user is already logged in';
$lang['error_captchamismatch'] = 'The text from the image was not entered correctly';
$lang['prompt_allow_repeated_logins'] = 'Allow users to login more than once';
$lang['prompt_allowed_image_extensions'] = 'Image File Extensions that Users allowed to upload';
$lang['event_help_OnDeleteUser'] = '<h3>OnDeleteUser<h3>
<p>An event generated when a user is deleted</p>
<h4>Parameters</h4>
<ul>
<li><em>username</em> - The user name</li>
<li><em>id</em> - The user id</li>
</ul> 
';
$lang['event_help_OnCreateUser'] = '<h3>OnCreateUser<h3>
<p>An event generated when a user is created</p>
<h4>Parameters</h4>
<ul>
<li><em>name</em> - The user name</li>
<li><em>id</em> - The user id</li>
</ul> 
';
$lang['event_help_OnUpdateUser'] = '<h3>OnUpdateUser<h3>
<p>An event generated when a user is updated (either by user themself or admin)</p>
<h4>Parameters</h4>
<ul>
<li><em>name</em> - The user name</li>
<li><em>id</em> - The user id</li>
</ul> 
';
$lang['event_help_OnCreateGroup'] = '<h3>OnCreateGroup<h3>
<p>An event generated when a group is created</p>
<h4>Parameters</h4>
<ul>
<li><em>name</em> - The group name</li>
<li><em>description</em> - The group description</li>
<li><em>id</em> - The group id</li>
</ul> 
';
$lang['event_help_OnDeleteGroup'] = '<h3>OnDeleteGroup<h3>
<p>An event generated when a group is deleted</p>
<h4>Parameters</h4>
<ul>
<li><em>name</em> - The group name</li>
<li><em>id</em> - The group id</li>
</ul> 
';
$lang['event_help_OnLogin'] = '<h3>OnLogin<h3>
<p>An event generated when a user logs in</p>
<h4>Parameters</h4>
<ul>
<li><em>username</em> - The name of the logged in user</li>
<li><em>ip</em> - The ip address of the client</li>
</ul>
';
$lang['event_help_OnLogout'] = '<p>An event generated when a user logs out</p>
<h4>Parameters</h4>
<ul>
<li><em>username</em> - The name of the loggedout user</li>
<li><em>id</em> - The user id</li>
</ul>
';
$lang['event_help_OnExpireUser'] = '<p>An event generated when a user session expires</p>
<h4>Parameters</h4>
<ul>
<li><em>username</em> - The name of the expired user</li>
<li><em>id</em> - The user id of the expired user</li>
</ul>
';
$lang['event_info_OnLogin'] = 'An event generated when a user logs in to the system';
$lang['event_info_OnLogout'] = 'An event generated when a user logs out of the system';
$lang['event_info_OnExpireUser'] = 'An event generated when a user session is expired';
$lang['event_info_OnCreateUser'] = 'An event generated when a new user is created';
$lang['event_info_OnUpdateUser'] = 'An event generated when a user info is updated';
$lang['event_info_OnDeleteUser'] = 'An event generated when a user account is deleted';
$lang['event_info_OnCreateGroup'] = 'An event generated when a user group is created';
$lang['event_info_OnDeleteGroup'] = 'An event generated when a user group is deleted';
$lang['backend_group'] = 'Backend Group';
$lang['info_star'] = '* The following macros can be used in these fields: {$username},{$group}. When using the {$group} macro, the system will subsitute the name of the first member group that the user belongs to, and will redirect to that page.';
$lang['info_admin_password'] = 'Edit this field to reset the users password';
$lang['info_admin_repeatpassword'] = 'Edit this field to reset the users password';
$lang['error_username_exists'] = 'A user with that username already exists';
$lang['nocsvresults'] = 'No results returned from csv export';
$lang['prompt_unfldlen'] = 'Length of username field';
$lang['prompt_pwfldlen'] = 'Length of password field';
$lang['error_invalidpasswordlengths'] = 'Min/Max password lengths are invalid';
$lang['error_invalidusernamelengths'] = 'Min/Max username lengths are invalid';
$lang['error_invalidemailaddress'] = 'Invalid Email address';
$lang['error_noemailaddress'] = 'We could not find an email address for this account';
$lang['error_problemseettinginfo'] = 'Problem setting user info';
$lang['error_settingproperty'] = 'Problem setting property';
$lang['user_added'] = 'User Added %s = %s';
$lang['user_deleted'] = 'User Deleted uid=%s';
$lang['propertyfilter'] = 'Property';
$lang['valueregex'] = 'Value (regular expression)';
$lang['warning_effectsfieldlength'] = 'Warning: These fields affect the size of input fields for forms.  Decreasing this number on an existing site may not be advisable';
$lang['confirm_submitprefs'] = 'Are you sure you want to adjust the module preferences?';
$lang['error_emailalreadyused'] = 'Email address already used';
$lang['prompt_allow_duplicate_emails'] = 'Allow duplicate emails';
$lang['info_allow_duplicate_emails'] = '(allow multiple users with the same email address)';
$lang['prompt_allow_duplicate_reminders'] = 'Allow duplicate &quot;forgot password&quot; reminders?';
$lang['info_allow_duplicate_reminders'] = '(allow a users to request a password reset, even if they haven&#039;t acted on a previous one)';
$lang['prompt_feusers_specific_permissions'] = 'Use Front-end User specific permissions?';
$lang['info_feusers_specific_permissions'] = '(Normally, FEUSers permissions are the same as the equivalent Admin Area permissions like Add User, Add Group, etc. If you select this option, there will be separate permissions for FEUsers.)';
$lang['error_missingupload'] = 'Could not find the uploaded file (internal error)';
$lang['error_missingusername'] = 'You did not enter a username';
$lang['error_missingpassword'] = 'You did not enter a password';
$lang['frontenduser_logout'] = 'Frontend User Logout';
$lang['frontenduser_loggedin'] = 'Frontend User Login';
$lang['editprop_infomsg'] = '<font color=&quot;red&quot;><b>USE CAUTION</b> when changing existing properties that are assigned to groups, you may potentially cause damage and break an existing site <i>(especially if you reduce field lengths, etc)</i></font>';
$lang['info_smtpvalidate'] = 'This function does not work on windows';
$lang['msg_dontcreateusername'] = 'Do not create a property for username, or password as these properties are builtin to the FrontEndUsers module';
$lang['prompt_exportcsv'] = 'Export Users to CSV';
$lang['exportcsv'] = 'Export';
$lang['importcsv'] = 'Import';
$lang['admin'] = 'Admin';
$lang['editprop'] = 'Edit Property';
$lang['maxlength'] = 'Maximum Length';
$lang['created'] = 'Created';
$lang['sortby'] = 'Sort By';
$lang['sort'] = 'Sorting';
$lang['usersingroup'] = 'Users in the selected group(s)';
$lang['userlimit'] = 'Limit results to';
$lang['error_noemailfield'] = 'Could not find an email field for this user.  You may need to contact the system administrator';
$lang['prompt_forgotpw_page'] = 'PageID/Alias for Forgot Password form';
$lang['prompt_changesettings_page'] = 'PageID/Alias for Change Settings form';
$lang['prompt_login_page'] = 'PageID/Alias to jump to after login *';
$lang['prompt_logout_page'] = 'PageID/Alias to jump to after logout *';
$lang['sortorder'] = 'Sort order';
$lang['prompt_numresetrecord'] = 'A number of users are in the middle of resetting lost passwords.  Currently this count is at:';
$lang['remove1week'] = 'Remove all entries more than a week old';
$lang['remove1month'] = 'Remove all entries more than a month old';
$lang['removeall'] = 'Remove all entries';
$lang['areyousure'] = 'Are you sure?';
$lang['error_invalidcode'] = 'An invalid code has been entered, please try again';
$lang['error_tempcodenotfound'] = 'A temporary code for your user id could not be found in the database';
$lang['forgotpassword_verifytemplate'] = 'Template used to display verification form';
$lang['forgotpassword_emailtemplate'] = 'Template used for forgotten password email';
$lang['error_resetalreadysent'] = 'Either yourself or someone else has already triggered a password reset operation for this account.  Check your email, you may have further instructions on how to reset your password in your inbox';
$lang['error_dberror'] = 'Database error';
$lang['message_forgotpwemail'] = 'You are receiving this message because somebody told our site that you had lost your password.  If this is the case, read the instructions below.  If you don&#039;t have a clue what this is, then you are safe to delete this message, and we thank you for your time.';
$lang['prompt_code'] = 'Code';
$lang['message_code'] = 'The following code has been generated randomly generated in order to verify the user account.  when you click on the link below you will be presented with a field to enter this code.  Normally the field is pre-completed for you, but incase it isn&#039;t the code is:';
$lang['prompt_link'] = 'Clicking on the following link will take you to the website where you can enter the above code, and reset your password:';
$lang['lostpassword_emailsubject'] = 'Lost Password';
$lang['error_nomailermodule'] = 'Could not find the CMSMailer module';
$lang['info_forgotpwmessagesent'] = 'An email has been sent to %s with instructions as to how to reset your password.  Thank you';
$lang['lostpw_message'] = 'So you forgot or lost your password. Well, type your username in here, and if we can find you we will send you an email with instructions on how to reset it';
$lang['forgotpassword_template'] = 'Forgot Password Templates';
$lang['error_propnotfound'] = 'Property %s not found';
$lang['propsfound'] = 'Properties found';
$lang['addprop'] = 'Add Property';
$lang['error_requiredfield'] = 'A required field (%s) was empty';
$lang['info_emptypasswordfield'] = 'Enter a new password here to change your password';
$lang['error_notloggedin'] = 'You do not appear to be logged in';
$lang['user_settings'] = 'Settings';
$lang['user_registration'] = 'Registration';
$lang['error_accountexpired'] = 'This account has expired';
$lang['error_improperemailformat'] = 'Improper email address formatting';
$lang['error_invalidexpirydate'] = 'Invalid expiry date';
$lang['error_problemsettingproperty'] = 'Error setting property %s for user $s';
$lang['error_invalidgroupid'] = 'Invalid group id %s';
$lang['hiddenfieldmarker'] = 'Hidden field marker';
$lang['hiddenfieldcolor'] = 'Hidden field color';
$lang['hidden'] = 'Hidden';
$lang['error_duplicatename'] = 'A property with that name is already defined';
$lang['error_noproperties'] = 'No properties defined';
$lang['error_norelations'] = 'No properties were selected for this group';
$lang['nogroups'] = 'No Groups are defined';
$lang['groupsfound'] = 'Groups Found';
$lang['error_onegrouprequired'] = 'Membership in at least one group is required';
$lang['prompt_requireonegroup'] = 'Require membership in atleast one group';
$lang['back'] = 'Back';
$lang['error_missing_required_param'] = '%s is a required field';
$lang['requiredfieldmarker'] = 'Mark required fields with';
$lang['requiredfieldcolor'] = 'Hilite required fields in';
$lang['next'] = 'Next';
$lang['error_groupexists'] = 'A Group with that name already exists';
$lang['required'] = 'Required Field';
$lang['optional'] = 'Optional';
$lang['off'] = 'Off';
$lang['size'] = 'Size';
$lang['sizecomment'] = '<br/>(Maximum size of any one dimension of the image in pixels)';
$lang['length'] = 'Length';
$lang['lengthcomment'] = '<br>(chars in the text input)';
$lang['seloptions'] = 'Dropdown options, separated by line breaks.  Values can be separated from text with a = character. i.e: Female=f';
$lang['prompt'] = 'Prompt';
$lang['prompt_type'] = 'Type';
$lang['type'] = 'Type';
$lang['text'] = 'Text';
$lang['checkbox'] = 'Checkbox';
$lang['multiselect'] = 'Multi Select List';
$lang['image'] = 'Image';
$lang['email'] = 'Email Address';
$lang['textarea'] = 'Textarea';
$lang['dropdown'] = 'Dropdown';
$lang['msg_currentlyloggedinas'] = 'Welcome';
$lang['logout'] = 'Sign out';
$lang['prompt_changesettings'] = 'Change My Settings';
$lang['error_loginfailed'] = 'Login failed - Invalid username or password?';
$lang['login'] = 'Sign in';
$lang['prompt_signin_button'] = 'Sign in button label';
$lang['prompt_username'] = 'Username';
$lang['prompt_password'] = 'Password';
$lang['register'] = 'Register';
$lang['forgotpw'] = 'Forgot Your Password?';
$lang['defaults'] = 'Defaults';
$lang['template'] = 'Template';
$lang['error_usernotfound'] = 'User ID not found';
$lang['error_usernametaken'] = 'That username (%s) is already in use';
$lang['prompt_smtpvalidate'] = 'Use SMTP to validate email addresses?';
$lang['prompt_minpwlen'] = 'Minimum Password Length';
$lang['prompt_maxpwlen'] = 'Maximum Password Length';
$lang['prompt_minunlen'] = 'Minimum Username Length';
$lang['prompt_maxunlen'] = 'Maximum Username Length';
$lang['prompt_sessiontimeout'] = 'Session Timeout (seconds)';
$lang['prompt_cookiekeepalive'] = 'Use cookies to keep logins alive';
$lang['prompt_allowemailreg'] = 'Allow Email Registration';
$lang['prompt_dfltgroup'] = 'Default Group for new users';
$lang['changesettings_template'] = 'Change Settings Template';
$lang['error_passwordmismatch'] = 'Passwords Do not match';
$lang['error_invalidusername'] = 'Invalid Username';
$lang['error_invalidpassword'] = 'Invalid Password';
$lang['edituser'] = 'Edit User';
$lang['valid'] = 'Valid';
$lang['username'] = 'Username';
$lang['status'] = 'Status';
$lang['error_membergroups'] = 'This user is not a member of any groups';
$lang['error_properties'] = 'No Properties';
$lang['value'] = 'Value';
$lang['groups'] = 'Groups';
$lang['properties'] = 'Properties';
$lang['propname'] = 'Property Name';
$lang['propvalue'] = 'Property Value';
$lang['add'] = 'Add';
$lang['history'] = 'History';
$lang['edit'] = 'Edit';
$lang['expires'] = 'Expires';
$lang['specify_date'] = 'Specify Date';
$lang['12hrs'] = '12 Hours';
$lang['24hrs'] = '24 Hours';
$lang['48hrs'] = '48 Hours';
$lang['1week'] = '1 Week';
$lang['2weeks'] = '2 Weeks';
$lang['1month'] = '1 Month';
$lang['3months'] = '3 Months';
$lang['6months'] = '6 Months';
$lang['1year'] = '1 Year';
$lang['never'] = 'Never';
$lang['postinstallmessage'] = 'Module installed sucessfully.<br/>Be sure to set the &quot;Modify FrontEndUser Properties permission.  Additionally, we recommend that you install the Captcha module.  If installed, validation of a captcha image will be required in addition to the username and password to login.  This is intended to prevent brute force attacks.  <strong>Note:</strong> The nocaptcha parameter can be used to disable this functionality even if the Captcha module is installed.&quot;';
$lang['password'] = 'Password';
$lang['repeatpassword'] = 'Again';
$lang['error_groupname_exists'] = 'Group by that name already exists';
$lang['editgroup'] = 'Edit Group';
$lang['submit'] = 'Submit';
$lang['cancel'] = 'Cancel';
$lang['delete'] = 'Delete';
$lang['confirm_editgroup'] = 'Are you sure this is the proper settings for this group?\nTurning a property off will not delete any entries in the properties table for this group/user.  They will merely be unavailable.';
$lang['areyousure_deletegroup'] = 'Are you sure you want to delete this group?';
$lang['confirm_delete_prop'] = 'Are you sure you want to completely delete this property?\nDoing so will also erase any user entries for this property.';
$lang['error_insufficientparams'] = 'Insufficient Parameters';
$lang['id'] = 'Id';
$lang['name'] = 'Name';
$lang['error_cantaddgorup'] = 'Problem adding group';
$lang['error_invalidparams'] = 'Invalid Parameters';
$lang['applyfilter'] = 'Apply';
$lang['filter'] = 'Filter';
$lang['userfilter'] = 'Username Regular Expression';
$lang['description'] = 'Description';
$lang['groupname'] = 'Group Name';
$lang['accessdenied'] = 'Access Denied';
$lang['error'] = 'Error';
$lang['addgroup'] = 'Add Group';
$lang['adduser'] = 'Add User';
$lang['usersfound'] = 'Users found that match the criteria';
$lang['group'] = 'Group';
$lang['selectgroup'] = 'Select Group';
$lang['registration_template'] = 'Registration Template';
$lang['logout_template'] = 'Logout Template';
$lang['login_template'] = 'Login Template';
$lang['preferences'] = 'Preferences';
$lang['users'] = 'Users';
$lang['friendlyname'] = 'Frontend User Management';
$lang['moddescription'] = 'Allow users to log in to the frontend of your site';
$lang['defaultfrontpage'] = 'Default front page';
$lang['lastaccessedpage'] = 'Last accessed page';
$lang['otherpage'] = 'Other page: ';
$lang['captcha_title'] = 'Enter the text from the image';
?>
