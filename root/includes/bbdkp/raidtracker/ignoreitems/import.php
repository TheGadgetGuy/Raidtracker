<?php
/**
 * Import CT_RaidTracker Ignore Items
 * 
 * @author Sajaki@bbdkp.com
 * @package bbDkp.acp
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
 * This class imports ignore items
 * ManageCTRT
 */
class Raidtracker_ImportIgnoreItems extends acp_dkp_rt_settings 
{

    var $Raidtrackerlink; 
    
    function Raidtracker_ImportIgnoreItems()
    {
    	global $phpbb_admin_path, $phpEx; 
        $this->Raidtrackerlink = '<br /><a href="'. append_sid ( "{$phpbb_admin_path}index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_list_ignore_items" ) . '"><h3>Return to Index</h3></a>';
    }

    /**
     * Import the aliases
     */
    function item_import() 
    {
        global $db, $user; 
        
        $message = "";

        $xml = utf8_normalize_nfc(request_var('xml', ' ', true)); 
        $xml = str_replace ("&", "and", html_entity_decode($xml));  

        $ignoreItems = $this->xmlparse($xml); 
        $count = 0; 
        
        foreach ($ignoreItems->IgnoreItem as $item) 
        {
			$item = intval(trim($item)); 
			$sql = 'DELETE from ' . RT_IGNORE_ITEMS_TABLE . ' where ignore_items_wow_id = ' . $item; 
			$db->sql_query($sql);
			$sql = 'INSERT INTO ' . RT_IGNORE_ITEMS_TABLE .  ' (ignore_items_wow_id) values (' . $item . ')'; 
			$db->sql_query($sql);
			$message .= sprintf($user->lang["RT_ITEM_SUCCESS_ADD"]."<br />", $item);
		}

        trigger_error($message . $this->Raidtrackerlink , E_USER_NOTICE);
    }

}
?>
