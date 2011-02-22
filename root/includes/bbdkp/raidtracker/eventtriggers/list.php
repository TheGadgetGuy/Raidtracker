<?php
/**
 * List RaidTracker Event Triggers
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
 * Display a list of event triggers. Provides mass delete.
 * ManageCTRT
 */
class Raidtracker_ListEventTriggers extends acp_dkp_rt_settings
{
    function Raidtracker_ListEventTriggers()
    {
        global $phpbb_admin_path, $db, $user, $template, $phpEx;

        $sql = 'SELECT a.event_trigger_id, a.event_trigger, c.dkpsys_name, 
				a.event_id, b.event_name from ' . RT_EVENT_TRIGGERS_TABLE . ' a, ' . EVENTS_TABLE . ' b , ' . DKPSYS_TABLE . ' c 
				where a.event_id = b.event_id 
				and b.event_dkpid = c.dkpsys_id
				order by b.event_dkpid, b.event_name
				';
        $result = $db->sql_query($sql);
        while ( $row = $db->sql_fetchrow($result) ) 
        {
            $template->assign_block_vars('row', array(
                'ID'    	=> $row['event_trigger_id'],
                'COL1'  	=> $row['event_trigger'],
                'COL2' 		=> $row['event_name'],
            	'COL3' 		=> $row['dkpsys_name'],
				'U_ADD'  	=> append_sid ( "{$phpbb_admin_path}index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_add_event_triggers&amp;id=" . $row['event_trigger_id'])
            ));
        }

        $template->assign_vars(array(
            // Form vars
            'F_CONFIG' 			=> append_sid("{$phpbb_admin_path}index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_add_event_triggers"), 
			'U_LINK' 			=> append_sid("{$phpbb_admin_path}index.$phpEx", "i=dkp_rt_settings&amp;"),
        ));
        
    }

}
?>
