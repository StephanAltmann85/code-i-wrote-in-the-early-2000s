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



// http://www.zend.com/zend/spotlight/creating-zip-files1.php

class zipfile {
	var $datasec = array();
	var $ctrl_dir = array();
	var $eof_ctrl_dir = "\x50\x4b\x05\x06\x00\x00\x00\x00";
	var $old_offset = 0;

	function add_dir($name) {
		$name = str_replace("\\", "/", $name);

		$fr = "\x50\x4b\x03\x04";
		$fr .= "\x0a\x00";
		$fr .= "\x00\x00";
		$fr .= "\x00\x00";
		$fr .= "\x00\x00\x00\x00";

		$fr .= pack("V", 0);
		$fr .= pack("V", 0);
		$fr .= pack("V", 0);
		$fr .= pack("v", wbb_strlen($name) );
		$fr .= pack("v", 0 );
		$fr .= $name;
		$fr .= pack("V", 0);
		$fr .= pack("V", 0);
		$fr .= pack("V", 0);

		$this -> datasec[] = $fr;

		$new_offset = wbb_strlen(implode("", $this->datasec));

		$cdrec = "\x50\x4b\x01\x02";
		$cdrec .= "\x00\x00";
		$cdrec .= "\x0a\x00";
		$cdrec .= "\x00\x00";
		$cdrec .= "\x00\x00";
		$cdrec .= "\x00\x00\x00\x00";
		$cdrec .= pack("V", 0);
		$cdrec .= pack("V", 0);
		$cdrec .= pack("V", 0);
		$cdrec .= pack("v", wbb_strlen($name) );
		$cdrec .= pack("v", 0 );
		$cdrec .= pack("v", 0 );
		$cdrec .= pack("v", 0 );
		$cdrec .= pack("v", 0 );
		$ext = "\x00\x00\x10\x00";
		$ext = "\xff\xff\xff\xff";
		$cdrec .= pack("V", 16 );
		$cdrec .= pack("V", $this -> old_offset );
		$cdrec .= $name;

		$this -> ctrl_dir[] = $cdrec;
		$this -> old_offset = $new_offset;

		return;
	}

	function add_file($data, $name, $date = 0) {
		$name = str_replace("\\", "/", $name);
		$unc_len = wbb_strlen($data);
		$crc = crc32($data);
		$zdata = gzcompress($data);
		$zdata = substr ($zdata, 2, - 4);
		$c_len = wbb_strlen($zdata);

		$fr = "\x50\x4b\x03\x04";
		$fr .= "\x14\x00";
		$fr .= "\x00\x00";
		$fr .= "\x08\x00";
		$fr .= "\x00\x00\x00\x00";
		$fr .= pack("V", $crc);
		$fr .= pack("V", $c_len);
		$fr .= pack("V", $unc_len);
		$fr .= pack("v", wbb_strlen($name) );
		$fr .= pack("v", 0 );
		$fr .= $name;
		$fr .= $zdata;
		$fr .= pack("V", $crc);
		$fr .= pack("V", $c_len);
		$fr .= pack("V", $unc_len);

		$this -> datasec[] = $fr;

		$new_offset = wbb_strlen(implode("", $this->datasec));
		$cdrec = "\x50\x4b\x01\x02";
		$cdrec .= "\x00\x00";
		$cdrec .= "\x14\x00";
		$cdrec .= "\x00\x00";
		$cdrec .= "\x08\x00";
		//$cdrec .= "\x00\x00\x00\x00";
		$cdrec .= $this->getDosDatetime($date);
		$cdrec .= pack("V", $crc);
		$cdrec .= pack("V", $c_len);
		$cdrec .= pack("V", $unc_len);
		$cdrec .= pack("v", wbb_strlen($name) );
		$cdrec .= pack("v", 0 );
		$cdrec .= pack("v", 0 );
		$cdrec .= pack("v", 0 );
		$cdrec .= pack("v", 0 );
		$cdrec .= pack("V", 32 );
		$cdrec .= pack("V", $this -> old_offset );

		$this -> old_offset = $new_offset;

		$cdrec .= $name;

		$this -> ctrl_dir[] = $cdrec;
	}

	function file() {
		$data = implode("", $this -> datasec);
		$ctrldir = implode("", $this -> ctrl_dir);

		return
			$data.
			$ctrldir.
			$this -> eof_ctrl_dir.
			pack("v", sizeof($this -> ctrl_dir)).
			pack("v", sizeof($this -> ctrl_dir)).
			pack("V", wbb_strlen($ctrldir)).
			pack("V", wbb_strlen($data)).
			"\x00\x00";
	}
	
	function getDosDatetime($date = 0) {
		$date = date("Y-m-d H:i:s", $date);

		$regexp = "([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})";
		$date = ereg_replace($regexp, "\\1-\\2-\\3-\\4-\\5-\\6", $date);
		$date_array = split("-", $date);
		
		$date_array[0] = $date_array[0]-1980;
		
		$date_day = $date_array[2];
		$date_month = $date_array[1];
		$date_year = $date_array[0];
		$date_hour = $date_array[3];
		$date_minute = $date_array[4];
		$date_second = $date_array[5];
		
		$my_time = $date_hour;
		$my_time = ($my_time << 6) + $date_minute;
		$my_time = ($my_time << 5) + number_format($date_second / 2, 0);
		$time_right = $my_time >> 8;
		$time_left = $my_time - ($time_right << 8);
		
		$my_date = $date_year;
		$my_date = ($my_date << 4) + $date_month;
		$my_date = ($my_date << 5) + $date_day;
		$date_right = $my_date >> 8;
		$date_left = $my_date - ($date_right << 8);
		
		$time_left = sprintf("%02x", $time_left);
		$time_right = sprintf("%02x", $time_right);
		$date_left = sprintf("%02x", $date_left);
		$date_right = sprintf("%02x", $date_right);
		
		return pack("H*H*H*H*", $time_left, $time_right, $date_left, $date_right);
	}
}

?>