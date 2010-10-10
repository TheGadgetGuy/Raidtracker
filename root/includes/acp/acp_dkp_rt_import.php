<?php
/**
* This class manages importing DKP strings from WoW with Ct_raidtracker
*  
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

class acp_dkp_rt_import extends bbDkp_Admin 
{
	var $u_action;
	
	function main($id, $mode) 
	{
		
		global $db, $user, $auth, $template, $sid, $cache;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;
		
		$user->add_lang ( array ('mods/dkp_raidtracker' ));

		$template->assign_vars(array(
			'U_PARSE' 			=> append_sid ( "index.$phpEx", "i=dkp_rt_import&amp;mode=rt_parse" ),
			'U_IMPORT' 			=> append_sid ( "index.$phpEx", "i=dkp_rt_import&amp;mode=rt_import" ), 
        ));

        switch ($mode) 
		{
			case 'rt_parse' :
					// parsing xml in temp tables
					$link = '<br /><a href="' . $this->u_action . '"><h3>Return to Raidtracker</h3></a>';
					include ($phpbb_root_path . "includes/bbdkp/raidtracker/import/parse.$phpEx");
					
					$extension = new Raidtracker_parse ($this->u_action);
									
					$submit = (isset ( $_POST ['parse'] )) ? true : false;
					if ($submit) 
					{
						$extension->raid_parse ();
					}

    				$this->tpl_name = 'dkp/acp_' . $mode;
					$this->page_title = $user->lang ['RT_PARSE'];
						
				
				break;
				
			case 'rt_import' :
					$link = '<br /><a href="' . $this->u_action . '"><h3>Return to Raidtracker</h3></a>';
					
					$listed = (isset ($_GET ['r']) && request_var('r', 0) != 0 ) ? true : false; 
					$submit = (isset ($_POST ['doimport'])) ? true : false;
					
					
					if($listed)
					{
						// display the raid for review
						include ($phpbb_root_path . "includes/bbdkp/raidtracker/import/review.$phpEx");
						$extension = new Raidtracker_Review ( );
						
					}
					
					if($submit)
					{
						// add the raid to bbdkp
						include ($phpbb_root_path . "includes/bbdkp/raidtracker/import/addraid.$phpEx");
						$extension = new Raidtracker_addraid($this->u_action);
					}
					
					$this->tpl_name = 'dkp/acp_' . $mode;
					$this->page_title = $user->lang ['RT_IMPORT'];
				
				break;
				
			case 'rt_delete' :
					// deletes a parsed raid
					$link = '<br /><a href="' . append_sid ( "{$phpbb_admin_path}index.$phpEx", "i=dkp_rt_import&amp;mode=rt_parse" ) . '"><h3>Return to Raidtracker</h3></a>';
					$raidid = request_var('r', 0); 
					if (confirm_box(true))
					{
						    // get raidinfo 
							$sql = 'SELECT batchid 
								FROM ' . RT_TEMP_RAIDINFO . ' where raidid = ' . (int) $raidid ; 
					        $result = $db->sql_query($sql);
					        while ( $row = $db->sql_fetchrow($result) )
					        {
					        	$batchid = $row['batchid']; 
					        }
					        $db->sql_freeresult ( $result);
        
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
							
							$success_message = sprintf($user->lang['RT_STEP1_DELETEPARSE'], $raidid);
							trigger_error($success_message . $link);
							
					}
					else
					{
						$s_hidden_fields = build_hidden_fields(array(
							'delete'		=> true,
							'raidid'		=> $raidid,
							)
						);
		
						confirm_box(false, sprintf($user->lang['RT_STEP1_DELETCONFIRM'], $raidid), $s_hidden_fields);
					}
					$this->tpl_name = 'dkp/acp_rt_parse';
					$this->page_title = $user->lang ['RT_DELETE'];
					meta_refresh(0, append_sid("{$phpbb_admin_path}index.$phpEx", 'i=dkp_rt_import'));
				
				break;
								
				
				
		}
	} // end main
}

?>
