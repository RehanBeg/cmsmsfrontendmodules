<?php
$lang['enable_captcha'] = 'Enable captcha on the login form';
$lang['info_enable_captcha'] = 'If the user is not logged in, and the module preference states to display the login form, this option controls wether a captcha will be displayed on the login screen.  If captcha is available';
$lang['pagetype_unauthorized'] = 'You are not authorized to view this content';
$lang['info_contentpage_grouplist'] = 'Specify a list of FEU groups that may have access to this page.  Selecting no groups will allow any user logged in to FEU to view the page';
$lang['pagetype_settings'] = 'Apsaugoto puslapio nustatymai';
$lang['pagetype_groups'] = 'Leidžiamos grupės';
$lang['info_pagetype_groups'] = 'Select the groups that are (by default) allowed to view protected pages.  An editor with the &quot;Manage All Content&quot; permission can override this for each page';
$lang['pagetype_action'] = 'Action for insufficient access';
$lang['info_pagetype_action'] = 'Specify the behavior for people accessing this page without sufficient permission.  You can either redirect to a specified page, or display the login form';
$lang['showloginform'] = 'Rodyti prisijungimo formą';
$lang['redirect'] = 'Redirect to a Page';
$lang['pagetype_redirectto'] = 'Redirect To';
$lang['info_pagetype_redirectto'] = 'Specify the page to redirect to.  If you select none, and the action is set to &quot;redirect&quot; the user will be presented with a message indicating that they do not hace access to the page';
$lang['permissions'] = 'Permissions';
$lang['feu_protected_page'] = 'Protected Content';
$lang['prompt_viewprops'] = 'Select Additional Properties to View';
$lang['view'] = 'Žiūrėti';
$lang['info_ignore_userid'] = 'If checked the import routine will attempt to add users independant of the userid column.  If a user with the name specified in the import file already exists, an error will be generated';
$lang['ignore_userid'] = 'Ignore UserID Column on Import';
$lang['export_passhash'] = 'Export the password hash to the file';
$lang['info_export_passhash'] = 'The password hash is only useful if the password salt on the import host is identical to that of the export host';
$lang['error_adjustsalt'] = 'The password salt cannot be adjusted';
$lang['prompt_pwsalt'] = 'Password Salt';
$lang['info_pwsalt'] = 'FrontEndUsers salts all passwords with this key which is created upon install.  Once users have been added to the database the salt cannot be changed. The salt may be empty for older installs.';
$lang['advanced_settings'] = 'I&scaron;plėstiniai nustatymai';
$lang['info_sessiontimeout'] = 'Specify the number of seconds before an inactive user is automatically logged out of the website';
$lang['prompt_expireusers_interval'] = 'User Expiry Interval';
$lang['info_expireusers_interval'] = 'Specify a value (in seconds) that indicates how often the system should force users whos session has expired to be logged out.  T&quot;his is an optimization to save database queries.  If left empty or set to 0 expiry will be performed on every request.';
$lang['msg_settingschanged'] = 'Jūsų nustatymai buvo sėkmingai atnaujinti';
$lang['forcedlogouttask_desc'] = 'Force users to logout at regular intervals';
$lang['prompt_forcelogout_times'] = 'Times for forced logout';
$lang['info_forcelogout_times'] = 'Specify a comma separated list of times like HH:MM,HH:MM where users will be forcibly logged out. Note, this uses the psuedocron mechanism so you must be sure that the times entered here will coincide reasonably with your &quot;pseudocron granularity&quot; and that sufficient requests will occur to your website to ensure that pseudocron is executed.';
$lang['prompt_forcelogout_sessionage'] = 'Exclude users that have been active in <em>(minutes)</em>';
$lang['info_forcelogout_sessionage'] = 'If specified, any users that have been active in this number of seconds will not be forcibly logged out';
$lang['areyousure_delete'] = 'Ar tikrai norite i&scaron;trinti %s naudotoją?';
$lang['error_invalidfileextension'] = 'The uploaded file does not match the list of allowed file types';
$lang['postuninstall'] = 'All data associated with the FrontEndUsers module has been deleted';
$lang['info_ecomm_paidregistration'] = 'If enabled, this module will listen to events from the Ecommerce suite.  The following settings only have effect if this setting is enabled.';
$lang['prompt_ecomm_paidregistration'] = 'Listen to Order Events';
$lang['info_paidreg_settings'] = 'The following settings only apply if using self registration and allowing for paid registration';
$lang['none'] = 'None';
$lang['delete_user'] = 'I&scaron;trinti naudotoją';
$lang['expire_user'] = 'Expire User';
$lang['prompt_action_ordercancelled'] = 'Action to perform when a subscription order is cancelled';
$lang['prompt_action_orderdeleted'] = 'Action to perform when a subscription order is deleted';
$lang['ecommerce_settings'] = 'E-komenrcijos nustatymai';
$lang['securefieldmarker'] = 'Secure Field Marker';
$lang['securefieldcolor'] = 'Secure Field Color';
$lang['prompt_encrypt'] = 'Store this data encrypted in the database';
$lang['error_notsupported'] = 'The chosen option is not supported given your current configuration';
$lang['audit_user_created'] = 'User automatically created';
$lang['info_auto_create_unknown'] = 'If a user is authenticated by an external authentication module but is not known in the FrontEndUsers module should an FEU account be created automatically?';
$lang['prompt_auto_create_unknown'] = 'Automatically Create Unknown Users';
$lang['display_settings'] = 'Rodymo nustatymai';
$lang['info_std_auth_settings'] = 'The following settings are only applicable if using the &quot;Builtin Authentication&quot;.';
$lang['info_support_lostun'] = 'Selecting No will disable the ability for a user to request lost login information, irrespective of other settings';
$lang['info_support_lostpw'] = 'Selecting No will disable the ability for a user to a password reset, irrespective of other settings';
$lang['prompt_support_lostun'] = 'Allow users to request their username';
$lang['prompt_support_lostpw'] = 'Allow users to request a password change';
$lang['auth_settings'] = 'Autentifikacijos nustatymai';
$lang['authentication'] = 'Builtin Authentication';
$lang['auth_builtin'] = 'FEU Standard Authentication';
$lang['auth_module'] = 'Authentication Module/Method';
$lang['info_auth_module'] = 'The FrontendUsers module supports using alternate authentication methods, with varying capabilities.  Some functionality will not function or be disabled when not using the built in authentication method';
$lang['error_user_nonunique_field_value'] = 'The value specified for %s is already in use by another user';
$lang['unique'] = 'Unique';
$lang['error_nonunique_field_value'] = 'The value specified for %s (%s) is not unique';
$lang['prompt_force_unique'] = 'Force values of this property to be unique across all user accounts';
$lang['help_returnlast'] = 'Used with the login and logout forms, this parameter if specified will indicate that the user should be returned to the page (by url) that the user was viewing before the action occurred.  This parameter will override the redirect preferences, and the returnto parameter.';
$lang['help_noinline'] = 'Used with one of the forms, this parameter specifies that the forms should not be placed inline, instead the resulting output after form submission will replace the default content block';
$lang['title_reset_session'] = 'Įspėjimas apie prisijungimo sesijos pabaigą';
$lang['msg_reset_session'] = 'Jūsų prisijungimo sesijos galiojimas artėja prie pabaigos. Pra&scaron;om paspauskite &quot;Pratęsti&quot; mygtuką, jei norite pratęsti prisijungimo sesijos galiojimą';
$lang['ok'] = 'Pratęsti';
$lang['resetsession_template'] = 'Sesijos atnaujinimo &scaron;ablonas';
$lang['info_name'] = 'This is the field name, to be used for addressing in smarty.  It must consist of only alphanumeric characters and underscores.';
$lang['visitors_tab'] = 'Lankytojai';
$lang['feu_groups_prompt'] = 'Pasirinkite vieną ar daugiau FEU grupių, kurioms bus leista matyti &scaron;į puslapį';
$lang['error_mustselect_group'] = 'Turi būti pasirinkta grupė';
$lang['selectone'] = 'Pasirinkite vieną';
$lang['start_year'] = 'Pradžios metai';
$lang['end_year'] = 'Pabaigos metai';
$lang['date'] = 'Data';
$lang['prompt_thumbnail_size'] = 'Miniatiūros dydis';
$lang['OnUpdateGroup'] = 'On User Group Modified';
$lang['error_toomanyselected'] = 'Too many users are selected for bulk operations.... Please trim it to 250 or less';
$lang['confirm_delete_selected'] = 'Ar tikrai norite i&scaron;trinti &scaron;į naudotoją?';
$lang['delete_selected'] = 'I&scaron;trinti pasirinktus';
$lang['prompt_randomusername'] = 'Pridedant naujus naudotojus generuoti atsitiktinį naudotojo vardą';
$lang['months'] = 'mėnesiai';
$lang['prompt_expireage'] = 'Numatytasis naudotojo galiojimo terminas';
$lang['notification_settings'] = 'Prane&scaron;imo nustatymai';
$lang['property_settings'] = 'Savybių nustatymai';
$lang['redirection_settings'] = 'Peradresavimo nustatymai';
$lang['general_settings'] = 'Pagrindiniai nustatymai';
$lang['session_settings'] = 'Sesijos ir slapukų nustatymai';
$lang['field_settings'] = 'Lauko nustatymai';
$lang['error_lostun_nonrequired'] = 'The lostusername flag can only be used on required fields';
$lang['prop_textarea_wysiwyg'] = 'Allow use of wysiwyg on this text area';
$lang['info_cookiestoremember'] = '<strong>Note: </strong> This uses the mcrypt functions for encryption purposes, and they could not be detected on your install.   Please contact your server administrator.';
$lang['editing_user'] = 'Redaguoti naudotoją';
$lang['noinline'] = 'Do not inline forms';
$lang['info_lostun'] = 'Spauskite čia, jei neatsimenate savo prisijungimo detalių';
$lang['info_forgotpw'] = 'Spauskite čia, jei neatsimenate savo slaptažodžio';
$lang['info_logout'] = 'Norėdami atsijungti spauskite čia';
$lang['info_changesettings'] = 'Paspauskite čia slaptažodžio ar kitos informacijos keitimui';
$lang['viewuser_template'] = 'Naudotojo peržiūrėjimo &scaron;ablonas';
$lang['event'] = 'Įvykis';
$lang['feu_event_notification'] = 'FEU Event Notification';
$lang['prompt_notification_address'] = 'E. pa&scaron;to adresas prane&scaron;imams';
$lang['prompt_notification_template'] = 'Prane&scaron;imo e. pa&scaron;tu &scaron;ablonas';
$lang['prompt_notification_subject'] = 'Prane&scaron;imo e. pa&scaron;tu tema';
$lang['prompt_notifications'] = 'Prane&scaron;imai e. pa&scaron;tu';
$lang['OnLogin'] = 'Prisijungus';
$lang['OnLogout'] = 'Atsijungus';
$lang['OnExpireUser'] = 'Pasibaigus sesijai';
$lang['OnCreateUser'] = 'Sukūrus naują naudotoją';
$lang['OnDeleteUser'] = 'I&scaron;trynus naudotoją';
$lang['OnUpdateUser'] = 'Kai naudotojų nustatymai pakeisti';
$lang['OnCreateGroup'] = 'Kai naudotojų grupė sukurta';
$lang['OnDeleteGroup'] = 'Kai naudotojų grupė i&scaron;trinta';
$lang['lostunconfirm_premsg'] = 'The lost login details functionality has successfully completed.  We have found a unique username that matches the details you entered.';
$lang['your_username_is'] = 'Jūsų naudotojo vardas yra';
$lang['lostunconfirm_postmsg'] = 'We recommend you record this information in a secure, but retrievable location.';
$lang['prompt_after_change_settings'] = 'PageID/Alias to jump to after change settings';
$lang['prompt_after_verify_code'] = 'PageID/Alias to jump to after code verification *';
$lang['lostun_details_template'] = 'Prarasto naudotojo vardo detalių &scaron;ablonas';
$lang['lostun_confirm_template'] = 'Naudotojo pamir&scaron;to vardo &scaron;ablonas';
$lang['error_nonuniquematch'] = 'Error: More than one user account matched the properties specified';
$lang['error_cantfinduser'] = 'Error: Could not find a matching user';
$lang['error_groupnotfound'] = 'Klaida - grupė tokiu vardu nerasta';
$lang['readonly'] = 'Tik skaitymui';
$lang['prompt_usermanipulator'] = 'Naudotojų manipuliatoriaus klasė';
$lang['admin_logout'] = 'Atjungtas administratoriaus';
$lang['prompt_loggedinonly'] = 'Rodyti tik prisijungusius naudotojus';
$lang['prompt_logout'] = 'Atjungti &scaron;į naudotoją';
$lang['user_properties'] = 'Naudotojo sąvybės';
$lang['userhistory'] = 'Naudotojo istorija';
$lang['export'] = 'Eksportuoti';
$lang['clear'] = 'Valyti';
$lang['prompt_exportuserhistory'] = 'Export User History To ASCII that is at least';
$lang['prompt_clearuserhistory'] = 'Clear User History records that is at least';
$lang['title_lostusername'] = 'Užmir&scaron;ote prisijungimo detales??';
$lang['title_rssexport'] = 'Export group definition (and properties) to XML';
$lang['title_userhistorymaintenance'] = 'User History Maintenance';
$lang['yes'] = 'Taip';
$lang['no'] = 'Ne';
$lang['prompt_of'] = 'i&scaron;';
$lang['date_allrecords'] = '**Be ribų **';
$lang['date_onehourold'] = 'Vienos valandos senumo';
$lang['date_sixhourold'] = '&Scaron;e&scaron;ių valandų senumo';
$lang['date_twelvehourold'] = 'Dvylikos valandų senumo';
$lang['date_onedayold'] = 'Vienos dienos senumo';
$lang['date_oneweekold'] = 'Vienos savaitės senumo';
$lang['date_twoweeksold'] = 'Dviejų mėnesių senumo';
$lang['date_onemonthold'] = 'Vieno mėnesio senumo';
$lang['date_threemonthsold'] = 'Trijų mėnesių senumo';
$lang['date_sixmonthsold'] = '&Scaron;e&scaron;ių mėnesių senumo';
$lang['date_oneyearold'] = 'Vienerių metų senumo';
$lang['title_groupsort'] = 'Grupavimas ir rū&scaron;iavimas';
$lang['prompt_recordsfound'] = 'Records matching the criteria';
$lang['sortorder_username_desc'] = 'Naudotojo vardas mažėjinčiai';
$lang['sortorder_username_asc'] = 'Naudotojo vardas didėjančiai';
$lang['sortorder_date_desc'] = 'Data | mažėjančiai';
$lang['sortorder_date_asc'] = 'Data | didėjančiai';
$lang['sortorder_action_desc'] = 'Įvykio tipas | mažėjančiai';
$lang['sortorder_action_asc'] = 'Įvykio tipas | didėjančiai';
$lang['sortorder_ipaddress_desc'] = 'Descending Ip Address';
$lang['sortorder_ipaddress_asc'] = 'Ascending Ip Address';
$lang['info_nohistorydetected'] = 'Neaptikta istorijos';
$lang['reset'] = 'Reset';
$lang['prompt_group_ip'] = 'Group By IP Address';
$lang['prompt_filter_eventtype'] = 'Event Type Filter';
$lang['prompt_filter_date'] = 'Display only events that are less than:';
$lang['prompt_pagelimit'] = 'Page Limit';
$lang['for'] = 'for';
$lang['title_userhistory'] = 'Naudotojo istorijos ataskaita';
$lang['unknown'] = 'Nežinomas';
$lang['prompt_ipaddress'] = 'IP adresas';
$lang['prompt_eventtype'] = 'Įvykio tipas';
$lang['prompt_date'] = 'Data';
$lang['prompt_return'] = 'Grįžti';
$lang['import_complete_msg'] = 'Import Operation Complete';
$lang['prompt_linesprocessed'] = 'Lines Processed';
$lang['prompt_errors'] = 'Įvyko klaidų';
$lang['prompt_recordsadded'] = 'Įra&scaron;ai pridėti';
$lang['error_nogroupproprelns'] = 'Could not find properties for group %s';
$lang['error_noresponsefromserver'] = 'Could not get a response from the SMTP server';
$lang['error_importfilenotfound'] = 'File specified (%s) could not be found';
$lang['error_importfieldvalue'] = 'Invalid value for dropdown or multiselect field %s';
$lang['error_importfieldlength'] = 'Laukas %s vir&scaron;ijo maksimalų ilgį';
$lang['error_importusers'] = 'Importavimo klaida (eilutė %s): %s';
$lang['error_propertydefns'] = 'Could not get the property definitions (internal error)';
$lang['error_problemsettinginfo'] = 'Problem setting user info';
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
    <p>This field must exist in the headerline, and in each and every line of the input file. The record will fail if a user with that username already exists in the database.</p></li>
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
$lang['prompt_importdestgroup'] = 'Importuoti naudotojus į &scaron;ią grupę';
$lang['prompt_importfilename'] = 'Input CSV File';
$lang['prompt_importxmlfile'] = 'Input XML File';
$lang['prompt_exportusers'] = 'Eksportuoti naudotojus';
$lang['prompt_importusers'] = 'Importuoti naudotojus';
$lang['prompt_clear'] = 'Valyti';
$lang['prompt_image_destination_path'] = 'Image Destination Path';
$lang['error_missing_upload'] = 'A problem occurred with a missing (but required) upload';
$lang['error_bad_xml'] = 'Could not parse the provided XML file';
$lang['error_notemptygroup'] = 'Grupė, kurioje yra naudotojų, negali būti i&scaron;trinta';
$lang['error_norepeatedlogins'] = '&Scaron;is naudotojas jau yra prisijungęs';
$lang['error_captchamismatch'] = 'Neteisingai įvestas tekstas i&scaron; paveiksliuko';
$lang['prompt_allow_repeated_logins'] = 'Leisti naudotojui prisijungti daugiau negu vieną kartą';
$lang['prompt_allowed_image_extensions'] = 'Image File Extensions that Users allowed to upload';
$lang['event_help_OnRefreshUser'] = '<h3>OnRefreshUser</h3>
<p>An event generated when the user session is refreshed.</p>
<h4>Parameters:</h4>
<ul>
  <li><em>id</em> - The User id</li>
</ul>
';
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
<li><em>id</em> - The id of the logged in user</li>
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
$lang['event_info_OnRefreshUser'] = 'An event generated when the user session is refreshed';
$lang['event_info_OnUpdateUser'] = 'An event generated when a user info is updated';
$lang['event_info_OnDeleteUser'] = 'An event generated when a user account is deleted';
$lang['event_info_OnCreateGroup'] = 'An event generated when a user group is created';
$lang['event_info_OnUpdateGroup'] = 'An event generated when a user group is updated';
$lang['event_info_OnDeleteGroup'] = 'An event generated when a user group is deleted';
$lang['backend_group'] = 'Backend Group';
$lang['info_star'] = '* The following macros can be used in these fields: {$username},{$group}. When using the {$group} macro, the system will subsitute the name of the first member group that the user belongs to, and will redirect to that page.';
$lang['info_admin_password'] = 'Edit this field to reset the users password';
$lang['info_admin_repeatpassword'] = 'Edit this field to reset the users password';
$lang['error_username_exists'] = 'Naudotojas tokiu vardu jau egzistuoja';
$lang['nocsvresults'] = 'No results returned from csv export';
$lang['prompt_unfldlen'] = 'Naudotojo vardo lauko ilgis';
$lang['prompt_pwfldlen'] = 'Slaptažodžio lauko ilgis';
$lang['error_invalidpasswordlengths'] = 'Minimalus/maksimalus slaptažodžio ilgis yra neteisingas';
$lang['error_invalidusernamelengths'] = 'Neteisingas naudotojo vardo ilgis (per trumpas arba per ilgas)';
$lang['error_invalidemailaddress'] = 'Neteisingas e. pa&scaron;to adresas';
$lang['error_noemailaddress'] = 'E. pa&scaron;to adresas &scaron;iai sąskaitai nerastas';
$lang['error_problemseettinginfo'] = 'Problem setting user info';
$lang['error_settingproperty'] = 'Problem setting property';
$lang['user_added'] = 'Naudotojas pridėtas %s = %s';
$lang['user_deleted'] = 'Naudotojas i&scaron;trintas uid=%s';
$lang['propertyfilter'] = 'Savybė';
$lang['valueregex'] = 'Value (regular expression)';
$lang['warning_effectsfieldlength'] = 'Warning: These fields affect the size of input fields for forms.  Decreasing this number on an existing site may not be advisable';
$lang['confirm_submitprefs'] = 'Are you sure you want to adjust the module preferences?';
$lang['error_emailalreadyused'] = 'E. pa&scaron;to adresas jau yra naudojamas';
$lang['prompt_usecookiestoremember'] = 'Use cookies to remember login details';
$lang['prompt_cookiename'] = 'The name of the cookie';
$lang['prompt_allow_duplicate_emails'] = 'Leisti tą patį e. pa&scaron;to adresą keliems naudotojams';
$lang['prompt_username_is_email'] = 'Naudotojo vardas yra naudotojo e. pa&scaron;to adresas';
$lang['info_cookie_keepalive'] = 'Attempt to keep logins alive by the use of a cookie <em>(the cookie is reset on activity in the website)</em>';
$lang['info_allow_duplicate_emails'] = '(allow multiple users with the same email address)';
$lang['info_username_is_email'] = '(user&#039;s email address is their username -- don&#039;t set this with &quot;allow duplicate email addresses&quot;!)';
$lang['prompt_allow_duplicate_reminders'] = 'Allow duplicate &quot;forgot password&quot; reminders?';
$lang['info_allow_duplicate_reminders'] = '(allow a users to request a password reset, even if they haven&#039;t acted on a previous one)';
$lang['prompt_feusers_specific_permissions'] = 'Use Front-end User specific permissions?';
$lang['info_feusers_specific_permissions'] = '(Normally, FEUSers permissions are the same as the equivalent Admin Area permissions like Add User, Add Group, etc. If you select this option, there will be separate permissions for FEUsers.)';
$lang['error_missingupload'] = 'Could not find the uploaded file (internal error)';
$lang['error_problem_upload'] = 'There was a problem with your uploaded file.  Please try again';
$lang['error_missingusername'] = 'Jūs neįvedėte naudotojo vardo';
$lang['error_missingemail'] = 'Jūs neįvedėte savo e. pa&scaron;to adreso';
$lang['error_missingpassword'] = 'Jūs neįvedėte slaptažodžio';
$lang['frontenduser_logout'] = 'Frontend User Logout';
$lang['frontenduser_loggedin'] = 'Frontend User Login';
$lang['editprop_infomsg'] = '<font color=&quot;red&quot;><b>USE CAUTION</b> when changing existing properties that are assigned to groups, you may potentially cause damage and break an existing site <i>(especially if you reduce field lengths, etc)</i></font>';
$lang['info_smtpvalidate'] = 'This function does not work on windows';
$lang['msg_dontcreateusername'] = 'Do not create a property for username, or password as these properties are builtin to the FrontEndUsers module';
$lang['prompt_exportcsv'] = 'Eksportuoti naudotojus į CSV';
$lang['exportcsv'] = 'Eksportuoti';
$lang['importcsv'] = 'Importuoti';
$lang['admin'] = 'Administravimas';
$lang['editprop'] = 'Keisti sąvybę: <em>%s</em>';
$lang['maxlength'] = 'Maksimalus ilgis';
$lang['created'] = 'Sukurtas';
$lang['sortby'] = 'Rū&scaron;iuoti pagal';
$lang['sort'] = 'Rū&scaron;iuojama';
$lang['usersingroup'] = 'Naudotojai pasirinktose grupėse';
$lang['userlimit'] = 'Apriboti rezultatus iki';
$lang['error_noemailfield'] = '&Scaron;io naudotojo e. pa&scaron;to adresas nerandamas. Kreipkitės į sistemos administratorių.';
$lang['prompt_forgotpw_page'] = 'PageID/Alias for Forgot Password form';
$lang['prompt_changesettings_page'] = 'PageID/Alias for Change Settings form';
$lang['prompt_login_page'] = 'PageID/Alias to jump to after login *';
$lang['prompt_logout_page'] = 'PageID/Alias to jump to after logout *';
$lang['sortorder'] = 'Rū&scaron;iavimo tvarka';
$lang['prompt_numresetrecord'] = 'A number of users are in the middle of resetting lost passwords.  Currently this count is at:';
$lang['remove1week'] = 'Pa&scaron;alinti visus daugiau negu savaitės senumo įra&scaron;us';
$lang['remove1month'] = 'Pa&scaron;alinti visus daugiau negu mėnesio senumo įra&scaron;us';
$lang['removeall'] = 'Pa&scaron;alinti visus įra&scaron;us';
$lang['areyousure'] = 'Ar jūs įsitikinęs?';
$lang['error_invalidcode'] = 'Neteisingas kodas buvo įvestas. Bandykite dar kartą';
$lang['error_tempcodenotfound'] = 'A temporary code for your user id could not be found in the database';
$lang['forgotpassword_verifytemplate'] = 'Template used to display verification form';
$lang['forgotpassword_emailtemplate'] = 'Template used for forgotten password email';
$lang['error_resetalreadysent'] = 'Jūs arba kas nors kitas jau pra&scaron;ėte slaptažodžio keitimo. Patikrinkit savo e. pa&scaron;tą - turėtumėte rasti e. lai&scaron;ką su instrukcijomis, kaip pakeisti slaptažodį.';
$lang['error_dberror'] = 'Duomenų bazės klaida';
$lang['message_forgotpwemail'] = 'Jūs gavote &scaron;į lai&scaron;ką, nes jūs arba kažkas kitas mūsų svetainėje nurodė, kad praradote savo prisijungimo slaptažodį. Jei jums nereikia keisti savo slaptažodžio, tiesiog ignoruokite &scaron;į lai&scaron;ką.';
$lang['prompt_code'] = 'Kodas';
$lang['message_code'] = 'Norėdami pakeisti savo slaptažodį sekite žemiau pateiktą nuorodą. Norint pakeisti slaptažodį, reikia įvesti ir kodą. Įprastai kodo laukelis būna i&scaron; anksto užpildytas, tačiau jei ne, tai kodas yra:';
$lang['prompt_link'] = 'Sekite &scaron;ią nuorodą, jei norite pakeisti savo slaptažodį:';
$lang['lostpassword_emailsubject'] = 'Prarastas slaptažodis';
$lang['error_nomailermodule'] = 'nerandamas CMSMailer modulis';
$lang['info_forgotpwmessagesent'] = 'E. lai&scaron;kas su instrukcijomis, kaip pakeisti slaptažodį, i&scaron;siųstas adresu %s. Ačiū!';
$lang['lostpw_message'] = 'Įveskite naudotojo vardą ir jeigu toks vardas egzistuoja, e. lai&scaron;kas su instrukcijomis, kaip pakeisti slaptažodį, bus jums i&scaron;siųstas. ';
$lang['forgotpassword_template'] = 'Užmir&scaron;to slaptažodžio &scaron;ablonas';
$lang['lostusername_template'] = 'Naudotojo vardo priminimo &scaron;ablonas';
$lang['error_propnotfound'] = 'Sąvybė %s nerasta';
$lang['propsfound'] = 'Rastos sąvybės';
$lang['addprop'] = 'Pridėti sąvybę';
$lang['error_requiredfield'] = 'Privalomas laukas (%s) buvo tu&scaron;čias';
$lang['info_emptypasswordfield'] = 'Įveskite naują slaptažodį, jei norite pakeisti dabartinį';
$lang['error_notloggedin'] = 'Jūs neprisijungęs';
$lang['user_settings'] = 'Nustatymai';
$lang['user_registration'] = 'Registracija';
$lang['error_accountexpired'] = '&Scaron;i paskyra nebegalioja';
$lang['error_improperemailformat'] = 'Neteisingas e. pa&scaron;to adreso formatas';
$lang['error_invalidexpirydate'] = 'Neteisinga paskyros galiojimo pabaigos data. Tai gali būti susieta su sistemos nustatymais. Bandykite nustatyti ankstesnius metus.';
$lang['error_problemsettingproperty'] = 'Error setting property %s for user $s';
$lang['error_invalidgroupid'] = 'Neteisingas %s grupės ID';
$lang['hiddenfieldmarker'] = 'Hidden field marker';
$lang['hiddenfieldcolor'] = 'Hidden field color';
$lang['hidden'] = 'Paslėpta';
$lang['error_duplicatename'] = 'A property with that name is already defined';
$lang['error_noproperties'] = 'No properties defined';
$lang['error_norelations'] = 'No properties were selected for this group';
$lang['nogroups'] = 'No Groups are defined';
$lang['groupsfound'] = 'Rastos grupės';
$lang['error_onegrouprequired'] = 'Membership in at least one group is required';
$lang['prompt_requireonegroup'] = 'Require membership in atleast one group';
$lang['back'] = 'Atgal';
$lang['error_missing_required_param'] = 'laukas %s yra privalomas';
$lang['requiredfieldmarker'] = 'Mark required fields with';
$lang['requiredfieldcolor'] = 'Hilite required fields in';
$lang['next'] = 'Kitas';
$lang['error_groupexists'] = 'Grupė tokiu pavadinimu jau yra';
$lang['required'] = 'Būtinas';
$lang['optional'] = 'Laisvai pasirenkamas';
$lang['off'] = 'I&scaron;jungta';
$lang['size'] = 'Dydis';
$lang['sizecomment'] = '<br/>(Maximum size of any one dimension of the image in pixels)';
$lang['length'] = 'Ilgis';
$lang['lengthcomment'] = '<br>(chars in the text input)';
$lang['seloptions'] = 'Dropdown options, separated by line breaks.  Values can be separated from text with a = character. i.e: Female=f';
$lang['radiooptions'] = 'Radiobutton labels, separated by line breaks. Values can be separated from text with a = character. i.e: Female=f';
$lang['prompt'] = 'Prompt';
$lang['prompt_type'] = 'Tipas';
$lang['type'] = 'Tipas';
$lang['fieldstatus'] = 'Laukelio statusas';
$lang['usedinlostun'] = 'Ask in Lost<br/>Username';
$lang['text'] = 'Tekstas';
$lang['checkbox'] = 'Checkbox';
$lang['multiselect'] = 'Multi Select List';
$lang['radiobuttons'] = 'Radio Buttons';
$lang['image'] = 'Paveiksliukas';
$lang['email'] = 'E. pa&scaron;to adresas';
$lang['textarea'] = 'Textarea';
$lang['dropdown'] = 'Dropdown';
$lang['msg_currentlyloggedinas'] = 'Sveiki';
$lang['logout'] = 'Atsijungti';
$lang['prompt_newgroupname'] = 'Naudoti &scaron;ios grupės vardą';
$lang['prompt_changesettings'] = 'Pakeisti mano nustatymus';
$lang['error_loginfailed'] = 'Nepavyko prisijungti: neteisingi naudotojo vardas arba slaptožodis';
$lang['login'] = 'Prisijungti';
$lang['prompt_signin_button'] = 'Prisijungimo mygtuko etiketė';
$lang['prompt_username'] = 'Naudotojo vardas';
$lang['prompt_email'] = 'E. pa&scaron;to adresas';
$lang['prompt_password'] = 'Slaptažodis';
$lang['prompt_rememberme'] = 'Prisimink mane';
$lang['register'] = 'Registruotis';
$lang['forgotpw'] = 'Užmir&scaron;ote slaptažodį?';
$lang['lostusername'] = 'Užmir&scaron;ote prisijungimo detales?';
$lang['defaults'] = 'Numatyti';
$lang['template'] = '&Scaron;ablonas';
$lang['error_usernotfound'] = 'Informacija apie &scaron;į naudotoją nerasta';
$lang['error_usernametaken'] = 'Naudotojo vardas (%s) jau yra naudojamas';
$lang['prompt_smtpvalidate'] = 'Use SMTP to validate email addresses?';
$lang['prompt_minpwlen'] = 'Minimum Password Length';
$lang['prompt_maxpwlen'] = 'Maximum Password Length';
$lang['prompt_minunlen'] = 'Minimalus naudotojo vardo ilgis';
$lang['prompt_maxunlen'] = 'Maximum Username Length';
$lang['prompt_sessiontimeout'] = 'Session Timeout (seconds)';
$lang['prompt_cookiekeepalive'] = 'Use cookies to keep logins alive';
$lang['prompt_allowemailreg'] = 'Allow Email Registration';
$lang['prompt_dfltgroup'] = 'Numatyta grupė naujam naudotojui';
$lang['changesettings_template'] = 'Nustatymų keitimo &scaron;ablonas';
$lang['error_passwordmismatch'] = 'Slaptažodžiai nesutampa';
$lang['error_invalidusername'] = 'Neteisingas naudotojo vardas';
$lang['error_invalidpassword'] = 'Neteisingas slaptažodis';
$lang['edituser'] = 'Redaguoti naudotoja';
$lang['valid'] = 'Galiojantis';
$lang['username'] = 'Naudotojo vardas';
$lang['status'] = 'Statusas';
$lang['error_membergroups'] = '&Scaron;is naudotojas nepriklauso jokiai grupei';
$lang['error_properties'] = 'Nėra sąvybių';
$lang['error_dup_properties'] = 'Attempt to import duplicate properties';
$lang['value'] = 'Vertė';
$lang['groups'] = 'Grupės';
$lang['properties'] = 'Savybės';
$lang['propname'] = 'Savybės vardas';
$lang['propvalue'] = 'Savybės vertė';
$lang['add'] = 'Pridėti';
$lang['history'] = 'Istorija';
$lang['edit'] = 'Keisti';
$lang['expires'] = 'Nustoja galioti';
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
$lang['never'] = 'Niekada';
$lang['postinstallmessage'] = 'Modulis instaliuotas sėkmingai.<br/>Be sure to set the &quot;Modify FrontEndUser Properties permission.  Additionally, we recommend that you install the Captcha module.  If installed, validation of a captcha image will be required in addition to the username and password to login.  This is intended to prevent brute force attacks.  <strong>Note:</strong> The nocaptcha parameter can be used to disable this functionality even if the Captcha module is installed.&quot;';
$lang['password'] = 'Slaptažodis';
$lang['repeatpassword'] = 'Slaptažodis, dar kartą';
$lang['error_groupname_exists'] = 'Grupė tokiu pavadinimu jau yra';
$lang['editgroup'] = 'Redaguoti grupę';
$lang['submit'] = 'Pateikti';
$lang['cancel'] = 'At&scaron;aukti';
$lang['delete'] = 'Trinti';
$lang['confirm_editgroup'] = 'Are you sure this is the proper settings for this group?\nTurning a property off will not delete any entries in the properties table for this group/user.  They will merely be unavailable.';
$lang['areyousure_deletegroup'] = 'Ar jūs įsitikinęs, kad norite i&scaron;trinti &scaron;ią grupę??';
$lang['confirm_delete_prop'] = 'Are you sure you want to completely delete this property?\nDoing so will also erase any user entries for this property.';
$lang['error_insufficientparams'] = 'Insufficient Parameters';
$lang['id'] = 'Id';
$lang['name'] = 'Vardas';
$lang['error_cantaddprop'] = 'Problem adding property';
$lang['error_cantaddgroupreln'] = 'Problem adding group relation';
$lang['error_cantaddgroup'] = 'Problem adding group';
$lang['error_cantassignuser'] = 'Problem adding a user to a group';
$lang['error_couldnotdeleteproperty'] = 'Problem deleting a property';
$lang['error_couldnotfindemail'] = 'E. pa&scaron;to adresas nerastas';
$lang['error_destinationnotwritable'] = 'No write permission to destination directory';
$lang['error_invalidparams'] = 'Neteisingi parametrai';
$lang['error_nogroups'] = 'Jokia grupė nerasta';
$lang['applyfilter'] = 'Pritaikyti';
$lang['filter'] = 'Filtras';
$lang['userfilter'] = 'Username Regular Expression';
$lang['description'] = 'Apra&scaron;ymas';
$lang['groupname'] = 'Grupės pavadinimas';
$lang['accessdenied'] = 'Prisijungimas atmestas';
$lang['error'] = 'Klaida';
$lang['addgroup'] = 'Pridėti grupę';
$lang['importgroup'] = 'Importuoti grupę';
$lang['adduser'] = 'Pridėti naudotoją';
$lang['usersfound'] = 'Users found that match the criteria';
$lang['group'] = 'Grupė';
$lang['selectgroup'] = 'Pasirinkti grupę';
$lang['registration_template'] = 'Registracijos &scaron;ablonas';
$lang['logout_template'] = 'Atsijungimo &scaron;ablonas';
$lang['login_template'] = 'Prisijungimo &scaron;ablonas';
$lang['preferences'] = 'Nustatymai';
$lang['users'] = 'Naudotojai';
$lang['friendlyname'] = 'Frontend naudotojų tvarkymas';
$lang['moddescription'] = 'Allow users to log in to the frontend of your site';
$lang['defaultfrontpage'] = 'Numatytasis prie&scaron;akinis puslapis';
$lang['lastaccessedpage'] = 'Last accessed page';
$lang['otherpage'] = 'Kitas puslapis: ';
$lang['captcha_title'] = 'Įveskite tekstą paveiksliukui';
?>
