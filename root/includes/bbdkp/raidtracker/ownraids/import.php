<?php
/**
 * Import RaidTracker Own Raids
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
 * This class imports own raids
 * ManageCTRT
 */
class Raidtracker_ImportOwnRaids extends acp_dkp_rt_settings
{
    function Raidtracker_ImportOwnRaids()
    {
    	global $phpEx; 
        $this->Raidtrackerlink = '<br /><a href="'. append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_list_own_raids" ) . '"><h3>Return to Index</h3></a>';
    }

    /**
     * Import the own raid xml 
     */
    function process_import () 
    {
        global $db, $user;
        $message = "";
        
        $xml = utf8_normalize_nfc(request_var('xml', ' ', true));         
        $xml = str_replace ("&", "and", html_entity_decode($xml));  

        $ownRaids = $this->xmlparse($xml); 
        $count = 0; 
        foreach ($ownRaids->OwnRaid as $ownraid) 
        {
        		$ownraid = (string) $ownraid;
        		
        		if (strlen($ownraid) > 0 )
        		{
					$sql = 'DELETE from ' . RT_OWN_RAIDS_TABLE . " where own_raid_name = '" . $db->sql_escape($ownraid)  . "'"; 
					$db->sql_query($sql);
						
					$data = array(
			    		'own_raid_name' => $ownraid,
					);
						
					$sql = 'INSERT into ' . RT_OWN_RAIDS_TABLE . ' ' . $db->sql_build_array('INSERT', $data);
					$db->sql_query($sql);
					
					$message .= sprintf($user->lang['RT_OWN_RAID_SUCCESS_ADD'], $ownraid); 
					$count++;
        		}
		}
		
		if($count >0)
		{
			trigger_error($message . $this->Raidtrackerlink , E_USER_NOTICE);	
		}
		else 
		{
			trigger_error($user->lang['RT_OWN_RAID_FAIL_ADD'] . $this->Raidtrackerlink , E_USER_WARNING);
		}
        
    }

}

?>