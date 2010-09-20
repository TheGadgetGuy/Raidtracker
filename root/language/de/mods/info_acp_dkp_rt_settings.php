<?php
/**
 * bbdkp acp language file for mainmenu
 * 
 * @package bbDkp
 * @copyright 2009 bbdkp <http://code.google.com/p/bbdkp/>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version $Id$
 * 
 */

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

// Create the lang array if it does not already exist
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// Merge the following language entries into the lang array
$lang = array_merge($lang, array(
	'RTSETTINGS'	=> 'RaidTracker Settings',  
	'RTSETTINGS_EXPLAIN' => 'General Raidtracker settings, add/ignored items, Alts, Event Triggers, Raid triggers and Own raids', 
	'RT_ADDITEMS'	=> 'Add Items',
	'RT_LISITEMS'	=> 'List Items',
	'RT_EXPITEMS'	=> 'Export Items',
	'RT_IMPITEMS'	=> 'Import Items',
	'RT_ADDALIAS'	=> 'Add Alts',
	'RT_LISALIAS'	=> 'List Alts',
	'RT_EXPALIAS'	=> 'Export Alts',
	'RT_IMPALIAS'	=> 'Import Alts',
	'RT_ADDEVTRIG'	=> 'Add Event Triggers',
	'RT_LISEVTRIG'	=> 'List Event Triggers',
	'RT_EXPEVTRIG'	=> 'Export Event Triggers',
	'RT_IMPEVTRIG'	=> 'Import Event Triggers',
	'RT_ADDIGNORE'	=> 'Add Ignore Items',
	'RT_LISIGNORE'	=> 'List Ignore Items',
	'RT_EXPIGNORE'	=> 'Export Ignore Items',
	'RT_IMPIGNORE'	=> 'Import Ignore Items',
	'RT_ADDOWNRAID'	=> 'Add Own Raids',
	'RT_LISOWNRAID'	=> 'List Own Raids',
	'RT_EXPOWNRAID'	=> 'Export Own Raids',
	'RT_IMPOWNRAID'	=> 'Import Own Raids',
	'RT_ADDRAIDTRIG'=> 'Add Raid Note Triggers',
	'RT_LISRAIDTRIG'=> 'List Raid Note Triggers',
	'RT_EXPRAIDTRIG'=> 'Export Raid Note Triggers',
	'RT_IMPRAIDTRIG'=> 'Import Raid Note Triggers',
));

?>