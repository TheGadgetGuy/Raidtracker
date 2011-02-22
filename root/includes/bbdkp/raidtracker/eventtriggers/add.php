<?php
/**
 * Add / Update CT_RaidTracker Event Triggers
 *
 *  @author Sajaki@bbdkp.com
 *  @package bbDkp.acp
 *  @copyright 2010 bbdkp <http://code.google.com/p/bbdkp/>
 *  @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *  $Id$
 */


/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * This class handles event trigger add & update
 * ManageCTRT
 */
class Raidtracker_AddEventTrigger  extends acp_dkp_rt_settings
{
    var $id;
    var $event = array(); 
    var $Raidtrackerlink; 

    function Raidtracker_AddEventTrigger()
    {
        global $phpbb_admin_path, $db, $user, $template, $phpEx;
		$this->Raidtrackerlink = '<br /><a href="'. append_sid ( "{$phpbb_admin_path}index.$phpEx", "i=dkp_rt_settings&amp;" ) .
			 '"><h3>Return to Index</h3></a>';
        
		if(isset ($_GET['id']))
        {
        	// get from $get if clicked in list
        	$this->id = request_var('id', 0);	
        	$sql = "SELECT * FROM " . RT_EVENT_TRIGGERS_TABLE . ' where event_trigger_id  = ' . $this->id;
	        $result = $db->sql_query($sql);
	        while ($row = $db->sql_fetchrow($result))
			{
				$this->event = array(
		            'event_trigger_id'  => $this->id, 
		            'event_trigger' 	=> $row['event_trigger'],
		            'event_id'  		=> $row['event_id']); 
			}
	        $db->sql_freeresult($result);
	        $template->assign_vars(array(
	            'ID'          		=> $this->id,
	        	'NAME'        		=> $this->event['event_trigger'],
	        	'RESULT'      		=> $this->event['event_id'],
	              ));
        }
        else
        {
          	// get from userinput $post
        	$event_trigger 	= utf8_normalize_nfc(request_var('event_trigger', ' ', true));
			$event_id 		=  request_var('event_id', 0);
			
			$sql = "SELECT * FROM " . RT_EVENT_TRIGGERS_TABLE . " where 
					event_trigger    = '" . $db->sql_escape($event_trigger) . "'  or   
					event_id		 = " .  $event_id;
	        $result = $db->sql_query($sql);

	        while ($row = $db->sql_fetchrow($result))
			{
				$this->event = array(
		            'event_trigger_id'  => $row['event_trigger_id'],
		            'event_trigger'  	=> $row['event_trigger'],
		            'event_id' 			=> $row['event_id']); 
			}
			
	        $db->sql_freeresult($result);
	        if(sizeof($this->event) > 0)
	        {
		        $template->assign_vars(array(
		            'ID'          		=> $this->event['event_trigger_id'],
		        	'NAME'        		=> $this->event['event_trigger'],
		        	'RESULT'      		=> $this->event['event_id'],
		         ));
	        }

        }
        
        /*
		 * Populate Event dropdown - we will store the eventid in the trigger table!
		 * 
		 */
		$sql = ' SELECT b.dkpsys_name, a.event_id, a.event_dkpid, a.event_name FROM ' . EVENTS_TABLE . ' a, ' . DKPSYS_TABLE .  ' b 
				 WHERE a.event_dkpid = b.dkpsys_id 	' ; 

		$result = $db->sql_query($sql);
	
		while ( $row = $db->sql_fetchrow($result) )
         {
			$template->assign_block_vars('event_row', array(
				'VALUE' 	=> 	 $row['event_id'],
				'SELECTED' 	=> ( $row['event_id'] == (isset($this->event['event_id']) ? $this->event['event_id'] : '') ) ? ' selected="selected"' : '',
				'OPTION'   	=> ( !empty($row['event_name']) ) ? $row['dkpsys_name'] . '-' . $row['event_name'] : '(None)')
			);
         }
        $db->sql_freeresult ($result);

		 $template->assign_vars(array(
            'F_CONFIG' 		=> append_sid ( "{$phpbb_admin_path}index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_add_event_triggers&amp;"),
            'U_LINK' 		=> append_sid("{$phpbb_admin_path}index.$phpEx", 	"i=dkp_rt_settings&amp;"),
            'S_ADD'     	=> (isset($this->id)) ? false : true,

        ));
    
        
    }
    
    /**
     * Process Delete (confirmed)
     */
    function event_delete()
    {
    		global $db, $user;
    	    // check mode
		    if (confirm_box(true))
		    {
			    
		    	$event_trigger_ids 	= request_var( 'evtriggerids', array(0=>0)); 
			    $event_triggers 	= request_var( 'evtriggernam', ' ');
			    $events 			= request_var( 'triggeredevents', ' ');
			    
			    foreach ( $event_trigger_ids as $key => $event_trigger_id )
				{
					$sql = 'DELETE from ' . RT_EVENT_TRIGGERS_TABLE . ' where event_trigger_id = ' . $event_trigger_id;  
					$result = $db->sql_query($sql);
				}
		    	
		    	// Append success message
		      	$success_message = sprintf($user->lang["RT_TRIGGER_SUCCESS_DELETE"], $event_triggers, $events) . '<br />';
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
       					$sql = "SELECT event_trigger_id , event_trigger, event_id FROM " . RT_EVENT_TRIGGERS_TABLE . ' 
	   						  where event_trigger_id = ' . (int) $id ; 
		       						
						$result = $db->sql_query($sql);	
						while ( $row = $db->sql_fetchrow($result) )
						{	
							$evtriggername[] = $row['event_trigger'];
							$evtriggerresult[] = $row['event_id'];
						}
					}
					$db->sql_freeresult($result);
					
					// transform to comma separated string representation of all array elements in the same order
					$evtriggernamelist 	 = implode(', ', $evtriggername);
					$evtriggerresultlist = implode(', ', $evtriggerresult);					
				}
			    	
		    	$s_hidden_fields = build_hidden_fields(array(
					'delete'	 		=> true,
		    		'evtriggerids'		=> $compare_ids, 
					'evtriggernam' 		=> $evtriggernamelist,
		    		'triggeredevents' 	=> $evtriggerresultlist, 
					)
				);	
					
		        //display mode
		        confirm_box(false, $user->lang['RT_TRIGGER_CONFIRM_DELETE'] . ' <br />  ' . $evtriggernamelist  , $s_hidden_fields);	
		    }       
    }

    /**
     * Update an event trigger record
     */
    function event_update()
    {
		global $db, $user;
				
        $data = array(
    		'event_trigger'   	=> utf8_normalize_nfc(request_var('event_trigger', ' ', true)), 
    		'event_id'  		=> request_var('event_id', 0), 
        	
		);
		
		$sql = 'SELECT b.event_name from ' . RT_EVENT_TRIGGERS_TABLE . ' a, ' . EVENTS_TABLE . " b 
				where a.event_trigger = '" . $db->sql_escape($data['event_trigger']) . "'
				AND a.event_id = b.event_id ";
	  	$result1 = $db->sql_query($sql); 
	  	$eventname = $db->sql_fetchfield('event_name'); 
	  	$db->sql_freeresult($result1);  
        
        $sql = 'UPDATE ' . RT_EVENT_TRIGGERS_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $data) . ' 
        		WHERE event_trigger_id = ' . request_var('id', 0) ;
		$db->sql_query($sql);
        
		$success_message = sprintf($user->lang['RT_TRIGGER_SUCCESS_UPDATE'], $data['event_trigger'], $eventname);
		trigger_error($success_message . $this->Raidtrackerlink, E_USER_NOTICE );
		
    }

    /**
     * Add an event trigger record
     */
    function event_add()
    {
        global $db, $user;
        
        // the event is the event_id value from pulldown
        $data = array(
    		'event_trigger' => utf8_normalize_nfc(request_var('event_trigger', ' ', true)), 
    		'event_id'  	=> request_var('event_id', 0),  
		);
		
		$sql = 'DELETE from ' . RT_EVENT_TRIGGERS_TABLE . " where event_trigger = '" . $db->sql_escape($data['event_trigger'])  . "'"; 
		$db->sql_query($sql);
		
		$sql = 'INSERT into ' . RT_EVENT_TRIGGERS_TABLE . ' ' . $db->sql_build_array('INSERT', $data);
		$db->sql_query($sql);
		
		$sql = 'SELECT b.event_name from ' . RT_EVENT_TRIGGERS_TABLE . ' a, ' . EVENTS_TABLE . " b 
				where a.event_trigger = '" . $db->sql_escape($data['event_trigger']) . "'
				AND a.event_id = b.event_id ";
  		$result = $db->sql_query($sql); 
  		$eventname = $db->sql_fetchfield('event_name' , 1, $result); 
	  	$db->sql_freeresult($result); 
	  	   	
        $log_action = array(
            'header'   						=> 'L_ACTION_CTRT_EVENT_TRIGGER_ADDED',
            'L_CTRT_LABEL_event_trigger'   	=> $data['event_trigger'],
            'L_CTRT_LABEL_event' 			=> $eventname, 
            'L_ADDED_BY'                  	=> $user->data['username']);

        $this->log_insert(array(
            'log_type'   => $log_action['header'],
            'log_action' => $log_action)
        );

        $message = sprintf($user->lang['RT_TRIGGER_SUCCESS_ADD'], $data['event_trigger'], $eventname); 
        trigger_error($message . $this->Raidtrackerlink , E_USER_NOTICE);
    }

}
?>