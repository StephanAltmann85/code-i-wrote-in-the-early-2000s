<?php
// ************************************************************************************//
// * WoltLab Burning Board 2
// ************************************************************************************//
// * Copyright (c) 2001-2004 WoltLab GmbH
// * Web           http://www.woltlab.de/
// * License       http://www.woltlab.de/products/burning_board/license_en.php
// *               http://www.woltlab.de/products/burning_board/license.php
// ************************************************************************************//
// * WoltLab Burning Board 2 is NOT free software.
// * You may not redistribute this package or any of it's files.
// ************************************************************************************//
// * $Date: 2004-10-20 13:24:57 +0200 (Wed, 20 Oct 2004) $
// * $Author: Burntime $
// * $Rev: 1453 $
// ************************************************************************************//


class WIW extends useronline {
	var $useronlinecache = array();
	
	var $boardids = "";
	var $threadids = "";
	var $userids = "";
	var $eventids = "";
	var $postids = "";
	
	var $boardcache = array();
	var $threadcache = array();
	var $usercache = array();
	var $eventcache = array();
	var $postcache = array();
	
	var $counter = -1;
	
	
	function insert($data) {
		list($script, $querystring, ) = explode("?", $data['request_uri']);
		if ($script == "attachment.php") $script = "thread.php";
		if ($script == "attachmentedit.php") $script = "board.php";
		$data['script'] = $script;
		
		if ($script == "board.php" || $script == "board.html" || $script == "newthread.php") $this->boardids .= ",".$data['boardid'];
		elseif ($script == "thread.php" || $script == "thread.html" || $script == "addreply.php") $this->threadids .= ",".$data['threadid'];				
		elseif ($script == "profile.php") {
			$a_querystring = explode("&", $querystring);
			for ($i = 0; $i < count($a_querystring); $i++) {
				list($varname, $value, ) = explode("=", $a_querystring[$i]);
				if ($varname == "userid") {
					$value = intval($value);
					if ($value != 0) {
						$this->userids .= ",".$value;
						$data['profile_userid'] = $value;
					}
				} 	
			}	
		}
		elseif ($script == "calendar.php") {
			$calendar_action = '';
			$eventid = 0;
			$a_querystring = explode("&", $querystring);
			for ($i = 0; $i < count($a_querystring); $i++) {
				list($varname, $value, ) = explode("=", $a_querystring[$i]);
				if ($varname == "id") $eventid = intval($value);
				if ($varname == "action") $calendar_action = $value;
			}
			
			if ($calendar_action == "viewevent" && $eventid != 0) {
				$this->eventids .= ",".$eventid;
				$data['eventid'] = $eventid;
			}
		}
		elseif ($script == "editpost.php") {
			$a_querystring = explode("&", $querystring);
			for ($i = 0; $i < count($a_querystring); $i++) {
				list($varname, $value, ) = explode("=", $a_querystring[$i]);
				if ($varname == "postid") {
					$value = intval($value);
					if ($value != 0) {
						$this->postids .= ",".$value;
						$data['postid'] = $value;
					}
				} 	
			}	
		}
		
		$this->useronlinecache[] = $data;
	}
	
	function cache() {
		global $permissioncache, $wbbuserdata, $n, $db, $lang;
		
		if ($this->boardids != '' || $this->threadids != '') {
			if (!isset($permissioncache)) $permissioncache = getPermissions();
			
			$global_boardids1 = '';
			$global_boardids2 = '';
			
			$result = $db->unbuffered_query("SELECT boardid FROM bb".$n."_boards WHERE password='' AND invisible<>2");
			while ($row = $db->fetch_array($result)) {
				if (!isset($permissioncache[$row['boardid']]['can_enter_board']) || $permissioncache[$row['boardid']]['can_enter_board'] == -1) $permissioncache[$row['boardid']]['can_enter_board'] = $wbbuserdata['can_enter_board'];
				if (!isset($permissioncache[$row['boardid']]['can_view_board']) || $permissioncache[$row['boardid']]['can_view_board'] == -1) $permissioncache[$row['boardid']]['can_view_board'] = $wbbuserdata['can_view_board'];
				
				if ($permissioncache[$row['boardid']]['can_view_board'] == 1) $global_boardids1 .= ",".$row['boardid'];
				if ($permissioncache[$row['boardid']]['can_enter_board'] == 1) $global_boardids2 .= ",".$row['boardid'];
			}
			
			if ($this->boardids != '' && $global_boardids1 != '') {
				$result = $db->unbuffered_query("SELECT boardid, title FROM bb".$n."_boards WHERE boardid IN (0".$this->boardids.") AND boardid IN (0".$global_boardids1.")");	
				while ($row = $db->fetch_array($result)) $this->boardcache[$row['boardid']] = getlangvar($row['title'], $lang);
			} 
			
			if ($this->threadids != '' && $global_boardids2 != '') {
				$result = $db->unbuffered_query("SELECT threadid, topic FROM bb".$n."_threads WHERE threadid IN (0".$this->threadids.") AND boardid IN (0".$global_boardids2.")");	
				while ($row = $db->fetch_array($result)) $this->threadcache[$row['threadid']] = htmlconverter(textwrap($row['topic']));	
			} 
			
			if ($this->postids != '' && $global_boardids2 != '') {
				$result = $db->unbuffered_query("SELECT p.postid, p.posttopic, p.message FROM bb".$n."_posts p, bb".$n."_threads t WHERE p.threadid=t.threadid AND p.postid IN (0".$this->postids.") AND t.boardid IN (0".$global_boardids2.")");	
				while ($row = $db->fetch_array($result)) $this->postcache[$row['postid']] = htmlconverter(textwrap( (($row['posttopic'] != '') ? ($row['posttopic']) : (wbb_substr($row['message'], 0, 100))) ));	
			} 
		} 	
		
		if ($this->userids != '') {
			$result = $db->unbuffered_query("SELECT userid, username FROM bb".$n."_users WHERE userid IN (0".$this->userids.")");	
			while ($row = $db->fetch_array($result)) $this->usercache[$row['userid']] = htmlconverter($row['username']);
		}
		
		if ($this->eventids != '' && $wbbuserdata['can_view_calendar']) {
			$result = $db->unbuffered_query("SELECT eventid, subject FROM bb".$n."_events WHERE eventid IN (0".$this->eventids.") AND (public=2 OR (public=1 AND groupid = '$wbbuserdata[groupid]') OR (public=0 AND userid = '$wbbuserdata[userid]'))");
			while ($row = $db->fetch_array($result)) $this->eventcache[$row['eventid']] = htmlconverter($row['subject']);
		}
	}
	
	function get() {
		global $lang, $session, $SID_ARG_1ST, $SID_ARG_2ND, $SID_ARG_2ND_UN;  
		
		$this->counter++;
		if (isset($this->useronlinecache[$this->counter])) {
			if (!$this->useronlinecache[$this->counter]['invisible'] || $this->can_view_ghosts == 1) {
				switch ($this->useronlinecache[$this->counter]['script']) {
					
					case "index.php":
						$location = $lang->get("LANG_WIW_FILE_INDEX", array('$SID_ARG_1ST' => $SID_ARG_1ST));
						break;

					case "wiw.php":
						$location = $lang->get("LANG_WIW_FILE_WIW", array('$SID_ARG_1ST' => $SID_ARG_1ST));
						break;
					
					case "register.php":
						$location = $lang->get("LANG_WIW_FILE_REGISTER", array('$SID_ARG_1ST' => $SID_ARG_1ST));
						break;
					
					case "usercp.php":
						$location = $lang->get("LANG_WIW_FILE_USERCP", array('$SID_ARG_1ST' => $SID_ARG_1ST));
						break;
					
					case "login.php":
						$location = $lang->get("LANG_WIW_FILE_LOGIN");
						break;
					
					case "profile.php":
						if (isset($this->useronlinecache[$this->counter]['profile_userid']) && isset($this->usercache[$this->useronlinecache[$this->counter]['profile_userid']])) {
							$userid = $this->useronlinecache[$this->counter]['profile_userid'];
							$username = $this->usercache[$userid];
							
							$location = $lang->get("LANG_WIW_FILE_PROFILE", array('$userid' => $userid, '$SID_ARG_2ND' => $SID_ARG_2ND, '$username' => $username));
						}
						else $location = $lang->get("LANG_WIW_FILE_UNKNOWN");
					break;
					
					case "logout.php":
						$location = $lang->get("LANG_WIW_FILE_LOGOUT");
						break;
					
					case "memberslist.php":
						$location = $lang->get("LANG_WIW_FILE_MEMBERSLIST", array('$SID_ARG_1ST' => $SID_ARG_1ST));
						break;
					
					case "search.php":
						$location = $lang->get("LANG_WIW_FILE_SEARCH", array('$SID_ARG_1ST' => $SID_ARG_1ST));
						break;
					
					case "calendar.php":
						if (isset($this->useronlinecache[$this->counter]['eventid']) && isset($this->eventcache[$this->useronlinecache[$this->counter]['eventid']])) {
							$eventid = $this->useronlinecache[$this->counter]['eventid'];
							$subject = $this->eventcache[$eventid];
							
							$location = $lang->get("LANG_WIW_FILE_CALENDAR_VIEWEVENT", array('$eventid' => $eventid, '$SID_ARG_2ND' => $SID_ARG_2ND, '$subject' => $subject));
						}
						else $location = $lang->get("LANG_WIW_FILE_CALENDAR", array('$SID_ARG_1ST' => $SID_ARG_1ST));
						break;
					
					case "team.php":
						$location = $lang->get("LANG_WIW_FILE_TEAM", array('$SID_ARG_1ST' => $SID_ARG_1ST));
						break;
					
					case "pms.php":
						$location = $lang->get("LANG_WIW_FILE_PMS", array('$SID_ARG_1ST' => $SID_ARG_1ST));
						break;
					
					case "modcp.php":
						$location = $lang->get("LANG_WIW_FILE_MODCP");
						break;
					
					case "editpost.php":
						if (isset($this->useronlinecache[$this->counter]['postid']) && isset($this->postcache[$this->useronlinecache[$this->counter]['postid']])) {
							$postid = $this->useronlinecache[$this->counter]['postid'];
							$topic = $this->postcache[$postid];
							
							$location = $lang->get("LANG_WIW_FILE_EDITPOST", array('$postid' => $postid, '$SID_ARG_2ND' => $SID_ARG_2ND, '$topic' => $topic));
						}
						else $location = $lang->get("LANG_WIW_FILE_UNKNOWN");
						break;
					
					case "board.php":
						if (isset($this->useronlinecache[$this->counter]['boardid']) && isset($this->boardcache[$this->useronlinecache[$this->counter]['boardid']])) {
							$boardid = $this->useronlinecache[$this->counter]['boardid'];
							$title = $this->boardcache[$boardid];
							
							$location = $lang->get("LANG_WIW_FILE_BOARD", array('$boardid' => $boardid, '$SID_ARG_2ND' => $SID_ARG_2ND, '$title' => $title));
						}
						else $location = $lang->get("LANG_WIW_FILE_UNKNOWN");
						break;
					
					case "newthread.php":
						if (isset($this->useronlinecache[$this->counter]['boardid']) && isset($this->boardcache[$this->useronlinecache[$this->counter]['boardid']])) {
							$boardid = $this->useronlinecache[$this->counter]['boardid'];
							$title = $this->boardcache[$boardid];
							
							$location = $lang->get("LANG_WIW_FILE_NEWTHREAD", array('$boardid' => $boardid, '$SID_ARG_2ND' => $SID_ARG_2ND, '$title' => $title));
						}
						else $location = $lang->get("LANG_WIW_FILE_UNKNOWN");
						break;
					
					case "thread.php":
						if (isset($this->useronlinecache[$this->counter]['threadid']) && isset($this->threadcache[$this->useronlinecache[$this->counter]['threadid']])) {
							$threadid = $this->useronlinecache[$this->counter]['threadid'];
							$topic = $this->threadcache[$threadid];
							
							$location = $lang->get("LANG_WIW_FILE_THREAD", array('$threadid' => $threadid, '$SID_ARG_2ND' => $SID_ARG_2ND, '$topic' => $topic));
						}
						else $location = $lang->get("LANG_WIW_FILE_UNKNOWN");
						break;
					
					case "addreply.php":
						if (isset($this->useronlinecache[$this->counter]['threadid']) && isset($this->threadcache[$this->useronlinecache[$this->counter]['threadid']])) {
							$threadid = $this->useronlinecache[$this->counter]['threadid'];
							$topic = $this->threadcache[$threadid];
							
							$location = $lang->get("LANG_WIW_FILE_ADDREPLY", array('$threadid' => $threadid, '$SID_ARG_2ND' => $SID_ARG_2ND, '$topic' => $topic));
						}
						else $location = $lang->get("LANG_WIW_FILE_UNKNOWN");
					break;
					
					case "usergroups.php":
						$location = $lang->get("LANG_WIW_FILE_USERGROUPS");
						break;

					case "index.html":
						$location = $lang->get("LANG_WIW_FILE_ARCHIVE_INDEX", array('$SID_ARG_1ST' => $SID_ARG_1ST));
						break;

					case "board.html":
						if (isset($this->useronlinecache[$this->counter]['boardid']) && isset($this->boardcache[$this->useronlinecache[$this->counter]['boardid']])) {
							$boardid = $this->useronlinecache[$this->counter]['boardid'];
							$title = $this->boardcache[$boardid];
							
							$location = $lang->get("LANG_WIW_FILE_ARCHIVE_BOARD", array('$boardid' => $boardid, '$SID_ARG_2ND' => $SID_ARG_2ND, '$title' => $title));
						}
						else $location = $lang->get("LANG_WIW_FILE_UNKNOWN");
						break;

					case "thread.html":
						if (isset($this->useronlinecache[$this->counter]['threadid']) && isset($this->threadcache[$this->useronlinecache[$this->counter]['threadid']])) {
							$threadid = $this->useronlinecache[$this->counter]['threadid'];
							$topic = $this->threadcache[$threadid];
							
							$location = $lang->get("LANG_WIW_FILE_ARCHIVE_THREAD", array('$threadid' => $threadid, '$SID_ARG_2ND' => $SID_ARG_2ND, '$topic' => $topic));
						}
						else $location = $lang->get("LANG_WIW_FILE_UNKNOWN");
						break;
					
					default:
						$location = $lang->get("LANG_WIW_FILE_UNKNOWN");
				}
				$this->useronlinecache[$this->counter]['location'] = $location;
				return $this->useronlinecache[$this->counter];
			}
			else return $this->get();
		}	
		else return ;	
	}
}
?>