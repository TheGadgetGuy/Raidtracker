<?php
/**
 * Export RaidTracker Add Items
 *
*  @author Sajaki@bbdkp.com
*  @package bbDkp.acp
 * @copyright 2010 bbdkp <http://code.google.com/p/bbdkp/>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * $Id$
 */

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}


/**
 * This class exports ignore items
 * ManageCTRT
 */
class Raidtracker_ExportIgnoreItem extends acp_dkp_rt_settings 
{
    function Raidtracker_ExportIgnoreItem()
    {
        global $db, $user, $template, $phpEx;
        $parser = new CTRT_XML();
	
		$sql =   "SELECT ignore_items_id, ignore_items_wow_id FROM " . RT_IGNORE_ITEMS_TABLE . ' ORDER BY ignore_items_wow_id ';
        $result = $db->sql_query($sql);
        
        $temp = array();
        while ( $row = $db->sql_fetchrow($result))
        {
        	$temp[] = $row["ignore_items_wow_id"];
        }
		
		$exportXML = $parser->xml_export(
			array(
				'IgnoreItems'	=>	array( 'IgnoreItem'	=>	$temp)));
		
        $template->assign_vars(array(
			'U_LINK' 		=> append_sid("index.$phpEx", "i=dkp_rt_settings&amp;"),
            'EXPORT'        => htmlentities($exportXML),
        ));

    }
}

?>
