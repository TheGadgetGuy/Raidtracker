<?php
/**
 * List RaidTracker Member Aliases
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
 * Display a list of member aliases. Provides mass delete and single alias add.
* Class Raidtracker_ListAliases, extends acp_dkp_rt_settings, which extends bbDkp_Admin
 */
class Raidtracker_ListAliases extends acp_dkp_rt_settings
{
    var $PlayerAlias;

    function Raidtracker_ListAliases()
    {
        global $db, $phpbb_admin_path, $user, $template, $phpEx;

        $sql =   "SELECT a.alias_id, a.alias_name, b.member_name FROM " . RT_ALIASES_TABLE . ' a , '
         . MEMBER_LIST_TABLE . ' b  where b.member_id = a.alias_member_id  ORDER BY a.alias_id ';
        
        $result = $db->sql_query($sql);
        while ( $row = $db->sql_fetchrow($result) )
        {
            $template->assign_block_vars('aliases_row', array(
                'ID'    => $row['alias_id'],
        	    'NAME'  => $row['member_name'],
                'ALIAS' => $row['alias_name'],
                'U_ADD_ALIAS'  => append_sid ( "{$phpbb_admin_path}index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_add_alias&amp;id=" . $row['alias_id']),
            ));
        }

        $template->assign_vars(array(
            'F_CONFIG' => append_sid( "{$phpbb_admin_path}index.$phpEx", "i=dkp_rt_settings&amp;mode=rt_add_alias"), 
			'U_LINK'   => append_sid("{$phpbb_admin_path}index.$phpEx", "i=dkp_rt_settings&amp;"),


        ));
        
    }

}
?>
