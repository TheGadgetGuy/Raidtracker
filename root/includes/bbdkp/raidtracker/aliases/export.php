<?php
/**
 * Export RaidTracker Member Alt names
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
 * This class exports one or multiple aliases
 * Raidtracker_ExportAliases
 * 
 */
class Raidtracker_ExportAliases extends acp_dkp_rt_settings 
{
    function Raidtracker_ExportAliases()
    {
        global $db, $user, $template, $phpEx;
		
		$parser = new CTRT_XML();
		
		$sql =   "SELECT a.alias_id, a.alias_name, b.member_name FROM " . RT_ALIASES_TABLE . ' a , '
         . MEMBER_LIST_TABLE . ' b  where b.member_id = a.alias_member_id  ORDER BY a.alias_id ';
        $result = $db->sql_query($sql);
        
        $playeralias = array();
        while ($row = $db->sql_fetchrow($result))
        {
			$playeralias[] = array(
				'alias'  =>	$row["alias_name"],
				'member' =>	$row["member_name"]);
        }
		$exportXML = $parser->xml_export(array("PlayerAlts"=>array("Alt"=>$playeralias)));

		
		$template->assign_vars(array(
            'EXPORT'        => htmlentities($exportXML),
			'U_LINK' 		=> append_sid("index.$phpEx", "i=dkp_rt_settings&amp;"),
        ));

    }
    
}
?>
