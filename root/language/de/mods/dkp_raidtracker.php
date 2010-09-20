<?php
/**
* Raidtracker language file
*  
* Powered by bbdkp © 2009 The bbDkp Project Team
* If you use this software and find it to be useful, we ask that you
* retain the copyright notice below.  While not required for free use,
* it will help build interest in the bbDkp project.
* 
* Integrated by: ippeh
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
'RT' => 'RaidTracker Import',
'IMPORT_RT_DATA' => 'Import DKP String',
'RT_DISABLED' => 'Raidtracker is disabled', 
'RT_PHP5'	=> 'PHP 5 is Required for RaidTracker.',
'RT_ERR_DUPLICATE' => 'Error. Duplicate raid insert attempted. Your can\'t insert raid within 30 minutes of previous raid ', 
'RT_ERR_NOATTENDEES' => 'Error. no attendees. ', 
'RT_ERR_NORAIDNOTE' => 'Error. no Raidnote set. ',
'RT_ERR_NOBOSSKILL' => 'Error. no Bosskill tag. cannot import',
'RT_ERR_NOEVENT' => 'Error. no event trigger found for "%s". <br />Please make an Event trigger to link "%s" to an existing Event and then import your Raid. ',
'RT_ERR_NOEVENTSETUP' => 'Error. no events have been set up in bbDKP. Raidtracker will stop here. Check your Events and Event trigger setup. ',
'RT_ERR_NODKPSYSSETUP' => 'Error. no DKP systems have been set up in bbDKP. Raidtracker will stop here.',

// parse screen
'RT_STEP1_PAGETITLE' => 'RaidTracker log Parse',
'RT_STEP1_DESCRIPTION' => 'Set ML_Raidtracker (http://www.mlmods.net) export format to "MLDdkp 1.1 /EQdkp"(do /rt o in WoW to set settings).<br /> To export Raid, do /rt, then rightclick your Raid, choose "show Dkp string", and copy that into the area below. 
<br /> click "Parse Log" to import. Imported Raids can then be managed from the bbDKP Import tab. ',
'RT_STEP1_INVALIDSTRING_TITLE' => 'Invalid DKP String',
'RT_STEP1_INVALIDSTRING_MSG' => 'The DKP String is not valid.',
'RT_STEP1_NODATA' => 'No DKP string to parse', 
'RT_STEP1_BUTTON_PARSELOG' => 'Parse Log',
'RT_STEP1_EDIT' => 'Edit',
'RT_STEP1_DELETE' => 'Delete' , 
'RT_STEP1_ZONE' => 'Zone', 
'RT_STEP1_START' => 'Start', 
'RT_STEP1_END'	=> 'End', 
'RT_STEP1_DONE' => 'Log imported to temporary tables. ',
'RT_STEP1_FOUNDRAIDS'	=> 'Found %d Raid logs ready to transfer', 
'RT_STEP1_DELETEPARSE'	=> 'Raid %s deleted from temporary tables', 
'RT_STEP1_DELETCONFIRM'	=> 'Are you sure you want to delete Raid %s from the temporary tables ?', 

// bbDKP import screen
'RT_STEP2_PAGETITLE' => 'bbDKP Import',
'RT_STEP2_DKPPOOL' => 'DKP Pool',
'RT_STEP2_EVENT' => 'Event',
'RT_STEP2_RAIDINFO' => 'Raid info',
'RT_STEP2_RAIDSTART' => 'Raid Start:',
'RT_STEP2_RAIDEND' => 'Raid End:',
'RT_STEP2_REALM' => 'Realm:',
'RT_STEP2_ZONE' => 'Zone:',
'RT_DIFFICULTYNORMAL' => 'Normal', 
'RT_DIFFICULTYHEROIC' => 'Heroic', 
'DIFFICULTY' => 'Difficulty', 
'RT_STEP2_DKPVALUE' => 'DKP Value:',
'RT_STEP2_ERR_RAIDID'	=> 'Error. Invalid Raidid. cannot load', 

//js alerts
'ALERT_AJAX' => 'There was a problem while using XMLHTTP', 
'ALERT_OLDBROWSER' => 'Browser does not support HTTP Request', 

'RT_STEP2_RAIDSDROPSDETAILS' => 'Raid/Drop Details',
'RT_STEP2_COMMENT' => 'Comments',
'RT_STEP2_BOSS' => 'Boss Name: ',
'RT_STEP2_KILLTIME' => 'Bosskill Time:',
'RT_STEP2_DKPCOST' => 'DKP Cost:',
'RT_STEP2_ATTENDEES' => 'Attendees',
'RT_STEP2_ITEMNAME' => 'Item Name:',
'RT_STEP2_ITEMID' => 'Item ID:',
'RT_STEP2_LOOTER' => 'Looter:',
'RT_STEP2_ITEMDKPVALUE' => 'DKP Value:',
'RT_STEP2_DKPVALUETIP' => 'Add Item value/attendees (Zero DKP)',
'RT_STEP2_INSERTRAIDS' => 'Insert Raid(s)',


// TRIGGER-ERROR RESULTS
'RT_STEP3_PAGETITLE' => 'RaidTracker Import',
'RT_STEP3_TITLE' => 'Action log<br/>',
'RT_STEP3_ALREADYEXIST' => '%s (%s, %s DKP) was already added, skipping<br/>',
'RT_STEP3_EMPTYRAIDNOTE' => '%s (%s, %s DKP) has no raid note, skipping<br/>',
'RT_STEP3_RAIDADDED' => '%s (%s, %s DKP) was added<br/>',
'RT_STEP3_ADJADDED' => 'An adjustment of %s DKP was added to %s<br/>',
'RT_STEP3_MEMBERADDED' => '%s (race: %s, class: %s, level: %s, rank: %s) was added to the Member list<br/>',
'RT_STEP3_MEMBERDKPADDED' => '%s was added to the Member Dkp table<br/>',
'RT_STEP3_MEMBERUPDATED' => '%s (race: %s, class: %s, level: %s, rank: %s) was updated to (race: %s, class: %s, level: %s, rank: %s)<br/>',
'RT_STEP3_MEMBERDKPUPDATED' => '%s dkp was updated<br/>',
'RT_STEP3_MEMBERLEVELUPDATED' => 'Looks like %s gained some levels. Updated from %s to %s<br/>',
'RT_STEP3_ATTENDEESADDED' => '%s attendees were added<br/>',
'RT_STEP3_LOOTADDED' => '%s (%s DKP) was added to %s<br/>',


/**
 * Log Actions
 */
'ACTION_RT_CONFIG_UPDATED' => '%s changed Raidtracker settings',

/**
 * configuration 
 */
'RT_SETTINGS_UPDATE_SUCCESS' => 'Raidtracker Settings updated by %s.',

'RT_MIN_QUALITY_EXPLAIN' => 'Minimum Item Quality of Items to be parsed.',
'RT_ADD_LOOT_DKP_EXPLAIN' => 'The Item cost will be distributed as Earned points to all attendees at the bosskill',
'RT_IGNORED_LOOTER_EXPLAIN' => 'The name of the Looter to be ignored.',
'RT_EVENT_TRIGGER_EXPLAIN' => "Check for Event Triggers in the Loot Notes (e.g. if your events are organised per boss " . "'KZ (Wizard of Oz), KZ (The Curator), ...'" . " but only want to log one raid.)",

'RT_DEFAULT_RANK_EXPLAIN' => 'Default Rank for new Members that are added when importing a raid.',
'RT_ATTENDANCE_FILTER_EXPLAIN' => 'Sets the type of attendance filtering.',
'RT_DEFAULT_DKP_EXPLAIN' => 'The cost of items with no dkp value.',
'RT_STARTING_DKP_EXPLAIN' => 'When creating a new member, if this is &gt; 0, it will add an adjustment to the member as starting dkp.',
'RT_CREATE_START_RAID_EXPLAIN' => 'Check to create a Starting Raid when the Attendance Filter is set to Boss Kill.',
'RT_START_RAID_DKP_EXPLAIN' => 'Default starting Raid dkp.',
'RT_SIMULATE_EXPLAIN' => 'Check to not insert/alter any information in the database.',
'RT_ALTREPLACE_EXPLAIN' => 'Will use the Alt listing to replace alts with Main character', 

'RT_MIN_QUALITY' => 'Minimum Quality',
'RT_ADD_LOOT_DKP' => 'Calculate Zero sum DKP',
'RT_IGNORED_LOOTER' => 'Ignored Looter',
'RT_EVENT_TRIGGER' => 'Check for Event Triggers',
'RT_DEFAULT_RANK' => 'Default Rank',
'RT_ATTENDANCE_FILTER' => 'Attendance Filter',
'RT_DEFAULT_DKP' => 'Default DKP Cost',
'RT_STARTING_DKP' => 'Starting DKP',
'RT_CREATE_START_RAID' => 'Create Start Raid',
'RT_START_RAID_DKP' => 'Start Raid DKP',
'RT_SIMULATE' => 'Simulate',
'RT_SIMULATE_WARNING' => 'Simulation ON - This is what would be done:<br/><br/>',
'RT_ALTREPLACE' => 'Replace Alt names',
'RT_ALTREPLACE_WARNING' => 'Replace player names with Main character names',
'RT_DKPHOUR' => 'DKP per hour passed', 
'RT_DKPHOUR_EXPLAIN' => 'will assign x DKP as earned for each hour passed that member present in raid (we look at global attendance)',

'RT_BOSSRAID' => 'Raid logging level',
'RT_BOSSRAID_EXPLAIN' => 'One raid for each Bosskill or 1 Global raid', 
'RT_BOSSRAID_YES' => 'Per Bosskill',
'RT_BOSSRAID_NO' => 'One global raid',

'VLOG_RT_CONFIG_UPDATED' => '%s updated RaidTracker config.',
'RT_ADMINMENU_CONFIG' => 'Configure',
'RT_ADMINMENU_SETTINGS' => 'Settings',

'RT_IQ_POOR' => 'Poor',
'RT_IQ_COMMON' => 'Common',
'RT_IQ_UNCOMMON' => 'Uncommon',
'RT_IQ_RARE' => 'Rare',
'RT_IQ_EPIC' => 'Epic',
'RT_IQ_LEGENDARY' => 'Legendary',

/**
 * Attendance Filter
 */
'RT_AF_NONE' => 'Members present in Raid',
'RT_AF_BOSS_KILL' => 'Members present at Boss Kill',

/**
 * Always Add these Items
 */

'RT_ADDITEM_SAMPLE_XML'	=> '&lt;AddItems&gt;<br />
&nbsp;&nbsp;&nbsp;&nbsp;&lt;AddItem&gt;18562&lt;/AddItem&gt;<br />
&nbsp;&nbsp;&nbsp;&nbsp;&lt;AddItem&gt;25641&lt;/AddItem&gt;<br />
&lt;/AddItems&gt;', 

'RT_ITEM_CONFIRM_DELETE' => 'Are you sure you want to delete the following items?',
'RT_ITEM_NOT_SELECTED' => 'No items selected.',
'RT_ITEM_DUPLICATE' => 'Item %s already exists.',
'RT_ITEM_SUCCESS_ADD' => 'Item %s added.',
'RT_ITEM_FAIL_ADD' => 'Item %s not added.',
'RT_ITEM_SUCCESS_UPDATE' => 'Item updated.',
'RT_ITEM_SUCCESS_DELETE' => 'Item %s deleted.',

'RT_HELP_ADD_ITEMS' => 'These items will always be added regardless of ignored items, Looters, or loot threshold set in Raidtracker Import',
'RT_HELP_ADD_ITEMS_WOW_ID' => 'Enter the item ID to be always added. The item ID is the internal WoW indentifier.',
'RT_ITEM_WOW_ID' => 'WoW Item ID',

'RT_ADMINMENU_ADD_ITEMS' => 'Add Items',
'RT_ADMINMENU_ADD_ITEMS_ADD' => 'Add Items',
'RT_ADMINMENU_ADD_ITEMS_LIST' => 'List Add Items',
'RT_ADMINMENU_ADD_ITEMS_EXPORT' => 'Export Add Items',
'RT_ADMINMENU_ADD_ITEMS_IMPORT' => 'Import Add Items',

'RT_HELP_IMPORT_ITEM' => 'Paste the text below to import your Items.',
'RT_HELP_IMPORT_FORMAT' => 'The import is case insensitive and should be in the form',

'RT_INVALID_XMLIMPORT' => 'Invalid or no XML provided',  

'RT_HELP_ITEM_EXPORT' => 'Copy the text below and paste into your favorite text editor to save.',

/**
 * Always Ignore Items
 */
'RT_HELP_IGNORE_ITEMS' => 'Set a list of item IDs which will be ignored for every raid.',
'RT_HELP_IGNORE_ITEMS_WOW_ID' => 'Enter the item ID to be always ignored. The item ID is the internal WoW indentifier.',

'RT_ADMINMENU_IGNORE_ITEMS' => 'Ignored Items',
'RT_ADMINMENU_IGNORE_ITEMS_ADD' => 'Add Ignored Items',
'RT_ADMINMENU_IGNORE_ITEMS_LIST' => 'List Ignored Items',
'RT_ADMINMENU_IGNORE_ITEMS_EXPORT' => 'Export Ignored Items',
'RT_ADMINMENU_IGNORE_ITEMS_IMPORT' => 'Import Ignored Items',

'RT_IGNORE_ITEMS_IMPORTSAMPLE' => '&lt;IgnoreItems&gt;<br />
&nbsp;&nbsp;&lt;IgnoreItem&gt;<br />
&nbsp;&nbsp;&nbsp;&nbsp;18562<br />
&nbsp;&nbsp;&lt;/IgnoreItem&gt;<br />
&nbsp;&nbsp;&lt;IgnoreItem&gt;<br />
&nbsp;&nbsp;&nbsp;&nbsp;20725<br />
&nbsp;&nbsp;&lt;/IgnoreItem&gt;<br />
&lt;/IgnoreItems&gt;', 

'RT_HELP_EXPORT' => 'Copy the text below and paste into your favorite text editor to save.',


/**
 * Alts/alias/twinks
 */

'RT_ADMINMENU_ALIASES' => 'Alts',
'RT_ADMINMENU_ALIASES_ADD' => 'Add Alt',
'RT_ADMINMENU_ALIASES_LIST' => 'List Alts',
'RT_ADMINMENU_ALIASES_EXPORT' => 'Export Alts',
'RT_ADMINMENU_ALIASES_IMPORT' => 'Import Alts',
'RT_ALIAS' => 'Alt',
'RT_MEMBER' => 'Member',
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
'RT_HELP_IMPORT' => 'Paste the text below to import your Alts.',


'RT_HELP_ALIAS' => 'Use an Alt when a player brings a different character to a raid and you want to track DKP for only one character (e.g. if a Twink of the Mainchar helps out, but the Mainchar should get the DKP Points)',
'RT_HELP_ALIAS_NAME' => 'Whenever this name is encountered, it will be replaced by the Member name below.',
'RT_HELP_ALIAS_MEMBER' => 'Select the member who will receive the DKP from the Alt.',
'RT_HELP_ALIAS_EXPORT' => 'Copy the text below and paste into your favorite text editor to save.',
'RT_HELP_ALIAS_IMPORT' => 'Paste the text below to import your Alts.',
'RT_HELP_ALIAS_IMPORT_FORMAT' => 'The import is case insensitive and should be in the form',

'RT_ALIAS_DUPLICATE' => 'Duplicate found : Twinkname %s not applied to member %s',
'RT_ADD_ALIAS_SUCCESS' => 'Alt %s added for member %s.',
'RT_ALIAS_UPDATE_SUCCESS' => 'Alt %s updated for member %s. ',
'RT_NO_ALIAS_SELECTED' => 'No Alt selected.',
'RT_CONFIRM_DELETE_ALIAS' => 'Are you sure you want to delete the following Alts?',
'RT_ALIAS_DELETED' => 'Alt %s deleted from member%s.',
'RT_ALIAS_IMPORT_MISSING_MEMBER' => 'Did not create Alt %s for %s, member does not exist',

'ACTION_RT_ALIAS_ADDED' => ' Alt Added',
'ACTION_RT_ALIAS_UPDATED' => ' Alt Updated',
'ACTION_RT_ALIAS_DELETED' => ' Alt Deleted',
'RT_ALIAS_NAME_BEFORE' => 'Alt Before',
'RT_ALIAS_NAME_AFTER' => 'Alt After',

'VLOG_RT_ALIAS_ADDED' => '%s added RaidTracker Alt %s for member %s.',
'VLOG_RT_ALIAS_UPDATED' => '%s updated RaidTracker Alt %s for member %s.',
'VLOG_RT_ALIAS_DELETED' => '%s deleted RaidTracker Alt %s from member %s.',

'RT_LABEL_ALIAS_NAME' => 'Alt Name',


/*
 * Events
 * 
 */
'EVENT'	=> 'Event Name', 
'RT_TRIGGER' => 'Trigger Name',
'RT_ADMINMENU_EVENT_TRIGGERS' => 'Events',
'RT_ADMINMENU_EVENT_TRIGGERS_ADD' => 'Add Trigger',
'RT_ADMINMENU_EVENT_TRIGGERS_LIST' => 'List Triggers',
'RT_ADMINMENU_EVENT_TRIGGERS_EXPORT' => 'Export Triggers',
'RT_ADMINMENU_EVENT_TRIGGERS_IMPORT' => 'Import Triggers',

'RT_HELP_EVENT_TRIGGERS_IMPORT_FORMAT' => 'The import is case insensitive and should be in the form',
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
	
'RT_TRIGGERXML_NODATA' => 'No XML to parse', 
'RT_TRIGGERXML_INVALID' => 'Invalid XML', 
'RT_HELP_IMPORT_EVENT_TRIGGERS' => 'Paste the text below to import the DKPPool-Event triggers. If they don\'t exist yet they will be created', 
'RT_TRIGGER_CONFIRM_DELETE' => 'Are you sure you want to delete the following triggers?',
'RT_TRIGGER_NOT_SELECTED' => 'No triggers selected.',
'RT_TRIGGER_DUPLICATE' => 'Trigger %s for %s already exists.',
'RT_TRIGGER_SUCCESS_ADD' => 'Trigger %s added for %s.',
'RT_TRIGGER_FAIL_ADD' => 'Trigger %s added for %s.',
'RT_DKPPOOL_SUCCESS_ADD' => 'DKP Pool %s added. ',
'RT_DKPPOOL_FAIL_ADD' => 'DKP Pool %s NOT added. Already exists ',
'RT_EVENT_SUCCESS_ADD' => 'Event %s added. ',
'RT_EVENT_FAIL_ADD' => 'Event %s NOT added. Already exists ',

'RT_TRIGGER_SUCCESS_UPDATE' => 'Trigger updated.',
'RT_TRIGGER_SUCCESS_DELETE' => 'Trigger %s deleted for %s.',
'RT_TRIGGER_MISSING_EVENT'	=> 'This event does not exist : "%s". can\'t add trigger "%s" ', 

'RT_HELP_EVENT_TRIGGER' => "Check for Event Triggers in the Loot Notes (e.g. if you have events called ''MC (Lucifron), MC (Magmadar), ...'' only want to log one raid.)",
'RT_HELP_EVENT_TRIGGER_NAME' => 'Enter the name of the event that will be replaced with the result.',
'RT_HELP_EVENT_TRIGGER_RESULT' => 'Choose the Event to link to the trigger',

/*
 * Own Raids
 * Random Drops are normaly added to an own Raid called "Random Drop"
 * 
 */

'RT_OWN_RAID' => 'Own Raid',

'RT_ADMINMENU_OWN_RAIDS' => 'Own Raids',
'RT_ADMINMENU_OWN_RAIDS_ADD' => 'Add Own Raids',
'RT_ADMINMENU_OWN_RAIDS_LIST' => 'List Own Raids',
'RT_ADMINMENU_OWN_RAIDS_EXPORT' => 'Export Own Raids',
'RT_ADMINMENU_OWN_RAIDS_IMPORT' => 'Import Own Raids',
'RT_HELP_OWN_RAID' => 'Raid notes which should be handled as its \'own raid\' everytime, (example "Random Drops")',
'RT_HELP_OWN_RAID_NAME' => 'Enter the name of the raid that will be used.',

'RT_OWN_RAID_CONFIRM_DELETE' => 'Are you sure you want to delete the following custom raids?',
'RT_OWN_RAID_NOT_SELECTED' => 'No custom raids selected.',
'RT_OWN_RAID_DUPLICATE' => 'Custom raid %s already exists.',
'RT_OWN_RAID_SUCCESS_ADD' => 'Custom raid %s added.',
'RT_OWN_RAID_SUCCESS_UPDATE' => 'Custom raid updated.',
'RT_OWN_RAID_SUCCESS_DELETE' => 'Custom raid %s deleted.',

'RT_HELP_OWN_RAID_EXPORT' => 'Copy the text below and paste into your favorite text editor to save.',

'RT_HELP_IMPORT_RAID_TRIGGERS' => 'Paste the text below to import the Raid triggers',
'RT_HELP_OWN_RAID_IMPORT_FORMAT' => 'The import is case insensitive and should be in the form',
'RT_OWN_RAID_IMPORTSAMPLE'	=> '&lt;OwnRaids&gt;<br />
&nbsp;&nbsp;&lt;OwnRaid&gt;Random Drop&lt;/OwnRaid&gt;<br />
&lt;/OwnRaids&gt;', 


/*
 * Raid Triggers
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
'RT_FV_INVALID_XML' => 'Can\'t import XML, invalid string. Compare with sample provided.',

'RT_MEMBER_NAME_BEFORE' => 'Member Before',
'RT_MEMBER_NAME_AFTER' => 'Member After',
'RT_LABEL_MEMBER_NAME' => 'Member Name',

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
