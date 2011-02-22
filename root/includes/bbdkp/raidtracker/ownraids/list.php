<?php
/**
 * List RaidTracker Own Raids
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
 * Display a list of own raids. Provides mass delete.
 */
class Raidtracker_ListOwnRaids extends acp_dkp_rt_settings
{
    function Raidtracker_ListOwnRaids()
    {
        global $phpbb_admin_path, $db, $user, $template, $phpEx;
       	$sql = "SELECT * FROM " . RT_OWN_RAIDS_TABLE ; 
        $result = $db->sql_query($sql);
        while ( $row = $db->sql_fetchrow($result) ) 
        {
            $template->assign_block_vars('row', array(
                'ID'    	=> $row['own_raid_id'],
                'COL1' 		=> $row['own_raid_name'],
				'U_ADD'  	=> append_sid ( "{$phpbb_admin_path}index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_add_own_raids&amp;id=" . $row['own_raid_id'])
            ));
        }

        $template->assign_vars(array(
            'F_CONFIG' 			=> append_sid("{$phpbb_admin_path}index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_add_own_raids"), 
			'U_LINK' 			=> append_sid("{$phpbb_admin_path}index.$phpEx", "i=dkp_rt_settings&amp;"),
        ));
        
    }

}
?>
