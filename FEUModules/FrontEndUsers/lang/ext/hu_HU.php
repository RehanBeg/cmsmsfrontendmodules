<?php
$lang['pagetype_unauthorized'] = 'Nem vagy felhatalmazva, hogy ezt a tartalmat megn&eacute;zd';
$lang['info_contentpage_grouplist'] = 'Specify a list of FEU groups that may have access to this page.  Selecting no groups will allow any user logged in to FEU to view the page';
$lang['pagetype_settings'] = 'V&eacute;dett oldal be&aacute;ll&iacute;t&aacute;sa';
$lang['pagetype_groups'] = 'Megengedett csoportok';
$lang['info_pagetype_groups'] = 'Select the groups that are (by default) allowed to view protected pages.  An editor with the &quot;Manage All Content&quot; permission can override this for each page';
$lang['pagetype_action'] = 'Action for insufficient access';
$lang['info_pagetype_action'] = 'Specify the behavior for people accessing this page without sufficient permission.  You can either redirect to a specified page, or display the login form';
$lang['showloginform'] = 'Bel&eacute;pő űrlap mutat&aacute;sa';
$lang['redirect'] = 'Atir&aacute;ny&iacute;t&aacute;s egy oldalra';
$lang['pagetype_redirectto'] = '&Aacute;tir&aacute;ny&iacute;t&aacute;s ide';
$lang['info_pagetype_redirectto'] = 'Specify the page to redirect to.  If you select none, and the action is set to &quot;redirect&quot; the user will be presented with a message indicating that they do not hace access to the page';
$lang['permissions'] = 'Enged&eacute;lyek';
$lang['feu_protected_page'] = 'V&eacute;dett tartalom';
$lang['prompt_viewprops'] = 'Select Additional Properties to View';
$lang['view'] = 'Megtekint&eacute;s';
$lang['info_ignore_userid'] = 'If checked the import routine will attempt to add users independant of the userid column.  If a user with the name specified in the import file already exists, an error will be generated';
$lang['ignore_userid'] = 'Ignore UserID Column on Import';
$lang['export_passhash'] = 'Export the password hash to the file';
$lang['info_export_passhash'] = 'The password hash is only useful if the password salt on the import host is identical to that of the export host';
$lang['error_adjustsalt'] = 'The password salt cannot be adjusted';
$lang['prompt_pwsalt'] = 'Password Salt';
$lang['info_pwsalt'] = 'FrontEndUsers salts all passwords with this key which is created upon install.  Once users have been added to the database the salt cannot be changed. The salt may be empty for older installs.';
$lang['advanced_settings'] = 'Advanced Settings';
$lang['info_sessiontimeout'] = 'Specify the number of seconds before an inactive user is automatically logged out of the website';
$lang['prompt_expireusers_interval'] = 'User Expiry Interval';
$lang['info_expireusers_interval'] = 'Specify a value (in seconds) that indicates how often the system should force users whos session has expired to be logged out.  T&quot;his is an optimization to save database queries.  If left empty or set to 0 expiry will be performed on every request.';
$lang['msg_settingschanged'] = 'Your settings were successfully updated';
$lang['forcedlogouttask_desc'] = 'Force users to logout at regular intervals';
$lang['prompt_forcelogout_times'] = 'Times for forced logout';
$lang['info_forcelogout_times'] = 'Specify a comma separated list of times like HH:MM,HH:MM where users will be forcibly logged out. Note, this uses the psuedocron mechanism so you must be sure that the times entered here will coincide reasonably with your &quot;pseudocron granularity&quot; and that sufficient requests will occur to your website to ensure that pseudocron is executed.';
$lang['prompt_forcelogout_sessionage'] = 'Exclude users that have been active in <em>(minutes)</em>';
$lang['info_forcelogout_sessionage'] = 'If specified, any users that have been active in this number of seconds will not be forcibly logged out';
$lang['areyousure_delete'] = 'Biztos t&ouml;r&ouml;lni akarod %s felhaszn&aacute;l&oacute;t?';
$lang['error_invalidfileextension'] = 'The uploaded file does not match the list of allowed file types';
$lang['postuninstall'] = 'All data associated with the FrontEndUsers module has been deleted';
$lang['info_ecomm_paidregistration'] = 'If enabled, this module will listen to events from the Ecommerce suite.  The following settings only have effect if this setting is enabled.';
$lang['prompt_ecomm_paidregistration'] = 'Listen to Order Events';
$lang['info_paidreg_settings'] = 'The following settings only apply if using self registration and allowing for paid registration';
$lang['none'] = 'None';
$lang['delete_user'] = 'Felhaszn&aacute;l&oacute; t&ouml;rl&eacute;se';
$lang['expire_user'] = 'Expire User';
$lang['prompt_action_ordercancelled'] = 'Action to perform when a subscription order is cancelled';
$lang['prompt_action_orderdeleted'] = 'Action to perform when a subscription order is deleted';
$lang['ecommerce_settings'] = 'E-kereskedelem be&aacute;ll&iacute;t&aacute;sok';
$lang['securefieldmarker'] = 'Biztons&aacute;gos mező jelző';
$lang['securefieldcolor'] = 'Biztons&aacute;gos mező sz&iacute;n';
$lang['prompt_encrypt'] = 'T&aacute;rold ezt az adatot titkos&iacute;tva az adatb&aacute;zisban';
$lang['error_notsupported'] = 'The chosen option is not supported given your current configuration';
$lang['audit_user_created'] = 'Felhaszn&aacute;l&oacute; automatikusanl&eacute;trehozva';
$lang['info_auto_create_unknown'] = 'If a user is authenticated by an external authentication module but is not known in the FrontEndUsers module should an FEU account be created automatically?';
$lang['prompt_auto_create_unknown'] = 'Automatically Create Unknown Users';
$lang['display_settings'] = 'Kijelz&eacute;si be&aacute;ll&iacute;t&aacute;sok';
$lang['info_std_auth_settings'] = 'A k&ouml;vetkező b&aacute;ll&iacute;t&aacute;sok csak akkor &eacute;rv&eacute;nyesek ha a &amp;quot;Be&eacute;p&iacute;tett azonos&iacute;t&aacute;s&amp;quot;-t haszn&aacute;ljuk.';
$lang['info_support_lostun'] = 'Selecting No will disable the ability for a user to request lost login information, irrespective of other settings';
$lang['info_support_lostpw'] = 'Selecting No will disable the ability for a user to a password reset, irrespective of other settings';
$lang['prompt_support_lostun'] = 'Engedd meg a felhaszn&aacute;l&oacute;knak, hogy k&eacute;rj&eacute;k a felhaszn&aacute;l&oacute;nev&uuml;ket';
$lang['prompt_support_lostpw'] = 'Engedd meg a felhaszn&aacute;l&oacute;knak, hogy jelsz&oacute;csr&eacute;t k&eacute;rjenek';
$lang['auth_settings'] = 'Azonos&iacute;t&aacute;si be&aacute;ll&iacute;t&aacute;sok';
$lang['authentication'] = 'Be&eacute;p&iacute;tett azonos&iacute;t&aacute;s';
$lang['auth_builtin'] = 'FEU alapvető azonos&iacute;t&aacute;s';
$lang['auth_module'] = 'Azonos&iacute;t&aacute;si modul/m&oacute;dszer';
$lang['info_auth_module'] = 'A FrontendUsers modul k&uuml;l&ouml;nboző azonos&iacute;t&aacute;si m&oacute;dszereket is t&aacute;mogat, v&aacute;ltoz&oacute; k&eacute;pess&eacute;gekkel.  Bizonyos funkcionalit&aacute;s nem fog műk&ouml;dni vagy ki lesz kapcsolva mikor nem a be&eacute;p&iacute;tett azonos&iacute;t&aacute;st haszn&aacute;lod.';
$lang['error_user_nonunique_field_value'] = 'A %s-nak(nek) megadott &eacute;rt&eacute;k m&aacute;r haszn&aacute;latban van egy m&aacute;sik felhaszn&aacute;l&oacute; &aacute;ltal';
$lang['unique'] = 'Egyedi';
$lang['error_nonunique_field_value'] = 'A %s-nak(nek) (%s) megadott &eacute;rt&eacute;k nem egyedi';
$lang['prompt_force_unique'] = 'Force values of this property to be unique across all user accounts';
$lang['help_returnlast'] = 'Used with the login and logout forms, this parameter if specified will indicate that the user should be returned to the page (by url) that the user was viewing before the action occurred.  This parameter will override the redirect preferences, and the returnto parameter.';
$lang['help_noinline'] = 'Used with one of the forms, this parameter specifies that the forms should not be placed inline, instead the resulting output after form submission will replace the default content block';
$lang['title_reset_session'] = 'Login Session Timeout Warning';
$lang['msg_reset_session'] = 'Your login session is about to expire, please click &quot;&quot;Ok&quot; to confirm your activity on this website.';
$lang['ok'] = 'Rendben';
$lang['resetsession_template'] = 'Reset Session Template';
$lang['info_name'] = 'This is the field name, to be used for addressing in smarty.  It must consist of only alphanumeric characters and underscores.';
$lang['visitors_tab'] = 'L&aacute;togat&oacute;k';
$lang['feu_groups_prompt'] = 'V&aacute;lassz egy vagy t&ouml;bb FEU csoportot amely l&aacute;thatja ezt az oldalt';
$lang['error_mustselect_group'] = 'Egy csoportot ki kell v&aacute;lasztani';
$lang['selectone'] = 'V&aacute;lassz egyet';
$lang['start_year'] = 'Kezd&eacute;si &eacute;v';
$lang['end_year'] = 'Befejeződ&eacute;s &eacute;v';
$lang['date'] = 'D&aacute;tum';
$lang['prompt_thumbnail_size'] = 'B&eacute;lyegk&eacute;p m&eacute;rete';
$lang['OnUpdateGroup'] = 'On User Group Modified';
$lang['error_toomanyselected'] = 'Too many users are selected for bulk operations.... Please trim it to 250 or less';
$lang['confirm_delete_selected'] = 'Biztosan t&ouml;r&ouml;lni akarod a kiv&aacute;lasztott felhaszn&aacute;l&oacute;kat?';
$lang['delete_selected'] = 'Kiv&aacute;lasztottak t&ouml;rl&eacute;se';
$lang['prompt_randomusername'] = 'Generate random username when adding new users';
$lang['months'] = 'h&oacute;nap';
$lang['prompt_expireage'] = 'Default user expiry period';
$lang['notification_settings'] = '&Eacute;rtes&iacute;t&eacute;si be&aacute;ll&iacute;t&aacute;sok';
$lang['property_settings'] = 'Tulajdons&aacute;g be&aacute;ll&iacute;t&aacute;sok';
$lang['redirection_settings'] = '&Aacute;tir&aacute;ny&iacute;t&aacute;si be&aacute;ll&iacute;t&aacute;sok';
$lang['general_settings'] = '&Aacute;ltal&aacute;nos be&aacute;ll&iacute;t&aacute;sok';
$lang['session_settings'] = 'Session and Cookie Settings';
$lang['field_settings'] = 'Mező be&aacute;ll&iacute;t&aacute;sok';
$lang['error_lostun_nonrequired'] = 'The lostusername flag can only be used on required fields';
$lang['prop_textarea_wysiwyg'] = 'WYSIWYG haszn&aacute;lat&aacute;nak enged&eacute;lyez&eacute;se ezen a sz&ouml;veges mezőn';
$lang['info_cookiestoremember'] = '<strong>Megjegyz&eacute;s: </strong> Ez az mcrypt funkci&oacute;t haszn&aacute;lja titkos&iacute;t&aacute;si c&eacute;lokra es ezt nem tal&aacute;ltuk a telep&iacute;t&eacute;skor. K&eacute;rj&uuml;k l&eacute;pj kapcsolatba a szerver rendszergazd&aacute;j&aacute;val.';
$lang['editing_user'] = 'M&oacute;dos&iacute;tott felhaszn&aacute;l&oacute;';
$lang['noinline'] = 'Do not inline forms';
$lang['info_lostun'] = 'Kattints ide ha nem eml&eacute;kszel a bel&eacute;p&eacute;si inform&aacute;ci&oacute;dra';
$lang['info_forgotpw'] = 'Kattints ide ha nem eml&eacute;kszel a jelszavadra';
$lang['info_logout'] = 'Kattints ide, hogy kijelentkezz';
$lang['info_changesettings'] = 'Kattints ide, hogy be&aacute;ll&iacute;tsd a jelszavad &eacute;s m&aacute;s inform&aacute;ci&oacute;id';
$lang['viewuser_template'] = 'Felhaszn&aacute;l&oacute; sablon megtekint&eacute;se';
$lang['event'] = 'Esem&eacute;ny';
$lang['feu_event_notification'] = 'FEU esem&eacute;ny &eacute;rtes&iacute;t&eacute;s';
$lang['prompt_notification_address'] = '&Eacute;rtes&iacute;t&eacute;si email c&iacute;m';
$lang['prompt_notification_template'] = '&Eacute;rtes&iacute;t&eacute;si email sablon';
$lang['prompt_notification_subject'] = '&Eacute;rtes&iacute;t&eacute;si email t&aacute;rgya';
$lang['prompt_notifications'] = 'Email &eacute;rtes&iacute;t&eacute;sek';
$lang['OnLogin'] = 'Bejelentkez&eacute;skor';
$lang['OnLogout'] = 'Kijelentkez&eacute;skor';
$lang['OnExpireUser'] = 'On Session Expiry';
$lang['OnCreateUser'] = '&Uacute;j felhaszn&aacute;l&oacute; l&eacute;trehoz&aacute;sakor';
$lang['OnDeleteUser'] = 'Felhaszn&aacute;l&oacute; t&ouml;rl&eacute;sekor';
$lang['OnUpdateUser'] = 'Felhaszn&aacute;l&oacute; be&aacute;ll&iacute;t&aacute;sai m&oacute;dos&iacute;t&aacute;sakor';
$lang['OnCreateGroup'] = 'Felhaszn&aacute;l&oacute;csoport l&eacute;trehoz&aacute;sakor';
$lang['OnDeleteGroup'] = 'Felhaszn&aacute;l&oacute;csoport t&ouml;rl&eacute;sekor';
$lang['lostunconfirm_premsg'] = 'Az elfelejtett bel&eacute;p&eacute;si inform&aacute;ci&oacute; funkcionalit&aacute;s befejeződ&ouml;tt. Tal&aacute;ltunk egy egyedi felhaszn&aacute;l&oacute;nevet ami megfelel az &aacute;ltalad be&iacute;rt r&eacute;szleteknek';
$lang['your_username_is'] = 'A felhaszn&aacute;l&oacute;neved';
$lang['lostunconfirm_postmsg'] = 'We recommend you record this information in a secure, but retrievable location.';
$lang['prompt_after_change_settings'] = 'PageID/Alias to jump to after change settings';
$lang['prompt_after_verify_code'] = 'PageID/Alias to jump to after code verification *';
$lang['lostun_details_template'] = 'Lost Username Details Template';
$lang['lostun_confirm_template'] = 'Lost Username Confirm Template';
$lang['error_nonuniquematch'] = 'Hiba: T&ouml;bb, mint egy felhaszn&aacute;l&oacute;i fi&oacute;kot tal&aacute;ltunk ami megegyezik a megadott tulajdons&aacute;gnak';
$lang['error_cantfinduser'] = 'Hiba: Nem tal&aacute;ltam megfelelő felhaszn&aacute;l&oacute;t';
$lang['error_groupnotfound'] = 'Hiba: Nem tal&aacute;ltam ilyen nevű csoportot';
$lang['readonly'] = 'Csak olvashat&oacute;';
$lang['prompt_usermanipulator'] = 'User Manipulator Class';
$lang['admin_logout'] = 'Logged out by administrator';
$lang['prompt_loggedinonly'] = 'Csak bejelentkezett felhaszn&aacute;l&oacute;k mutat&aacute;sa';
$lang['prompt_logout'] = 'Felhaszn&aacute;l&oacute; kil&eacute;ptet&eacute;se';
$lang['user_properties'] = 'Felhaszn&aacute;l&oacute; tulajdons&aacute;gai';
$lang['userhistory'] = 'User History';
$lang['export'] = 'Export';
$lang['clear'] = 'Clear';
$lang['prompt_exportuserhistory'] = 'Export User History To ASCII that is at least';
$lang['prompt_clearuserhistory'] = 'Clear User History records that is at least';
$lang['title_lostusername'] = 'Elfelejtetted a bel&eacute;p&eacute;si inform&aacute;ci&oacute;id?';
$lang['title_rssexport'] = 'Export group definition (and properties) to XML';
$lang['title_userhistorymaintenance'] = 'User History Maintenance';
$lang['yes'] = 'Igen';
$lang['no'] = 'Nem';
$lang['prompt_of'] = 'Of';
$lang['date_allrecords'] = '** Korl&aacute;t n&eacute;lk&uuml;l **';
$lang['date_onehourold'] = 'Egy &oacute;r&aacute;s';
$lang['date_sixhourold'] = 'Hat &oacute;r&aacute;s';
$lang['date_twelvehourold'] = 'Tizenk&eacute;t &oacute;r&aacute;s';
$lang['date_onedayold'] = 'Egy napos';
$lang['date_oneweekold'] = 'Egy hetes';
$lang['date_twoweeksold'] = 'K&eacute;t hetes';
$lang['date_onemonthold'] = 'Egy h&oacute;napos';
$lang['date_threemonthsold'] = 'H&aacute;rom H&oacute;napos';
$lang['date_sixmonthsold'] = 'Hat h&oacute;napos';
$lang['date_oneyearold'] = 'Egy &eacute;ves';
$lang['title_groupsort'] = 'Csoportos&iacute;t&aacute;s &eacute;s rendez&eacute;s';
$lang['prompt_recordsfound'] = 'A krit&eacute;riumnak megfelelő bejegyz&eacute;sek';
$lang['sortorder_username_desc'] = 'Cs&ouml;kkenő felhaszn&aacute;l&oacute;n&eacute;v';
$lang['sortorder_username_asc'] = 'Novekvő felhaszn&aacute;l&oacute;n&eacute;v';
$lang['sortorder_date_desc'] = 'Cs&ouml;kkenő d&aacute;tum';
$lang['sortorder_date_asc'] = 'N&ouml;vekvő d&aacute;tum';
$lang['sortorder_action_desc'] = 'Descending Event Type';
$lang['sortorder_action_asc'] = 'Ascending Event Type';
$lang['sortorder_ipaddress_desc'] = 'Descending Ip Address';
$lang['sortorder_ipaddress_asc'] = 'Ascending Ip Address';
$lang['info_nohistorydetected'] = 'No History Detected';
$lang['reset'] = 'Reset';
$lang['prompt_group_ip'] = 'Group By IP Address';
$lang['prompt_filter_eventtype'] = 'Event Type Filter';
$lang['prompt_filter_date'] = 'Display only events that are less than:';
$lang['prompt_pagelimit'] = 'Page Limit';
$lang['for'] = 'for';
$lang['title_userhistory'] = 'User History Report';
$lang['unknown'] = 'Unknown';
$lang['prompt_ipaddress'] = 'IP c&iacute;m';
$lang['prompt_eventtype'] = 'Event Type';
$lang['prompt_date'] = 'D&aacute;tum';
$lang['prompt_return'] = 'Vissza';
$lang['import_complete_msg'] = 'Import Operation Complete';
$lang['prompt_linesprocessed'] = 'Lines Processed';
$lang['prompt_errors'] = 'Errors Encountered';
$lang['prompt_recordsadded'] = 'Bejegyz&eacute;s hozz&aacute;adva';
$lang['error_nogroupproprelns'] = 'Could not find properties for group %s';
$lang['error_noresponsefromserver'] = 'Could not get a response from the SMTP server';
$lang['error_importfilenotfound'] = 'File specified (%s) could not be found';
$lang['error_importfieldvalue'] = 'Invalid value for dropdown or multiselect field %s';
$lang['error_importfieldlength'] = 'Field %s exceeds maximum length';
$lang['error_importusers'] = 'Import Error (line %s): %s';
$lang['error_propertydefns'] = 'Could not get the property definitions (internal error)';
$lang['error_problemsettinginfo'] = 'Problem setting user info';
$lang['error_importrequiredfield'] = 'Could not find a column to match the required field %s';
$lang['error_nogroupproperties'] = 'Could not find properties for the specified group';
$lang['error_importfileformat'] = 'The file specified for import is not in the correct format';
$lang['error_couldnotopenfile'] = 'Nem tudtam megnyitni a f&aacute;jlt';
$lang['info_importusersfileformat'] = '<h4>File Format Information</h4>
<p>The input file must be in ASCII format using comma separated values.  Each line in this input file (with the exception of the header line, discussed below) represents one user record.  The order of the fields in each line must be identical.</p>
<h5>Header line</h5>
<ul>
<li>The first line of the file must begin with two pound (\#) characters, and names each of the fields in the file.  The names of these fields is significant.  There are some required field names (see below), and other field names must match the property names associated with the group users are going to be added into.</li>
<li>The import process will fail if the fields in the input file does not match all of the required properties associated with the group that users are being added into</li>
<li>The input file may contain fields representing some of the optional properties in the specified group.</li>
<li>The import process will ignore any fields in the input file that are either not known, or map to properties that are <em>off</em> in the specified user group.</li>
</ul><br/>
<h6><strong>Columnar Data</strong></h5>
<ul>
<li>The <strong>userid</strong> Field - The userid for the user. A value in this field will indicate you are doing an update.  There is a checkbox during the import process to specify that tue userid field can be ignored for the purposes of migrating users from one server to another.</li>
<li>The <strong>username</strong> Field - The desired username.
    <p>This field must exist in the headerline, and in each and every line of the input file. The record will fail if a user with that username already exists in the database.</p></li>
<li>The <strong>password</strong> Field - The password to set for the user.  Optionally, a <strong>passwordhash</strong> field may be included that specifies thee <em>salted</em> MD5 hash of the users password.  If the password field is empty when creating new users the password &quot;changeme&quot; is hardcoded.</li>
<li>The <strong>createdate</strong> Field - todo</li>
<li>The <strong>expires</strong> Field - todo</li>
<li>The <strong>groupname</strong> Field - The groups that you want to have the user be a member of. If all required fields are not filled in the insert/update of the record will fail. See Multiselect Fields below for syntax.</li>
<li>Dropdown/Radio Fields
    <p>The value of dropdown properties in an import file is represented as the string that is shown in the dropdown control in the FrontEndUsers module.</p>
</li>
<li>Multiselect Fields
    <p>Multiselect fields are contained within the ASCII file as a : separated list of strings, where each string represents the text shown in the multiselect list</p>
</li>
<li>Date Fields
    <p>Must be in the format of MM-DD-YYYY</p>
</li>
<li>Image Fields
    <p>Image are fields who&#039;s column name matches a property of type Image.  If this field is a required part of the destination group, then the name specified in these columns must exist in the uploads disrectory of the CMS installation.  If the image does not exist, and the field is required, then the record will fail.</p></li>
</ul>
<h5>Notes</h5>
<p>The import process is subject to the limitations imposed by the host provider, such as memory limitations, processing time, file size upload, and safe mode restrictions.  Any one of these limitations may cause the import to fail. Therefore it is advisable to ensure that import files are smaller in size, and simpler in nature.</p>
<p>Though every effort has been made to ensure that database corruption will not occur, it is advisable to perform a database backup before doing a user import.</p>
<p>The Export data is in the same format as needed for import.</p>
<h5>Example</h5>
<pre>
##username,first_name,last_name,email,city,state,country,zip
user1,test,user,user1@somedomain.com,somewhere,TX,US,12345
</pre>
';
$lang['prompt_importdestgroup'] = 'Import Users Into This Group';
$lang['prompt_importfilename'] = 'Input CSV File';
$lang['prompt_importxmlfile'] = 'Input XML File';
$lang['prompt_exportusers'] = 'Export Users';
$lang['prompt_importusers'] = 'Import Users';
$lang['prompt_clear'] = 'Clear';
$lang['prompt_image_destination_path'] = 'Image Destination Path';
$lang['error_missing_upload'] = 'A problem occurred with a missing (but required) upload';
$lang['error_bad_xml'] = 'Could not parse the provided XML file';
$lang['error_notemptygroup'] = 'Cannot delete a group that still has users';
$lang['error_norepeatedlogins'] = 'This user is already logged in';
$lang['error_captchamismatch'] = 'The text from the image was not entered correctly';
$lang['prompt_allow_repeated_logins'] = 'Allow users to login more than once';
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
<li><em>props</em> - A hash filled with the properties of the user</li>
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
$lang['info_star'] = '* The following fields are full smarty templates.<br/>Along with other pre-existing smarty variables and plugins, the {$username} and {$group} variables are availabie.  <em>(The {$group} variable matches the first group to which the user belongs.)</em>.';
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
$lang['propertyfilter'] = 'Tulajdons&aacute;g';
$lang['valueregex'] = 'Value (regular expression)';
$lang['warning_effectsfieldlength'] = 'Warning: These fields affect the size of input fields for forms.  Decreasing this number on an existing site may not be advisable';
$lang['confirm_submitprefs'] = 'Are you sure you want to adjust the module preferences?';
$lang['error_emailalreadyused'] = 'M&aacute;r haszn&aacute;latban levő email c&iacute;m';
$lang['prompt_usecookiestoremember'] = 'S&uuml;tik haszn&aacute;lata a bejelentkez&eacute;si inform&aacute;ci&oacute; &eacute;szben tart&aacute;s&aacute;ra';
$lang['prompt_cookiename'] = 'S&uuml;ti neve';
$lang['prompt_allow_duplicate_emails'] = 'Ism&eacute;tlődő email c&iacute;m haszn&aacute;lat&aacute;nak enged&eacute;lyez&eacute;se';
$lang['prompt_username_is_email'] = 'Email c&iacute;m a felhaszn&aacute;l&oacute;n&eacute;v';
$lang['info_cookie_keepalive'] = 'Attempt to keep logins alive by the use of a cookie <em>(the cookie is reset on activity in the website)</em>';
$lang['info_allow_duplicate_emails'] = '(T&ouml;bb felhaszn&aacute;l&oacute; is haszn&aacute;lhatja ugyanazt az email c&iacute;met)';
$lang['info_username_is_email'] = '(A felhaszn&aacute;l&oacute; email c&iacute;m&eacute;t haszn&aacute;lja felhaszn&aacute;l&oacute;n&eacute;vk&eacute;nt -- Ne haszn&aacute;ld ezt az ism&eacute;tlődő email c&iacute;m haszn&aacute;lat&aacute;nak enged&eacute;lyez&eacute;s&eacute;vel!)';
$lang['prompt_allow_duplicate_reminders'] = 'Allow duplicate &quot;forgot password&quot; reminders?';
$lang['info_allow_duplicate_reminders'] = '(Allow a users to request a password reset, even if they haven&#039;t acted on a previous one)';
$lang['prompt_feusers_specific_permissions'] = 'Use Front-end User specific permissions?';
$lang['info_feusers_specific_permissions'] = '(Normally, FEUSers permissions are the same as the equivalent Admin Area permissions like Add User, Add Group, etc. If you select this option, there will be separate permissions for FEUsers.)';
$lang['error_missingupload'] = 'Could not find the uploaded file (internal error)';
$lang['error_problem_upload'] = 'There was a problem with your uploaded file.  Please try again';
$lang['error_missingusername'] = 'Nem &iacute;rt&aacute;l be felhaszn&aacute;l&oacute;nevet';
$lang['error_missingemail'] = 'Nem &iacute;rtad be az email c&iacute;med';
$lang['error_missingpassword'] = 'Nem adt&aacute;l meg jelsz&oacute;t';
$lang['frontenduser_logout'] = 'FrontendUser kijelentkez&eacute;s';
$lang['frontenduser_loggedin'] = 'FrontendUser bejelentkez&eacute;s';
$lang['editprop_infomsg'] = '<font color=&quot;red&quot;><b>USE CAUTION</b> when changing existing properties that are assigned to groups, you may potentially cause damage and break an existing site <i>(especially if you reduce field lengths, etc)</i></font>';
$lang['info_smtpvalidate'] = 'Ez a funkci&oacute; nem műk&ouml;dik Windowson';
$lang['msg_dontcreateusername'] = 'Do not create a property for username, or password as these properties are builtin to the FrontEndUsers module';
$lang['prompt_exportcsv'] = 'Export Users to CSV';
$lang['exportcsv'] = 'Export';
$lang['importcsv'] = 'Import';
$lang['admin'] = 'Admin';
$lang['editprop'] = 'Edit Property: <em>%s</em>';
$lang['maxlength'] = 'Maximum Hossz';
$lang['created'] = 'L&eacute;trehozva';
$lang['sortby'] = 'Sort By';
$lang['sort'] = 'Sorting';
$lang['usersingroup'] = 'Users in the selected group(s)';
$lang['userlimit'] = 'Hat&aacute;rold az eredm&eacute;nyeket ennyire';
$lang['error_noemailfield'] = 'Could not find an email field for this user.  You may need to contact the system administrator';
$lang['prompt_forgotpw_page'] = 'PageID/Alias for Forgot Password form';
$lang['prompt_changesettings_page'] = 'PageID/Alias for Change Settings form';
$lang['prompt_login_page'] = 'PageID/Alias to jump to after login *';
$lang['prompt_logout_page'] = 'PageID/Alias to jump to after logout *';
$lang['sortorder'] = 'Sort order';
$lang['prompt_numresetrecord'] = 'A number of users are in the middle of resetting lost passwords.  Currently this count is at:';
$lang['remove1week'] = 'Remove all entries more than a week old';
$lang['remove1month'] = 'Remove all entries more than a month old';
$lang['removeall'] = 'Minden bejegyz&eacute;s elt&aacute;vol&iacute;t&aacute;sa';
$lang['areyousure'] = 'Biztos vagy benne?';
$lang['error_invalidcode'] = 'A megadott k&oacute;d hib&aacute;s, k&eacute;rlek pr&oacute;b&aacute;ld &uacute;jra';
$lang['error_tempcodenotfound'] = 'A temporary code for your user id could not be found in the database';
$lang['forgotpassword_verifytemplate'] = 'Template used to display verification form';
$lang['forgotpassword_emailtemplate'] = 'Template used for forgotten password email';
$lang['error_resetalreadysent'] = 'Either yourself or someone else has already triggered a password reset operation for this account.  Check your email, you may have further instructions on how to reset your password in your inbox';
$lang['error_dberror'] = 'Adatb&aacute;zis hiba';
$lang['message_forgotpwemail'] = 'You are receiving this message because somebody told our site that you had lost your password.  If this is the case, read the instructions below.  If you don&#039;t have a clue what this is, then you are safe to delete this message, and we thank you for your time.';
$lang['prompt_code'] = 'K&oacute;d';
$lang['message_code'] = 'The following code has been randomly generated in order to verify the user account.  when you click on the link below you will be presented with a field to enter this code.  Normally the field is pre-completed for you, but incase it isn&#039;t the code is:';
$lang['prompt_link'] = 'Clicking on the following link will take you to the website where you can enter the above code, and reset your password:';
$lang['lostpassword_emailsubject'] = 'Elfelejtett jelsz&oacute;';
$lang['error_nomailermodule'] = 'Nem tal&aacute;lom a CMSMailer modult';
$lang['info_forgotpwmessagesent'] = 'An email has been sent to %s with instructions as to how to reset your password.  Thank you';
$lang['lostpw_message'] = 'So you forgot or lost your password. Well, type your username in here, and if we can find you we will send you an email with instructions on how to reset it';
$lang['forgotpassword_template'] = 'Forgot Password Templates';
$lang['lostusername_template'] = 'Lost Username Template';
$lang['error_propnotfound'] = 'Property %s not found';
$lang['propsfound'] = 'Properties found';
$lang['addprop'] = 'Add Property';
$lang['error_requiredfield'] = 'A required field (%s) was empty';
$lang['info_emptypasswordfield'] = 'Enter a new password here to change your password';
$lang['error_notloggedin'] = 'You do not appear to be logged in';
$lang['user_settings'] = 'Be&aacute;ll&iacute;t&aacute;sok';
$lang['user_registration'] = 'Regisztr&aacute;ci&oacute;';
$lang['error_accountexpired'] = 'Ez a fi&oacute;k lej&aacute;rt';
$lang['error_improperemailformat'] = 'Improper email address formatting';
$lang['error_invalidexpirydate'] = 'Invalid expiry date.  This may be system related.  Try setting an earlier year.';
$lang['error_problemsettingproperty'] = 'Error setting property %s for user $s';
$lang['error_invalidgroupid'] = 'Invalid group id %s';
$lang['hiddenfieldmarker'] = 'Hidden field marker';
$lang['hiddenfieldcolor'] = 'Hidden field color';
$lang['hidden'] = 'Hidden';
$lang['error_duplicatename'] = 'A property with that name is already defined';
$lang['error_noproperties'] = 'No properties defined';
$lang['error_norelations'] = 'No properties were selected for this group.  A group must have at least one property selected (Required,Optional, or Hidden)';
$lang['nogroups'] = 'No Groups are defined';
$lang['groupsfound'] = 'Groups Found';
$lang['error_onegrouprequired'] = 'Membership in at least one group is required';
$lang['prompt_requireonegroup'] = 'Require membership in atleast one group';
$lang['back'] = 'Vissza';
$lang['error_missing_required_param'] = '%s egy k&ouml;telező mező';
$lang['requiredfieldmarker'] = 'Mark required fields with';
$lang['requiredfieldcolor'] = 'Hilite required fields in';
$lang['next'] = 'Tov&aacute;bb';
$lang['error_groupexists'] = 'A Group with that name already exists';
$lang['required'] = 'K&ouml;telező';
$lang['optional'] = 'Optional';
$lang['off'] = 'Off';
$lang['size'] = 'M&eacute;ret';
$lang['sizecomment'] = '<br/>(Maximum size of any one dimension of the image in pixels)';
$lang['length'] = 'Hossz';
$lang['lengthcomment'] = '<br>(chars in the text input)';
$lang['seloptions'] = 'Dropdown options, separated by line breaks.  Values can be separated from text with a = character. i.e: Female=f';
$lang['radiooptions'] = 'Radiobutton labels, separated by line breaks. Values can be separated from text with a = character. i.e: Female=f';
$lang['prompt'] = 'Prompt';
$lang['prompt_type'] = 'T&iacute;pus';
$lang['type'] = 'T&iacute;pus';
$lang['fieldstatus'] = 'Mező &aacute;llapot';
$lang['usedinlostun'] = 'Ask in Lost<br/>Username';
$lang['text'] = 'Sz&ouml;veg';
$lang['checkbox'] = 'Jel&ouml;lőmező';
$lang['multiselect'] = 'Multi Select List';
$lang['radiobuttons'] = 'R&aacute;di&oacute; gomb';
$lang['image'] = 'K&eacute;p';
$lang['email'] = 'Email c&iacute;m';
$lang['textarea'] = 'Szoveges mező';
$lang['dropdown'] = 'Leg&ouml;rd&uuml;lő lista';
$lang['msg_currentlyloggedinas'] = '&Uuml;dv&ouml;zl&uuml;nk';
$lang['logout'] = 'Kijelentkez&eacute;s';
$lang['prompt_newgroupname'] = 'Haszn&aacute;ld ezt a csoportnevet';
$lang['prompt_changesettings'] = 'Be&aacute;ll&iacute;t&aacute;saim m&oacute;dos&iacute;t&aacute;sa';
$lang['error_loginfailed'] = 'Bejelentkez&eacute;s sikertelen - Hib&aacute;s felhaszn&aacute;l&oacute;n&eacute;v vagy jelsz&oacute;?';
$lang['login'] = 'Bejelentkez&eacute;s';
$lang['prompt_signin_button'] = 'Bejelentkez&eacute;s gomb c&iacute;mke';
$lang['prompt_username'] = 'Felhaszn&aacute;l&oacute;n&eacute;v';
$lang['prompt_email'] = 'Email c&iacute;m';
$lang['prompt_password'] = 'Jelsz&oacute;';
$lang['prompt_rememberme'] = 'Eml&eacute;kezz r&aacute;m ezen a g&eacute;pen';
$lang['register'] = 'Regisztr&aacute;ci&oacute;';
$lang['forgotpw'] = 'Elfelejtetted a jelszavad?';
$lang['lostusername'] = 'Elfelejtetted a bel&eacute;p&eacute;si inform&aacute;ci&oacute;dat?';
$lang['defaults'] = 'Alap&eacute;rtelmezett &eacute;rt&eacute;kek';
$lang['template'] = 'Sablon';
$lang['error_usernotfound'] = 'Nem tal&aacute;ltam inform&aacute;ci&oacute;t erről a felhaszn&aacute;l&oacute;r&oacute;l';
$lang['error_usernametaken'] = 'Ez a felhaszn&aacute;l&oacute;n&eacute;v (%s) m&aacute;r foglalt';
$lang['prompt_smtpvalidate'] = 'Haszn&aacute;lj SMTP-t, hogy &eacute;rv&eacute;nyes&iacute;tsd az email c&iacute;meket';
$lang['prompt_minpwlen'] = 'Minimum jelsz&oacute; hossz';
$lang['prompt_maxpwlen'] = 'Maximum jelsz&oacute; hossz';
$lang['prompt_minunlen'] = 'Minimum felhaszn&aacute;l&oacute;n&eacute;v hossz';
$lang['prompt_maxunlen'] = 'Maximum felhaszn&aacute;l&oacute;n&eacute;v hossz';
$lang['prompt_sessiontimeout'] = 'Session Timeout (seconds)';
$lang['prompt_cookiekeepalive'] = 'Use cookies to keep logins alive';
$lang['prompt_allowemailreg'] = 'Allow Email Registration';
$lang['prompt_dfltgroup'] = 'Alap&eacute;rtelmezett csoport az &uacute;j felhaszn&aacute;l&oacute;knak';
$lang['changesettings_template'] = 'Be&aacute;ll&iacute;t&aacute;sok m&oacute;dos&iacute;t&aacute;sa sablon';
$lang['error_passwordmismatch'] = 'Jelszavak nem tal&aacute;lnak';
$lang['error_invalidusername'] = '&Eacute;rv&eacute;nytelen felhaszn&aacute;l&oacute;n&eacute;v';
$lang['error_invalidpassword'] = '&Eacute;rv&eacute;nytelen jelsz&oacute;';
$lang['edituser'] = 'Felhaszn&aacute;l&oacute; m&oacute;dos&iacute;t&aacute;sa';
$lang['valid'] = '&Eacute;rv&eacute;nyes';
$lang['username'] = 'Felhaszn&aacute;l&oacute;n&eacute;v';
$lang['status'] = '&Aacute;llapot';
$lang['error_membergroups'] = 'Ez a felhaszn&aacute;l&oacute; nem tagja egy csoportnak sem';
$lang['error_properties'] = 'No Properties';
$lang['error_dup_properties'] = 'Attempt to import duplicate properties';
$lang['value'] = '&Eacute;rt&eacute;k';
$lang['groups'] = 'Csoportok';
$lang['properties'] = 'Tulajdons&aacute;gok';
$lang['propname'] = 'Tulajdons&aacute;g neve';
$lang['propvalue'] = 'Tulajdons&aacute;g &eacute;rt&eacute;ke';
$lang['add'] = 'Hozz&aacute;ad&aacute;s';
$lang['history'] = 'History';
$lang['edit'] = 'Szerkeszt&eacute;s';
$lang['expires'] = 'Lej&aacute;r';
$lang['specify_date'] = 'Hat&aacute;rozd meg a d&aacute;tumot';
$lang['12hrs'] = '12 &Oacute;ra';
$lang['24hrs'] = '24 &Oacute;ra';
$lang['48hrs'] = '48 &Oacute;ra';
$lang['1week'] = '1 h&eacute;t';
$lang['2weeks'] = '2 h&eacute;t';
$lang['1month'] = '1 h&oacute;nap';
$lang['3months'] = '3 h&oacute;nap';
$lang['6months'] = '6 h&oacute;nap';
$lang['1year'] = '1 &eacute;v';
$lang['never'] = 'Soha';
$lang['postinstallmessage'] = 'Module installed sucessfully.<br/>Be sure to set the &quot;Modify FrontEndUser Properties permission.  Additionally, we recommend that you install the Captcha module.  If installed, validation of a captcha image will be required in addition to the username and password to login.  This is intended to prevent brute force attacks.  <strong>Note:</strong> The nocaptcha parameter can be used to disable this functionality even if the Captcha module is installed.&quot;';
$lang['password'] = 'Jelsz&oacute;';
$lang['repeatpassword'] = '&Uacute;jra';
$lang['error_groupname_exists'] = 'Ilyen nevű csoport m&aacute;r l&eacute;tezik';
$lang['editgroup'] = 'Csoport szerkeszt&eacute;se';
$lang['submit'] = 'K&uuml;ld&eacute;s';
$lang['cancel'] = 'M&eacute;gse';
$lang['delete'] = 'T&ouml;rl&eacute;s';
$lang['confirm_editgroup'] = 'Are you sure this is the proper settings for this group?\nTurning a property off will not delete any entries in the properties table for this group/user.  They will merely be unavailable.';
$lang['areyousure_deletegroup'] = 'Biztosan t&ouml;r&ouml;lni akarod ezt a csoportot?';
$lang['confirm_delete_prop'] = 'Are you sure you want to completely delete this property?\nDoing so will also erase any user entries for this property.';
$lang['error_insufficientparams'] = 'El&eacute;gtelen param&eacute;ter';
$lang['id'] = 'Id';
$lang['name'] = 'N&eacute;v';
$lang['error_cantaddprop'] = 'Problem adding property';
$lang['error_cantaddgroupreln'] = 'Problem adding group relation';
$lang['error_cantaddgroup'] = 'Problem adding group';
$lang['error_cantassignuser'] = 'Problem adding a user to a group';
$lang['error_couldnotdeleteproperty'] = 'Problem deleting a property';
$lang['error_couldnotfindemail'] = 'Nem tal&aacute;ltam email c&iacute;met';
$lang['error_destinationnotwritable'] = 'No write permission to destination directory';
$lang['error_invalidparams'] = 'Invalid Parameters';
$lang['error_nogroups'] = 'Nem tal&aacute;ltam csoportot';
$lang['applyfilter'] = 'Alkalmaz';
$lang['filter'] = 'Szűrő';
$lang['userfilter'] = 'Username Regular Expression';
$lang['description'] = 'Le&iacute;r&aacute;s';
$lang['groupname'] = 'Csoport neve';
$lang['accessdenied'] = 'Hozz&aacute;f&eacute;r&eacute;s megtiltva';
$lang['error'] = 'Hiba';
$lang['addgroup'] = 'Csoport hozz&aacute;ad&aacute;sa';
$lang['importgroup'] = 'Csoport import&aacute;l&aacute;sa';
$lang['adduser'] = 'Felhaszn&aacute;l&oacute; hozz&aacute;ad&aacute;sa';
$lang['usersfound'] = 'Felhaszn&aacute;l&oacute;k, akik megfelelnek a krit&eacute;riumoknak';
$lang['group'] = 'Csoport';
$lang['selectgroup'] = 'Csoport kiv&aacute;laszt&aacute;sa';
$lang['registration_template'] = 'Regisztr&aacute;ci&oacute;s sablon';
$lang['logout_template'] = 'Kijelentkez&eacute;s sablon';
$lang['login_template'] = 'Bejelentkez&eacute;s sablon';
$lang['preferences'] = 'Preferenci&aacute;k';
$lang['users'] = 'Felhaszn&aacute;l&oacute;k';
$lang['friendlyname'] = 'Frontend User Management';
$lang['moddescription'] = 'Allow users to log in to the frontend of your site';
$lang['defaultfrontpage'] = 'Elap&eacute;rtelmezett főoldal';
$lang['lastaccessedpage'] = 'Utols&oacute; megl&aacute;togatott oldal';
$lang['otherpage'] = 'M&aacute;s oldal: ';
$lang['captcha_title'] = '&Iacute;rd be a sz&ouml;veget a k&eacute;pről';
?>
