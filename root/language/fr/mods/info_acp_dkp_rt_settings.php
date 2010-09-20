<?php
/**
 * bbdkp acp language file for mainmenu - Francais
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
	'RTSETTINGS'	=> 'R�glages RaidTracker',  
	'RTSETTINGS_EXPLAIN' => 'R�glages Raidtracker, Objets ignor�s, Alts, Triggers Ev�nements, Triggers Raid et Troggers Own Raid', 
	'RT_ADDITEMS'	=> 'Ajouter objets',
	'RT_LISITEMS'	=> 'Liste objets',
	'RT_EXPITEMS'	=> 'Exporter objets',
	'RT_IMPITEMS'	=> 'Importer objets',
	'RT_ADDALIAS'	=> 'Ajouter Alts',
	'RT_LISALIAS'	=> 'Liste Alts',
	'RT_EXPALIAS'	=> 'Exporter Alts',
	'RT_IMPALIAS'	=> 'Importer Alts',
	'RT_ADDEVTRIG'	=> 'Ajouter trigger ev�nement',
	'RT_LISEVTRIG'	=> 'Liste trigger ev�nement',
	'RT_EXPEVTRIG'	=> 'Exporter trigger ev�nement',
	'RT_IMPEVTRIG'	=> 'Importer trigger ev�nement',
	'RT_ADDIGNORE'	=> 'Ajouter objet ignor�',
	'RT_LISIGNORE'	=> 'Liste objets ignor�s',
	'RT_EXPIGNORE'	=> 'Exporter objets ignor�s',
	'RT_IMPIGNORE'	=> 'Importer objet ignor�',
	'RT_ADDOWNRAID'	=> 'Ajouter Own Raids',
	'RT_LISOWNRAID'	=> 'Liste Own Raids',
	'RT_EXPOWNRAID'	=> 'Exporter Own Raids',
	'RT_IMPOWNRAID'	=> 'Importer Own Raids',
	'RT_ADDRAIDTRIG'=> 'Ajouter trigger Raid',
	'RT_LISRAIDTRIG'=> 'Liste trigger Raid',
	'RT_EXPRAIDTRIG'=> 'Exporter Raid Note Triggers',
	'RT_IMPRAIDTRIG'=> 'Importer Raid Note Triggers',
));

?>