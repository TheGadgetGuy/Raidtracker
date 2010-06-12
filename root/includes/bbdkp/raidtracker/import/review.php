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
 */

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * This class handles import from temp tables process
 * uses the $config data and rt preference tables to insert data into bbDKP
 * 
 */
class Raidtracker_Review extends acp_dkp_rt_import
{
	// raid
    var $Raid; 
   
    // lists
    var $dkplist;
    var $eventlist; 
    var $Raidtrackerlink; 
    
	/**
     * new instance of Importer 
     * 
     */
    function Raidtracker_Review()
    {
    	//global phpbb vars
    	global $config, $db, $user, $phpbb_root_path, $phpbb_admin_path, $phpEx;
    	
    	$raidid = request_var('r', 0); 
    	if($raidid == 0)
    	{
    		trigger_error($user->lang['RT_STEP2_ERR_RAIDID'], E_USER_WARNING); 
    	}
    	
    	$this->Raidtrackerlink = '<br /><a href="'. 
    		append_sid ( "index.$phpEx", "i=dkp_rt_import&amp;mode=rt_import" ) . '"><h3>Return to Index</h3></a>';

 		$batchid = ''; 
        // get raidinfo 
		$sql = 'SELECT event_id, dkpsys_id, batchid, realm, starttime, endtime , zone, note, difficulty
			FROM ' . RT_TEMP_RAIDINFO . ' where raidid = ' . (int) $raidid ; 
        $result = $db->sql_query($sql);
        while ( $row = $db->sql_fetchrow($result) )
        {
        	$batchid = $row['batchid']; 
			$this->Raid = array(
				'batchid'	  => $batchid, 
				'raidid'	  => $raidid, 
			    'realm' 	  => $row['realm'],
			    'starttime'   => $row['starttime'],
			    'endtime'     => $row['endtime'], 
			    'zone'     	  => $row['zone'],
			    'note'     	  => $row['note'],
			    'difficulty'  => $row['difficulty'],
				'event_id'    => $row['event_id'],
				'dkpsys_id'   => $row['dkpsys_id'],
			);
        }
        $db->sql_freeresult ( $result);
        
        // get playerinfo from temptable 
		$sql = 'SELECT playerid, playername, guild, race, sex, class, level
			 FROM ' . RT_TEMP_PLAYERINFO . " where batchid = '" . $batchid . "' order by playername"; 
        $result = $db->sql_query($sql);
        while ( $row = $db->sql_fetchrow($result) )
        {
			$allplayerinfo[] = array(
			    'playerid'  => $row['playerid'],
			    'name' 		=> $row['playername'],
			    'race' 	    => $row['race'],
			    'class'     => $row['class'],
				'level'     => $row['level'],
				'guild'     => $row['guild'],
				'sex'     	=> $row['sex']
			);
        }
        $db->sql_freeresult ( $result);
        
        $this->Raid['allplayerinfo'] = $allplayerinfo; 
        
		/*
		 * add attendees to raid 
		 */
     	$totalplayernr = 0;
     	$attendingplayers='';
	  	 switch ($config['bbdkp_rt_attendancefilter']) 
	  	 {
	  	 	case RT_AF_BOSS_KILL :
	 	 		// attendance set for boss-loot kill : all players present at bosskill
	  	 		$sql = 'SELECT distinct playername FROM ' . RT_TEMP_ATTENDEES . " where batchid = '" . $batchid . "' order by playername"; 
		        $result = $db->sql_query($sql);
		        while ( $row = $db->sql_fetchrow($result) )
		        {
		        	$attendingplayers[] = $row['playername'];
					$totalplayernr += 1; 
		        }
		        $db->sql_freeresult ( $result);
		        
	  	 		break; 
	  	 	case RT_AF_NONE :
	  	 		// attendance set to all : all players in the raid
	  	 		foreach ($allplayerinfo as $player)
	  	 		{
	  	 			$attendingplayers[] = $player['name'];
	  	 			$totalplayernr++; 
	  	 		}
	  	 		break; 
	  	 }
	  	 
	  	 $this->Raid['playersattending'] = $attendingplayers; 
	  	
		/*
		 * loop bossarray
		 */
	  	
        $sql_array = array(
	    'SELECT'    => 'b.bossid, b.bossname , b.time, b.difficulty ',
	    'FROM'      => array(
	        RT_TEMP_BOSSKILLS 	=> 'b',
	    ),
	    'WHERE'     =>  " b.batchid = '" . $db->sql_escape($batchid) . "'", 
	    'ORDER_BY'	=> ' b.time ', 
		);
		
		$lootid=0;
		$sql = $db->sql_build_query('SELECT', $sql_array);   
		$result = $db->sql_query($sql);
		while ( $row = $db->sql_fetchrow($result) )
        {
        	
	     /*
	      * array structure of $Bosskills array to be filled
                 
		   "$Bosskills" = Array [6]	
			0 = Array [6]	
				bossname = (string:14) Lord Marrowgar	
				time = (string:10) 1267813467	
				difficulty = (string:1) 1	
				bossattendees = Array [10]	
					0 = (string:6) Aidail	
					1 = (string:4) Alfr	
					2 = (string:6) Anunia	
					3 = (string:8) Cikaflex	
					4 = (string:12) Hunterbunter	
					5 = (string:9) Puhaasham	
					6 = (string:11) Rockythewar	
					7 = (string:6) Shintu	
					8 = (string:6) Willów	
					9 = (string:6) Xzound	
				countattendees = (int) 10	
				loot = Array [1]	
					0 = Array [7]	
						lootnr = (int) 0	
						itemid = (string:5) 50760	
						itemname = (string:19) Bonebreaker Scepter	
						playername = (string:6) Aidail	
						loottime = (string:4) 3600	
						lootnote = (string:61)  - Zone: Icecrown Citadel (10) - Boss: Lord Marrowgar - 0 DKP	
					cost = (string:5) 15.00	
         */
        	
        	/* adding attendees */
        	$sql_array2 = array(
	    	'SELECT'    => 'n.playername ',
	    	'FROM'      => array(
	        	RT_TEMP_ATTENDEES   => 'n'
	    	),
	    	'WHERE'     =>  " n.bossname = '" . $db->sql_escape($row['bossname']) . "'   
						 	AND  n.batchid = '" . $db->sql_escape($batchid) . "'",   
	    	'ORDER_BY'	=> 'n.playername', 
			);
			$sql2 = $db->sql_build_query('SELECT', $sql_array2);   
			$result2 = $db->sql_query($sql2);
			$nr_boss_attendees = 0;
			$bossattendees = array(); 
			while ( $row2 = $db->sql_fetchrow($result2) )
	        {
	        	$nr_boss_attendees++;  
				$bossattendees[] = $row2['playername'];
	        }
	        $db->sql_freeresult ($result2);	
			
	        /* adding loot for this boss */
	        
	        // set boss lootcounter to 0 
	        $sql_array3 = array(
		    'SELECT'    => 'b.bossname, l.itemid, l.itemname, l.playername, l.time, l.note, l.cost  ',
		    'FROM'      => array(
		        RT_TEMP_BOSSKILLS => 'b',
		        RT_TEMP_LOOT    => 'l' 
		    ),
		    
		    'WHERE'     =>  " b.bossname = l.boss
		    			  AND l.itemid NOT IN ( SELECT ignore_items_wow_id FROM " .  RT_IGNORE_ITEMS_TABLE . " )  
						  AND b.bossname = '" . $db->sql_escape($row['bossname']) . "' 
						  AND b.batchid = l.batchid
						  AND b.batchid = '" . $db->sql_escape($batchid) . "'", 
			);
			$sql3 = $db->sql_build_query('SELECT', $sql_array3);
	        $result3 = $db->sql_query($sql3);

	        // loop loot of this boss
	        $loot = array();
			while ( $row3 = $db->sql_fetchrow($result3) )
	        {
				$loot[] = array(
		            'lootnr'   		=> $lootid,
					'itemid'   		=> $row3['itemid'],
		            'itemname'      => $row3['itemname'],
		            'playername'    => $row3['playername'],
		            'loottime'      => date("Z", $row3['time']),
		            'lootnote'      => $row3['note'],
		            'cost'      	=> ($row3['cost'] > 0.00) ? $row3['cost'] :  number_format($config['bbdkp_rt_defaultcost'], 2) ,				
	    		);	 
	    		$lootid++;
	    		
	        }
	        $db->sql_freeresult ($result3);
	        
	        /* combining attendees and loot into boss array */
			$Bosskills[] = array(
			    'bossname' 		 => $row['bossname'],
			    'time' 	    	 => $row['time'],
				'difficulty'	 => $row['difficulty'],
				'bossattendees'  => $bossattendees, 
				'countattendees' => $nr_boss_attendees, 
				'loot'			 => $loot
			);
			
			// unset for next loop
			unset($bossattendees);
			unset($nr_boss_attendees);
			unset($loot);
			
        }
        $db->sql_freeresult ($result);
        
        /*** adding trash mobs ****/
        
       	// get own raids. there has to be an own raid called "Trash mob"
        $sql = "SELECT * FROM " . RT_OWN_RAIDS_TABLE ; 
        $result = $db->sql_query($sql);
        while ( $row = $db->sql_fetchrow($result) )
        {
        	$this->ownraid[] = $row['own_raid_name']; 
        }
        $db->sql_freeresult ($result);   
        
        //match between own raids and Temp loot table but not matching bosskill table or ignored items
	    $sql_array = array(
		    'SELECT'    => 'b.own_raid_name, l.itemid, l.itemname, l.playername, l.time, l.note, l.cost  ',
		    'FROM'      => array(
		        RT_OWN_RAIDS_TABLE => 'b',
		        RT_TEMP_LOOT    => 'l', 
		    ),
			// anti-joining with ignore and bosskills table
		    'WHERE'     =>  ' b.own_raid_name = l.boss
				  AND b.own_raid_name NOT IN (SELECT bossname FROM ' . RT_TEMP_BOSSKILLS . " where batchid = '" .  $db->sql_escape($batchid) . "' )
    			  AND l.itemid NOT IN ( SELECT ignore_items_wow_id FROM " .  RT_IGNORE_ITEMS_TABLE . " )  
				  AND l.batchid = '" . $db->sql_escape($batchid) . "'", 
		    
			);
		$sql = $db->sql_build_query('SELECT', $sql_array);
	    $result = $db->sql_query($sql);
	    
	    $nr_ownraid_attendees = 0; 
	    $loot = array();
	    $bossattendees = array(); 
        while ( $row = $db->sql_fetchrow($result) )
        {
        	$own_raid_name = $row['own_raid_name']; 
			$loot[] = array(
	            'lootnr'   		=> $lootid,
				'itemid'   		=> $row['itemid'],
	            'itemname'      => $row['itemname'],
	            'playername'    => $row['playername'],
	            'loottime'      => date("Z", $row['time']),
	            'lootnote'      => $row['note'],
	            'cost'      	=> ($row['cost'] > 0.00) ? $row['cost'] :  number_format($config['bbdkp_rt_defaultcost'], 2) ,				
    		);	 
    		++$lootid;
			$bossattendees[] = $row['playername'];
        }
        
        $db->sql_freeresult ($result);
		$bossattendees = array_unique($bossattendees); 
        
		if(count($loot) > 0 && count($bossattendees) > 0)
		{
			// add trash mob loot to $boskills
			$Bosskills[] = array(
			    'bossname' 		 => (string) $own_raid_name,
			    'time' 	    	 => (int) $this->Raid['starttime'],
				'difficulty'	 => 1,
				'bossattendees'  => (array) $bossattendees, 
				'countattendees' => (int) count($bossattendees), 
				'loot'			 => (array) $loot
			);
		}
        
		/* adding boss array to raid */        
        $this->Raid['bosskills'] = $Bosskills; 
        
        //unsetting 
        unset($Bosskills);
        unset($loot);
        unset($bossattendees);
        

        /*
    	 * populate dkplist (entire) 
    	 */
 		$sql = 'SELECT dkpsys_name, dkpsys_id, dkpsys_default FROM ' . DKPSYS_TABLE; 
        $result = $db->sql_query($sql);
        while ( $row = $db->sql_fetchrow($result) )
        {
			$this->dkplist[] = array(
				'dkpsys_id' 	=> $row['dkpsys_id'],
				'dkpsys_name'   => $row['dkpsys_name'], 
			); 
        }
        $db->sql_freeresult ($result);
        
        /*
		 * Populate Eventlist of this dkp 
		 */
		$sql_array = array(
	    'SELECT'    => 'b.event_name, b.event_id , b.event_value ',
	    'FROM'      => array(
		        EVENTS_TABLE 	=> 'b',
	    		),
	    'WHERE'     =>  ' b.event_dkpid = ' . intval($this->Raid['dkpsys_id']) , 
	    'ORDER_BY'	=> ' b.event_id ', 
		);
		$sql = $db->sql_build_query('SELECT', $sql_array);   
        $result = $db->sql_query($sql);
        while ( $row = $db->sql_fetchrow($result) )
         {
         	if($row['event_id'] == $this->Raid['event_id'])
         	{
         		$this->Raid['event_value'] = $row['event_value']; 
         	}
			$this->eventlist[] = array(
				'event_id'   	=> $row['event_id'], 
				'event_name' 	=> $row['event_name'],
				'event_value'   => $row['event_value'],
			); 
         }
        $db->sql_freeresult ($result);
        


       // get jointimes  
		$sql = 'SELECT playername, jointime, leavetime FROM ' . RT_TEMP_JOININFO . " where batchid = '" . $batchid . "'"; 
        $result = $db->sql_query($sql);
        while ( $row = $db->sql_fetchrow($result) )
        {
			$this->joininfo[] = array(
			    'playername'    => $row['playername'],
			    'jointime' 	    => date("r", $row['jointime']),
				'leavetime' 	=> date("r", $row['leavetime']),
			);
        }
        $db->sql_freeresult ($result);
        
        $this->display_form();

    }
    
    
    /**
     * displays a batch id
     * 
     */
    function display_form()
    {
		// displays a batchid

    	
    	global $template, $phpEx, $config; 
    	
    	// global vars   	
        $template->assign_vars(array(
	  	 	'U_LINK' 				=> append_sid("index.$phpEx", "i=dkp_rt_import&amp;"), 
			'S_ADDLOOTDKPVALUES' 	=> (( $config['bbdkp_rt_aldkpchkbox']) ? true : false) , 
            'U_IMPORT' 				=> append_sid ( "index.$phpEx", "i=dkp_rt_import&amp;mode=rt_import&amp;r=" . $this->Raid['raidid']  ),
        	 // javascript
        	 'UA_FINDEVENT'		    => append_sid("findevent.$phpEx"),
	  	 ));   
	  	
	  	/*
		 * Populate DKP dropdown 
		 */
        foreach ($this->dkplist as $dkp)
        {
			$template->assign_block_vars('dkpsys_row', array(
				'DKPLISTVALUE' 		=> $dkp['dkpsys_id'],
				'DKPLISTSELECTED' 	=> ( $dkp['dkpsys_id'] == $this->Raid['dkpsys_id'] ) ? ' selected="selected"' : '',
				'DKPLISTOPTION'   	=> ( !empty($dkp['dkpsys_name']) ) ? $dkp['dkpsys_name'] : ' ')
			);
        }

        /*
		 * Populate Event dropdown 
		 */
        foreach($this->eventlist as $allevents)
         {
			$template->assign_block_vars('eventlist_row', array(
				'EVENTLISTVALUE' 	=> $allevents['event_id'],
				'EVENTLISTSELECTED' => ( $allevents['event_id'] == $this->Raid['event_id'] ) ? ' selected="selected"' : '',
				'EVENTLISTOPTION'   => ( !empty($allevents['event_name']) ) ? $allevents['event_name'] : ' ')
			);
         }

         
        /*
         * fill allplayerinfo row
         */
		foreach( $this->Raid['allplayerinfo'] as $player)
		{
			$template->assign_block_vars('allplayers_row', array(
			'ID' 		=> $player['playerid'],
			'NAME' 		=> $player['name'], 
        	'GUILD'		=> $player['guild'],			
        	'RACE'		=> $player['race'],
			'SEX' 		=> $player['sex'], 
        	'CLASS'		=> $player['class'],
        	'LEVEL'		=> $player['level'],
			));
		}
         
        /*
		 * fill generic raid info 
		 */
        $template->assign_block_vars('raid_row', array(
			'REALM' 		=> $this->Raid['realm'], 
        	'RAIDID'		=> $this->Raid['raidid'],
        	'BATCHID'		=> $this->Raid['batchid'],
			'HRAIDSTART_MO' => date ( "m", $this->Raid['starttime'] ), 
			'HRAIDSTART_D' 	=> date ( "d", $this->Raid['starttime'] ), 
			'HRAIDSTART_Y' 	=> date ( "Y", $this->Raid['starttime'] ), 
			'HRAIDSTART_H' 	=> date ( "H", $this->Raid['starttime'] ), 
			'HRAIDSTART_MI' => date ( "i", $this->Raid['starttime'] ), 
			'HRAIDSTART_S' 	=> date ( "s", $this->Raid['starttime'] ), 
			'HRAIDEND_MO' 	=> date ( "m", $this->Raid['endtime'] ), 
			'HRAIDEND_D' 	=> date ( "d", $this->Raid['endtime'] ), 
			'HRAIDEND_Y' 	=> date ( "Y", $this->Raid['endtime'] ), 
			'HRAIDEND_H' 	=> date ( "H", $this->Raid['endtime'] ), 
			'HRAIDEND_MI' 	=> date ( "i", $this->Raid['endtime'] ), 
			'HRAIDEND_S' 	=> date ( "s", $this->Raid['endtime'] ),	  	
			'ZONE' 			=> $this->Raid['zone'],
        	'NOTE' 			=> $this->Raid['note'],
        	'EVENT' 		=> $this->Raid['event_id'],
        	'EVENT_VALUE' 	=> $this->Raid['event_value'],
        	'DKPSYS' 		=> $this->Raid['dkpsys_id'],
		  	'NORM_CHECKED' 	=> ($this->Raid['difficulty'] == '1') ? ' checked="checked"' : ''  , 
	  	    'HEROIC_CHECKED' => ($this->Raid['difficulty'] == '2') ? ' checked="checked"' : '' , 
    		'TOTALATTENDEESCOUNT' => sizeof($this->Raid['playersattending']), 
    		'ALLATTENDEES'	=> implode(', ', $this->Raid['playersattending'] ), 
			
        	
	  	 ));    
        	
        /*
		 * fill boss info to template
		 */
	  	 foreach($this->Raid['bosskills'] as $key => $boss)
	  	{
	  	  	$template->assign_block_vars('raid_row.boss_row', array(
	            'BOSSNAME'    => $boss['bossname'],
				'BOSSKILL_MO' => date ( "m", $boss['time'] ),
				'BOSSKILL_D'  => date ( "d", $boss['time'] ),
				'BOSSKILL_Y'  => date ( "Y", $boss['time'] ),
				'BOSSKILL_H'  => date ( "H", $boss['time'] ),
				'BOSSKILL_MI' => date ( "i", $boss['time'] ),
				'BOSSKILL_S'  => date ( "s", $boss['time'] ),
    			'BOSSATTENDEES'	=> implode(', ', $boss['bossattendees']),
    			'COUNTOFBOSSATTENDEES'	=> 	$boss['countattendees'], 
    			'BOSSNORM_CHECKED' 		=> ($boss['difficulty'] == '1') ? ' checked="checked"' : ''   , //ok
	  	    	'BOSSHEROIC_CHECKED' 	=> ($boss['difficulty'] == '2') ? ' checked="checked"' : ''   , //ok
    		
	        ));
	        
	        foreach($boss['loot'] as $key => $loot)
	        {
		        $template->assign_block_vars('raid_row.boss_row.loot_row', array(
		            'LOOTNR'   		=> $loot['lootnr'],
					'ITEMID'   		=> $loot['itemid'],
		            'ITEMNAME'      => $loot['itemname'],
		            'PLAYERNAME'    => $loot['playername'],
		            'LOOTTIME'      => $loot['loottime'],
		            'LOOTNOTE'      => $loot['lootnote'],
		            'COST'      	=> $loot['cost'] 
	    		));	 
	        }

	  	}

    }
    
   
}
?>
