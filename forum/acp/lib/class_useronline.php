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


class useronline {
	
	var $modids = array();
	var $can_view_ghosts = 0;
	var $useronlinebit = "";
	var $buddies = array();
	
	function useronline($can_view_ghosts, $buddylist = '') {
		$this->can_view_ghosts = $can_view_ghosts;
		$this->buddies = explode(' ', $buddylist); 
	}
	
	function parse($userid, $username, $useronlinemarking, $invisible) {
		global $tpl, $SID_ARG_1ST, $SID_ARG_2ND, $SID_ARG_2ND_UN, $lang;
		
		if (is_array($this->buddies) && in_array($userid, $this->buddies)) eval("\$username = \"".$tpl->get("useronline_buddy")."\";");
		
		if ($useronlinemarking != '') $username = sprintf($useronlinemarking, $username);
		
		eval("\$useronlinebit = \"".$tpl->get("index_useronline")."\";");
		return $useronlinebit;
	}
	
	function user($userid, $username, $useronlinemarking, $invisible) {
		if ($invisible == 1 && $this->can_view_ghosts == 0) return "";
		if ($this->useronlinebit != '') $this->useronlinebit .= ", ".$this->parse($userid, $username, $useronlinemarking, $invisible);
		else $this->useronlinebit = $this->parse($userid, $username, $useronlinemarking, $invisible);
	}
}
?>