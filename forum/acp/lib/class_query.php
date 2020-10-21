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


class query {
	var $query = '';
	
	function query($query) {
		$this->query = $query;	
	}
	
	function doquery() {
		global $db;
		
		$this->query = preg_replace("/(\n|^)#[^\n]*(\n|$)/", "\\1", wbb_trim($this->query));
		$buffer = array();
		$query_array = array();
		$in_string = false;
		
		for ($i = 0; $i < wbb_strlen($this->query) - 1; $i++) {
			if ($this->query[$i] == ";" && !$in_string) {
				$query_array[] = wbb_substr($this->query, 0, $i);
				$this->query = wbb_substr($this->query, $i + 1);
				$i = 0;
			}
			if (isset($buffer[1])) $buffer[0] = $buffer[1];
			
			if ($in_string && $this->query[$i] == "'" && $buffer[0] != "\\") $in_string = false;
			elseif (!$in_string && $this->query[$i] == "'" && (!isset($buffer[0]) || $buffer[0] != "\\")) $in_string = true;
			
			$buffer[1] = $this->query[$i];
		}
		
		if (!empty($this->query)) $query_array[] = $this->query;
		for ($i = 0; $i < count($query_array); $i++) {
			$query_array[$i] = wbb_trim($query_array[$i]);
			if (!$query_array[$i]) continue;
			$db->unbuffered_query($query_array[$i], 0, 0, 0, 0);
		}	
	}
}
?>