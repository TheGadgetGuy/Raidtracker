<?php
/**
 * List CT_RaidTracker Ignore Items
 *
 * @author Sajaki@bbdkp.com
 * @package bbDkp.acp
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
 * Display a list of items. Provides mass delete.
 * ManageCTRT
 */
class Raidtracker_ListIgnoreItems extends acp_dkp_rt_settings
{
	var $link; 
	
    function Raidtracker_ListIgnoreItems()
    {
		global $phpbb_admin_path, $db, $user, $template, $phpEx;

        $sql =   "SELECT ignore_items_id, ignore_items_wow_id FROM " . RT_IGNORE_ITEMS_TABLE . ' ORDER BY ignore_items_wow_id ';
        $result = $db->sql_query($sql);
        while ( $row = $db->sql_fetchrow($result) )
        {
			$template->assign_block_vars('row', array(
                'ID'    	=> $row['ignore_items_id'],
                'COL1' 		=> $row['ignore_items_wow_id'],
				'U_ADD'		=> append_sid ( "{$phpbb_admin_path}index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_add_ignore_items&amp;id=" . $row['ignore_items_id']),
            ));
        }
        $db->sql_freeresult($result);

        $template->assign_vars(array(
        	'F_CONFIG'			=> append_sid ( "{$phpbb_admin_path}index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_add_ignore_items"), 
        ));
    }

}
?>
