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
	'RT_PARSE' 			=> 'Raidtracker XML Parse',
	'RT_PARSE_EXPLAIN'  => 'Hier werden die XML Dateiten vom Game verarbeitet unf in Zwischentabelle gelagert.', 	
	'RT_IMPORT' 		=> 'RaidTracker Importierung',
	'RT_IMPORT_EXPLAIN' => 'Importiert Raids, Items und Mitglieder im DKP System',  
	'RT_IMPORTLOG' 		=> 'Importieren',
	'RT_DELETE' 		=> 'Raid löschen',  
));

?>