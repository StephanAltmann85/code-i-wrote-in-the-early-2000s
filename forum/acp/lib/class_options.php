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


class options {
	var $path2lib = '';
	
	function options($path2lib) {
		$this->path2lib = $path2lib;
	}
	
	function write() {
		global $db, $n;
		
		$fp = fopen($this->path2lib.'/options.inc.php', 'w+b');
		fwrite($fp, "<?php\n// automatic generated option file\n// do not change\n\n");
		$result = $db->query("SELECT varname, value FROM bb".$n."_options");	
		while ($row = $db->fetch_array($result)) fwrite($fp, "\$".$row['varname']." = \"".str_replace("\"", "\\\"", dos2unix($row['value']))."\";\n");
		fwrite($fp, "?>");
		fclose($fp);	
	}
}
?>