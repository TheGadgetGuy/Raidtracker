<?php
/**
 * List CT_RaidTracker Raid Note Triggers
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
 * Display a list of raid note triggers. Provides mass delete.
 */
class Raidtracker_ListRaidNoteTriggers extends acp_dkp_rt_settings
{
    function Raidtracker_ListRaidNoteTriggers()
    {
        global $db, $user, $template, $phpEx;
       	$sql = "SELECT * FROM " . RT_RAID_NOTE_TRIGGERS_TABLE ; 
        $result = $db->sql_query($sql);
        while ( $row = $db->sql_fetchrow($result) )
    	{        
            $template->assign_block_vars('row', array(
                'ID'    	=> $row['raid_note_trigger_id'],
                'COL1'  	=> $row['raid_trigger'],
                'COL2' 		=> $row['raid'],
                'U_ADD'   	=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_add_raid_note_triggers&amp;id=" . 
                $row['raid_note_trigger_id'])
            ));
        }

        $template->assign_vars(array(
            'F_CONFIG' 			=> append_sid("index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_add_raid_note_triggers&amp;") , 
			'U_LINK' 			=> append_sid("index.$phpEx", "i=dkp_rt_settings&amp;"),
        ));
    }
}
?>