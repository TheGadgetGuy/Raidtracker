<?php
/**
* This class manages importing DKP strings from WoW with Ct_raidtracker EQDKP
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

class acp_dkp_rt_import_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_dkp_rt_import',
			'title'		=> 'ACP_DKP_RT_IMPORT',
			'version'	=> '1.0.1',
			'modes'		=> array(
				'rt_parse'		=> array('title' => 'RT_PARSE',  'display' => 1, 'auth' => 'acl_a_dkp', 'cat' => array('ACP_DKP')),
				'rt_import'		=> array('title' => 'RT_IMPORT', 'display' => 0, 'auth' => 'acl_a_dkp', 'cat' => array('ACP_DKP')),				
				'rt_delete'		=> array('title' => 'RT_DELETE', 'display' => 0, 'auth' => 'acl_a_dkp', 'cat' => array('ACP_DKP')),
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
