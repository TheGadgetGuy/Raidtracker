<?php
/**
 * Import RaidTracker Member Aliases
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
 * This class imports one or multiple aliases
 * ManageCTRT
 */
class Raidtracker_ImportAliases extends acp_dkp_rt_settings  
{
    var $Raidtrackerlink; 

    function Raidtracker_ImportAliases()
    {
 		global $phpbb_admin_path, $phpEx; 
        $this->Raidtrackerlink = '<br /><a href="'. append_sid ( "{$phpbb_admin_path}index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_list_alias" ) . '"><h3>Return to Index</h3></a>';
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

        $aliases = $this->xmlparse($xml); 
        $aliases = (array) $aliases[0]; 

        foreach ($aliases as $alias) 
        {
        	$alias = (array) $alias; 
			
			foreach ($alias as $alt) 
        	{
        		$alt = (array) $alt; 
	            /**
	             * The member name must exist
	             */
	            $sql = "SELECT member_id, member_name
	                    FROM " . MEMBER_LIST_TABLE ."
	                    WHERE lower(member_name) = '". $db->sql_escape($alt['member']) ."'";
	            $result = $db->sql_query($sql);	
	            		
				while ( $row = $db->sql_fetchrow($result) )
				{
					$member_id = $row['member_id'];
				}
	
	            if ( isset($member_id) ) 
	            {
	                /**
	                 * Member name exists; insert the record
	                 */
					$sql = 'DELETE from ' . RT_ALIASES_TABLE . " where alias_name = '" . $db->sql_escape($alt['alias']) . "'"; 
					$db->sql_query($sql);
					
				    $data = array(
			    		'alias_member_id'   => $member_id, 
			    		'alias_name'     	=> $alt['alias'], 
					);
					
					$sql = 'INSERT INTO ' . RT_ALIASES_TABLE .  ' ' .  $db->sql_build_array('INSERT', $data); 
					$db->sql_query($sql);
	
					$message .= sprintf($user->lang['RT_ADD_ALIAS_SUCCESS']."<br />", ucwords($alt['alias']),$alt['member']);
	            } 
	            else 
	            {
	            	$errors +=1; 
	                $message .= sprintf($user->lang['RT_ALIAS_IMPORT_MISSING_MEMBER']."<br />",ucwords($alt['alias']),$alt['member']);
	            }
        	}
        }
        
        if ($errors > 0)
        {
        	trigger_error($message . $this->Raidtrackerlink, E_USER_WARNING);
        }
        else
        {
        	trigger_error($message . $this->Raidtrackerlink, E_USER_NOTICE);
        }
        

    }

}
?>
