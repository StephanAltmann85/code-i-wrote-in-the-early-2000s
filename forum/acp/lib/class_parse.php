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
// * $Date: 2004-12-14 13:53:45 +0100 (Tue, 14 Dec 2004) $
// * $Author: Burntime $
// * $Rev: 1513 $
// ************************************************************************************//


class parse {
	var $search = array();
	var $replace = array();
	
	var $smilie_search = array();
	var $smilie_replace = array();
	var $smilie_search2 = array();
	var $smilie_replace2 = array();
	
	var $wrapwidth = 75;
	var $hilight = '';
	var $showimages = 0;
	var $docensor = 0;
	var $censorwords = array();
	var $censorcover = '';
	var $imgsearch = '';
	var $imgreplace = '';
	var $censorsearch = array();
	var $censorreplace = array();
	
	var $done = array(); 
	var $cuturls = 0;
	var $linenumbers = 1;
	
	// (php - ) & code parse 
	var $usecode = 0;
	var $index = array();
	var $hash = '';
	var $tempsave = array();
	
	var $hilightSearch = '';
	var $hilightReplace = '';
	
	var $useCaching = 0;
	
	
	function parse($docensor = 0, $wrapwidth = 0, $showimages = 0, $hilight = '', $usecode = 1, $cuturls = 1, $useCaching = 0) {
		$this->done = array('bbcode' => 0, 'smilies' => 0);  
		$this->useCaching = $useCaching;
		
		if ($hilight) $this->hilight = urldecode($hilight);
		if ($docensor == 1) {
			$this->docensor = 1;
			global $censorwords, $censorcover;
			$this->censorwords = explode("\n", preg_replace("/\s*\n\s*/", "\n", wbb_trim($censorwords)));
			$this->censorcover = $censorcover;
		}
		if ($wrapwidth) $this->wrapwidth = $wrapwidth;
		if ($showimages) $this->showimages = $showimages;
		$this->prepareimages();
		$this->cuturls = $cuturls;
		
		if ($usecode == 1) $this->usecode = 1;
		
		$this->generateHash();
	}
	
	function getsmilies() {
		global $db, $n, $lang;
		$i = 0;
		$result = $db->unbuffered_query("SELECT smilieid, smiliecode, smiliepath, smilietitle FROM bb".$n."_smilies ORDER BY smilieorder ASC");
		while ($row = $db->fetch_array($result)) {
			$row['smilietitle'] = getlangvar($row['smilietitle'], $lang);
			
			$this->smilie_search[] = "/".$this->preg_quote($row['smiliecode'])."/";
			$this->smilie_replace[] = "{".$this->hash."_".$row['smilieid']."}";
			
			$this->smilie_search2[] = "/{".$this->hash."_".$row['smilieid']."}/";
			if ($this->useCaching) $row['smiliepath'] = str_replace("{imagefolder}", "@@@imagefolder@@@", $row['smiliepath']);
			$this->smilie_replace2[] = makeimgtag($row['smiliepath'], $row['smilietitle'], 0) . "\n";
		}
		
		$this->done['smilies'] = 1;
	}
	
	
	function getHilight($forBBCode = false) {
		if ($this->done['hilight'] == 1 && $forBBCode) {
			if ($this->hilightSearch != '') {			
				$this->search[] = $this->hilightSearch;
				$this->replace[] = $this->hilightReplace;
			}
		
			return;
		}

		if ($this->hilight) {
			$hilightwords = preg_replace("/[\/:;'\"\(\)\[\]?!#{}%\-+\\\\]/s", "", str_replace("/", "\/", quotemeta($this->hilight)));
			$hilightwords = preg_replace("/\s{2,}/", " ", $hilightwords);
			$hilightwords = preg_split("/[\s]/", wbb_strtolower($hilightwords), - 1, PREG_SPLIT_NO_EMPTY);
			while (list($key, $word) = each($hilightwords)) {
				if ($word == "and" || $word == "or" || $word == "not") continue;
				
				$word = addcslashes($word, '.|$=<>^');
				
				$word = str_replace("*", "[0-9a-z]*", $word);
				$word = str_replace("_", "[0-9a-z]{1}", $word);
				
				if (!isset($hilightstring)) $hilightstring = $word;
				else $hilightstring .= "|".$word;
			}
			if (isset($hilightstring)) {
				$this->hilightSearch = "/(^|\s|\]|>|\")($hilightstring)(([,\.]{1}[\s[\"<$]+)|\s|\[|\"|<|$)/i";;
				$this->hilightReplace = "\\1<span class=\"highlight\">\\2</span>\\3"; 
				
				if ($forBBCode) {
					$this->search[] = $this->hilightSearch;
					$this->replace[] = $this->hilightReplace;
				}
			}
		}
		
		$this->done['hilight'] = 1;
	}
	
	
	
	function getbbcode() {
		global $db, $n, $style, $lang;
		
		$this->search[] = "/\[list=(&quot;|['\"]?)([^\"']+)\\1](.+)\[\/list((=\\1[^\"']+\\1])|(\]))/esiU";
		$this->replace[] = "\$this->formatlist('\\3', '\\2')"; 
		$this->search[] = "/\[list](.+)\[\/list\]/esiU";	
		$this->replace[] = "\$this->formatlist('\\1')"; 
		$this->search[] = "/\[url=(&quot;|['\"]?)([^\"']+)\\1](.+)\[\/url\]/esiU";
		$this->replace[] = "\$this->formaturl('\\2','\\3')";
		$this->search[] = "/\[url]([^\"]+)\[\/url\]/eiU";	
		$this->replace[] = "\$this->formaturl('\\1')";
		$this->search[] = "/javascript:/i";
		$this->replace[] = "java script:";
		$this->search[] = "/vbscript:/i";
		$this->replace[] = "vb script:";
		$this->search[] = "/about:/i";
		$this->replace[] = "about :";
		
		$this->getHilight(true);
		
		$threeparams = "/\[%s=(&quot;|['\"]?)(%s),(%s)\\1](%s)\[\/%s\]/siU";
		$twoparams = "/\[%s=(&quot;|['\"]?)(%s)\\1](%s)\[\/%s\]/siU";
		$oneparam = "/\[%s](%s)\[\/%s\]/siU"; 
		
		$result = $db->unbuffered_query("SELECT bbcodetag, bbcodereplacement, params, multiuse, pattern1, pattern2, pattern3, eval_replacement FROM bb".$n."_bbcodes ORDER BY params ASC");
		
		while ($row = $db->fetch_array($result)) {
			if ($row['params'] == 1) {
				if (!$row['pattern1']) $row['pattern1'] = ".*";
				$search = sprintf($oneparam, $row['bbcodetag'], $row['pattern1'], $row['bbcodetag']);
			}
			if ($row['params'] == 2) {
				if (!$row['pattern1']) $row['pattern1'] = "[^\"']+";
				if (!$row['pattern2']) $row['pattern2'] = ".*";
				$search = sprintf($twoparams, $row['bbcodetag'], $row['pattern1'], $row['pattern2'], $row['bbcodetag']);
			}
			if ($row['params'] == 3) {
				if (!$row['pattern1']) $row['pattern1'] = "[^\"']+";
				if (!$row['pattern2']) $row['pattern2'] = "[^\"']+";
				if (!$row['pattern3']) $row['pattern3'] = ".*";
				$search = sprintf($threeparams, $row['bbcodetag'], $row['pattern1'], $row['pattern2'], $row['pattern3'], $row['bbcodetag']);
			}
			
			if ($row['eval_replacement'] == 1) {
				eval("\$row['bbcodereplacement'] = \"".addcslashes($row['bbcodereplacement'], "\"\\")."\";");
			}
			
			for ($i = 0; $i < $row['multiuse']; $i++) {
				$this->search[] = $search;
				$this->replace[] = $row['bbcodereplacement'];
			}
		}
		$this->done['bbcode'] = 1;
	}
	
	function prepareimages() {
		global $allowdynimg;
		
		if ($allowdynimg == 1) $this->imgsearch = "/\[img]([^\"]+)\[\/img\]/siU";
		else $this->imgsearch = "/\[img]([^\"\?\&]+\.(gif|jpg|jpeg|bmp|png))\[\/img\]/siU";
		if ($this->showimages == 1) $this->imgreplace = "<img src=\"\\1\" alt=\"\" border=\"0\" class=\"resizeImage\" />";
		else $this->imgreplace = "<a href=\"\\1\" target=\"_blank\">\\1</a>";
	}
	
	function censor($post) {
		if (count($this->censorsearch) == 0 || count($this->censorreplace) == 0) {
			reset($this->censorwords);
			while (list($key, $censor) = each($this->censorwords)) {
				$censor = wbb_trim($censor);
				if (!$censor) continue;
				
				if (preg_match("/\{([^=]+)=([^=]*)\}/si", $censor, $exp)) {  
					$this->censorsearch[] = "/(^|\s|\]|>|\")(".$this->preg_quote($exp[1]).")(([,\.]{1}[\s[\"<$]+)|\s|\[|\"|<|$)/i";                		
					$this->censorreplace[] = "\\1".$exp[2]."\\3";
				}
				elseif (preg_match("/\{([^=]+)\}/si", $censor, $exp)) {
					$this->censorsearch[] = "/(^|\s|\]|>|\")(".$this->preg_quote($exp[1]).")(([,\.]{1}[\s[\"<$]+)|\s|\[|\"|<|$)/i";
					$this->censorreplace[] = "\\1".str_repeat($this->censorcover, wbb_strlen($exp[1]))."\\3";
				}
				elseif (preg_match("/([^=]+)=([^=]*)/si", $censor, $exp)) {
					$this->censorsearch[] = "/".$this->preg_quote($exp[1])."/i";
					$this->censorreplace[] = $exp[2];
				}
				else {
					$this->censorsearch[] = "/".$this->preg_quote($censor)."/i";
					$this->censorreplace[] = str_repeat($this->censorcover, wbb_strlen($censor));
				}
			}
		}
		if (count($this->censorsearch) > 0 && count($this->censorreplace) > 0) return preg_replace($this->censorsearch, $this->censorreplace, $post);
		else return $post;
	}
	
	function doparse($post, $allowsmilies, $allowhtml, $allowbbcode, $allowimages) {
		// censorship
		if ($this->docensor == 1) $post = $this->censor($post);
		
		// cache code
		if ($this->usecode == 1 && $allowbbcode == 1) {
			$this->tempsave['php'] = array();
			$this->tempsave['code'] = array();
			$this->index['php'] = -1;
			$this->index['code'] = -1;
			$post = preg_replace("/(\[(php|code)\])(.*)(\[\/\\2\])/seiU", "\$this->cachecode('\\3','\\2')", $post);
		}
		
		// cache smilies
		if ($allowsmilies == 1) {
			if ($this->done['smilies'] != 1) $this->getsmilies(); 
			
			$post = preg_replace($this->smilie_search, $this->smilie_replace, $post);
		}
		
		// wrap text
		$post = $this->textwrap($post, $this->wrapwidth, 1);
		
		// remove tab
		$post = str_replace("\t", " ", $post);
		
		// html  
		if ($allowhtml == 0) {
			$post = htmlconverter($post);
			$post = nl2br($post);
		}
		else $post = preg_replace("/<([\/]?)script([^>]*)>/i", "&lt;\\1script\\2&gt;", $post);
		
		// bbcodes
		if ($allowbbcode == 1) {
			if ($this->done['bbcode'] != 1) $this->getbbcode(); 
			$post = preg_replace($this->search, $this->replace, $post);
		}
		else {
			$post = preg_replace("/javascript:/i", "java script:", $post);
			$post = preg_replace("/vbscript:/i", "vb script:", $post);
		}
		
		// images
		if ($allowimages != 0) $post = preg_replace($this->imgsearch, $this->imgreplace, $post);
		
		// replace smilies
		if ($allowsmilies == 1) $post = preg_replace($this->smilie_search2, $this->smilie_replace2, $post);
		
		// insert code
		if ($this->usecode == 1 && $allowbbcode == 1 && ($this->index['php'] != -1 || $this->index['code'] != -1)) $post = $this->replacecode($post);
		
		return $post;
	}
	
	function textwrap($post, $wrapwidth = 0, $inpost = 0) {
		if ($wrapwidth == 0) $wrapwidth = $this->wrapwidth;
		if ($post) {
			if ($inpost == 1) return preg_replace("/([^\n\r ?&\.\/\"\\-{}]{".$wrapwidth."})/i", " \\1\n", $post);
			else return preg_replace("/([^\n\r -]{".$wrapwidth."})/i", " \\1\n", $post);
		}
	}
	
	function cachecode($code, $mode) {
		$mode = wbb_strtolower($mode);
		$this->index[$mode]++;
		$this->tempsave[$mode][$this->index[$mode]] = $code;
		return "{".$this->hash."_".$mode."_".$this->index[$mode]."}";
	}
	
	function replacecode($post) {
		reset($this->tempsave);
		while (list($mode, $val) = each($this->tempsave)) {
			while (list($varnr, $code) = each($val)) $post = str_replace("{".$this->hash."_".$mode."_".$varnr."}", $this->codeformat($code, $mode), $post);
		}
		return $post;
	}
	
	function codeformat($code, $mode) {
		global $tpl, $phpversion, $style, $lang, $filename;
		
		if ($mode == "php") {
			$phptags = 0;
			$code = str_replace("\\\"", "\"", $code);
			
			if (!wbb_strpos($code, "<?") && wbb_substr($code, 0, 2) != "<?") {
				$phptags = 1;
				$code = "<?php ".wbb_trim($code)." ?>";
			}
			ob_start();
			$oldlevel = error_reporting(0);
			highlight_string($code);
			error_reporting($oldlevel);
			$buffer = ob_get_contents();
			ob_end_clean();
			
			$buffer = str_replace("<code>", "", $buffer);
			$buffer = str_replace("</code>", "", $buffer);
			
			if ($phptags == 1) {
				if (version_compare($phpversion, "4.3.0") == -1) $buffer = preg_replace("/([^\\2]*)(&lt;\?php&nbsp;)(.*)(&nbsp;.*\?&gt;)([^\\4]*)/si", "\\1\\3\\5", $buffer);
				else if (version_compare($phpversion, "5.0.0RC1") == -1) $buffer = preg_replace("/([^\\2]*)(&lt;\?php )(.*)( .*\?&gt;)([^\\4]*)/si", "\\1\\3\\5", $buffer);
				else {
					$buffer = preg_replace("/([^\\2]*)(&lt;\?php )(.*)(\?&gt;)([^\\4]*)/si", "\\1\\3\\5", $buffer);	
				}
			}
			
			$buffer = preg_replace("/<font color=\"([^\"]*)\">/i", "<span style=\"color: \\1\">", str_replace("</font>", "</span>", $buffer));
			if ($phptags == 1 && version_compare($phpversion, "4.3.0") != -1) $buffer = str_replace("<font</span>", "", $buffer);
			$buffer = preg_replace("/<span style=\"([^\"]*)\">/i", "<span style='\\1'>", $buffer);
			$buffer = str_replace("\"", "&quot;", $buffer);
			$buffer = str_replace("{", "&#123;", $buffer);
			$buffer = str_replace("}", "&#125;", $buffer);
			$buffer = str_replace("\n", "", $buffer);
			$buffer = str_replace("<br />", "\n", $buffer);
			
			$linecount = wbb_substr_count($buffer, "\n") + 1;
			$height = ($style['smallfontsize'] + 3) * $linecount + 50;
			
			if ($this->linenumbers == 1) $linenumbers = $this->makeLineNumbers($buffer);
			else $linenumbers = '';
			
			eval("\$code = \"".$tpl->get("codephptag")."\";");
		}
		else {
			$code = str_replace("\\\"", "\"", $code); 
			$code = htmlconverter($code); 
			//$code = str_replace(" ", "&nbsp;", $code); 
			//$code = nl2br($code);
			
			$code = str_replace("{", "&#123;", $code);
			$code = str_replace("}", "&#125;", $code);
			
			$linecount = wbb_substr_count($code, "\n") + 1;
			$height = ($style['smallfontsize'] + 3) * $linecount + 50;
			
			if ($this->linenumbers == 1) $linenumbers = $this->makeLineNumbers($code);
			else $linenumbers = '';
			
			eval("\$code = \"".$tpl->get("codetag")."\";");
		}
		
		return $code;
	}
	
	function formaturl($url, $title = '', $maxwidth = 60, $width1 = 40, $width2 = -15) {
		if (!wbb_trim($title)) {
			$title = rehtmlconverter($url);
			if (!preg_match("/[a-z]:\/\//si", $url)) $url = "http://$url";
			if ($this->cuturls == 1 && wbb_strlen($title) > $maxwidth) $title = wbb_substr($title, 0, $width1)."...".wbb_substr($title, $width2);
			return "<a href=\"$url\" target=\"_blank\">".htmlconverter(str_replace("\\\"", "\"", $title))."</a>";
		}
		else {
			if (!preg_match("/[a-z]:\/\//si", $url)) $url = "http://$url";
			return "<a href=\"$url\" target=\"_blank\">".$title."</a>";
		}
	}
	
	function formatlist($list, $listtype = '') {
		$listtype = wbb_trim($listtype);
		$listtype = ((!$listtype) ? ("") : (" type=\"$listtype\""));
		
		$list = wbb_trim($list);
		$list = str_replace("\\\"", "\"", $list);
		
		$list = amount_str_replace("</li>", "", str_replace("[*]", "</li><li>", $list), 1);
		if (strstr($list, "<li>")) $list .= "</li>";
		
		$list = preg_replace("/^.*(<li>)/sU", "\\1", $list);
		
		if ($listtype) return "<ol$listtype>".$list."</ol>";
		else return "<ul>".$list."</ul>";
	}
	
	function preg_quote($text) {
		$text = preg_quote($text);
		$text = str_replace("/", "\/", $text);
		return $text;
	}
	
	function makeLineNumbers($code, $split = "\n") {
		$lines = explode($split, $code);	
		
		$linenumbers = '';
		for ($i = 0; $i < count($lines); $i++) $linenumbers .= ($i + 1).":\n";	
		
		return $linenumbers;	
	}
	
	function generateHash() {
		for ($i = 0; $i < 6; $i++) {
			$time = intval(wbb_substr(microtime(), 2, 8));
			mt_srand($time);
			
			$this->hash .= mt_rand(0, 9);	
		}
	}
	
	
	function parseCache($post) {
		global $style;
		
		if ($this->done['hilight'] != 1) {
			$this->getHilight();
		}
		
		if ($this->hilightSearch != '') {
			$post = preg_replace($this->hilightSearch, $this->hilightReplace, $post);
		}
		
		$post = str_replace("@@@imagefolder@@@", $style['imagefolder'], $post);
		
		return $post;
	}
}
?>