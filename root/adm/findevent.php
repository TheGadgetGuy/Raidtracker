<?php
/**
 * returns event xml based on ajax call 
 * @package bbDkp.acp
 * @copyright (c) 2009 bbDkp <http://code.google.com/p/bbdkp/>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version $Id$
 */
define('IN_PHPBB', true);
define('ADMIN_START', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);

$dkpid = request_var('dkpid', 0);
if($dkpid !=0)
{
	$sql = 'SELECT event_id, event_name , event_value  
			FROM ' . EVENTS_TABLE . ' WHERE
			event_dkpid =  '. $dkpid . ' ORDER BY event_id';
	$result = $db->sql_query($sql);
	header('Content-type: text/xml');
	// preparing xml
	$xml = '<?xml version="1.0" encoding="UTF-8"?>
	<eventlist>';
	while ( $row = $db->sql_fetchrow($result)) 
	{
		 $xml .= '<event>'; 
		 $xml .= "<event_id>" . $row['event_id'] . "</event_id>";
		 $xml .= "<event_name>" . $row['event_name'] . "</event_name>";
		 $xml .= "<event_value>" . $row['event_value'] . "</event_value>"; 
		 $xml .= '</event>'; 	 
	}
	$xml .= '</eventlist>';
	$db->sql_freeresult($result);
	//return xml to ajax
	echo($xml); 
}

$eventid = request_var('eventid', 0);
if($eventid !=0)
{
	$sql = 'SELECT event_id, event_value FROM ' . EVENTS_TABLE . ' WHERE event_id =  '. $eventid;
	$result = $db->sql_query($sql);
	while ( $row = $db->sql_fetchrow($result)) 
	{
		 $xml = $row['event_value'];
	}
	$db->sql_freeresult($result);
	//return xml to ajax
	echo($xml); 
}

?>
