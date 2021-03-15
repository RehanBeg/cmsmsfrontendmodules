<?php
$lang['info_filter_sortby'] = '<strong>Nota:</strong> Il riordino delle colonne fornir&agrave; un ordinamento ulteriore sugli elementi corrispondenti';
$lang['any'] = 'Qualsiasi';
$lang['sortby_username_asc'] = 'Nome utente (crescente)';
$lang['sortby_username_desc'] = 'Nome utente (decrescente)';
$lang['sortby_create_asc'] = 'Data di creazione (crescente)';
$lang['sortby_create_desc'] = 'Data di creazione (decrescente)';
$lang['sortby_expires_asc'] = 'Data di scadenza (crescente)';
$lang['sortby_expires_desc'] = 'Data di scadenza (decrescente)';
$lang['info_encrypted'] = 'Le propriet&agrave; criptate possono essere visualizzate e modificate esclusivamente dall&#039;utente. Nemmeno l&#039;amministratore pu&ograve; vedere o gestire queste informazioni';
$lang['encrypted'] = 'Criptato';
$lang['info_cookiename'] = 'Se impostato, verr&agrave; abilitata la funzionalit&agrave; &quot;ricordami&quot;.  E&#039; simile alla funzionalit&agrave; &quot;keepalive&quot; per i cookie, ma dura fino a sei giorni.';
$lang['msg_username_readonly'] = 'Non &egrave; permessa la modifica del nome utente per questo account';
$lang['msg_password_readonly'] = 'Non &egrave; permessa la modifica della password per questo account';
$lang['prompt_normallogin'] = 'Accesso Diretto';
$lang['move_up'] = 'Sposta Su';
$lang['move_down'] = 'Sposta Gi&ugrave;';
$lang['title_propmodule'] = 'Questa propriet&agrave; &egrave; generata da un modulo e non pu&ograve; essere modificataThis property is created by a module, and cannot be edited';
$lang['not_available'] = 'Non disponibile';
$lang['prompt_dflt_checked'] = 'Questo campo dovrebbe essere attivo in modo predefinito';
$lang['operation_completed'] = 'Operazione Completa';
$lang['members'] = 'Membri';
$lang['view_filter'] = 'Vedi Filtro';
$lang['data'] = 'Dati';
$lang['applied'] = 'Applicato';
$lang['firstpage'] = '<<';
$lang['prevpage'] = '<';
$lang['nextpage'] = '>';
$lang['lastpage'] = '>>';
$lang['page'] = 'Pagina';
$lang['prompt_allow_changeusername'] = 'Permetti Cambio Nome Utente';
$lang['info_allow_changeusername'] = 'Se abilitato, agli utenti sar&agrave; permesso modificare il proprio nome utente assieme ad altre impostazioni';
$lang['template_saved'] = 'Modello salvato';
$lang['template_resetdefaults'] = 'Modello riportato ai valori predefiniti';
$lang['lbl_settings'] = 'Impostazioni';
$lang['lbl_templates'] = 'Modelli';
$lang['enable_captcha'] = 'Abilita Captcha sul modulo di login';
$lang['info_enable_captcha'] = 'Se l&#039;utente non ha eseguito l&#039;accesso e le preferenze del modulo indicano di visualizzare il modulo di login, quest&#039;opzione controlla se debba essere visualizzata un&#039;autenticazione captcha, se il modulo captcha &egrave; disponibile';
$lang['pagetype_unauthorized'] = 'Non siete autorizzati a vedere questo contenuto';
$lang['info_contentpage_grouplist'] = 'Specifica una lista di gruppi di FEU che possono accedere a questa pagina. Non selezionando alcun gruppo verr&agrave; permessa la visione della pagina a tutti gli utenti di FEU';
$lang['pagetype_settings'] = 'impostazioni Pagine Protette';
$lang['pagetype_groups'] = 'Gruppi Autorizzati';
$lang['info_pagetype_groups'] = 'Selezionate i gruppi che sono autorizzati (in modo predefinito) a visualizzare pagine protette. Un utente editor con permessi &quot;Gestisci tutto il contenuto&quot; pu&ograve; sovrascrivere questa opzione per ogni pagina';
$lang['pagetype_action'] = 'Azione per accesso non sufficiente';
$lang['info_pagetype_action'] = 'Specifica il comportamento da seguire per chi accede a questa pagina senza avere permessi sufficienti. Potete reindirizzare verso una pagina specifica, oppure visualizzare il modulo di accesso';
$lang['showloginform'] = 'Visualizza modulo di accesso';
$lang['redirect'] = 'Reindirizzare verso una Pagina';
$lang['pagetype_redirectto'] = 'Reindirizzare a';
$lang['info_pagetype_redirectto'] = 'Specifica la pagina a cui reindirizzare. Se non ne sceglierete nessuna e l&#039;azione impostata &egrave; &quot;reindirizzare&quot;, verr&agrave; visualizzato un messaggio che  indica che l&#039;utente non ha accesso alla pagina';
$lang['permissions'] = 'Permessi';
$lang['feu_protected_page'] = 'Contenuto Protetto';
$lang['prompt_viewprops'] = 'Selezionate Propriet&agrave; aggiuntive da visualizzare';
$lang['view'] = 'Visualizza';
$lang['info_ignore_userid'] = 'Se selezionato, la procedura di importazione tenter&agrave; di aggiungere utenti indipendentemente dalla colonna userid.  Se un utente con il nome specificato nel file importato esiste gi&agrave;, verr&agrave; generato un errore';
$lang['ignore_userid'] = 'Ignora Colonna UserID durante l&#039;importazione&igrave;';
$lang['export_passhash'] = 'Esporta l&#039;hash della password nel file';
$lang['info_export_passhash'] = 'L&#039;hash della password &egrave; utile solo se la codifica della password sull&#039;host di importazione &egrave; identica a quella dell&#039;host di esportazione';
$lang['error_adjustsalt'] = 'La codifica della password non pu&ograve; essere modificata';
$lang['prompt_pwsalt'] = 'Codifica Password';
$lang['info_pwsalt'] = 'Il modulo FrontEndUsers codifica tutte le password con questa chiave, creata in fase di installazione.  Dopo che gli utenti vengono aggiunti al database, la codifica non pu&ograve; essere modificata. La chiave di codifica potrebbe essere vuota per installazioni pi&ugrave; datate.';
$lang['advanced_settings'] = 'Impostazioni Avanzate';
$lang['info_sessiontimeout'] = 'Specificate il numero di secondi prima che un utente inattivo venga disconnesso dal sito automaticamente';
$lang['prompt_expireusers_interval'] = 'Intervallo Scadenza Utente';
$lang['info_expireusers_interval'] = 'Specificate un valore (in secondi) che indica la frequenza con cui il sistema forzi la disconnessione di utenti con sessioni scadute. E&#039; un&#039;ottimizzazione per ridurre le quesry verso il database. Se lasciato vuoto o impostato a 0, la scadenza verr&agrave; attuata ad ogni richiesta.';
$lang['msg_settingschanged'] = 'Impostazioni aggiornate correttamente';
$lang['forcedlogouttask_desc'] = 'Forza la disconnessioni degli utenti ad intervalli regolari';
$lang['prompt_forcelogout_times'] = 'Tempi per disconnessione forzata';
$lang['info_forcelogout_times'] = 'Elencate una lista di tempi, separati da virgola, nella forma &quot;HH:MM,HH:MM,...&quot; in cui gli utenti verranno forzati alla disconnessione. Nota: questa procedura utilizza il meccanismo pseudocron, pertanto verificate che i tempi inseriti coincidano ragionevolmente con la vostra &quot;granularit&agrave; pseudocron&quot; e che ci siano richieste sufficienti perch&egrave; il pseudocron venga eseguito.';
$lang['prompt_forcelogout_sessionage'] = 'Escludi utenti attivi negli ultimi <em>(minuti)</em>';
$lang['info_forcelogout_sessionage'] = 'Se specificato, tutti gli utenti che sono stati attivi in questo numero di minuti non verranno forzati alla disconnessione';
$lang['areyousure_delete'] = 'Siete certi di volere eliminare l&#039;utente %s';
$lang['error_invalidfileextension'] = 'Il file caricato non corrisponde con i tipi di file consentiti';
$lang['postuninstall'] = 'Tutti i dati associati con il modulo FrontEndUsers saranno cancellati';
$lang['info_ecomm_paidregistration'] = 'Se abilitato, questo modulo aspetta per eventi dalla suite Ecommerce.  La seguente configurazione ha effetto solo se questo &egrave; abilitato.';
$lang['prompt_ecomm_paidregistration'] = 'Pronto per eventi di Order';
$lang['info_paidreg_settings'] = 'La configurazione seguente si applica solo con l&#039;uso di Self Registration e permettendo la registrazione a pagamento';
$lang['none'] = 'Nessuno';
$lang['delete_user'] = 'Utente cancellato';
$lang['expire_user'] = 'Utente scaduto';
$lang['prompt_action_ordercancelled'] = 'Azione da eseguire quando una sottoscrizione &egrave; annullata';
$lang['prompt_action_orderdeleted'] = 'Azione da eseguire quando una sottoscrizione &egrave; cancellata';
$lang['ecommerce_settings'] = 'Configurazioni Ecommerce';
$lang['securefieldmarker'] = 'Marcatore del Secure Field';
$lang['securefieldcolor'] = 'Colore del Secure Field';
$lang['prompt_encrypt'] = 'Immagazzina questo dato criptato nel database';
$lang['error_notsupported'] = 'La opzione scelta non &egrave; supportata dall&#039;attuale configurazione';
$lang['audit_user_created'] = 'Utente automaticamente creato';
$lang['info_auto_create_unknown'] = 'Se un utente &egrave; authenticato da un modulo esterno ma sconosciuto al modulo FrontEndUsers dovrebbe essere creato automticamente un account FEU?';
$lang['prompt_auto_create_unknown'] = 'Automaticamente crea utenti Sconosciuti';
$lang['display_settings'] = 'Configurazioni di visualizzazione';
$lang['info_std_auth_settings'] = 'Le seguenti configurazioni sono solo applicabili con l&#039;uso di &quot;Autenticazioni interne&quot;.';
$lang['info_support_lostun'] = 'Selezionando No disabiliter&agrave; l&#039;abilit&agrave; per uno user di richiedere le informazioni per la perdita del login, a prescindere da altre impostazioni';
$lang['info_support_lostpw'] = 'Selezionando No disabiliter&agrave; l&#039;abilit&agrave; per uno user di reimpostare la password, a prescindere da altre impostazioni';
$lang['prompt_support_lostun'] = 'Permette agli utenti di richiedere il loro username';
$lang['prompt_support_lostpw'] = 'Permette agli utenti di richiedere un cambiamento di password';
$lang['auth_settings'] = 'Configurazioni di autenticazione';
$lang['authentication'] = 'Autenticazioni interne';
$lang['auth_builtin'] = 'Autenticazione standard FEU';
$lang['auth_module'] = 'Autenticazione Modulo/Metodo';
$lang['info_auth_module'] = 'Il modulo FrontendUsers supporta l&#039;utilizzo di metodi di autenticazione alternativi, con possibilit&agrave; diverse.  Alcune funzionalit&agrave; non risponderanno o saranno disabilitate nel caso non si utilizzi il sistema di autenticazione integrato';
$lang['error_user_nonunique_field_value'] = 'Il valore specificato per %s &egrave; gi&agrave; in uso da altro utente';
$lang['unique'] = 'Unico';
$lang['error_nonunique_field_value'] = 'Il valore specificato per %s (%s) non &egrave; unico';
$lang['prompt_force_unique'] = 'Forza i valori di questa propriet&agrave; di essere unica attraverso tutti gli utenti';
$lang['help_returnlast'] = 'Utilizzato con i moduli di login e logout, questo parametro (se specificato) indicher&agrave; che l&#039;utente debba essere reindirizzato verso la pagina (url) che stava visualizzando prima dell&#039;esecuzione dell&#039;azione.  Il parametro sovrascriver&agrave; le impostazioni di reindirizzamento e il parametro returnto.';
$lang['help_noinline'] = 'Utilizzatocon uno dei moduli, questo parametro specifica che i moduli non debbano essere posizionati in linea, ma che l&#039;output risultante dopo l&#039;invio del modulo sostituisca il blocco di contenuto predefinito';
$lang['title_reset_session'] = 'Avviso per sessione di login scaduta';
$lang['msg_reset_session'] = 'Your login session is about to expire, please click &quot;&quot;Ok&quot; to confirm your activity on this website.';
$lang['ok'] = 'OK';
$lang['resetsession_template'] = 'Reimposta Modello Sessione';
$lang['info_name'] = 'Questo &egrave; il nome del campo utilizzato per l&#039;indirizzamento in smarty.  Dev&#039;essere composto solo da caratteri alfanumerici e underscore (&quot;_&quot;).';
$lang['visitors_tab'] = 'Visitatori';
$lang['feu_groups_prompt'] = 'Seleziona uno o pi&ugrave; gruppi FEU a cui &egrave; permesso visualizzare questa pagina';
$lang['error_mustselect_group'] = 'Selezionare almeno un gruppo';
$lang['selectone'] = 'Seleziona uno';
$lang['start_year'] = 'Anno di partenza';
$lang['end_year'] = 'Anno finale';
$lang['date'] = 'Data';
$lang['prompt_thumbnail_size'] = 'Dimensione miniatura';
$lang['OnUpdateGroup'] = 'Alla modifica dei Gruppi Utente';
$lang['error_toomanyselected'] = 'Sono selezionati troppi utenti per operazioni di massa... Riduceteli a 250 o meno';
$lang['confirm_delete_selected'] = 'Siete sicuri di volere eliminare gli utenti selezionati?';
$lang['delete_selected'] = 'Elimina Selezionati';
$lang['prompt_randomusername'] = 'Genera nome utente casuale quando si aggiungono nuovi utenti';
$lang['months'] = 'mesi';
$lang['prompt_expireage'] = 'Periodo di validit&agrave; utente predefinito';
$lang['notification_settings'] = 'Impostazioni di notifica';
$lang['property_settings'] = 'Impostazioni di propriet&agrave;';
$lang['redirection_settings'] = 'Impostazioni di redirezionamento';
$lang['general_settings'] = 'Impostazioni Generali';
$lang['session_settings'] = 'Impostazioni di Sessione e Cookie';
$lang['field_settings'] = 'Impostazioni Campi';
$lang['error_lostun_nonrequired'] = 'Il flag lostusername pu&ograve; essere utilizzato solo su campi obbligatori';
$lang['prop_textarea_wysiwyg'] = 'Permetti l&#039;uso di un editor wysiwyg per quest&#039;area di testo';
$lang['editing_user'] = 'Modifica Utente';
$lang['noinline'] = 'Non allineare Moduli';
$lang['info_lostun'] = 'Cliccate qui se non ricordate i dettagli del vostro login';
$lang['info_forgotpw'] = 'Cliccate qui se non ricordate la vostra password';
$lang['info_logout'] = 'Cliccate qui per disconnettervi';
$lang['info_changesettings'] = 'Cliccate qui per modificare la vostra password o altre informazioni';
$lang['viewuser_template'] = 'Visualizza il Modello Utente';
$lang['event'] = 'Evento';
$lang['feu_event_notification'] = 'Notifica Evento FEU';
$lang['prompt_notification_address'] = 'Indirizzo Email per Notifiche';
$lang['prompt_notification_template'] = 'Modello Email di Notifica';
$lang['prompt_notification_subject'] = 'Oggetto della Email di notifica';
$lang['prompt_notifications'] = 'Notifiche via Email';
$lang['OnLogin'] = 'Al Login';
$lang['OnLogout'] = 'Al Logout';
$lang['OnExpireUser'] = 'Alla Scadenza Sessione';
$lang['OnCreateUser'] = 'Alla Creazione Nuovo Utente';
$lang['OnDeleteUser'] = 'Alla Cancellazione Utente';
$lang['OnUpdateUser'] = 'Alla Modifica Impostazioni Utente';
$lang['OnCreateGroup'] = 'Alla Creazione Gruppi Utente';
$lang['OnDeleteGroup'] = 'Alla Cancellazione Gruppi Utente';
$lang['lostunconfirm_premsg'] = 'La funzionalit&agrave; dettagli di login persi &egrave; stata completata correttamente. Abbiamo trovato un nome utente univoco che corrisponde con le informazioni che avete inserito.';
$lang['your_username_is'] = 'Il vostro nome utente &egrave;';
$lang['lostunconfirm_postmsg'] = 'Vi raccomandiamo di registrare questa informazione in un posto sicuro ma recuperabile.';
$lang['prompt_after_change_settings'] = 'ID/Alias di pagina a cui andare dopo il cambio delle impostazioni';
$lang['prompt_after_verify_code'] = 'ID/Alias di pagina a cui andare dopo la verifica del codice *';
$lang['lostun_details_template'] = 'Modello Dettagli Nome Utente Perso';
$lang['lostun_confirm_template'] = 'Modello Conferma Nome Utente Perso';
$lang['error_nonuniquematch'] = 'Errore: Pi&ugrave; di un account utente coincide con le propriet&agrave; specificate';
$lang['error_cantfinduser'] = 'Errore: Non trovo nessun utente corrispondente';
$lang['error_groupnotfound'] = 'Errore: Non trovo un gruppo con quel nome';
$lang['readonly'] = 'Sola lettura';
$lang['prompt_usermanipulator'] = 'Classe per la manipolazione utenti';
$lang['admin_logout'] = 'Disconnesso dall&#039;amministratore';
$lang['prompt_loggedinonly'] = 'Mostra solo utenti connessi';
$lang['prompt_logout'] = 'Disconnetti questo utente';
$lang['user_properties'] = 'Propriet&agrave; utente';
$lang['userhistory'] = 'Cronologia utente';
$lang['export'] = 'Esporta';
$lang['clear'] = 'Pulisci';
$lang['prompt_exportuserhistory'] = 'Esporta la Cronologia Utente in ASCII che &egrave; almeno';
$lang['prompt_clearuserhistory'] = 'Pulisci i valori della Cronologia Utente che sono almeno';
$lang['title_lostusername'] = 'Valori di Login Dimenticati?';
$lang['title_rssexport'] = 'Esporta definizioni del gruppo (e propriet&agrave;) in XML';
$lang['title_userhistorymaintenance'] = 'Gestione cronologia utente';
$lang['yes'] = 'S&igrave;';
$lang['no'] = 'No';
$lang['prompt_of'] = 'di';
$lang['date_allrecords'] = '** Nessun limite **';
$lang['date_onehourold'] = 'Vecchio di un ora';
$lang['date_sixhourold'] = 'Vecchio di sei ore';
$lang['date_twelvehourold'] = 'Vecchio di dodici ore';
$lang['date_onedayold'] = 'Vecchio di un giorno';
$lang['date_oneweekold'] = 'Vecchio di una settimana';
$lang['date_twoweeksold'] = 'Vecchio di due settimane';
$lang['date_onemonthold'] = 'Vecchio di un mese';
$lang['date_threemonthsold'] = 'Vecchio di tre mesi';
$lang['date_sixmonthsold'] = 'Vecchio di sei mesi';
$lang['date_oneyearold'] = 'Vecchio di un anno';
$lang['title_groupsort'] = 'Raggruppamento e ordinamento';
$lang['prompt_recordsfound'] = 'Valori che corrispondono al criterio';
$lang['sortorder_username_desc'] = 'Nomi Utente discendenti';
$lang['sortorder_username_asc'] = 'Nomi Utente ascendenti';
$lang['sortorder_date_desc'] = 'Data discendente';
$lang['sortorder_date_asc'] = 'Data ascendente';
$lang['sortorder_action_desc'] = 'Tipo evento discendente';
$lang['sortorder_action_asc'] = 'Tipo evento ascendente';
$lang['sortorder_ipaddress_desc'] = 'Indirizzi Ip discendenti';
$lang['sortorder_ipaddress_asc'] = 'Indirizzi Ip ascendenti';
$lang['info_nohistorydetected'] = 'Nessuna cronologia trovata';
$lang['reset'] = 'Azzera';
$lang['prompt_group_ip'] = 'Raggruppa per indirizzo IP';
$lang['prompt_filter_eventtype'] = 'Filtra per tipo di evento';
$lang['prompt_filter_date'] = 'Visualizza solo gli eventi che sono meno di:';
$lang['prompt_pagelimit'] = 'Limite pagina';
$lang['for'] = 'per';
$lang['title_userhistory'] = 'Report cronologia utente';
$lang['unknown'] = 'Sconosciuto';
$lang['prompt_ipaddress'] = 'Indirizzo IP';
$lang['prompt_eventtype'] = 'Tipo evento';
$lang['prompt_date'] = 'Data';
$lang['prompt_return'] = 'Ritorna';
$lang['import_complete_msg'] = 'Operazione di importazione completata';
$lang['prompt_linesprocessed'] = 'Linee processate';
$lang['prompt_errors'] = 'Errori incontrati';
$lang['prompt_recordsadded'] = 'Record aggiunti';
$lang['error_nogroupproprelns'] = 'Non trovo propriet&agrave; per il gruppo %s';
$lang['error_noresponsefromserver'] = 'Non ho ottenuto risposte dal server SMTP';
$lang['error_importfilenotfound'] = 'Il file specificato (%s) non &egrave; stato trovato';
$lang['error_importfieldvalue'] = 'Valore non validi per campi tendina o multiselezione %s';
$lang['error_importfieldlength'] = 'Il campo %s eccede la lunghezza massima';
$lang['error_importusers'] = 'Errore di importazione (linea %s): %s';
$lang['error_propertydefns'] = 'Non riesco ad ottenere le definizioni della propriet&agrave; (errore interno)';
$lang['error_problemsettinginfo'] = 'Problema nell&#039;impostare le informazioni utente';
$lang['error_importrequiredfield'] = 'Non trovo una colonna che coincida con il campo richiesto %s';
$lang['error_nogroupproperties'] = 'Non trovo propriet&agrave; per il gruppo specificato';
$lang['error_importfileformat'] = 'Il file specificato per l&#039;importazione non &egrave; nel formato corretto';
$lang['error_couldnotopenfile'] = 'Non posso aprire il file';
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
$lang['prompt_importdestgroup'] = 'Importa Utenti in questo Gruppo';
$lang['prompt_importfilename'] = 'File CSV di Input';
$lang['prompt_importxmlfile'] = 'File XML di Input';
$lang['prompt_exportusers'] = 'Esporta Utenti';
$lang['prompt_importusers'] = 'Importa Utenti';
$lang['prompt_clear'] = 'Pulisci';
$lang['prompt_image_destination_path'] = 'Percorso Destinazione Immagine';
$lang['error_missing_upload'] = 'Problema occorso con un file caricato mancante (ma necessario)';
$lang['error_bad_xml'] = 'Non riesco ad interpretare il file XML fornito';
$lang['error_notemptygroup'] = 'Non posso eliminare un gruppo che contiene ancora utenti';
$lang['error_norepeatedlogins'] = 'Questo utente &egrave; gi&agrave; collegato';
$lang['error_captchamismatch'] = 'Il testo dall&#039;immagine non &egrave; stato inserito correttamente';
$lang['prompt_allow_repeated_logins'] = 'Permette agli utenti di connettersi pi&ugrave; volte contemporaneamente';
$lang['prompt_allowed_image_extensions'] = 'Estensioni del file immagine di upload permessi all&#039;utente';
$lang['event_help_OnRefreshUser'] = '<h3>OnRefreshUser</h3>
<p>An event generated when the user session is refreshed.</p>
<h4>Parameters:</h4>
<ul>
  <li><em>id</em> - The User id</li>
</ul>';
$lang['event_help_OnDeleteUser'] = '<h3>OnDeleteUser<h3>
<p>Un evento generato quando un utente viene cancellato</p>
<h4>Parametri</h4>
<ul>
<li><em>username</em> - Il nome utente</li>
<li><em>id</em> - L&#039;ID utente</li>
</ul>';
$lang['event_help_OnCreateUser'] = '<h3>OnCreateUser<h3>
<p>Un evento generato quando viene creato un utente</p>
<h4>Parametri</h4>
<ul>
<li><em>name</em> - Il nome utente</li>
<li><em>id</em> - L&#039;ID utente</li>
</ul>';
$lang['event_help_OnUpdateUser'] = '<h3>OnUpdateUser<h3>
<p>Un evento generato quando un utente &egrave; aggiornato (o dallo stesso user o da admin)</p>
<h4>Parametri</h4>
<ul>
<li><em>name</em> - Il nome utente</li>
<li><em>id</em> - L&#039;ID utente</li>
</ul>';
$lang['event_help_OnCreateGroup'] = '<h3>OnCreateGroup<h3>
<p>Un evento generato quando viene creato un gruppo</p>
<h4>Parametri</h4>
<ul>
<li><em>name</em> - Il nome del gruppo</li>
<li><em>description</em> - La descrizione del gruppo</li>
<li><em>id</em> - L&#039;ID del gruppo</li>
</ul>';
$lang['event_help_OnDeleteGroup'] = '<h3>OnDeleteGroup<h3>
<p>Un evento generato quando viene cancellato un gruppo</p>
<h4>Parametri</h4>
<ul>
<li><em>name</em> - Il nome del gruppo</li>
<li><em>id</em> - L&#039;ID del gruppo</li>
</ul>';
$lang['event_help_OnLogin'] = '<h3>OnLogin<h3>
<p>Un evento generato quando un utente effettua l&#039;accesso</p>
<h4>Parametri</h4>
<ul>
<li><em>username</em> - Il nome dell&#039;utente che ha effettuato l&#039;accesso</li>
<li><em>ip</em> - L&#039;indirizzo IP del client</li>
</ul>';
$lang['event_help_OnLogout'] = '<p>Un evento generato quando un utente si disconnette</p>
<h4>Parametri</h4>
<ul>
<li><em>username</em> - Il nome dell&#039;utente disconnesso</li>
<li><em>id</em> - L&#039;ID utente</li>
</ul>';
$lang['event_help_OnExpireUser'] = '<p>Un evento generato quando scade una sessione utente</p>
<h4>Parametri</h4>
<ul>
<li><em>username</em> - Il nome dell&#039;utente scaduto</li>
<li><em>id</em> - L&#039;ID dell&#039;utente scaduto</li>
</ul>';
$lang['event_info_OnLogin'] = 'Un evento generato quando un utente si connette al sistema';
$lang['event_info_OnLogout'] = 'Un evento generato quando un utente si disconnette dal sistema';
$lang['event_info_OnExpireUser'] = 'Un evento generato quando la sessione utente scade';
$lang['event_info_OnCreateUser'] = 'Un evento generato quando viene creato un nuovo utente';
$lang['event_info_OnRefreshUser'] = 'Un evento generato quando viene aggiornata la sessione utente';
$lang['event_info_OnUpdateUser'] = 'Un evento generato quando le informazioni utente sono aggiornate';
$lang['event_info_OnDeleteUser'] = 'Un evento generato quando viene cancellato un account utente';
$lang['event_info_OnCreateGroup'] = 'Un evento generato quando viene creato un nuovo gruppo';
$lang['event_info_OnUpdateGroup'] = 'Un evento generato quando un gruppo &egrave; aggiornato';
$lang['event_info_OnDeleteGroup'] = 'Un evento generato quando viene cancellato un gruppo';
$lang['backend_group'] = 'Gruppo di Backend';
$lang['info_star'] = '* Le seguenti macro possono essere usate in questo campi: {$username},{$group}. Quando usate la macro {$group}, il sistema sostituir&agrave; il nome del primo gruppo utenti a cui appartiene l&#039;utente e redirezioner&agrave; a quella pagina.';
$lang['info_admin_password'] = 'Modifica questo campo per resettare le password utenti';
$lang['info_admin_repeatpassword'] = 'Modifica questo campo per resettare le password utenti';
$lang['error_username_exists'] = 'Esiste gi&agrave; un utente con questo username';
$lang['nocsvresults'] = 'Nessun risultato ricevuto dall&#039;esportazione csv';
$lang['prompt_unfldlen'] = 'Lunghezza del campo nome utente';
$lang['prompt_pwfldlen'] = 'Lunghezza del campo password';
$lang['error_invalidpasswordlengths'] = 'Lunghezza Min/Max della password non valida';
$lang['error_invalidusernamelengths'] = 'Lunghezza Min/Max del nome utente non valida';
$lang['error_invalidemailaddress'] = 'Indirizzo Email non valido';
$lang['error_noemailaddress'] = 'Non trovo un indirizzo email per questo account';
$lang['error_problemseettinginfo'] = 'Problema nell&#039;impostazione delle informazioni utente';
$lang['error_settingproperty'] = 'Problema nell&#039;impostazione delle propriet&agrave;';
$lang['user_added'] = 'Utente aggiunto %s = %s';
$lang['user_deleted'] = 'Utente cancellato uid=%s';
$lang['propertyfilter'] = 'Propriet&agrave;';
$lang['valueregex'] = 'Valore (espressione regolare)';
$lang['warning_effectsfieldlength'] = 'Attenzione: Questi campi influiscono sulla dimensione dei campi di input dei form. Potrebbe non essere consigliabile diminuire questo numero su un sito esistente';
$lang['confirm_submitprefs'] = 'Siete sicuri di volere modificare le preferenze del modulo?';
$lang['error_emailalreadyused'] = 'Indirizzo email gi&agrave; usato';
$lang['prompt_usecookiestoremember'] = 'Usa cookies per ricordare i dettagli del login';
$lang['prompt_cookiename'] = 'Nome del cookie';
$lang['prompt_allow_duplicate_emails'] = 'Permetti email duplicate';
$lang['prompt_username_is_email'] = 'L&#039;indirizzo Email diventa lo username';
$lang['info_cookie_keepalive'] = 'Si cerca di tenere attiva la sessione con l&#039;uso di un cookie <em>(il cookie &egrave; continuamente resettato con l&#039;attivit&agrave; sul sito)</em>';
$lang['info_allow_duplicate_emails'] = '(permetti pi&ugrave; utenti con lo stesso indirizzo email)';
$lang['info_username_is_email'] = '(indirizzo email dell&#039;utente &egrave; il suo nome utente -- non utilizzare questa impostazione con &quot;permetti indirizzi email duplicati&quot;!)';
$lang['prompt_allow_duplicate_reminders'] = 'Permetti richieste multiple per password dimenticate?';
$lang['info_allow_duplicate_reminders'] = '(permette ad un utente di richiedere l&#039;azzeramento della password anche se non ha portato a termine una richiesta precedente)';
$lang['prompt_feusers_specific_permissions'] = 'Usa i permessi specifici del modulo FrontEndUser?';
$lang['info_feusers_specific_permissions'] = '(Normalmente i permessi per FEUsers sono gli stessi degli equivalenti permessi nell&#039;area Amministrazione come Aggiungi Utente, Aggiungi Gruppo, etc. Se selezionate questa opzione ci saranno permessi separati per FEUsers.)';
$lang['error_missingupload'] = 'Non trovo il file di upload (errore interno)';
$lang['error_problem_upload'] = 'Si &egrave; verificato un problema nel file spedito. Si prega di riprovare';
$lang['error_missingusername'] = 'Non avete inserito un nome utente';
$lang['error_missingemail'] = 'Non avete inserito la Vostra email';
$lang['error_missingpassword'] = 'Non avete inserito una password';
$lang['frontenduser_logout'] = 'Logout Utente FrontEnd';
$lang['frontenduser_loggedin'] = 'Login Utente';
$lang['editprop_infomsg'] = '<span style=&quot;color:red&quot;><b>USARE CON CAUTELA</b> quando modificate propriet&agrave; esistenti che sono assegnate a gruppi, potete potenzialmente causare danni e bloccare un sito esistente <i>(specialmente se riducete la lunghezza dei campi, etc)</i></span>';
$lang['info_smtpvalidate'] = 'Questa funzione non funziona su windows';
$lang['msg_dontcreateusername'] = 'Non create una propriet&agrave; per username o password, poich&egrave; queste propriet&agrave; sono gi&agrave; inserite nel modulo FrontEndUsers';
$lang['prompt_exportcsv'] = 'Esporta gli utenti in CSV';
$lang['exportcsv'] = 'Esporta';
$lang['importcsv'] = 'Importa';
$lang['admin'] = 'Amministrazione';
$lang['editprop'] = 'Modifica propriet&agrave;';
$lang['maxlength'] = 'Massima lunghezza';
$lang['created'] = 'Creato';
$lang['sortby'] = 'Ordinato per';
$lang['sort'] = 'Ordinamento';
$lang['usersingroup'] = 'Utenti nel gruppo/i selezionato/i';
$lang['userlimit'] = 'Limita risultati a';
$lang['error_noemailfield'] = 'Non riesco a trovare un campo email per questo utente. Contattare l&#039;amministratore del sistema';
$lang['prompt_forgotpw_page'] = 'ID/Alias della pagina per il modulo di Password dimenticata';
$lang['prompt_changesettings_page'] = 'ID/Alias della pagina per il modulo di Modifica configurazioni';
$lang['prompt_login_page'] = 'ID/Alias della pagina a cui andare dopo il login *';
$lang['prompt_logout_page'] = 'ID/Alias della pagina a cui andare dopo il logout *';
$lang['sortorder'] = 'Ordina';
$lang['prompt_numresetrecord'] = 'Un numero di utenti sono nel mezzo dell&#039;azzeramento della loro password dimenticate. In questo momento sono:';
$lang['remove1week'] = 'Rimuovi tutte le entit&agrave; pi&ugrave; vecchie di una settimana';
$lang['remove1month'] = 'Rimuovi tutte le entit&agrave; pi&ugrave; vecchie di un mese';
$lang['removeall'] = 'Rimuovi tutte le entit&agrave;';
$lang['areyousure'] = 'Siete sicuri?';
$lang['error_invalidcode'] = 'E&#039; stato in serito un codice non valido, provate di nuovo';
$lang['error_tempcodenotfound'] = 'Non &egrave; possibile trovare un codice temporaneo per il vostro ID utente nel database';
$lang['forgotpassword_verifytemplate'] = 'Modello usato per visualizzare il modulo di verifica';
$lang['forgotpassword_emailtemplate'] = 'Modello usato per la email per password dimenticata';
$lang['error_resetalreadysent'] = 'Voi o qualcun&#039;altro ha gi&agrave; richiesto di azzerare la password per questo account. Controllate la vostra email, dovreste avere ricevuto le istruzioni su come azzerare la vostra password';
$lang['error_dberror'] = 'Errore del database';
$lang['message_forgotpwemail'] = 'Avete ricevuto questo messaggio perch&egrave; qualcuno ha segnalato sul nostro sito che avete perso la Vostra password. Se &egrave; corretto, leggete le istruzioni sottostanti. Se non sapete di cosa si tratti, potete tranquillamente cancellare questo messaggio, grazie per il tempo dedicatoci.';
$lang['prompt_code'] = 'Codice';
$lang['message_code'] = 'Il seguente codice &egrave; stato generato in maniera casuale per verificare l&#039;account utente. Quando fate click sul link sottostante verr&agrave; visualizzato un campo in cui inserire questo codice. Normalmente il campo &egrave; pre-compilato per Voi, ma se cos&igrave; non fosse il codice &egrave;:';
$lang['prompt_link'] = 'Seguendo il link seguente verrete portati al sito web dove inserire il codice riportato sopra per azzerare la vostra password:';
$lang['lostpassword_emailsubject'] = 'Password persa';
$lang['error_nomailermodule'] = 'Non trovo il modulo CMSMailer';
$lang['info_forgotpwmessagesent'] = 'Una email &egrave; stata spedita all&#039;indirizzo %s con le istruzioni su come azzerare la vostra password. Grazie';
$lang['lostpw_message'] = 'Avete quindi dimenticato o perso la vostra password. Digitate il vostro nome utente e se verr&agrave; trovato spediremo una email con le istruzioni su come azzerarla';
$lang['forgotpassword_template'] = 'Modello per Password dimenticata';
$lang['lostusername_template'] = 'Modello Perdita Username';
$lang['error_propnotfound'] = 'Propriet&agrave; %s non trovata';
$lang['propsfound'] = 'Propriet&agrave; trovata';
$lang['addprop'] = 'Aggiungi Propriet&agrave;';
$lang['error_requiredfield'] = 'Un campo richiesto (%s) era vuoto';
$lang['info_emptypasswordfield'] = 'Inserire solo per modificare quella precedente';
$lang['error_notloggedin'] = 'Sembra che non abbiate effettuato l&#039;accesso';
$lang['user_settings'] = 'Impostazioni';
$lang['user_registration'] = 'Registrazione';
$lang['error_accountexpired'] = 'Questo account &egrave; scaduto';
$lang['error_improperemailformat'] = 'Formattazione dell&#039;indirizzo di email non valida';
$lang['error_invalidexpirydate'] = 'Data di scadenza non valida';
$lang['error_problemsettingproperty'] = 'Errore nell&#039;impostazione della propriet&agrave; %s per l&#039;utente %s';
$lang['error_invalidgroupid'] = 'ID di gruppo %s non valido';
$lang['hiddenfieldmarker'] = 'Marcatore del campo nascosto';
$lang['hiddenfieldcolor'] = 'Colore del campo nascosto';
$lang['hidden'] = 'Nascosto';
$lang['error_duplicatename'] = 'Una propriet&agrave; con quel nome &egrave; gi&agrave; definita';
$lang['error_noproperties'] = 'Nessuna propriet&agrave; definita';
$lang['error_norelations'] = 'Nessuna propriet&agrave; selezionata per questo gruppo';
$lang['nogroups'] = 'Nessun gruppo definito';
$lang['groupsfound'] = 'Gruppi trovati';
$lang['error_onegrouprequired'] = 'E&#039; necessario essere membro di almeno un gruppo';
$lang['prompt_requireonegroup'] = 'Richiede essere membro di almeno un gruppo';
$lang['back'] = 'Indietro';
$lang['error_missing_required_param'] = '%s &egrave; un campo obbligatorio';
$lang['requiredfieldmarker'] = 'Marca i campi richiesti con';
$lang['requiredfieldcolor'] = 'Evidenziare i campi richiesti in';
$lang['next'] = 'Prossimo';
$lang['error_groupexists'] = 'Un gruppo con quel nome &egrave; gi&agrave; presente';
$lang['required'] = 'Campo obbligatorio';
$lang['optional'] = 'Facoltativo';
$lang['off'] = 'Off';
$lang['size'] = 'Dimensione';
$lang['sizecomment'] = '<br />(Massimo lato di una immagine in pixels)';
$lang['length'] = 'Lunghezza';
$lang['lengthcomment'] = '<br />(caratteri nel campo di testo)';
$lang['seloptions'] = 'Opzioni della tendina, separati da fine linea. Valori possono essere separati dal testo con un =, per esempio Femmina=f';
$lang['radiooptions'] = 'Etichette Radiobutton, separati da fine linea. Valori possono essere separati dal testo con un =, per esempio Femmina=f';
$lang['prompt'] = 'Suggerimento';
$lang['prompt_type'] = 'Tipo';
$lang['type'] = 'Tipo';
$lang['fieldstatus'] = 'Campo Stato';
$lang['usedinlostun'] = 'Chiedi in Perdita<br/>Username';
$lang['text'] = 'Testo';
$lang['checkbox'] = 'Checkbox';
$lang['multiselect'] = 'Lista Multi Select';
$lang['radiobuttons'] = 'Radio Buttons';
$lang['image'] = 'Immagine';
$lang['email'] = 'Indirizzo email';
$lang['textarea'] = 'Area di testo';
$lang['dropdown'] = 'Tendina';
$lang['msg_currentlyloggedinas'] = 'Benvenuto';
$lang['logout'] = 'Uscita';
$lang['prompt_newgroupname'] = 'Usa questo nome di gruppo';
$lang['prompt_changesettings'] = 'Modifica le mie impostazioni';
$lang['error_loginfailed'] = 'Login fallito - nome utente o password sbagliati?';
$lang['login'] = 'Accedi';
$lang['prompt_signin_button'] = 'Etichetta del pulsante di Accesso';
$lang['prompt_username'] = 'Nome utente';
$lang['prompt_email'] = 'Indirizzo Email';
$lang['prompt_password'] = 'Password';
$lang['prompt_rememberme'] = 'Ricordami su questo computer';
$lang['register'] = 'Registrati';
$lang['forgotpw'] = 'Password dimenticata?';
$lang['lostusername'] = 'Dimenticato il Vostro login?';
$lang['defaults'] = 'Valori predefiniti';
$lang['template'] = 'Modello';
$lang['error_usernotfound'] = 'ID utente non trovato';
$lang['error_usernametaken'] = 'Questo username (%s) &egrave; gi&agrave; in uso';
$lang['prompt_smtpvalidate'] = 'Usare SMTP per validare indirizzi email?';
$lang['prompt_minpwlen'] = 'Lunghezza minima della password';
$lang['prompt_maxpwlen'] = 'Lunghezza massima della password';
$lang['prompt_minunlen'] = 'Lunghezza minima del nome utente';
$lang['prompt_maxunlen'] = 'Lunghezza massima del nome utente';
$lang['prompt_sessiontimeout'] = 'Timeout della sessione (secondi)';
$lang['prompt_cookiekeepalive'] = 'Uso cookies per tener vivo il login';
$lang['prompt_allowemailreg'] = 'Permetti registrazione Email';
$lang['prompt_dfltgroup'] = 'Gruppo predefinito per nuovi utenti';
$lang['changesettings_template'] = 'Cambia il Modello delle configurazioni';
$lang['error_passwordmismatch'] = 'Le password non coincidono';
$lang['error_invalidusername'] = 'Nome utente non valido';
$lang['error_invalidpassword'] = 'Password non valida';
$lang['edituser'] = 'Modifica Utente';
$lang['valid'] = 'Valido';
$lang['username'] = 'Nome utente';
$lang['status'] = 'Stato';
$lang['error_membergroups'] = 'Questo utente non &egrave; membro di nessun gruppo';
$lang['error_properties'] = 'Nessuna Propriet&agrave;';
$lang['error_dup_properties'] = 'Tentativo di importare propriet&agrave; duplicate';
$lang['value'] = 'Valore';
$lang['groups'] = 'Gruppi';
$lang['properties'] = 'Propriet&agrave;';
$lang['propname'] = 'Nome della propriet&agrave;';
$lang['propvalue'] = 'Valore della propriet&agrave;';
$lang['add'] = 'Aggiungere';
$lang['history'] = 'Cronologia';
$lang['edit'] = 'Modifica';
$lang['expires'] = 'Scadenze';
$lang['specify_date'] = 'Specificare una data';
$lang['12hrs'] = '12 Ore';
$lang['24hrs'] = '24 Ore';
$lang['48hrs'] = '48 Ore';
$lang['1week'] = '1 Settimana';
$lang['2weeks'] = '2 Settimane';
$lang['1month'] = '1 Mese';
$lang['3months'] = '3 Mesi';
$lang['6months'] = '6 Mesi';
$lang['1year'] = '1 Anno';
$lang['never'] = 'Mai';
$lang['postinstallmessage'] = 'Modulo installato.<br />Accertarsi di configurare i permessi per &quot;Modify FrontEndUser Properties permission&quot;. Consigliamo inoltre di installare il modulo Captcha poich&egrave; pu&ograve; essere richiesto la validazione di una immagine. Questo &egrave; inteso per prevenire attacchi brute force.  <strong>Nota:</strong> il parametro nocaptcha pu&ograve; essere usato per disabilitare questa funzionalit&agrave; anche se il modulo &egrave; installato.';
$lang['password'] = 'Password';
$lang['repeatpassword'] = 'di nuovo';
$lang['error_groupname_exists'] = 'Un gruppo con quel nome &egrave; gi&agrave; presente';
$lang['editgroup'] = 'Modifica Gruppo';
$lang['submit'] = 'Invia';
$lang['cancel'] = 'Annulla';
$lang['delete'] = 'Cancella';
$lang['confirm_editgroup'] = 'Siete sicuri che queste siano le impostazioni corrette per questo gruppo?\nDisattivando una propriet&agrave; non si cancellano i dati nella tabella propriet&agrave; per quel gruppo/utente. Saranno solo non disponibili.';
$lang['areyousure_deletegroup'] = 'Siete sicuri di volere cancellare questo gruppo?';
$lang['confirm_delete_prop'] = 'Siete sicuro di volere cancellare completamente questa propriet&agrave;?\nFacendolo saranno cancellati tutti i dati degli utenti per questa propriet&agrave;.';
$lang['error_insufficientparams'] = 'Parametri insufficienti';
$lang['id'] = 'ID';
$lang['name'] = 'Nome';
$lang['error_cantaddprop'] = 'Problema nell&#039;aggiungere propriet&agrave;';
$lang['error_cantaddgroupreln'] = 'Problema nell&#039;aggiungere relazione di gruppo';
$lang['error_cantaddgroup'] = 'Problema nell&#039;aggiungere il gruppo';
$lang['error_cantassignuser'] = 'Problema nell&#039;aggiungere un utente al gruppo';
$lang['error_couldnotdeleteproperty'] = 'Problema nella cancellazione di una propriet&agrave;';
$lang['error_couldnotfindemail'] = 'Non trovo un indirizzo email';
$lang['error_destinationnotwritable'] = 'Nessun permesso di scrittura nella cartella di destinazione';
$lang['error_invalidparams'] = 'Parametri non validi';
$lang['error_nogroups'] = 'Non trovo gruppi';
$lang['applyfilter'] = 'Applica';
$lang['filter'] = 'Filtro';
$lang['userfilter'] = 'Espressione regolare di Username';
$lang['description'] = 'Descrizione';
$lang['groupname'] = 'Nome gruppo';
$lang['accessdenied'] = 'Accesso negato';
$lang['error'] = 'Errore';
$lang['addgroup'] = 'Aggiungere gruppo';
$lang['importgroup'] = 'Importa Gruppo';
$lang['adduser'] = 'Aggiungere utente';
$lang['usersfound'] = 'Trovati utenti che soddisfano il criterio';
$lang['group'] = 'Gruppo';
$lang['selectgroup'] = 'Seleziona Gruppo';
$lang['registration_template'] = 'Modello di registrazione';
$lang['logout_template'] = 'Modello di logout';
$lang['login_template'] = 'Modello di login';
$lang['preferences'] = 'Preferenze';
$lang['users'] = 'Utenti';
$lang['friendlyname'] = 'Gestione utenti di Frontend';
$lang['moddescription'] = 'Permetti agli utenti di effettuare l&#039;accesso dall&#039;interfaccia del sito';
$lang['defaultfrontpage'] = 'Pagina di accesso predefinita';
$lang['lastaccessedpage'] = 'Ultima pagina acceduta';
$lang['otherpage'] = 'Altra pagina:';
$lang['captcha_title'] = 'Inserite il testo visualizzato nell&#039;immagine';
$lang['utma'] = '156861353.838811379.1385129143.1389198872.1389707124.4';
$lang['utmz'] = '156861353.1389198872.3.3.utmcsr=solgea.net|utmccn=(referral)|utmcmd=referral|utmcct=/cmsms/admin/index.php';
$lang['utmb'] = '156861353';
$lang['utmc'] = '156861353';
?>