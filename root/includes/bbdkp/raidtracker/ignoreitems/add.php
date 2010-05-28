<?php
/**
 * Add / Update RaidTracker IgnoreItems
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
 * This class handles ignoreitems add & update
 */
class Raidtracker_AddIgnoreItem extends acp_dkp_rt_settings
{
    var $id;
    var $Raidtrackerlink; 
    function Raidtracker_AddIgnoreItem()
    {
        global $db, $user, $template, $phpEx;

        $this->Raidtrackerlink = '<br /><a href="'. append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;" ) . '"><h3>Return to Index</h3></a>';
        if(isset ($_GET['id']))
        {
        	$this->id = request_var('id', 0);	
        	$sql =   "SELECT ignore_items_wow_id FROM " . RT_IGNORE_ITEMS_TABLE . ' where ignore_items_id  = ' . $this->id ;
	        $result = $db->sql_query($sql);
	        $ignore_items_wow_id = $db->sql_fetchfield('ignore_items_wow_id', 1 , $result);
	        $db->sql_freeresult($result);
	        $template->assign_vars(array(
	            'ID'          		=> $this->id,
				'V_ID'        		=> $this->id,
	         ));
        }
        else 
        {
	        // get from userinput
			$ignore_items_wow_id = request_var('ignore_items_wow_id', 0);	
        }

        
        $template->assign_vars(array(
			'U_LINK' => append_sid("index.$phpEx", "i=dkp_rt_settings&amp;"),
            'IGNORE_ITEMS_WOW_ID'  => $ignore_items_wow_id, 
            'S_ADD'     => isset($this->id) ? false : true,
        ));
        
    }

    /**
     * Add 
     */
    function item_add()
    {
        global $db, $user;
		$ignore_items_wow_id = request_var('ignore_items_wow_id',0);
		
		if($ignore_items_wow_id != 0)
		{
			$sql = 'DELETE from ' . RT_IGNORE_ITEMS_TABLE . ' where ignore_items_wow_id = ' . $ignore_items_wow_id; 
			$db->sql_query($sql);
			$sql = 'INSERT INTO ' . RT_IGNORE_ITEMS_TABLE .  ' (ignore_items_wow_id) values (' . $ignore_items_wow_id . ')'; 
			$db->sql_query($sql);
			
	        $log_action = array(
	            'header'					=> 'L_ACTION_CTRT_IGNORE_ITEM_ADDED',
	            'L_CTRT_LABEL_IGNORE_ITEM'	=> $ignore_items_wow_id,
	            'L_ADDED_BY'				=> $user->data['username']);
	
	        $this->log_insert(array(
	            'log_type'					=> $log_action['header'],
	            'log_action'				=> $log_action)
	        );
	
		}
		else 
		{
	        $success_message = sprintf($user->lang['RT_ITEM_FAIL_ADD'], $ignore_items_wow_id);
	        trigger_error($success_message . $this->Raidtrackerlink, E_USER_WARNING);
			
		}

        return;
    }
    
    /**
     * Update an own item record
     */
    function item_update()
    {
        global $db, $user;
     	
		$data = array(
		    'ignore_items_id'     	=> (int) $this->id,
		    'ignore_items_wow_id'  => request_var('ignore_items_wow_id',0)
		);
     	
        $sql =   "SELECT count(ignore_items_id) as checkval from " . RT_IGNORE_ITEMS_TABLE . ' where ignore_items_wow_id = ' . $data['ignore_items_wow_id'];
	  	$result = $db->sql_query($sql);
		if($db->sql_fetchfield('checkval') !=0)
		{
			$failure_message = sprintf($user->lang["RT_ITEM_DUPLICATE"], $data['ignore_items_wow_id']);
            trigger_error($failure_message);
		}
		$db->sql_freeresult($result);  
        
        $sql = 'UPDATE ' . RT_IGNORE_ITEMS_TABLE . ' SET ignore_items_wow_id = ' . $data['ignore_items_wow_id'] . ' where  ignore_items_id= ' . $data['ignore_items_id'];
        $db->sql_query($sql);
        
		$success_message = sprintf($user->lang['RT_ITEM_SUCCESS_UPDATE'], $data['ignore_items_wow_id']);
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
		    $ignore_items_wow_id = request_var( 'ignore_items_wow_id', array(0=>0)); 
		    foreach ( $ignore_items_wow_id as $key => $wow_id )
			{
				$sql = 'DELETE from ' . RT_IGNORE_ITEMS_TABLE . ' where ignore_items_wow_id = ' . $wow_id;  
				$result = $db->sql_query($sql);
			}
	    	
	    	// Append success message
	      	$success_message .= sprintf($user->lang["RT_ITEM_SUCCESS_DELETE"], implode(', ', $ignore_items_wow_id)) . '<br />';
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
	       					$sql = 'SELECT ignore_items_wow_id 
							FROM ' . RT_IGNORE_ITEMS_TABLE . ' 
							WHERE ignore_items_id = ' . (int) $id ; 
	       						
					$result = $db->sql_query($sql);	
					while ( $row = $db->sql_fetchrow($result) )
					{	
						$ignore_items_wow_id[] = $row['ignore_items_wow_id'];
					}
				}
				$wowids = implode(', ', $ignore_items_wow_id);					
			}
		    	
	    	$s_hidden_fields = build_hidden_fields(array(
				'delete'	=> true,
				'ignore_items_wow_id'	=> $ignore_items_wow_id,
				)
			);	
				
	        //display mode
	        confirm_box(false, $user->lang['RT_ITEM_CONFIRM_DELETE'] . ' <br />  ' . $wowids  , $s_hidden_fields);	
	    }
	}

}
?>
