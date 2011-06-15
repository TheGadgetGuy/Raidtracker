<?php
/**
* bbdkp Raidtracker plugin Installer
* Powered by bbDkp (c) 2009 The bbDkp Project Team 
* @version $Id$
* @package umil
* @copyright (c) 2008 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
define('UMIL_AUTO', true);
define('IN_PHPBB', true);
define('ADMIN_START', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);
$user->session_begin();
$auth->acl($user->data);
$user->setup();

// We only allow a founder install this MOD
if ($user->data['user_type'] != USER_FOUNDER)
{
    if ($user->data['user_id'] == ANONYMOUS)
    {
        login_box('', 'LOGIN');
    }
    trigger_error('NOT_AUTHORISED');
}

if (!file_exists($phpbb_root_path . 'umil/umil_auto.' . $phpEx))
{
	trigger_error('Please download the latest UMIL (Unified MOD Install Library) from: <a href="http://www.phpbb.com/mods/umil/">phpBB.com/mods/umil</a>', E_USER_ERROR);
}

// only allow install when wow is installed as game 
// and we have bbDKP 1.23
if  (!isset ($config['bbdkp_games_wow']) )
{
    trigger_error('NOT_AUTHORISED');
}
else
{
	if  ($config['bbdkp_games_wow'] != 1 )
	{
	    trigger_error('NOT_AUTHORISED');
	}
}

// The name of the mod to be displayed during installation.
$mod_name = 'Raidtracker 0.3.2';

/*
* The name of the config variable which will hold the currently installed version
* You do not need to set this yourself, UMIL will handle setting and updating the version itself.
*/
$version_config_name = 'bbdkp_raidtracker';

// old prefix
$bbdkp_table_prefix= 'bbeqdkp_';
/*
* The language file which will be included when installing
* Language entries that should exist in the language file for UMIL (replace $mod_name with the mod's name you set to $mod_name above)
* $mod_name
* 'INSTALL_' . $mod_name
* 'INSTALL_' . $mod_name . '_CONFIRM'
* 'UPDATE_' . $mod_name
* 'UPDATE_' . $mod_name . '_CONFIRM'
* 'UNINSTALL_' . $mod_name
* 'UNINSTALL_' . $mod_name . '_CONFIRM'
*/
$language_file = 'mods/dkp_raidtracker';

/*
* Options to display to the user (this is purely optional, if you do not need the options you do not have to set up this variable at all)
* Uses the acp_board style of outputting information, with some extras (such as the 'default' and 'select_user' options)

$options = array(
	'test_username'	=> array('lang' => 'TEST_USERNAME', 'type' => 'text:40:255', 'explain' => true, 'default' => $user->data['username'], 'select_user' => true),
	'test_boolean'	=> array('lang' => 'TEST_BOOLEAN', 'type' => 'radio:yes_no', 'default' => true),
);
*/

/*
* Optionally we may specify our own logo image to show in the upper corner instead of the default logo.
* $phpbb_root_path will get prepended to the path specified
* Image height should be 50px to prevent cut-off or stretching.
*/
//$logo_img = 'styles/prosilver/imageset/site_logo.gif';

/*
* The array of versions and actions within each.
* You do not need to order it a specific way (it will be sorted automatically), however, you must enter every version, even if no actions are done for it.
*
* You must use correct version numbering.  Unless you know exactly what you can use, only use X.X.X (replacing X with an integer).
* The version numbering must otherwise be compatible with the version_compare function - http://php.net/manual/en/function.version-compare.php
*/

$versions = array(

	'0.2.0' => array(

     // Lets add global config settings
     // we scrap the ctrt_config table
	'config_add' => array(
		array('bbdkp_rt_minitemquality', 'RT_IQ_RARE', true),
		array('bbdkp_rt_ignoredlooter', '', true),
		array('bbdkp_rt_aldkpchkbox', 1),
		array('bbdkp_rt_lootnoteeventtrigger', 0),
		array('bbdkp_rt_attendancefilter', 1, true),
		array('bbdkp_rt_skipempty', 1, true),
		array('bbdkp_rt_defaultcost', 5.0, true),
		array('bbdkp_rt_startdkp', 10.0, true),
		array('bbdkp_rt_createstartraid', 0, true),
		array('bbdkp_rt_startraiddkp', 0.0, true),
		array('bbdkp_rt_replacealtnames', 1, true),
		),
            		
	// raidtracker is now in the raids tree
	'module_add' => array(
		array('acp', 'ACP_DKP_RAIDS', array(
			'module_basename' => 'dkp_rt_import',
			'modes'           => array(
				'rt_parse', 
				'rt_import',
				'rt_delete'),		
			)),

		array('acp', 'ACP_DKP_RAIDS', array(
			'module_basename' => 'dkp_rt_settings',
			'modes'           => array(
				'rt_manage_settings' , 
				'rt_add_items' , 
				'rt_list_items', 
				'rt_import_items',
				'rt_export_items',
				'rt_add_alias',
				'rt_list_alias',
				'rt_import_alias',
				'rt_export_alias',
				'rt_add_event_triggers',
				'rt_list_event_triggers',
				'rt_import_event_triggers',
				'rt_export_event_triggers',
				'rt_add_ignore_items',
				'rt_list_ignore_items',
				'rt_import_ignore_items',
				'rt_export_ignore_items',
				'rt_add_own_raids',
				'rt_list_own_raids',
				'rt_import_own_raids',
				'rt_export_own_raids',
				'rt_add_raid_note_triggers',
				'rt_list_raid_note_triggers',
				'rt_import_raid_note_triggers',
				'rt_export_raid_note_triggers',
                )),
			)),
		
		'table_add' => array(

			// temporary tables for raid import
			// general raidinfo
			array($bbdkp_table_prefix . 'rt_temp_raidinfo', array(
                    'COLUMNS'		=> array(
					   'batchid' 	=> array('VCHAR', ''),
                       'raidid'		=> array('INT:8', NULL, 'auto_increment' ),
		  			   'realm' 		=> array('VCHAR_UNI', ''),
		  			   'starttime' 	=> array('TIMESTAMP', 0),
					   'endtime'   	=> array('TIMESTAMP', 0),
					   'zone'   	=> array('VCHAR_UNI', ''),
					   'note'		=> array('VCHAR_UNI', ''), //raidnote
		  			   'difficulty' => array('USINT', 1),
					   'event_id' 	=> array('INT:8', 0),
					   'dkpsys_id'  => array('INT:8', 0),
			
					),
                    'PRIMARY_KEY'	=> array('raidid'),
					 'KEYS'            => array(
       						 'batchid'   => array('INDEX', 'batchid'),
						)
              ),
            ),  
			
			//playerinfo
            array($bbdkp_table_prefix . 'rt_temp_playerinfo', array(
                    'COLUMNS'		=> array(
            		   'batchid' 	=> array('VCHAR', ''),
                       'raidid'		=> array('INT:8', 0),
					   'playerid'	=> array('INT:8', NULL, 'auto_increment' ),
		  			   'playername' => array('VCHAR_UNI', ''),
            		   'race' 		=> array('VCHAR', ''),
            		   'guild' 		=> array('VCHAR_UNI', ''),
		  			   'sex' 		=> array('BOOL', 0), 
					   'class'   	=> array('VCHAR', ''),
					   'level'   	=> array('USINT', 0),
            		   'value' 		=> array('DECIMAL:11', 0.00),                       
					),
                    'PRIMARY_KEY'	=> array('playerid'),
					 'KEYS'         => array(
       					 'batchid' => array('INDEX', 'batchid'),
       					 'raidid'  => array('INDEX', 'raidid'),
					)
			)),  	

			//join leaves log
            array($bbdkp_table_prefix . 'rt_temp_joininfo', array(
                    'COLUMNS'		=> array(
            		   'batchid' 	=> array('VCHAR', ''),
                       'raidid'		=> array('INT:8', 0),            
             		   'joinlogid'	=> array('INT:8', NULL, 'auto_increment' ),
					   'playerid'	=> array('INT:8', 0),
		  			   'playername' => array('VCHAR_UNI', ''),            
					   'jointime'  	=> array('TIMESTAMP', 0),
            		   'leavetime' 	=> array('TIMESTAMP', 0),
            		),
                    'PRIMARY_KEY'	=> array('joinlogid'),
					 'KEYS'            => array(
						'batchid'   => array('INDEX', 'batchid'),
						'playerid'  => array('INDEX', 'playerid'),
						'raidid'	 => array('INDEX', 'raidid'),
					)            		
              )),  	
            
			//bosskills
            array($bbdkp_table_prefix . 'rt_temp_bosskills', array(
                    'COLUMNS'		=> array(
            		   'batchid' 	=> array('VCHAR', ''),            
					   'bossid'		=> array('INT:8', NULL, 'auto_increment' ),
		  			   'bossname' 	=> array('VCHAR_UNI', ''),
            		   'time' 		=> array('TIMESTAMP', 0),
            		   'zone' 		=> array('VCHAR_UNI', ''),
            		   'difficulty' => array('USINT', 1),
					),
                    'PRIMARY_KEY'	=> array('bossid', ),
					 'KEYS'            => array(
       						 'batchid'   => array('INDEX', 'batchid'),
					)
              ),
            ), 
            
            array($bbdkp_table_prefix . 'rt_temp_attendees', array(
                    'COLUMNS'		=> array(
            		   'batchid' 	=> array('VCHAR', ''),           
					   'bossname'	=> array('VCHAR_UNI', ''),
            		   'playername' => array('VCHAR_UNI', ''),
					),
					 'KEYS'			=> array(
						'batchid'   	=> array('INDEX', 'batchid'),
						'playername'   => array('INDEX', 'playername'),
					)
              )),             
            
            array($bbdkp_table_prefix . 'rt_temp_loot', array(
                    'COLUMNS'		=> array(
            		   'batchid' 	=> array('VCHAR', ''), 
					   'lootid' 	=> array('INT:8', NULL, 'auto_increment' ),     			        
					   'itemid'		=>  array('VCHAR', ''),
					   'itemname' 	=> array('VCHAR_UNI', ''),
            		   'playername' => array('VCHAR_UNI', ''),
            		   'count' 		=> array('INT:8', 0), 
            		   'time' 		=> array('TIMESTAMP', 0),
            		   'quality' 	=> array('VCHAR', ''),
            		   'boss' 		=> array('VCHAR_UNI', ''),
            		   'note' 		=> array('VCHAR_UNI', ''), 
            		   'cost' 		=> array('DECIMAL:11', 0.00),                                                            
					),
					 'PRIMARY_KEY'	=> array('lootid', ),
					 'KEYS'			=> array(
       						 'itemname'   => array('INDEX', 'itemname'),
					)
              ),
            ),      
			            
			array($bbdkp_table_prefix . 'rt_aliases', array(
                    'COLUMNS'		=> array(
                       'alias_id'	=> array('INT:8', NULL, 'auto_increment' ),
                       'alias_member_id' => array('INT:8', 0 ),
		  			   'alias_name' => array('VCHAR_UNI:255', ''),
                  ),
                    'PRIMARY_KEY'	=> array('alias_id'),
              ),
            ),                
                
			array($bbdkp_table_prefix . 'rt_eventtriggers', array(
                    'COLUMNS'		=> array(
                       'event_trigger_id'	=> array('INT:8', NULL, 'auto_increment' ),
                       'event_trigger' => array('VCHAR_UNI:255', ''),
		  			   'event_id' 	   => array('INT:8', 0),
                    ),
                    'PRIMARY_KEY'	=> array('event_trigger_id'),
                    'KEYS'			=> array(
       						 'event_trigger'   => array('UNIQUE', 'event_trigger'),
					)
              ),
            ),   

			array($bbdkp_table_prefix . 'rt_raidnote_triggers', array(
                    'COLUMNS'		=> array(
                       'raid_note_trigger_id'	=> array('INT:8', NULL, 'auto_increment' ),
                       'raid_trigger' => array('VCHAR_UNI:255', ''),
		  			   'raid' => array('VCHAR_UNI:255', ''),
                    ),
                    'PRIMARY_KEY'	=> array('raid_note_trigger_id'),
              ),
            ),   

			array($bbdkp_table_prefix . 'rt_ownraids', array(
                    'COLUMNS'		=> array(
                       'own_raid_id'	=> array('INT:8', NULL, 'auto_increment' ),
                       'own_raid_name' => array('VCHAR_UNI:255', ''),
                    ),
                    'PRIMARY_KEY'	=> array('own_raid_id'),
              ),
            ),   
            
			array($bbdkp_table_prefix . 'rt_additems', array(
                    'COLUMNS'		=> array(
                       'add_items_id'	=> array('INT:8', NULL, 'auto_increment' ),
                       'add_items_wow_id' => array('INT:8', 0 ),
                    ),
                    'PRIMARY_KEY'	=> array('add_items_id'),
              ),
            ),   
            
			array($bbdkp_table_prefix . 'rt_ignoreitems', array(
                    'COLUMNS'		=> array(
                       'ignore_items_id'	=> array('INT:8', NULL, 'auto_increment' ),
                       'ignore_items_wow_id' =>  array('INT:8', 0 ),
                    ),
                    'PRIMARY_KEY'	=> array('ignore_items_id'),
              ),
            ),   

		),
		
		'custom' => array('raidtrackerupdater'),   
		
	),
	
	'0.2.1' => array(

	 // add a parameter to set logging one global raid - set default to false
	'config_add' => array(
		array('bbdkp_rt_bossraid', 0, true),)
		,
		'custom' => array('raidtrackerupdater021'),
		
	
	),

	'0.2.2' => array(
	
	// add a parameter to set hourly dkp to be assigned
	'config_add' => array(
		array('bbdkp_rt_hourdkp', 0.00, true),)	
	
	),

	'0.2.3' => array(

	// remove the skip empty raidnote setting
	'config_remove' => array(
		array('bbdkp_rt_skipempty'),
		),	
	
	),

	'0.2.4' => array(
	// no db change, only a bugfix
		'custom' => array('raidtrackerupdater'),
	),

	'0.2.5' => array(
	// no db change, only a bugfix
		'custom' => array('raidtrackerupdater'),
	),
	
	'0.2.6' => array(
	// no db change, only a bugfix
		'custom' => array('raidtrackerupdater'),
	),
	
	'0.2.7' => array(
	// no db change, only a bugfix
		'custom' => array('raidtrackerupdater'),
	),
	
	'0.2.8' => array(
	// no db change, only a bugfix
		'custom' => array('raidtrackerupdater'),
	),
	
	'0.3.0' => array(
		'custom' => array('raidtrackerupdater', 'tablerename'),   
		
		
		'config_add' => array(
			array('bbdkp_rt_noguild', '1', true),
		),
		
	     // remove config settings that were moved to core
		'config_remove' => array(
			array('bbdkp_rt_aldkpchkbox'),
			array('bbdkp_rt_startdkp'),
			array('bbdkp_rt_createstartraid'),
			array('bbdkp_rt_startraiddkp'),
			),
			
		// new column to check if raid was imported		
		'table_column_add' => array(
			array($table_prefix . 'bbdkp_rt_temp_raidinfo', 'imported' , array('BOOL', 0)),
			),
	),

	'0.3.1' => array (
	  // no db change, but many bugfixes 
	  	'custom' => array('raidtrackerupdater'),
	  	'config_update' => array(
			array('bbdkp_rt_ignoredlooter', 'disenchanted', true),
		),
		// the name of the bank in the XML to be tied to the bbDKP Guildbank
	   'config_add' => array(
			array('bbdkp_rt_xmlbanker', 'bank', true)),		
	
	),
	
	'0.3.2' => array (
	  // change in raid creation code..
	  	'custom' => array('raidtrackerupdater'),
	
	),
	
	'0.3.3' => array (
	  // code bugfix, no db change.
	  	'custom' => array('raidtrackerupdater'),
	
	),
		
);

// We include the UMIF Auto file and everything else will be handled automatically.
include($phpbb_root_path . 'umil/umil_auto.' . $phpEx);

function raidtrackerupdater($action, $version)
{
	global $db, $table_prefix, $umil, $phpbb_root_path, $phpEx;
	switch ($action)
	{
		case 'install' :
		case 'update' :
            
            $umil->table_row_remove($table_prefix . 'bbdkp_plugins',
                array('name'  => 'ctrt')
            );

            $umil->table_row_remove($table_prefix . 'bbdkp_plugins',
                array('name'  => 'RaidTracker')
            );
                        
			$umil->table_row_insert($table_prefix . 'bbdkp_plugins', 	
		    array(
                array(
        				'name'  => 'RaidTracker', 
        				'value'  => '1', 
        				'version'  => $version, 								
        				'orginal_copyright'  => 'ippeh', 				
        				'bbdkp_copyright'  => 'bbDKP Team', 
                    ),
            ));		

       		return array('command' => 'RAIDTRACKER_INSTALL_MOD', 'result' => 'SUCCESS');
			break; 
			
		case 'uninstall' :
			// Run this when uninstalling

			return array('command' => 'RAIDTRACKER_UNINSTALL_MOD', 'result' => 'SUCCESS');
			break;
	
	}
}

/******************************
 *  table rename update calls 
 */
function tablerename($action, $version)
{
	global $user, $config, $db, $table_prefix, $umil, $bbdkp_table_prefix; 
	switch ($action)
	{
		case 'install' :
		case 'update' :
		
			switch ($version)
			{
				case '0.3.0':
					// renaming tables
					if ($umil->table_exists($bbdkp_table_prefix . 'rt_temp_raidinfo'))
					{
						$sql = 'RENAME TABLE ' . $bbdkp_table_prefix . 'rt_temp_raidinfo TO ' . $table_prefix . 'bbdkp_rt_temp_raidinfo ';
						$db->sql_query($sql);
					}
					if ($umil->table_exists($bbdkp_table_prefix . 'rt_temp_playerinfo'))
					{
						$sql = 'RENAME TABLE ' . $bbdkp_table_prefix . 'rt_temp_playerinfo TO ' . $table_prefix . 'bbdkp_rt_temp_playerinfo ';
						$db->sql_query($sql);
					}
					if ($umil->table_exists($bbdkp_table_prefix . 'rt_temp_playerinfo'))
					{
						$sql = 'RENAME TABLE ' . $bbdkp_table_prefix . 'rt_temp_playerinfo TO ' . $table_prefix . 'bbdkp_rt_temp_playerinfo ';
						$db->sql_query($sql);
					}
					if ($umil->table_exists($bbdkp_table_prefix . 'rt_temp_joininfo'))
					{
						$sql = 'RENAME TABLE ' . $bbdkp_table_prefix . 'rt_temp_joininfo TO ' . $table_prefix . 'bbdkp_rt_temp_joininfo ';
						$db->sql_query($sql);
					}										
					if ($umil->table_exists($bbdkp_table_prefix . 'rt_temp_bosskills'))
					{
						$sql = 'RENAME TABLE ' . $bbdkp_table_prefix . 'rt_temp_bosskills TO ' . $table_prefix . 'bbdkp_rt_temp_bosskills ';
						$db->sql_query($sql);
					}										
					if ($umil->table_exists($bbdkp_table_prefix . 'rt_temp_attendees'))
					{
						$sql = 'RENAME TABLE ' . $bbdkp_table_prefix . 'rt_temp_attendees TO ' . $table_prefix . 'bbdkp_rt_temp_attendees ';
						$db->sql_query($sql);
					}										
					if ($umil->table_exists($bbdkp_table_prefix . 'rt_temp_loot'))
					{
						$sql = 'RENAME TABLE ' . $bbdkp_table_prefix . 'rt_temp_loot TO ' . $table_prefix . 'bbdkp_rt_temp_loot ';
						$db->sql_query($sql);
					}
					if ($umil->table_exists($bbdkp_table_prefix . 'rt_aliases'))
					{
						$sql = 'RENAME TABLE ' . $bbdkp_table_prefix . 'rt_aliases TO ' . $table_prefix . 'bbdkp_rt_aliases ';
						$db->sql_query($sql);
					}
					if ($umil->table_exists($bbdkp_table_prefix . 'rt_eventtriggers'))
					{
						$sql = 'RENAME TABLE ' . $bbdkp_table_prefix . 'rt_eventtriggers TO ' . $table_prefix . 'bbdkp_rt_eventtriggers ';
						$db->sql_query($sql);
					}					
					if ($umil->table_exists($bbdkp_table_prefix . 'rt_raidnote_triggers'))
					{
						$sql = 'RENAME TABLE ' . $bbdkp_table_prefix . 'rt_raidnote_triggers TO ' . $table_prefix . 'bbdkp_rt_raidnote_triggers ';
						$db->sql_query($sql);
					}			
					if ($umil->table_exists($bbdkp_table_prefix . 'rt_ownraids'))
					{
						$sql = 'RENAME TABLE ' . $bbdkp_table_prefix . 'rt_ownraids TO ' . $table_prefix . 'bbdkp_rt_ownraids ';
						$db->sql_query($sql);
					}																					
					if ($umil->table_exists($bbdkp_table_prefix . 'rt_additems'))
					{
						$sql = 'RENAME TABLE ' . $bbdkp_table_prefix . 'rt_additems TO ' . $table_prefix . 'bbdkp_rt_additems ';
						$db->sql_query($sql);
					}																					
					if ($umil->table_exists($bbdkp_table_prefix . 'rt_ignoreitems'))
					{
						$sql = 'RENAME TABLE ' . $bbdkp_table_prefix . 'rt_ignoreitems TO ' . $table_prefix . 'bbdkp_rt_ignoreitems ';
						$db->sql_query($sql);
					}
					return array('command' => 'UMIL_RENAMETABLESNEW', 'result' => 'SUCCESS');
					
					break;
			}
			break;
			
		case 'uninstall' :
				// Run this when uninstalling
				// renaming tables back to old
					if ($umil->table_exists($table_prefix . 'bbdkp_rt_temp_raidinfo'))
					{
						$sql = 'RENAME TABLE ' . $table_prefix . 'bbdkp_rt_temp_raidinfo TO ' . $bbdkp_table_prefix . 'rt_temp_raidinfo ';
						$db->sql_query($sql);
					}
					if ($umil->table_exists($table_prefix . 'bbdkp_rt_temp_playerinfo'))
					{
						$sql = 'RENAME TABLE ' . $table_prefix . 'bbdkp_rt_temp_playerinfo TO ' . $bbdkp_table_prefix . 'rt_temp_playerinfo ';
						$db->sql_query($sql);
					}
					if ($umil->table_exists($table_prefix . 'bbdkp_rt_temp_playerinfo'))
					{
						$sql = 'RENAME TABLE ' . $table_prefix . 'bbdkp_rt_temp_playerinfo TO ' . $bbdkp_table_prefix . 'rt_temp_playerinfo ';
						$db->sql_query($sql);
					}
					if ($umil->table_exists($table_prefix . 'bbdkp_rt_temp_joininfo'))
					{
						$sql = 'RENAME TABLE ' . $table_prefix . 'bbdkp_rt_temp_joininfo TO ' . $bbdkp_table_prefix . 'rt_temp_joininfo ';
						$db->sql_query($sql);
					}										
					if ($umil->table_exists($table_prefix . 'bbdkp_rt_temp_bosskills'))
					{
						$sql = 'RENAME TABLE ' . $table_prefix . 'bbdkp_rt_temp_bosskills TO ' . $bbdkp_table_prefix . 'rt_temp_bosskills ';
						$db->sql_query($sql);
					}										
					if ($umil->table_exists($table_prefix . 'bbdkp_rt_temp_attendees'))
					{
						$sql = 'RENAME TABLE ' . $table_prefix . 'bbdkp_rt_temp_attendees TO ' . $bbdkp_table_prefix . 'rt_temp_attendees ';
						$db->sql_query($sql);
					}										
					if ($umil->table_exists($table_prefix . 'bbdkp_rt_temp_loot'))
					{
						$sql = 'RENAME TABLE ' . $table_prefix . 'bbdkp_rt_temp_loot TO ' . $bbdkp_table_prefix . 'rt_temp_loot ';
						$db->sql_query($sql);
					}
					if ($umil->table_exists($table_prefix . 'bbdkp_rt_aliases'))
					{
						$sql = 'RENAME TABLE ' . $table_prefix . 'bbdkp_rt_aliases TO ' . $bbdkp_table_prefix . 'rt_aliases ';
						$db->sql_query($sql);
					}
					if ($umil->table_exists($table_prefix . 'bbdkp_rt_eventtriggers'))
					{
						$sql = 'RENAME TABLE ' . $table_prefix . 'bbdkp_rt_eventtriggers TO ' . $bbdkp_table_prefix . 'rt_eventtriggers ';
						$db->sql_query($sql);
					}					
					if ($umil->table_exists($table_prefix . 'bbdkp_rt_raidnote_triggers'))
					{
						$sql = 'RENAME TABLE ' . $table_prefix . 'bbdkp_rt_raidnote_triggers TO ' . $bbdkp_table_prefix . 'rt_raidnote_triggers ';
						$db->sql_query($sql);
					}
					if ($umil->table_exists($table_prefix . 'bbdkp_rt_ownraids'))
					{
						$sql = 'RENAME TABLE ' . $table_prefix . 'bbdkp_rt_ownraids TO ' . $bbdkp_table_prefix . 'rt_ownraids ';
						$db->sql_query($sql);
					}																					
					if ($umil->table_exists($table_prefix . 'bbdkp_rt_additems'))
					{
						$sql = 'RENAME TABLE ' . $table_prefix . 'bbdkp_rt_additems TO ' . $bbdkp_table_prefix . 'rt_additems ';
						$db->sql_query($sql);
					}																					
					if ($umil->table_exists($table_prefix . 'bbdkp_rt_ignoreitems'))
					{
						$sql = 'RENAME TABLE ' . $table_prefix . 'bbdkp_rt_ignoreitems TO ' . $bbdkp_table_prefix . 'rt_ignoreitems ';
						$db->sql_query($sql);
					}							
					
					return array('command' => 'UMIL_RENAMETABLESOLD', 'result' => 'SUCCESS');
			break;
	}
	
	 
}

?>