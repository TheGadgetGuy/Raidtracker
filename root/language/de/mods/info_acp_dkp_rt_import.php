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
	'RT_PARSE' 			=> 'Raidtracker Processing',
	'RT_PARSE_EXPLAIN'  => 'Parses XML files from game and imports the data into temporary tables for later processing.', 	
	'RT_IMPORT' 		=> 'RaidTracker Import',
	'RT_IMPORT_EXPLAIN' => 'Imports Raids, Items and Members into the DKP system',  
	'RT_IMPORTLOG' 		=> 'Manage Imports',
	'RT_DELETE' 		=> 'Delete Parsed raid',  
));

?>