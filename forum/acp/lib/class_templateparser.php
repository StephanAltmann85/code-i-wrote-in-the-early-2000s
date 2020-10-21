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


class TemplateParser {

	/**
	* compile template sourcecode
	*
	* @param string code template sourcecode
	* @return string compiled templatecode
	*
	*/
	function parse($code) {
		
		// addslashes		
		$code = addcslashes($code, '"\\');
		
		// replace single if -> if/else
		$code = preg_replace('!</then>(\s*)</if>!i', '</then><else></else>\\1</if>', $code);
		
		// replace if tag
		$code = preg_replace('!<if\((.*)\)>!sieU', '"\".((".$this->stripSlashes(\'\\1\').") "', $code);
		
		// replace end if tag
		$code = preg_replace('!</if>!i', ')."', $code);
		
		// replace then tag
		$code = preg_replace('!<then>!i', '? ("', $code);
		
		// replace end then tag
		$code = preg_replace('!</then>!i', '") ', $code);
		
		// replace else tag
		$code = preg_replace('!<else>!i', ': ("', $code);
		
		// replace end else tag
		$code = preg_replace('!</else>!i', '")', $code);
		
		// replace expression tags
		$code = preg_replace('!<expression>(.*)</expression>!sieU', '"\".".$this->stripSlashes(\'\\1\').".\""', $code);
		
		return $code;
	}

	/**
	* strip slashes from conditions
	*
	* @param string code if condition
	* @return string if condition
	*
	*/
	function stripSlashes($code) {
		//$code = str_replace('\$', '$', $code);
		$code = str_replace('\\\\', '\\', $code);
		$code = str_replace('\"', '"', $code);
		$code = str_replace('\"', '"', $code);
		
		return $code;
	}

}
?>