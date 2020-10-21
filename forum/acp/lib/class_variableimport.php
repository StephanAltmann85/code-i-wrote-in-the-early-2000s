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


/**
* class to import a .wbb variablefile (see docs for format definition)
* 
* usage: $variableimport = new variableimport('variablefile.wbb');
* 
* // get data
* $data = $variableimport->getData(); 
*
* if ($variableimport->errors()) echo 'the following errors occured while reading variablefile: <br />'.$variableimport->getErrors().'<br />';
* else
* {
* 	// import variables into database
* 	$variableimport->import();
* 	if ($variableimport->errors()) echo 'the following errors occured while trying to import variablefile: <br />'.$variableimport->getErrors().'<br />';
* 	elseif ($variableimport->warnings()) echo 'Warning:<br />'.$variableimport->getWarnings().'<br />';
* 	else echo 'variables successfully imported.<br />';
* }
*
*
*/
class variableimport {
	/**
	* the variablefiles' filename
	* @access public
	*/
	var $filename = '';

	/**
	* all errors will be logged into this array
	* @access private
	*/
	var $errors = array();

	/**
	* all warnings will be logged into this array
	* @access private
	*/
	var $warnings = array();
	
	/**
	* array to store content of the variablefile
	* @access private
	* @see variableimport::getData()
	*/
	var $data = array();
	
	/**
	* cache to store all languagepackids
	* @access private
	*/
	var $languagepackids = array();

	/**
	* cache to store necessary languagecategories
	* @access private
	*/
	var $languagecats = array();

	/**
	* cache to store showorder values
	* @access private
	*/
	var $showorder = array();

	/**
	* cache to store variablegroups
	* @access private
	*/
	var $variablegroupids = array();

	/**
	* cache to store optiongroups
	* @access private
	*/
	var $optiongroupids = array();
	
	/**
	* cache to store menuitemgroups
	* @access private
	*/
	var $itemgroupids = array();
	
		
	/**
	* create variableimport object and reads variablefile
	* 
	* @param filename string
	* @access public
	*/
	function variableimport($filename) {
		if (!file_exists($filename)) {
			$this->errors[] = "variablefile $filename does not exist.";
			return false;
		}
		else $this->filename = $filename;
		if (!$this->_readdata()) $this->errors[] = "invalid variablefile.";
	}
	
	
	/**
	* returns a multidimensional array containing the variables stored in the variablefile
	* 
	* @return data array
	* @access public
	*/
	function getData() {
		return $this->data;	
	}
	
	/**
	* returns true if errors occured during import
	* 
	* @return errors boolean
	* @access public
	*/
	function errors() {
		return (boolean)count($this->errors);
	}
	
	/**
	* returns the error messages
	* 
	* @return errorstring string
	* @access public
	*/
	function getErrors() {
		return implode(' < br / >', $this->errors);
	}
	

	/**
	* returns true if warnings occured during import
	* 
	* @return warnings boolean
	* @access public
	*/
	function warnings() {
		return (boolean)count($this->warnings);
	}
	
	/**
	* returns the warnings
	* 
	* @return warnings string
	* @access public
	*/
	function getWarnings() {
		return implode(' < br / >', $this->warnings);
	}
	
	
	/**
	* start import of the variables.
	* existing variables will not be overwritten.
	* after importing the variables, the class is updating the languagecache.
	*
	* @return void
	* @access public
	*/
	function import() {
		global $db, $n;
		$this->languagepackids = array();
		$this->languagecats = array();
		$this->showorder = array();

		$result = $db->query("SELECT languagepackid FROM bb".$n."_languagepacks");
		while ($row = $db->fetch_array($result)) $this->languagepackids[] = $row['languagepackid'];
		$result = $db->query("SELECT catid,catname FROM bb".$n."_languagecats WHERE catname='acp_group' OR catname='acp_options' OR catname='acp_global'");
		while ($row = $db->fetch_array($result)) $this->languagecats[$row['catname']] = $row['catid'];
		foreach ($this->languagecats as $catname => $catid) {
			list($this->showorder['lang'][$catname]) = $db->query_first("SELECT MAX(showorder) as showorder FROM bb".$n."_languages WHERE catid='$catid'");
			$this->showorder['lang'][$catname]++;
		}
		
		// insert optiongroups & options
		if (count($this->data['wbboptiongroup'])) $this->_insert_optiongroup();
		if (count($this->data['wbboption'])) $this->_insert_option();

		// insert acpmenuitemgroups & acpmenuitems
		if (count($this->data['wbbacpmenuitemgroup'])) $this->_insert_menuitemgroup();
		if (count($this->data['wbbacpmenuitem'])) $this->_insert_menuitem();
		
		// insert groupvariablegroups & groupvariables
		if (count($this->data['wbbgroupvariablegroup'])) {
			$sort = array();
			foreach ($this->data['wbbgroupvariablegroup'] as $array) $sort[] = $array['parent'];
			array_multisort($sort, SORT_ASC, SORT_STRING, $this->data['wbbgroupvariablegroup']);
			
			$this->showorder['groupvariablegroups'] = array();
			$result = $db->query("SELECT variablegroupid,parentvariablegroupid,title,showorder FROM bb".$n."_groupvariablegroups");
			while ($row = $db->fetch_array($result)) {
				if ($row['showorder'] > $this->showorder['groupvariablegroups'][$row['parentvariablegroupid']]) $this->showorder['groupvariablegroups'][$row['parentvariablegroupid']] = $row['showorder']; 
				$this->variablegroupids[$row['title']] = $row['variablegroupid'];
			}
			foreach ($this->showorder['groupvariablegroups'] as $key => $val) $this->showorder['groupvariablegroups'][$key]++;
			$this->_insert_groupvariablegroup_recursive();
		}
		if (count($this->data['wbbgroupvariable'])) $this->_insert_groupvariable();
		
		
		// update languagecache
		foreach ($this->languagecats as $catid) {
			foreach ($this->languagepackids as $languagepackid) {
				updateCache($languagepackid, $catid);	
			}
		}
	}
	
	
	
	/**
	* private function to parse the content of the variablefile
	* 
	* @return void
	* @access private
	*/	
	function _readdata() {
		$this->data = array();
		$entities = array(
			"wbboptiongroup" => array("name", "title", "acpmode"),
			"wbboption" => array("name", "group", "value", "type", "title", "desc", "acpmode"),
			"wbbgroupvariablegroup" => array("name", "title", "parent", "securitylevel", "acpmode"),
			"wbbgroupvariable" => array("name", "type", "defaultvalue", "title", "desc", "group", "acpmode"),
			"wbbacpmenuitemgroup" => array("name", "condition", "conditiontype", "acpmode"),
			"wbbacpmenuitem" => array("name", "title", "group", "link", "linkformat", "condition", "conditiontype", "acpmode")
		);
		
		$entitypattern = '';
		foreach ($entities as $entity => $val) {
			$data[$entity] = array();
			if ($entitypattern) $entitypattern .= "|".$entity;
			else $entitypattern = $entity;
		}
		
		// read in file
		$fp = fopen($this->filename, "rb");
		$file = fread($fp, filesize($this->filename));
		fclose($fp);
		$file = preg_replace("#(?:\r\n)|(?:\r)#", "\n", $file);
		$file = preg_replace("#<\?xml.*\?>\n?#i", "", $file);
		
		// match entities	
		preg_match_all("#<($entitypattern)>\s*(.*)\s*</\\1>#isU", $file, $matches);
		$max = count($matches[0]);
	
		// parse found entities
		for ($i = 0; $i < $max; $i++) {
			preg_match_all("#<(".implode("|", $entities[wbb_strtolower($matches[1][$i])]).")>(.*)</\\1>#isU", $matches[2][$i], $matches2);
			$max2 = count($matches2[0]);
			if ($max2 != count($entities[wbb_strtolower($matches[1][$i])])) return false;
			$temp = array();
			for ($j = 0; $j < $max2; $j++) {
				if (wbb_strtolower($matches2[1][$j]) != $entities[wbb_strtolower($matches[1][$i])][$j]) return false;
				$temp[wbb_strtolower($matches2[1][$j])] = trim($matches2[2][$j]);
			}
			$this->data[wbb_strtolower($matches[1][$i])][$temp[$entities[wbb_strtolower($matches[1][$i])][0]]] = $temp;
			unset($temp);
			unset($matches2);
			
		}
		unset($matches);
		return true;
	}


	/**
	* private function to import groupvariables 
	*
	* @return void
	* @access private
	*/
	function _insert_groupvariable() {
		global $db, $n;
		
		$newvalues = array();
		$groupvariablecache = array();
		$this->showorder['groupvariable'] = array();
		$result = $db->query("SELECT variableid,variablename,variablegroupid,showorder FROM bb".$n."_groupvariables");
		while ($row = $db->fetch_array($result)) {
			$groupvariablecache[$row['variablename']] = $row['variableid'];
			if ($row['showorder'] > $this->showorder['groupvariable'][$row['variablegroupid']]) $this->showorder['groupvariable'][$row['variablegroupid']] = $row['showorder'];
		}
		foreach ($this->showorder['groupvariable'] as $key => $val) $this->showorder['groupvariable'][$key]++;
		
		$insert_str = '';
		$insert_str2 = '';
		$variablenames = '';
		foreach ($this->data['wbbgroupvariable'] as $groupvariable) {
			if (!isset($groupvariablecache[$groupvariable['name']]) || !$groupvariablecache[$groupvariable['name']]) {
				if (!isset($this->variablegroupids[$groupvariable['group']])) {
					list($variablegroupid) = $db->query_first("SELECT variablegroupid FROM bb".$n."_groupvariablegroups WHERE title='".addslashes($groupvariable['group'])."'");
					if (!$variablegroupid) $this->errors[] = "no variablegroup '$groupvariable[group]' for groupvariable '$groupvariable[name]' found.";
					else $this->variablegroupids[$groupvariable['group']] = $variablegroupid;
				}
				else $variablegroupid = $this->variablegroupids[$groupvariable['group']];
				
				if ($variablegroupid) {
					if (!isset($this->showorder['groupvariable'][$variablegroupid])) $this->showorder['groupvariable'][$variablegroupid] = 1;
					$insert_str .= ",('".addslashes($groupvariable['name'])."', '".addslashes($groupvariable['type'])."', '".addslashes($groupvariable['defaultvalue'])."', '".$variablegroupid."', '".$this->showorder['groupvariable'][$variablegroupid]."', '".intval($groupvariable['acpmode'])."')";
					$this->showorder['groupvariable'][$variablegroupid]++;
					$variablenames .= ",'".addslashes($groupvariable['name'])."'";
					// insert title & desc into languagepack
					if ($groupvariable['title']) {
						foreach ($this->languagepackids as $languagepackid) {
							$insert_str2 .= ",('LANG_ACP_GROUP_VAR_".addslashes(wbb_strtoupper($groupvariable['name']))."', '$languagepackid', '".$this->languagecats['acp_group']."', '".addslashes($groupvariable['title'])."', '".$this->showorder['lang']['acp_group']."'),('LANG_ACP_GROUP_VAR_".addslashes(wbb_strtoupper($groupvariable['name']))."_DESC', '$languagepackid', '".$this->languagecats['acp_group']."', '".addslashes($groupvariable['desc'])."', '".($this->showorder['lang']['acp_group'] + 1)."')";
							$this->showorder['lang']['acp_group'] += 2;
						}
					}
				}
			}
			else $this->warnings[] = "groupvariable '$groupvariable[name]' already exists.";
		}
		if ($variablenames && $insert_str) {
			$db->unbuffered_query("INSERT INTO bb".$n."_groupvariables (variablename,type,defaultvalue,variablegroupid,showorder,acpmode) VALUES ".wbb_substr($insert_str, 1), 1);
			
			$insert_str = '';
			$newvalues = array();
			$result = $db->query("SELECT variableid,defaultvalue FROM bb".$n."_groupvariables WHERE variablename IN (".wbb_substr($variablenames, 1).")");
			while ($row = $db->fetch_array($result)) $newvalues[$row['variableid']] = $row['defaultvalue'];

			$result = $db->query("SELECT groupid FROM bb".$n."_groups");
			while ($row = $db->fetch_array($result)) {
				foreach ($newvalues as $variableid => $value) {
					$insert_str .= ",('$row[groupid]','$variableid','".addslashes($value)."')";
				}
			}
			if ($insert_str) $db->unbuffered_query("INSERT INTO bb".$n."_groupvalues (groupid,variableid,value) VALUES ".wbb_substr($insert_str, 1), 1);
			unset($insert_str);
			unset($variablenames);
			unset($newvalues);
			$result = $db->query("SELECT groupids FROM bb".$n."_groupcombinations");
			while ($row = $db->fetch_array($result)) cachegroupcombinationdata($row['groupids']);
		}
		if ($insert_str2) {
			$db->unbuffered_query("REPLACE INTO bb".$n."_languages (itemname,languagepackid,catid,item,showorder) VALUES ".wbb_substr($insert_str2, 1), 1);
			unset($insert_str2);
		}
	}
	
	
	
	/**
	* private recursive function to import variablegroups 
	*
	* @param groupname string
	* @return variablegroupid integer
	* @access private
	*/
	function _insert_groupvariablegroup_recursive($name = '') {
		global $db, $n;	
		if (!$name) {
			foreach ($this->data['wbbgroupvariablegroup'] as $variablegroup) {
				if (isset($this->variablegroupids[$variablegroup['name']]) && $this->variablegroupids[$variablegroup['name']]) $variablegroupid = $this->variablegroupids[$variablegroup['name']];
				else {
					$variablegroupid = $this->_insert_groupvariablegroup_insert($variablegroup['name']);
					$variablegroupids[$newvariablegroup['name']] = $variablegroupid;
				}
			}
			return $variablegroupid;
		}
		else {
			$variablegroup = $this->data['wbbgroupvariablegroup'][$name];
			if (isset($this->variablegroupids[$variablegroup['name']]) && $this->variablegroupids[$variablegroup['name']]) return $this->variablegroupids[$variablegroup['name']];
			$variablegroupid = $this->_insert_groupvariablegroup_insert($name);
			return $variablegroupid;
		}
	}
	
	
	
	
	/**
	* private function to insert one groupvariable
	*
	* @param groupname string
	* @return variablegroupid integer
	* @access private
	*/
	function _insert_groupvariablegroup_insert($name) {
		global $db, $n;
		
		$variablegroup = $this->data['wbbgroupvariablegroup'][$name];
		if (!$variablegroup) $this->errors[] = "variablegroup '$name' not found in datafile.";
		
		if (!isset($this->variablegroupids[$name]) || !$this->variablegroupids[$name]) {
			// get parentid
			if ($variablegroup['parent']) {
				if (isset($this->variablegroupids[$variablegroup['parent']])) $parentid = $this->variablegroupids[$variablegroup['parent']];
				elseif (isset($this->data['wbbgroupvariablegroup'][$variablegroup['parent']])) $parentid = $this->_insert_groupvariablegroup_recursive($variablegroup['parent']);
				else list($parentid) = $db->query_first("SELECT variablegroupid FROM bb".$n."_groupvariablegroups WHERE title='".addslashes($variablegroup['parent'])."'");
				if (!$parentid) $this->errors[] = "parent group '$variablegroup[parent]' for '$name' not found.";
			}
			else $parentid = 0;
			
			if (!isset($this->showorder['groupvariablegroups'][$parentid])) $this->showorder['groupvariablegroups'][$parentid] = 1;
			$db->query("INSERT INTO bb".$n."_groupvariablegroups (parentvariablegroupid,title,showorder,securitylevel,acpmode) VALUES ('$parentid','".addslashes($variablegroup['name'])."','".intval($this->showorder['groupvariablegroups'][$parentid])."','".intval($variablegroup['securitylevel'])."','".intval($variablegroup['acpmode'])."')");
			$variablegroupid = $db->insert_id();
			$this->showorder['groupvariablegroups'][$parentid]++;
			// insert title into languagepack
			foreach ($this->languagepackids as $languagepackid) {
				$db->unbuffered_query("REPLACE INTO bb".$n."_languages (itemname,languagepackid,catid,item,showorder) VALUES ('LANG_ACP_GROUP_VARGROUP_".addslashes(wbb_strtoupper($variablegroup['name']))."', '".$languagepackid."', '".$this->languagecats['acp_group']."', '".addslashes($variablegroup['title'])."', '".$this->showorder['lang']['acp_group']."')", 1);
				$this->showorder['lang']['acp_group']++;
			}
		}
		else $this->warnings[] = "variablegroup '$name' already exists.";
		$this->variablegroupids[$name] = $variablegroupid;
		return $variablegroupid;
	}
	
	
	
	
	/**
	* private function to import optiongroups
	*
	* @return void
	* @access private
	*/
	function _insert_optiongroup() {
		global $db, $n;
		
		$this->optiongroupids = array();
		$showorder = 0;
		$result = $db->query("SELECT optiongroupid,title,showorder FROM bb".$n."_optiongroups");
		while ($row = $db->fetch_array($result)) {
			$this->optiongroupids[$row['title']] = $row['optiongroupid'];
			if ($row['showorder'] > $showorder) $showorder = $row['showorder'];
		}
		$showorder++;
		
		foreach ($this->data['wbboptiongroup'] as $optiongroup) {
			if (!isset($this->optiongroupids[$optiongroup['name']]) || !$this->optiongroupids[$optiongroup['name']]) {
				// insert optiongroup
				$db->query("INSERT INTO bb".$n."_optiongroups (title,showorder,acpmode) VALUES ('".addslashes($optiongroup['name'])."','".$showorder."','".intval($optiongroup['acpmode'])."')");
				$optiongroupid = $db->insert_id();
				$showorder++;
				
				// insert title into languagepack
				foreach ($this->languagepackids as $languagepackid) {
					$db->unbuffered_query("REPLACE INTO bb".$n."_languages (itemname,languagepackid,catid,item,showorder) VALUES ('LANG_ACP_OPTIONS_GROUP_".addslashes(wbb_strtoupper($optiongroup['name']))."', '$languagepackid', '".$this->languagecats['acp_options']."', '".addslashes($optiongroup['title'])."', '".$this->showorder['lang']['acp_options']."')", 1);
					$this->showorder['lang']['acp_options']++;
				}
			}
			else $this->warnings[] = "optiongroup '$optiongroup[name]' already exists.";
			$this->optiongroupids[$optiongroup['name']] = $optiongroupid;			
		}
	}
	
	
	
	
	
	/**
	* private function to import options
	*
	* @return void
	* @access private
	*/
	function _insert_option() {
		global $db, $n;
		
		$optioncache = array();
		$showorder = array();
		$result = $db->query("SELECT optionid,varname,optiongroupid,showorder FROM bb".$n."_options");
		while ($row = $db->fetch_array($result)) {
			$optioncache[$row['varname']] = $row['optionid'];
			if ($row['showorder'] > $showorder[$row['optiongroupid']]) $showorder[$row['optiongroupid']] = $row['showorder'];	
		}
		foreach ($showorder as $key => $val) $showorder[$key]++;
		
		$insert_str = '';
		$insert_str2 = '';
		foreach ($this->data['wbboption'] as $option) {
			if (!isset($optioncache[$option['name']]) || !$optioncache[$option['name']]) {
				if ($option['group']) {
					if (!isset($this->optiongroupids[$option['group']])) {
						list($optiongroupid) = $db->query_first("SELECT optiongroupid FROM bb".$n."_optiongroups WHERE title='".addslashes($option['group'])."'");	
						if (!$optiongroupid) $this->errors[] = "no optiongroup '".$option['group']."' for option '".$option['name']."'";
						$this->optiongroupids[$option['group']] = $optiongroupid;
					}
					else $optiongroupid = $this->optiongroupids[$option['group']];
				}
				else $optiongroupid = 0;
				
				// insert only if optiongroup found
				if (!$option['group'] || $optiongroupid) {
					if (!isset($showorder[$optiongroupid])) $showorder[$optiongroupid] = 1;
					$insert_str .= ",('".$optiongroupid."', '".addslashes($option['name'])."', '".addslashes($option['value'])."', '".addslashes($option['type'])."', '".$showorder[$optiongroupid]."', '".intval($option['acpmode'])."')";
					$showorder[$optiongroupid]++;
					$optioncache[$option['name']] = "X";
					// insert title & description into languagepack
					if ($option['title']) {
						foreach ($this->languagepackids as $languagepackid) {
							$insert_str2 .= ",('LANG_ACP_OPTIONS_OPTION_".addslashes(wbb_strtoupper($option['name']))."', '$languagepackid', '".$this->languagecats['acp_options']."', '".addslashes($option['title'])."', '".$this->showorder['lang']['acp_options']."'),('LANG_ACP_OPTIONS_OPTION_".addslashes(wbb_strtoupper($option['name']))."_DESC', '$languagepackid', '".$this->languagecats['acp_options']."', '".addslashes($option['desc'])."', '".($this->showorder['lang']['acp_options'] + 1)."')";
							$this->showorder['lang']['acp_options'] += 2;
						}
					}
				}
			}
			else $this->warnings[] = "option '$option[name]' already exists.";
		}
		if ($insert_str) {
			$db->unbuffered_query("INSERT INTO bb".$n."_options (optiongroupid,varname,value,optioncode,showorder,acpmode) VALUES ".wbb_substr($insert_str, 1), 1);
			unset($insert_str1);
		}
		if ($insert_str2) {
			$db->unbuffered_query("REPLACE INTO bb".$n."_languages (itemname,languagepackid,catid,item,showorder) VALUES ".wbb_substr($insert_str2, 1), 1);
			unset($insert_str2);
		}
	}








	/**
	* private function to import acpmenuitemgroups
	*
	* @return void
	* @access private
	*/
	function _insert_menuitemgroup() {
		global $db, $n;
		
		$this->itemgroupids = array();
		$showorder = 0;
		$result = $db->query("SELECT itemgroupid,title,showorder FROM bb".$n."_acpmenuitemgroups");
		while ($row = $db->fetch_array($result)) {
			$this->itemgroupids[$row['title']] = $row['itemgroupid'];
			if ($row['showorder'] > $showorder) $showorder = $row['showorder'];
		}
		$showorder++;
		
		foreach ($this->data['wbbacpmenuitemgroup'] as $itemgroup) {
			if (!isset($this->itemgroupids[$itemgroup['name']]) || !$this->itemgroupids[$itemgroup['name']]) {
				// insert itemgroup
				$itemgroup['conditiontype'] = wbb_strtoupper($itemgroup['conditiontype']);
				switch ($itemgroup['conditiontype']) {
					case "OR": break;
					case "AND": break;
					default: $itemgroup['conditiontype'] = "OR";
				}
				$db->query("INSERT INTO bb".$n."_acpmenuitemgroups (title,condition,conditiontype,showorder,acpmode) VALUES ('".addslashes($itemgroup['name'])."','".addslashes($itemgroup['condition'])."','".addslashes($itemgroup['conditiontype'])."','".$showorder."','".intval($itemgroup['acpmode'])."')");
				$itemgroupid = $db->insert_id();
				$showorder++;
			}
			else $this->warnings[] = "itemgroup '$itemgroup[name]' already exists.";
			$this->itemgroupids[$itemgroup['name']] = $itemgroupid;			
		}
	}
	
	
	
	
	
	/**
	* private function to import acpmenuitems
	*
	* @return void
	* @access private
	*/
	function _insert_menuitem() {
		global $db, $n;
		
		$itemcache = array();
		$showorder = array();
		$result = $db->query("SELECT itemid,itemgroupid,languageitem,showorder FROM bb".$n."_acpmenuitems");
		while ($row = $db->fetch_array($result)) {
			$itemcache[$row['languageitem']] = $row['itemid'];
			if ($row['showorder'] > $showorder[$row['itemgroupid']]) $showorder[$row['itemgroupid']] = $row['showorder'];	
		}
		foreach ($showorder as $key => $val) $showorder[$key]++;
		
		$insert_str = '';
		$insert_str2 = '';
		foreach ($this->data['wbbacpmenuitem'] as $item) {
			$item['name'] = wbb_strtoupper($item['name']);
			if (!isset($itemcache[$item['name']]) || !$itemcache[$item['name']]) {
				if ($item['group']) {
					if (!isset($this->itemgroupids[$item['group']])) {
						list($itemgroupid) = $db->query_first("SELECT itemgroupid FROM bb".$n."_acpmenuitemgroups WHERE title='".addslashes($item['group'])."'");	
						if (!$itemgroupid) $this->errors[] = "no acpmenuitemgroup '".$item['group']."' for acpmenuitem '".$item['name']."'";
						$this->itemgroupids[$item['group']] = $itemgroupid;
					}
					else $itemgroupid = $this->itemgroupids[$item['group']];
				}
				else $itemgroupid = 0;
				
				// insert only if itemgroup found
				if (!$item['group'] || $itemgroupid) {
					$item['conditiontype'] = wbb_strtoupper($item['conditiontype']);
					switch ($item['conditiontype']) {
						case "OR": break;
						case "AND": break;
						default: $item['conditiontype'] = "OR";
					}
					if (!isset($showorder[$itemgroupid])) $showorder[$itemgroupid] = 1;
					$insert_str .= ",('".$itemgroupid."', '".addslashes($item['name'])."', '".addslashes($item['link'])."', '".addslashes($item['linkformat'])."', '".addslashes($item['condition'])."', '".addslashes($item['conditiontype'])."', '".$showorder[$itemgroupid]."', '".intval($item['acpmode'])."')";
					$showorder[$itemgroupid]++;
					$itemcache[$item['name']] = "X";
					// insert title & description into languagepack
					if ($item['title']) {
						foreach ($this->languagepackids as $languagepackid) {
							$insert_str2 .= ",('LANG_ACP_GLOBAL_MENU_".addslashes($item['name'])."', '$languagepackid', '".$this->languagecats['acp_global']."', '".addslashes($item['title'])."', '".$this->showorder['lang']['acp_global']."')";
							$this->showorder['lang']['acp_global']++;
						}
					}
				}
			}
			else $this->warnings[] = "acpmenuitem '$item[name]' already exists.";
		}
		if ($insert_str) {
			$db->unbuffered_query("INSERT INTO bb".$n."_acpmenuitems (itemgroupid, languageitem, link, linkformat, condition, conditiontype, showorder, acpmode) VALUES ".wbb_substr($insert_str, 1), 1);
			unset($insert_str1);
		}
		if ($insert_str2) {
			$db->unbuffered_query("REPLACE INTO bb".$n."_languages (itemname, languagepackid, catid, item, showorder) VALUES ".wbb_substr($insert_str2, 1), 1);
			unset($insert_str2);
		}
	}
}
?>