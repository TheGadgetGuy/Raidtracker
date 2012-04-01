<?php
/**
* Raidtracker language file - DE
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
* @author Sajaki
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
'RT' => 'RaidTracker Import',
'IMPORT_RT_DATA' => 'Import DKP XML',
'RT_DISABLED' => 'Raidtracker ist momentan nicht verfügbar ', 
'RT_PHP5'	=> 'RaidTracker benötigt PHP 5.',
'RT_ERR_DUPLICATE' => 'Fehler. Einfügung Duplikat vom Raid versucht.', 
'RT_ERR_NOATTENDEES' => 'Fehler. keine Teilnehmner. ', 
'RT_ERR_NORAIDNOTE' => 'Fehler. Kein Raidnote. ',
'RT_ERR_NOBOSSKILL' => 'Fehler. kein Bosskill Element gefunden. Einfügung nicht gelungen',
'RT_ERR_NOEVENT' => 'Fehler. keine Beziehung gefunden zur Ergebnisse für diese Raidzones <br /> "%s". <br />Erst muss eine Beziehung zwischen <br /> "%s" <br /> und einen bestehenden Ereignis eingestellt werden bevor der Raid importiert werden kann. ',
'RT_ERR_NOEVENTSETUP' => 'Fehler. keine Ereignisse aufgefunden in bbDKP. Raidtracker kann nicht funktionieren. ',
'RT_ERR_NODKPSYSSETUP' => 'Fehler. kein DKP Pool ist aufgefunden in bbDKP. Raidtracker kann nicht funktionieren.',
'RT_ERR_NOSTARTTAG'	=> 'Fehler. kein starttime Element gefunden.', 
'RT_ERR_NOENDTAG'	=> 'Fehler. kein endtime Element gefunden. ',
'RT_ERR_NOZONEFOUND'	=> 'Fehler. keine zone gefunden', 
'RT_ERR_NOPLAYERINFOSTAG'	=> 'Fehler. kein Playerinfo Element gefunden', 
'RT_ERR_NOPLAYER_RACE_TAG'	=> 'Fehler. kein Playerinfo race Element gefunden', 
'RT_ERR_NOPLAYER_CLASS_TAG'	=> 'Fehler. kein Playerinfo class Element gefunden', 
'RT_ERR_NOPLAYER_NAME_STAG'	=> 'Fehler. kein Playerinfo name Element gefunden', 
'RT_ERR_NOPLAYER_LEVEL_TAG'	=> 'Fehler. kein Playerinfo level Element gefunden', 
'RT_ERR_NOJOINTAG' => 'Fehler. kein join Element gefunden', 
'RT_ERR_NOLEAVETAG' => 'Fehler. kein leave Element gefunden', 
'RT_ERR_RAID_ALREADYPROCESSED' => 'Fehler. Raid bereits eingefügt',

// parse screen
'RT_STEP1_PAGETITLE' => 'RaidTracker XML Parser',
'RT_STEP1_DESCRIPTION' => 'Setze ML_Raidtracker (http://www.mlmods.net) Exportformat auf "MLDdkp 1.1 /EQdkp"(/rt o in WoW).<br /> Zum exportieren, /rt, dann rechsklicken auf Raidname, wähle "show Dkp string", und kopiere den XML im Textfeld. 
<br /> klick "Parse Log" zum importieren. Bereitz geparste Raids können im "bbDKP Import" in bbDKP eingefügt werden.',
'RT_STEP1_INVALIDSTRING_TITLE' => 'Ungültiger DKP XML',
'RT_STEP1_INVALIDSTRING_MSG' => 'Der DKP XML ist ungültig.',
'RT_STEP1_NODATA' => 'Kein DKP XML zum parsen', 
'RT_STEP1_BUTTON_PARSELOG' => 'Parse Log',
'RT_STEP1_EDIT' => 'Bearbeiten',
'RT_STEP1_DELETE' => 'Delete' , 
'RT_STEP1_ZONE' => 'Zone', 
'RT_STEP1_START' => 'Start', 
'RT_STEP1_ZONE' => 'Verriegeld', 
'RT_STEP1_END'	=> 'Ende', 
'RT_STEP1_DONE' => 'Log importiert im Zwischenlager. ',
'RT_STEP1_FOUNDRAIDS'	=> '%d Raids gefunden im Zwischenlager', 
'RT_STEP1_DELETEPARSE'	=> 'Raids %s ist gelöscht vom Zwischenlager', 
'RT_STEP1_DELETCONFIRM'	=> 'Bist du sicher dass der Raid %s vom Zwischenlager gelöscht werden soll?', 

// bbDKP import screen
'RT_STEP2_PAGETITLE' => 'bbDKP Import',
'RT_STEP2_DKPPOOL' => 'DKP Pool',
'RT_STEP2_EVENT' => 'Ereignis',
'RT_STEP2_RAIDINFO' => 'Raid info',
'RT_STEP2_RAIDSTART' => 'Raid Start:',
'RT_STEP2_RAIDEND' => 'Raid Ende:',
'RT_STEP2_REALM' => 'Realm:',
'RT_STEP2_ZONE' => 'Zone:',
'RT_DIFFICULTYNORMAL' => 'Normal', 
'RT_DIFFICULTYHEROIC' => 'Heroisch', 
'DIFFICULTY' => 'Schwierigkeitsgrad', 
'RT_STEP2_DKPVALUE' => 'DKP Wert:',
'RT_STEP2_DKPVALUE_EXPLAIN' => 'Dieser Wert wird als Gewinn verbucht für jedem Teilnehmer.',
'RT_STEP2_ERR_RAIDID'	=> 'Fehler. Ungültiger Raidid.', 

//js alerts
'ALERT_AJAX' => 'Es hat sich ein Problem vorgetan beim laden von XMLHTTP', 
'ALERT_OLDBROWSER' => 'Dein Browser ist veraltet.', 

// Import Screen
'RT_STEP2_RAIDSDROPSDETAILS' => 'Raid/Loot Details',
'RT_STEP2_COMMENT' => 'Kommentare',
'RT_STEP2_BOSS' => 'Boss Name: ',
'RT_STEP2_KILLTIME' => 'Bosskill Zeit:',
'RT_STEP2_DKPCOST' => 'DKP Kost:',
'RT_STEP2_ATTENDEES' => 'Teilnehmer',
'RT_STEP2_ITEMNAME' => 'Item Name:',
'RT_STEP2_ITEMID' => 'Item ID:',
'RT_STEP2_LOOTER' => 'Looter:',
'RT_STEP2_ITEMDKPVALUE' => 'DKP Wert:',
'RT_STEP2_DKPVALUETIP' => 'Nullsummen DKP, addiere für alle Teilnehmer der Gegenstandswert/Teilnehmeranzahl',
'RT_STEP2_INSERTRAIDS' => 'Raid hinzufügen',
'RT_STEP2_TIMEBONUSCALCULATION' => 'Zeitbonusberechnung',
'RT_STEP2_TIMEBONUSCALCULATION_EXPLAIN' => 'Diese Boni werden als Gewinn verbucht im Teilnehmerkonto.', 
'RT_STEP2_ID' => 'ID',
'RT_STEP2_NAME' => 'Spieler',
'RT_STEP2_JOINTIME' => 'Start',
'RT_STEP2_LEAVETIME' => 'Ende',
'RT_STEP2_DURATION' => 'Dauer',
'RT_STEP2_BASIS' => 'Basis',
'RT_STEP2_TIMEBONUS' => 'Zeitbonus',


// TRIGGER-ERROR RESULTS
'RT_STEP3_PAGETITLE' => 'RaidTracker Import',
'RT_STEP3_TITLE' => 'Aktionslog<br/>',
'RT_STEP3_ALREADYEXIST' => '%s (%s, %s DKP) war schon addiert, wird ausgelassen<br/>',
'RT_STEP3_EMPTYRAIDNOTE' => '%s (%s, %s DKP) hat keine Raidnotiz, wird ausgelassen<br/>',
'RT_STEP3_RAIDADDED' => '%s (%s, %s DKP) ist zugefügt<br/>',
'RT_STEP3_ADJADDED' => 'Eine Punkteanpassung von %s DKP ist %s zugefügt worden<br/>',
'RT_STEP3_MEMBERADDED' => 'Spieler %s (%s, %s, %s, %s) wurde zugefügt an die Mitgliedsliste<br/>',
'RT_STEP3_MEMBERDKPADDED' => '%s kat ein DKP Konto bekommen<br/>',
'RT_STEP3_MEMBERUPDATED' => 'Spieler %s (%s, %s, %s, %s) wurde aktualisiert zu (%s, %s, %s, %s)<br/>',
'RT_STEP3_MEMBERDKPUPDATED' => '%s DKP Konto aktualisiert<br/>',
'RT_STEP3_MEMBERLEVELUPDATED' => 'des Level von %s ist akualisiert von %s zu %s<br/>',
'RT_STEP3_ATTENDEESADDED' => '%s Teilnehmer wurden zugefügt<br/>',
'RT_STEP3_LOOTADDED' => '%s (%s DKP) ist addiert worden für %s<br/>',


/**
 * Log Actions
 */
'ACTION_RT_CONFIG_UPDATED' => '%s hat die Raidtracker Einstellungen bearbeitet.',

/**
 * configuration 
 */
'RT_SETTINGS_UPDATE_SUCCESS' => 'Raidtracker Einstellungen aktualisiert durch %s.',

'RT_MIN_QUALITY_EXPLAIN' => 'Minimum Gegenstandsqualität.',
'RT_ADD_LOOT_DKP_EXPLAIN' => 'Nullsummen DKP : Gegenstandswert/Teilnehmeranzahl wird verteilt als Gewinn an alle Bosskill-Teilnehmer. (ex. 120 dkp / 10 teilnehmer = 12 DKP pro Kopf)',
'RT_IGNORED_LOOTER_EXPLAIN' => 'Dieser Looter werd nicht aufgenommen (zb. disenchant).',
'RT_EVENT_TRIGGER_EXPLAIN' => "Ereignis triggers verlinken die Zone im DKP XML mit bbDKP Ereignisse. ",

'RT_ATTENDANCE_FILTER_EXPLAIN' => 'Es gibt 2 Bosskill-Teilnehmungskriterien. entweder alle Schlachtgruppe Teilnehmer im DKP XML oder nur diejenige die tatsächlich mitgespielt haben am Bosskill.',
'RT_DEFAULT_DKP_EXPLAIN' => 'Standartwert für Gegenstände ohne aufgegebenen Preis.',
'RT_STARTING_DKP_EXPLAIN' => 'Punkteanpassung zu vergeben für neue Mitglieder, wenn &gt; 0, wird dies als Start DKP zugefügt.',
'RT_START_RAID_DKP_EXPLAIN' => 'Starting Raid DKP.',
'RT_ALTREPLACE_EXPLAIN' => 'Wenn aktiviert, werden Alt Charaktere im DKP XML ersetzt durch das Hauptcharakter, wie in die Alt Liste aufgesetzt', 

'RT_MIN_QUALITY' => 'Minimum Qualität',
'RT_ADD_LOOT_DKP' => 'Berechne Nullsummen DKP',
'RT_IGNORED_LOOTER' => 'Looter zum ignorieren',
'RT_EVENT_TRIGGER' => 'Check for Event Triggers',
'RT_DEFAULT_RANK' => 'Default Rank',
'RT_ATTENDANCE_FILTER' => 'Attendance Filter',
'RT_DEFAULT_DKP' => 'Standartkost',
'RT_STARTING_DKP' => 'Starting DKP',
'RT_CREATE_START_RAID' => 'Create Start Raid',
'RT_START_RAID_DKP' => 'Start Raid DKP',
'RT_ALTREPLACE' => 'Ersetze Alt Namen',
'RT_ALTREPLACE_WARNING' => 'Ersetze Alt Namen mit Hauptcharaktere',
'RT_DKPHOUR' => 'DKP pro Stunde', 
'RT_DKPHOUR_EXPLAIN' => 'Für jede begonnene stunde wird x DKP vergeben.',

'RT_NOGUILD' => 'Keine Gilde ?',
'RT_NOGUILD_EXPLAIN' => 'wenn kein XML-tag besteht im XML oder wenn der Raider gildenlos ist',
'RT_NOGUILD_ADDCURRENT' => 'Addiere zur StandardGilde',
'RT_NOGUILD_ADDNONE' => 'Addier als gildenlos',

'VLOG_RT_CONFIG_UPDATED' => '%s hat RaidTrackereinstellungen überarbeitet.',
'RT_ADMINMENU_CONFIG' => 'Einstellung',
'RT_ADMINMENU_SETTINGS' => 'Einstellung',

'RT_IQ_POOR' => 'Schlecht',
'RT_IQ_COMMON' => 'Verbreitet',
'RT_IQ_UNCOMMON' => 'Selten',
'RT_IQ_RARE' => 'Rar',
'RT_IQ_EPIC' => 'Episch',
'RT_IQ_LEGENDARY' => 'Legendär',

'RT_BANKER' => 'Bank Trigger ',
'RT_BANKER_EXPLAIN' => 'Bankname im XML zur Küpplung mit die bbDKP Bank',

/**
 * Attendance Filter
 */
'RT_AF_NONE' => 'Teilnehmer present im Raid',
'RT_AF_BOSS_KILL' => 'Teilnehmer present am Bosskill',

/**
 * Always Add these Items
 */

'RT_ADDITEM_SAMPLE_XML'	=> '&lt;AddItems&gt;<br />
&nbsp;&nbsp;&nbsp;&nbsp;&lt;AddItem&gt;18562&lt;/AddItem&gt;<br />
&nbsp;&nbsp;&nbsp;&nbsp;&lt;AddItem&gt;25641&lt;/AddItem&gt;<br />
&lt;/AddItems&gt;', 

'RT_ITEM_CONFIRM_DELETE' => 'Bist du sicher dass diese Gegenstände gelöscht werden müssen?',
'RT_ITEM_NOT_SELECTED' => 'Keine Gegenstände ausgewählt.',
'RT_ITEM_DUPLICATE' => 'Gegenstand %s existiert schon',
'RT_ITEM_SUCCESS_ADD' => 'Gegenstand %s zugefügt.',
'RT_ITEM_FAIL_ADD' => 'Gegenstand %s nicht zugefügt.',
'RT_ITEM_SUCCESS_UPDATE' => 'Gegenstand bearbeitet.',
'RT_ITEM_SUCCESS_DELETE' => 'Gegenstand %s gelöscht.',

'RT_HELP_ADD_ITEMS' => 'Diese Gegenstände werden immer eingefügt (ungeachtet ignorierte Gegenstandsliste, Looter, oder Lootniveau)',
'RT_HELP_ADD_ITEMS_WOW_ID' => 'Wow Gegenstands ID. (siehe Wowhead Itemid)',
'RT_ITEM_WOW_ID' => 'WoW Gegenstands ID',

'RT_ADMINMENU_ADD_ITEMS' => 'Gegenstände',
'RT_ADMINMENU_ADD_ITEMS_ADD' => 'Zufügen',
'RT_ADMINMENU_ADD_ITEMS_LIST' => 'Liste',
'RT_ADMINMENU_ADD_ITEMS_EXPORT' => 'Exportieren',
'RT_ADMINMENU_ADD_ITEMS_IMPORT' => 'Importieren',

'RT_HELP_IMPORT_ITEM' => 'Gegenständs-XML',
'RT_HELP_IMPORT_FORMAT' => 'der Import ist unabhängich von Gross- oder Kleinschreibung und ist in der Form ',

'RT_INVALID_XMLIMPORT' => 'Ungültiger oder leerer XML',  
'RT_HELP_ITEM_EXPORT' => 'Kopiere den Tekst hierunter und füge es in ihr favorites Tekstverarbeitungsprogramm.',

/**
 * Always Ignore Items
 */
'RT_HELP_IGNORE_ITEMS' => 'Diese Gegenstände werden immer ignoriert.',
'RT_HELP_IGNORE_ITEMS_WOW_ID' => 'Wow Gegenstands ID. (siehe Wowhead Itemid)',

'RT_ADMINMENU_IGNORE_ITEMS' => 'Ignorierte Gegenstände',
'RT_ADMINMENU_IGNORE_ITEMS_ADD' => 'Zufügen',
'RT_ADMINMENU_IGNORE_ITEMS_LIST' => 'Liste',
'RT_ADMINMENU_IGNORE_ITEMS_EXPORT' => 'Exportieren',
'RT_ADMINMENU_IGNORE_ITEMS_IMPORT' => 'Importieren',

'RT_IGNORE_ITEMS_IMPORTSAMPLE' => '&lt;IgnoreItems&gt;<br />
&nbsp;&nbsp;&lt;IgnoreItem&gt;<br />
&nbsp;&nbsp;&nbsp;&nbsp;18562<br />
&nbsp;&nbsp;&lt;/IgnoreItem&gt;<br />
&nbsp;&nbsp;&lt;IgnoreItem&gt;<br />
&nbsp;&nbsp;&nbsp;&nbsp;20725<br />
&nbsp;&nbsp;&lt;/IgnoreItem&gt;<br />
&lt;/IgnoreItems&gt;', 

'RT_HELP_EXPORT' => 'Kopiere den Tekst hierunter und füge es in ihr favorites Tekstverarbeitungsprogramm.',


/**
 * Alts/alias/twinks
 */

'RT_ADMINMENU_ALIASES' => 'Alt-Charaktere',
'RT_ADMINMENU_ALIASES_ADD' => 'Zufügen',
'RT_ADMINMENU_ALIASES_LIST' => 'Liste',
'RT_ADMINMENU_ALIASES_EXPORT' => 'Exportieren',
'RT_ADMINMENU_ALIASES_IMPORT' => 'Importieren',
'RT_ALIAS' => 'Alt-Charakter im Raid',
'RT_MEMBER' => 'Hauptcharakter',
'RT_ALIASES' => 'Alt-Charaktere',


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

'RT_IMPORT' => 'Importieren',
'RT_HELP_IMPORT' => 'Hierunter soll der Alt-Charaktere XML eingefügt werden.',

'RT_HELP_ALIAS' => 'Wenn ein Spieler ein Charakter im Schlachtzug mitbringt und die Punkte vergeben werden sollen an ein anderes Charakter. ',
'RT_HELP_ALIAS_NAME' => 'Dieser Name wird substituiert durch den Namen hierunter.',
'RT_HELP_ALIAS_MEMBER' => 'Wähle den Namen des Mitglieds das DKP punkte vom Alt erhalten soll.',
'RT_HELP_ALIAS_EXPORT' => 'Kopiere den Tekst hierunter und füge es in dein favorites Tekstverarbeitungsprogramm.',
'RT_HELP_ALIAS_IMPORT' => 'Paste the text below to import your Alts.',
'RT_HELP_ALIAS_IMPORT_FORMAT' => 'der Import ist unabhängich von Gross- oder Kleinschreibung und ist in der Form ',

'RT_ALIAS_DUPLICATE' => 'Duplikat aufgefunden : Altname %s wurde nicht verbunden an %s',
'RT_ADD_ALIAS_SUCCESS' => 'Alt %s verbunden am Mitglied %s.',
'RT_ALIAS_UPDATE_SUCCESS' => 'die Verbindung zwischen Alt %s und Mitglied %s ist aktualisiert. ',
'RT_NO_ALIAS_SELECTED' => 'Kein Alt gewählt.',
'RT_CONFIRM_DELETE_ALIAS' => 'Bist du sicher dass die folgenden Alts gelöscht werden sollen ?',
'RT_ALIAS_DELETED' => 'Alt %s wurde vom Mitglied %s gelöscht.',
'RT_ALIAS_IMPORT_MISSING_MEMBER' => 'Mitglied nicht gefunden, Altverbindung kann nicht Alt %s - %s kann nicht gemacht werden.',

'ACTION_RT_ALIAS_ADDED' => ' Altverbindung zugefügt',
'ACTION_RT_ALIAS_UPDATED' => ' Altverbindung aktualisiert',
'ACTION_RT_ALIAS_DELETED' => ' Altverbindung gelöscht',
'RT_ALIAS_NAME_BEFORE' => 'Alt vorher',
'RT_ALIAS_NAME_AFTER' => 'Alt nachher',

'VLOG_RT_ALIAS_ADDED' => '%s hat RaidTracker Alt %s zugefügt für Mitglied %s.',
'VLOG_RT_ALIAS_UPDATED' => '%s hat RaidTracker Alt %s aktualisiert für Mitglied %s.',
'VLOG_RT_ALIAS_DELETED' => '%s hat RaidTracker Alt %s gelöscht von Mitglied %s.',

'RT_LABEL_ALIAS_NAME' => 'Alt Name',


/*
 * Events
 * 
 */
'EVENT'	=> 'Ereignis Name', 
'RT_TRIGGER' => 'Verbindungs Name',
'RT_ADMINMENU_EVENT_TRIGGERS' => 'Ereignisverbindung',
'RT_ADMINMENU_EVENT_TRIGGERS_ADD' => 'Zufügen',
'RT_ADMINMENU_EVENT_TRIGGERS_LIST' => 'Liste',
'RT_ADMINMENU_EVENT_TRIGGERS_EXPORT' => 'Exportieren',
'RT_ADMINMENU_EVENT_TRIGGERS_IMPORT' => 'Importieren',

'RT_HELP_EVENT_TRIGGERS_IMPORT_FORMAT' => 'der Import ist unabhängich von Gross- oder Kleinschreibung und ist in der Form ',
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
	
'RT_TRIGGERXML_NODATA' => 'Kein XML aufgefunden', 
'RT_TRIGGERXML_INVALID' => 'Ungültiger XML', 
'RT_HELP_IMPORT_EVENT_TRIGGERS' => 'Füge hierunter den XML zur verbindung zwischen einerseids Zonen und anderseitz bbDKP DKPPool-Ereignisse. in bbDKP fehlende Pools oder Ereignisse werden geschafft.', 
'RT_TRIGGER_CONFIRM_DELETE' => 'Bist du sicher dass die folgenden Verbindungen gelöscht werden sollen ?',
'RT_TRIGGER_NOT_SELECTED' => 'Keine Verbindung gewählt.',
'RT_TRIGGER_DUPLICATE' => ' %s - %s Verbindung besteht schon.',
'RT_TRIGGER_SUCCESS_ADD' => '%s - %s Verbindung zugefügt.',
'RT_TRIGGER_FAIL_ADD' => '%s - %s Verbindung nicht gelungen.',
'RT_DKPPOOL_SUCCESS_ADD' => 'DKP Pool %s zugefügt. ',
'RT_DKPPOOL_FAIL_ADD' => 'DKP Pool %s nicht zugefügt. besteht schon. ',
'RT_EVENT_SUCCESS_ADD' => 'Ereignis %s zugefugt. ',
'RT_EVENT_FAIL_ADD' => 'Ereignis %s nicht zugefügt. besteht schon. ',

'RT_TRIGGER_SUCCESS_UPDATE' => 'Trigger updated.',
'RT_TRIGGER_SUCCESS_DELETE' => 'Trigger %s deleted for %s.',
'RT_TRIGGER_MISSING_EVENT'	=> 'This event does not exist : "%s". can\'t add trigger "%s" ', 

'RT_HELP_EVENT_TRIGGER' => "Verbindung zwischen einerseids Zonen und anderseitz bbDKP DKPPool-Ereignisse",
'RT_HELP_EVENT_TRIGGER_NAME' => 'Zonenname der ersetzt werden soll.',
'RT_HELP_EVENT_TRIGGER_RESULT' => 'Wähle den Ubereinstimmenden Ereignis',

/*
 * Own Raids
 * Random Drops are normaly added to an own Raid called "Random Drop"
 * 
 */

'RT_OWN_RAID' => 'Eigene Raid',

'RT_ADMINMENU_OWN_RAIDS' => 'Eigene Raids',
'RT_ADMINMENU_OWN_RAIDS_ADD' => 'Add Eigene Raids',
'RT_ADMINMENU_OWN_RAIDS_LIST' => 'List Eigene Raids',
'RT_ADMINMENU_OWN_RAIDS_EXPORT' => 'Export Eigene Raids',
'RT_ADMINMENU_OWN_RAIDS_IMPORT' => 'Import Eigene Raids',
'RT_HELP_OWN_RAID' => 'Raidnotiz die als ’Eigener Raid’ eingestuft werden soll (zb ’Trash Raid’)',
'RT_HELP_OWN_RAID_NAME' => 'Gib den namen des Raids.',

'RT_OWN_RAID_CONFIRM_DELETE' => 'Bist du sicher dass diese Trash raids gelöscht werden sollen ?',
'RT_OWN_RAID_NOT_SELECTED' => 'Keine Trash Raids gewählt.',
'RT_OWN_RAID_DUPLICATE' => 'Trash raid %s besteht schon.',
'RT_OWN_RAID_SUCCESS_ADD' => 'Eigene raid %s zugefügt.',
'RT_OWN_RAID_SUCCESS_UPDATE' => 'Eigene raid aktualisiert.',
'RT_OWN_RAID_SUCCESS_DELETE' => 'Eigene raid %s gelöscht.',

'RT_HELP_OWN_RAID_EXPORT' => 'Kopiere den Tekst hierunter und füge es in dein favorites Tekstverarbeitungsprogramm.',

'RT_HELP_IMPORT_RAID_TRIGGERS' => 'Paste the text below to import the Raid triggers',
'RT_HELP_OWN_RAID_IMPORT_FORMAT' => 'der Import ist unabhängich von Gross- oder Kleinschreibung und ist in der Form ',
'RT_OWN_RAID_IMPORTSAMPLE'	=> '&lt;OwnRaids&gt;<br />
&nbsp;&nbsp;&lt;OwnRaid&gt;Random Drop&lt;/OwnRaid&gt;<br />
&lt;/OwnRaids&gt;', 


/*
 * Raidnotiz Triggers
 * 
 */
'RT_ADMINMENU_RAID_NOTE_TRIGGERS' => 'Raids',
'RT_ADMINMENU_RAID_NOTE_TRIGGERS_ADD' => 'Add Trigger',
'RT_ADMINMENU_RAID_NOTE_TRIGGERS_LIST' => 'List Triggers',
'RT_ADMINMENU_RAID_NOTE_TRIGGERS_EXPORT' => 'Export Triggers',
'RT_ADMINMENU_RAID_NOTE_TRIGGERS_IMPORT' => 'Import Triggers',

'RT_HELP_RAID_NOTE_TRIGGER' => 'Here you can set the triggers for the bbDKP Raid Note (CT_RaidRracker Raid note and the Loots Notes will 
be parsed (Loot Notes will override the Raid Note))',
'RT_HELP_RAID_NOTE_TRIGGER_NAME' => 'Enter the name of the raid note that will be replaced with the result.',
'RT_HELP_RAID_NOTE_TRIGGER_RESULT' => 'Enter the text you want to see in place of the trigger',

'RT_OWN_RAID_NOTETRIGGER_EXPORT' => 'Copy the text below and paste into your favorite text editor to save.',

'RT_RAID_NOTETRIGGER_CONFIRM_DELETE' => 'Are you sure you want to delete the following Raid Note triggers? %s ',
'RT_RAID_NOTETRIGGER_NOT_SELECTED' => 'No Raid Note triggers selected.',
'RT_RAID_NOTETRIGGER_DUPLICATE' => 'Raid Note Trigger %s for %s already exists.',
'RT_RAID_NOTETRIGGER_SUCCESS_ADD' => 'Raid Note Trigger %s added for %s.',
'RT_RAID_NOTETRIGGER_SUCCESS_UPDATE' => 'Raid Note Trigger updated.',
'RT_RAID_NOTETRIGGER_SUCCESS_DELETE' => 'Raid Note Trigger %s deleted for %s.',

'RT_RAID_NOTE' => 'Raid Note',
'RT_RAID_NOTE_TRIGGER' => 'Raid name that will be inserted',


'RT_HELP_RAID_NOTE_IMPORT_FORMAT' => 'The import is case insensitive and should be in the form',
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
'RT_CANCEL' => 'Cancel',
'RT_RESULT' => 'Result',

/**
 * Form validation messages
 */
'RT_FV_INVALID_XML' => 'ungültiger XML, kann nicht importiert werden.',

'RT_MEMBER_NAME_BEFORE' => 'Name vorher',
'RT_MEMBER_NAME_AFTER' => 'Name nachher',
'RT_LABEL_MEMBER_NAME' => 'Mitglieds name',

/*
 * Race Names
 */
'BLOOD_ELF'  => 'Blutelf',
'DRAENEI'    => 'Draenei',
'DWARF'      => 'Zwerg',
'GNOME'      => 'Gnome',
'HUMAN'      => 'Mensch',
'NIGHT_ELF'  => 'Nachtelf',
'ORC'        => 'Orc',
'UNDEAD'     => 'Untoter',
'TAUREN'     => 'Tauren',
'TROLL'      => 'Troll',

/*
 * Class Names
 */
'WARRIOR'     => 'Krieger',
'ROGUE'       => 'Schurke',
'HUNTER'      => 'Jäger',
'PALADIN'     => 'Paladin',
'PRIEST'      => 'Priester',
'DRUID'       => 'Druide',
'SHAMAN'      => 'Shamane',
'WARLOCK'     => 'Hexenmeister',
'MAGE'        => 'Magier',
'DEATHKNIGHT' => 'Todesritter',

));

?>
