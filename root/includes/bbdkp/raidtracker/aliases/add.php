<?php
/**
 * Add / Update CT_RaidTracker Add Alias
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
 * This class handles the addition, update, and deletion of a single alias/Twink
 * Class Raidtracker_AddAlias, extends acp_dkp_rt_settings, which extends bbDkp_Admin
 * 
 */
class Raidtracker_AddAlias extends acp_dkp_rt_settings
{
    var $id;
    var $alias; 
    var $Raidtrackerlink; 
    
    function Raidtracker_AddAlias()
    {
        global $db, $user, $template, $phpEx;
		$this->Raidtrackerlink = '<br /><a href="'. append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;" ) . '"><h3>Return to Index</h3></a>';
        if(isset ($_GET['id']))
        {
        	// get from $get if clicked in list
        	$this->id = request_var('id', 0);	
        	$sql = "SELECT * FROM " . RT_ALIASES_TABLE . ' where alias_id  = ' . $this->id;
	        $result = $db->sql_query($sql);
	        while ($row = $db->sql_fetchrow($result))
			{
				$this->alias = array(
		            'alias_id'          => $this->id, 
		            'alias_member_id'   => $row['alias_member_id'],
		            'alias_name'        => $row['alias_name']); 
			}
	        $db->sql_freeresult($result);
	        $template->assign_vars(array(
	            'ID'          		=> $this->id,
				'V_ID'        		=> $this->id,
	         ));
        
        }
        else 
        {
	        // get from userinput $post
			$alias_name = utf8_normalize_nfc(request_var('alias_name', ' ', true));
			$sql = "SELECT * FROM " . RT_ALIASES_TABLE . " where alias_name  = '" . $db->sql_escape($alias_name) . "'" ; 
	        $result = $db->sql_query($sql);
	        while ($row = $db->sql_fetchrow($result))
			{
				$this->alias = array(
		            'alias_id'          => $row['alias_id'],
		            'alias_member_id'   => $row['alias_member_id'],
		            'alias_name'        => $row['alias_name']); 
			}
	        $db->sql_freeresult($result);
	        $template->assign_vars(array(
	            'ID'          		=> $this->alias['alias_id'],
				'V_ID'        		=> $this->alias['alias_id'],
	         ));
        }

        /**
         * Generate the list of members
         */
        $sql =   'SELECT member_id, member_name FROM ' . MEMBER_LIST_TABLE . ' ORDER BY member_name';
        $result = $db->sql_query($sql);

        while ( $row = $db->sql_fetchrow($result) )
        {
            $template->assign_block_vars('members_row', array(
                'VALUE'    => $row['member_id'],
                'SELECTED' => ( $this->alias['alias_member_id'] == $row['member_id'] ) ? ' selected="selected"' : '',
                'OPTION'   => $row['member_name'])
            );
        }
        $db->sql_freeresult($result);
        
        $template->assign_vars(array(
            // Form vars
			'U_LINK' => append_sid("index.$phpEx", "i=dkp_rt_settings&amp;"),
            // Form values
    		'ALIAS_NAME' 		  => $this->alias['alias_name'], 
        
            // Buttons
            'S_ADD'     => isset($this->id) ? false : true,
        ));
        
    }


    /**
     * Process Twink Delete (confirmed)
     */
    function alias_delete()
    {
	     global $db, $user;
	        
	        // check mode
		    if (confirm_box(true))
		    {
			    $alias_ids = request_var( 'alias_id', array(0=>0)); 
			    $alias_names = request_var( 'alias_name', ' ');
			    $membernamelist = request_var( 'member_name', ' ');
			    foreach ( $alias_ids as $key => $alias_id )
				{
					$sql = 'DELETE from ' . RT_ALIASES_TABLE . ' where alias_id = ' . $alias_id;  
					$result = $db->sql_query($sql);
				}
		    	
		    	// Append success message
		      	$success_message .= sprintf($user->lang["RT_ALIAS_DELETED"], $alias_names, $membernamelist) . '<br />';
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
       					$sql = "SELECT a.alias_name , b.member_name FROM " . RT_ALIASES_TABLE . ' a , '
	   						. MEMBER_LIST_TABLE . ' b  where b.member_id = a.alias_member_id  and a.alias_id = ' . (int) $id ; 
		       						
						$result = $db->sql_query($sql);	
						while ( $row = $db->sql_fetchrow($result) )
						{	
							$aliasnamearray[] = $row['alias_name'];
							$membernamearray[] = $row['member_name'];
						}
					}
					$aliasnamelist = implode(', ', $aliasnamearray);
					$membernamelist = implode(', ', $membernamearray);					
				}
			    	
		    	$s_hidden_fields = build_hidden_fields(array(
					'delete'	  => true,
		    		'alias_id'	  => $compare_ids, 
					'alias_name'  => $aliasnamelist,
		    		'member_name' => $membernamelist, 
					)
				);	
					
		        //display mode
		        confirm_box(false, $user->lang['RT_CONFIRM_DELETE_ALIAS'] . ' <br />  ' . $aliasnamelist  , $s_hidden_fields);	
		    }       
	        
    }
    
    
	/*
	 * Process Update 
	 * 
	 * updates the alias/twink name 
	 */

    function alias_update()
    {
    	
    	global $db, $user, $phpEx;

    	$newalias_name = utf8_normalize_nfc(request_var('alias_name', ' ', true));
		$alias_member_id = request_var('alias_member_id', 0); 
		
    	// check if twink name already assigned to other member		
        $sql =   "SELECT count(alias_name) as checkval from " . RT_ALIASES_TABLE . " where alias_name = '" . $db->sql_escape($newalias_name) . "'"; 
	  	$result = $db->sql_query($sql);
		if($db->sql_fetchfield('checkval') != 0) 
		{
			$sql =   "SELECT alias_member_id from " . RT_ALIASES_TABLE . " where alias_name = '" . $db->sql_escape($newalias_name) . "'"; 
	  		$result = $db->sql_query($sql);
	  		$existingid = $db->sql_fetchfield('alias_member_id'); 
	  		$failure_message = sprintf($user->lang["RT_ALIAS_DUPLICATE"], $alias_name, $existingid);
            trigger_error($failure_message . $this->Raidtrackerlink, E_USER_WARNING);
		}
		$db->sql_freeresult($result);  
        
		// perform update
        $sql = 'UPDATE ' . RT_ALIASES_TABLE . " SET alias_name = '" . $db->sql_escape($newalias_name) . "' where alias_member_id = " . $alias_member_id;
        $db->sql_query($sql);
        
		$success_message = sprintf($user->lang['RT_ALIAS_UPDATE_SUCCESS'], $newalias_name, $alias_member_id);
		trigger_error($success_message . $this->Raidtrackerlink, E_USER_NOTICE );

    }

    /**
     * Process Add
     *
     * adds the alias/twink name to the database
     */
    function alias_add()
    {
        global $db, $user;
        
        $data = array(
    		'alias_member_id'   => utf8_normalize_nfc(request_var('alias_member_id', ' ', true)), 
    		'alias_name'     	=> utf8_normalize_nfc(request_var('alias_name', ' ', true)), 
			);

    	// check if twink name already assigned to other member		
        $sql =   "SELECT count(alias_name) as checkval from " . RT_ALIASES_TABLE . " where alias_name = '" . $db->sql_escape($data['alias_name']) . "'"; 
	  	$result = $db->sql_query($sql);
		if($db->sql_fetchfield('checkval') != 0) 
		{
			$sql =   "SELECT alias_member_id from " . RT_ALIASES_TABLE . " where alias_name = '" . $db->sql_escape($data['alias_name']) . "'"; 
	  		$result = $db->sql_query($sql);
	  		$existingid = $db->sql_fetchfield('alias_member_id'); 
	  		$failure_message = sprintf($user->lang["RT_ALIAS_DUPLICATE"], $alias_name, $existingid);
            trigger_error($failure_message . $this->Raidtrackerlink, E_USER_WARNING);
		}
		$db->sql_freeresult($result); 			
      	
		$sql = 'INSERT into ' . RT_ALIASES_TABLE . ' ' . $db->sql_build_array('INSERT', $data);
		$db->sql_query($sql);
		
        $log_action = array(
            'header'					=> 'L_ACTION_CTRT_ALIAS_ADDED',
			'L_CTRT_LABEL_ALIAS_NAME'     => $data['alias_name'], 
			'L_CTRT_LABEL_MEMBER_NAME'    => $data['alias_member_id'],
			'L_ADDED_BY'                  => $user->data['username']);

        $this->log_insert(array(
            'log_type'					=> $log_action['header'],
            'log_action'				=> $log_action)
        );

         $success_message = sprintf($user->lang['RT_ADD_ALIAS_SUCCESS'], $data['alias_name'], $data['alias_member_id']); 
         trigger_error($success_message . $this->Raidtrackerlink , E_USER_NOTICE);

        return;
    }

}
?>