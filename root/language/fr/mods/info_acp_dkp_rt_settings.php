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
	'RTSETTINGS_EXPLAIN' => 'Règlages Raidtracker, déclencheurs d\' Objets ignorés, Alts, Evènements, Notes de Raid et Raids Particuliers', 
	'RT_ADDITEMS'	=> 'Ajouter objets permanents',
	'RT_LISITEMS'	=> 'Liste objets permanents',
	'RT_EXPITEMS'	=> 'Exporter objets permanents',
	'RT_IMPITEMS'	=> 'Importer objets permanents',
	'RT_ADDALIAS'	=> 'Ajouter Alts',
	'RT_LISALIAS'	=> 'Liste Alts',
	'RT_EXPALIAS'	=> 'Exporter Alts',
	'RT_IMPALIAS'	=> 'Importer Alts',
	'RT_ADDEVTRIG'	=> 'Ajouter déclencheur evénement',
	'RT_LISEVTRIG'	=> 'Liste déclencheur evénement',
	'RT_EXPEVTRIG'	=> 'Exporter déclencheur evénement',
	'RT_IMPEVTRIG'	=> 'Importer déclencheur evénement',
	'RT_ADDIGNORE'	=> 'Ajouter objet ignoré',
	'RT_LISIGNORE'	=> 'Liste objets ignorés',
	'RT_EXPIGNORE'	=> 'Exporter objets ignorés',
	'RT_IMPIGNORE'	=> 'Importer objet ignoré',
	'RT_ADDOWNRAID'	=> 'Ajouter déclencheur de Raid particulier',
	'RT_LISOWNRAID'	=> 'Liste déclencheur de Raid particulier',
	'RT_EXPOWNRAID'	=> 'Exporter déclencheur de Raid particulier',
	'RT_IMPOWNRAID'	=> 'Importer déclencheur de Raid particulier',
	'RT_ADDRAIDTRIG'=> 'Ajouter déclencheur de note de Raid',
	'RT_LISRAIDTRIG'=> 'Liste déclencheur de note de Raid',
	'RT_EXPRAIDTRIG'=> 'Exporter déclencheur de note de Raid',
	'RT_IMPRAIDTRIG'=> 'Importer déclencheur de  Raid Note Triggers',
));

?>