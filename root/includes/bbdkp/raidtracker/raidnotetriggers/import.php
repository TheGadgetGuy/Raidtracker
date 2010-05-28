<?php
/**
 * Import RaidTracker Raid Note Triggers
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
 * This class imports raid note triggers
 * ManageCTRT
 */
class Raidtracker_ImportRaidNoteTriggers extends acp_dkp_rt_settings 
{

    function Raidtracker_ImportRaidNoteTriggers()
    {
    	global $phpEx; 
        $this->Raidtrackerlink = '<br /><a href="'. append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_list_raid_note_triggers" ) . '"><h3>Return to Index</h3></a>';
    }

    /**
     * Import the aliases
     */
    function process_import () 
    {
        global $db, $user;
        $message = "";

        $xml = utf8_normalize_nfc(request_var('xml', ' ', true));         
        $xml = str_replace ("&", "and", html_entity_decode($xml));  

        $RaidnoteTriggers = $this->xmlparse($xml); 
        $count = 0; 
        
        foreach ($RaidnoteTriggers->RaidNoteTrigger as $RaidNoteTrigger) 
        {
        	$RaidNoteTrigger = (array) $RaidNoteTrigger; 
        	
        	if (strlen($RaidNoteTrigger['trigger'])> 0 && strlen($RaidNoteTrigger['result'])> 0 )
        	{
				$sql = 'DELETE from ' . RT_RAID_NOTE_TRIGGERS_TABLE . " where raid_trigger = '" . $db->sql_escape($RaidNoteTrigger['trigger'])  . "'"; 
				$db->sql_query($sql);
				
			    $data = array(
		    		'raid_trigger'   => trim($RaidNoteTrigger['trigger']), 
		    		'raid' 		  	 => trim($RaidNoteTrigger['result']),
				);
	
				$sql = 'INSERT into ' . RT_RAID_NOTE_TRIGGERS_TABLE . ' ' . $db->sql_build_array('INSERT', $data);
				$db->sql_query($sql);
				
				$message .= sprintf(
					$user->lang['RT_RAID_NOTETRIGGER_SUCCESS_ADD'], 
					$RaidNoteTrigger['trigger'], 
					$RaidNoteTrigger['result'] ) . '<br />'; 
					
				$count++;
        	}
		}
		
		if ($count > 0)
		{
	        trigger_error($message . $this->Raidtrackerlink, E_USER_NOTICE);
		}
		else 
		{
			trigger_error($user->lang['RT_RAID_NOTETRIGGER_FAIL_ADD']. $this->Raidtrackerlink, E_USER_WARNING);
		}
		

    }

}
?>
