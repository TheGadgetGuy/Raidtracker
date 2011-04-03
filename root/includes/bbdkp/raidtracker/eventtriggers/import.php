<?php
/**
 * Import RaidTracker Event Triggers
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
 * This class imports event triggers
 * ManageCTRT
 */
class Raidtracker_ImportEventTriggers extends acp_dkp_rt_settings 
{
    var $Raidtrackerlink; 

    function Raidtracker_ImportEventTriggers()
    {
    	global $phpbb_admin_path, $phpEx; 
		$this->Raidtrackerlink = '<br /><a href="'. append_sid ( "{$phpbb_admin_path}index.$phpEx", "i=dkp_rt_settings&amp;&amp;mode=rt_list_event_triggers" ) . '"><h3>Return to Index</h3></a>';
    }

    /**
     * Import the event triggers
     * this xml allows to create dkp pool, events, and triggers all in the same time.
     * 
     * 
	 *	 <EventTriggers>
	 *	  <EventTrigger>
	 *	    <trigger>Kazzak</trigger>
	 *	    <resultpool>Classic</resultpool>
	 *	    <resultevent>World Bosses</resultevent>
	 *	  </EventTrigger>
	 * 	  <EventTrigger>
	 *	    <trigger>very big dragon 25</trigger>
	 *	    <resultpool>WLK25</resultpool>
	 *	    <resultevent>Onyxia's Lair (25)</resultevent>
	 *	  </EventTrigger>
	 *	  <EventTrigger>
	 *	    <trigger>Ony 25</trigger>
	 *	    <resultpool>WLK25</resultpool>
	 *	    <resultevent>Onyxia's Lair (25)</resultevent>
	 *	  </EventTrigger>
	 *	  <EventTrigger>
	 *	    <trigger>ICC (10)</trigger>
	 *	    <resultpool>WLK10</resultpool>
	 *	    <resultevent>Icecrown (10)</resultevent>
	 *	  </EventTrigger>
	 *	</EventTriggers>
     * 
     */
    function process_import()
    {
        global $db, $user;
        $message = "";

        $xml = utf8_normalize_nfc(request_var('xml', ' ', true)); 
        $doc = $this->xmlparse($xml); 
        
        $errors = 0;
        foreach ($doc->EventTrigger as $EventTrigger) 
        {
       		$EventTrigger = (array) $EventTrigger; 

       		unset ($dkpsys_id);
        	unset ($event_id);  
        	
        	$trigger 	=  (string) trim($EventTrigger['trigger']); 
        	$dkpsys_name = (string) trim($EventTrigger['resultpool']); 
        	$resultevent = (string) trim($EventTrigger['resultevent']); 
        	$errors = 0; 
        	if(strlen($trigger) > 1 and strlen($dkpsys_name) > 1 and  strlen($resultevent) > 1)
        	{
	        	/* 
				 * check if dkp pool exists otherwise create it 
				 */
	        	$sql = "SELECT dkpsys_id, dkpsys_name
	                    FROM " . DKPSYS_TABLE . "
	                    WHERE dkpsys_name = '". $db->sql_escape(trim($dkpsys_name)) ."'";
	            $result = $db->sql_query($sql);	
	            // get id
	            while ( $row = $db->sql_fetchrow($result) )
				{
					$dkpsys_id 	= $row['dkpsys_id'];
				}
				$db->sql_freeresult($result);
				
				if ( !isset($dkpsys_id) )
				{
					// new dkp pool, create it.
					// table must be created with autoincrement or else this will fail
					$query = $db->sql_build_array('INSERT', array(
							'dkpsys_name'     => $dkpsys_name , 
							'dkpsys_status'   => 'N', 
							'dkpsys_addedby'  => $user->data['username'],
							'dkpsys_default'  => 'N') 
						);
					$db->sql_query('INSERT INTO ' . DKPSYS_TABLE . $query);
	
					// get id
				    $sql = "SELECT dkpsys_id, dkpsys_name
	                    FROM " . DKPSYS_TABLE . "
	                    WHERE dkpsys_name = '". $db->sql_escape(trim($dkpsys_name)) ."'";
		            $result = $db->sql_query($sql);	
		            while ( $row = $db->sql_fetchrow($result) )
					{
						$dkpsys_id 		= $row['dkpsys_id'];
					}
					$db->sql_freeresult($result);
					
					$message .= sprintf($user->lang["RT_DKPPOOL_SUCCESS_ADD"]."<br />" , $dkpsys_name )  ; 
				
				}
				else 
				{
					$errors++; 
					$message .= sprintf($user->lang["RT_DKPPOOL_FAIL_ADD"]."<br />" , $dkpsys_name )  ; 
				}
				
	        	/*
				* check if event exists otherwise create it 
				*/
				$sql = "SELECT event_id, event_name FROM " . EVENTS_TABLE ."
	                    WHERE event_name = '". $db->sql_escape(trim($resultevent)) ."'";
	            $result = $db->sql_query($sql);	
	            while ( $row = $db->sql_fetchrow($result) )
				{
					$event_id = $row['event_id'];
				}
				$db->sql_freeresult($result);
				
	        	if ( !isset($event_id) ) 
	            {
	            	// create event 
					$query = $db->sql_build_array('INSERT', array(   
					        'event_dkpid'     => $dkpsys_id,   
					        'event_name'      => $resultevent,  
							'event_color'     => '#0088EE',
							'event_imagename' => '', 
					        'event_value'     => 0,  
					        'event_added_by'  => $user->data['username'])   
					    );       
					$db->sql_query('INSERT INTO ' . EVENTS_TABLE . $query);
					
					$sql = "SELECT event_id, event_name FROM " . EVENTS_TABLE ."
		                    WHERE event_name = '". $db->sql_escape(trim($resultevent)) ."'";
		            
					$result = $db->sql_query($sql);	
		            while ( $row = $db->sql_fetchrow($result) )
					{
						$event_id = $row['event_id'];
					}
					$db->sql_freeresult($result);
					$message .= sprintf($user->lang["RT_EVENT_SUCCESS_ADD"]."<br />" , $resultevent )  ; 
					
	            }
	            else 
	            {
	            	$errors++; 
	            	$message .= sprintf($user->lang["RT_EVENT_FAIL_ADD"]."<br />" , $resultevent )  ; 
	            }
	            
	            // insert the  trigger record but delete it if it exists already 
				$sql = 'DELETE from ' . RT_EVENT_TRIGGERS_TABLE . " where event_trigger = '" . $db->sql_escape($trigger) . "'"; 
				$db->sql_query($sql);
				
			    $data = array(
		    		'event_trigger'   => $trigger, 
		    		'event_id' 		  => $event_id,
				);
				
				$sql = 'INSERT INTO ' . RT_EVENT_TRIGGERS_TABLE .  ' ' .  $db->sql_build_array('INSERT', $data); 
				$db->sql_query($sql);
	
				$message .= sprintf($user->lang["RT_TRIGGER_SUCCESS_ADD"]."<br />" , ucwords($trigger) ,$resultevent)  ;
        		
        	}
        
        }

    	if ($errors < 5)
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
