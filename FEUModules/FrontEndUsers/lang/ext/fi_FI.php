<?php
$lang['prompt_viewprops'] = 'Select Additional Properties to View';
$lang['view'] = 'View';
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
$lang['msg_settingschanged'] = 'Asetuksesi on p&auml;ivitetty onnistuneesti';
$lang['forcedlogouttask_desc'] = 'Force users to logout at regular intervals';
$lang['prompt_forcelogout_times'] = 'Times for forced logout';
$lang['info_forcelogout_times'] = 'Specify a comma separated list of times like HH:MM,HH:MM where users will be forcibly logged out. Note, this uses the psuedocron mechanism so you must be sure that the times entered here will coincide reasonably with your &quot;pseudocron granularity&quot; and that sufficient requests will occur to your website to ensure that pseudocron is executed.';
$lang['prompt_forcelogout_sessionage'] = 'Exclude users that have been active in <em>(minutes)</em>';
$lang['info_forcelogout_sessionage'] = 'If specified, any users that have been active in this number of seconds will not be forcibly logged out';
$lang['areyousure_delete'] = 'Are you sure you want to delete the user %s';
$lang['error_invalidfileextension'] = 'The uploaded file does not match the list of allowed file types';
$lang['postuninstall'] = 'All data associated with the FrontEndUsers module has been deleted';
$lang['info_ecomm_paidregistration'] = 'If enabled, this module will listen to events from the Ecommerce suite.  The following settings only have effect if this setting is enabled.';
$lang['prompt_ecomm_paidregistration'] = 'Listen to Order Events';
$lang['info_paidreg_settings'] = 'The following settings only apply if using self registration and allowing for paid registration';
$lang['none'] = 'None';
$lang['delete_user'] = 'Delete User';
$lang['expire_user'] = 'Expire User';
$lang['prompt_action_ordercancelled'] = 'Action to perform when a subscription order is cancelled';
$lang['prompt_action_orderdeleted'] = 'Action to perform when a subscription order is deleted';
$lang['ecommerce_settings'] = 'Ecommerce Settings';
$lang['securefieldmarker'] = 'Secure Field Marker';
$lang['securefieldcolor'] = 'Secure Field Color';
$lang['prompt_encrypt'] = 'Store this data encrypted in the database';
$lang['error_notsupported'] = 'The chosen option is not supported given your current configuration';
$lang['audit_user_created'] = 'User automatically created';
$lang['info_auto_create_unknown'] = 'If a user is authenticated by an external authentication module but is not known in the FrontEndUsers module should an FEU account be created automatically?';
$lang['prompt_auto_create_unknown'] = 'Automatically Create Unknown Users';
$lang['display_settings'] = 'Display Settings';
$lang['info_std_auth_settings'] = 'The following settings are only applicable if using the &quot;Builtin Authentication&quot;.';
$lang['info_support_lostun'] = 'Selecting No will disable the ability for a user to request lost login information, irrespective of other settings';
$lang['info_support_lostpw'] = 'Selecting No will disable the ability for a user to a password reset, irrespective of other settings';
$lang['prompt_support_lostun'] = 'Allow users to request their username';
$lang['prompt_support_lostpw'] = 'Allow users to request a password change';
$lang['auth_settings'] = 'Authentication Settings';
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
$lang['title_reset_session'] = 'Login Session Timeout Warning';
$lang['msg_reset_session'] = 'Your login session is about to expire, please click &quot;&quot;Ok&quot; to confirm your activity on this website.';
$lang['ok'] = 'Ok';
$lang['resetsession_template'] = 'Reset Session Template';
$lang['info_name'] = 'This is the field name, to be used for addressing in smarty.  It must consist of only alphanumeric characters and underscores.';
$lang['visitors_tab'] = 'Visitors';
$lang['feu_groups_prompt'] = 'Select one or more FEU groups that are allowed to view this page';
$lang['error_mustselect_group'] = 'A group must be selected';
$lang['selectone'] = 'Select One';
$lang['start_year'] = 'Start Year';
$lang['end_year'] = 'End Year';
$lang['date'] = 'Date';
$lang['prompt_thumbnail_size'] = 'Thumbnail Size';
$lang['OnUpdateGroup'] = 'On User Group Modified';
$lang['error_toomanyselected'] = 'Too many users are selected for bulk operations.... Please trim it to 250 or less';
$lang['confirm_delete_selected'] = 'Are you sure you want to delete the selected users?';
$lang['delete_selected'] = 'Delete Selected';
$lang['prompt_randomusername'] = 'Generate random username when adding new users';
$lang['months'] = 'months';
$lang['prompt_expireage'] = 'Default user expiry period';
$lang['notification_settings'] = 'Notification Settings';
$lang['property_settings'] = 'Property Settings';
$lang['redirection_settings'] = 'Redirection Settings';
$lang['general_settings'] = 'General Settings';
$lang['session_settings'] = 'Session and Cookie Settings';
$lang['field_settings'] = 'Field Settings';
$lang['error_lostun_nonrequired'] = 'The lostusername flag can only be used on required fields';
$lang['prop_textarea_wysiwyg'] = 'Allow use of wysiwyg on this text area';
$lang['info_cookiestoremember'] = '<strong>Note: </strong> This uses the mcrypt functions for encryption purposes, and they could not be detected on your install.   Please contact your server administrator.';
$lang['editing_user'] = 'Editing User';
$lang['noinline'] = 'Do not inline forms';
$lang['info_lostun'] = 'Paina t&auml;st&auml;, jos et muista kirjautumistietojasi';
$lang['info_forgotpw'] = 'Paina t&auml;st&auml;, jos et muista salasanaasi';
$lang['info_logout'] = 'Klikkaa kirjautuaksesi ulos';
$lang['info_changesettings'] = 'Paina t&auml;st&auml; muokataksesi salasanaasi tai muita tietojasi';
$lang['viewuser_template'] = 'N&auml;yt&auml; k&auml;ytt&auml;j&auml; -pohja';
$lang['event'] = 'Tapahtuma';
$lang['feu_event_notification'] = 'FEU-tapahtumahuomautus';
$lang['prompt_notification_address'] = 'Ilmoitusviestien kohdeosoite';
$lang['prompt_notification_template'] = 'Ilmoitusviestien pohja';
$lang['prompt_notification_subject'] = 'Ilmoitusviestien aihe (Subject)';
$lang['prompt_notifications'] = 'S&auml;hk&ouml;posti-ilmoitukset';
$lang['OnLogin'] = 'Sis&auml;&auml;nkirjautuessa';
$lang['OnLogout'] = 'Uloskirjautuessa';
$lang['OnExpireUser'] = 'Istunnon vanhetessa';
$lang['OnCreateUser'] = 'K&auml;ytt&auml;ji&auml; luodessa';
$lang['OnDeleteUser'] = 'K&auml;ytt&auml;ji&auml; poistettaessa';
$lang['OnUpdateUser'] = 'K&auml;ytt&auml;j&auml;n asetuksien muuttuessa';
$lang['OnCreateGroup'] = 'Luotaessa k&auml;ytt&auml;j&auml;ryhm&auml;';
$lang['OnDeleteGroup'] = 'Poistettaessa k&auml;ytt&auml;j&auml;ryhm&auml;';
$lang['lostunconfirm_premsg'] = '&quot;Kadonneet kirjautumistiedot&quot;-toiminnallisuus on onnistuneesti suoritettu. L&ouml;ydettiin uniikki k&auml;ytt&auml;j&auml;tunnus, joka vastaa antamiasi tietoja.';
$lang['your_username_is'] = 'K&auml;ytt&auml;j&auml;tunnuksesi on';
$lang['lostunconfirm_postmsg'] = 'Suosittelemme kirjaamaan t&auml;m&auml;n tiedon yl&ouml;s turvalliseen, mutta saatavilla olevaan sijaintiin.';
$lang['prompt_after_change_settings'] = 'PageID/Alias, jonne siirryt&auml;&auml;n asetusten muutoksen j&auml;lkeen';
$lang['prompt_after_verify_code'] = 'PageID/Alias koodin varmennuksen j&auml;lkeen *';
$lang['lostun_details_template'] = 'Kadonnut k&auml;ytt&auml;j&auml;tunnus pohja';
$lang['lostun_confirm_template'] = 'Kadonnut k&auml;ytt&auml;j&auml;tunnus varmennus pohja';
$lang['error_nonuniquematch'] = 'Virhe: Enemm&auml;n kuin yksi tili l&ouml;ytyi ominaisuuksilla';
$lang['error_cantfinduser'] = 'Virhe: K&auml;ytt&auml;j&auml;&auml; ei l&ouml;ytynyt n&auml;ill&auml; ehdoilla';
$lang['error_groupnotfound'] = 'Virhe: Ryhm&auml;&auml; ei l&ouml;ytynyt';
$lang['readonly'] = 'Vain luku';
$lang['prompt_usermanipulator'] = 'K&auml;ytt&auml;jien muokkausluokka';
$lang['admin_logout'] = 'Yll&auml;pit&auml;j&auml; kirjasi ulos';
$lang['prompt_loggedinonly'] = 'N&auml;yt&auml; vain kirjautuneet k&auml;ytt&auml;j&auml;t';
$lang['prompt_logout'] = 'Kirjaa t&auml;m&auml; k&auml;ytt&auml;j&auml; ulos';
$lang['user_properties'] = 'K&auml;ytt&auml;j&auml;n ominaisuudet';
$lang['userhistory'] = 'K&auml;ytt&auml;j&auml;n historia';
$lang['export'] = 'Vie';
$lang['clear'] = 'Tyhjenn&auml;';
$lang['prompt_exportuserhistory'] = 'Vie k&auml;ytt&auml;j&auml;historia ASCII-muodossa joka on v&auml;hint&auml;&auml;n';
$lang['prompt_clearuserhistory'] = 'Tyhjenn&auml; k&auml;ytt&auml;j&auml;historia joka on v&auml;hint&auml;&auml;n';
$lang['title_lostusername'] = 'Unohditko tunnuksen tai salasanan?';
$lang['title_rssexport'] = 'Vie ryhm&auml;m&auml;&auml;ritykset XML-muodossa';
$lang['title_userhistorymaintenance'] = 'K&auml;ytt&auml;j&auml;historian hallinta';
$lang['yes'] = 'Kyll&auml;';
$lang['no'] = 'Ei';
$lang['prompt_of'] = '/';
$lang['date_allrecords'] = '** Ei rajoitusta **';
$lang['date_onehourold'] = 'Tunnin vanha';
$lang['date_sixhourold'] = 'Kuusi tuntia vanha';
$lang['date_twelvehourold'] = 'Kaksitoista tuntia vanha';
$lang['date_onedayold'] = 'P&auml;iv&auml;n vanha';
$lang['date_oneweekold'] = 'Viikon vanha';
$lang['date_twoweeksold'] = 'Kaksi viikkoa vanha';
$lang['date_onemonthold'] = 'Kuukauden vanha';
$lang['date_threemonthsold'] = 'Kolme kuukautta vanha';
$lang['date_sixmonthsold'] = 'Kuusi kuukautta vanha';
$lang['date_oneyearold'] = 'Vuoden vanha';
$lang['title_groupsort'] = 'Ryhmittely ja j&auml;rjestys';
$lang['prompt_recordsfound'] = 'Hakuehtoja vastaavat merkinn&auml;t';
$lang['sortorder_username_desc'] = 'K&auml;ytt&auml;j&auml;tunnus laskeva';
$lang['sortorder_username_asc'] = 'K&auml;ytt&auml;j&auml;tunnus nouseva';
$lang['sortorder_date_desc'] = 'P&auml;iv&auml;m&auml;&auml;r&auml; laskeva';
$lang['sortorder_date_asc'] = 'P&auml;iv&auml;m&auml;&auml;r&auml; nouseva';
$lang['sortorder_action_desc'] = 'Tapahtuman tyyppi laskeva';
$lang['sortorder_action_asc'] = 'Tapahtuman tyyppi nouseva';
$lang['sortorder_ipaddress_desc'] = 'IP-osoite laskeva';
$lang['sortorder_ipaddress_asc'] = 'IP-osoite nouseva';
$lang['info_nohistorydetected'] = 'Ei historiaa';
$lang['reset'] = 'Nollaa';
$lang['prompt_group_ip'] = 'Ryhmittele IP-osoitteen mukaan';
$lang['prompt_filter_eventtype'] = 'Tapahtumatyyppisuodatus';
$lang['prompt_filter_date'] = 'N&auml;yt&auml; vain tapahtumat jotka ovat:';
$lang['prompt_pagelimit'] = 'Sivurajoitus';
$lang['for'] = 'for';
$lang['title_userhistory'] = 'K&auml;ytt&auml;j&auml;historiaraportti';
$lang['unknown'] = 'Tuntematon';
$lang['prompt_ipaddress'] = 'IP-Osoite';
$lang['prompt_eventtype'] = 'Tapahtuman tyyppi';
$lang['prompt_date'] = 'P&auml;iv&auml;';
$lang['prompt_return'] = 'Palaa';
$lang['import_complete_msg'] = 'Tuonti onnistui';
$lang['prompt_linesprocessed'] = 'Rivi&auml; k&auml;sitelty';
$lang['prompt_errors'] = 'Virheit&auml; l&ouml;ytyi';
$lang['prompt_recordsadded'] = 'Merkint&auml;&auml; lis&auml;tty';
$lang['error_nogroupproprelns'] = 'Ryhm&auml;lle %s ei l&ouml;ytynyt ominaisuuksia';
$lang['error_noresponsefromserver'] = 'SMTP-serveriin ei saatu yhteytt&auml;';
$lang['error_importfilenotfound'] = 'Tiedostoa (%s) ei l&ouml;ytynyt';
$lang['error_importfieldvalue'] = 'Virheellinen arvo kent&auml;ss&auml; %s';
$lang['error_importfieldlength'] = 'Kent&auml;ss&auml; %s liian pitk&auml; arvo';
$lang['error_importusers'] = 'Tuontivirhe (rivi %s): %s';
$lang['error_propertydefns'] = 'Ei voitu ladata ominaisuustietoja (Sis&auml;inen virhe)';
$lang['error_problemsettinginfo'] = 'Ongelma asetettaessa k&auml;ytt&auml;j&auml;n tietoja';
$lang['error_importrequiredfield'] = 'Vaaditulle kent&auml;lle %s ei l&ouml;ytynyt saraketta';
$lang['error_nogroupproperties'] = 'Ryhm&auml;lle ei l&ouml;ydy ominaisuuksia';
$lang['error_importfileformat'] = 'Tuontitiedoston muoto on v&auml;&auml;r&auml;';
$lang['error_couldnotopenfile'] = 'Tiedostoa ei voitu avata';
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
</pre>';
$lang['prompt_importdestgroup'] = 'Tuo k&auml;ytt&auml;j&auml;t ryhm&auml;&auml;n';
$lang['prompt_importfilename'] = 'CSV-tiedosto';
$lang['prompt_importxmlfile'] = 'XML-tiedosto';
$lang['prompt_exportusers'] = 'Vie k&auml;ytt&auml;j&auml;t';
$lang['prompt_importusers'] = 'Tuo k&auml;ytt&auml;j&auml;t';
$lang['prompt_clear'] = 'Tyhjenn&auml;';
$lang['prompt_image_destination_path'] = 'Kuvan kohdepolku';
$lang['error_missing_upload'] = 'Havaittiin ongelma puuttuvan (ja vaaditun) uploadin kanssa';
$lang['error_bad_xml'] = 'XML-tiedostoa ei voitu lukea';
$lang['error_notemptygroup'] = 'Ei voida tuhota ryhm&auml;&auml; jossa on viela k&auml;ytt&auml;ji&auml;';
$lang['error_norepeatedlogins'] = 'K&auml;ytt&auml;j&auml; on jo kirjautuneena';
$lang['error_captchamismatch'] = 'Kuvassa oleva teksti ei ole sy&ouml;tetty oikein';
$lang['prompt_allow_repeated_logins'] = 'Salli k&auml;ytt&auml;jien kirjautua useamman kerran';
$lang['prompt_allowed_image_extensions'] = 'Kuvien tiedostop&auml;&auml;tteet joita k&auml;ytt&auml;j&auml;t saavat ladata';
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
$lang['event_info_OnLogin'] = 'Suoritetaan kun k&auml;ytt&auml;j&auml; kirjautuu j&auml;rjestelm&auml;&auml;n';
$lang['event_info_OnLogout'] = 'Suoritetaan kun k&auml;ytt&auml;j&auml; kirjautuu ulos j&auml;rjestelm&auml;st&auml;';
$lang['event_info_OnExpireUser'] = 'Suoritetaan kun k&auml;ytt&auml;j&auml;n istunto vanhenee';
$lang['event_info_OnCreateUser'] = 'Suoritetaan kun uusi k&auml;ytt&auml;j&auml; luodaan';
$lang['event_info_OnRefreshUser'] = 'An event generated when the user session is refreshed';
$lang['event_info_OnUpdateUser'] = 'Suoritetaan kun k&auml;ytt&auml;j&auml;n tietoja p&auml;ivitet&auml;&auml;n';
$lang['event_info_OnDeleteUser'] = 'Suoritetaan kun k&auml;ytt&auml;j&auml;n tili poistetaan';
$lang['event_info_OnCreateGroup'] = 'Suoritetaan kun ryhm&auml; luodaan';
$lang['event_info_OnUpdateGroup'] = 'An event generated when a user group is updated';
$lang['event_info_OnDeleteGroup'] = 'Suoritetaan kun ryhm&auml; poistetaan';
$lang['backend_group'] = 'Backend Group';
$lang['info_star'] = '* Seuraavia makroja voidaan k&auml;ytt&auml;&auml;: {$username},{$group}. When using the {$group} macro, the system will subsitute the name of the first member group that the user belongs to, and will redirect to that page.';
$lang['info_admin_password'] = 'Muokkaa t&auml;t&auml; kentt&auml;&auml; nollataksesi k&auml;ytt&auml;j&auml;n salasanan';
$lang['info_admin_repeatpassword'] = 'Muokkaa t&auml;t&auml; kentt&auml;&auml; nollataksesi k&auml;ytt&auml;j&auml;n salasanan';
$lang['error_username_exists'] = 'K&auml;ytt&auml;j&auml;tunnus on jo k&auml;yt&ouml;ss&auml;';
$lang['nocsvresults'] = 'CSV export ei palauttanut tuloksia';
$lang['prompt_unfldlen'] = 'K&auml;ytt&auml;j&auml;tunnuskent&auml;n pituus';
$lang['prompt_pwfldlen'] = 'Salasanakent&auml;n pituus';
$lang['error_invalidpasswordlengths'] = 'Minimi-/Maksimi-pituudet salasanalle ovat virheelliset';
$lang['error_invalidusernamelengths'] = 'Minimi-/Maksimi-pituudet k&auml;ytt&auml;j&auml;tunnukselle ovat virheelliset';
$lang['error_invalidemailaddress'] = 'Virheellinen email-osoite';
$lang['error_noemailaddress'] = 'Tilille ei l&ouml;ytynyt email-osoitetta';
$lang['error_problemseettinginfo'] = 'Ongelma asetettaessa k&auml;ytt&auml;j&auml;n tietoja';
$lang['error_settingproperty'] = 'Ongelma asetettaessa ominaisuuksia';
$lang['user_added'] = 'K&auml;ytt&auml;j&auml; lis&auml;tty %s=%s';
$lang['user_deleted'] = 'K&auml;ytt&auml;j&auml; poistettu uid=%s';
$lang['propertyfilter'] = 'Ominaisuus';
$lang['valueregex'] = 'Arvo (reqular expression)';
$lang['warning_effectsfieldlength'] = 'Varoitus: N&auml;m&auml; kent&auml;t vaikuttavat sy&ouml;tt&ouml;kenttien kokoon. Arvojen pienent&auml;minen ei ole suositeltavaa k&auml;ytt&ouml;ss&auml; olevalla sivustolla';
$lang['confirm_submitprefs'] = 'Haluatko varmasti muokata modulin asetuksia';
$lang['error_emailalreadyused'] = 'Email osoite on jo k&auml;yt&ouml;ss&auml;';
$lang['prompt_usecookiestoremember'] = 'K&auml;yt&auml; keksej&auml; kirjautumistietojen tallennukseen';
$lang['prompt_cookiename'] = 'Keksin nimi';
$lang['prompt_allow_duplicate_emails'] = 'Salli tupla-emailit';
$lang['prompt_username_is_email'] = 'S&auml;hk&ouml;postiosoite on k&auml;ytt&auml;j&auml;nimi';
$lang['info_cookie_keepalive'] = 'Yrit&auml; pit&auml;&auml; k&auml;ytt&auml;jien kirjautuminen aktiivisena keksill&auml;';
$lang['info_allow_duplicate_emails'] = 'Salli useille k&auml;ytt&auml;jille sama email-osoite';
$lang['info_username_is_email'] = '(user&#039;s email address is their username -- don&#039;t set this with &quot;allow duplicate email addresses&quot;!)';
$lang['prompt_allow_duplicate_reminders'] = 'Salli useat &quot;unohditko salasanasi&quot; viestit?';
$lang['info_allow_duplicate_reminders'] = 'Salli k&auml;ytt&auml;jien pyyt&auml;&auml; salasana uudestaan vaikka edelliseen kutsuun ei ole viel&auml; reagoitu';
$lang['prompt_feusers_specific_permissions'] = 'K&auml;yt&auml; Front-end User specifici&auml; oikeuksia';
$lang['info_feusers_specific_permissions'] = '(Normally, FEUSers permissions are the same as the equivalent Admin Area permissions like Add User, Add Group, etc. If you select this option, there will be separate permissions for FEUsers.)';
$lang['error_missingupload'] = 'Ei voitu avata ladattua tiedostoa';
$lang['error_problem_upload'] = 'Ladatussa tiedostossa on havaittu ongelma, ole hyv&auml; ja yrit&auml; uudelleen';
$lang['error_missingusername'] = 'Et sy&ouml;tt&auml;nyt k&auml;ytt&auml;j&auml;tunnusta';
$lang['error_missingemail'] = 'Et sy&ouml;tt&auml;nyt s&auml;hk&ouml;postiosoitettasi';
$lang['error_missingpassword'] = 'Et sy&ouml;tt&auml;nyt salasanaa';
$lang['frontenduser_logout'] = 'Kirjaudu ulos';
$lang['frontenduser_loggedin'] = 'Kirjaudu sis&auml;&auml;n';
$lang['editprop_infomsg'] = '<font color=\&quot;red\&quot;><b>USE CAUTION</b> when changing existing properties that are assigned to groups, you may potentially cause damage and break an existing site <i>(especially if you reduce field lengths, etc)</i></font>';
$lang['info_smtpvalidate'] = 'T&auml;m&auml; toiminto ei toimi Windows-ymp&auml;rist&ouml;ss&auml;';
$lang['msg_dontcreateusername'] = '&Auml;L&Auml; luo ominaisuutta k&auml;ytt&auml;j&auml;tunnukselle tai salasanalle, n&auml;m&auml; kent&auml;t luodaan aina automaattisesti.';
$lang['prompt_exportcsv'] = 'Vie k&auml;ytt&auml;j&auml;t CSV-tiedostoon';
$lang['exportcsv'] = 'Vie';
$lang['importcsv'] = 'Tuo';
$lang['admin'] = 'Hallinnoi';
$lang['editprop'] = 'Muokkaa ominaisuutta';
$lang['maxlength'] = 'Maksimi pituus';
$lang['created'] = 'Luotu';
$lang['sortby'] = 'J&auml;rjest&auml;';
$lang['sort'] = 'J&auml;rjestys';
$lang['usersingroup'] = 'K&auml;ytt&auml;j&auml;t valitussa ryhm&auml;ss&auml;';
$lang['userlimit'] = 'N&auml;yt&auml; rivi&auml;:';
$lang['error_noemailfield'] = 'K&auml;ytt&auml;j&auml;lle ei l&ouml;ydetty email kentt&auml;&auml;. Ota yhtett&auml; webmasteriin';
$lang['prompt_forgotpw_page'] = 'PageID/Alias &quot;unohtunut salasana&quot; -lomakkeelle';
$lang['prompt_changesettings_page'] = 'PageID/Alias &quot;muuta asetuksia&quot; -lomakkeelle';
$lang['prompt_login_page'] = 'PageID/Alias joka n&auml;ytet&auml;&auml;n kirjautumisen j&auml;lkeen';
$lang['prompt_logout_page'] = 'PageID/Alias joka n&auml;ytet&auml;&auml;n ulos kirjautumisen j&auml;lkeen';
$lang['sortorder'] = 'J&auml;rjestys';
$lang['prompt_numresetrecord'] = 'Joitain k&auml;ytt&auml;ji&auml; on t&auml;ll&auml; hetkell&auml; resetoimassa salasanojaan. T&auml;ll&auml; hetkell&auml; n&auml;it&auml; k&auml;ytt&auml;ji&auml; ovat: ';
$lang['remove1week'] = 'Poista kaikki yli viikon vanhat merkinn&auml;t';
$lang['remove1month'] = 'Poista kaikki yli kuukauden vanhat merkinn&auml;t';
$lang['removeall'] = 'Poista kaikki merkinn&auml;t';
$lang['areyousure'] = 'Oletko varma?';
$lang['error_invalidcode'] = 'Virheellinen koodi, ole hyv&auml; ja yrit&auml; uudelleen';
$lang['error_tempcodenotfound'] = 'V&auml;liaikaista koodia k&auml;ytt&auml;j&auml;tunnukselle ei l&ouml;ytynyt tietokannasta';
$lang['forgotpassword_verifytemplate'] = 'Pohja vahvistuslomakkeelle';
$lang['forgotpassword_emailtemplate'] = 'Pohja &quot;unohtunut salasana&quot; -s&auml;hk&ouml;postille';
$lang['error_resetalreadysent'] = 'Joko sin&auml; tai joku muu on halunnut nollata salasanan t&auml;lle tilille. Tarkista s&auml;hk&ouml;postisi, l&auml;yd&auml;t sielt&auml; jatko-ohjeet salasanan nollaamiseen';
$lang['error_dberror'] = 'Tietokantavirhe';
$lang['message_forgotpwemail'] = 'Sait t&auml;m&auml;n viestin koska joku on valinnut sivustolta &quot;unohditko salasanansi&quot; toiminnon. Jos teit t&auml;m&auml;n toiminnon itse l&ouml;yd&auml;t ohjeet alta. Jos et tied&auml; mist&auml; puhutaan voit tuhota t&auml;m&auml;n postin, kiitoksia ajastasi.';
$lang['prompt_code'] = 'Koodi';
$lang['message_code'] = 'Seuraava koodi on luotu sinulle, k&auml;yt&auml; koodia vahvistaaksesi ett&auml; olet tilin k&auml;ytt&auml;j&auml;. Kun klikkaat alla olevaa linkki&auml; sinun tarvitsee sy&ouml;tt&auml;&auml; t&auml;m&auml; koodi lomakkeeseen. Yleens&auml; kentt&auml; on valmiiksi t&auml;ytetty, mutta jos jostain syyst&auml; ei ole koodisi on:';
$lang['prompt_link'] = 'T&auml;m&auml; linkki vie sinut sivulle jonne voit sy&ouml;tt&auml;&auml; yll&auml; mainitun koodin ja nollata salasanasi';
$lang['lostpassword_emailsubject'] = 'Kadonnut salasana';
$lang['error_nomailermodule'] = 'Ei voitu k&auml;ytt&auml;&auml; CMSMailer-moduulia';
$lang['info_forgotpwmessagesent'] = 'Sinulle on l&auml;hetetty email-osoitteseen %s jossa on tiedot miten voit nollata salasanasi.';
$lang['lostpw_message'] = 'Unohdit siis salasanasi? Noh, kirjoita k&auml;ytt&auml;j&auml;tunnuksesi t&auml;h&auml;n ja l&auml;het&auml;mme tunnuksen s&auml;hk&ouml;postiosoitteeseen viestin joka sis&auml;lt&auml;&auml; ohjeet salasanasi nollaamiseen.';
$lang['forgotpassword_template'] = '&quot;Unohtunut salasana&quot; -pohja';
$lang['lostusername_template'] = '&quot;Unohtunut k&auml;ytt&auml;j&auml;tunnus&quot; -pohja';
$lang['error_propnotfound'] = 'Ominaisuutta %s ei l&ouml;ydy';
$lang['propsfound'] = 'Ominaisuuksia l&ouml;ytynyt';
$lang['addprop'] = 'Lis&auml;&auml; ominaisuus';
$lang['error_requiredfield'] = 'Vaadittu kentt&auml; (%s) on tyhj&auml;';
$lang['info_emptypasswordfield'] = 'Sy&ouml;t&auml; uusi salasana';
$lang['error_notloggedin'] = 'Et ole kirjautunut';
$lang['user_settings'] = 'Asetukset';
$lang['user_registration'] = 'Rekister&ouml;inti';
$lang['error_accountexpired'] = 'T&auml;m&auml; tilli on vanhentunut';
$lang['error_improperemailformat'] = 'Email-osoitteen muoto on v&auml;&auml;r&auml;';
$lang['error_invalidexpirydate'] = 'Virheellinen vanhentumisp&auml;iv&auml;';
$lang['error_problemsettingproperty'] = 'Virhe asetettaessa ominaisuutta %s k&auml;ytt&auml;j&auml;lle $s';
$lang['error_invalidgroupid'] = 'Virheellinen ryhm&auml; %s';
$lang['hiddenfieldmarker'] = 'Piilotettu kentt&auml; -merkint&auml;';
$lang['hiddenfieldcolor'] = 'Piilotetun kent&auml;n v&auml;ri';
$lang['hidden'] = 'Piilotettu';
$lang['error_duplicatename'] = 'Samalla nimell&auml; on jo ominaisuus';
$lang['error_noproperties'] = 'Ei ominaisuuksia m&auml;&auml;ritelty';
$lang['error_norelations'] = 'T&auml;lle ryhm&auml;lle ei ole valittuja ominaisuuksia';
$lang['nogroups'] = 'Ei m&auml;&auml;riteltyj&auml; ryhmi&auml;';
$lang['groupsfound'] = 'Ryhmi&auml; l&ouml;ytyi';
$lang['error_onegrouprequired'] = 'K&auml;ytt&auml;j&auml;n tulee kuulua v&auml;hint&auml;&auml;n yhteen ryhm&auml;&auml;n';
$lang['prompt_requireonegroup'] = 'Vaadi v&auml;hint&auml;&auml;n yksi ryhm&auml; per k&auml;ytt&auml;j&auml;';
$lang['back'] = 'Takaisin';
$lang['error_missing_required_param'] = '%s on vaadittu kentt&auml;';
$lang['requiredfieldmarker'] = 'Merkitse vaaditut kent&auml;t merkill&auml;';
$lang['requiredfieldcolor'] = 'Korosta vaadittuja kentti&auml;';
$lang['next'] = 'Seuraava';
$lang['error_groupexists'] = 'Samalla nimell&auml; on jo ryhm&auml;';
$lang['required'] = 'Vaadittu kentt&auml;';
$lang['optional'] = 'Vapaaehtoinen';
$lang['off'] = 'Off';
$lang['size'] = 'Koko';
$lang['sizecomment'] = '<br/>(Maksimi kuvan koko (leveys ja korkeus) pikseleiss&auml; )';
$lang['length'] = 'Pituus';
$lang['lengthcomment'] = '<br>(Merkkej&auml; teksti kent&auml;ss&auml;)';
$lang['seloptions'] = 'Alasvetovalikon valinnat, jokainen arvo omalla rivill&auml;&auml;n. Arvo voidaan erottaa = merkill&auml;, esim Nainen=N
';
$lang['radiooptions'] = 'Radiobutton labels, separated by line breaks. Values can be separated from text with a = character. i.e: Female=f';
$lang['prompt'] = 'Kehote';
$lang['prompt_type'] = 'Tyyppi';
$lang['type'] = 'Tyyppi';
$lang['fieldstatus'] = 'Kent&auml;n tila';
$lang['usedinlostun'] = 'Ask in Lost<br/>Username';
$lang['text'] = 'Teksti';
$lang['checkbox'] = 'Valintalaatikko';
$lang['multiselect'] = 'Monivalinta&quot;lista';
$lang['radiobuttons'] = 'Radio Buttons';
$lang['image'] = 'Kuva';
$lang['email'] = 'Email-osoite';
$lang['textarea'] = 'Tekstialue';
$lang['dropdown'] = 'Alasvetovalikko';
$lang['msg_currentlyloggedinas'] = 'Tervetuloa';
$lang['logout'] = 'Kirjaudu ulos';
$lang['prompt_newgroupname'] = 'K&auml;yt&auml; t&auml;t&auml; ryhm&auml; nime&auml;';
$lang['prompt_changesettings'] = 'Asetukseni';
$lang['error_loginfailed'] = 'Kirjautuminen ep&auml;onnistui - tarkista k&auml;ytt&auml;j&auml;tunnus ja salasana';
$lang['login'] = 'Kirjaudu';
$lang['prompt_signin_button'] = 'Kirjaudu sis&auml;&auml;n -napin otsikko';
$lang['prompt_username'] = 'K&auml;ytt&auml;j&auml;tunnus';
$lang['prompt_email'] = 'S&auml;hk&ouml;postiosoite';
$lang['prompt_password'] = 'Salasana';
$lang['prompt_rememberme'] = 'Muista minut t&auml;ll&auml; tietokoneella';
$lang['register'] = 'Rekister&ouml;idy';
$lang['forgotpw'] = 'Unohditko salasanasi';
$lang['lostusername'] = 'Unohditko kirjautumistietosi?';
$lang['defaults'] = 'Oletukset';
$lang['template'] = 'Pohja';
$lang['error_usernotfound'] = 'K&auml;ytt&auml;j&auml;&auml; ei l&ouml;ytynyt';
$lang['error_usernametaken'] = 'Valitsemasi k&auml;ytt&auml;j&auml;tunnus on jo k&auml;yt&ouml;ss&auml;';
$lang['prompt_smtpvalidate'] = 'K&auml;yt&auml; SMTP:t&auml; email-osoitteiden tarkistuksessa';
$lang['prompt_minpwlen'] = 'Salasanan minimipituus';
$lang['prompt_maxpwlen'] = 'Salasanan maksimipituus';
$lang['prompt_minunlen'] = 'K&auml;ytt&auml;j&auml;tunnuksen minimipituus';
$lang['prompt_maxunlen'] = 'K&auml;ytt&auml;j&auml;tunnuksen maksimipituus';
$lang['prompt_sessiontimeout'] = 'Istunnon aikakatkaisu (sekunteja)';
$lang['prompt_cookiekeepalive'] = 'K&auml;yt&auml; keksej&auml; pit&auml;&auml;ksesi kirjautumisen yll&auml;';
$lang['prompt_allowemailreg'] = 'Salli email-rekister&ouml;inti';
$lang['prompt_dfltgroup'] = 'Oletusryhm&auml; uusille k&auml;ytt&auml;jille';
$lang['changesettings_template'] = 'Vaihda asetuksia -pohja';
$lang['error_passwordmismatch'] = 'Salasanat eiv&auml;t ole yhtenev&auml;t';
$lang['error_invalidusername'] = 'K&auml;ytt&auml;j&auml;tunnus ei kelpaa';
$lang['error_invalidpassword'] = 'Salasana ei kelpaa';
$lang['edituser'] = 'Muokkaa k&auml;ytt&auml;j&auml;&auml;';
$lang['valid'] = 'Kelpaa';
$lang['username'] = 'K&auml;ytt&auml;j&auml;tunnus';
$lang['status'] = 'Tila';
$lang['error_membergroups'] = 'T&auml;m&auml; k&auml;ytt&auml;j&auml; ei kuulu mihink&auml;&auml;n ryhm&auml;&auml;n';
$lang['error_properties'] = 'Ei ominaisuuksia';
$lang['error_dup_properties'] = 'Yrit&auml; tuoda tuplaominaisuudet';
$lang['value'] = 'Arvo';
$lang['groups'] = 'Ryhm&auml;t';
$lang['properties'] = 'Ominaisuudet';
$lang['propname'] = 'Ominaisuuden nimi';
$lang['propvalue'] = 'Ominaisuuden arvo';
$lang['add'] = 'Lis&auml;&auml;';
$lang['history'] = 'Historia';
$lang['edit'] = 'Muokkaa';
$lang['expires'] = 'Vanhenee';
$lang['specify_date'] = 'M&auml;&auml;rittele p&auml;iv&auml;';
$lang['12hrs'] = '12 tuntia';
$lang['24hrs'] = '24 tuntia';
$lang['48hrs'] = '48 tuntia';
$lang['1week'] = '1 viikko';
$lang['2weeks'] = '2 viikkoa';
$lang['1month'] = '1 kuukausi';
$lang['3months'] = '3 kuukautta';
$lang['6months'] = '6 kuukautta';
$lang['1year'] = '1 vuosi';
$lang['never'] = 'Ei koskaan';
$lang['postinstallmessage'] = 'Module installed sucessfully.<br/>Be sure to set the \&quot;Modify FrontEndUser Properties permission.  Additionally, we recommend that you install the Captcha module.  If installed, validation of a captcha image will be required in addition to the username and password to login.  This is intended to prevent brute force attacks.  <strong>Note:</strong> The nocaptcha parameter can be used to disable this functionality even if the Captcha module is installed.\&quot;';
$lang['password'] = 'Salasana';
$lang['repeatpassword'] = 'Uudestaan';
$lang['error_groupname_exists'] = 'Nimell&auml; on jo ryhm&auml;';
$lang['editgroup'] = 'Muokkaa ryhm&auml;&auml;';
$lang['submit'] = 'L&auml;het&auml;';
$lang['cancel'] = 'Peruuta';
$lang['delete'] = 'Poista';
$lang['confirm_editgroup'] = 'Are you sure this is the proper settings for this group?\nTurning a property off will not delete any entries in the properties table for this group/user.  They will merely be unavailable.';
$lang['areyousure_deletegroup'] = 'Haluatko varmasti poistaa t&auml;m&auml;n ryhm&auml;&auml;n';
$lang['confirm_delete_prop'] = 'Are you sure you want to completely delete this property?\nDoing so will also erase any user entries for this property.';
$lang['error_insufficientparams'] = 'Riitt&auml;m&auml;tt&ouml;m&auml;t parametrit';
$lang['id'] = 'Id';
$lang['name'] = 'Nimi';
$lang['error_cantaddprop'] = 'Ongelma ominaisuuden lis&auml;yksess&auml;';
$lang['error_cantaddgroupreln'] = 'Ryhm&auml;liitoksen lis&auml;&auml;misessa esiintyi ongelma';
$lang['error_cantaddgroup'] = 'Ongelma ryhm&auml;n lis&auml;&auml;misess&auml;';
$lang['error_cantassignuser'] = 'Ongelma k&auml;ytt&auml;j&auml;n lis&auml;&auml;misess&auml; ryhm&auml;&auml;n';
$lang['error_couldnotdeleteproperty'] = 'Ongelma ominaisuuden poistamisessa';
$lang['error_couldnotfindemail'] = 'Email osoitetta ei l&ouml;ydetty';
$lang['error_destinationnotwritable'] = 'Kohde kansioon ei ole kirjoitusoikeutta';
$lang['error_invalidparams'] = 'Virheelliset parametrit';
$lang['error_nogroups'] = 'Ryhmi&auml; ei l&ouml;ytynyt';
$lang['applyfilter'] = 'Aseta';
$lang['filter'] = 'Suodata';
$lang['userfilter'] = 'K&auml;ytt&auml;j&auml;tunnus (regular expression)';
$lang['description'] = 'Kuvaus';
$lang['groupname'] = 'Ryhm&auml;n nimi';
$lang['accessdenied'] = 'P&auml;&auml;sy kielletty';
$lang['error'] = 'Virhe';
$lang['addgroup'] = 'Lis&auml;&auml; ryhm&auml;';
$lang['importgroup'] = 'Tuo ryhm&auml;';
$lang['adduser'] = 'Lis&auml;&auml; k&auml;ytt&auml;j&auml;';
$lang['usersfound'] = 'Hakuehtoihin sopivat k&auml;ytt&auml;j&auml;t';
$lang['group'] = 'Ryhm&auml;';
$lang['selectgroup'] = 'Valittu ryhm&auml;';
$lang['registration_template'] = 'Rekister&ouml;inti pohja';
$lang['logout_template'] = 'Kirjaudu ulos pohja';
$lang['login_template'] = 'Kirjautumis pohja';
$lang['preferences'] = 'Asetukset';
$lang['users'] = 'K&auml;ytt&auml;j&auml;t';
$lang['friendlyname'] = 'Frontend User Management';
$lang['moddescription'] = 'Sallii k&auml;ytt&auml;jien kirjautua sivustollesi';
$lang['defaultfrontpage'] = 'Oletus etusivu';
$lang['lastaccessedpage'] = 'Viimeksi k&auml;yty sivu';
$lang['otherpage'] = 'Toinen sivu: ';
$lang['captcha_title'] = 'Sy&ouml;t&auml; kuvassa n&auml;kyv&auml; teksti';
?>
