<?php
/**
 * XML helper classes for CT_RaidTracker
 *
 * @package bbDkp.acp
 * @copyright (c) 2006, EQdkp <http://www.eqdkp.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @author Garrett Hunter <loganfive@blacktower.com>
 * $Id$
 */

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;
include_once($phpbb_root_path. 'includes/bbdkp/raidtracker/xml.' .$phpEx );

/**
 * Class for parsing CTRT XML strings
 */
class CTRT_XML 
{
	function CTRT_XML () {}

	function validateXML ($xml) {
		$xml = strtolower(html_entity_decode($xml));
		$data = XML_unserialize($xml);
		
		if ($data === NULL) 
		{
			return 0;
		} 
		else 
		{
			return 1;
		}
	}
	
	/**
	 * Parses an XML string and returns a PHP array representation. All strings are lowercased on import for consistency
     * @var string xml
	 */
	function xml_import ($xml) 
	{
		$xml = strtolower(html_entity_decode($xml));

		$data = XML_unserialize($xml);
		if ($data === NULL) 
		{
			return 0;
		} 
		else 
		{
		    return $data;
		}
	}

	/**
	 * Converts a PHP array into an XML string
     * @var array data
	 */
	function xml_export ($data) 
	{
		$xml = XML_serialize($data);
		if ($xml === NULL) 
		{
			return 0;
		} 
		else 
		{
		    return $xml;
		}
	}
}
?>
