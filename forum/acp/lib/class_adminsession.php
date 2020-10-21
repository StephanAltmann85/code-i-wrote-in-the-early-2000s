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


class adminsession {
	var $hash = '';
	var $authentificationcode = '';
	
	function update($hash = '', $ip, $agent) {
		$error = 0;
		if ($hash != '' && wbb_strlen($hash) == 32) {
			global $db, $n, $adminsession_timeout, $wbbuserdata, $disableverify;
			
			if ($disableverify != 0) $session = $db->query_first("SELECT * FROM bb".$n."_adminsessions WHERE sessionhash = '".addslashes($hash)."' AND lastactivity >= '".(time() - $adminsession_timeout)."'");
			else $session = $db->query_first("SELECT * FROM bb".$n."_adminsessions WHERE sessionhash = '".addslashes($hash)."' AND ipaddress = '".addslashes($ip)."' AND useragent = '".addslashes($agent)."' AND lastactivity >= '".(time() - $adminsession_timeout)."'");
			if ($session['sessionhash']) {
				$this->hash = $session['sessionhash'];
				$this->authentificationcode = $session['authentificationcode'];
				$wbbuserdata = getwbbuserdata($session['userid'], "userid", 2);
				$db->unbuffered_query("UPDATE bb".$n."_adminsessions SET lastactivity='".time()."' WHERE sessionhash = '".$this->hash."'", 1);	
			}
			else $error = 1;
		}
		else $error = 1;
		
		return $error;
	}	
	
	function create($userid, $ip, $agent, $authentificationcode = '') {
		global $db, $n;
		
		$this->hash = md5(uniqid(microtime()));
		$db->query("INSERT INTO bb".$n."_adminsessions (sessionhash,userid,ipaddress,useragent,starttime,lastactivity,authentificationcode) VALUES ('".$this->hash."','$userid','".addslashes($ip)."','".addslashes($agent)."','".time()."','".time()."', '".addslashes($authentificationcode)."')");
	}	
}
?>