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


class language {  
	
	var $items = array();  
	var $languagepackid = 0; 
	var $path = '.';
	
	function language($languagepackid, $path = '.') {
		$this->languagepackid = $languagepackid;
		$this->path = $path;
	}
	
	function load($catlist = '') {
		$cats = explode(",", $catlist);
		
		for ($i = 0; $i < count($cats); $i++) {
			if (@file_exists($this->path."/cache/language/".$this->languagepackid."_".wbb_strtolower($cats[$i]).".php")) {
				include_once($this->path."/cache/language/".$this->languagepackid."_".wbb_strtolower($cats[$i]).".php");
			}
		}
	}
	
	function get($itemname, $params = array()) {  
		if (isset($this->items[$itemname])) {
			$content = $this->items[$itemname];
		}
		else {
			return $itemname;
		}
		
		if (count($params)) {
			return strtr($content, $params);
		}
		else {
			return $content;
		}
	}
	
	function get4eval($itemname) {  
  		return str_replace("\"", "\\\"", $this->get($itemname));      
 	}
	
	function setPath($path) {
		$this->path = $path;
	}
}  
?>