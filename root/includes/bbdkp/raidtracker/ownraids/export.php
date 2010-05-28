<?php
/**
 * Export CT_RaidTracker Own Raids
 *
 * @author Sajaki@bbdkp.com
 * @package bbDkp.acp
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
 * This class exports event triggers
 * ManageCTRT
 */
class Raidtracker_ExportOwnRaids extends acp_dkp_rt_settings 
{

    function Raidtracker_ExportOwnRaids()
    {

        global $db, $user, $template, $phpEx;
        $Ownraids = array(); 
		$parser = new CTRT_XML();
		$sql = "SELECT * FROM " . RT_OWN_RAIDS_TABLE; 

		$result = $db->sql_query($sql);
        while ($row = $db->sql_fetchrow($result)) 
        {
			$Ownraids[] = array(
	            'own_raid_name'   => $row['own_raid_name']); 
        }
        
		$exportXML = $parser->xml_export(
			array( "OwnRaids" => array("OwnRaid"=> $Ownraids)
		));

        $template->assign_vars(array(
            'EXPORT'          	=> htmlentities($exportXML),
			'U_LINK' => append_sid("index.$phpEx", "i=dkp_rt_settings&amp;"),
        ));
    }

}
?>
