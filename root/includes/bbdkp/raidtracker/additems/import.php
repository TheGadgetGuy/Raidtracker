<?php
/**
 * Import CT_RaidTracker Add Items
 *
*  @author Sajaki@bbdkp.com
*  @package bbDkp.acp
 * @copyright 2010 bbdkp <http://code.google.com/p/bbdkp/>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * $Id$
 */


/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}


/**
 * This class imports items
 * 
 */
class Raidtracker_ImportAddItem extends acp_dkp_rt_settings 
{
	var $Raidtrackerlink; 

    function Raidtracker_ImportAddItem()
    {
    	global $phpEx; 
        $this->Raidtrackerlink = '<br /><a href="'. append_sid ( "index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_list_items" ) . '"><h3>Return to Index</h3></a>';
    }

    /**
     * Import the add items
     */
    function process_import () 
    {
        global $db, $user; 

        $message = "";
        
        $xml = utf8_normalize_nfc(request_var('xml', ' ', true)); 
        $xml = str_replace ("&", "and", html_entity_decode($xml)); 

        $addItems = $this->xmlparse($xml); 
        $addItems = (array) $addItems[0]; 
        
        foreach ($addItems as $additem) 
        {
        	$additem = (array) $additem; 
			
			foreach ($additem as $item) 
			{
				$item = intval(trim($item)); 
				$sql = 'DELETE from ' . RT_ADD_ITEMS_TABLE . ' where add_items_wow_id = ' . $item; 
				$db->sql_query($sql);
				$sql = 'INSERT INTO ' . RT_ADD_ITEMS_TABLE .  ' (add_items_wow_id) values (' . $item . ')'; 
				$db->sql_query($sql);
				$message .= sprintf($user->lang["RT_ITEM_SUCCESS_ADD"]."<br />", $item);
								
			}
		}

        //
        // Success message
        //
        trigger_error($message . $this->Raidtrackerlink , E_USER_NOTICE);
    }

}
?>
