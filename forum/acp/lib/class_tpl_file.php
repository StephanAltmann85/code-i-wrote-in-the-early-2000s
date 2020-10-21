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


class tpl {
	
	var $templates   = array();
	var $templatepackid = 0;
	var $path = ".";
	
	/* constuctor */
	function tpl($templatepackid = 0, $path = ".") {
		$this->templatepackid = $templatepackid;
		$this->path = $path;
	}
	
	/* get template */
	function get($templatename, $isacp = 0) {
		// board template
		if ($isacp == 0) {
			if (!isset($this->templates[$templatename])) {
				
				// get templatepackid
				if ($this->templatepackid != 0) {
					global $wbbuserdata;
					if (!is_array($wbbuserdata['templatestructure'])) {
						$wbbuserdata['templatestructure'] = unserialize($wbbuserdata['templatestructure']);
					}
					$templatepackid = $wbbuserdata['templatestructure'][$templatename];
				}
				else $templatepackid = 0;
				
				// include template
				if (file_exists($this->path."/cache/templates/".$templatepackid."_".$templatename.".php")) {
					include($this->path."/cache/templates/".$templatepackid."_".$templatename.".php");
				}
				else $this->templates[$templatename] = "template &quot;".$templatename."&quot; doesnt exist";
			}
			
			return $this->templates[$templatename];
		}
		
		// acp template
		else {
			if (!isset($this->templates['acp_'.$templatename])) {
				if (file_exists($this->path."/cache/templates/acp/".$templatename.".php")) {
					include($this->path."/cache/templates/acp/".$templatename.".php");
				}
				else $this->templates['acp_'.$templatename] = "template &quot;".$templatename."&quot; doesnt exist";
			}
			
			return $this->templates['acp_'.$templatename];
		}
	}
	
	/* print template */
	function output($template, $isacp = 0) {
		headers::send($isacp);
		print($template);
	}
}
?>