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
 * This class exports add items
 * ManageCTRT
 */
class Raidtracker_ExportAddItem extends acp_dkp_rt_settings 
{
    function Raidtracker_ExportAddItem()
    {
        global $db, $user, $template, $phpbb_admin_path, $phpEx;
        $parser = new CTRT_XML();
	
		$sql =   "SELECT add_items_id, add_items_wow_id FROM " . RT_ADD_ITEMS_TABLE . ' ORDER BY add_items_wow_id ';
        $result = $db->sql_query($sql);
        
        $temp = array();
        while ( $row = $db->sql_fetchrow($result))
        {
        	$temp[] = $row["add_items_wow_id"];
        }
		
		$exportXML = $parser->xml_export(array("AddItems"=>array("AddItem"=>$temp)));
		
        $template->assign_vars(array(
        	// Form values
            'EXPORT'        => htmlentities($exportXML),
			'U_LINK' 		=> append_sid("{$phpbb_admin_path}index.$phpEx", "i=dkp_rt_settings&amp;"),
        ));

    }
}

?>
