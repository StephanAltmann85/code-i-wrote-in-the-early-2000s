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


class parsecode extends parse {
	function parsecode($usecode = 1) {
		$this->usecode = $usecode;
		if ($usecode == 1) {
			$this->generateHash();
		}
	}
	function doparse($post) {
		// cache code
		if ($this->usecode == 1) {
			$this->tempsave['php'] = array();
			$this->tempsave['code'] = array();
			$this->index['php'] = -1;
			$this->index['code'] = -1;
			$post = preg_replace("/(\[(php|code)\])(.*)(\[\/\\2\])/seiU", "\$this->cachecode('\\3','\\2')", $post);
		}
		return $post;
	}
	function replacecode($post) {
		if ($this->usecode == 1 && ($this->index['php'] != -1 || $this->index['code'] != -1)) {
			reset($this->tempsave);
			while (list($mode, $val) = each($this->tempsave)) {
				while (list($varnr, $code) = each($val)) $post = str_replace("{".$this->hash."_".$mode."_".$varnr."}", "[".$mode."]".str_replace("\\\"", "\"", $code)."[/".$mode."]", $post);
			}
		}
		return $post;
	}			
}
?>