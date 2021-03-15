<?php
$lang['applied'] = 'Upraven&eacute;';
$lang['firstpage'] = '<<';
$lang['prevpage'] = '<';
$lang['nextpage'] = '>';
$lang['lastpage'] = '>>';
$lang['page'] = 'Strana';
$lang['prompt_allow_changeusername'] = 'Povoliť zmenu použ&iacute;vateľsk&eacute;ho mena';
$lang['info_allow_changeusername'] = 'Použ&iacute;vateľ si m&ocirc;že zmeniť jeho použ&iacute;vateľsk&eacute; meno spolu s ostatn&yacute;mi &uacute;dajmi';
$lang['template_saved'] = '&Scaron;abl&oacute;na uložen&aacute;';
$lang['template_resetdefaults'] = '&Scaron;abl&oacute;na zmenen&aacute; na prednastaven&uacute;';
$lang['lbl_settings'] = 'Nastavenia';
$lang['lbl_templates'] = '&Scaron;abl&oacute;ny';
$lang['enable_captcha'] = 'Povoliť overenie captcha v prihlasovaciom formul&aacute;ri';
$lang['info_enable_captcha'] = 'Ak použ&iacute;vateľ nie je prihl&aacute;seny a je zobrazen&yacute; prihlasovac&iacute; formul&aacute;r, toto nastavenie ovplivn&iacute;, či bude použit&eacute; overenie pomocou k&oacute;du captcha, pokiaľ je dostupn&yacute;.';
$lang['pagetype_unauthorized'] = 'Nem&aacute;te opr&aacute;vnenie na prezeranie tohoto obsahu';
$lang['info_contentpage_grouplist'] = 'Nastav zoznam FEU použ&iacute;vateľsk&yacute;ch skup&iacute;n, ktor&eacute; maj&uacute; pr&iacute;stup k tejto str&aacute;nke. Pokiaľ nie je vybran&aacute; žiadna skupina, maj&uacute; k nej pr&iacute;stup v&scaron;etci prihl&aacute;sen&yacute; použ&iacute;vatelia.';
$lang['pagetype_settings'] = 'Nastavenia chr&aacute;nen&yacute;ch str&aacute;nok';
$lang['pagetype_groups'] = 'Povolen&eacute; skupiny';
$lang['info_pagetype_groups'] = 'Vyberte skupiny, ktor&yacute;m je z&aacute;kladne povolen&eacute; zobrazenie chr&aacute;nen&yacute;ch str&aacute;nok. Administr&aacute;tor s pr&aacute;vami pre &uacute;pravu obsahu, m&aacute; možnosť upraviť tieto nastavenia pre jednotliv&eacute; str&aacute;nky.';
$lang['pagetype_action'] = 'Akcia pri nedostatočnom opr&aacute;vnen&iacute;';
$lang['info_pagetype_action'] = 'Akcia, ktor&aacute; sa m&aacute; vykonať pokiaľ použ&iacute;vateľ nem&aacute; dostatočn&eacute; opr&aacute;vnenia na zobrazenie obsahu. M&ocirc;že byť presmerovan&yacute; na určit&uacute; str&aacute;nku, alebo mu m&ocirc;že byť zobrazen&yacute; prihlasovac&iacute; formul&aacute;r';
$lang['showloginform'] = 'Zobraziť prihlasovac&iacute; formul&aacute;r';
$lang['redirect'] = 'Presmerovať na str&aacute;nku';
$lang['pagetype_redirectto'] = 'Presmerovať na';
$lang['info_pagetype_redirectto'] = 'Vyberte str&aacute;nku na ktor&uacute; m&aacute; byť použ&iacute;vateľ presmerovan&yacute;. Pokiaľ je akcia nastaven&aacute; na presmerovanie a nie je vybran&aacute; žiadna str&aacute;nka pre presmerovanie, použ&iacute;vateľovi bude zobrazen&aacute; varovn&aacute; spr&aacute;va.';
$lang['permissions'] = 'Opr&aacute;vnenia';
$lang['feu_protected_page'] = 'Chr&aacute;nen&yacute; obsah';
$lang['prompt_viewprops'] = 'Vyberte dodatočn&eacute; vlastnosti na zobrazenie';
$lang['view'] = 'Zobraziť';
$lang['info_ignore_userid'] = 'If checked the import routine will attempt to add users independant of the userid column.  If a user with the name specified in the import file already exists, an error will be generated';
$lang['ignore_userid'] = 'Ignore UserID Column on Import';
$lang['export_passhash'] = 'Export the password hash to the file';
$lang['info_export_passhash'] = 'The password hash is only useful if the password salt on the import host is identical to that of the export host';
$lang['error_adjustsalt'] = 'The password salt cannot be adjusted';
$lang['prompt_pwsalt'] = 'Password Salt';
$lang['info_pwsalt'] = 'FEU prid&aacute;va reťazec k heslu každ&eacute;ho použ&iacute;vateľa. Po tom ako s&uacute; použ&iacute;vatelia pridan&yacute; do datab&aacute;zi nie je možn&eacute; tento reťazec meniť. Pre star&scaron;ie in&scaron;tal&aacute;cie m&ocirc;že byť pr&aacute;zdny.';
$lang['advanced_settings'] = 'Roz&scaron;&iacute;ren&eacute; nastavenia';
$lang['info_sessiontimeout'] = 'Časov&yacute; interval po ktorom je použ&iacute;vateľ automatick&yacute; odhl&aacute;sen&yacute; z d&ocirc;vodu nečinnosti (v sekund&aacute;ch)';
$lang['prompt_expireusers_interval'] = 'Kontrola expir&aacute;cie';
$lang['info_expireusers_interval'] = 'Časov&yacute; interval, ako často m&aacute; syst&eacute;m n&uacute;tene odhl&aacute;siť použ&iacute;vateľov, ktor&yacute;ch sedenie vypr&scaron;alo (v sekund&aacute;ch). Sl&uacute;ži ako optimaliz&aacute;cia na zn&iacute;ženie zaťaženia datab&aacute;zi. Pri 0 sa kontrola vykon&aacute;va pri každej požiadavke.';
$lang['msg_settingschanged'] = 'Your settings were successfully updated';
$lang['forcedlogouttask_desc'] = 'Force users to logout at regular intervals';
$lang['prompt_forcelogout_times'] = 'Časi pre n&uacute;ten&eacute; odhl&aacute;senie';
$lang['info_forcelogout_times'] = 'Zoznam časov, oddelen&yacute;ch čiarov v tvare HH:MM,HH:MM, kedy maj&uacute; byť použ&iacute;vatelia n&uacute;tene odhl&aacute;sen&yacute;. Berte do &uacute;vahy, že sa využ&iacute;va mechanizmus pseudocron, takže je potrebn&eacute; v dan&yacute;ch časoch zaistiť splnenie podmienok na vyvolanie pr&iacute;kazu.';
$lang['prompt_forcelogout_sessionage'] = 'Vynechať použ&iacute;vateľov, ktor&yacute; boli akt&iacute;vny posledn&yacute;ch <em>(min&uacute;t)</em>';
$lang['info_forcelogout_sessionage'] = 'Použ&iacute;vateľ, ktor&yacute; bol akt&iacute;vny v danom časovom rozmedz&iacute;, nebude n&uacute;tene odhl&aacute;sen&yacute;.';
$lang['areyousure_delete'] = 'Are you sure you want to delete the user %s';
$lang['error_invalidfileextension'] = 'The uploaded file does not match the list of allowed file types';
$lang['postuninstall'] = 'All data associated with the FrontEndUsers module has been deleted';
$lang['info_ecomm_paidregistration'] = 'If enabled, this module will listen to events from the Ecommerce suite.  The following settings only have effect if this setting is enabled.';
$lang['prompt_ecomm_paidregistration'] = 'Listen to Order Events';
$lang['info_paidreg_settings'] = 'The following settings only apply if using self registration and allowing for paid registration';
$lang['none'] = 'Žiadne';
$lang['delete_user'] = 'Odstr&aacute;niť užvateľa';
$lang['expire_user'] = 'Expir&aacute;cia už&iacute;vateľa';
$lang['prompt_action_ordercancelled'] = 'Action to perform when a subscription order is cancelled';
$lang['prompt_action_orderdeleted'] = 'Action to perform when a subscription order is deleted';
$lang['ecommerce_settings'] = 'Ecommerce Settings';
$lang['securefieldmarker'] = 'Označenie zabezpečen&yacute;ch pol&iacute;';
$lang['securefieldcolor'] = 'Farba zabezpečen&yacute;ch pol&iacute;';
$lang['prompt_encrypt'] = 'Uložiť d&aacute;ta v datab&aacute;ze &scaron;ifrovan&eacute;';
$lang['error_notsupported'] = 'The chosen option is not supported given your current configuration';
$lang['audit_user_created'] = 'User automatically created';
$lang['info_auto_create_unknown'] = 'Ak je sa použ&iacute;vateľ autentifikuje pomocou extern&eacute;ho modulu a neexisuje z&aacute;znam v datab&aacute;ze FEU modulu, m&aacute; byť tak&yacute;to z&aacute;znam vytvoren&yacute;?';
$lang['prompt_auto_create_unknown'] = 'Automaticky vytvoriť nezn&aacute;mych použ&iacute;vateľov';
$lang['display_settings'] = 'Nastavenie zobrazovania';
$lang['info_std_auth_settings'] = 'Nasleduj&uacute;ce nastavenia sa ber&uacute; do &uacute;vahu, iba pokiaľ sa použ&iacute;va vstavan&aacute; autentifik&aacute;cia';
$lang['info_support_lostun'] = 'V&yacute;berom nie, zak&aacute;žete použ&iacute;vateľom požiadať o obnovenie straten&yacute;ch prihlasovac&iacute;ch &uacute;dajov, bez ohľadu na ostatn&eacute; nastavenia';
$lang['info_support_lostpw'] = 'V&yacute;berom nie, zak&aacute;žete použ&iacute;vateľom požiadať o obnovenie straten&eacute;ho hesla, bez ohľadu na ostatn&eacute; nastavenia';
$lang['prompt_support_lostun'] = 'Povoliť použ&iacute;vateľom zmenu použ&iacute;vateľsk&eacute;ho mena';
$lang['prompt_support_lostpw'] = 'Povoliť použ&iacute;vateľom vyžiadať zmenu hesla';
$lang['auth_settings'] = 'Nastavenia autentifik&aacute;cie';
$lang['authentication'] = 'Vstavan&aacute; autentifik&aacute;cia';
$lang['auth_builtin'] = '&Scaron;tandardn&aacute; autentifik&aacute;cia';
$lang['auth_module'] = 'Autentifikačn&yacute; Modul';
$lang['info_auth_module'] = 'Modul podporuje použ&iacute;vanie alternat&iacute;vnych autentifikačn&yacute;ch met&oacute;d. Niektor&eacute; funkcie nemusia byť dostupn&eacute;, pokiaľ je použ&iacute;van&aacute; in&aacute; ako &scaron;tandardn&aacute; forma autentifik&aacute;cie.';
$lang['error_user_nonunique_field_value'] = 'The value specified for %s is already in use by another user';
$lang['unique'] = 'Unik&aacute;tny';
$lang['error_nonunique_field_value'] = 'The value specified for %s (%s) is not unique';
$lang['prompt_force_unique'] = 'Vyžadovať aby bola hodnota unik&aacute;tna medzi v&scaron;etk&yacute;mi &uacute;čtami';
$lang['help_returnlast'] = 'Used with the login and logout forms, this parameter if specified will indicate that the user should be returned to the page (by url) that the user was viewing before the action occurred.  This parameter will override the redirect preferences, and the returnto parameter.';
$lang['help_noinline'] = 'Used with one of the forms, this parameter specifies that the forms should not be placed inline, instead the resulting output after form submission will replace the default content block';
$lang['title_reset_session'] = 'Login Session Timeout Warning';
$lang['msg_reset_session'] = 'Your login session is about to expire, please click &quot;&quot;Ok&quot; to confirm your activity on this website.';
$lang['ok'] = 'Ok';
$lang['resetsession_template'] = '&Scaron;abl&oacute;na pre resetovania sedenia';
$lang['info_name'] = 'This is the field name, to be used for addressing in smarty.  It must consist of only alphanumeric characters and underscores.';
$lang['visitors_tab'] = 'N&aacute;v&scaron;tevn&iacute;ci';
$lang['feu_groups_prompt'] = 'Select one or more FEU groups that are allowed to view this page';
$lang['error_mustselect_group'] = 'Skupina mus&iacute; byť vybran&aacute;';
$lang['selectone'] = 'Vybrať';
$lang['start_year'] = 'Počiatočn&yacute; rok';
$lang['end_year'] = 'Konečn&yacute; rok';
$lang['date'] = 'D&aacute;tum';
$lang['prompt_thumbnail_size'] = 'Veľkosť n&aacute;hľadu';
$lang['OnUpdateGroup'] = 'Pri zmene skupiny';
$lang['error_toomanyselected'] = 'Pr&iacute;li&scaron; veľa už&iacute;vateľov zvolen&yacute;ch pre hromadn&uacute; akciu. Maxim&aacute;lny počet je 25';
$lang['confirm_delete_selected'] = 'Ste si ist&yacute;, že chcete odstr&aacute;niť vybran&yacute;ch už&iacute;vateľov';
$lang['delete_selected'] = 'Zmazať vybran&eacute;';
$lang['prompt_randomusername'] = 'Generovať n&aacute;hodne už&iacute;vateľsk&eacute; menu pri vložen&iacute;';
$lang['months'] = 'mesiace';
$lang['prompt_expireage'] = 'Prednastaven&aacute; hodnote pre expir&aacute;ciu';
$lang['notification_settings'] = 'Nastavenia notifik&aacute;cie';
$lang['property_settings'] = 'Nastavenia vlastnosti';
$lang['redirection_settings'] = 'Nastavenia presmerovania';
$lang['general_settings'] = 'Hlavn&eacute; nastavenia';
$lang['session_settings'] = 'Nastavenia Session a Cookie ';
$lang['field_settings'] = 'Nastavenia pol&iacute;';
$lang['error_lostun_nonrequired'] = 'Značka poľa pre zabudnut&eacute; heslo m&ocirc;že byť len pri povinn&yacute;ch poliach';
$lang['prop_textarea_wysiwyg'] = 'Povoliť wysiwyg editore pre textov&eacute; pole';
$lang['info_cookiestoremember'] = '<strong>Pozn&aacute;mka: </strong> Využ&iacute;va funkcie mcrypt, pre &scaron;ifrovaci &uacute;čely, tie nie je možn&eacute; detekovať pri in&scaron;tal&aacute;cii. Pros&iacute;m kontaktujte administr&aacute;tora serveru.';
$lang['editing_user'] = 'Upravovan&yacute; už&iacute;vateľ';
$lang['noinline'] = 'Do not inline forms';
$lang['info_lostun'] = 'Click here if you cannot remember your login details';
$lang['info_forgotpw'] = 'Click here if you cannot remember your password';
$lang['info_logout'] = 'Click here to sign out';
$lang['info_changesettings'] = 'Click here to adjust your password or other information';
$lang['viewuser_template'] = '&Scaron;abl&oacute;na pre v&yacute;pis použ&iacute;vateľa';
$lang['event'] = 'Udalosť';
$lang['feu_event_notification'] = 'FEU Event Notification';
$lang['prompt_notification_address'] = 'Adresa pre zasielanie upozornen&iacute;';
$lang['prompt_notification_template'] = '&Scaron;abl&oacute;na upozornenia';
$lang['prompt_notification_subject'] = 'Predmet upozornenia';
$lang['prompt_notifications'] = 'Upozornenie e-mailom';
$lang['OnLogin'] = 'Pri prihl&aacute;sen&iacute;';
$lang['OnLogout'] = 'Pri odhl&aacute;sen&iacute;';
$lang['OnExpireUser'] = 'Pri expir&aacute;cii sedenia';
$lang['OnCreateUser'] = 'Pri vytvoren&iacute; nov&eacute;ho použ&iacute;vateľa';
$lang['OnDeleteUser'] = 'Pri odstr&aacute;nen&iacute; použ&iacute;vateľa';
$lang['OnUpdateUser'] = 'Pri zmene nastaven&iacute; použ&iacute;vateľa';
$lang['OnCreateGroup'] = 'Pri vytvoren&iacute; novej skupiny';
$lang['OnDeleteGroup'] = 'Pri odtr&aacute;nen&iacute; skupiny';
$lang['lostunconfirm_premsg'] = 'The lost login details functionality has successfully completed.  We have found a unique username that matches the details you entered.';
$lang['your_username_is'] = 'Va&scaron;e už&iacute;vateľske meno je';
$lang['lostunconfirm_postmsg'] = 'We recommend you record this information in a secure, but retrievable location.';
$lang['prompt_after_change_settings'] = 'PageID/Alias str&aacute;nky po zmene nastaven&iacute;';
$lang['prompt_after_verify_code'] = 'PageID/Alias str&aacute;nky po overen&iacute; registr&aacute;cie *';
$lang['lostun_details_template'] = '&Scaron;abl&oacute;na pre obnovu straten&eacute;ho mena';
$lang['lostun_confirm_template'] = '&Scaron;abl&oacute;na pre potvrdenie obnovy straten&eacute;ho mena';
$lang['error_nonuniquematch'] = 'Error: More than one user account matched the properties specified';
$lang['error_cantfinduser'] = 'Chyby: už&iacute;vateľ nen&aacute;jden&yacute;';
$lang['error_groupnotfound'] = 'Chyba: Nebola n&aacute;jden&aacute; skupina s t&yacute;mto menom';
$lang['readonly'] = 'Iba na č&iacute;tanie';
$lang['prompt_usermanipulator'] = 'Trieda User Manipulator Class';
$lang['admin_logout'] = 'Odhl&aacute;senie administr&aacute;torom';
$lang['prompt_loggedinonly'] = 'Uk&aacute;zať iba prihl&aacute;sen&yacute;ch už&iacute;vateľov';
$lang['prompt_logout'] = 'Odhl&aacute;siť tohto už&iacute;vateľa';
$lang['user_properties'] = 'Vlasnosti už&iacute;vateľa';
$lang['userhistory'] = 'Hist&oacute;ria už&iacute;vateľa';
$lang['export'] = 'Exportovať';
$lang['clear'] = 'Vyčistiť';
$lang['prompt_exportuserhistory'] = 'Exportovať hist&oacute;riu do ASCII';
$lang['prompt_clearuserhistory'] = 'Vyčistiť hist&oacute;riu už&iacute;vateľa';
$lang['title_lostusername'] = 'Zabudli ste va&scaron;e prihlasovacie &uacute;daje?';
$lang['title_rssexport'] = 'Exportovať skupiny a ich vlastnost&iacute; do XML';
$lang['title_userhistorymaintenance'] = '&Uacute;držba hist&oacute;rie už&iacute;vateľa';
$lang['yes'] = '&Aacute;no';
$lang['no'] = 'Nie';
$lang['prompt_of'] = 'z';
$lang['date_allrecords'] = '** Bez limitu **';
$lang['date_onehourold'] = '1 hodinu star&eacute;';
$lang['date_sixhourold'] = '6 hod&iacute;n star&eacute;';
$lang['date_twelvehourold'] = '12 hod&iacute;n star&eacute;';
$lang['date_onedayold'] = 'Jeden den star&eacute;';
$lang['date_oneweekold'] = 'Jeden t&yacute;ždeň stare';
$lang['date_twoweeksold'] = 'Dva t&yacute;ždne star&eacute;';
$lang['date_onemonthold'] = 'Jeden mesiac star&eacute;';
$lang['date_threemonthsold'] = 'Tri mesiace star&eacute;';
$lang['date_sixmonthsold'] = '&Scaron;esť mesiacov star&eacute;';
$lang['date_oneyearold'] = 'Jeden rok star&eacute;';
$lang['title_groupsort'] = 'Zoskupovanie a triedenie';
$lang['prompt_recordsfound'] = 'Z&aacute;znamy odpovedaj&uacute;ce podmienke';
$lang['sortorder_username_desc'] = 'Zostupne podľa už&iacute;vateľsk&eacute;ho mena';
$lang['sortorder_username_asc'] = 'Vzostupne podľa už&iacute;vateľsk&eacute;ho mena';
$lang['sortorder_date_desc'] = 'Zostupne podľa d&aacute;tumu';
$lang['sortorder_date_asc'] = 'Vzostupne podľa d&aacute;tumu';
$lang['sortorder_action_desc'] = 'Zostupne podľa typu udalost&iacute;';
$lang['sortorder_action_asc'] = 'Vzostupne podľa typu udalost&iacute;';
$lang['sortorder_ipaddress_desc'] = 'Zostupne podľa IP adresy';
$lang['sortorder_ipaddress_asc'] = 'Vzostupne podľa IP adresy';
$lang['info_nohistorydetected'] = 'Hist&oacute;ria nen&aacute;jden&aacute;';
$lang['reset'] = 'Resetovať';
$lang['prompt_group_ip'] = 'Zoskupiť podľa IP adries';
$lang['prompt_filter_eventtype'] = 'Filtrovanie podľa typov udalost&iacute;';
$lang['prompt_filter_date'] = 'Zobraziť iba akcie, ktor&eacute; su menej ako:';
$lang['prompt_pagelimit'] = 'Str&aacute;nkovac&iacute; limit';
$lang['for'] = 'pre';
$lang['title_userhistory'] = 'Z&aacute;znam už&iacute;vateľov hist&oacute;rie';
$lang['unknown'] = 'Nezn&aacute;mi';
$lang['prompt_ipaddress'] = 'IP adresa';
$lang['prompt_eventtype'] = 'Typ udalosti';
$lang['prompt_date'] = 'D&aacute;tum';
$lang['prompt_return'] = 'N&aacute;vrat';
$lang['import_complete_msg'] = 'Import kompletn&yacute;';
$lang['prompt_linesprocessed'] = 'Spracovan&yacute;ch riadkov';
$lang['prompt_errors'] = 'Chyby';
$lang['prompt_recordsadded'] = 'Pridan&yacute;ch z&aacute;znamov';
$lang['error_nogroupproprelns'] = 'Nen&aacute;jden&eacute; vlastnost&iacute; pre skupinu %s';
$lang['error_noresponsefromserver'] = 'Bez odozvy SMTP servera';
$lang['error_importfilenotfound'] = 'File specified (%s) could not be found';
$lang['error_importfieldvalue'] = 'Chybn&aacute; hodnota v&yacute;berov&eacute;ho poľa alebo viacv&yacute;berov&eacute;ho poľa %s';
$lang['error_importfieldlength'] = 'Pole %s presiahlo maxim&aacute;lny počet znakov';
$lang['error_importusers'] = 'Chyba pri importe  (riadok %s): %s';
$lang['error_propertydefns'] = 'Could not get the property definitions (internal error)';
$lang['error_problemsettinginfo'] = 'Problem setting user info';
$lang['error_importrequiredfield'] = 'Could not find a column to match the required field %s';
$lang['error_nogroupproperties'] = 'Could not find properties for the specified group';
$lang['error_importfileformat'] = 'The file specified for import is not in the correct format';
$lang['error_couldnotopenfile'] = 'Nie je možn&eacute; otvoriť s&uacute;bor';
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
$lang['prompt_importdestgroup'] = 'Importovať už&iacute;vateľov do tejto skupiny';
$lang['prompt_importfilename'] = 'Vložiť CSV s&uacute;bor';
$lang['prompt_importxmlfile'] = 'Vložiť XML s&uacute;bor';
$lang['prompt_exportusers'] = 'Exportovať už&iacute;vateľov';
$lang['prompt_importusers'] = 'Importovať už&iacute;vateľov';
$lang['prompt_clear'] = 'Vyčistiť';
$lang['prompt_image_destination_path'] = 'Cesta k obr&aacute;zku';
$lang['error_missing_upload'] = 'A problem occurred with a missing (but required) upload';
$lang['error_bad_xml'] = 'Could not parse the provided XML file';
$lang['error_notemptygroup'] = 'Cannot delete a group that still has users';
$lang['error_norepeatedlogins'] = 'This user is already logged in';
$lang['error_captchamismatch'] = 'The text from the image was not entered correctly';
$lang['prompt_allow_repeated_logins'] = 'Povoliť viac simult&aacute;lnych prihl&aacute;sen&iacute; použ&iacute;vateľa';
$lang['prompt_allowed_image_extensions'] = 'Typy s&uacute;borov, ktor&eacute; s&uacute; použ&iacute;vateľom dovolen&eacute; nahr&aacute;vať na server';
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
$lang['info_star'] = '* Nasleduj&uacute;ce makra m&ocirc;žu byť použit&eacute; v t&yacute;chto poliach: {$username}.';
$lang['info_admin_password'] = 'Upravte toto pole pre resetovanie hesla už&iacute;vateľa';
$lang['info_admin_repeatpassword'] = 'Upravte toto pole pre resetovanie hesla už&iacute;vateľa';
$lang['error_username_exists'] = 'Už&iacute;vateľ s t&yacute;mto už&iacute;vateľsk&yacute;m menom už existuje';
$lang['nocsvresults'] = 'CSV export nevr&aacute;til žiadne v&yacute;sledky';
$lang['prompt_unfldlen'] = 'Dĺžka poľa pre už&iacute;vateľsk&eacute; meno';
$lang['prompt_pwfldlen'] = 'Dĺžka poľa pre heslo';
$lang['error_invalidpasswordlengths'] = 'Min/Max dĺžka hesla nie je neplatn&aacute;';
$lang['error_invalidusernamelengths'] = 'Min/Max dĺžka už&iacute;vateľsk&eacute;ho mena nie je neplatn&aacute;';
$lang['error_invalidemailaddress'] = 'Neplatn&aacute; e-mailov&aacute; adresa';
$lang['error_noemailaddress'] = 'E-mailov&aacute; adresa pre tento &uacute;čet neboli n&aacute;jden&eacute;';
$lang['error_problemseettinginfo'] = 'Probl&eacute;m s nastaven&iacute;m už&iacute;vateľsk&yacute;ch inform&aacute;cii';
$lang['error_settingproperty'] = 'Probl&eacute;m s nastaven&iacute;m vlasnosti';
$lang['user_added'] = 'Už&iacute;vateľ pridal %s = %s';
$lang['user_deleted'] = 'Už&iacute;vateľ vymazal  uid=%s';
$lang['propertyfilter'] = 'Vlastnosť';
$lang['valueregex'] = 'Hodnota (regul&aacute;rny v&yacute;raz)';
$lang['warning_effectsfieldlength'] = 'Varovanie: Tieto polia ovplynia veľkosť vstupn&yacute;ch pol&iacute; formul&aacute;rov. Zn&iacute;žen&iacute;m tohto č&iacute;sla na existuj&uacute;cej str&aacute;nke nedoporučujeme.';
$lang['confirm_submitprefs'] = 'Ste si ist&yacute;, že chcete zmeniť nastavenia modulu?';
$lang['error_emailalreadyused'] = 'E-mailov&aacute; adresa už je použ&iacute;van&aacute;';
$lang['prompt_usecookiestoremember'] = 'Použiť cookie pre zapam&auml;tanie prihlasovac&iacute;ch &uacute;dajov';
$lang['prompt_cookiename'] = 'Meno cookie';
$lang['prompt_allow_duplicate_emails'] = 'Povoliť duplicitn&eacute; e-maily';
$lang['prompt_username_is_email'] = 'E-mailov&aacute; adresa je už&iacute;vateľsk&eacute; meno ';
$lang['info_cookie_keepalive'] = 'Sk&uacute;&scaron;ať udržať  prihl&aacute;sen&yacute;ch už&iacute;vateľov pomocou cookies <em>(cookie resetuje aktivitu na str&aacute;nkach)</em>';
$lang['info_allow_duplicate_emails'] = '(povoliť viac už&iacute;vateľov s rovnakou e-mailovou adresou)';
$lang['info_username_is_email'] = '(použ&iacute;vateľova e-mailov&aacute; adresa je z&aacute;roveň aj jeho použ&iacute;vateľsk&yacute;m menom -- nepouž&iacute;vajte s nastaven&iacute;m &quot;povoliť duplicitn&eacute; e-maily&quot;!)';
$lang['prompt_allow_duplicate_reminders'] = 'Povoliť duplicitn&eacute; vyžiadanie straten&eacute;ho hesla';
$lang['info_allow_duplicate_reminders'] = '(Povoliť použ&iacute;vateľovi požiadať o obnovenie hesla, pokiaľ nereagoval na predch&aacute;dzaj&uacute;cu žiadosť)';
$lang['prompt_feusers_specific_permissions'] = 'Požiť opr&aacute;vnenia &scaron;pecifick&eacute; pre Front-end User modul?';
$lang['info_feusers_specific_permissions'] = '(Zvyčajne s&uacute; pre FEUsers modul  použ&iacute;van&eacute; rovnak&eacute; opr&aacute;vnenia ako pre administračn&eacute; rozhranie. Pokiaľ vyberete t&uacute;to možnosť, bud&uacute; pre FEUsesrs použit&eacute; vlastn&eacute; nastavenia.)';
$lang['error_missingupload'] = 'Nahrat&yacute; s&uacute;bor nebol n&aacute;jden&yacute; (intern&aacute; chyba)';
$lang['error_problem_upload'] = 'Pri nahr&aacute;van&iacute; s&uacute;boru do&scaron;lo k chybe. Skuste to znovu';
$lang['error_missingusername'] = 'Nevložili ste už&iacute;vateľsk&eacute; meno';
$lang['error_missingemail'] = 'Nevložili ste e-mail';
$lang['error_missingpassword'] = 'Nevložili ste heslo';
$lang['frontenduser_logout'] = 'Frontend User odhl&aacute;senie';
$lang['frontenduser_loggedin'] = 'Frontend User prihl&aacute;senie';
$lang['editprop_infomsg'] = '<font color=&quot;red&quot;><b>UPOZORNENIE</b> zmena st&aacute;vaj&uacute;cich vlasnost&iacute;, ktor&eacute; s&uacute; priraden&eacute; skupin&aacute;m m&ocirc;žu sp&ocirc;sobiť probl&eacute;my <i>(predov&scaron;etk&yacute;m pri skr&aacute;ten&iacute; niektor&yacute;ch pol&iacute;)</i></font>';
$lang['info_smtpvalidate'] = 'T&aacute;to funkcia nepracuje pod windows';
$lang['msg_dontcreateusername'] = 'Nevytv&aacute;rajte vlasnosť pre už&iacute;vateľsk&eacute; meno, pretože to už je s&uacute;časťou modulu FrontEndUsers';
$lang['prompt_exportcsv'] = 'Exportovať už&iacute;vateľov do CSV';
$lang['exportcsv'] = 'Exportortovať';
$lang['importcsv'] = 'Importovať';
$lang['admin'] = 'Administr&aacute;cia';
$lang['editprop'] = 'Upraviť vlasnosť';
$lang['maxlength'] = 'Maxim&aacute;lna dĺžka';
$lang['created'] = 'Vytvoren&eacute;';
$lang['sortby'] = 'Zoradiť podľa';
$lang['sort'] = 'Zoradenie';
$lang['usersingroup'] = 'Už&iacute;vatelia vo vybranej/vybran&yacute;ch skupin&aacute;ch';
$lang['userlimit'] = 'Obmedziť v&yacute;sledky do';
$lang['error_noemailfield'] = 'Nie je možn&eacute; n&aacute;jsť položku e-mail pre tohto už&iacute;vateľa. Kontaktujte administr&aacute;tora webu.';
$lang['prompt_forgotpw_page'] = 'PageID/Alias str&aacute;nky pre formul&aacute;r zmeny hesla';
$lang['prompt_changesettings_page'] = 'PageID/Alias str&aacute;nky pre formul&aacute;r zmeny nastavenia';
$lang['prompt_login_page'] = 'PageID/Alias str&aacute;nky po prihl&aacute;seni *';
$lang['prompt_logout_page'] = 'PageID/Alias str&aacute;nky pre odhl&aacute;senie *';
$lang['sortorder'] = 'Poradie';
$lang['prompt_numresetrecord'] = 'Počet už&iacute;vateloľov, ktor&yacute; moment&aacute;lne žiadaj&uacute; o reset hesla:';
$lang['remove1week'] = 'Odstraniť v&scaron;etky z&aacute;znamy star&scaron;ie ako 1 t&yacute;ždeň';
$lang['remove1month'] = 'Odstr&aacute;niť v&scaron;etky z&aacute;znamy star&scaron;ie ako 1 mesiac';
$lang['removeall'] = 'Odstr&aacute;niť v&scaron;etky z&aacute;znamy';
$lang['areyousure'] = 'Ste si ist&yacute;?';
$lang['error_invalidcode'] = 'Vložen&yacute; bol nespr&aacute;vny k&oacute;d, sk&uacute;ste to znovu';
$lang['error_tempcodenotfound'] = 'Dočasn&yacute; k&oacute;d pre va&scaron;e už&iacute;vateľsk&eacute; meno nebolo n&aacute;jden&eacute; v datab&aacute;ze';
$lang['forgotpassword_verifytemplate'] = '&Scaron;abl&oacute;na formul&aacute;ra pre verifik&aacute;ciu';
$lang['forgotpassword_emailtemplate'] = '&Scaron;abl&oacute;na formul&aacute;ra pre zabudnut&eacute; heslo';
$lang['error_resetalreadysent'] = 'Ďal&scaron;ie in&scaron;trukcie n&aacute;jdete vo svojej e-mailovej schr&aacute;nky.';
$lang['error_dberror'] = 'Problem s datab&aacute;zov';
$lang['message_forgotpwemail'] = 'T&uacute;to spr&aacute;vu ste dostali, pretože niekto požiadal o obnovenie zabudnut&eacute;ho hesla k v&aacute;&scaron;mu &uacute;čtu na na&scaron;ej str&aacute;nke. Pokiaľ je to tak, postupujte podľa niž&scaron;ie uveden&yacute;ch in&scaron;trukci&iacute;. Pokiaľ netu&scaron;&iacute;te o čo ide, tak tento e-mail pros&iacute;m ignorujte.';
$lang['prompt_code'] = 'K&oacute;d';
$lang['message_code'] = 'Nasleduj&uacute;ci k&oacute;d bol n&aacute;hodne vygenerovan&yacute; pre overenie už&iacute;vateľsk&eacute;ho &uacute;čtu. Po kliknut&iacute; na nasleduj&uacute;ci odkaz sa dostane na str&aacute;nku, kde zad&aacute;te tento k&oacute;d.Pole bude predvyplnen&eacute;. Pokiaľ nie, k&oacute;d je tu:';
$lang['prompt_link'] = 'Kliknut&iacute;m na nasleduj&uacute;ci odkaz sa dostanete na str&aacute;nku, kde m&ocirc;žete zadať vy&scaron;ie uveden&yacute; k&oacute;d a obnoviť va&scaron;e heslo';
$lang['lostpassword_emailsubject'] = 'Zabudnut&eacute; heslo';
$lang['error_nomailermodule'] = 'Nen&aacute;jden&yacute; CMSMailer modul';
$lang['info_forgotpwmessagesent'] = 'Na e-mail %s boli zaslan&eacute; in&scaron;trukcie pre obnovenie hesla. Ďakujeme';
$lang['lostpw_message'] = 'Pokiaľ ste zabudli alebo stratili svoje heslo, tak pros&iacute;m vyplňte svoje už&iacute;vateľsk&eacute; meno a e-mailom dostanene in&scaron;trukcie ako pokračovať pri obnoven&iacute; hesla';
$lang['forgotpassword_template'] = '&Scaron;abl&oacute;na pri strate hesla';
$lang['lostusername_template'] = '&Scaron;abl&oacute;na pri strate už&iacute;vateľsk&eacute;ho mena';
$lang['error_propnotfound'] = 'Vlasnosť %s nen&aacute;jden&aacute;';
$lang['propsfound'] = 'Vlasnosť n&aacute;jden&aacute;';
$lang['addprop'] = 'Pridať vlasnosť';
$lang['error_requiredfield'] = 'Povinn&eacute; pole (%s) bolo pr&aacute;zdne';
$lang['info_emptypasswordfield'] = 'Zadajte nov&eacute; heslo';
$lang['error_notloggedin'] = 'Pravdepodobne nie ste prihl&aacute;sen&yacute;';
$lang['user_settings'] = 'Nastavenia';
$lang['user_registration'] = 'Registr&aacute;cia';
$lang['error_accountexpired'] = 'Tento &uacute;čet vypr&scaron;al';
$lang['error_improperemailformat'] = 'Nespr&aacute;vny form&aacute;t e-mailovej adresy';
$lang['error_invalidexpirydate'] = 'Neplatn&yacute; d&aacute;tum expir&aacute;cie';
$lang['error_problemsettingproperty'] = 'Chyba pri nastaven&iacute; vlasnost&iacute; %s pre už&iacute;vateľa $s';
$lang['error_invalidgroupid'] = 'Neplant&eacute; ID skupiny %s';
$lang['hiddenfieldmarker'] = 'Označenia skryt&yacute;ch pol&iacute;';
$lang['hiddenfieldcolor'] = 'Farba skryt&eacute;ho poľa';
$lang['hidden'] = 'Skryt&eacute;';
$lang['error_duplicatename'] = 'Vlastnosť s t&yacute;mto menom už bola nadefinovan&aacute;';
$lang['error_noproperties'] = 'Neboli nadefinovan&eacute; žiadne vlastnosti';
$lang['error_norelations'] = 'Neboli vybran&eacute; vlasnosti pre t&uacute;to skupinu';
$lang['nogroups'] = 'Žiadne skupiny nie s&uacute; nadefinovan&eacute;';
$lang['groupsfound'] = 'Skupiny n&aacute;jden&eacute;';
$lang['error_onegrouprequired'] = 'Je nut&eacute; priradenie aspoň k jednej skupine';
$lang['prompt_requireonegroup'] = 'Vyžadovať priradenie aspoň do jednej skupiny';
$lang['back'] = 'Sp&auml;ť';
$lang['error_missing_required_param'] = '%s je povinn&aacute; položka';
$lang['requiredfieldmarker'] = 'Označiť povinn&eacute; polia s';
$lang['requiredfieldcolor'] = 'Zv&yacute;razniť požadovan&eacute; polia';
$lang['next'] = 'Ďal&scaron;ie';
$lang['error_groupexists'] = 'Skupina s t&yacute;mto n&aacute;zvom už existuje';
$lang['required'] = 'Vyžadovan&aacute;';
$lang['optional'] = 'Voliteľn&aacute;';
$lang['off'] = 'Vypn&uacute;ť';
$lang['size'] = 'Veľkosť';
$lang['sizecomment'] = '<br/>(maxim&aacute;lna rozmer v px pre jeden z rozmerov - v&yacute;&scaron;ka, &scaron;&iacute;rka)';
$lang['length'] = 'Dĺžka';
$lang['lengthcomment'] = '<br>(počet znakov v textovom poli)';
$lang['seloptions'] = 'Položky rozbaľovacieho menu oddelen&eacute; nov&yacute;mi riadkami.';
$lang['radiooptions'] = 'Radiobutton labels, separated by line breaks. Values can be separated from text with a = character. i.e: Female=f';
$lang['prompt'] = 'Verejn&yacute; n&aacute;zov poľa';
$lang['prompt_type'] = 'Typ';
$lang['type'] = 'Typ';
$lang['fieldstatus'] = 'Stav poľa';
$lang['usedinlostun'] = 'P&yacute;tať pri strate<br/>Už&iacute;vateľsk&eacute; meno';
$lang['text'] = 'Text';
$lang['checkbox'] = 'Za&scaron;krt&aacute;vacie pol&iacute;čko';
$lang['multiselect'] = 'Viacv&yacute;berov&eacute; pole';
$lang['radiobuttons'] = 'Skupina radio prvkov';
$lang['image'] = 'Obr&aacute;zok';
$lang['email'] = 'E-mailov&aacute; adresa';
$lang['textarea'] = 'Textov&aacute; oblasť';
$lang['dropdown'] = 'Rozbaľovacie menu';
$lang['msg_currentlyloggedinas'] = 'Vitaj';
$lang['logout'] = 'Odhl&aacute;siť';
$lang['prompt_newgroupname'] = 'Použiť toho meno skupiny';
$lang['prompt_changesettings'] = 'Uprav moje nastavenia';
$lang['error_loginfailed'] = 'Chyba pri prihl&aacute;sen&iacute; - nespr&aacute;vne už&iacute;vateľsk&eacute; meno alebo heslo?';
$lang['login'] = 'Prihl&aacute;siť';
$lang['prompt_signin_button'] = 'N&aacute;zov prihlasovacieho pol&iacute;čka';
$lang['prompt_username'] = 'Už&iacute;vateľsk&eacute; meno';
$lang['prompt_email'] = 'E-mailov&aacute; adresa';
$lang['prompt_password'] = 'Heslo';
$lang['prompt_rememberme'] = 'Zapam&auml;taj si ma na tomto poč&iacute;tači';
$lang['register'] = 'Registrovať';
$lang['forgotpw'] = 'Zabudnut&eacute; heslo?';
$lang['lostusername'] = 'Zabudnut&eacute; prihlasovacie &uacute;daje?';
$lang['defaults'] = 'V&yacute;chodzie';
$lang['template'] = '&Scaron;abl&oacute;na';
$lang['error_usernotfound'] = 'Neboli n&aacute;jden&eacute; žiadne inform&aacute;cie o už&iacute;vateľovi';
$lang['error_usernametaken'] = 'Toto už&iacute;vateľsk&eacute; (%s) už niekdo použ&iacute;va';
$lang['prompt_smtpvalidate'] = 'Použiť SMTP pre valid&aacute;ciu e-mailov&yacute;ch adries?';
$lang['prompt_minpwlen'] = 'Minim&aacute;lna dĺžka hesla';
$lang['prompt_maxpwlen'] = 'Maxim&aacute;lna dĺžka hesla';
$lang['prompt_minunlen'] = 'Minim&aacute;lna dĺžka už&iacute;vateľsk&eacute;ho mena';
$lang['prompt_maxunlen'] = 'Maxim&aacute;lna dĺžka už&iacute;vateľsk&eacute;ho mena';
$lang['prompt_sessiontimeout'] = 'Vypr&scaron;anie sedenia (sekundy)';
$lang['prompt_cookiekeepalive'] = 'Použiť cookies na udržanie prihl&aacute;senia';
$lang['prompt_allowemailreg'] = 'Povoliť e-mailov&uacute; registr&aacute;ciu';
$lang['prompt_dfltgroup'] = 'V&yacute;chodzia skupiny pre nov&eacute;ho už&iacute;vateľa';
$lang['changesettings_template'] = '&Scaron;abl&oacute;na pre zmenu nastaven&iacute;';
$lang['error_passwordmismatch'] = 'Hesla sa nezhoduj&uacute;';
$lang['error_invalidusername'] = 'Nespr&aacute;vne už&iacute;vateľsk&eacute; meno';
$lang['error_invalidpassword'] = 'Nespr&aacute;vne heslo';
$lang['edituser'] = 'Upraviť už&iacute;vateľa';
$lang['valid'] = 'Spr&aacute;vne';
$lang['username'] = 'Už&iacute;vateľsk&eacute; meno';
$lang['status'] = 'Stav';
$lang['error_membergroups'] = 'Tento už&iacute;vateľ nie je priraden&yacute; do žiadnej skupiny';
$lang['error_properties'] = 'Žiadne vlasnosti';
$lang['error_dup_properties'] = 'Pokus o import duplicitn&yacute;ch vlastnost&iacute;';
$lang['value'] = 'Hodnoty';
$lang['groups'] = 'Skupiny';
$lang['properties'] = 'Vlasnosti';
$lang['propname'] = 'N&aacute;zov vlastnosti';
$lang['propvalue'] = 'Hodnota vlasnosti';
$lang['add'] = 'Pridať';
$lang['history'] = 'Hist&oacute;ria';
$lang['edit'] = 'Upraviť';
$lang['expires'] = 'Planosť';
$lang['specify_date'] = '&Scaron;pecifikujte d&aacute;tum';
$lang['12hrs'] = '12 hod&iacute;n';
$lang['24hrs'] = '24 hod&iacute;n';
$lang['48hrs'] = '48 hod&iacute;n';
$lang['1week'] = '1 t&yacute;ždeň';
$lang['2weeks'] = '2 t&yacute;ždne';
$lang['1month'] = '1 mesiac';
$lang['3months'] = '3 mesiace';
$lang['6months'] = '6 mesiacov';
$lang['1year'] = '1 rok';
$lang['never'] = 'Nikdy';
$lang['postinstallmessage'] = 'Modul &uacute;spe&scaron;ne nain&scaron;talovan&yacute;.<br /> Nezabudnite nastaviť pr&aacute;va  &amp;quot;Modify FrontEndUser Properties&amp;quot;.';
$lang['password'] = 'Heslo';
$lang['repeatpassword'] = 'Znova';
$lang['error_groupname_exists'] = 'Skupina s t&yacute;mto n&aacute;zvom už existuje';
$lang['editgroup'] = 'Upraviť skupinu';
$lang['submit'] = 'Odoslať';
$lang['cancel'] = 'Zru&scaron;iť';
$lang['delete'] = 'Odstr&aacute;niť';
$lang['confirm_editgroup'] = 'Ste si ist&yacute;, že toto je spr&aacute;vne nastaveniepre t&uacute;to skupinu?\n Vypnut&iacute;m vlastnost&iacute; sa neodstr&aacute;nia žiadne &uacute;daje vo vlasnostiach už&iacute;vateľa/skupiny.';
$lang['areyousure_deletegroup'] = 'Ste si ist&yacute;, že chcete zmazať t&uacute;to skupinu?';
$lang['confirm_delete_prop'] = 'Naozaj chcete kompletne zmazať t&uacute;to vlasnosť?\nVymažu sa t&yacute;m aj v&scaron;etky hodnoty tejto vlasnosti u už&iacute;vateľoch.';
$lang['error_insufficientparams'] = 'Nedostatočn&eacute; parametre';
$lang['id'] = 'Id';
$lang['name'] = 'Meno';
$lang['error_cantaddprop'] = 'Probl&eacute;m pri prid&aacute;van&iacute; vlasnost&iacute;';
$lang['error_cantaddgroupreln'] = 'Problem adding group relation';
$lang['error_cantaddgroup'] = 'Problem adding group';
$lang['error_cantassignuser'] = 'Problem adding a user to a group';
$lang['error_couldnotdeleteproperty'] = 'Probl&eacute;m s odstr&aacute;nen&iacute;m vlasnost&iacute;';
$lang['error_couldnotfindemail'] = 'Nen&aacute;jden&aacute; e-mailov&aacute; adresa';
$lang['error_destinationnotwritable'] = 'Bez pr&aacute;v na zapisovanie do cieľov&eacute;ho adres&aacute;ra';
$lang['error_invalidparams'] = 'Chybn&eacute; parametre';
$lang['error_nogroups'] = 'Skupina nebola pridan&aacute;';
$lang['applyfilter'] = 'Použiť';
$lang['filter'] = 'Filter';
$lang['userfilter'] = 'Regul&aacute;rny v&yacute;raz pre už&iacute;vateľsk&eacute; meno';
$lang['description'] = 'Popis';
$lang['groupname'] = 'N&aacute;zov skupiny';
$lang['accessdenied'] = 'Pr&iacute;stup zamietnut&yacute;';
$lang['error'] = 'Chyba';
$lang['addgroup'] = 'Pridať skupinu';
$lang['importgroup'] = 'Importovať skupinu';
$lang['adduser'] = 'Pridať už&iacute;vateľa';
$lang['usersfound'] = 'Už&iacute;vatelia splňuj&uacute;ci krit&eacute;ria vyhľad&aacute;vania';
$lang['group'] = 'Skupina';
$lang['selectgroup'] = 'Vybrať skupinu';
$lang['registration_template'] = '&Scaron;abl&oacute;na pre registr&aacute;ciu';
$lang['logout_template'] = '&Scaron;ablon&aacute; pre odhl&aacute;senie';
$lang['login_template'] = '&Scaron;abl&oacute;na pre prihl&aacute;senie';
$lang['preferences'] = 'Predvoľby';
$lang['users'] = 'Už&iacute;vatelia';
$lang['friendlyname'] = 'Frontend User Management (spr&aacute;va už&iacute;vateľov)';
$lang['moddescription'] = 'Allow users to log in to the frontend of your site';
$lang['defaultfrontpage'] = 'V&yacute;chodzia str&aacute;nka';
$lang['lastaccessedpage'] = 'Str&aacute;nka s posledn&yacute;m pr&iacute;stupom';
$lang['otherpage'] = 'In&aacute; str&aacute;nka';
$lang['captcha_title'] = 'Vložte text z obr&aacute;zka';
?>