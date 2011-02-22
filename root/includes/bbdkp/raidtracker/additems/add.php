<?php
/**
 * Add / Update CT_RaidTracker Add Items
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
 * This class handles add items add & update
 */
class Raidtracker_AddItem extends acp_dkp_rt_settings
{
    var $id;
    var $Raidtrackerlink; 
    function Raidtracker_AddItem()
    {
        global $db, $user, $template, $phpbb_admin_path, $phpEx;

        $this->Raidtrackerlink = '<br /><a href="'. append_sid ( "{$phpbb_admin_path}index.$phpEx", "i=dkp_rt_settings&amp;" ) . '"><h3>Return to Index</h3></a>';
        if(isset ($_GET['id']))
        {
        	$this->id = request_var('id', 0);	
        	$sql =   "SELECT add_items_wow_id FROM " . RT_ADD_ITEMS_TABLE . ' where add_items_id  = ' . $this->id ;
	        $result = $db->sql_query($sql);
	        $add_items_wow_id = $db->sql_fetchfield('add_items_wow_id', 1 , $result);
	        $db->sql_freeresult($result);
	        $template->assign_vars(array(
	            'ID'          		=> $this->id,
				'V_ID'        		=> $this->id,
	         ));
        }
        else 
        {
	        // get from userinput
			$add_items_wow_id = request_var('add_items_wow_id', 0);	
        }

        
        $template->assign_vars(array(
			'U_LINK' => append_sid("{$phpbb_admin_path}index.$phpEx", "i=dkp_rt_settings&amp;"),
            'ADD_ITEMS_WOW_ID'  => $add_items_wow_id, 
            'S_ADD'     => isset($this->id) ? false : true,
        ));
        
    }

    /**
     * Add 
     */
    function item_add()
    {
        global $db, $user;
		$add_items_wow_id = request_var('add_items_wow_id',0);
		
		$sql = 'DELETE from ' . RT_ADD_ITEMS_TABLE . ' where add_items_wow_id = ' . $add_items_wow_id; 
		$db->sql_query($sql);
		$sql = 'INSERT INTO ' . RT_ADD_ITEMS_TABLE .  ' (add_items_wow_id) values (' . $add_items_wow_id . ')'; 
		$db->sql_query($sql);
		
        $log_action = array(
            'header'					=> 'L_ACTION_CTRT_ADD_ITEM_ADDED',
            'L_CTRT_LABEL_ADD_ITEM'		=> $add_items_wow_id,
            'L_ADDED_BY'				=> $user->data['username']);

        $this->log_insert(array(
            'log_type'					=> $log_action['header'],
            'log_action'				=> $log_action)
        );

        $success_message = sprintf($user->lang['RT_ITEM_SUCCESS_ADD'], $add_items_wow_id);
        trigger_error($success_message . $this->Raidtrackerlink, E_USER_NOTICE);

        return;
    }
    
    /**
     * Update an own item record
     */
    function item_update()
    {
        global $db, $user;
     	
		$data = array(
		    'add_items_id'     	=> (int) $this->id,
		    'add_items_wow_id'  => request_var('add_items_wow_id',0)
		);
     	
        $sql =   "SELECT count(add_items_id) as checkval from " . RT_ADD_ITEMS_TABLE . ' where add_items_wow_id = ' . $data['add_items_wow_id'];
	  	$result = $db->sql_query($sql);
		if($db->sql_fetchfield('checkval') !=0)
		{
			$failure_message = sprintf($user->lang["RT_ITEM_DUPLICATE"], $data['add_items_wow_id']);
            trigger_error($failure_message);
		}
		$db->sql_freeresult($result);  
        
        $sql = 'UPDATE ' . RT_ADD_ITEMS_TABLE . ' SET add_items_wow_id = ' . $data['add_items_wow_id'] . ' where  add_items_id= ' . $data['add_items_id'];
        $db->sql_query($sql);
        
		$success_message = sprintf($user->lang['RT_ITEM_SUCCESS_UPDATE'], $data['add_items_wow_id']);
		trigger_error($success_message  . $this->Raidtrackerlink, E_USER_NOTICE );
		
    }
    

    /**
     * Process Delete 
     */
    function item_delete()
    {
        global $db, $user;
        
        // check mode
	    if (confirm_box(true))
	    {
		    $add_items_wow_id = request_var( 'add_items_wow_id', array(0=>0)); 
		    foreach ( $add_items_wow_id as $key => $wow_id )
			{
				$sql = 'DELETE from ' . RT_ADD_ITEMS_TABLE . ' where add_items_wow_id = ' . $wow_id;  
				$result = $db->sql_query($sql);
			}
	    	
	    	// Append success message
	      	$success_message .= sprintf($user->lang["RT_ITEM_SUCCESS_DELETE"], implode(', ', $add_items_wow_id)) . '<br />';
	        // Success message
	        trigger_error($success_message  . $this->Raidtrackerlink, E_USER_NOTICE);
	    }
	    else
	    {
	    	
		    if ( isset($_POST['compare_ids']) )
			{
			    $compare_ids = request_var('compare_ids', array(0 => 0));
				foreach ( $compare_ids as $id )
				{
	       					$sql = 'SELECT add_items_wow_id 
							FROM ' . RT_ADD_ITEMS_TABLE . ' 
							WHERE add_items_id = ' . (int) $id ; 
	       						
					$result = $db->sql_query($sql);	
					while ( $row = $db->sql_fetchrow($result) )
					{	
						$add_items_wow_id[] = $row['add_items_wow_id'];
					}
				}
				$wowids = implode(', ', $add_items_wow_id);					
			}
		    	
	    	$s_hidden_fields = build_hidden_fields(array(
				'delete'	=> true,
				'add_items_wow_id'	=> $add_items_wow_id,
				)
			);	
				
	        //display mode
	        confirm_box(false, $user->lang['RT_ITEM_CONFIRM_DELETE'] . ' <br />  ' . $wowids  , $s_hidden_fields);	
	    }
	}

}
?>
