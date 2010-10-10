<?php
/**
* This class manages all the Ct_raidtracker settings
*  
* Powered by bbdkp © 2009 The bbDkp Project Team
* If you use this software and find it to be useful, we ask that you
* retain the copyright notice below.  While not required for free use,
* it will help build interest in the bbDkp project.
* 
* Integrated by: ippeh
* 
* @package bbDkp.acp
* @copyright (c) 2009 bbdkp http://code.google.com/p/bbdkp/
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* $Id$
* 
*  
**/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}


/**
* @package module_install
*/
class acp_dkp_rt_settings_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_dkp_rt_settings',
			'title'		=> 'RTSETTINGS',
			'version'	=> '0.2.6',
			'modes'		=> array(
				'rt_manage_settings'			=> array('title' => 'RTSETTINGS',  'display' => 1,  'auth' => 'acl_a_dkp', 'cat' => array('ACP_DKP')),
				'rt_add_items'					=> array('title' => 'RT_ADDITEMS',  'display' => 0, 'auth' => 'acl_a_dkp', 'cat' => array('ACP_DKP')),
				'rt_list_items'					=> array('title' => 'RT_LISITEMS',  'display' => 0, 'auth' => 'acl_a_dkp', 'cat' => array('ACP_DKP')),
				'rt_export_items'				=> array('title' => 'RT_EXPITEMS',  'display' => 0, 'auth' => 'acl_a_dkp', 'cat' => array('ACP_DKP')),
				'rt_import_items'				=> array('title' => 'RT_IMPITEMS',  'display' => 0, 'auth' => 'acl_a_dkp', 'cat' => array('ACP_DKP')),
				'rt_add_alias'					=> array('title' => 'RT_ADDALIAS',  'display' => 0, 'auth' => 'acl_a_dkp', 'cat' => array('ACP_DKP')),
				'rt_list_alias'					=> array('title' => 'RT_LISALIAS',  'display' => 0, 'auth' => 'acl_a_dkp', 'cat' => array('ACP_DKP')),
				'rt_export_alias'				=> array('title' => 'RT_EXPALIAS',  'display' => 0, 'auth' => 'acl_a_dkp', 'cat' => array('ACP_DKP')),
				'rt_import_alias'				=> array('title' => 'RT_IMPALIAS',  'display' => 0, 'auth' => 'acl_a_dkp', 'cat' => array('ACP_DKP')),
				'rt_add_event_triggers'			=> array('title' => 'RT_ADDEVTRIG',  'display' => 0, 'auth' => 'acl_a_dkp', 'cat' => array('ACP_DKP')),
				'rt_list_event_triggers'		=> array('title' => 'RT_LISEVTRIG',  'display' => 0, 'auth' => 'acl_a_dkp', 'cat' => array('ACP_DKP')),
				'rt_export_event_triggers'		=> array('title' => 'RT_EXPEVTRIG',  'display' => 0, 'auth' => 'acl_a_dkp', 'cat' => array('ACP_DKP')),
				'rt_import_event_triggers'		=> array('title' => 'RT_IMPEVTRIG',  'display' => 0, 'auth' => 'acl_a_dkp', 'cat' => array('ACP_DKP')),
				'rt_add_ignore_items'			=> array('title' => 'RT_ADDIGNORE',  'display' => 0, 'auth' => 'acl_a_dkp', 'cat' => array('ACP_DKP')),
				'rt_list_ignore_items'			=> array('title' => 'RT_LISIGNORE',  'display' => 0, 'auth' => 'acl_a_dkp', 'cat' => array('ACP_DKP')),
				'rt_export_ignore_items'		=> array('title' => 'RT_EXPIGNORE',  'display' => 0, 'auth' => 'acl_a_dkp', 'cat' => array('ACP_DKP')),
				'rt_import_ignore_items'		=> array('title' => 'RT_IMPIGNORE',  'display' => 0, 'auth' => 'acl_a_dkp', 'cat' => array('ACP_DKP')),
				'rt_add_own_raids'				=> array('title' => 'RT_ADDOWNRAID',  'display' => 0, 'auth' => 'acl_a_dkp', 'cat' => array('ACP_DKP')),
				'rt_list_own_raids'				=> array('title' => 'RT_LISOWNRAID',  'display' => 0, 'auth' => 'acl_a_dkp', 'cat' => array('ACP_DKP')),
				'rt_export_own_raids'			=> array('title' => 'RT_EXPOWNRAID',  'display' => 0, 'auth' => 'acl_a_dkp', 'cat' => array('ACP_DKP')),
				'rt_import_own_raids'			=> array('title' => 'RT_IMPOWNRAID',  'display' => 0, 'auth' => 'acl_a_dkp', 'cat' => array('ACP_DKP')),
				'rt_add_raid_note_triggers'		=> array('title' => 'RT_ADDRAIDTRIG',  'display' => 0, 'auth' => 'acl_a_dkp', 'cat' => array('ACP_DKP')),
				'rt_list_raid_note_triggers'	=> array('title' => 'RT_LISRAIDTRIG',  'display' => 0, 'auth' => 'acl_a_dkp', 'cat' => array('ACP_DKP')),
				'rt_export_raid_note_triggers'	=> array('title' => 'RT_EXPRAIDTRIG',  'display' => 0, 'auth' => 'acl_a_dkp', 'cat' => array('ACP_DKP')),
				'rt_import_raid_note_triggers'	=> array('title' => 'RT_IMPRAIDTRIG',  'display' => 0, 'auth' => 'acl_a_dkp', 'cat' => array('ACP_DKP')),
				),
		);
	}

	function install()
	{
	}

	function uninstall()
	{
	}
}

?>
