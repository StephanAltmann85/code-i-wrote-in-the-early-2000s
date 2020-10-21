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


require('./global.php');
$lang->load('ACP_DATABASE');

@set_time_limit(0);
if (ini_get('safe_mode')) {
	$perpage = 5000;	
}
else {
	$perpage = 0;	
}








if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];
else $action = '';




/** download created backup **/
if ($action == 'backup_download') {
	checkAdminPermissions('a_can_database_backup', 1);
	
	if (isset($_REQUEST['filename'])) $tmpfilename = $_REQUEST['filename'];
	else $tmpfilename = '';
	if (!file_exists($tmpfilename)) {
		header("Location: database.php?action=backup&sid=$session[hash]");
		exit;
	}
	$filename = "backup_wBB2_" . formatdate("YmdHi", time()) . ".sql" . (($_REQUEST['use_gz'] && function_exists("gzopen")) ? (".gz") : (""));  
	
	// get mime type
	if (preg_match("/Opera\/[0-9]\.[0-9]{1,2}/", $_SERVER['HTTP_USER_AGENT']) || preg_match("/MSIE [0-9]\.[0-9]{1,2}/", $_SERVER['HTTP_USER_AGENT'])) $mime_type = "application/octetstream";
	else $mime_type = "application/octet-stream";
	
	// send file to browser
	header("Content-Type: ".$mime_type);
	header("Expires: ".date("D, d M Y H:i:s"));
	if (preg_match("/MSIE [0-9]\.[0-9]{1,2}/", $_SERVER['HTTP_USER_AGENT'])) {
		header("Content-Disposition: inline; filename=\"".$filename."\"");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Pragma: public");
	}
	else {
		header("Content-Disposition: attachment; filename=\"".$filename."\"");
		header("Pragma: no-cache");
	}
	
	// output gzip file
	readfile($tmpfilename);
	@unlink($tmpfilename);	
}


/** create a database backup **/
if ($action == 'backup') {
	checkAdminPermissions('a_can_database_backup', 1);
	
	if (isset($_POST['send'])) {
		// shell backup  	
		if ($_POST['download'] == 2) {
			if (count($_POST['tables'])) {
				require("./lib/config.inc.php");
				
				$shellstring = "mysqldump --add-locks -qela";
				if ($_POST['structure'] == 0) $shellstring .= "t";
				if ($_POST['drop_table'] == 1) $shellstring .= " --add-drop-table"; 
				$shellstring .= " -h{$sqlhost} -u{$sqluser} -p{$sqlpassword} {$sqldb} ";
				$shellstring .= implode(" ", $_POST['tables']);
				if ($_POST['use_gz'] == 1) $shellstring .= " | gzip > ./backup_wBB2_".formatdate("YmdHi", time()).".sql.gz"; 
				else $shellstring .= " > ./backup_wBB2_".formatdate("YmdHi", time()).".sql";
				@system($shellstring);
				
				acp_message($lang->get("LANG_ACP_DATABASE_BACKUP_DONE"));
			}
			else acp_error($lang->get("LANG_ACP_DATABASE_ERROR_1"));	
			
			exit;	
		}
		
		// no tables selected
		if (!$_POST['tables'] || !count($_POST['tables'])) acp_error($lang->get("LANG_ACP_DATABASE_ERROR_1"));
		
		// create backup file
		if (isset($_POST['use_gz']) && $_POST['use_gz'] && function_exists("gzopen")) $use_gz = 1;
		else $use_gz = 0;
		
		if (isset($_POST['download']) && $_POST['download'] == 1) $tmpfilename = "./temp/backup_".md5(uniqid(rand())).($use_gz ? (".gz") : (""));
		else $tmpfilename = "./backup_wBB2_".formatdate("YmdHi", time()).".sql".(($use_gz) ? (".gz") : (""));
		if ($use_gz) $fp = @gzopen($tmpfilename, "w1b");
		else $fp = @fopen($tmpfilename, "w+b");
		
		// file header 
		@wbbfwrite($fp, "# WoltLab Burning Board $boardversion Database Backup\n# generated: ".formatdate($wbbuserdata['dateformat']." ".$wbbuserdata['timeformat'], time())."\n\n");

		// backup all selected tables at once
		if (!$perpage) {
			foreach ($_POST['tables'] as $table) {
				// export structure
				if ($_POST['structure'] == 1) {
					@wbbfwrite($fp, dumpTableStructure($table, $_POST['drop_table']));
				}
				// delete all
				elseif ($_POST['delete_all'] == 1) @wbbfwrite($fp, "DELETE FROM $table;\n\n");
				
				// get table data
				dumpTableData($table, $fp);
				@wbbfwrite($fp, "\n\n");
			}
		}
		
		// close backup file
		@wbbfclose($fp);
		
		if ($perpage) {
			// output javascript to start backing up the database.
			$tables = '';
			foreach ($_POST['tables'] as $table) {
				if (isset($firstTable)) $firstTable = $table;
				$tables .= makeoption($table, $table, $_POST['tables']);	
			}
			eval("\$tpl->output(\"".$tpl->get("working_loaddbbackup", 1)."\",1);");
			exit;	
		}
		
		// download file (if dumped at once)
		if ($_POST['download'] == 1) {
			$filename = "backup_wBB2_" . formatdate("YmdHi", time()) . ".sql" . (($_POST['use_gz'] && function_exists("gzopen")) ? (".gz") : (""));  
			
			// get mime type
			if (preg_match("/Opera\/[0-9]\.[0-9]{1,2}/", $_SERVER['HTTP_USER_AGENT']) || preg_match("/MSIE [0-9]\.[0-9]{1,2}/", $_SERVER['HTTP_USER_AGENT'])) $mime_type = "application/octetstream";
			else $mime_type = "application/octet-stream";
			
			// send file to browser
			header("Content-Type: ".$mime_type);
			header("Expires: ".date("D, d M Y H:i:s"));
			if (preg_match("/MSIE [0-9]\.[0-9]{1,2}/", $_SERVER['HTTP_USER_AGENT'])) {
				header("Content-Disposition: inline; filename=\"".$filename."\"");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Pragma: public");
			}
			else {
				header("Content-Disposition: attachment; filename=\"".$filename."\"");
				header("Pragma: no-cache");
			}
			
			// output gzip file
			readfile($tmpfilename);
			@unlink($tmpfilename);
		}
		else {
			acp_message($lang->get("LANG_ACP_DATABASE_BACKUP_DONE"));
		}
		exit;	
	}
	
	$result = mysql_list_tables($sqldb);
	$table_options = '';
	while ($row = $db->fetch_array($result)) $table_options .= makeoption($row[0], $row[0], $row[0], 1);
	
	eval("\$tpl->output(\"".$tpl->get("database_backup", 1)."\",1);");
}









/** execute sql query **/
if ($action == 'query') {
	if (!checkAdminPermissions("a_can_database_query") && !checkAdminPermissions("a_can_database_extra")) access_error(1);
	if (isset($_POST['send'])) {
		checkAdminPermissions("a_can_database_query", 1);
		$query = '';
		if (isset($_FILES['uploadfile']['tmp_name']) && $_FILES['uploadfile']['tmp_name'] && is_uploaded_file($_FILES['uploadfile']['tmp_name'])) {
			do {
   				$tempfile = "./temp/sqlimport_".md5(uniqid(rand()));
   			}
			while (file_exists($tempfile));
	
			if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $tempfile)) {
				@chmod($tempfile, 0777);
			}
			
			if (wbb_strtolower(wbb_substr($_FILES['uploadfile']['name'], - 3)) == ".gz") $query = implode("", gzfile($tempfile));
			else $query = implode("", file($tempfile)); 	
		}
		elseif ($_POST['query']) $query = $_POST['query'];
		elseif ($_POST['filename'] && file_exists($_POST['filename'])) {
			if (wbb_strtolower(wbb_substr($_POST['filename'], - 3)) == ".gz") $query = implode("", gzfile($_POST['filename']));
			else $query = implode("", file($_POST['filename']));
		}
		if ($query != '') {
			include('./lib/class_query.php');
			$sql_query = new query($query);
			$sql_query->doquery();
			
			$lang->items['LANG_ACP_DATABASE_QUERY_DONE'] = $lang->get("LANG_ACP_DATABASE_QUERY_DONE", array('$sqldb' => $sqldb));
			acp_message($lang->get("LANG_ACP_DATABASE_QUERY_DONE"));
		}	
	}
	
	$table_options = '';
	if (checkAdminPermissions("a_can_database_extra")) {
		$result = mysql_list_tables($sqldb);
		while ($row = $db->fetch_array($result)) $table_options .= makeoption($row[0], $row[0], "", 0);
	}
	
	$lang->items['LANG_ACP_DATABASE_QUERY'] = $lang->get("LANG_ACP_DATABASE_QUERY", array('$sqldb' => $sqldb));
	eval("\$tpl->output(\"".$tpl->get("database_query", 1)."\",1);");
}



// OPTIMIZE|REPAIR TABLE
if ($action == 'extra') {
	checkAdminPermissions("a_can_database_extra", 1);
	if (!$_POST['tables'] || !count($_POST['tables'])) acp_error($lang->get("LANG_ACP_DATABASE_ERROR_1"));
	reset($_POST['tables']);
	
	if ($_POST['what'] == 1) while (list($key, $val) = each($_POST['tables'])) $db->unbuffered_query("OPTIMIZE TABLE $val");	
	elseif ($_POST['what'] == 2) while (list($key, $val) = each($_POST['tables'])) $db->unbuffered_query("REPAIR TABLE $val");	
	
	@header("Location: database.php?action=query&sid=$session[hash]");
	exit();
}
?>