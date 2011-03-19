<?php
/**
 * AddRaid Base class
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
 * This class adds a raid to bbdkp
 */
class Raidtracker_Addraid extends acp_dkp_rt_import
{
	//holds boardtime
	public  $time;
    private $id, $Raidtrackerlink; 
	private $dkp, $batchid, $event, $eventname, $globalcomments, 
	    $allattendees, $raid_value, $raidbegin, $difficulty, $raidend, $timebonuses; 
	private $bosses, $bossesdifficulty, $bosskilltime, $bossattendees, $bossloots; 
	/* holds status message */
	private $message; 
	
    public function Raidtracker_Addraid($action)
    {
    	global $phpbb_admin_path, $config, $user, $phpEx, $phpbb_root_path;
 		$user->add_lang ( array ('mods/dkp_admin' ) );
    	
    	$this->Raidtrackerlink = '<br /><a href="'. 
    		append_sid ( "{$phpbb_admin_path}index.$phpEx", "i=dkp_rt_import" ) . '"><h3>Return to Index</h3></a>';
    		
		$boardtime = getdate(time() + $user->timezone + $user->dst - date('Z'));
    	$this->time = $boardtime[0]; 

    	//parameters
    	$this->batchid = request_var('batchid', '' );    
    	$this->dkp 	   = request_var('dkpsys' , 0 );
    	$this->event   = request_var('event' , 0 );
    	$this->eventname   = request_var('event_name' , array(''=>'') );
		
		$this->allattendees = utf8_normalize_nfc(request_var('allattendees', array( '' => '') , true)); 

		$this->raid_value = request_var('dkpvalue',array( '' => 0.00));
		$this->difficulty = request_var('difficulty', array( '' => 0));
		$this->globalcomments = utf8_normalize_nfc(request_var('globalcomments', array( '' => '') , true)); 
		
    	$raidstart_h = request_var('raidstart_h', array( '' => 0)); 
    	$raidstart_mi = request_var('raidstart_mi', array( '' => 0)); 
    	$raidstart_s = request_var('raidstart_s', array( '' => 0)); 
    	$raidstart_mo = request_var('raidstart_mo', array( '' => 0)); 
    	$raidstart_d = request_var('raidstart_d', array( '' => 0)); 
    	$raidstart_y = request_var('raidstart_y', array( '' => 0)); 

    	$raidsend_h = request_var('raidend_h', array( '' => 0)); 
    	$raidend_mi = request_var('raidend_mi', array( '' => 0)); 
    	$raidend_s = request_var('raidend_s', array( '' => 0)); 
    	$raidend_mo = request_var('raidend_mo', array( '' => 0)); 
    	$raidend_d = request_var('raidend_d', array( '' => 0)); 
    	$raidend_y = request_var('raidend_y', array( '' => 0)); 

    	$this->raidbegin = mktime(
        	$raidstart_h[$this->batchid]  , 
        	$raidstart_mi[$this->batchid]  , 
        	$raidstart_s[$this->batchid]  , 
        	$raidstart_mo[$this->batchid]  , 
        	$raidstart_d[$this->batchid], 
        	$raidstart_y[$this->batchid] );
        	
        $this->raidend = mktime(
        	$raidsend_h[$this->batchid] , 
        	$raidend_mi[$this->batchid] , 
        	$raidend_s[$this->batchid] , 
        	$raidend_mo[$this->batchid], 
        	$raidend_d[$this->batchid], 
        	$raidend_y[$this->batchid] );
        	
        // boss array
        /*
         * $this->bosses = utf8_normalize_nfc(request_var('bossname', array( '' => array( '' => '' )) , true)); 
          $this->bossesdifficulty = utf8_normalize_nfc(request_var('bossdifficulty', array('' => array('' => 0)), true)); 
        */
    	include ($phpbb_root_path . "includes/bbdkp/raidtracker/import/krequest.$phpEx");
        $req = new phpbb_request; 
        $this->bosses = $req->variable('bossname', array( ''=> array( ''=> '')), true, phpbb_request::POST );  
        $this->bossesdifficulty = $req->variable('bossdifficulty', array( ''=> array( ''=> '')), true, phpbb_request::POST );
        $this->bossloots = $req->variable('loots', array( ''=> array( ''=> array( ''=>  array( ''=> '')))), true, phpbb_request::POST ); 
        $this->timebonuses = $req->variable('timebonus', array( ''=> array( ''=> 0.00)), true, phpbb_request::POST );      
        $this->bossattendees = $req->variable('attendees', array( ''=> array( ''=> '')), true, phpbb_request::POST );    
        $req->enable_super_globals();
        unset($req);
        
        $bosskilltime_h  = request_var('bosskill_h', array( '' => array( '' => 0))); 
    	$bosskilltime_mi = request_var('bosskill_mi', array( '' => array( '' => 0))); 
    	$bosskilltime_s  = request_var('bosskill_s', array( '' => array( '' => 0))); 
    	$bosskilltime_mo = request_var('bosskill_mo', array( '' => array( '' => 0))); 
    	$bosskilltime_d  = request_var('bosskill_d', array( '' => array( '' => 0))); 
    	$bosskilltime_y  = request_var('bosskill_y', array( '' => array( '' => 0))); 
    	
    	if (sizeof( $this->bosses) > 0 )
    	{
	    	foreach($this->bosses[$this->batchid] as $boss )
	    	{
	    		$bkt[$boss] = mktime(
	    				$bosskilltime_h[$this->batchid][$boss], 
	    				$bosskilltime_mi[$this->batchid][$boss], 
	    				$bosskilltime_s[$this->batchid][$boss], 
	    				$bosskilltime_mo[$this->batchid][$boss], 
	    				$bosskilltime_d[$this->batchid][$boss],
	    				$bosskilltime_y[$this->batchid][$boss]); 
	    	}
	    	$this->bosskilltime = $bkt; 
    	}
      
        /* add new members */
        $this->handle_new_members($this->batchid);
        
		/* add raid, attendees and loot*/
        switch($config['bbdkp_rt_bossraid'])
        {
        	case 0:
        		$this->raid_add_one();
        
        		break;
        	case 1:
		        $this->raid_add();
		        $this->dkppoints_add_bosskill();
        		break;
        }
        
        /* add dkp earned per hour */ 
        if ( (float) $config['bbdkp_dkphour'] > 0 )
        {
        	$this->add_time_dkp(); 
        }
        
        /* add bosskills */
        $this->raidkill_add	();
        $success_message = sprintf ( $user->lang ['ADMIN_ADD_RAID_SUCCESS'], $user->format_date($this->raidbegin)   , $this->eventname[$this->batchid] ) . '<br />';
		trigger_error($success_message . $this->Raidtrackerlink , E_USER_NOTICE); 
        return;
        
    }
    
    private function handle_new_members() 
    {
    	global $db, $user, $config, $phpbb_root_path, $phpEx;
        if ( !class_exists('acp_dkp_mm')) 
        {
            // we need this class for accessing member functions
            include ($phpbb_root_path . 'includes/acp/acp_dkp_mm.' . $phpEx); 
        }
        $acp_dkp_mm = new acp_dkp_mm;
        $allplayerinfo = array();
        
		$sql = 'select distinct playername, race, guild, sex, class, level, value 
		from ' . RT_TEMP_PLAYERINFO . " where batchid = '" . $db->sql_escape($this->batchid) . "'" ;
	    $result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$allplayerinfo[] = array(
				'playername' => (string) $row['playername'], 
				'race' 		 => (int) $row['race'],
				'guild' 	 => (string)  $row['guild'],
				'sex' 		 => (int) $row['sex'],
				'class' 	 => (int) $row['class'],
				'level' 	 => (int) $row['level'],
				'value' 	 => (float) $row['value'],
				);
		}
		$db->sql_freeresult ( $result);
		
		foreach($allplayerinfo as $player)
		{
			//check if exists
            $sql = "SELECT count(*) as mcount 
	        	FROM " . MEMBER_LIST_TABLE . " 
	        	where member_name ='" . $db->sql_escape($player['playername']) . "'";
			$result = $db->sql_query($sql);
            $mcount = (int) $db->sql_fetchfield('mcount', false, $result);  
            $db->sql_freeresult($result);
            $membersadded = 0; 

            if ($mcount == 0)
            {
            	// member does not exist
            	// check if there is a guildname
				if( strlen($player['guild']) > 2 )
				{
			        // check guild
					$sql = "SELECT id FROM " . GUILD_TABLE . " where name ='" . $db->sql_escape($player['guild']) . "'";
					$result = $db->sql_query($sql);
		            $guild_id = $db->sql_fetchfield('id');  
		            $db->sql_freeresult($result);
		            
		            //guild not found -> make it
		            if (!$guild_id)
		            {
		            	// insertnewguild($guild_name,$realm_name,$region, $showroster, $aionlegionid = 0, $aionserverid = 0) 
			            $guild_id = (int) $acp_dkp_mm->insertnewguild(
				            $player['guild'],
				            $config['bbdkp_default_realm'],
				            $config['bbdkp_default_region'], 
				            	1);
			            
			            // ranks are just defaults, you will have to run armoryupdater to update correct ranks
			            $acp_dkp_mm->insertnewrank(0, 'Guildleader', 0, '', '',  $guild_id);
			            $acp_dkp_mm->insertnewrank(1, 'Member', 0, '', '',  $guild_id);
		            }
				}
				else 
				{
					// look for guild with most members and add player to that!
					$sql = 'select a.member_guild_id from (select member_guild_id, count(*) as mcount from '. MEMBER_LIST_TABLE .'  group by member_guild_id ) a order by a.mcount desc ';
					$result = $db->sql_query_limit($sql,1);
					$guild_id = (int) $db->sql_fetchfield ('member_guild_id', false, $result );
					$db->sql_freeresult($result);
				}
            
           		// we dont care about the actual rank, thats armoryupdater's job. 
            	$rank = 1;
            	if ($guild_id == 0 )
            	{
            		// set to 'out' rank
            		$rank = 99;
            	}
            	
            	// insert the member
                if ($acp_dkp_mm->insertnewmember(
                	$player['playername'], 
                	1, 
                	$player['level'], 
                	$player['race'], 
                	$player['class'], 
                	$rank,
                	"Member inserted " . $user->format_date($this->time) . ' by RaidTracker',
                	$this->time, // joindate
                	mktime(0, 0, 0, 12, 31, 2030),  // should be null
                 	$guild_id,
                	$player['sex'], 
                	0,  //achiev
                	' ' //url
                	))
	                {
	                     $membersadded += 1;
	                }
              }
              
            //get the id
            $this_memberid = (int) $acp_dkp_mm->get_member_id($player['playername']); 
            
            // check if player has dkp record for pool
            // otherwise add one
			$sql = ' SELECT count(*) as pcount FROM ' . MEMBER_DKP_TABLE . ' WHERE member_id = ' . $this_memberid . ' AND member_dkpid  = ' . (int) $this->dkp; 
			$result = $db->sql_query ($sql);
			$pcount = (int) $db->sql_fetchfield('pcount');  
			$db->sql_freeresult($result);
            $memberdkpadded = 0; 
            if ($pcount == 0)
            {
            	    //make dkp record, set adjustment to starting dkp
					$sql_ary = array(
				    'member_dkpid'      => (int) $this->dkp,
				    'member_id'     	=> $this_memberid,
				    'member_adjustment' => floatval($config['bbdkp_starting_dkp']),
					'member_status'     => 1,
				    'member_firstraid'  => $this->raidbegin,
					);
				$sql = 'INSERT INTO ' . MEMBER_DKP_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary);
				$db->sql_query($sql);

               if ( !class_exists('acp_dkp_adj')) 
        	   {
	       			 include ($phpbb_root_path . 'includes/acp/acp_dkp_adj.' . $phpEx);
        	   }
        	   $acp_dkp_adj = new acp_dkp_adj;
        	   
        	   $group_key = $acp_dkp_adj->gen_group_key(
        	   		$this->time, 
        	   		$user->lang['RT_STARTING_DKP'],  
        	   		floatval($config['bbdkp_starting_dkp']) );
        	   $acp_dkp_adj->add_new_adjustment( 
        	   		(int) $this->dkp, 
        	   		$this_memberid, 
        	   		$group_key, 
        	   		floatval($config['bbdkp_starting_dkp']), 
        	   		$user->lang['RT_STARTING_DKP'] );
            	unset($acp_dkp_adj);
            	 
            }
              	        
		}
		unset ($acp_dkp_mm); 
		
    }


    /**
     * integrates raid in bbDKP
     * this creates one raid for each Boss kill
     * 
     */
	private function raid_add()
	{
		global $db, $user, $config, $phpEx, $phpbb_root_path ;
		
		if ( !class_exists('acp_dkp_mm')) 
        {
            // we need this class for accessing member functions
            include ($phpbb_root_path . 'includes/acp/acp_dkp_mm.' . $phpEx); 
        }
        $acp_dkp_mm = new acp_dkp_mm;
		/*
		 * start transaction
		 */
		$db->sql_transaction('begin');

		// insert raid record
        // 1 raid per boss
		// put bossname in raid note with the comments
		// add raid bonus
		if (sizeof ($this->bosses ) > 0)
		{
			foreach($this->bosses[$this->batchid] as $boss)
			{
				
				// Insert the raid
				// raid id is auto-increment so it is increased automatically
				//
				$sql_raid = array(
					'event_id'     	 => (int) $this->event,
					'raid_start'     => $this->bosskilltime[$boss] - (3600/20),
					'raid_end'       => $this->bosskilltime[$boss],     
					'raid_note'      => $boss . ' : ' . $this->raid_value[$this->batchid]. ' ' . $this->globalcomments[$this->batchid]  ,
					'raid_added_by'  => 'RaidTracker (by ' . $user->data ['username'] . ')' , 
				);
				
				$sql = 'INSERT INTO ' . RAIDS_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_raid);
				$db->sql_query($sql);	
				$raid_id = $db->sql_nextid();
				unset ($sql_raid);
	
				// add attendees
				$sql_attendees=array();
				$attendees = array_unique(explode(',' , $this->bossattendees[$this->batchid][$boss]));
				foreach($attendees as $attendee)
				{
					$this_memberid = (int) $acp_dkp_mm->get_member_id(trim($attendee));	
					//only add the attendee if he is present !
					// if the bossattendee array is bigger than playerinfo then we ignore the rest
					if ($this_memberid != 0)
					{
						$sql_attendees[] = array(
							'raid_id'     	 => (int) $raid_id, 
							'member_id'      => (int) $this_memberid, 
							'raid_value'   => (float) $this->raid_value[$this->batchid],
				            'time_bonus'   => (float) $this->timebonuses[$this->batchid][trim($attendee)],
							);
					}
				}
				$db->sql_multi_insert(RAID_DETAIL_TABLE, $sql_attendees);
				unset  ($sql_attendees);
			
				foreach ($sql_attendees as $attendee)
				{
					// only update lastraid date if it is earlier than this raid's date
					$sql = 'select member_lastraid from  ' . MEMBER_DKP_TABLE . ' where member_dkpid = ' . (int) $this->dkp . '
						AND member_id = ' . (int) $this_memberid;
					$result = $db->sql_query($sql);
		           	$member_lastraid = (int) $db->sql_fetchfield('member_lastraid', false, $result);  
		           	$db->sql_freeresult($result);
		            
		           	// add raid and time bonus 
			        $sql  = 'UPDATE ' . MEMBER_DKP_TABLE . ' m
		               SET m.member_raid_value = m.member_raid_value + ' .  $this->raid_value[$this->batchid] . ', 
		               	   m.member_time_bonus = m.member_time_bonus + ' .  $attendee['time_bonus'] ;
			           	        
		               if ( $member_lastraid < $this->raidbegin )
		               {
		                  $sql .= 'm.member_lastraid = ' . $this->raidbegin . ', ';
		               }
		               
		               $sql .= ' m.member_raidcount = m.member_raidcount + 1
		               WHERE m.member_dkpid = ' . (int) $this->dkp . '
		               AND m.member_id = ' . (int) $this_memberid;
		               $db->sql_query($sql);
				}

				// add loot 
				$this->_loot_add($raid_id, $boss);
		
				
				$log_action = array (
				'header' 		=> 'L_ACTION_RAID_ADDED', 
				'id' 			=> $raid_id, 
				'L_EVENT' 		=> $this->eventname[$this->batchid], 
				'L_ATTENDEES' 	=> $this->bossattendees[$this->batchid][$boss], 
				'L_NOTE' 		=> $boss . ' : ' . $this->raid_value[$this->batchid]. ' ' . $this->globalcomments[$this->batchid] , 
				'L_VALUE' 		=> $this->raid_value[$this->batchid], 
				'L_ADDED_BY' 	=> $user->data ['username'] );
			
				$this->log_insert (array (
					'log_type' 		=> $log_action ['header'], 
					'log_action' 	=> $log_action ));
				
			}
			
		}

		// commit
		$db->sql_transaction('commit');
	}
    
    /**
     * integrates raid in bbDKP
     * this function creates one global raid regardless of number of bosses
     * (as per user request)
     * 
     */
	private function raid_add_one()
	{
		global $db, $user, $config, $phpEx, $phpbb_root_path ;
		
		if ( !class_exists('acp_dkp_mm')) 
        {
            // we need this class for accessing member functions
            include ($phpbb_root_path . 'includes/acp/acp_dkp_mm.' . $phpEx); 
        }
        $acp_dkp_mm = new acp_dkp_mm;

		// add global raid record
		$sql_raid = array(
			'event_id'     	 => (int) $this->event, 
			'raid_start'     => $this->raidbegin,
			'raid_end'       => $this->raidend, 
			'raid_note'      => $this->globalcomments[$this->batchid],
			'raid_added_by'  => 'RaidTracker (by ' . $user->data ['username'] . ')' 
		);
		
		$sql = 'INSERT INTO ' . RAIDS_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_raid);
		$db->sql_query($sql);	
		$raid_id = $db->sql_nextid();
		unset ($sql_raid);

		// add raid detail pro raider
		$attendees = array_unique(explode(',' , $this->allattendees[$this->batchid]));
		foreach($attendees as $attendee)
		{
			$this_memberid = (int) $acp_dkp_mm->get_member_id(trim($attendee));				
			//only add the attendee if he is present !
			// if the bossattendee array is bigger than playerinfo then we ignore the rest
			if ($this_memberid != 0)
			{
				$sql_attendees[] = array(
				'raid_id'     	 => (int) $raid_id, 
				'member_id'      => (int) $this_memberid, 
				'raid_value'   => (float) $this->raid_value[$this->batchid],
	            'time_bonus'   => (float) $this->timebonuses[$this->batchid][trim($attendee)],
				);
			}
			
		}
		$db->sql_multi_insert(RAID_DETAIL_TABLE, $sql_attendee);
		
		foreach ($sql_attendees as $attendee)
		{
			// only update lastraid date if it is earlier than this raid's date
			$sql = 'select member_lastraid from  ' . MEMBER_DKP_TABLE . ' where member_dkpid = ' . (int) $this->dkp . '
				AND member_id = ' . (int) $this_memberid;
			$result = $db->sql_query($sql);
           	$member_lastraid = (int) $db->sql_fetchfield('member_lastraid', false, $result);  
           	$db->sql_freeresult($result);
            
           	// add raid and time bonus 
	        $sql  = 'UPDATE ' . MEMBER_DKP_TABLE . ' m
               SET m.member_raid_value = m.member_raid_value + ' .  $this->raid_value[$this->batchid] . ', 
               	   m.member_time_bonus = m.member_time_bonus + ' .  $attendee['time_bonus'] ;
	           	        
               if ( $member_lastraid < $this->raidbegin )
               {
                  $sql .= 'm.member_lastraid = ' . $this->raidbegin . ', ';
               }
               
               $sql .= ' m.member_raidcount = m.member_raidcount + 1
               WHERE m.member_dkpid = ' . (int) $this->dkp . '
               AND m.member_id = ' . (int) $this_memberid;
               $db->sql_query($sql);
		}
		
		// add loot and assign it to the global raid
		if(sizeof ($this->bosses) > 0)
		{
			foreach($this->bosses[$this->batchid] as $boss)
			{
				$this->_loot_add($raid_id, $boss);
			}
		}
		
		$log_action = array (
		'header' 		=> 'L_ACTION_RAID_ADDED', 
		'id' 			=> $raid_id, 
		'L_EVENT' 		=> $this->eventname[$this->batchid], 
		'L_ATTENDEES' 	=> $this->allattendees[$this->batchid], 
		'L_NOTE' 		=> $this->globalcomments[$this->batchid], 
		'L_VALUE' 		=> $this->raid_value[$this->batchid], 
		'L_ADDED_BY' 	=> $user->data ['username'] );
	
		$this->log_insert ( array (
			'log_type' 		=> $log_action ['header'], 
			'log_action' 	=> $log_action ) );
			
	}
	
	

	
	
    /*
     * inserts new loot in item table
     * increases spent amount per player
     * called from raid_add() for each boss or or raid_add_one for global raid
     * 
     * if zero balance is set then call function 
     * 
     * @param $raidid = primary key of raid table
     * @param $boss = boss name to treat
     * 
     */
    private function _loot_add($raidid, $boss)
    {
    	global $db, $user, $config, $phpEx, $phpbb_root_path ;
    	
    	if ( !class_exists('acp_dkp_item')) 
        {
            // we need this class for accessing item functions
            include ($phpbb_root_path . 'includes/acp/acp_dkp_item.' . $phpEx); 
        }
        $acp_dkp_item = new acp_dkp_item;
        
        //did boss drop loot ?
        
        if(isset($this->bossloots[$this->batchid][$boss]) > 0) 
        {
        	
        	//calculate group keys
        	foreach ($this->bossloots[$this->batchid][$boss]['itemname'] as $key => $item)
        	{
        		$allitems[] = $item; 
        	}
        	$allitems = array_unique($allitems); 
        	
        	foreach ($allitems as $item)
        	{
        		$groupid[$item] = $acp_dkp_item->gen_group_key($item, $this->bosskilltime[$boss], $raidid ) ;
        	}
        	unset ($allitems); 
        	
        	$items = array();
        	
        	$log_action = array();
        	
        	// loop items and prepare insert sql 
        	foreach($this->bossloots[$this->batchid][$boss]['itemname'] as $key => $item_name)
        	{
        		$items[] = array(
	        		'item_dkpid' 	=> (int) $this->dkp,
	        		'item_name' 	=> (string)  trim($item_name),
	        		'item_buyer' 	=> (string) $this->bossloots[$this->batchid][$boss]['playername'][$key],
	        		'raid_id' 		=> (int) $raidid,
	        		'item_value' 	=> (float)  $this->bossloots[$this->batchid][$boss]['cost'][$key],
	        		'item_date' 	=> (int) $this->bosskilltime[$boss],
	        		'item_added_by' => (string) $user->data ['username'],
	        		'item_updated_by' => (string) $user->data ['username'],
	        		'item_group_key' => (string) $groupid[trim($item_name)],
	        		'item_gameid' 	=> (int)  $this->bossloots[$this->batchid][$boss]['itemid'][$key],
        		);
        		
				$log_actions[$key]['header'] = 'L_ACTION_ITEM_ADDED';
				$log_actions[$key]['L_NAME'] = trim($item_name);  
				$log_actions[$key]['L_BUYERS'] = (string) $this->bossloots[$this->batchid][$boss]['playername'][$key];
				$log_actions[$key]['L_RAID_ID'] = (int) $raidid;
				$log_actions[$key]['L_VALUE']  = (float) $this->bossloots[$this->batchid][$boss]['cost'][$key];
				$log_actions[$key]['L_ADDED_BY'] = $user->data['username'];

        	}
        	$db->sql_multi_insert(RAID_ITEMS_TABLE, $items);
        	
        	// loop items and increase dkp spent value for buyer
        	$query = array();
        	foreach($items as $key => $item)
        	{
				$query[] = 'UPDATE ' . MEMBER_DKP_TABLE . ' d, ' . MEMBER_LIST_TABLE  . ' m 
					SET d.member_spent = d.member_spent + ' . (float) $item['item_value']  .  ' 
					WHERE d.member_dkpid = ' . (int) $this->dkp  . " 
				  	 AND  d.member_id =  m.member_id 
				  	 AND m.member_name  = '" . $db->sql_escape( $item['item_buyer'] ) . "' ";
				
				// if zero balance flag is set then return sql to update dkp
				if ($config['bbdkp_zerosum'] == 1 )
				{
					$query[] = $this->_zero_balance($boss, $item['item_value'] );
				}
				
				
        	}
        	unset($items);
        	
        	foreach ($query as $sql)
        	{
				$db->sql_query ($sql);
        	}
		
			foreach($log_actions as $key => $log_action )
			{
	        	$this->log_insert ( array (
					'log_type' => $log_action ['header'], 
					'log_action' => $log_action ) );
			}
        	
        }
    	
    }
	
    
 	/**
     * updates bonus earned points raidcount & last raiddate
     * per bosskill & member !!
     * 
     */
    private function dkppoints_add_bosskill()
    {
   		global $db, $user, $config, $phpEx, $phpbb_root_path ;
   		
   				
		if ( !class_exists('acp_dkp_mm')) 
        {
            // we need this class for accessing member functions
            include ($phpbb_root_path . 'includes/acp/acp_dkp_mm.' . $phpEx); 
        }
        $acp_dkp_mm = new acp_dkp_mm;
        
        $trashbosses = array();
        
     	$sql = "SELECT * FROM " . RT_OWN_RAIDS_TABLE ; 
        $result = $db->sql_query($sql);
        while ( $row = $db->sql_fetchrow($result) )
        {
        	$trashbosses[] = $row['own_raid_name']; 
        }
        $db->sql_freeresult ($result);   
        $trashbosses = array_unique($trashbosses); 
        
   		// increase raid count, member_lastraid, earned for each raid 
        foreach($this->bosses[$this->batchid] as $key => $boss)
		{
			// add exception that the boss may not be defined in own_raids
			// own_raids bosses do not count for the overall raidcount 
			if ( !in_array($boss, $trashbosses))
			{
				
				$attendees = explode(',' , $this->bossattendees[$this->batchid][$boss]);
				foreach($attendees as $attendee)
				{
					$this_memberid = (int) $acp_dkp_mm->get_member_id(trim($attendee));				
	
					// only uodate lastraid date if it is earlier than this raid's date
					$sql = 'select member_lastraid from  ' . MEMBER_DKP_TABLE . ' where member_dkpid = ' . (int) $this->dkp . '
						AND member_id = ' . (int) $this_memberid;
					
					$result = $db->sql_query($sql);
	            	$member_lastraid = (int) $db->sql_fetchfield('member_lastraid', false, $result);  
	            	$db->sql_freeresult($result);
	             
			        $sql  = 'UPDATE ' . MEMBER_DKP_TABLE . ' m
	                SET m.member_earned = m.member_earned + ' .  $this->raid_value[$this->batchid] . ', ';
			        
	                if ( $member_lastraid < $this->bosskilltime[$boss] )
	                {
	                   $sql .= 'm.member_lastraid = ' . $this->bosskilltime[$boss] . ', ';
	                }
	                
	                $sql .= ' m.member_raidcount = m.member_raidcount + 1
	                WHERE m.member_dkpid = ' . (int) $this->dkp . '
	                AND m.member_id = ' . (int) $this_memberid;
	                $db->sql_query($sql);
	            
				}
				 
			}
			
			
		}
    }
    
        
    
    /***
     * Zero-sum DKP function
     * will increase earned points for members present at loot time (== bosskill time) or present in Raid, depending on Settings
     * ex. player A pays 100dkp for item A
     * there are 15 players in raid
     * so each raider gets 100/15 = earned bonus 6.67 
     * 
     * called from _loot_add
     * 
     * @param $boss : all attendees for boss get redistributed
     * @param $itemvalue : all itemvalue 
     * 
     * returns the sql to update
     * 
     */
    private function _zero_balance($boss, $itemvalue )
    {
    	global $db;
    	
    	$zerosumdkp = round( $itemvalue / count($this->bossattendees[$this->batchid][$boss] , 2)); 
    	
    	$sql = ' UPDATE ' . MEMBER_DKP_TABLE . ' d, ' . MEMBER_LIST_TABLE  . ' m 
			SET d.member_earned = d.member_earned + ' . (float) $zerosumdkp  .  ' 
			WHERE d.member_dkpid = ' . (int) $this->dkp  . ' 
		  	 AND  d.member_id =  m.member_id 
		  	 AND ' . $db->sql_in_set('m.member_name', $this->bossattendees[$this->batchid][$boss]  ) ;

    	return $sql; 
    }
    
    /**
     * function to add time raid points
     * 
     */
    private function add_time_dkp()
    {
		global $db, $user, $config, $phpEx, $phpbb_root_path ;
   				
		if ( !class_exists('acp_dkp_mm')) 
        {
            // we need this class for accessing member functions
            include ($phpbb_root_path . 'includes/acp/acp_dkp_mm.' . $phpEx); 
            
        }
		
        if ( !class_exists('acp_dkp_adj')) 
        {
	        include ($phpbb_root_path . 'includes/acp/acp_dkp_adj.' . $phpEx);
        }
        
        $acp_dkp_mm = new acp_dkp_mm;
        $acp_dkp_adj = new acp_dkp_adj;
        
		// add time bonus to all attendees as an adjustment
		$bonuslist = array();
        foreach ($this->timebonuses[$this->batchid] as $player => $bonus)
        {
        	$this_memberid = (int) $acp_dkp_mm->get_member_id(trim($player));	
        	if ($this_memberid != 0)
        	{
				$bonuslist[$this_memberid] = (float) $bonus;
        	}
        }
					    
        foreach($bonuslist as $member_id => $bonusadj)
        {
        	$comment = $this->eventname[$this->batchid] . date ("dmY", $this->raidend);
	        $group_key = $acp_dkp_adj->gen_group_key($this->time, $comment,  $bonusadj );
        	$acp_dkp_adj->add_new_adjustment( (int) $this->dkp, $member_id, $group_key, $bonusadj, $comment  );
        }
    	
    }
    
}

?>
