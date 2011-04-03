<?php
/**
 * Export CT_RaidTracker Event Triggers
 *
 * @author Sajaki@bbdkp.com
 * @package bbDkp.acp
 * @copyright 2010 bbdkp <http://code.google.com/p/bbdkp/>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * $Id$
 * 
 */

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * This class exports event triggers
 * acp_dkp_rt_settings
 */
class Raidtracker_ExportEventTriggers extends acp_dkp_rt_settings 
{

    function Raidtracker_ExportEventTriggers()
    {
        global $db, $phpbb_admin_path, $user, $template, $phpEx;
		$parser = new CTRT_XML();
		$eventTrigger = array(); 
		
        $sql = 'SELECT a.event_trigger_id, a.event_trigger, c.dkpsys_name  , 
				a.event_id, b.event_name from ' . RT_EVENT_TRIGGERS_TABLE . ' a, ' . EVENTS_TABLE . ' b , ' . DKPSYS_TABLE . ' c 
				where a.event_id = b.event_id 
				and b.event_dkpid = c.dkpsys_id
				order by b.event_dkpid, b.event_name
				';
        
        $result = $db->sql_query($sql);
        while ( $row = $db->sql_fetchrow($result) ) 
        {
			$eventTrigger[] = array(
				'trigger'	=> 	$row['event_trigger'],
				'resultpool'	=>	$row['dkpsys_name'], 
				'resultevent'	=>	$row['event_name']
			);
        }
		$db->sql_freeresult($result); 
		
		$exportXML = $parser->xml_export(
			array(
				'EventTriggers'	=>	array(	'EventTrigger' 	=>	$eventTrigger )
		));
		
		$template->assign_vars(array(
            'EXPORT'        	=> htmlentities($exportXML),
			'U_LINK' 			=> append_sid("{$phpbb_admin_path}index.$phpEx", "i=dkp_rt_settings&amp;"),
        ));
    }
}
?>
