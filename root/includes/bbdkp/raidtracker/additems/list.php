<?php
/**
 * List CT_RaidTracker Add Items
 *
*  @author Sajaki@bbdkp.com
*  @package bbDkp.acp
 * @copyright (c) 2006, EQdkp <http://www.edqkp.com>
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
 * Display a list of items. Provides mass delete.
 * ManageCTRT
 */
class Raidtracker_ListAddItems extends acp_dkp_rt_settings
{
	var $link; 
	
    function Raidtracker_ListAddItems()
    {
		global $db, $user, $template, $phpEx;

        $sql =   "SELECT add_items_id, add_items_wow_id FROM " . RT_ADD_ITEMS_TABLE . ' ORDER BY add_items_wow_id ';
        $result = $db->sql_query($sql);
        while ( $row = $db->sql_fetchrow($result) )
        {
			$template->assign_block_vars('row', array(
                'ID'    	=> $row['add_items_id'],
                'COL1' 		=> $row['add_items_wow_id'],
				'U_ADD'		=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_add_items&amp;id=" . $row['add_items_id']),
            ));
        }
        $db->sql_freeresult($result);

        $template->assign_vars(array(
        	'F_CONFIG'			=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_add_items"), 
        ));
    }

}
?>
