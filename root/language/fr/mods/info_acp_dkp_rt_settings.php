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
	'RTSETTINGS'	=> 'Règlages RaidTracker',  
	'RTSETTINGS_EXPLAIN' => 'Règlages Raidtracker, Objets ignorés, Alts, Triggers Evènements, Triggers Raid et Troggers Own Raid', 
	'RT_ADDITEMS'	=> 'Ajouter objets',
	'RT_LISITEMS'	=> 'Liste objets',
	'RT_EXPITEMS'	=> 'Exporter objets',
	'RT_IMPITEMS'	=> 'Importer objets',
	'RT_ADDALIAS'	=> 'Ajouter Alts',
	'RT_LISALIAS'	=> 'Liste Alts',
	'RT_EXPALIAS'	=> 'Exporter Alts',
	'RT_IMPALIAS'	=> 'Importer Alts',
	'RT_ADDEVTRIG'	=> 'Ajouter trigger evénement',
	'RT_LISEVTRIG'	=> 'Liste trigger evénement',
	'RT_EXPEVTRIG'	=> 'Exporter trigger evénement',
	'RT_IMPEVTRIG'	=> 'Importer trigger evénement',
	'RT_ADDIGNORE'	=> 'Ajouter objet ignoré',
	'RT_LISIGNORE'	=> 'Liste objets ignorés',
	'RT_EXPIGNORE'	=> 'Exporter objets ignorés',
	'RT_IMPIGNORE'	=> 'Importer objet ignoré',
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