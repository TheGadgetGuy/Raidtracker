<?php
/**
 * Export CT_RaidTracker Raid Note Triggers
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
 * This class exports Raid note triggers
 * acp_dkp_rt_settings
 */
class Raidtracker_ExportRaidnoteTriggers extends acp_dkp_rt_settings 
{
    function Raidtracker_ExportRaidnoteTriggers()
    {
        global $db, $user, $phpbb_admin_path, $template, $phpEx;
		$parser = new CTRT_XML();
		$sql = "SELECT * FROM " . RT_RAID_NOTE_TRIGGERS_TABLE; 
        
		$RaidTrigger = array();
		
        $result = $db->sql_query($sql);
        while ($row = $db->sql_fetchrow($result)) 
        {
			$RaidTrigger[] = array(
				'trigger'	=> 	$row['raid_trigger'],
				'result'	=>	$row['raid']);
        }
		
		$exportXML = $parser->xml_export(
			array(
				'RaidnoteTriggers'	=>	array(	'RaidNoteTrigger' 	=>	$RaidTrigger )
		));
		
		$template->assign_vars(array(
            'EXPORT'        	=> htmlentities($exportXML),
			'U_LINK' 			=> append_sid("{$phpbb_admin_path}index.$phpEx", "i=dkp_rt_settings&amp;"),
        ));
    }
}


?>