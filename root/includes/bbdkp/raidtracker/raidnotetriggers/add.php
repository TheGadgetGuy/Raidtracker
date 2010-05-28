<?php
/**
 * Add / Update RaidTracker Raid Note Triggers
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
 * This class handles raid note trigger adds & updates
 * 
 */
class Raidtracker_AddRaidNoteTrigger extends acp_dkp_rt_settings
{
    var $id;
    var $Raid = array(); 
    var $Raidtrackerlink; 

    function Raidtracker_AddRaidNoteTrigger()
    {
    	global $db, $user, $template, $phpEx;
		$this->Raidtrackerlink = '<br /><a href="'. append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;" ) . '"><h3>Return to Index</h3></a>';
		
        if(isset ($_GET['id']))
        {
        	$this->id = request_var('id', 0);	
        	$sql = "SELECT * FROM " . RT_RAID_NOTE_TRIGGERS_TABLE . ' where raid_note_trigger_id  = ' . $this->id;
	        $result = $db->sql_query($sql);
	        while ($row = $db->sql_fetchrow($result))
			{
				$this->Raid = array(
		            'raid_note_trigger_id'      => $this->id, 
		            'raid_trigger'   			=> $row['raid_trigger'],
		            'raid'  					=> $row['raid']); 
			}
	        $db->sql_freeresult($result);
	        $template->assign_vars(array(
	            'ID'          		=> $this->id,
				'V_ID'        		=> $this->id,
           		'NAME'        		=> $this->Raid['raid_trigger'],
           		'RESULT'      		=> $this->Raid['raid'],
	         ));
        }
        else
        {
          	// get from userinput $post
        	$raid_trigger = utf8_normalize_nfc(request_var('raid_trigger', ' ', true));
			$raid = utf8_normalize_nfc(request_var('raid', ' ', true));
			$sql = "SELECT * FROM " . RT_RAID_NOTE_TRIGGERS_TABLE . " where 
					raid_trigger    = '" . $db->sql_escape($raid_trigger) . "'  or   
					raid  = '" . $db->sql_escape($raid) . "'";
			 
	        $result = $db->sql_query($sql);
	        while ($row = $db->sql_fetchrow($result))
			{
				$this->Raid = array(
		            'raid_note_trigger_id'      => $row['raid_note_trigger_id'],
		            'raid_trigger'  			=> $row['raid_trigger'],
		            'raid'  					=> $row['raid']); 
			}
			
	        $db->sql_freeresult($result);
	        
	        if(sizeof($this->Raid)>0)
	        {
		        $template->assign_vars(array(
		            'ID'          		=> $this->Raid['raid_note_trigger_id'],
					'V_ID'        		=> $this->Raid['raid_note_trigger_id'],
            		'NAME'        		=> $this->Raid['raid_trigger'],
            		'RESULT'      		=> $this->Raid['raid'],
		         ));
	        }

        }
        
        
        $template->assign_vars(array(
        	'F_CONFIG' 		=> append_sid("index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_add_raid_note_triggers&amp;"),
			'U_LINK' 		=> append_sid("index.$phpEx", "i=dkp_rt_settings&amp;"),
            'S_ADD'     => ( !empty($this->id) ) ? false : true,
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
			    $raid_trigger_ids = request_var( 'raidtriggerids', array(0=>0)); 
			    $raid_trigger_names = request_var( 'raidtriggernam', ' ');
			    $raid_trigger_results = request_var( 'raidtriggerres', ' ');
			    foreach ( $raid_trigger_ids as $key => $raid_trigger_id )
				{
					$sql = 'DELETE from ' . RT_RAID_NOTE_TRIGGERS_TABLE . ' where raid_note_trigger_id = ' . $raid_trigger_id;  
					$result = $db->sql_query($sql);
				}
		    	
		    	// Append success message
		      	$success_message .= sprintf($user->lang["RT_RAID_NOTETRIGGER_SUCCESS_DELETE"], $raid_trigger_names, $raid_trigger_results) . '<br />';
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
       					$sql = "SELECT raid_note_trigger_id , raid_trigger, raid FROM " . RT_RAID_NOTE_TRIGGERS_TABLE . ' 
	   						  where raid_note_trigger_id = ' . (int) $id ; 
		       						
						$result = $db->sql_query($sql);	
						while ( $row = $db->sql_fetchrow($result) )
						{	
							$raidtriggername[] = $row['raid_trigger'];
							$raidtriggerresult[] = $row['raid'];
						}
					}
					$raidtriggernamelist = implode(', ', $raidtriggername);
					$raidtriggerresultlist = implode(', ', $raidtriggerresult);					
				}
			    	
		    	$s_hidden_fields = build_hidden_fields(array(
					'delete'	 	 => true,
		    		'raidtriggerids' => $compare_ids, 
					'raidtriggernam' => $raidtriggernamelist,
		    		'raidtriggerres' => $raidtriggerresultlist, 
					)
				);	
					
		        //display mode
		        confirm_box(false, sprintf($user->lang['RT_RAID_NOTETRIGGER_CONFIRM_DELETE'],  $raidtriggernamelist, '<br />')  , $s_hidden_fields);	
		    }       
	}

    /**
     * Update a raidnote trigger record
     */
    function process_update()
    {
		global $db, $user;
        $data = array(
    		'raid_trigger'   	=> utf8_normalize_nfc(request_var('raid_trigger', ' ', true)), 
    		'raid'  => utf8_normalize_nfc(request_var('raid', ' ', true)), 
		);
		
		// perform update
        $sql = 'UPDATE ' . RT_RAID_NOTE_TRIGGERS_TABLE . " SET 
        		raid = '" . $db->sql_escape($data['raid']) . "' 
        		raid_trigger = '" . 	$db->sql_escape($data['raid_trigger']) . "'";
        $db->sql_query($sql);
        
		$success_message = sprintf(
			$user->lang['ctrt_trigger_success_update'], 
			$data['raid_trigger'], 
			$data['raid']);
		trigger_error($success_message . $this->Raidtrackerlink, E_USER_NOTICE );
    }

    /**
     * Add raid note trigger record
     */
    function process_add()
    {
        global $db, $user;
        
        $data = array(
    		'raid_trigger'   	=> utf8_normalize_nfc(request_var('raid_trigger', ' ', true)), 
    		'raid'  => utf8_normalize_nfc(request_var('raid', ' ', true)), 
			);
		
		$sql = 'DELETE from ' . RT_RAID_NOTE_TRIGGERS_TABLE . " where raid_trigger = '" . $db->sql_escape($data['raid_trigger'])  . "'"; 
		$db->sql_query($sql);
		
		$sql = 'INSERT into ' . RT_RAID_NOTE_TRIGGERS_TABLE . ' ' . $db->sql_build_array('INSERT', $data);
		$db->sql_query($sql);
		
        $log_action = array(
            'header'                        		=> 'L_ACTION_CTRT_RAID_TRIGGER_ADDED',
            'L_CTRT_LABEL_RAID_TRIGGER_NAME'   		=> $data['raid_trigger'],
            'L_CTRT_LABEL_RAID_TRIGGER_RESULT' 		=> $data['raid'], 
            'L_ADDED_BY'                  			=> $user->data['username']);

        $this->log_insert(array(
            'log_type'   => $log_action['header'],
            'log_action' => $log_action)
        );

        $message = sprintf(
        	$user->lang['RT_TRIGGER_SUCCESS_ADD'], 
        	$data['raid_trigger'], 
        	$data['raid']); 
        trigger_error($message . $this->Raidtrackerlink , E_USER_NOTICE);
    }


}
?>
