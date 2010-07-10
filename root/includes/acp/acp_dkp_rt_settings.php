<?php
/**
* This class manages all the Ct_raidtracker settings
*
* @author Sajaki@bbdkp.com
* @package bbDkp.acp
* @copyright (c) 2009 bbdkp http://code.google.com/p/bbdkp/
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* $Id$
* 
**/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (! defined('EMED_BBDKP')) 
{
	$user->add_lang ( array ('mods/dkp_raidtracker' ));
    trigger_error($user->lang ['RT_DISABLED'], E_USER_WARNING);
}

class acp_dkp_rt_settings extends bbDkp_Admin 
{
	var $u_action;
	var $Raidtrackerlink; 
	
	function main($id, $mode) 
	{
		global $db, $user, $auth, $template, $sid, $cache;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;
		
		$user->add_lang ( array ('mods/dkp_raidtracker' ) );
		$this->Raidtrackerlink = '<br /><a href="'. append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;" ) . '"><h3>Return to Index</h3></a>'; 
		
		// main tabs
		$template->assign_vars ( array (
				//tab links
				'U_MANAGE_SETTINGS' 	=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_manage_settings" ), 
				'U_ADDITEMS' 			=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_add_items" ), 
				'U_ALIASES' 			=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_add_alias" ), 
				'U_EVENT_TRIGGER' 		=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_add_event_triggers" ), 
				'U_IGNOREITEM' 			=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_add_ignore_items" ), 			
				'U_ADDOWNRAIDS' 		=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_add_own_raids" ), 
				'U_RAIDNOTETRIGGERS' 	=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_add_raid_note_triggers" ), 	
        ));
        
        // own items sub tabs
         $template->assign_vars ( array (
					//tab links
					'U_ADDITEMS' 			=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_add_items" ), 
					'U_LISITEMS' 			=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_list_items" ), 
					'U_EXPITEMS' 			=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_export_items" ), 
					'U_IMPITEMS' 			=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_import_items" ), 
				));
        // alias sub tabs
         $template->assign_vars ( array (
					//tab links
					'U_ADDALIAS' 			=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_add_alias" ),
					'U_LISALIAS' 			=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_list_alias" ), 
					'U_EXPALIAS' 			=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_export_alias" ), 
					'U_IMPALIAS' 			=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_import_alias" ), 
				));
				        
        // event trigger sub tabs
         $template->assign_vars ( array (
					//tab links
					'U_ADDEVTRIG' 			=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_add_event_triggers" ),
					'U_LISEVTRIG' 			=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_list_event_triggers" ), 
					'U_EXPEVTRIG' 			=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_export_event_triggers" ), 
					'U_IMPEVTRIG' 			=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_import_event_triggers" ), 
				));
				
        // ignore items sub tabs
         $template->assign_vars ( array (
					//tab links
					'U_ADDIGNORE' 			=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_add_ignore_items" ),
					'U_LISIGNORE' 			=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_list_ignore_items" ), 
					'U_EXPIGNORE' 			=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_export_ignore_items" ), 
					'U_IMPIGNORE' 			=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_import_ignore_items" ), 
				));
				
        // add own raid sub tabs
         $template->assign_vars ( array (
					//tab links
					'U_ADDOWNRAID' 			=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_add_own_raids" ),
					'U_LISOWNRAID' 			=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_list_own_raids" ), 
					'U_EXPOWNRAID' 			=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_export_own_raids" ), 
					'U_IMPOWNRAID' 			=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_import_own_raids" ),  
				));
				
		 // add raid triggers sub tabs
         $template->assign_vars ( array (
					//tab links
					'U_ADDRAIDTRIG' 			=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_add_raid_note_triggers" ), 
					'U_LISRAIDTRIG' 			=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_list_raid_note_triggers" ),  
					'U_EXPRAIDTRIG' 			=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_export_raid_note_triggers" ), 
					'U_IMPRAIDTRIG' 			=> append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_import_raid_note_triggers" ), 
				));
				
				
				
		switch ($mode) 
		
		{
			case 'rt_manage_settings' :

				/**
				 * Create the Minimum Quality menu
				 */
				$quality = array (
				RT_IQ_POOR       => $user->lang ['RT_IQ_POOR'], 
				RT_IQ_COMMON     => $user->lang ['RT_IQ_COMMON'], 
				RT_IQ_UNCOMMON   => $user->lang ['RT_IQ_UNCOMMON'], 
				RT_IQ_RARE       => $user->lang ['RT_IQ_RARE'], 
				RT_IQ_EPIC		 => $user->lang ['RT_IQ_EPIC'], 
				RT_IQ_LEGENDARY  => $user->lang ['RT_IQ_LEGENDARY'] );
				
				foreach ( $quality as $key => $value ) 
				{
					$template->assign_block_vars ( 'quality_row', array (
					'VALUE' => $key, 
					'SELECTED' => ($key == $config['bbdkp_rt_minitemquality']) ? ' selected="selected"' : '', 
					'OPTION' => $value ) );
				}
				

				/**
				 * Create the Attenance Filter menu
				 */
				$attendance = array (
				RT_AF_NONE         => $user->lang ['RT_AF_NONE'], 
				RT_AF_BOSS_KILL    => $user->lang ['RT_AF_BOSS_KILL'] );
				
				foreach ( $attendance as $key => $value ) 
				{
					$template->assign_block_vars ( 'attendance_row', array (
					'VALUE' => $key, 
					'SELECTED' => ($key == $config ['bbdkp_rt_attendancefilter']) ? ' selected="selected"' : '', 
					'OPTION' => $value ) );
				}
				
				$submit = (isset ( $_POST ['submit'] )) ? true : false;
				if ($submit) 
				{
					// Update each config setting
					set_config  ( 'bbdkp_rt_minitemquality',  request_var('min_item_quality', ' '), 0);  
					set_config  ( 'bbdkp_rt_ignoredlooter',  utf8_normalize_nfc(request_var('ignored_looter', ' ', true)), 0);  
					set_config  ( 'bbdkp_rt_aldkpchkbox',  (isset ( $_POST ['add_loot_dkp'] )) ? 1 : 0 , 0);  
					set_config  ( 'bbdkp_rt_lootnoteeventtrigger',  (isset ( $_POST ['event_trigger'] )) ? 1 : 0 , 0);  
					set_config  ( 'bbdkp_rt_attendancefilter',  request_var('attendance_filter', ''), 0);  
					set_config  ( 'bbdkp_rt_defaultcost',  request_var('default_dkp', 0.00), 0);  
					set_config  ( 'bbdkp_rt_startdkp',  request_var('starting_dkp' , 0.00 ), 0);  
					set_config  ( 'bbdkp_rt_hourdkp',  request_var('dkphour' , 0.00 ), 0);  
					set_config  ( 'bbdkp_rt_replacealtnames', (isset ( $_POST ['replacealtnames'] )) ? 1 : 0 , 0);  
					set_config  ( 'bbdkp_rt_bossraid',  request_var('bossraid', 0));
					// purge cache
					$cache->destroy('config');
					
					$log_action = array (
					'header' 		 => 'L_ACTION_CTRT_CONFIG_UPDATED', 
					'L_UPDATED_BY'   => $user->data['username']);
					
					$this->log_insert ( array (
					'log_type' => $log_action ['header'], 
					'log_action' => $log_action ) );
					
					trigger_error ( sprintf($user->lang['RT_SETTINGS_UPDATE_SUCCESS'], $user->data['username']) . $this->Raidtrackerlink, E_USER_NOTICE );
				}
				
				$template->assign_vars ( array (
				
				// Form values
				'IGNORED_LOOTER'         => $config  ['bbdkp_rt_ignoredlooter'], 
				'ADD_LOOT_DKP'           => ((int) $config ['bbdkp_rt_aldkpchkbox'] == 1) ? 'checked="checked"' : "", 
				'EVENT_TRIGGER'          => ((int) $config ['bbdkp_rt_lootnoteeventtrigger'] == 1) ? 'checked="checked"' : "", 
				'DEFAULT_DKP'            => $config  ['bbdkp_rt_defaultcost'], 
				'STARTING_DKP'           => $config  ['bbdkp_rt_startdkp'], 
				'REPLACEALTS'            => ((int) $config ['bbdkp_rt_replacealtnames'] == 1) ? 'checked="checked"' : "", 
				'DKPHOUR'				=>  $config  ['bbdkp_rt_hourdkp'],
				'BOSSRAID_YES_CHECKED' 	=> ( $config['bbdkp_rt_bossraid'] == '1' ) ? ' checked="checked"' : '',
    			'BOSSRAID_NO_CHECKED'  	=> ( $config['bbdkp_rt_bossraid'] == '0' ) ? ' checked="checked"' : '', 
				
				
				// Form validation
				'FV_DEFAULT_DKP' => $this->fv->generate_error ( 'default_dkp' ), 
				'FV_STARTING_DKP' => $this->fv->generate_error ( 'starting_dkp' ), 
				'FV_START_RAID_DKP' => $this->fv->generate_error ( 'start_raid_dkp' ) )

				 );
				

				break;
			
			case 'rt_add_items' :

				include ($phpbb_root_path . "includes/bbdkp/raidtracker/additems/add.$phpEx");
				$extension = new Raidtracker_AddItem( );
				$submit = (isset ( $_POST ['add'] )) ? true : false;
				$update = (isset ( $_POST ['update'] )) ? true : false;
				$delete = (isset ( $_POST ['delete'] )) ? true : false;
				
				if ($submit) 
				{
					$extension->item_add();
				}
				if ($update) 
				{
					$extension->item_update();
				}
				if ($delete) 
				{
					$extension->item_delete();
				}

				break;
			
			case 'rt_list_items' :

				include ($phpbb_root_path . "includes/bbdkp/raidtracker/additems/list.$phpEx");		
				$extension = new Raidtracker_ListAddItems ( );	

				break;
			
			case 'rt_import_items' :
				
		        if (! class_exists('CTRT_XML'))
        		{
            		include ($phpbb_root_path . 'includes/bbdkp/raidtracker/ctrt_xml.' . $phpEx); 
        		}
				include ($phpbb_root_path . "includes/bbdkp/raidtracker/additems/import.$phpEx");
				
				$extension = new Raidtracker_ImportAddItem ( );
				
				$submit = (isset ( $_POST ['import'] )) ? true : false;
				
				if ($submit) 
				{
					$extension->process_import();
				}
				break;
			
			case 'rt_export_items' :

		        if (! class_exists('CTRT_XML'))
        		{
            		include ($phpbb_root_path . 'includes/bbdkp/raidtracker/ctrt_xml.' . $phpEx); 
        		}
				include ($phpbb_root_path . "includes/bbdkp/raidtracker/additems/export.$phpEx");
				
				$extension = new Raidtracker_ExportAddItem ( );		

				break;
			
			case 'rt_add_alias' :
				
				include ($phpbb_root_path . "includes/bbdkp/raidtracker/aliases/add.$phpEx");

				$extension = new Raidtracker_AddAlias ( );

				$submit = (isset ( $_POST ['add'] )) ? true : false;
				$update = (isset ( $_POST ['update'] )) ? true : false;
				$delete = (isset ( $_POST ['delete'] )) ? true : false;
				
				if ($submit) 
				{
					$extension->alias_add();
				}
				if ($update) 
				{
					$extension->alias_update();
				}
				if ($delete) 
				{
					$extension->alias_delete();
				}

				break;
				
			case 'rt_list_alias' :
				
				include ($phpbb_root_path . "includes/bbdkp/raidtracker/aliases/list.$phpEx");
				$extension = new Raidtracker_ListAliases ( );
				
				break;

			case 'rt_import_alias' :
				
		        if (! class_exists('CTRT_XML'))
        		{
            		include ($phpbb_root_path . 'includes/bbdkp/raidtracker/ctrt_xml.' . $phpEx); 
        		}
				include ($phpbb_root_path . "includes/bbdkp/raidtracker/aliases/import.$phpEx");
				
				$extension = new Raidtracker_ImportAliases( );
				
				$submit = (isset ( $_POST ['import'] )) ? true : false;
				
				if ($submit) 
				{
					$extension->process_import();
				}
			
				break;

			case 'rt_export_alias' :
				
				if (! class_exists('CTRT_XML'))
        		{
            		include ($phpbb_root_path . 'includes/bbdkp/raidtracker/ctrt_xml.' . $phpEx); 
        		}
				include ($phpbb_root_path . "includes/bbdkp/raidtracker/aliases/export.$phpEx");
				
				$extension = new Raidtracker_ExportAliases ( );
				
				break;
			
			case 'rt_add_event_triggers' :
				
				include ($phpbb_root_path . 'includes/bbdkp/raidtracker/eventtriggers/add.' . $phpEx);
				
				$extension = new Raidtracker_AddEventTrigger ( );
								
				$submit = (isset ( $_POST ['add'] )) ? true : false;
				$update = (isset ( $_POST ['update'] )) ? true : false;
				$delete = (isset ( $_POST ['delete'] )) ? true : false;
				
				if ($submit) 
				{
					$extension->event_add ();
				}
				if ($update) 
				{
					$extension->event_update ();
				}
				if ($delete) 
				{
					$extension->event_delete ();
				}

				break;
			
			case 'rt_list_event_triggers' :
				
		       include ($phpbb_root_path . 'includes/bbdkp/raidtracker/eventtriggers/list.' . $phpEx);
				$extension = new Raidtracker_ListEventTriggers ( );

				break;
			
			case 'rt_import_event_triggers' :
		       
				if (! class_exists('CTRT_XML'))
        		{
            		include ($phpbb_root_path . 'includes/bbdkp/raidtracker/ctrt_xml.' . $phpEx); 
        		}
				include ($phpbb_root_path . 'includes/bbdkp/raidtracker/eventtriggers/import.' . $phpEx);
				
				$extension = new Raidtracker_ImportEventTriggers ( );
				$submit = (isset ( $_POST ['import'] )) ? true : false;
				
				if ($submit) 
				{
					$extension->process_import ();
				}
				
				break;
			
			case 'rt_export_event_triggers' :
		     	if (! class_exists('CTRT_XML'))
        		{
            		include ($phpbb_root_path . 'includes/bbdkp/raidtracker/ctrt_xml.' . $phpEx); 
        		}
				include ($phpbb_root_path . 'includes/bbdkp/raidtracker/eventtriggers/export.' . $phpEx);
				
				$extension = new Raidtracker_ExportEventTriggers ( );	

				break;
			
			case 'rt_add_ignore_items' :
				include ($phpbb_root_path . 'includes/bbdkp/raidtracker/ignoreitems/add.' . $phpEx);
				$extension = new Raidtracker_AddIgnoreItem ( );
				
				$submit = (isset ( $_POST ['add'] )) ? true : false;
				$update = (isset ( $_POST ['update'] )) ? true : false;
				$delete = (isset ( $_POST ['delete'] )) ? true : false;
				
				if ($submit) 
				{
					$extension->item_add();
				}
				if ($update) 
				{
					$extension->item_update();
				}
				if ($delete) 
				{
					$extension->item_delete();
				}
				
				$this->page_title = $user->lang ['RTSETTINGS'];
				$this->tpl_name = 'dkp/acp_' . $mode;
				
				break;
			
			case 'rt_list_ignore_items' :
				include ($phpbb_root_path . 'includes/bbdkp/raidtracker/ignoreitems/list.' . $phpEx);
				
				$extension = new Raidtracker_ListIgnoreItems ( );
				
				

				break;
			
			case 'rt_import_ignore_items' :
				if (! class_exists('CTRT_XML'))
        		{
            		include ($phpbb_root_path . 'includes/bbdkp/raidtracker/ctrt_xml.' . $phpEx); 
        		}
				include ($phpbb_root_path . 'includes/bbdkp/raidtracker/ignoreitems/import.' . $phpEx);
				
				$extension = new Raidtracker_ImportIgnoreItems ( );
				$submit = (isset ( $_POST ['import'] )) ? true : false;
				
				if ($submit) 
				{
					$extension->item_import ();
				}
				
				$this->page_title = $user->lang ['RTSETTINGS'];
				$this->tpl_name = 'dkp/acp_' . $mode;			
				break;
			
			case 'rt_export_ignore_items' :
				if (! class_exists('CTRT_XML'))
        		{
            		include ($phpbb_root_path . 'includes/bbdkp/raidtracker/ctrt_xml.' . $phpEx); 
        		}
				include ($phpbb_root_path . 'includes/bbdkp/raidtracker/ignoreitems/export.' . $phpEx);

				$extension = new Raidtracker_ExportIgnoreItem ( ); 
				
				break;
			
			case 'rt_add_own_raids' :
				include ($phpbb_root_path . 'includes/bbdkp/raidtracker/ownraids/add.' . $phpEx);
				
				$extension = new Raidtracker_AddOwnRaid ();
				
				$submit = (isset ( $_POST ['add'] )) ? true : false;
				$update = (isset ( $_POST ['update'] )) ? true : false;
				$delete = (isset ( $_POST ['delete'] )) ? true : false;
				
				if ($submit) 
				{
					$extension->process_add ();
				}
				if ($update) 
				{
					$extension->process_update ();
				}
				if ($delete) 
				{
					$extension->process_delete ();
				}
				
				$this->page_title = $user->lang ['RTSETTINGS'];
				$this->tpl_name = 'dkp/acp_' . $mode;		
				break;
			
			case 'rt_list_own_raids' :
				include ($phpbb_root_path . 'includes/bbdkp/raidtracker/ownraids/list.' . $phpEx);
				$extension = new Raidtracker_ListOwnRaids ( );
					
				break;
			
			case 'rt_import_own_raids' :
				if (! class_exists('CTRT_XML'))
        		{
            		include ($phpbb_root_path . 'includes/bbdkp/raidtracker/ctrt_xml.' . $phpEx); 
        		}
				include ($phpbb_root_path . 'includes/bbdkp/raidtracker/ownraids/import.' . $phpEx);
				
				$extension = new Raidtracker_ImportOwnRaids ( );
				$submit = (isset ( $_POST ['import'] )) ? true : false;
				
				if ($submit) 
				{
					$extension->process_import ();
				}
				break;
			
			case 'rt_export_own_raids' :
				if (! class_exists('CTRT_XML'))
        		{
            		include ($phpbb_root_path . 'includes/bbdkp/raidtracker/ctrt_xml.' . $phpEx); 
        		}
				include ($phpbb_root_path . 'includes/bbdkp/raidtracker/ownraids/export.' . $phpEx);
				$extension = new Raidtracker_ExportOwnRaids ( );
				
				break;
			
			case 'rt_add_raid_note_triggers' :
				include ($phpbb_root_path . 'includes/bbdkp/raidtracker/raidnotetriggers/add.' . $phpEx);
				
				$extension = new Raidtracker_AddRaidNoteTrigger ( );
								
				$submit = (isset ( $_POST ['add'] )) ? true : false;
				$update = (isset ( $_POST ['update'] )) ? true : false;
				$delete = (isset ( $_POST ['delete'] )) ? true : false;
				
				if ($submit) 
				{
					$extension->process_add ();
				}
				if ($update) 
				{
					$extension->process_update ();
				}
				if ($delete) 
				{
					$extension->process_delete ();
				}

				break;
			
			case 'rt_list_raid_note_triggers' :
				
				include ($phpbb_root_path . 'includes/bbdkp/raidtracker/raidnotetriggers/list.' . $phpEx);			
				$extension = new Raidtracker_ListRaidNoteTriggers ( );
				
				break;
			
			case 'rt_import_raid_note_triggers' :
				if (! class_exists('CTRT_XML'))
        		{
            		include ($phpbb_root_path . 'includes/bbdkp/raidtracker/ctrt_xml.' . $phpEx); 
        		}
				include ($phpbb_root_path . 'includes/bbdkp/raidtracker/raidnotetriggers/import.' . $phpEx);
				
				$extension = new Raidtracker_ImportRaidNoteTriggers ( );  
								
				$submit = (isset ( $_POST ['import'] )) ? true : false;
				
				if ($submit) 
				{
					$extension->process_import ();
				}
				
				break;
			
			case 'rt_export_raid_note_triggers' :
				if (! class_exists('CTRT_XML'))
        		{
            		include ($phpbb_root_path . 'includes/bbdkp/raidtracker/ctrt_xml.' . $phpEx); 
        		}
				include ($phpbb_root_path . 'includes/bbdkp/raidtracker/raidnotetriggers/export.' . $phpEx);
				
				$extension = new Raidtracker_ExportRaidNoteTriggers ( );
								
				break;
		}
		
		$this->tpl_name = 'dkp/acp_' . $mode;
	}
	
	/*
	 * function used to check xml in Raidtracker preferences
	 * 
	 * returns Simplexml object
	 * 
	 */
	function xmlparse($xml)
	{
		global $user;
		
		$xml = str_replace ("&", "and", html_entity_decode($xml)); 
		
        $xml = '<?xml version="1.0" encoding="utf-8"?>' . trim($xml) ; 
        
		if (strlen($xml)<=40)
		{
			 trigger_error( $user->lang['RT_TRIGGERXML_NODATA'] . $this->Raidtrackerlink, E_USER_WARNING);
		}
		
        // set libxml error handler on
        libxml_use_internal_errors(true);
        
    	if (!$this->_allowSimpleXMLOptions())
		{
			//CDATA tags will be set manually to text
			$doc = $this->_removeCData($xml);
			// returns a SimpleXMLElement object 
			$doc = simplexml_load_string($xml, 'SimpleXMLElement');
		}
		else
		{
			// load and set CDATA as Text nodes
			// returns a SimpleXMLElement  object
			$doc = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
		}
		
		$xmlcheck = explode("\n", $doc);
		if(!$doc)
        {
	       $errors = libxml_get_errors();
	       if (!empty($errors))
	       {
	       		 $message = ''; 
		         foreach ($errors as $error) 
		         {
   					$message .= 
   					utf8_htmlspecialchars($xmlcheck[$error->line-1]) . '<br />' . 
   					utf8_htmlspecialchars($xmlcheck[$error->line]) . '<br />' .
   					utf8_htmlspecialchars($xmlcheck[$error->line +1]) . "<br />";
   					
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
   				 
   				$message = $user->lang ['RT_TRIGGERXML_INVALID']. '<br />--------------------------------------------<br />' . $message; 
   				 
				// set error handler off - to free memory
		        libxml_clear_errors();
				// display errors
		        trigger_error( $message . $this->Raidtrackerlink, E_USER_WARNING);
	        }
	        	
        }
        
        return $doc; 
        
	}
	
}

?>
