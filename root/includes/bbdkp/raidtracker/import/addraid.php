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
	public	$time;
	private $id, $Raidtrackerlink; 
	private $dkp, $batchid, $realm, $event, $eventname, $globalcomments, $allplayerinfo,
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

		if ($this->check_parse() == 1)
		{
			trigger_error($user->lang['RT_ERR_RAID_ALREADYPROCESSED'] . $this->Raidtrackerlink , E_USER_WARNING); 
		}
		
		$this->dkp	   = request_var('dkpsys' , 0 );
		$this->event   = request_var('event' , 0 );
		$this->eventname   = request_var('event_name' , array(''=>'') );
		
		$this->allattendees = utf8_normalize_nfc(request_var('allattendees', array( '' => '') , true)); 
		$this->realm = utf8_normalize_nfc(request_var('realm' , '', true));
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
		if ( !class_exists('phpbb_request')) 
		{
			include ($phpbb_root_path . "includes/bbdkp/raidtracker/import/krequest.$phpEx");
		}
		$req = new phpbb_request; 
		$this->bosses = $req->variable('bossname', array( ''=> array( ''=> '')), true, phpbb_request::POST );  
		$this->bossesdifficulty = $req->variable('bossdifficulty', array( ''=> array( ''=> '')), true, phpbb_request::POST );
		$this->bossloots = $req->variable('loots', array( ''=> array( ''=> array( ''=>	array( ''=> '')))), true, phpbb_request::POST ); 
		$this->timebonuses = $req->variable('timebonus', array( ''=> array( ''=> 0.00)), true, phpbb_request::POST );	   
		$this->bossattendees = $req->variable('attendees', array( ''=> array( ''=> '')), true, phpbb_request::POST );	 
		$req->enable_super_globals();
		unset($req);
		
		$bosskilltime_h	 = request_var('bosskill_h', array( '' => array( '' => 0))); 
		$bosskilltime_mi = request_var('bosskill_mi', array( '' => array( '' => 0))); 
		$bosskilltime_s	 = request_var('bosskill_s', array( '' => array( '' => 0))); 
		$bosskilltime_mo = request_var('bosskill_mo', array( '' => array( '' => 0))); 
		$bosskilltime_d	 = request_var('bosskill_d', array( '' => array( '' => 0))); 
		$bosskilltime_y	 = request_var('bosskill_y', array( '' => array( '' => 0))); 
		
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
		$this->raid_add();
		
		$this->close_parse();
		
		$success_message = sprintf ( $user->lang ['ADMIN_ADD_RAID_SUCCESS'], $user->format_date($this->raidbegin)	, $this->eventname[$this->batchid] ) . '<br />';
		trigger_error($success_message . $this->Raidtrackerlink , E_USER_NOTICE); 
		return;
		
	}

	/**
	 * 
	 * returns true if raid was not parsed yet
	 */
	private function check_parse()
	{
		global $db;
		$sql = "select imported from  " . RT_TEMP_RAIDINFO . " where batchid = '" . $db->sql_escape($this->batchid) . "'";	
		$result = $db->sql_query($sql);
		$imported = $db->sql_fetchfield('imported', 0 , $result);
		$db->sql_freeresult ( $result);
		return $imported;
	}
	
	
	/**
	 * 
	 * marks raid as imported
	 */
	private function close_parse()
	{
		global $db;
		$sql = "update " . RT_TEMP_RAIDINFO . " set imported = 1 where batchid = '" . $db->sql_escape($this->batchid) . "'";  
		$db->sql_query($sql);
		
	}
	
	/**
	 * 
	 * adds new members to listmembers table, adds dkp
	 */
	private function handle_new_members() 
	{
		global $db, $user, $config, $phpbb_root_path, $phpEx;
		if ( !class_exists('acp_dkp_mm')) 
		{
			// we need this class for accessing member functions
			include ($phpbb_root_path . 'includes/acp/acp_dkp_mm.' . $phpEx); 
		}
		$acp_dkp_mm = new acp_dkp_mm;
 
		$this->allplayerinfo = array();
		
		$sql = 'select distinct playerid, playername, race, guild, sex, class, level, value 
		from ' . RT_TEMP_PLAYERINFO . " where batchid = '" . $db->sql_escape($this->batchid) . "'" ;
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$this->allplayerinfo[$row['playerid']] = array(
				'playername' => (string) $row['playername'], 
				'race'		 => (int) $row['race'],
				'guild'		 => (string)  $row['guild'],
				'sex'		 => (int) $row['sex'],
				'class'		 => (int) $row['class'],
				'level'		 => (int) $row['level'],
				'value'		 => (float) $row['value'],
				'member_id'	 => (int) 0,
				);
		}
		$db->sql_freeresult ( $result);
		
		foreach($this->allplayerinfo as $playerid => $player)
		{
			// check if player exists in memberlist
			$sql = "SELECT count(*) as mcount FROM " . MEMBER_LIST_TABLE . " where ucase(member_name) =  ucase('" . $db->sql_escape($player['playername']) . "') ";
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
					// check guildname
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
						$acp_dkp_mm->insertnewrank(0, 'Guildleader', 0, '', '',	 $guild_id);
						$acp_dkp_mm->insertnewrank(1, 'Member', 0, '', '',	$guild_id);
					}
				}
				else 
				{
					// the array does not have a guildname or the raider is guildless
					if($config['bbdkp_rt_noguild'] ==1 )
					{
						// add to highest guildid 
						$sql = 'select max(id) AS guild_id from ' . GUILD_TABLE;
						$result = $db->sql_query_limit($sql,1);
						$guild_id = (int) $db->sql_fetchfield ('guild_id', false, $result );
						$db->sql_freeresult($result);
					}
					else
					{
						// add to guildid 0
						$guild_id= 0;
					}
				}
			
				if ($guild_id == 0)
				{
					// set to 'out' rank
					$rank_id = 99;
				}
				else 
				{
					// get highest guildrank that is not 90
					$sql = 'select max(rank_id) AS rank_id from ' . MEMBER_RANKS_TABLE . ' where guild_id = ' . $guild_id . ' and rank_id != 90';
					$result = $db->sql_query_limit($sql,1);
					$rank_id = (int) $db->sql_fetchfield ('rank_id', false, $result );
					$db->sql_freeresult($result);
				}
				
				// insert the new member
				$this_memberid = $acp_dkp_mm->insertnewmember(
					$player['playername'], 
					1, 
					$player['level'], 
					$player['race'], 
					$player['class'], 
					$rank_id,
					"Member inserted " . $user->format_date($this->time) . ' by RaidTracker',
					$this->raidbegin - 172800, // take today or two days ago from raid start (-3600*24*2)
					0, 
					$guild_id,
					$player['sex'], 
					0,	//achiev
					' ', //url
					$this->realm, 
					'wow'
					);
					
					if ($this_memberid > 0)
					{
						 $membersadded += 1;
					}
					else
					{
						trigger_error('GENERAL_ERROR');
					}
					
			 }
			 else
			 {
				//get the id
				$this_memberid = (int) $acp_dkp_mm->get_member_id($player['playername']); 
			 }
			 
			$this->allplayerinfo[$playerid]['member_id'] = $this_memberid;
			
			// check if player has dkp record for pool
			// otherwise add one
			$sql = ' SELECT count(*) as pcount FROM ' . MEMBER_DKP_TABLE . ' WHERE member_id = ' . $this_memberid . ' AND member_dkpid	= ' . (int) $this->dkp; 
			$result = $db->sql_query ($sql);
			$pcount = (int) $db->sql_fetchfield('pcount');	
			$db->sql_freeresult($result);
			
			if ($pcount == 0)
			{
			   //make dkp record, set adjustment to starting dkp
			   $sql_ary = array(
				'member_dkpid'		=> (int) $this->dkp,
				'member_id'			=> $this_memberid,
				'member_adjustment' => floatval($config['bbdkp_starting_dkp']),
				'member_status'		=> 1,
				'member_firstraid'	=> $this->raidbegin,
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
			
		// add global raid record
		$sql_raid = array(
			'event_id'		 => (int) $this->event, 
			'raid_start'	 => $this->raidbegin,
			'raid_end'		 => $this->raidend, 
			'raid_note'		 => $this->globalcomments[$this->batchid],
			'raid_added_by'	 => 'RaidTracker (by ' . $user->data ['username'] . ')' 
		);
		
		$sql = 'INSERT INTO ' . RAIDS_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_raid);
		$db->sql_query($sql);	
		$raid_id = $db->sql_nextid();
		unset ($sql_raid);

		// add raid detail per raider
		foreach($this->allplayerinfo as $player_id => $attendee)
		{
			if ($attendee['member_id'] != 0)
			{
				$timebonus = 0;
				if (isset($this->timebonuses[$this->batchid][ $attendee['playername']] ))
				{
					$timebonus = (float) $this->timebonuses[$this->batchid][ $attendee['playername']];	
				}
				
				$sql_attendees[] = array(
				'raid_id'		 => (int) $raid_id, 
				'member_id'		 => (int) $attendee['member_id'], 
				'raid_value'   => (float) $this->raid_value[$this->batchid],
				'time_bonus'   => (float) $timebonus,
				);
			}
		}
		$db->sql_multi_insert(RAID_DETAIL_TABLE, $sql_attendees);
		unset ($attendee);
		
		foreach ($sql_attendees as $attendee)
		{
			// only update lastraid date if it is earlier than this raid's date
			$sql = 'select member_lastraid from ' . MEMBER_DKP_TABLE . ' where member_dkpid = ' . (int) $this->dkp . '
				AND member_id = ' . (int) $attendee['member_id'];
			$result = $db->sql_query($sql);
			$member_lastraid = (int) $db->sql_fetchfield('member_lastraid', false, $result);  
			$db->sql_freeresult($result);
			
			$raidbonus = $this->raid_value[$this->batchid]; 
			$timebonus = $attendee['time_bonus']; 
			
			// add raid, time bonuses 
			$sql = 'UPDATE ' . MEMBER_DKP_TABLE . ' m
			   SET m.member_raid_value = m.member_raid_value + ' . (string) $raidbonus . ',	 
			   m.member_time_bonus = m.member_time_bonus + ' . (string) $timebonus . ',	   
			   m.member_earned =  m.member_earned  + ' . (string) floatval($raidbonus + $timebonus) ;
						
			   if ( $member_lastraid < $this->raidbegin)
			   {
				  $sql .= ', m.member_lastraid = ' . $this->raidbegin ;
			   }
			   
			   $sql .= ' , m.member_raidcount = m.member_raidcount + 1
			   WHERE m.member_dkpid = ' . (int) $this->dkp . '
			   AND m.member_id = ' . (int) $attendee['member_id'];
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
		'header'		=> 'L_ACTION_RAID_ADDED', 
		'id'			=> $raid_id, 
		'L_EVENT'		=> $this->eventname[$this->batchid], 
		'L_ATTENDEES'	=> $this->allattendees[$this->batchid], 
		'L_NOTE'		=> $this->globalcomments[$this->batchid], 
		'L_VALUE'		=> $this->raid_value[$this->batchid], 
		'L_ADDED_BY'	=> $user->data ['username'] );
	
		$this->log_insert ( array (
			'log_type'		=> $log_action ['header'], 
			'log_action'	=> $log_action ) );
		
		// commit
		$db->sql_transaction('commit');
	}
	
	/**
	 * inserts new loot in item table increases spent amount per player
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
		
		if ( !class_exists('acp_dkp_mm')) 
		{
			// we need this class for accessing member functions
			include ($phpbb_root_path . 'includes/acp/acp_dkp_mm.' . $phpEx); 
		}
		$acp_dkp_mm = new acp_dkp_mm;
		
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
			$log_actions = array();
			
			// loop items and prepare insert sql 
			foreach($this->bossloots[$this->batchid][$boss]['itemname'] as $key => $item_name)
			{
				$buyername = (string) $this->bossloots[$this->batchid][$boss]['playername'][$key];
				if ($buyername == $config['bbdkp_rt_ignoredlooter'])
				{
					//don't add disenchanted items 
					continue;					
				}
				else 
				{
					$this_memberid = (int) $acp_dkp_mm->get_member_id(trim($buyername));
					if ($this_memberid != 0)
					{
						$items[] = array(
							'item_name'		=> (string) trim($item_name),
							'member_id'		=> (int) $this_memberid,
							'raid_id'		=> (int) $raidid,
							'item_value'	=> (float)	$this->bossloots[$this->batchid][$boss]['cost'][$key],
							'item_date'		=> (int) $this->bosskilltime[$boss],
							'item_group_key' => (string) $groupid[trim($item_name)],
							'item_gameid'	=> (int)  $this->bossloots[$this->batchid][$boss]['itemid'][$key],
							'item_zs'		=> (int) $config['bbdkp_zerosum'],
							'item_added_by' => (string) $user->data ['username'],
							'item_updated_by' => (string) $user->data ['username'],
						);
						
						$log_actions[$key]['header'] = 'L_ACTION_ITEM_ADDED';
						$log_actions[$key]['L_NAME'] = trim($item_name);  
						$log_actions[$key]['L_BUYERS'] = (string) $this->bossloots[$this->batchid][$boss]['playername'][$key];
						$log_actions[$key]['L_RAID_ID'] = (int) $raidid;
						$log_actions[$key]['L_VALUE']  = (float) $this->bossloots[$this->batchid][$boss]['cost'][$key];
						$log_actions[$key]['L_ADDED_BY'] = $user->data['username'];
					}
				}

			}
			$db->sql_multi_insert(RAID_ITEMS_TABLE, $items);

			if($config['bbdkp_zerosum'] == 1)
			{
				//count bosskill attendees 
				$bossattendees = array_unique(explode(',', $this->bossattendees[$this->batchid][$boss]));			

				// make array with boss attendees memberids
				$raiders = array();
				foreach($bossattendees as $name)
				{
					$member_id = (int) $acp_dkp_mm->get_member_id(trim($name));
					if($member_id != $config['bbdkp_bankerid'])
					{
						$raiders[]	= $member_id;
					}
				}
				$numraiders = count($raiders);
				
			}
			
			// loop looted items and increase dkp spent value for buyer
			foreach($items as $key => $item)
			{
				// update dkp account with spent value
				$sql = 'UPDATE ' . MEMBER_DKP_TABLE . ' d				
						SET d.member_spent = d.member_spent + ' . (float) $item['item_value']  .  ' 
						WHERE d.member_dkpid = ' . (int) $this->dkp	 . ' 
						AND member_id = ' . $item['member_id'];
				$db->sql_query ( $sql );
				
				//if zerosum flag is set then distribute item value over raiders
				if($config['bbdkp_zerosum'] == 1)
				{
					//  exception : no redistribution if the item was looted by guildbank
					if ($item['member_id']  == $config['bbdkp_bankerid'] )
					{
						continue;
					}
					
					$distributed = round($item['item_value'] / max(1, $numraiders), 2);
					// rest of division
					$restvalue = $item['item_value'] - ($numraiders * $distributed); 
					
					// increase raid detail table
					$sql = 'UPDATE ' . RAID_DETAIL_TABLE . '				
							SET zerosum_bonus = zerosum_bonus + ' . (float) $distributed . ' 
							WHERE raid_id = ' . (int) $raidid . ' and ' . $db->sql_in_set('member_id', $raiders) ;
					$db->sql_query ( $sql );
					
					// allocate dkp itemvalue bought to all raiders
					$sql = 'UPDATE ' . MEMBER_DKP_TABLE . '	
							SET member_zerosum_bonus = member_zerosum_bonus + ' . (float) $distributed	.  ', 
							member_earned = member_earned + ' . (float) $distributed  .	 ' 
							WHERE member_dkpid = ' . (int) $this->dkp  . ' 
							AND ' . $db->sql_in_set('member_id', $raiders);
							 
					$db->sql_query ($sql);
					
					// give rest value to buyer or to guildbank 
					if($restvalue!=0 )
					{
						$sql = 'UPDATE ' . RAID_DETAIL_TABLE . '				
								SET zerosum_bonus = zerosum_bonus + ' . (float) $restvalue	.  '   
								WHERE raid_id = ' . (int) $raidid . '  
								AND member_id = ' . ($config['bbdkp_zerosumdistother'] == 1 ? $config['bbdkp_bankerid'] : $item['member_id'] );
						$db->sql_query ( $sql );					
						
						$sql = 'UPDATE ' . MEMBER_DKP_TABLE . '					
								SET member_zerosum_bonus = member_zerosum_bonus + ' . (float) $restvalue  .	 ', 
								member_earned = member_earned + ' . (float) $restvalue	.  ' 
								WHERE member_dkpid = ' . (int) $this->dkp  . '  
								AND member_id = ' . ($config['bbdkp_zerosumdistother'] == 1 ? $config['bbdkp_bankerid'] : $item['member_id'] );
						$db->sql_query ( $sql );	
					}
				}
			}
			unset($items);
			
			
			foreach($log_actions as $key => $log_action )
			{
				$this->log_insert ( array (
					'log_type' => $log_action ['header'], 
					'log_action' => $log_action ) );
			}
			
		}
		
	}
	
	
}

?>
