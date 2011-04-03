<?php
/**
 * Add / Update RaidTracker Own Raids
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
 * This class handles own raid add & update
 * 
 */
class Raidtracker_AddOwnRaid extends acp_dkp_rt_settings
{
    var $raid = array();
    var $id;
    var $Raidtrackerlink; 
    var $ownraid; 
    
    function Raidtracker_AddOwnRaid()
    {
    	global $db, $user, $template, $phpbb_admin_path, $phpEx;
		$this->Raidtrackerlink = '<br /><a href="'. append_sid ( "{$phpbb_admin_path}index.$phpEx", "i=dkp_rt_settings&amp;" ) . '"><h3>Return to Index</h3></a>';
        if(isset ($_GET['id']))
        {
        	// get from $get if clicked in list
        	$this->id = request_var('id', 0);	
        	$sql = "SELECT * FROM " . RT_OWN_RAIDS_TABLE . ' where own_raid_id  = ' . $this->id;
	        $result = $db->sql_query($sql);
	        while ($row = $db->sql_fetchrow($result))
			{
				$this->ownraid = array(
		            'own_raid_id'      => $this->id, 
		            'own_raid_name'   	=> $row['own_raid_name']
				); 
			}
	        $db->sql_freeresult($result);
        }
        else
        {
          	// get from userinput $post
        	$own_raid = utf8_normalize_nfc(request_var('own_raid_name', ' ', true));
			$sql = "SELECT * FROM " . RT_OWN_RAIDS_TABLE . " where 
					own_raid_name  = '" . $db->sql_escape($own_raid) . "'";
	        $result = $db->sql_query($sql);
	        while ($row = $db->sql_fetchrow($result))
			{
				$this->ownraid = array(
		            'own_raid_id'     => $row['own_raid_id'],
		            'own_raid_name'   => $row['own_raid_name']); 
		           
			}
	        $db->sql_freeresult($result);

        }

		 $template->assign_vars(array(
		 	'ID'        => $this->ownraid['own_raid_id'], 
    		'NAME'		=> $this->ownraid['own_raid_name'], 
            'F_CONFIG' 	=> append_sid ( "{$phpbb_admin_path}index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_add_own_raids&amp;"),
            'S_ADD'   	=> ( !empty($this->id) ) ? false : true,
        ));
   
    }
    
    /**
     * Process Delete (confirmed)
     */
    function process_delete()
    {
    	global $db, $user;
    	    // check mode
		    if (confirm_box(true))
		    {
			    $ownraidids = request_var( 'own_raid_id', array(0=>0)); 
			    $ownraidnames = utf8_normalize_nfc(request_var('own_raid_name', ' ', true));
			    foreach ( $ownraidids as $key => $ownraidid )
				{
					$sql = 'DELETE from ' . RT_OWN_RAIDS_TABLE . ' where own_raid_id = ' . $ownraidid;  
					$result = $db->sql_query($sql);
				}
		    	
		    	// Append success message
		      	$success_message .= sprintf($user->lang['RT_OWN_RAID_SUCCESS_DELETE'], $ownraidnames) . '<br />';
		        // Success message
		        trigger_error($success_message . $this->Raidtrackerlink , E_USER_NOTICE);
		    }
		    else
		    {
			    if ( isset($_POST['compare_ids']) )
				{
				    $compare_ids = request_var('compare_ids', array(0 => 0));
					foreach ($compare_ids as $id)
					{
       					$sql = "SELECT own_raid_id , own_raid_name FROM " . RT_OWN_RAIDS_TABLE . ' 
	   						  where own_raid_id = ' . (int) $id ; 
		       						
						$result = $db->sql_query($sql);	
						while ( $row = $db->sql_fetchrow($result) )
						{	
							$own_raid_name[] = $row['own_raid_name'];
						}
					}
					$own_raid_namelist = implode(', ', $own_raid_name);
				}
			    	
		    	$s_hidden_fields = build_hidden_fields(array(
					'delete'	 		=> true,
		    		'own_raid_id'	 	=> $compare_ids, 
					'own_raid_name' 	=> $own_raid_namelist,
		    		
					)
				);	

		        confirm_box(false, $user->lang['RT_OWN_RAID_CONFIRM_DELETE'] . ' <br />  ' . $own_raid_namelist  , $s_hidden_fields);	
		    }  
    }


    /**
     * Update an own raid record
     */
    function process_update()
    {
		global $db, $user;
        
  		$own_raid_name   = utf8_normalize_nfc(request_var('own_raid_name', ' ', true));  
		
		// check if own raid exists
        $sql =   "SELECT count(own_raid_name) as checkval from " . RT_OWN_RAIDS_TABLE . " 
        		  WHERE own_raid_name = '" . $db->sql_escape($own_raid_name) . "'"; 
	  	$result = $db->sql_query($sql);
	  	
		if($db->sql_fetchfield('checkval') != 0) 
		{
			$db->sql_freeresult($result);  
			return;
		}
        
		// perform update
        $sql = 'UPDATE ' . RT_OWN_RAIDS_TABLE . " SET 
        		own_raid_name = '" . $db->sql_escape( $own_raid_name ) . "' 
        		where own_raid_name = '" . $db->sql_escape( $own_raid_name ) . "'";
        $db->sql_query($sql);
        
		$success_message = $user->lang['RT_OWN_RAID_SUCCESS_UPDATE'];
		trigger_error($success_message . $this->Raidtrackerlink, E_USER_NOTICE );
    }
    
    /**
     * Add an own raid record
     */
    function process_add()
    {
    	global $db, $user;
    	
        $data = array(
 		'own_raid_name'   	=> utf8_normalize_nfc(request_var('own_raid_name', ' ', true)), 
		);
			
		$sql = 'DELETE from ' . RT_OWN_RAIDS_TABLE . " where own_raid_name = '" . $db->sql_escape($data['own_raid_name'])  . "'"; 
		$db->sql_query($sql);
			
		$sql = 'INSERT into ' . RT_OWN_RAIDS_TABLE . ' ' . $db->sql_build_array('INSERT', $data);
		$db->sql_query($sql);
			
		$log_action = array(
		    'header'                      => 'L_ACTION_CTRT_OWN_RAID_ADDED',
		    'L_CTRT_LABEL_OWN_RAID_NAME'  => $data['own_raid_name'],
		    'L_ADDED_BY'                  => $user->data['username']);
		
		$this->log_insert(array(
		    'log_type'   => $log_action['header'],
		    'log_action' => $log_action)
		);
		
        $message = sprintf($user->lang['RT_OWN_RAID_SUCCESS_ADD'], $data['own_raid_name']); 
        trigger_error($message . $this->Raidtrackerlink , E_USER_NOTICE);

    }

}
?>
