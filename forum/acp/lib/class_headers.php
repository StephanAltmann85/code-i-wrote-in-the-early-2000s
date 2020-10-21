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


class headers {
	
	/** send headers **/
	function send($isacp = 0) {
		global $sendnocacheheaders, $gzip;
		
		@header("Content-type: text/html; charset=".ENCODING);
		
		if ($isacp == 0) {
			if ($sendnocacheheaders == 1) {
				@header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
				@header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
				@header("Cache-Control: no-cache, must-revalidate");
				@header("Pragma: no-cache");
			}
			if ($gzip == 1) headers::compress();
		}
	}
	
	/** compress output **/
	function compress() {
		global $_SERVER, $gziplevel;
		
		if (strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') && $gziplevel != 0 && function_exists('gzcompress')) {
			ob_start('gzoutput');
			@header('Content-Encoding: gzip');
		}
	}
}

function gzoutput($output) {
	global $gziplevel;
	
	$size = wbb_strlen($output);
	$newoutput = "\x1f\x8b\x08\x00\x00\x00\x00\x00";
	$newoutput .= wbb_substr(gzcompress($output, $gziplevel), 0, - 4);
	$newoutput .= pack("V", $size);
	
	return $newoutput;
}
?>