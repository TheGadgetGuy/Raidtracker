<?php
/**
 * bbdkp acp language file for mainmenu - Français
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
	'RT_PARSE' 			=> 'Traitement XML',
	'RT_PARSE_EXPLAIN'  => 'Traite les fichiers XML files de CT_Raidtracker ou Headcount et les importe dans les tables temporaires pour processing ulterieur.', 	
	'RT_IMPORT' 		=> 'Importation',
	'RT_IMPORT_EXPLAIN' => 'Importe les Raids, Objets et Membres dans le système DKP',  
	'RT_IMPORTLOG' 		=> 'Gère les Importations',
	'RT_DELETE' 		=> 'Supprimer Raid temporaire',  
));

?>