<?php
/**
* Raidtracker language file - FR
*  
* Powered by bbdkp © 2009 The bbDkp Project Team
* If you use this software and find it to be useful, we ask that you
* retain the copyright notice below.  While not required for free use,
* it will help build interest in the bbDkp project.
* 
* @package bbDkp
* @copyright (c) 2009 bbdkp http://code.google.com/p/bbdkp/
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* $Id$
* 
*  
**/


/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}


/**
* DO NOT CHANGE
*/
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(

/*
 * Raidtracker Import 
 */
'RT' => 'Importation RaidTracker ',
'IMPORT_RT_DATA' => 'Importation DKP XML',
'RT_DISABLED' => 'Raidtracker est désactivé', 
'RT_PHP5'	=> 'PHP 5 est requis pour RaidTracker.',
'RT_ERR_DUPLICATE' => 'Erreur. Insertion d\'un Raid doublon. Vous ne pouvez inserer des Raids qui diffèrent de moins de 30 minutes du raid précédent. ', 
'RT_ERR_NOATTENDEES' => 'Erreur. pas de participants. ', 
'RT_ERR_NORAIDNOTE' => 'Erreur. pas de Note raid trouvée. ',
'RT_ERR_NOBOSSKILL' => 'Erreur. pas de balise boss trouvée. ',
'RT_ERR_NOEVENT' => 'erreur. pas de Trgger Evènement trouvé pour "%s". <br />Veuillez créer un déclincheur d\'évènement pour lier "%s" à un Evènement existant et ensuite importez votre Raid. ',
'RT_ERR_NOEVENTSETUP' => 'Erreur. pas d\évènements trouvés en bbDKP. Raidtracker s\'arrètera ici. Controlez vos évènements et leurs déclincheurs. ',
'RT_ERR_NODKPSYSSETUP' => 'Erreur. pas de systeme DKP trouvés. Raidtracker s\'arrètera ici',

// parse screen
'RT_STEP1_PAGETITLE' => 'Parseur de Log RaidTracker ',
'RT_STEP1_DESCRIPTION' => 'Mettez le format d\exportation ML_Raidtracker (http://www.mlmods.net) à "MLDdkp 1.1 /EQdkp"(/rt o dans WoW).<br /> Pour exporter, faire /rt, puis clique droite, choisir "show Dkp string", et copiez cet XML ci-dessous. 
<br /> cliquez "Parser le Log" pour importer. Les raids importés peuvent-être consultés du tab "importation". ',
'RT_STEP1_INVALIDSTRING_TITLE' => 'XML DKP invalide',
'RT_STEP1_INVALIDSTRING_MSG' => 'le XML DKP est invalide.',
'RT_STEP1_NODATA' => 'Pas de XML DKP trouvé', 
'RT_STEP1_BUTTON_PARSELOG' => 'Parser le Log',
'RT_STEP1_EDIT' => 'Edition',
'RT_STEP1_DELETE' => 'Supprimer' , 
'RT_STEP1_ZONE' => 'Zone', 
'RT_STEP1_START' => 'Départ', 
'RT_STEP1_END'	=> 'Fin', 
'RT_STEP1_DONE' => 'Log importé vers les tables temporaires ',
'RT_STEP1_FOUNDRAIDS'	=> 'Trouvé %d Logs de Raid prêtes à transferer', 
'RT_STEP1_DELETEPARSE'	=> 'Supprimé Raid %s des tables temporaires', 
'RT_STEP1_DELETCONFIRM'	=> 'Êtes-vous sûr de vouloir supprimer le Raid %s des tables temporaires ?', 

// bbDKP import screen
'RT_STEP2_PAGETITLE' => 'bbDKP Import',
'RT_STEP2_DKPPOOL' => 'Groupe DKP',
'RT_STEP2_EVENT' => 'Evènement',
'RT_STEP2_RAIDINFO' => 'Information du Raid',
'RT_STEP2_RAIDSTART' => 'Départ Raid:',
'RT_STEP2_RAIDEND' => 'Fin Raid:',
'RT_STEP2_REALM' => 'Royaume:',
'RT_STEP2_ZONE' => 'Zone:',
'RT_DIFFICULTYNORMAL' => 'Normal', 
'RT_DIFFICULTYHEROIC' => 'Heroique', 
'DIFFICULTY' => 'Difficulté', 
'RT_STEP2_DKPVALUE' => 'Valeur DKP:',
'RT_STEP2_DKPVALUE_EXPLAIN' => 'Cette valeur sera comptabilisée comme un Gain pour chaque joueur.',
'RT_STEP2_ERR_RAIDID'	=> 'Erreur. Raid ID invalide. chargement interrompu.', 

//js alerts
'ALERT_AJAX' => 'Il y a eu un problême lors de la tentative d\'utiliser XMLHTTP', 
'ALERT_OLDBROWSER' => 'Votre Browser ne supporte pas le protocole HTTP Request, veuillez le mettre à jour.', 

// Import Screen
'RT_STEP2_RAIDSDROPSDETAILS' => 'Details des drops',
'RT_STEP2_COMMENT' => 'Commentaires',
'RT_STEP2_BOSS' => 'Nom du Boss: ',
'RT_STEP2_KILLTIME' => 'Moment du Bosskill:',
'RT_STEP2_DKPCOST' => 'Côut DKP:',
'RT_STEP2_ATTENDEES' => 'Participants',
'RT_STEP2_ITEMNAME' => 'Nom de l\'objet:',
'RT_STEP2_ITEMID' => 'ID objet:',
'RT_STEP2_LOOTER' => 'Récepteur:',
'RT_STEP2_ITEMDKPVALUE' => 'Veleur DKP:',
'RT_STEP2_DKPVALUETIP' => 'DKP Zerobase : ajouter la fraction Valeur/nombre de participants à chaque participant. ',
'RT_STEP2_INSERTRAIDS' => 'Insertion de Raid',
'RT_STEP2_TIMEBONUSCALCULATION' => 'Calcul de Bonus par Temps passé',
'RT_STEP2_TIMEBONUSCALCULATION_EXPLAIN' => 'Ces Bonus seront comptabilisés comme un Gain.', 
'RT_STEP2_ID' => 'ID',
'RT_STEP2_NAME' => 'Joueur',
'RT_STEP2_JOINTIME' => 'Départ',
'RT_STEP2_LEAVETIME' => 'Fin',
'RT_STEP2_DURATION' => 'Durée',
'RT_STEP2_BASIS' => 'Base',
'RT_STEP2_TIMEBONUS' => 'Bonus Temps',

// TRIGGER-ERROR RESULTS
'RT_STEP3_PAGETITLE' => 'RaidTracker Import',
'RT_STEP3_TITLE' => 'log des Actions<br/>',
'RT_STEP3_ALREADYEXIST' => '%s (%s, %s DKP) était déjà ajouté, passer outre<br/>',
'RT_STEP3_EMPTYRAIDNOTE' => '%s (%s, %s DKP) n\'a pas de note Raid, passer outre<br/>',
'RT_STEP3_RAIDADDED' => '%s (%s, %s DKP) a été ajouté<br/>',
'RT_STEP3_ADJADDED' => 'Un ajustement de %s DKP est ajouté au joueur %s<br/>',
'RT_STEP3_MEMBERADDED' => '%s (race: %s, classe: %s, niveau: %s, grade: %s) a été ajouté aux membres<br/>',
'RT_STEP3_MEMBERDKPADDED' => '%s a été ajouté aux comptes DKP<br/>',
'RT_STEP3_MEMBERUPDATED' => '%s (race: %s, classe: %s, Niveau: %s, Grade: %s) a été mis à jour à : (race: %s, classe: %s, niveau: %s, grade: %s)<br/>',
'RT_STEP3_MEMBERDKPUPDATED' => '%s dkp a été actualisé<br/>',
'RT_STEP3_MEMBERLEVELUPDATED' => 'Ce membre a gagné de niveaux, de %s à %s<br/>',
'RT_STEP3_ATTENDEESADDED' => '%s participants ajoutés<br/>',
'RT_STEP3_LOOTADDED' => '%s (%s DKP) ajouté à %s<br/>',


/**
 * Log Actions
 */
'ACTION_RT_CONFIG_UPDATED' => '%s a changé les réglages Raidtracker',

/**
 * configuration 
 */
'RT_SETTINGS_UPDATE_SUCCESS' => 'réglages Raidtracker mis à jour par %s.',

'RT_MIN_QUALITY_EXPLAIN' => 'Niveau minimum de qualité des objets.',
'RT_ADD_LOOT_DKP_EXPLAIN' => 'DKP Base Zero : la fraction (Coût objet/#participants) est distribué comme montant de gagne aux joueurs participants. (ex. 120 dkp / 10 participants = 12 DKP/participant)',
'RT_IGNORED_LOOTER_EXPLAIN' => 'Le nom du joueur à ignorer dans le XML.',
'RT_EVENT_TRIGGER_EXPLAIN' => 'Les Déclencheurs de Zone lient les Zones du XML aux événements bbDKP.',

'RT_ATTENDANCE_FILTER_EXPLAIN' => 'Règle le niveau de participation. soit tous les joueurs rencontrés dans l\'XML soit seulement ceux qui ont été présents aux bosskill.',
'RT_DEFAULT_DKP_EXPLAIN' => 'Le côut standart des objets pour lesquels aucune valeur n\'a été renseignée dans l\'XML.',
'RT_STARTING_DKP_EXPLAIN' => 'à la création d\'un nouveau membre, si cette valeur est &gt; 0, ceci ira ajouter un ajustement aux membre comme DKP de départ.',
'RT_START_RAID_DKP_EXPLAIN' => 'Points de départ standard.',
'RT_ALTREPLACE_EXPLAIN' => 'Activer le listing de remplacement noms de Alts par Noms de Main. ', 

'RT_MIN_QUALITY' => 'Qualité minimum',
'RT_ADD_LOOT_DKP' => 'Calculer Base zéro DKP',
'RT_IGNORED_LOOTER' => 'Joueur ignoré',
'RT_EVENT_TRIGGER' => 'Cocher pour Déclencheurs d\'évenements',
'RT_DEFAULT_RANK' => 'Grade Défaut',
'RT_ATTENDANCE_FILTER' => 'Filtre d\'e présence',
'RT_DEFAULT_DKP' => 'Coût DKP par défaut ',
'RT_STARTING_DKP' => 'DKP de démarrage',
'RT_CREATE_START_RAID' => 'Create Start Raid',
'RT_START_RAID_DKP' => 'Start Raid DKP',
'RT_ALTREPLACE' => 'Replacer noms de Alt',
'RT_ALTREPLACE_WARNING' => 'Replacer nes noms Alts du XML par les noms de Main',
'RT_DKPHOUR' => 'DKP par heure passée', 
'RT_DKPHOUR_EXPLAIN' => 'assignera x DKP comme ajustement pour chaque heure présente dans Raid (arrondie, soit 1h45m devient 2h, 2h13m devient 2h)',

'RT_BOSSRAID' => 'niveau de logging Raid ',
'RT_BOSSRAID_EXPLAIN' => 'Enregistrer 1 Raid par Bosskill ou bien Raid Global par fichier XML', 
'RT_BOSSRAID_YES' => 'Par Bosskill',
'RT_BOSSRAID_NO' => '1 Raid global',

'VLOG_RT_CONFIG_UPDATED' => '%s a mis à jour le config RaidTracker.',
'RT_ADMINMENU_CONFIG' => 'Configurer',
'RT_ADMINMENU_SETTINGS' => 'Réglages',

'RT_IQ_POOR' => 'Médiocre',
'RT_IQ_COMMON' => 'Classique',
'RT_IQ_UNCOMMON' => 'Bonne',
'RT_IQ_RARE' => 'Rare',
'RT_IQ_EPIC' => 'Epique',
'RT_IQ_LEGENDARY' => 'Légendaire',

/**
 * Attendance Filter
 */
'RT_AF_NONE' => 'Membres présent dans Raid',
'RT_AF_BOSS_KILL' => 'Members present au Bosskill',

/**
 * Always Add these Items
 */

'RT_ADDITEM_SAMPLE_XML'	=> '&lt;AddItems&gt;<br />
&nbsp;&nbsp;&nbsp;&nbsp;&lt;AddItem&gt;18562&lt;/AddItem&gt;<br />
&nbsp;&nbsp;&nbsp;&nbsp;&lt;AddItem&gt;25641&lt;/AddItem&gt;<br />
&lt;/AddItems&gt;', 

'RT_ITEM_CONFIRM_DELETE' => 'Êtes-vous sûr de vouloir supprimer les objets suivants?',
'RT_ITEM_NOT_SELECTED' => 'Pas d\'objets selectionnés.',
'RT_ITEM_DUPLICATE' => 'Objet %s existe déjà.',
'RT_ITEM_SUCCESS_ADD' => 'Objet %s ajouté.',
'RT_ITEM_FAIL_ADD' => 'Objet %s pas ajouté.',
'RT_ITEM_SUCCESS_UPDATE' => 'Objet mis à jour.',
'RT_ITEM_SUCCESS_DELETE' => 'Objet %s supprimé.',

'RT_HELP_ADD_ITEMS' => 'Ces Objets seront toujours ajoutés quelque soit leur présence dans la liste des objets ignorés, leur achat par un joueur ignoré, ou si leur niveau de qualité serait au dessous du niveau minimum',
'RT_HELP_ADD_ITEMS_WOW_ID' => 'Entrez le ID de l\'objet à ajouter toujours. l\'ID est celui de Wowhead.',
'RT_ITEM_WOW_ID' => 'ID objet WoW ',

'RT_ADMINMENU_ADD_ITEMS' => 'Objets permanents',
'RT_ADMINMENU_ADD_ITEMS_ADD' => 'Ajouter objets',
'RT_ADMINMENU_ADD_ITEMS_LIST' => 'Liste Objets',
'RT_ADMINMENU_ADD_ITEMS_EXPORT' => 'Exporter Objets',
'RT_ADMINMENU_ADD_ITEMS_IMPORT' => 'Importer Objets',

'RT_HELP_IMPORT_ITEM' => 'coller l\' XML ci-dessous our importer les objets.',
'RT_HELP_IMPORT_FORMAT' => 'l\'importation est indépendante de l\'usage de majuscules/minuscules et doit être dans la forme XML.',

'RT_INVALID_XMLIMPORT' => 'XML invalide ou pas donné',  

'RT_HELP_ITEM_EXPORT' => 'Copie l\'XML ci-dessous et colle le dans un programme de traitement de texte.',

/**
 * Always Ignore Items
 */
'RT_HELP_IGNORE_ITEMS' => 'Indique une liste d\'objets qui seront toujours ignorés.',
'RT_HELP_IGNORE_ITEMS_WOW_ID' => 'Entre le ID à ignorer en parmanence. Cet ID est l\'identifiant interne en WoW.',

'RT_ADMINMENU_IGNORE_ITEMS' => 'Objets ignorés',
'RT_ADMINMENU_IGNORE_ITEMS_ADD' => 'Ajouter',
'RT_ADMINMENU_IGNORE_ITEMS_LIST' => 'Liste',
'RT_ADMINMENU_IGNORE_ITEMS_EXPORT' => 'Exporter',
'RT_ADMINMENU_IGNORE_ITEMS_IMPORT' => 'Importer',

'RT_IGNORE_ITEMS_IMPORTSAMPLE' => '&lt;IgnoreItems&gt;<br />
&nbsp;&nbsp;&lt;IgnoreItem&gt;<br />
&nbsp;&nbsp;&nbsp;&nbsp;18562<br />
&nbsp;&nbsp;&lt;/IgnoreItem&gt;<br />
&nbsp;&nbsp;&lt;IgnoreItem&gt;<br />
&nbsp;&nbsp;&nbsp;&nbsp;20725<br />
&nbsp;&nbsp;&lt;/IgnoreItem&gt;<br />
&lt;/IgnoreItems&gt;', 

'RT_HELP_EXPORT' => 'Copie l\'XML ci-dessous et colle le dans un programme de traitement de texte.',


/**
 * Alts/alias/twinks
 */

'RT_ADMINMENU_ALIASES' => 'Alts',
'RT_ADMINMENU_ALIASES_ADD' => 'Ajouter Alt',
'RT_ADMINMENU_ALIASES_LIST' => 'Liste Alts',
'RT_ADMINMENU_ALIASES_EXPORT' => 'Exporter Alts',
'RT_ADMINMENU_ALIASES_IMPORT' => 'Importer Alts',
'RT_ALIAS' => 'Alt',
'RT_MEMBER' => 'Caractère Main ',
'RT_ALIASES' => 'Alts',


'RT_ALIAS_IMPORTSAMPLE'	=> '&lt;PlayerAlts&gt;<br />
&nbsp;&nbsp;&lt;Alt&gt;<br />
&nbsp;&nbsp;&nbsp;&nbsp;&lt;alias&gt;Twinkone&lt;/alias&gt;<br />
&nbsp;&nbsp;&nbsp;&nbsp;&lt;member&gt;Maintoon&lt;/member&gt;<br />
&nbsp;&nbsp;&lt;/Alt&gt;<br />
&nbsp;&nbsp;&lt;Alt&gt;<br />
&nbsp;&nbsp;&nbsp;&nbsp;&lt;alias&gt;Twinktwo&lt;/alias&gt;<br />
&nbsp;&nbsp;&nbsp;&nbsp;&lt;member&gt;Maintoon&lt;/member&gt;<br />
&nbsp;&nbsp;&lt;/Alt&gt;<br />
&lt;/PlayerAlts&gt;', 

'RT_IMPORT' => 'Import',
'RT_HELP_IMPORT' => 'Colle l\'XML ci-dessous pour importer vos Alts.',

'RT_HELP_ALIAS' => 'Utilisez le systeme de remplacement des Alts si un joueur amène un charctère Alt mais vous voulez tenir des comptes DKP seulement pour les Caractères principales.',
'RT_HELP_ALIAS_NAME' => 'Si ce nom est rencontré, il sera remplacé',
'RT_HELP_ALIAS_MEMBER' => 'Selectionne le membre récepteur de points venant du Alt.',
'RT_HELP_ALIAS_EXPORT' => 'Copie l\'XML ci-dessous et colle le dans un programme de traitement de texte.',
'RT_HELP_ALIAS_IMPORT' => 'Colle l\'XML ci-dessous pour importer vos Alts.',
'RT_HELP_ALIAS_IMPORT_FORMAT' => 'l\'importation est indépendante de l\'usage de majuscules/minuscules et doit être dans la forme XML.',

'RT_ALIAS_DUPLICATE' => 'Doublon trouvé : nom de Alt  %s pas appliqué au membre %s',
'RT_ADD_ALIAS_SUCCESS' => 'Alt %s ajouté au membre %s.',
'RT_ALIAS_UPDATE_SUCCESS' => 'Alt %s mis à jour pour membre %s. ',
'RT_NO_ALIAS_SELECTED' => 'Pas de Alt selectionné.',
'RT_CONFIRM_DELETE_ALIAS' => 'Êtes-vous sûr de voiloir supprimer les Alts suivants ?',
'RT_ALIAS_DELETED' => 'Alt %s supprimé de %s.',
'RT_ALIAS_IMPORT_MISSING_MEMBER' => 'pas créé Alt %s pour %s, car membre n\'existe pas.',

'ACTION_RT_ALIAS_ADDED' => ' Alt ajouté',
'ACTION_RT_ALIAS_UPDATED' => ' Alt mis à jour',
'ACTION_RT_ALIAS_DELETED' => ' Alt supprimé',
'RT_ALIAS_NAME_BEFORE' => 'Alt avant',
'RT_ALIAS_NAME_AFTER' => 'Alt après',

'VLOG_RT_ALIAS_ADDED' => '%s ajouté Alt %s en Raidtracker pour membre %s.',
'VLOG_RT_ALIAS_UPDATED' => '%s a mis à jour un Alt %s en Raidtracker pour membre %s.',
'VLOG_RT_ALIAS_DELETED' => '%s a supprimé un Alt %s en RaidTracker du membre %s.',

'RT_LABEL_ALIAS_NAME' => 'Nom de Alt',


/*
 * Events
 * 
 */
'EVENT'	=> 'Nom d\'évènement', 
'RT_TRIGGER' => 'Nom de déclencheur',
'RT_ADMINMENU_EVENT_TRIGGERS' => 'Evénements',
'RT_ADMINMENU_EVENT_TRIGGERS_ADD' => 'Ajouter',
'RT_ADMINMENU_EVENT_TRIGGERS_LIST' => 'Liste',
'RT_ADMINMENU_EVENT_TRIGGERS_EXPORT' => 'Exporter',
'RT_ADMINMENU_EVENT_TRIGGERS_IMPORT' => 'Importer',

'RT_HELP_EVENT_TRIGGERS_IMPORT_FORMAT' => 'l\'importation est indépendante de l\'usage de majuscules/minuscules et doit être dans la forme XML.',
'RT_EVENT_TRIGGERS_IMPORTSAMPLE'	=> '&lt;EventTriggers&gt;<br />
	&nbsp;&nbsp;&lt;EventTrigger&gt;<br />
	&nbsp;&nbsp;&nbsp;&nbsp;&lt;trigger&gt;Kazzak&lt;/trigger&gt;<br />
	&nbsp;&nbsp;&nbsp;&nbsp;&lt;resultpool&gt;Classic&lt;/resultpool&gt;<br />
	&nbsp;&nbsp;&nbsp;&nbsp;&lt;resultevent&gt;World Bosses&lt;/resultevent&gt;<br />
	&nbsp;&nbsp;&lt;/EventTrigger&gt;<br />
	&nbsp;&nbsp;&lt;EventTrigger&gt;<br />
	&nbsp;&nbsp;&nbsp;&nbsp;&lt;trigger&gt;Ony 25</span>&lt;/trigger&gt;<br />
	&nbsp;&nbsp;&nbsp;&nbsp;&lt;resultpool&gt;WLK25&lt;/resultpool&gt;<br />
	&nbsp;&nbsp;&nbsp;&nbsp;&lt;resultevent&gt;Onyxia\'s Lair (25)&lt;/resultevent&gt;<br />
	&nbsp;&nbsp;&lt;/EventTrigger&gt;<br />
	&nbsp;&nbsp;&lt;EventTrigger&gt;<br />
	&nbsp;&nbsp;&nbsp;&nbsp;&lt;trigger&gt;ICC (10)&lt;/trigger&gt;<br />
	&nbsp;&nbsp;&nbsp;&nbsp;&lt;resultpool&gt;WLK10&lt;/resultpool&gt;<br />
	&nbsp;&nbsp;&nbsp;&nbsp;&lt;resultevent&gt;Icecrown (10)&lt;/resultevent&gt;<br />
	&nbsp;&nbsp;&lt;/EventTrigger&gt;<br />
	&lt;/EventTriggers&gt;', 
	
'RT_TRIGGERXML_NODATA' => 'pas de XML à parser', 
'RT_TRIGGERXML_INVALID' => 'XML invalide', 
'RT_HELP_IMPORT_EVENT_TRIGGERS' => 'Collez le texte ci-dessous pour importer les déclencheurs d\'évènements de de groupes DKP. Si\'ils n\'existent pas, ils seront créés.', 
'RT_TRIGGER_CONFIRM_DELETE' => 'Ëtes-vous sûr de vouloir supprimer les déclencheurs suivants ?',
'RT_TRIGGER_NOT_SELECTED' => 'Pas de déclencheurs séléctionnés.',
'RT_TRIGGER_DUPLICATE' => 'Déclencheur %s pour %s existe déjà.',
'RT_TRIGGER_SUCCESS_ADD' => 'Déclencheur %s ajouté pour %s.',
'RT_TRIGGER_FAIL_ADD' => 'Déclencheur %s ajouté pour %s.',
'RT_DKPPOOL_SUCCESS_ADD' => 'Groupe DKP %s ajouté. ',
'RT_DKPPOOL_FAIL_ADD' => 'Groupe DKP  %s pas ajouté. existe déjà ',
'RT_EVENT_SUCCESS_ADD' => 'Evénement %s ajouté. ',
'RT_EVENT_FAIL_ADD' => 'Evénement %s pas ajouté. Existe déjà. ',

'RT_TRIGGER_SUCCESS_UPDATE' => 'Déclencheur mis à jour.',
'RT_TRIGGER_SUCCESS_DELETE' => 'Déclencheur %s supprimé pour %s.',
'RT_TRIGGER_MISSING_EVENT'	=> 'Cet evénement n\'existe pas : "%s". ne peut pas ajouter déclencheur "%s" ', 

'RT_HELP_EVENT_TRIGGER' => "Les déclencheurs de zones lient une zone du XML à un événement en bbDKP",
'RT_HELP_EVENT_TRIGGER_NAME' => 'Entrez le nom de Zone à remplacer par le nom de l\'événement.',
'RT_HELP_EVENT_TRIGGER_RESULT' => 'Choisir l\'événement correspondant',

/*
 * Own Raids
 * Random Drops are normaly added to an own Raid called "Random Drop"
 * 
 */
'RT_OWN_RAID' => 'Raid Particulier',

'RT_ADMINMENU_OWN_RAIDS' => 'Raids Particuliers',
'RT_ADMINMENU_OWN_RAIDS_ADD' => 'Ajouter',
'RT_ADMINMENU_OWN_RAIDS_LIST' => 'Liste',
'RT_ADMINMENU_OWN_RAIDS_EXPORT' => 'Exporter',
'RT_ADMINMENU_OWN_RAIDS_IMPORT' => 'Importer',
'RT_HELP_OWN_RAID' => 'Note de Raid qui déclenchera comme un Raid "Particulier", (par exemple "Random Drops")',
'RT_HELP_OWN_RAID_NAME' => 'Entre le nom du Raid à utiliser.',

'RT_OWN_RAID_CONFIRM_DELETE' => 'Êtes-vous sûr de voilour supprimer les Raids particuliers suivants ?',
'RT_OWN_RAID_NOT_SELECTED' => 'Pas de Raid particulier séléctionné.',
'RT_OWN_RAID_DUPLICATE' => 'Le Raid Parciculier %s existe déjà.',
'RT_OWN_RAID_SUCCESS_ADD' => 'Raid Parciculier  %s ajouté.',
'RT_OWN_RAID_SUCCESS_UPDATE' => 'Raid Parciculier mis à jour.',
'RT_OWN_RAID_SUCCESS_DELETE' => 'Raid Parciculier %s supprimé.',

'RT_HELP_OWN_RAID_EXPORT' => 'Copie l\'XML ci-dessous et colle le dans un programme de traitement de texte.',

'RT_HELP_IMPORT_RAID_TRIGGERS' => 'Colle l\'XML ci-dessous pour importer vos déclencheurs.',
'RT_HELP_OWN_RAID_IMPORT_FORMAT' => 'l\'importation est indépendante de l\'usage de majuscules/minuscules et doit être dans la forme XML.',
'RT_OWN_RAID_IMPORTSAMPLE'	=> '&lt;OwnRaids&gt;<br />
&nbsp;&nbsp;&lt;OwnRaid&gt;Random Drop&lt;/OwnRaid&gt;<br />
&lt;/OwnRaids&gt;', 


/*
 * Raid Triggers
 * 
 */
'RT_ADMINMENU_RAID_NOTE_TRIGGERS' => 'Note de Raids',
'RT_ADMINMENU_RAID_NOTE_TRIGGERS_ADD' => 'Ajouter',
'RT_ADMINMENU_RAID_NOTE_TRIGGERS_LIST' => 'Liste',
'RT_ADMINMENU_RAID_NOTE_TRIGGERS_EXPORT' => 'Exporter',
'RT_ADMINMENU_RAID_NOTE_TRIGGERS_IMPORT' => 'Import',

'RT_HELP_RAID_NOTE_TRIGGER' => 'Ici vous pouvez indiquer les déclencheurs pour la note de Raid bbDKP (la note de Raid CT_RaidRracker et les notes de Loot seront parsés, tandis que les notes de loot sont prioritaires)',
'RT_HELP_RAID_NOTE_TRIGGER_NAME' => 'Entre le nom de la Note de Raid qui sera remplacé par le résultat.',
'RT_HELP_RAID_NOTE_TRIGGER_RESULT' => 'Entre le texte qui remplacera le texte déclencheur',

'RT_OWN_RAID_NOTETRIGGER_EXPORT' => 'Copie l\'XML ci-dessous et colle le dans un programme de traitement de texte.',

'RT_RAID_NOTETRIGGER_CONFIRM_DELETE' => 'Êtes-vous sûr de vouloir remplacer les déclencheurs de Note de Raids suivants ? %s ',
'RT_RAID_NOTETRIGGER_NOT_SELECTED' => 'Pas de déclencheurs séléctionnés.',
'RT_RAID_NOTETRIGGER_DUPLICATE' => 'Ce déclencheur de Notes %s pour %s existe déjà.',
'RT_RAID_NOTETRIGGER_SUCCESS_ADD' => 'déclencheur de Notes %s ajouté pour %s.',
'RT_RAID_NOTETRIGGER_SUCCESS_UPDATE' => 'déclencheur de Notes mis à jour.',
'RT_RAID_NOTETRIGGER_SUCCESS_DELETE' => 'déclencheur de Notes %s supprimé pour %s.',

'RT_RAID_NOTE' => 'Note de Raid',
'RT_RAID_NOTE_TRIGGER' => 'Note de Raid qui sera inserée',


'RT_HELP_RAID_NOTE_IMPORT_FORMAT' => 'l\'importation est indépendante de l\'usage de majuscules/minuscules et doit être dans la forme XML.',
'RT_RAID_NOTE_IMPORTSAMPLE'	=> '&lt;RaidNoteTriggers&gt;<br />
&nbsp;&nbsp;&lt;RaidNoteTrigger&gt;<br />
&nbsp;&nbsp;&nbsp;&nbsp;&lt;trigger&gt;Bloodlord&lt;/trigger&gt;<br />
&nbsp;&nbsp;&nbsp;&nbsp;&lt;result&gt;Bloodlord Mandokir&lt;/result&gt;<br />
&nbsp;&nbsp;&lt;/RaidNoteTrigger&gt;<br />
&nbsp;&nbsp;&lt;RaidNoteTrigger&gt;<br />
&nbsp;&nbsp;&nbsp;&nbsp;&lt;trigger&gt;Fankriss&lt;/trigger&gt;<br />
&nbsp;&nbsp;&nbsp;&nbsp;&lt;result&gt;Fankriss the Unyielding&lt;/result&gt;<br />
&nbsp;&nbsp;&lt;/RaidNoteTrigger&gt;<br />
&nbsp;&nbsp;&lt;RaidNoteTrigger&gt;<br />
&nbsp;&nbsp;&nbsp;&nbsp;&lt;trigger&gt;Gruul&lt;/trigger&gt;<br />
&nbsp;&nbsp;&nbsp;&nbsp;&lt;result&gt;Gruul the Dragonkiller&lt;/result&gt;<br />
&nbsp;&nbsp;&lt;/RaidNoteTrigger&gt;<br />
&lt;/RaidNoteTriggers&gt;', 

/**
 * Buttons
 */
'RT_CANCEL' => 'Annulation',
'RT_RESULT' => 'Résultat',

/**
 * Form validation messages
 */
'RT_FV_INVALID_XML' => 'Importation XML impossible, XML invalide. Comparez avec exemple fourni.',

'RT_MEMBER_NAME_BEFORE' => 'Membre avant',
'RT_MEMBER_NAME_AFTER' => 'Membre après',
'RT_LABEL_MEMBER_NAME' => 'Nom de membre',

/*
 * Race Names
 */
'BLOOD_ELF'  => 'Blood Elf',
'DRAENEI'    => 'Draenei',
'DWARF'      => 'Dwarf',
'GNOME'      => 'Gnome',
'HUMAN'      => 'Human',
'NIGHT_ELF'  => 'Night Elf',
'ORC'        => 'Orc',
'UNDEAD'     => 'Undead',
'TAUREN'     => 'Tauren',
'TROLL'      => 'Troll',

/*
 * Class Names
 */
'WARRIOR'     => 'Warrior',
'ROGUE'       => 'Rogue',
'HUNTER'      => 'Hunter',
'PALADIN'     => 'Paladin',
'PRIEST'      => 'Priest',
'DRUID'       => 'Druid',
'SHAMAN'      => 'Shaman',
'WARLOCK'     => 'Warlock',
'MAGE'        => 'Mage',
'DEATHKNIGHT' => 'Death Knight',

));

?>
