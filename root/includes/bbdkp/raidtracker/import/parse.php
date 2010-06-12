<?php
/**
 * Import Base class
 *
*  @author Sajaki@bbdkp.com
*  @package bbDkp.acp
 * @copyright 2010 bbdkp <http://code.google.com/p/bbdkp/>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * $Id$
 * 
 * requires PHP 5 >= 5.1.0
 */

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * This class handles parsing the xml file from ML_Raidtracker to the temp tables of Raidtracker plugin
 */
class Raidtracker_parse extends acp_dkp_rt_import
{
    var $id;
    var $Raidtrackerlink; 
    var $dkpid; 
    
    // prefs - needed during parsing
    var $alwaysaddeditems;
    var $alwaysignoreitem;  
    var $eventtrigger; 
	var $raidnotetrigger; 
	var $mainchar; 
    
    function Raidtracker_parse($action)
    {
    	global $db, $user, $template, $phpEx;
    	$this->Raidtrackerlink = '<br /><a href="'. $action . '"><h3>Return to Index</h3></a>';

		/*
       	 * prepare class vars
       	 */ 
    	
        // check if we have dkp systems in bbDKP
    	$sql = 'select count(*) as hasdkpsys from ' . DKPSYS_TABLE ; 
    	$result =  $result = $db->sql_query($sql);
		$checkexists = (int) $db->sql_fetchfield('hasdkpsys');
		$db->sql_freeresult ( $result);
		if ($checkexists == 0)
		{
			trigger_error($user->lang['RT_ERR_NODKPSYSSETUP'] . $this->Raidtrackerlink , E_USER_WARNING); 
		}
		
    	// check if we have events in bbDKP
    	$sql = 'select count(*) as hasevents from ' . EVENTS_TABLE; 
    	$result =  $result = $db->sql_query($sql);
		$checkexists = (int) $db->sql_fetchfield('hasevents');
		$db->sql_freeresult ( $result);
		if ($checkexists == 0)
		{
			trigger_error($user->lang['RT_ERR_NOEVENTSETUP'] . $this->Raidtrackerlink , E_USER_WARNING); 
		}
		
		// get event triggers
        $sql = 'SELECT a.event_trigger_id, a.event_trigger, c.dkpsys_name, c.dkpsys_id , 
		a.event_id, b.event_name from ' . RT_EVENT_TRIGGERS_TABLE . ' a, ' . EVENTS_TABLE . ' b , ' . DKPSYS_TABLE . ' c 
		where a.event_id = b.event_id 
		and b.event_dkpid = c.dkpsys_id
		order by b.event_dkpid, b.event_name';
        $result = $db->sql_query($sql);
        while ( $row = $db->sql_fetchrow($result) )
        {
        	$this->eventtrigger[$row['event_trigger']]['event_name'] = $row['event_name']; 
        	$this->eventtrigger[$row['event_trigger']]['event_id']   = $row['event_id'];
        	$this->eventtrigger[$row['event_trigger']]['dkpsys_id']  = $row['dkpsys_id']; 
        	
        }
        $db->sql_freeresult ( $result);
        
        // get raidnote triggers
        $sql = "SELECT * FROM " . RT_RAID_NOTE_TRIGGERS_TABLE ; 
        $result = $db->sql_query($sql);
        while ( $row = $db->sql_fetchrow($result) )
        {
        	$this->raidnotetrigger[$row['raid_trigger']] = $row['raid']; 
        }
        $db->sql_freeresult ( $result);  
	
        // get player aliases
        $sql =   "SELECT a.alias_id, a.alias_name, b.member_name FROM " . RT_ALIASES_TABLE . ' a , '
         . MEMBER_LIST_TABLE . ' b  where b.member_id = a.alias_member_id  ORDER BY a.alias_id ';
        $result = $db->sql_query($sql);
        while ( $row = $db->sql_fetchrow($result) )
        {
        	$this->mainchar[$row['alias_name']] = $row['member_name']; 
        }
        $db->sql_freeresult ( $result);
        
        
        // get always added items 
        $sql = "SELECT * FROM " . RT_ADD_ITEMS_TABLE ; 
        $result = $db->sql_query($sql);
        while ( $row = $db->sql_fetchrow($result) )
        {
        	$this->alwaysadditem[] = $row['add_items_wow_id']; 
        }
        $db->sql_freeresult ( $result);         
       
        // get always ignored items
        $sql = "SELECT * FROM " . RT_IGNORE_ITEMS_TABLE ; 
        $result = $db->sql_query($sql);
        while ( $row = $db->sql_fetchrow($result) )
        {
        	$this->alwaysignoreitem[] = $row['ignore_items_wow_id']; 
        }
        $db->sql_freeresult ( $result); 
        
        
        $this->display_form(); 
		
    }
    
    
    /*
     * displays the form
     * 
     */
    function display_form()
    {
    	global $db, $user, $template, $phpEx, $config;
    	
		/*
		 * show the raids yet to import below
		 */
		$import_count = 0;
		$listimport = false; 
		$sql = 'SELECT raidid, zone, note, starttime, endtime FROM ' . RT_TEMP_RAIDINFO . ' ORDER BY raidid';
  		if ( ($import_result = $db->sql_query($sql)) )
		{
			$listimport = true; 
		}

		while ( $row = $db->sql_fetchrow($import_result) )
		{
			$import_count++;
			
			$template->assign_block_vars('import_row', array(
				'ID'          	=> $row['raidid'],
				'DESCRIPTION'  	=> $row['zone'] . ' ' . $row['note'],
				'START'       	=> date("r", $row['starttime']),
				'END'  		  	=> date("r", $row['endtime']),
				'U_VIEW_IMPORT' => append_sid("index.$phpEx", "i=dkp_rt_import&amp;mode=rt_import&amp;r={$row['raidid']}")  ,
				'U_DELETE' 		=> append_sid("index.$phpEx", "i=dkp_rt_import&amp;mode=rt_delete&amp;r={$row['raidid']}")  ,  
				)
			); 

		}
		$db->sql_freeresult ( $import_result);
		    	
    	$template->assign_vars(array(
    		'S_SHOWIMP' 		=> $listimport, 
			'LISTIMPORT_FOOTCOUNT' => sprintf($user->lang['RT_STEP1_FOUNDRAIDS'], $import_count),
			)
		);		
    	
    	
    }
    
	/************************
	 * Main parser function
	 * gets called from acp_dkp_rt_import.php
	 * 
	 * @access public
	 ************************/
    function raid_parse()
    {
        global $db, $user, $config;  
        global $phpbb_root_path, $phpbb_admin_path, $phpEx; 
    
		/* Input Cleanup */
		$log = utf8_normalize_nfc(request_var('raidlog', ' ', true));
		$log = str_replace ("&", "and", html_entity_decode($log));
		
		if (strlen($log)<=1)
		{
			 trigger_error( $user->lang['RT_STEP1_NODATA'] . $this->Raidtrackerlink, E_USER_WARNING);
		}
		
		/*
		 * validate xml
		 * 
		 */ 

		// set libxml error handler on
        libxml_use_internal_errors(true);
               
    	if (!$this->_allowSimpleXMLOptions())
		{
			//CDATA tags will be set manually to text
			$log = $this->_removeCData($log);
			// returns a SimpleXMLElement object 
			$doc = simplexml_load_string($log, 'SimpleXMLElement');
		}
		else
		{
			// load and set CDATA as Text nodes
			// returns a SimpleXMLElement  object
			$doc = simplexml_load_string($log, 'SimpleXMLElement', LIBXML_NOCDATA);
		}
		
        $xml = explode("\n", $log);
        if(!$doc)
        {
	       $errors = libxml_get_errors();
	       if (!empty($errors))
	       {
	       		 $message = ''; 
		         foreach ($errors as $error) 
		         {
   					$message .= 
   					utf8_htmlspecialchars($xml[$error->line-1]) . '<br />' . 
   					utf8_htmlspecialchars($xml[$error->line]) . '<br />' .
   					utf8_htmlspecialchars($xml[$error->line +1]) . "<br />";
   					
					switch ($error->level) 
					{
				       case LIBXML_ERR_WARNING:
				           $message .= "Warning $error->code: ";
				           break;
				         case LIBXML_ERR_ERROR:
				           $message .= "Error $error->code: ";
				           break;
				       case LIBXML_ERR_FATAL:
				           $message .= "Fatal Error $error->code: ";
				           break;
					}
				    $message .= trim($error->message) . '. ' . 
			               "Line: $error->line, " .
			               "Column: $error->column<br />";
					
					if ($error->file) 
					{
					    $message .= "  File: $error->file<br />";
					}
					
					$message .= "--------------------------------------------<br />";
   				 }
   				 
   				$message = $user->lang ['RT_STEP1_INVALIDSTRING_MSG']. '<br />--------------------------------------------<br />' . $message; 
   				 
				// set error handler off - to free memory
		        libxml_clear_errors();
				// display errors
		        trigger_error( $message . $this->Raidtrackerlink, E_USER_WARNING);
	        }
	        	
        }

		/*
         * validate tags before processing
         * 
         */ 
        $start = (int) strtotime((string) $doc->start[0]); 
        $end = (int) strtotime((string) $doc->end[0]); 
        
        /* check for duplicate raid import */
        /* logs can't start 30 minutes before or after */
        $sql = ' select count(*) as checktime from ' . RT_TEMP_RAIDINFO . ' ';
        $sql .= ' where (starttime < ' . strval($start + 1800) . ' ) and ( starttime  > ' . strval($start - 1800) . ' ) '; 
        
		$result =  $result = $db->sql_query($sql);
		$checkexists = (int) $db->sql_fetchfield('checktime');
		$db->sql_freeresult ( $result);
		if ($checkexists != 0)
		{
			trigger_error($user->lang['RT_ERR_DUPLICATE'] . $this->Raidtrackerlink , E_USER_WARNING); 
		}
        
        $players =  (array) $doc->PlayerInfos;
		$Joins =  (array) $doc->Join[0];
		$Leaves =  (array) $doc->Leave[0];
		
		// no import when no bosskills
        $Bosskills =  (array) $doc->BossKills[0]; 
        if (sizeof($Bosskills) == 0)
       	{
       		trigger_error( $user->lang['RT_ERR_NOBOSSKILL'] . $this->Raidtrackerlink, E_USER_WARNING);	
       	}
		
       	$Wipes =  (array) $doc->Wipes[0]; 
		$Loots =  (array) $doc->Loot[0]; 
        

        if(isset($doc->realm))
        {
        	$realm = (string) $doc->realm[0]; 
        }
        else 
        {
        	$realm = 'n/a';  
        }
		

		/*
		 * General Raid info
		 * parsing raidnote
		 *  
		 */	 

        /*
         * find the raidzones from this xml
         * 
         * headcount
         * ct_raidtracker
         * 
         */  
        //declare aray 
        $Raidzone = array(); 

        // ct_raidtracker only. start by checking in raidnote
        $Note = (string) $doc->note[0];
        $Note = trim($Note, '- Zone:'); 
        $Note = trim($Note);
       	if (strlen(trim($Note)) == 0 && $config['bbdkp_rt_skipempty'] == 1)
    	{        		
			//so ignore this raid
			trigger_error( $user->lang['RT_ERR_NORAIDNOTE'] . $this->Raidtrackerlink, E_USER_WARNING);	
    	}

       	if (strlen(trim($Note)) == 0)
    	{        		
	    	//empty raidnote so look in zone tag
	    	//--> Headcount
	    	$Note = (string) $doc->zone[0];  
    	}
    	
    	if (strlen(trim($Note)) != 0)
    	{
    		$Raidzone[] = $Note;
    	}
    	
       	// look further in loot notes and zones
    	foreach ($Loots as $key => $Loot)
		{
			// explicitly cast Simplexml object to array
			$Loot = (array) $Loot; 
			//get note
			$Note =  $Loot ['Note'];
			$Note = preg_split ( "/-/", (string) $Loot['Note'] );
        	$Note = preg_split ( "/Zone: /", (string) $Note[1] );
			$Note = trim((string) $Note[1]);
			
        	if (strlen(trim($Note)) > 0)
        	{
        		$Raidzone[] = $Note;	
        	}
        	else 
        	{
        		// look in loot zone tag 
        		$Note = trim((string) $Loot ['zone']);
        		
        		// add it to the zone array
        		$Raidzone[] = $Note; 
        	}
		}
		
		// make the array unique
		$Raidzone = array_unique($Raidzone); 
		
		// with this element, get the event using the triggers. 
		// pass the unique array of raidzones, and return the first match that comes

		// if the trigger is unsuccessful in getting an event then trigger error.
		// 'unknown event' is not allowed anymore !
		
        $globalevent = $this->_GetRaidEventFromString ($Raidzone );
        $globalraidnote = $Raidzone[0]; 
		
		// is there a difficulty tag ?
        if(isset($doc->difficulty))
        {
        	$Raidlevel = $this->_GetDifficulty( (string) $doc->difficulty[0] ); 
        }
        else 
        {
        	$Raidlevel = 1; 
        }

        $batchid = unique_id();
        
        $data = array(
		    'batchid'     	=> $batchid,
		    'realm'     	=> $realm,
		    'starttime'     => $start,
		    'endtime'     	=> $end,
		    'zone'     		=> $globalevent['event_name'],
        	'event_id'		=> $globalevent['event_id'],
        	'dkpsys_id'		=> $globalevent['dkpsys_id'],
		    'note'     		=> $globalraidnote,
		    'difficulty'    => $Raidlevel,                                                      
		);
		
		$sql = 'INSERT INTO ' . RT_TEMP_RAIDINFO . ' ' . $db->sql_build_array('INSERT', $data);
		$db->sql_query($sql);

		$raid_id = $db->sql_nextid();
		
		/*
		 * main tests passed. proceed to tag processing
		 *
		 */
		
		/*
		 * Playerinfo
		 *
		 */
		foreach ($players as $key => $player)
		{
			$player = (array) $player; 
			
			// substitute altname with playername if pref is set
			if ($config['bbdkp_rt_replacealtnames'] == 1)
			{
				$dkpplayername = $this->_GetMainCharName((string) $player['name']);
			}
			else 
			{
				$dkpplayername = (string) $player['name'];
			}
			
			// get correct classid
			$class = (array) $this->_Getclass($player['class']);
			 
			$rt_player[] = array(
			'batchid'    => $batchid,
		    'raidid'     => $raid_id,
		    'playerid'   => 0,
			'race'		 => $this->_GetRaceIdByRaceName($player['race']), 
		    'playername' => $dkpplayername ,
		    'guild'   	 => (string) isset($player['guild']) ? $player['guild'] : '', 
		    'sex'    	 => (int) ($player['sex'] == 2 ? 0 : 1) ,  // 2 is male, 3 is female
		    'class'      => (int) $class[1],  
			'level'      => (int) $player['level'],  
			); 
		}	
	
		$db->sql_multi_insert(RT_TEMP_PLAYERINFO, $rt_player);
		
		
		/*
		 * Calculate Raid join and leave times
		 *
		 */
		foreach ($Joins as $key => $join)
		{
			$join = (array) $join; 
			
			// substitute altname with playername if pref is set
			if ($config['bbdkp_rt_replacealtnames'] == 1)
			{
				$dkpplayername = $this->_GetMainCharName((string) $join['player']);
			}
			else 
			{
				$dkpplayername = (string) $join['player'];
			}			
			
			$rt_joinleave[] = array(
			'batchid'   => $batchid ,
			'raidid'    => $raid_id ,
			'playerid'  => (int) $key ,
			'playername'    => $dkpplayername ,
		    'jointime'      => (int) strtotime((string) $join['time']) ,
			'leavetime'     => '',
			); 
		}	
		
		// make join array unique. no duplicate join records are allowed.
		$rt_joinleave = $this->serial_arrayUnique($rt_joinleave); 
		
		foreach ($Leaves as $key => $leave)
		{
			$leave = (array) $leave; 
			
			// substitute altname with playername if pref is set
			if ($config['bbdkp_rt_replacealtnames'] == 1)
			{
				$dkpplayername = $this->_GetMainCharName((string) $leave['player']);
			}
			else 
			{
				$dkpplayername = (string) $leave['player'];
			}			
			
			$rt_leave[] = array(
			'playername'    => (string) $dkpplayername ,
		    'leavetime'     => (int) strtotime((string) $leave['time']) ,
			); 
		}	
		
		// make leave array unique. no duplicate leave records are allowed.
		$rt_leave = $this->serial_arrayUnique($rt_leave); 
		
		
		// merge join-leave records, make one sequence
		// note if there is one join record and two leave records then only the first pair will be recorded.
		foreach ($rt_joinleave as $key1 => $joinleave)
		{
			foreach ($rt_leave as $key2 => $leave)
			{
				if($joinleave['playername'] == $leave['playername'])
				{
					//set leavetime to the first leavetime encountered for this playername
					$rt_joinleave[$key1]['leavetime'] = $leave['leavetime'];
					// unset this leave element to allow for multiple join/leave times
					unset ($rt_leave[$key2]); 
					 //break inner loop and get next joinleave.
					break 1; 
				}
			}
		}
		
		// second loop to check in-out values
		foreach ($rt_joinleave as $key1 => $joinleave)
		{
			if ($joinleave['leavetime'] == '')
			{
				unset ($rt_joinleave[$key1]); 
			}
		}
		
		// fill temp table
		$db->sql_multi_insert(RT_TEMP_JOININFO, $rt_joinleave);
		

		/*
		 *
		 *  Bosskills and wipes
		 *
		 */
		foreach ($Bosskills as $key => $Bosskill)
		{
			$Bosskill = (array) $Bosskill; 
			
			// is there a boss difficulty tag ?
	        if(isset($Bosskill['difficulty']))
	        {
	        	$Bosslevel = $this->_GetDifficulty( $Bosskill['difficulty'] ); 
	        }
	        else 
	        {
	        	//no
	        	$Bosslevel = 1; 
	        }
	        
			$rt_bosskill[] = array(
			'batchid'    => $batchid ,
			'bossname'   => (string) $Bosskill['name'] ,
		    'time'       => (int) strtotime((string) $Bosskill['time']) ,
			'zone'		 => $globalevent['event_name'], 
			'difficulty' => $Bosslevel ,
			); 
			
			if (isset($Bosskill['attendees']) && count( (array) $Bosskill['attendees']) > 0 )
			{
				
				// we have attendee records 
				$attendees = (array) $Bosskill['attendees']; 

				//loop the attendees, make a record
				foreach ($attendees as $key => $Player )
				{
					$Player = (array) $Player; 
					
					// substitute altname with playername if pref is set
					if ($config['bbdkp_rt_replacealtnames'] == 1)
					{
						$dkpplayername = $this->_GetMainCharName((string) $Player['name']);
					}
					else 
					{
						$dkpplayername = (string) $Player['name'];
					}				
					
					$rt_attendees[] = array(
						'batchid'     => $batchid ,
						'bossname'    => (string) $Bosskill['name'] ,
					  	'playername'  => $dkpplayername ,
					); 
			
				}
			}
			else 
			{
				// if there is no attendees tag for this bosskill then add everyone 
				// that was still in raid at time of bosskill
				// ->> some old Wow tracking mods don't add this tag
				
				// loop playerjointable to check 
				foreach($rt_joinleave as $key => $player)
				{
					$bosskilltime = (int) strtotime((string) $Bosskill['time']); 
					$leavetime =  (int) $player['leavetime']; 
					$jointime =  (int) $player['jointime'];
					$leftafterkill = ($bosskilltime < $leavetime) ? true : false; 
					$presentbeforekill = ($jointime < $bosskilltime) ? true : false;
					
					if ($presentbeforekill && $leftafterkill)
					{
						
						$rt_attendees[] = array(
							'batchid'     => $batchid ,
							'bossname'    => (string) $Bosskill['name'] ,
						  	'playername'  => $player['playername'] ,
						); 
					}
				}
				
				// if nobody was present at the bosskill then just exit here. 
				
		       	//  there is still a possibility that we may find a bosskill time based on the loot time though ...
		        if (sizeof($rt_attendees) == 0)
		       	{
		       		// delete raid 
		       		$sql = 'DELETE FROM ' . RT_TEMP_RAIDINFO . " WHERE batchid='" . $db->sql_escape($batchid) . "'";
					$db->sql_query($sql);
					$sql = 'DELETE FROM ' . RT_TEMP_PLAYERINFO . " WHERE batchid='" . $db->sql_escape($batchid) . "'";
					$db->sql_query($sql);
					$sql = 'DELETE FROM ' . RT_TEMP_JOININFO . " WHERE batchid='" . $db->sql_escape($batchid) . "'";
					$db->sql_query($sql);
					$sql = 'DELETE FROM ' . RT_TEMP_BOSSKILLS . " WHERE batchid='" . $db->sql_escape($batchid) . "'";
					$db->sql_query($sql);
					$sql = 'DELETE FROM ' . RT_TEMP_ATTENDEES . " WHERE batchid='" . $db->sql_escape($batchid) . "'";
					$db->sql_query($sql);
					$sql = 'DELETE FROM ' . RT_TEMP_LOOT . " WHERE batchid='" . $db->sql_escape($batchid) . "'";
					$db->sql_query($sql);
					
					// throw a critical error		       		
		       		trigger_error( sprintf($user->lang['RT_ERR_NOONEPRESENTATKILL'], date("Y-m-d H:i:s", $bosskilltime ) ) . $this->Raidtrackerlink, E_USER_WARNING);	
		       	}
		       	

		       	
		       	
		       	
			}
			
			
		}	
		
		// log wipes if it is present in xml
		// set difficultylevel to one
		$wipecount=0;
		foreach ($Wipes as $Wipe)
		{
			foreach ($Wipe as $wipetime)
			{
				$wipecount++;
				
				$rt_bosskill[] = array(
				'batchid'   => $batchid ,
				'bossname'  => 'Wipe'. $wipecount ,
			    'time'      => (int) $wipetime ,
				'zone'		=> $globalevent['event_name'], 
				'difficulty' => 1,
				); 
				
				// loop playerjointable to check who was present at the wipe
				foreach($rt_joinleave as $key => $player)
				{
					$leavetime =  (int) $player['leavetime']; 
					$jointime =  (int) $player['jointime'];
					$leftafterkill = ($wipetime < $leavetime) ? true : false; 
					$presentbeforekill = ($jointime < $wipetime) ? true : false;
					
					if ($presentbeforekill && $leftafterkill)
					{
						$rt_attendees[] = array(
							'batchid'     => $batchid ,
							'bossname'    => 'Wipe' . $wipecount ,
						  	'playername'  => $player['playername'] ,
						); 
					}
				}
				
				
			}
		}	
		
		// sort by time, interpolate the wipes with the bosskills
		// only if there was a bosskill 
		if(isset($rt_bosskill ))
		{
			
			//sort bosskills by time
			foreach ( $rt_bosskill as $key => $raid )
			{
				$times [$key] = $raid ['time'];
			}
			array_multisort ( $times, SORT_ASC, $rt_bosskill );
			
			//insert bosskill data
			$db->sql_multi_insert(RT_TEMP_BOSSKILLS, $rt_bosskill);
			
			//insert attendee data (if it is set)
			if (isset($rt_attendees))
			{
				$db->sql_multi_insert(RT_TEMP_ATTENDEES, $rt_attendees);
			}
		}
		
		/*
		 * loot
		 *  
		 */
		
        $ignoredlooter = isset($config['bbdkp_rt_ignoredlooter']) ? trim($config['bbdkp_rt_ignoredlooter']) : ''; 
		
        // walk the loot
		foreach ($Loots as $key => $Loot)
		{
			// explicitly cast Simplexml object to array
			$Loot = (array) $Loot; 
			
			// substitute altname in loot with playername if the pref is set
			if ($config['bbdkp_rt_replacealtnames'] == 1)
			{
				$dkpplayername = $this->_GetMainCharName((string) $Loot['Player']);
			}
			else 
			{
				$dkpplayername = (string) $Loot['Player'];
			}
			
			// retrieve item dkp cost
			// firstly go see in the loot note
			// if nothing found look in cost tag
			// if there is no cost tag or it is empty then look in the bbdkp items history
			// if it is still zero then look in the default DKP cost setting
			
			// initialise loot cost
			$dkpcost = 0.00; 
			
			// lootnote parsing
			if (! empty ( $Loot ['Note'] )) 
			{
				preg_match ( "/([\d\.]+) DKP/", $Loot ['Note'], $dkpinfo );
				if (isset( $dkpinfo [1] ) ) 
				{
				    if ( is_numeric( $dkpinfo [1]))
				    {
							$dkpcost = (float) $dkpinfo [1];
				    }
				}
			}
			
			// cost tag (only in Headcount)
			if ($dkpcost == 0.00)
			{
				if (!empty ($Loot['Costs']))
				{
					$dkpcost = (float) $Loot ['Costs']; 
				}
			}
			
			$itemname = str_replace ( "\\'", "'", (string) $Loot ['ItemName'] ); 

			// get the item id from loot
			$itemid =  (int) $this->_GetMainItemId($Loot['ItemID']);
			
			// go look in bbDKP
			if ($dkpcost == 0.00)
			{
				$dkpcost = $this->_GetDkpValue($itemname, $itemid) ;
			}
			
			// finally check the default cost
			if ($dkpcost == 0.00)
			{
				if ((float) $config['bbdkp_rt_defaultcost'] != 0.00  ) 
				{
					$dkpcost = (float) $config['bbdkp_rt_defaultcost'];
				}
			}
			
			
			// loot note
			$lootraidnote =  (string)  $Loot ['Note'];
        	if (strlen(trim($lootraidnote)) == 0)
        	{
        		// look in loot zone tag 
        		$lootraidnote = trim((string) $Loot ['zone']);
        	}
			
			
			//compare loot itemquality with minimum level if itemquality is too low then don't add the loot
			$itemquality = (int) $this->_GetItemQualityByColor ( $Loot ['Color'] ); 
			
			$isitemquality_low = ($itemquality >= $config['bbdkp_rt_minitemquality']) ? false : true;  

			// if this item is on ignore list don't add to loot table
			$isignoreditem = isset($this->alwaysignoreitem) ? in_array($itemid, $this->alwaysignoreitem) : false; 

			// is the looter being ignored ?
			$isignoredlooter = ($ignoredlooter == $dkpplayername) ? true: false;
			
			// if this item is on always add list ? this will override ignoredlooter and items and itemquality
			$isalwaysadded  = isset($this->alwaysadditem) ? in_array($itemid, $this->alwaysadditem) : false; 
			
			if (  ($isignoreditem == false && $isignoredlooter == false && $isitemquality_low == false) or ($isalwaysadded == true ))
			{
				$rt_loot[] = array(
				'batchid'   => $batchid,
			    'itemid'    => $itemid ,
				'itemname'  => $itemname, 
			    'playername' => $dkpplayername,
			    'count' 	=> (int) $Loot['Count'] ,
				'quality'	=> $this->_GetItemQualityByColor ( $Loot ['Color'] ), 
				'time'      => (int) strtotime((string) $Loot['Time']) ,
				'boss'      => (string) $Loot['Boss'], 
				'note'      => $lootraidnote,
				'cost'		=> $dkpcost,
				); 
					
			}
			

		}
		
		if(isset($rt_loot))
		{
			$db->sql_multi_insert(RT_TEMP_LOOT, $rt_loot);
		}

		

        $message =  $user->lang['RT_STEP1_DONE']; 
        trigger_error($message . $this->Raidtrackerlink, E_USER_NOTICE);

        return;
    }
    
    
	/************************
	 * 
	 * parser helper functions
	 * 
	 ************************/
	
	/*
	 * tries to find a Raid name matching the raidnote with each raidnote trigger
	 * if it finds one, return it
	 * else return the raidnote as they were given
	 * 
	 * @access private 
	 */
	function _GetRaidNoteFromString($string) 
	{
		global $config; 
		
		$string = str_replace ( "\\'", "'", $string );
		foreach ( (array) $this->raidnotetrigger as $trigger => $value ) 
		{
			if ($this->_in_string ( $trigger, $string, true )) 
			{
				return $value;
			}
		}
		//@todo make this variable
		return "Unknown";
	}
	
	/*
	 * tries to find an Event array matching input array of Eventtriggers using the Eventtriggers setup
	 * 
	 * @params (array) $raidzonearray 
	 * @returns (array) $event
	 */
	function _GetRaidEventFromString($raidzonearray) 
	{
		global $user; 
		
		foreach ( (array) $this->eventtrigger as $trigger => $event )
		{
			
			foreach ($raidzonearray as $raidzone)
			{
				$raidzone = trim((string) $raidzone); 
				if ($this->_in_string ( $trigger,  $raidzone , true )) 
				{
					return (array) $event;
				}
			}
			
		}
		
		 // if no matching event is found then return an error.
		 trigger_error( sprintf($user->lang['RT_ERR_NOEVENT'] , 
		 		implode(",", $raidzonearray), 
		 		implode(",", $raidzonearray)) . $this->Raidtrackerlink, 
		 		E_USER_WARNING);
	}
	
	/*
	 * returns the Main Char, given an Altname
	 * 
	 * @access private
	 */
	function _GetMainCharName($playername)
	{
		if (! empty ( $this->mainchar[$playername] )) 
		{
			return (string) $this->mainchar[$playername];
		}
		else 
		{
			return $playername; 
		}
							
	}
	
	
	/*
	 * function used for finding triggers
	 * 
	 * @access private
	 */
	function _in_string($needle, $haystack, $insensitive = false) 
	{
		if ($insensitive) 
		{
			$haystack = strtolower ( $haystack );
			$needle = strtolower ( $needle );
		}
		return (false !== strpos ( $haystack, $needle )) ? true : false;
	}
	
	/*
	 * parses itemid tag from dkp string
	 * form for ct_Raidtracker : <ItemID>33283:0:0:0:0:0:0:1810958690:73</ItemID>
	 * form for HeadCount : <ItemID>50787</ItemID>
	 * @access private
	 */
	function _GetMainItemId($itemid) 
	{
		
		if (strstr($itemid, ':') != false)
		{
			//ct_raidtracker
			$itemid = trim ( $itemid, "item:" );
			$itemid = preg_split ( "/:/", $itemid );
			return $itemid [0];
		}
		else 
		{
			//headcount
			return trim($itemid);
		}
		
		
	}
	
	/*
	 * finds item quality string
	 */
	function _GetItemQualityByColor($color) 
	{
		$quality = - 1;
		$color = strtolower ( $color );
		
		switch ($color) 
		{
			case "ffff8000" :
				$quality = RT_IQ_LEGENDARY;
				break;
			case "ffa335ee" :
				$quality = RT_IQ_EPIC;
				break;
			case "ff0070dd" :
				$quality = RT_IQ_RARE;
				break;
			case "ff1eff00" :
				$quality = RT_IQ_UNCOMMON;
				break;
			case "ffffffff" :
				$quality = RT_IQ_COMMON;
				break;
			case "ff9d9d9d" :
				$quality = RT_IQ_POOR;
				break;
		}
		
		return $quality;
	}
	
	/*
	 * gets raceid given racename in DKP string
	 */
	function _GetRaceIdByRaceName($racename) 
	{
		global $db;
		
		if ($racename == "Scourge") 
		{
			$racename = "Undead";
		} 
		elseif ($racename == "NightElf") 
		{
			$racename = "Night Elf";
		} 
		elseif ($racename == "BloodElf") 
		{
			$racename = "Blood Elf";
		}
		
		$result = $db->sql_query ( 'SELECT race_id FROM ' . RACE_TABLE . ' WHERE race_name ' .	
		$db->sql_like_expression($db->any_char . $db->sql_escape($racename) . $db->any_char) );
		
		$max_value = 0;
		// normally 1 loop will suffice
		while ( $row = $db->sql_fetchrow ( $result ) ) 
		{
			$value = $row ['race_id'];
			$max_value ++;
		}
		
		$db->sql_freeresult ( $result);
		
		if ($max_value >= 1) 
		{
			return $value;
		} 
		else 
		{
			return 0;
		}
	
	}

	/*
	 * gets correct bbDKP Class name and id given classname from DKP string
	 * 
	 */
	function _Getclass($CT_RaidTrackerclassName) 
	{
		switch ($CT_RaidTrackerclassName) 
		{
			case "WARRIOR" :
				$class = array("Warrior", 1);
				break;
			case "ROGUE" :
				$class = array("Rogue", 4);
				break;
			case "HUNTER" :
				$class = array("Hunter", 3);
				break;
			case "PALADIN" :
				$class = array("Paladin", 2);
				break;
			case "SHAMAN" :
				$class = array("Shaman",7);
				break;
			case "DRUID" :
				$class = array("Druid",11);
				break;
			case "WARLOCK" :
				$class = array("Warlock",9);
				break;
			case "MAGE" :
				$class = array("Mage",8);
				break;
			case "PRIEST" :
				$class = array("Priest",5);
				break;
			case "DEATHKNIGHT" :
				$class = array("Death Knight",6);
				break;
			default :
				$class = array("Unknown",0);
				break;
		}
		return $class;
	}
	
	
	/*
	 * serializes an associative array and runs array_unique
	 */
	function serial_arrayUnique($myArray)
	{
	    if(!is_array($myArray))
	           return $myArray;
	
	    foreach ($myArray as &$myvalue){
	        $myvalue=serialize($myvalue);
	    }
	
	    $myArray=array_unique($myArray);
	
	    foreach ($myArray as &$myvalue){
	        $myvalue=unserialize($myvalue);
	    }
	
	    return $myArray;

	} 


    /*
     * function to get dkp value from item from items table based on itemid and/or item name
     * if the item is new then we return the default cost
     * @todo add itemid search for 1.1.1
     * 
     * 
     */
	function _GetDkpValue($itemname, $itemid = 0) 
	{
		global $db, $config;
		
		$sql = 'SELECT MIN(item_value) as minval 
            		FROM ' . ITEMS_TABLE . " 
            		WHERE item_name = '" . $db->sql_escape ( $itemname ) . "'    ";
		
		$result = $db->sql_query ( $sql );
		$row = $db->sql_fetchrow ( $result );
		
		if (! is_numeric ( $row ['minval'] )) 
		{
			$dkpval= (float) $config['bbdkp_rt_defaultcost'];
		} 
		else 
		{
			$dkpval= (float) $row ['minval'];
		}
		
		$db->sql_freeresult ( $result);
		
		return $dkpval; 
		
		
	}
	
	/*
	 * retrieves heroic level from tag
	 */
	function _GetDifficulty($tag)
	{
		$tag = (string) $tag; 
		
		$difficulty = 1; 
		
		if (strstr($tag, 'Difficulty') != false)
		{
			//headcount
			switch ($tag)
			{
				case '10 Player':
				case '25 Player':
					$difficulty = 1; 	
					break;
				case '10 Player (Heroic)':
				case '25 Player (Heroic)':
					$difficulty = 2; 	
					break;
			}
			
		}
		else 
		{
			//ct_raidtracker (1 or 2)
			$difficulty = (int) $tag;
		}
		
		return $difficulty;
		
	}
	
	

}
?>
