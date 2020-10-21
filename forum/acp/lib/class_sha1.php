<?php


class sha1
{
	/**
	* A php implementation of the Secure Hash Algorithm, SHA-1, as defined
	* in FIPS PUB 180-1
	* Copyright 2002 (C) WoltLab GBR www.woltlab.info (by Troublegum)
	*/
	
	/**
	* @desc hashes a string using the SHA-1 algorithm
	* @autor Troublegum www.woltlab.info WoltLab GBR
	*/
	
	/**
	* usage:
	* $sha1 = new sha1();
	* $hash = $sha1->hash("string");
	*/

	/** integer variable: stores if the sha1 or mhash php-function is avaible or not */
	var $usage=0;

	function sha1()
	{
		$this->usage=0;
		if(extension_loaded("mhash") && function_exists("mhash")) $this->usage=2;
		if(function_exists("sha1")) $this->usage=1;
	}
	
	
	/**
	* @desc alternative to the zero fill shift right operator
	*/
	function zeroFill($a, $b)
	{
		$z = hexdec(80000000);
		if ($z & $a)
		{
			$a >>= 1;
			$a &= (~ $z);
			$a |= 0x40000000;
			$a >>= ($b-1);
		}
		else
		{
			$a >>= $b;
		}
		return $a;
	}
	
	
	/**
	* @desc conversion decimal to hexadecimal
	* @param decnum integer
	* @return hexstr string
	*/
	function hex($decnum)
	{
		$hexstr = dechex($decnum);
		if(strlen($hexstr)<8) $hexstr=str_repeat("0",8-strlen($hexstr)).$hexstr;
		return $hexstr;
	}



	/**
	* @desc divides a string into 16-word blocks
	* @param str string
	* @return blocks array
	*/
	function str2blks_SHA1($str)
	{
		$nblk = ((strlen($str) + 8) >> 6) + 1;
		$blks = array($nblk*16);
		
		for($i=0;$i<$nblk*16;$i++) $blks[$i]=0;
		for($i=0;$i<strlen($str);$i++) $blks[($i>>2)] |= ord(substr($str,$i,1)) << (24 - ($i % 4) * 8);
		$blks[($i>>2)] |= 0x80 << (24 - ($i % 4) * 8);
		$blks[($nblk * 16 - 1)] = strlen($str)*8;
		return $blks;
	}


	/**
	* @desc add integers, wrapping at 2^32. This uses 16-bit operations internally
	*/
	function add($x, $y)
	{
		$lsw = ($x & 0xFFFF) + ($y & 0xFFFF);
		$msw = ($x >> 16) + ($y >> 16) + ($lsw >> 16);
		return ($msw << 16) | ($lsw & 0xFFFF);
	}




	/**
	* @desc Bitwise rotate a 32-bit number to the left
	*/
	function rol($num, $cnt)
	{
		return ($num << $cnt) | $this->zeroFill($num,(32 - $cnt));
	}



	/**
	* @descPerform the appropriate triplet combination function for the current
	* iteration
	*/
	function ft($t,$b,$c,$d)
	{
		if($t<20) return ($b & $c) | ((~$b) & $d);
		elseif($t<40) return $b ^ $c ^ $d;
		elseif($t<60) return ($b & $c) | ($b & $d) | ($c & $d);
		else return $b ^ $c ^ $d;
	}

	/**
	* @desc Determine the appropriate additive constant for the current iteration
	*/
	function kt($t)
	{
		if($t<20) return 1518500249;
		elseif($t<40) return 1859775393;
		elseif($t<60) return -1894007588;
		else return -899497514;
	}

	/**
	* @desc hashes a string using SHA-1 und returns the hexadecimal conversion of it.
	* uses mhash library if avaible.
	* @param str string
	* @return sha1_hash string
	*/
	function hash($str)
	{
		if($this->usage==2)
		{
			return bin2hex(mhash(MHASH_SHA1,$str));
		}
		if($this->usage==1)
		{
			return sha1($str);
		}
		else
		{
			$x = $this->str2blks_SHA1($str);
			$w = Array(80);
			
			$a =  1732584193;
			$b = -271733879;
			$c = -1732584194;
			$d =  271733878;
			$e = -1009589776;
			
			for($i=0;$i<count($x);$i+=16)
			{
				$olda = $a;
				$oldb = $b;
				$oldc = $c;
				$oldd = $d;
				$olde = $e;
				
				for($j=0;$j<80;$j++)
				{
					if($j<16) $w[$j]=$x[($i + $j)];
					else $w[$j] = $this->rol(($w[($j-3)] ^ $w[($j-8)] ^ $w[($j-14)] ^ $w[($j-16)]), 1);
					$t = $this->add($this->add($this->rol($a, 5), $this->ft($j, $b, $c, $d)), $this->add($this->add($e, $w[$j]), $this->kt($j)));
					$e = $d;
					$d = $c;
					$c = $this->rol($b, 30);
					$b = $a;
					$a = $t;
				}
				
				$a = $this->add($a, $olda);
				$b = $this->add($b, $oldb);
				$c = $this->add($c, $oldc);
				$d = $this->add($d, $oldd);
				$e = $this->add($e, $olde);
			}
			return $this->hex($a).$this->hex($b).$this->hex($c).$this->hex($d).$this->hex($e);
		}
	}
}






?>