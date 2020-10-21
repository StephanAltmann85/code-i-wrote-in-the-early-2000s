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
// * $Date: 2005-05-17 14:14:45 +0200 (Tue, 17 May 2005) $
// * $Author: Burntime $
// * $Rev: 1609 $
// ************************************************************************************//


if (file_exists("./lib/install.lock")) die("please delete /acp/lib/install.lock to unlock installation");

@error_reporting(7);
@set_time_limit(0);
@set_magic_quotes_runtime(0);
$phpversion = phpversion();
$noerror = 0;
define('USE_MBSTRING', false);

/** get function libary **/
require("./lib/functions.php");
require("./lib/admin_functions.php");
if (version_compare($phpversion, "4.1.0") == -1) {
 	$_REQUEST = array_merge($HTTP_COOKIE_VARS, $HTTP_POST_VARS, $HTTP_GET_VARS);
 	$_COOKIE =& $HTTP_COOKIE_VARS;
 	$_SERVER =& $HTTP_SERVER_VARS;
 	$_FILES =& $HTTP_POST_FILES;
 	$_GET =& $HTTP_GET_VARS;
 	$_POST =& $HTTP_POST_VARS;
}

// remove slashes in get post cookie data...
if (get_magic_quotes_gpc()) {
  	if (is_array($_REQUEST)) $_REQUEST = stripslashes_array($_REQUEST);
  	if (is_array($_POST)) $_POST = stripslashes_array($_POST);
  	if (is_array($_GET)) $_GET = stripslashes_array($_GET);
  	if (is_array($_COOKIE)) $_COOKIE = stripslashes_array($_COOKIE);
}

/* page output function */
function informationPage($content, $title = '') {
 	echo '<?xml version="1.0" encoding="windows-1252"?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="de" xml:lang="de">
			<head>
				<title>' . $title . '</title>
				<link rel="stylesheet" href="css/other.css" />
			</head>

			<body>
 				<table align="center" width="500">
  					<tr>
   						<td align="center"><img src="images/acp-logo.gif" border="0" alt="" /></td>
  					</tr>
  					<tr>
   						<td><br /><br />' . $content . '</td>
  					</tr>
 				</table>
			</body>
		</html>';	
}

/** refresh an acp page **/
function stepdie()
{
	global $noerror;
	
	if ($noerror == 0) {
		echo "</textarea>
		</form></body></html>";
	}
}

/** refresh an acp page **/
function stepstart() {
 	register_shutdown_function("stepdie");
 
 	echo "<?xml version=\"1.0\" encoding=\"windows-1252\"?>
		<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html xmlns=\"http://www.w3.org/1999/xhtml\" dir=\"ltr\" lang=\"de\" xml:lang=\"de\">
			<head>
				<title></title>
				<link rel=\"stylesheet\" href=\"css/other.css\" />
				<script type=\"text/javascript\">
					<!--
						function showErrorMsg(errormsg) {
							if (errormsg != '') {
								errormsg = errormsg.replace(/<[^>]+>/g, '');
								if (window.clipboardData) window.clipboardData.setData('Text', errormsg);
								alert(errormsg + '\\n\\nDiese Fehlermeldung wurde in der Zwischenablage gespeichert und kann mit der Tastenkombination [STRG]+[V] eingefügt werden.');
							}
							else alert('Während der Aktion ist ein unbekannter Fehler aufgetreten.');
						}

						function checkForError() {
							if (!document.errorform || !document.errorform.noerror || !document.errorform.noerror.value || document.errorform.noerror.value != 'true') {
								if (!document.phperror || !document.phperror.phperror || !document.phperror.phperror.value) var errormsg = '';
								else var errormsg = document.phperror.phperror.value;
								
								if (!errormsg) {
									if (!document.errormsg || !document.errormsg.errormsg || !document.errormsg.errormsg.value) var errormsg = '';
									else var errormsg=document.errormsg.errormsg.value;
								}
								showErrorMsg(errormsg);
							}
							else {
								proceed();
							}
						}
					//-->
				</script>
			</head>
			<body onload=\"checkForError();\">
				<form name=\"phperror\" method=\"get\" action=\"#\">
					<textarea name=\"phperror\" rows=\"0\" cols=\"0\">";
}

function repeatstep($percent, $loop, $step1, $step2) {
 	global $mode, $noerror;
 
 	$noerror = 1;
 	echo '</textarea>
				</form>
				<script type="text/javascript">
					<!--
						parent.frames[0].location.href=\'setup.php?step='.$step1.'&mode='.$mode.'&frameset=1&percent='.$percent.'\';
						parent.frames[1].location.href=\'setup.php?step='.$step2.'&mode='.$mode.'&frameset=1&loop='.$loop.'\';
					//-->
				</script>
			</body>
		</html>';
}

function statusPage($text, $nextstep) {
 	global $_REQUEST, $mode, $frameset;
 
 	if (isset($_REQUEST['percent'])) $percent = $_REQUEST['percent'];
 	else $percent = 0;
 
 	if ($percent > 100) $percent = 100;
 
 	informationPage($text . ' ('.number_format($percent, 2).'%)<br />Diese Aktion kann einige Zeit dauern, brechen Sie den Vorgang bitte nicht ab.<br /><br /><a href="setup.php?step='.$nextstep.'&amp;mode='.$mode.'&amp;frameset='.$frameset.'">Falls l&auml;ngere Zeit kein Fortschritt zu erkennen ist, klicken Sie hier, um diesen Schritt zu &uuml;berspringen.</a>');	
}

class ConvertSize {
 var $index = array();
 var $hash = "";
 var $tempsave = array();

 function ConvertSize() {
  $this->hash = substr(md5(uniqid(microtime())),0,6);	
 }

 function convertSizeTag($text) {
  // cache code
  $this->tempsave['php'] = array();
  $this->tempsave['code'] = array();
  $this->index['php'] = -1;
  $this->index['code'] = -1;
  
  $text = preg_replace("/(\[(php|code)\])([^\\4\\1]*)(\[\/\\2\])/eiU","\$this->cachecode('\\3','\\2')",$text);
  
  // replace size tag
  $text = preg_replace("/\[size=([0-9])+\]/sie", "\$this->convertSizeTagHelp('\\1')", $text);
  
  // insert code
  if($this->index['php']!=-1 || $this->index['code']!=-1) $text = $this->replacecode($text);
  
  return $text;
 }

 function convertSizeTagHelp($size) {
  return "[size=" . ( 11 + ($size-1)*2 ) . "]";
 }
 
 function cachecode($code,$mode) {
  $mode=strtolower($mode);
  $this->index[$mode]++;
  $this->tempsave[$mode][$this->index[$mode]]=$code;
  return "{".$this->hash."_".$mode."_".$this->index[$mode]."}";
 }
 
 function replacecode($text) {
  reset($this->tempsave);
  while(list($mode,$val)=each($this->tempsave)) {
   while(list($varnr,$code)=each($val)) {
    $code =  str_replace("\\\\", "\\", $code);
    $code =  str_replace('\"', '"', $code);
    
    $text = str_replace("{".$this->hash."_".$mode."_".$varnr."}","[$mode]".$code."[/$mode]",$text);
   }
  }
  return $text;
 }
}



if (isset($_REQUEST['step'])) $step = $_REQUEST['step'];
else $step = 0;
if (isset($_REQUEST['frameset'])) $frameset = intval($_REQUEST['frameset']);
else $frameset = 0;
if (isset($_REQUEST['mode'])) $mode = intval($_REQUEST['mode']);
else $mode = 0;

if ($mode == 2) {
	require("./_data.inc.php");
	$m = $n;	
}


/* setup start page */
if ($step == 0) {
	informationPage('<b>Herzlich Willkommen bei der Einrichtung vom WoltLab Burning Board 2.3.2</b><br /><br />
	 <table>
	  <tr>
	   <td colspan="3">Systemvoraussetzungen:</td>
	  </tr>
	  <tr>
	   <td><u>Eigenschaft</u></td>
	   <td><u>erforderlich</u></td>
	   <td><u>vorhanden</u></td>
	  </tr>
	  <tr>
	   <td>PHP Version</td>
	   <td>4.0.3</td>
	   <td><span style="color: '.((version_compare($phpversion, "4.0.3") == -1) ? ('red') : ('green')).'">'.$phpversion.'</span></td>
	  </tr>
	  <tr>
	   <td>magic_quotes_sybase</td>
	   <td>deaktiviert</td>
	   <td><span style="color: '.((get_cfg_var("magic_quotes_sybase")) ? ('red') : ('green')).'">'.((get_cfg_var("magic_quotes_sybase")) ? ('aktiviert') : ('deaktiviert')).'</span></td>
	  </tr>  
	  <tr>
	   <td>upload_max_filesize</td>
	   <td>> 0</td>
	   <td><span style="color: '.((!get_cfg_var("upload_max_filesize")) ? ('red') : ('green')).'">'.get_cfg_var("upload_max_filesize").'</span></td>
	  </tr>
	  <tr>
	   <td>Schreibrechte im Verzeichnis "/acp/lib"</td>
	   <td>Ja</td>
	   <td><span style="color: '.((!is_writeable("./lib")) ? ('red') : ('green')).'">'.((is_writeable("./lib")) ? ('Ja') : ('Nein')).'</span></td>
	  </tr>
	  <tr>
	   <td>Schreibrechte im Verzeichnis "/acp/temp"</td>
	   <td>Ja</td>
	   <td><span style="color: '.((!is_writeable("./temp")) ? ('red') : ('green')).'">'.((is_writeable("./temp")) ? ('Ja') : ('Nein')).'</span></td>
	  </tr>
	  <tr>
	   <td>Schreibrechte im Verzeichnis "/images/avatars"</td>
	   <td>Ja</td>
	   <td><span style="color: '.((!is_writeable("./../images/avatars")) ? ('red') : ('green')).'">'.((is_writeable("./../images/avatars")) ? ('Ja') : ('Nein')).'</span></td>
	  </tr>
	  <tr>
	   <td>Schreibrechte im Verzeichnis "/attachments"</td>
	   <td>Ja</td>
	   <td><span style="color: '.((!is_writeable("./../attachments")) ? ('red') : ('green')).'">'.((is_writeable("./../attachments")) ? ('Ja') : ('Nein')).'</span></td>
	  </tr>
	  <tr>
	   <td>Schreibrechte im Verzeichnis "/cache/templates"</td>
	   <td>Ja</td>
	   <td><span style="color: '.((!is_writeable("./../cache/templates")) ? ('red') : ('green')).'">'.((is_writeable("./../cache/templates")) ? ('Ja') : ('Nein')).'</span></td>
	  </tr>
	  <tr>
	   <td>Schreibrechte im Verzeichnis "/cache/templates/acp"</td>
	   <td>Ja</td>
	   <td><span style="color: '.((!is_writeable("./../cache/templates/acp")) ? ('red') : ('green')).'">'.((is_writeable("./../cache/templates/acp")) ? ('Ja') : ('Nein')).'</span></td>
	  </tr>
	  <tr>
	   <td>Schreibrechte im Verzeichnis "/cache/language"</td>
	   <td>Ja</td>
	   <td><span style="color: '.((!is_writeable("./../cache/language")) ? ('red') : ('green')).'">'.((is_writeable("./../cache/language")) ? ('Ja') : ('Nein')).'</span></td>
	  </tr>
	  <tr>
	   <td>Schreibrechte f&uuml;r Datei "/acp/lib/options.inc.php"</td>
	   <td>Ja</td>
	   <td><span style="color: '.((!is_writeable("./lib/options.inc.php")) ? ('red') : ('green')).'">'.((is_writeable("./lib/options.inc.php")) ? ('Ja') : ('Nein')).'</span></td>
	  </tr>
	  <tr>
	   <td>Schreibrechte f&uuml;r Datei "/acp/lib/config.inc.php"</td>
	   <td>Ja</td>
	   <td><span style="color: '.((!is_writeable("./lib/config.inc.php")) ? ('red') : ('green')).'">'.((is_writeable("./lib/config.inc.php")) ? ('Ja') : ('Nein')).'</span></td>
	  </tr>
	 </table>
	 
	 <p><i>Sollten eine oder mehrere Voraussetzungen nicht erfüllt sein, kann ein einwandfreier Betrieb des Forum nicht gewährleistet werden.</i></p>
	   <form method="post" action="setup.php"><select name="mode">
	    <option value="0">Bitte wählen Sie die Einrichtungsart:</option>
	    <option value="1">Neuinstallation</option>
	    <option value="3">Umstellung von wBB 2.3.1</option>
	    <option value="4">Umstellung von wBB 2.2.0 oder höher</option>
	    <option value="5">Umstellung von wBBLite 1.0.0 oder höher</option>
	   </select> <input type="submit" value="Fortfahren" />
	   <input type="hidden" name="step" value="1" />
	   </form>
	 ');
}


/* check javascript and frameset support */
if ($step == 1) {
	if ($mode > 5 || $mode < 1) {
		header("Location: setup.php");
		exit;	
	}
	
	if ($frameset == 0) {
		informationPage('
		<script type="text/javascript">
		<!--
		document.location.href=\'setup.php?step=1&mode='.$mode.'&frameset=1\'; 
		//-->
		</script>
		<noscript>
		Javascript ist in Ihrem Browser leider nicht aktiviert.<br />
		Klicken sie bitte <a href="setup.php?step=2&amp;mode='.$mode.'">hier</a>, um ohne die Verwendung von Javascript mit der Installation fortzufahren.
		</noscript>');	
	}
	else {
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="de" xml:lang="de">
		<head>
		<title>Status der Installation</title>
		<link rel="stylesheet" href="css/other.css" />
		</head>
		
		<frameset cols="*,0"> 
		<frame name="main" src="setup.php?step=2&amp;mode='.$mode.'&amp;frameset=1" frameborder="0">
		<frame name="hidden" src="" noresize="noresize" frameborder="0" marginwidth="0" marginheight="0">
		
		<noframes>
		<body>Ihr Browser unterstützt leider keine Frames.<br />
		Klicken sie bitte <a href="setup.php?step=2&amp;mode='.$mode.'">hier</a>, um ohne Frames fortzufahren.
		</body>
		</noframes>
		</frameset>
		</html>';
	}	
}


/* step 2  */
if ($step == 2) {
	 if ($mode == 4) {
	 	header("Location: setup.php?step=180&mode=4&frameset=$frameset");
	 	exit;
	 }
	 
	 if ($mode == 3) {
	 	header("Location: setup.php?step=290&mode=3&frameset=$frameset");
	 	exit;
	 }
	 
	 if ($mode == 5) {
	 	header("Location: setup.php?step=82&mode=5&frameset=$frameset");
	 	exit;
	 }
	  
	 if (isset($_POST['send'])) {
		$fp = fopen("./lib/config.inc.php", "w+b");	
		fwrite($fp, "<?php
// Hostname oder IP des MySQL-Servers
\$sqlhost = \"".str_replace("\"", "\\\\\"", $_POST['sqlhost'])."\";
// Username und Passwort zum einloggen in den Datenbankserver
\$sqluser = \"".str_replace("\"", "\\\\\"", $_POST['sqluser'])."\";
\$sqlpassword = \"".str_replace("\"", "\\\\\"", $_POST['sqlpassword'])."\";
// Name der Datenbank
\$sqldb = \"".str_replace("\"", "\\\\\"", $_POST['sqldb'])."\";
// Nummer des Boards
\$n = \"".intval($_POST['n'])."\";
// Email des Admins
\$adminmail = \"".str_replace("\"", "\\\\\"", $_POST['adminmail'])."\";
?>");
		fclose($fp);
		header("Location: setup.php?step=3&mode=$mode&frameset=$frameset");
		exit();
	 }
	 else {
	 	require("./lib/config.inc.php");
	  
	 	if ($mode == 2 && $m == $n) $n += 1; 
	  
	  	informationPage('<b>Eingabe der Datenbankzugangsdaten</b><br /><br />
		  <form method="post" action="setup.php">
		   <table>
		    <tr>
		     <td>Adresse des Datenbankservers:</td>
		     <td><input type="text" name="sqlhost" value="'.$sqlhost.'" /></td>
		    </tr>
		    <tr>
		     <td>Datenbank-Benutzername:</td>
		     <td><input type="text" name="sqluser" value="'.$sqluser.'" /></td>
		    </tr>
		    <tr>
		     <td>Datenbank-Benutzerpasswort:</td>
		     <td><input type="text" name="sqlpassword" value="'.$sqlpassword.'" /></td>
		    </tr>
		    <tr>
		     <td>Datenbankname:</td>
		     <td><input type="text" name="sqldb" value="'.$sqldb.'" /></td>
		    </tr>
		    <tr>
		     <td>Nummer des Forums:</td>
		     <td><input type="text" name="n" value="'.$n.'" /></td>
		    </tr>
		    <tr>
		     <td>E-Mail des techn. Admins:</td>
		     <td><input type="text" name="adminmail" value="'.$adminmail.'" /></td>
		    </tr>
		   </table>
		   <p align="center"><input type="submit" value="Speichern" /> <input type="reset" value="Zur&uuml;cksetzen" /></p>
		   <input type="hidden" name="step" value="2" />
		   <input type="hidden" name="send" value="send" />
		   <input type="hidden" name="frameset" value="'.$frameset.'" />
		   <input type="hidden" name="mode" value="'.$mode.'" />
		   </form>
		   <a href="setup.php?step=3&amp;mode='.$mode.'&amp;frameset='.$frameset.'">Falls Sie bereits die Datei "config.inc.php" von Hand konfiguriert haben, k&ouml;nnen Sie diesen Schritt &uuml;berspringen.</a>
		  ');
	 }
}


if ($step == 3) {
	require("./lib/config.inc.php");
	$error = 0;
	$connid = @mysql_connect($sqlhost, $sqluser, $sqlpassword);	
	if (!$connid) $error = 1;
	else if (!@mysql_select_db($sqldb, $connid)) $error = 1;
	
	if ($error == 1) {
		informationPage('Es sind Fehler beim Verbinden mit dem Datenbankserver aufgetreten. Die von Ihnen angegebenen Datenbankzugriffsdaten sind wom&ouml;glich nicht korrekt.
		<br /><br /><b>'.mysql_error().'</b> 
		<br /><br /><a href="setup.php?step=2&amp;mode='.$mode.'&amp;frameset='.$frameset.'">Bitte kehren Sie auf die vorherige Seite zur&uuml;ck, und korrigieren Ihre Angaben noch einmal.</a>');	
	}
	else {
		informationPage('Es kann eine korrekte Verbindung zur Datenbank erstellt werden.
		<br /><br /><a href="setup.php?step=4&amp;mode='.$mode.'&amp;frameset='.$frameset.'">Klicken Sie hier, um mit der Installation fortzufahren.</a>');		
	}
}


if ($step == 4) {
	require("./lib/config.inc.php");
	require("./lib/class_db_mysql.php");
	$db = new db($sqlhost, $sqluser, $sqlpassword, $sqldb, $phpversion);
	
	$tables = array(
	"bb".$n."_access"
	, "bb".$n."_acpmenuitemgroups"
	, "bb".$n."_acpmenuitemgroupscount"
	, "bb".$n."_acpmenuitems"
	, "bb".$n."_acpmenuitemscount"
	, "bb".$n."_adminsessions"
	, "bb".$n."_announcements"
	, "bb".$n."_applications"
	, "bb".$n."_attachments"
	, "bb".$n."_avatars"
	, "bb".$n."_bbcodes"
	, "bb".$n."_boards"
	, "bb".$n."_boardvisit"
	, "bb".$n."_designelements"
	, "bb".$n."_designpacks"
	, "bb".$n."_events"
	, "bb".$n."_folders"
	, "bb".$n."_groupcombinations"
	, "bb".$n."_groupleaders"
	, "bb".$n."_groups"
	, "bb".$n."_groupvalues"
	, "bb".$n."_groupvariablegroups"
	, "bb".$n."_groupvariables"
	, "bb".$n."_icons"
	, "bb".$n."_languagecats"
	, "bb".$n."_languagepacks"
	, "bb".$n."_languages"
	, "bb".$n."_mailqueue"
	, "bb".$n."_mails"
	, "bb".$n."_moderators"
	, "bb".$n."_optiongroups"
	, "bb".$n."_options"
	, "bb".$n."_permissions"
	, "bb".$n."_polloptions"
	, "bb".$n."_polls"
	, "bb".$n."_posts"
	, "bb".$n."_postcache"
	, "bb".$n."_privatemessage"
	, "bb".$n."_privatemessagereceipts"
	, "bb".$n."_profilefields"
	, "bb".$n."_ranks"
	, "bb".$n."_searchs"
	, "bb".$n."_sessions"
	, "bb".$n."_smilies"
	, "bb".$n."_stats"
	, "bb".$n."_styles"
	, "bb".$n."_subscribeboards"
	, "bb".$n."_subscribethreads"
	, "bb".$n."_templatepacks"
	, "bb".$n."_templates"
	, "bb".$n."_threads"
	, "bb".$n."_threadvisit"
	, "bb".$n."_user2groups"
	, "bb".$n."_userfields"
	, "bb".$n."_users"
	, "bb".$n."_votes"
	, "bb".$n."_wordlist"
	, "bb".$n."_wordmatch");
	
	$c = 0;
	$result = mysql_list_tables($sqldb); 
	for ($i = 0; $i < $db->num_rows($result); $i++) { 
		if (in_array(mysql_tablename($result, $i), $tables)) {
			$c = 1;
			break;	
		} 
	}
	
	if ($c == 1) {
		informationPage('Es sind bereits Tabellen in der ausgew&auml;hlten Datenbank vorhanden, die von dieser Installation erstellt werden sollen. <b>Wenn Sie fortfahren werden die vorhandenen Tabellen samt Daten &uuml;berschrieben.</b>
		<br /><br /><a href="setup.php?step=5&amp;mode='.$mode.'&amp;frameset='.$frameset.'">Fortfahren und Tabellen &uuml;berschreiben</a>');
	}
	else {
		header("Location: setup.php?step=5&mode=$mode&frameset=$frameset");
		exit();	
	}
}


/* create database structure */
if ($step == 5) {
	require("./lib/config.inc.php");
	require("./lib/class_db_mysql.php");
	require("./lib/class_query.php");
	$db = new db($sqlhost, $sqluser, $sqlpassword, $sqldb, $phpversion);
	
	$fp = fopen("./lib/structure.sql", "rb");
	$query = fread($fp, filesize("./lib/structure.sql"));
	fclose($fp);
	if ($n != 1) $query = str_replace("bb1_", "bb".$n."_", $query); 
	$sql_query = new query($query);
	$sql_query->doquery();
	
	informationPage('Die Datenbankstruktur wurde erfolgreich erstellt.
	<br /><br /><a href="setup.php?step=6&amp;mode='.$mode.'&amp;frameset='.$frameset.'">Klicken Sie hier, um mit der Installation fortzufahren.</a>');
}


/* insert database data */
if ($step == 6) {
	require("./lib/config.inc.php");
	require("./lib/class_db_mysql.php");
	require("./lib/class_query.php");
	$db = new db($sqlhost, $sqluser, $sqlpassword, $sqldb, $phpversion);
	
	$fp = fopen("./lib/inserts.sql", "rb");
	$query = fread($fp, filesize("./lib/inserts.sql"));
	fclose($fp);
	if ($n != 1) $query = str_replace("bb1_", "bb".$n."_", $query); 
	$sql_query = new query($query);
	$sql_query->doquery();
	
	list($version) = $db->query_first("SELECT VERSION()");
	if ( preg_match("/^(3\.23)|(4\.)/", $version) ) $db->query("ALTER TABLE bb".$n."_sessions TYPE=HEAP", 0, 0, 0);
	
	
	informationPage('Das Einfügen der Datenbankinhalte wurde erfolgreich abgeschlosssen.
	<br /><br /><a href="setup.php?step=7&amp;mode='.$mode.'&amp;frameset='.$frameset.'">Klicken Sie hier, um mit der Installation fortzufahren.</a>');
} 


/* import style data */
if ($step == 7) {
	require("./lib/config.inc.php");
	require("./lib/class_db_mysql.php");
	$db = new db($sqlhost, $sqluser, $sqlpassword, $sqldb, $phpversion);
	
	$stylefile = "bb1.style";
	if (file_exists($stylefile)) {
		
		$fp = fopen($stylefile, "rb");
		$data = unserialize(base64_decode(str_replace("\n", "", fread($fp, filesize($stylefile)))));
		fclose($fp);
		
		if ($mode < 3) { 
			// designpack data
			$db->query("INSERT INTO bb".$n."_designpacks (designpackname) VALUES ('".addslashes($data['designpack']['designpackname'])."')");
			$designpackid = $db->insert_id();
			
			if (isset($data['designpack']['designelements']) && count($data['designpack']['designelements'])) {
				while (list(, $designelement) = each($data['designpack']['designelements'])) $db->unbuffered_query("INSERT INTO bb".$n."_designelements (designpackid, element, value) VALUES ('$designpackid', '".addslashes($designelement['element'])."', '".addslashes($designelement['value'])."')");
			}
		}
		
		// template data
		if (isset($data['templates']) && count($data['templates'])) {
			while (list(, $template) = each($data['templates'])) {
				$db->unbuffered_query("REPLACE INTO bb".$n."_templates (templatepackid, templatename, template) VALUES (0, '".addslashes($template['templatename'])."', '".addslashes($template['template'])."')", 1);
			}
		}
		
		if ($mode < 3) { 
			// create style
			$db->query("INSERT INTO bb".$n."_styles (styleid, stylename, designpackid) VALUES (0, '".$data['general']['stylename']."', '".$designpackid."')");
		}
		
		updateTemplateStructure();
		
		informationPage('Das Entpacken der Styledaten ist erfolgreich durchgef&uuml;hrt worden.
		<br /><br /><a href="setup.php?step=8&amp;mode='.$mode.'&amp;frameset='.$frameset.'">' . (($mode > 2) ? ('Klicken Sie hier, um mit dem Update fortzufahren.') : ('Klicken Sie hier, um mit der Installation fortzufahren.')) . '</a>');
	}	
	else {
	
		informationPage('Fehler: Style Datei konnte nicht gefunden werden. Bitte vergewissern Sie sich, dass sich die Datei "bb1.style" im Verzeichnis "acp" befindet.
		<br /><br /><a href="setup.php?step=7&amp;mode='.$mode.'&amp;frameset='.$frameset.'">Erneut versuchen</a>');
	}	
}


/* import lang pack */
if ($step == 8) {
	require("./lib/config.inc.php");
	require("./lib/class_db_mysql.php");
	$db = new db($sqlhost, $sqluser, $sqlpassword, $sqldb, $phpversion);
	
	$lngfile = "german.lng";
	if (file_exists($lngfile)) {
		$lngdata = readlngfile($lngfile, 1);
		
		if (count($lngdata['cats'])) {
			$where = '';
			foreach ($lngdata['cats'] as $cat) {
				$db->unbuffered_query("INSERT IGNORE INTO bb".$n."_languagecats (catname) VALUES ('".addslashes($cat)."')");
				$where .= ",'".addslashes($cat)."'";
			}
					
			$cats = array();
			$result = $db->query("SELECT catid,catname FROM bb".$n."_languagecats WHERE catname IN(".substr($where, 1).")");
			while ($row = $db->fetch_array($result)) $cats[$row['catname']] = $row['catid'];
		}
			
		if (count($lngdata['items'])) {
			
			$languagecode = $lngdata['languagecode'];
			$languagepackname = $lngdata['languagepackname'];
			
			if ($mode < 3) $db->query("INSERT INTO bb".$n."_languagepacks (languagepackid,languagepackname,languagecode) VALUES (0,'".addslashes($languagepackname)."','".addslashes($languagecode)."')");
					
			$insert_str = '';
			$rowCount = 0;
			foreach ($lngdata['items'] as $cat => $itemarray) {
				$showorder = 1;
				foreach ($itemarray as $itemname => $item) {
					if ($rowCount > 150 && $insert_str != '') {
						$db->unbuffered_query("REPLACE INTO bb".$n."_languages (languagepackid,catid,itemname,item,showorder) VALUES ".substr($insert_str, 1), 1);
						$rowCount = 0;
						$insert_str = '';
					}
					$insert_str .= ",(0,'".$cats[$cat]."', '".addslashes($itemname)."', '".addslashes($item)."', '".$showorder."')";
					$showorder++;
					$rowCount++;
				}
			}
			
			if ($insert_str) $db->unbuffered_query("REPLACE INTO bb".$n."_languages (languagepackid,catid,itemname,item,showorder) VALUES ".substr($insert_str, 1), 1);
			foreach ($cats as $catname => $catid) updateCache(0, $catid);
		}
		
		informationPage('Das Vorbereiten der Sprachdateien ist erfolgreich durchgef&uuml;hrt worden.
		<br /><br /><a href="setup.php?step=9&amp;mode='.$mode.'&amp;frameset='.$frameset.'">' . (($mode > 2) ? ('Klicken Sie hier, um mit dem Update fortzufahren.') : ('Klicken Sie hier, um mit der Installation fortzufahren.')) . '</a>');
	}
	else {
		informationPage('Fehler: Sprachdatei konnte nicht gefunden werden. Bitte vergewissern Sie sich, dass sich die Datei "german.lng" im Verzeichnis "acp" befindet.
		<br /><br /><a href="setup.php?step=8&amp;mode='.$mode.'&amp;frameset='.$frameset.'">Erneut versuchen</a>');	
	}
}


/* compile board templates */
if ($step == 9) {
	if ($frameset == 1) repeatstep(0, 0, 9.2, 9.1);
	else {
		header("Location: setup.php?step=9.1&mode=$mode");
		exit;	
	}	
}

if ($step == 9.1) {
	if (isset($_REQUEST['loop'])) $loop = intval($_REQUEST['loop']);
	else $loop = 0;
	$perloop = 10;
	
	require("./lib/config.inc.php");
	require("./lib/class_db_mysql.php");
	
	$db = new db($sqlhost, $sqluser, $sqlpassword, $sqldb, $phpversion);
	require("./lib/class_templateparser.php");
	
	list($totalcount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_templates");
	$result = $db->query("SELECT * FROM bb".$n."_templates ORDER BY templateid ASC", $perloop, $loop * $perloop);
	
	if ($db->num_rows($result) > 0) {
		if ($frameset == 1) stepstart();
		
		while ($row = $db->fetch_array($result)) {
			$tplparser = new TemplateParser();
			$row['template'] = $tplparser->parse($row['template']);
			
			$fp = fopen("./../cache/templates/".$row['templatepackid']."_".$row['templatename'].".php", "w+b");
			fwrite($fp, "<?php
/*
templatepackid: ".$row['templatepackid']."
templatename: ".$row['templatename']."
*/

\$this->templates['".$row['templatename']."']=\"".addcslashes($row['template'], "$\"\\")."\";
?>");
			fclose($fp);
			@chmod("./../cache/templates/".$row['templatepackid']."_".$row['templatename'].".php", 0666);
			
			unset($row);
			unset($tplparser);
		}
		$loop++;
		
		if ($frameset == 1) repeatstep((($loop * $perloop) / $totalcount) * 100, $loop, 9.2, 9.1);
		else {
			header("Location: setup.php?step=9.1&loop=$loop&mode=$mode");
			exit;
		}
	}
	else {
		$db->unbuffered_query("UPDATE bb".$n."_templates SET recompile = 0", 1);
		if ($frameset == 1) {
			informationPage('<script type="text/javascript">
			<!--
			parent.frames[0].location.href=\'setup.php?step=9.3&mode='.$mode.'&frameset=1\';
			//-->
			</script>');
		}
		else {
			header("Location: setup.php?step=9.3&mode=$mode");
			exit;
		}
	}	
}

/* status page */
if ($step == 9.2) {
	statusPage("Vorbereiten der Templates läuft...", "10");
}


/* end page */
if ($step == 9.3) {
	informationPage('Das Vorbereiten der Templates ist erfolgreich durchgef&uuml;hrt worden.
	 <br /><br /><a href="setup.php?step=10&amp;mode='.$mode.'&amp;frameset='.$frameset.'">' . (($mode > 2) ? ('Klicken Sie hier, um mit dem Update fortzufahren.') : ('Klicken Sie hier, um mit der Installation fortzufahren.')) . '</a>');
}


/* compile acp templates */
if ($step == 10) {
	if ($frameset == 1) repeatstep(0, 0, 10.2, 10.1);
	else {
		header("Location: setup.php?step=10.1&mode=$mode");
		exit;	
	}	
}

if ($step == 10.1) {
	if (isset($_REQUEST['loop'])) $loop = intval($_REQUEST['loop']);
	else $loop = 0;
	$perloop = 10;
	
	require("./lib/class_templateparser.php");
	
	$acp_templates = array();
	$handle = @opendir("./templates");
	while ($file = readdir($handle)) {
		if ($file == ".." || $file == ".") continue;
		$acp_templates[] = substr($file, 0, - 1 * strlen(strrchr($file, ".")));
	}
	
	sort($acp_templates);
	$totalcount = count($acp_templates);
	
	if ($totalcount >= $loop * $perloop) {
		if ($frameset == 1) stepstart();
		
		for ($i = $loop * $perloop; $i < (($loop + 1) * $perloop) && $i < $totalcount; $i++) {
			
			$tplparser = new TemplateParser();
			$filename = "./templates/" . $acp_templates[$i] . ".htm";
			$fp = fopen($filename, "rb");
			$template = $tplparser->parse(fread($fp, filesize($filename)));
			fclose($fp);
			
			$fp = fopen("./../cache/templates/acp/".$acp_templates[$i].".php", "w+b");
			fwrite($fp, "<?php
/*
acp template
templatename: ".$acp_templates[$i]."
*/

\$this->templates['acp_".$acp_templates[$i]."']=\"".addcslashes($template, "$\"\\")."\";
?>");
			fclose($fp);
			@chmod("./../cache/templates/acp/".$acp_templates[$i].".php", 0666);
			
			unset($template);
			unset($tplparser);
		}
		$loop++;
		
		if ($frameset == 1) repeatstep((($loop * $perloop) / $totalcount) * 100, $loop, 10.2, 10.1);
		else {
			header("Location: setup.php?step=10.1&loop=$loop&mode=$mode");
			exit;
		}
	}
	else {
		if ($frameset == 1) {
			informationPage('<script type="text/javascript">
			<!--
			parent.frames[0].location.href=\'setup.php?step=10.3&mode='.$mode.'&frameset=1\';
			//-->
			</script>');
		}
		else {
			header("Location: setup.php?step=10.3&mode=$mode");
			exit;
		}
	}
}

/* status page */
if ($step == 10.2) {
	statusPage("Vorbereiten der ACP-Templates läuft...", "10.3");
}

/* end page */
if ($step == 10.3) {
	if ($mode == 1) {
		$nextstep = 11;
	}
	
	if ($mode == 2) {
		$nextstep = 20;
	}
	
	if ($mode == 3) {
		$nextstep = 291;
	}
	
	if ($mode == 4) {
		$nextstep = 181;
	}
	
	informationPage('Das Vorbereiten der ACP-Templates ist erfolgreich durchgef&uuml;hrt worden.
	<br /><br /><a href="setup.php?step='.$nextstep.'&amp;mode='.$mode.'&amp;frameset='.$frameset.'">' . (($mode > 2) ? ('Klicken Sie hier, um mit dem Update fortzufahren.') : ('Klicken Sie hier, um mit der Installation fortzufahren.')) . '</a>');
}


/* register admin */
if ($step == 11) {
	if (isset($_POST['send'])) {
		$username = trim($_REQUEST['username']);
		$email = trim($_REQUEST['email']);
		$password = trim($_REQUEST['password']);
		
		if ($username && $email && $password) {
			require("./lib/config.inc.php");
			require("./lib/class_db_mysql.php");
			$db = new db($sqlhost, $sqluser, $sqlpassword, $sqldb, $phpversion);
			
			$db->query("INSERT INTO bb".$n."_users (username,password,sha1_password,email,groupcombinationid,rankid,regdate,lastvisit,lastactivity,activation,timezoneoffset,rankgroupid,useronlinegroupid) VALUES ".
			"('".addslashes($username)."','".md5($password)."','".sha1($password)."','".addslashes($email)."','11','1','".time()."','".time()."','".time()."','1','1','1','1')");
			$userid = $db->insert_id();
			$db->query("INSERT INTO bb".$n."_userfields (userid) VALUES ('$userid')");
			$db->query("INSERT INTO bb".$n."_user2groups (userid,groupid) VALUES ('$userid','1'),('$userid','4')");
			
			header("Location: setup.php?step=12");
			exit();
		}	
	}	
	
	informationPage('<form method="post" action="setup.php">
	<b>Registrierung des Administrators</b><br />
	<table>
	<tr>
	<td>Benutzername:</td>
	<td><input type="text" name="username" value="'.$username.'" /></td>
	</tr>
	<tr>
	<td>Passwort:</td>
	<td><input type="text" name="password" value="'.$password.'" /></td>
	</tr>
	<tr>
	<td>E-Mail Adresse:</td>
	<td><input type="text" name="email" value="'.$email.'" /></td>
	</tr>
	</table>
	<p align="center"><input type="submit" value="Speichern" /> <input type="reset" value="Zur&uuml;cksetzen" /></p>
	<input type="hidden" name="step" value="11" />
	<input type="hidden" name="send" value="send" />
	</form>');
}


/* installation end */
if ($step == 12) {
	require("./lib/config.inc.php");
	require("./lib/class_db_mysql.php");
	require("./lib/class_options.php");
	$db = new db($sqlhost, $sqluser, $sqlpassword, $sqldb, $phpversion);
	
	// update groupcombinationdata
	$result = $db->query("SELECT groupids FROM bb".$n."_groupcombinations");
	while ($row = $db->fetch_array($result)) cachegroupcombinationdata($row['groupids']);
	
	// update install date 
	$db->query("UPDATE bb".$n."_options SET value='".time()."' WHERE varname='installdate'");
	$option = new options("lib");
	$option->write();
	
	$fp = @fopen("./lib/install.lock", "w+b");
	fclose($fp);
	
	informationPage('<b>Einrichtung ist erfolgreich abgeschlossen.</b> Sie k&ouml;nnen die Datei "setup.php" jetzt per FTP vom Server enfernen.
	<br /><br /><a href="index.php" target="_blank">Klicken Sie hier, um ins Admin Control Panel zu gelangen</a>');
}


/********* update from wbb Lite *********/
if($mode==5 && $step>=82 && $step<=102) {
 function rehtmlspecialchars($text) {
  $trans = get_html_translation_table(HTML_SPECIALCHARS);
  $trans = array_flip($trans);
  return strtr($text, $trans);
 }

 require("./lib/config.inc.php");
 require("./lib/class_db_mysql.php");
 $db = new db($sqlhost,$sqluser,$sqlpassword,$sqldb,$phpversion);

 if($step==82) {
  require("./lib/class_query.php");

  $fp = fopen("./lib/lite_update1.sql", "rb");
  $query=fread($fp, filesize("./lib/lite_update1.sql"));
  fclose($fp);
  if($n!=1) $query=str_replace("bb1_","bb".$n."_",$query);
  $sql_query = new query($query);
  $sql_query->doquery();

  informationPage('Die Datenbankstruktur wurde erfolgreich an Version 2.3 angepasst.
   <br /><br /><a href="setup.php?step=83&amp;mode='.$mode.'&amp;frameset='.$frameset.'">Klicken Sie hier, um mit dem Update fortzufahren.</a>');
 }

 if($step==83) {
  require("./lib/class_query.php");

  $fp = fopen("./lib/lite_update2.sql", "rb");
  $query=fread($fp, filesize("./lib/lite_update2.sql"));
  fclose($fp);
  if($n!=1) $query=str_replace("bb1_","bb".$n."_",$query);
  $sql_query = new query($query);
  $sql_query->doquery();

  informationPage('Datenbankinhalte von Version 2.3 wurden hinzugefügt.
   <br /><br /><a href="setup.php?step=84&amp;mode='.$mode.'&amp;frameset='.$frameset.'">Klicken Sie hier, um mit dem Update fortzufahren.</a>');
 }

 if($step==84) {
  $var_insert_sql = "";
  $group_insert_sql = "";

  $result = $db->query("SELECT * FROM bb".$n."_groups");
  while($row=$db->fetch_array($result)) {
   $vars = $db->query("SELECT * FROM bb".$n."_groupvariables");
   while($var=$db->fetch_array($vars)) {
    $value = "";

    switch($var['variablename']) {
     case "can_view_board": $value = $row['canviewboard']; break;
     case "can_view_off_board": $value = $row['canviewoffboard']; break;
     case "can_use_search": $value = $row['canusesearch']; break;
     case "can_use_pms": $value = $row['canusepms']; break;
     case "can_start_topic": $value = $row['canstarttopic']; break;
     case "can_reply_topic": $value = $row['canreplytopic']; break;
     case "can_post_without_moderation": $value = $row['canpostwithoutmoderation']; break;
     case "can_edit_own_post": $value = $row['caneditownpost']; break;
     case "can_del_own_post": $value = $row['candelownpost']; break;
     case "can_close_own_topic": $value = $row['cancloseowntopic']; break;
     case "can_del_own_topic": $value = $row['candelowntopic']; break;
     case "can_edit_own_topic": $value = $row['caneditowntopic']; break;
     case "can_post_poll": $value = $row['canpostpoll']; break;
     case "can_vote_poll": $value = $row['canvotepoll']; break;
     case "can_use_avatar": $value = $row['canuseavatar']; break;
     case "can_upload_avatar": $value = $row['canuploadavatar']; break;
     case "can_upload_attachments": $value = $row['canuploadattachments']; break;
     case "can_download_attachments": $value = $row['candownloadattachments']; break;
     case "can_rate_thread": $value = $row['canratethread']; break;
     case "can_view_mblist": $value = $row['canviewmblist']; break;
     case "can_view_profile": $value = $row['canviewprofile']; break;
     case "can_view_calendar": $value = $row['canviewcalender']; break;
     case "can_private_event": $value = $row['canprivateevent']; break;
     case "can_public_event": $value = $row['canpublicevent']; break;
     case "can_rate_users": $value = $row['canrateusers']; break;
     case "dont_append_editnote": $value = 1-$row['appendeditnote']; break;
     case "avoid_fc": $value = $row['avoidfc']; break;
     case "m_is_supermod": $value = $row['issupermod']; break;
     case "a_can_use_acp": $value = $row['canuseacp']; break;
     case "max_post_image": $value = $row['maxpostimage']; break;
     case "max_sig_image": $value = $row['maxsigimage']; break;
     case "max_sig_length": $value = $row['maxsiglength']; break;
     case "allowed_avatar_extensions": $value = $row['allowedavatarextensions']; break;
     case "max_avatar_width": $value = $row['maxavatarwidth']; break;
     case "max_avatar_height": $value = $row['maxavatarheight']; break;
     case "max_avatar_size": $value = $row['maxavatarsize']; break;
     case "allowed_attachment_extensions": $value = $row['allowedattachmentextensions']; break;
     case "max_attachment_size": $value = $row['maxattachmentsize']; break;
     case "max_usertext_length": $value = $row['maxusertextlength']; break;
     case "edit_posttime_limit": $value = -1; break;

     default:
      if($row['default_group']==2) {
       // default user
       switch($var['variablename']) {
       	case "can_enter_board": $value = 1; break;
       	case "can_read_thread": $value = 1; break;
       	case "can_view_wiw": $value = 1; break;
       	case "can_use_pn_bbcode": $value = 1; break;
       	case "can_use_pn_smilies": $value = 1; break;
       	case "can_use_pn_icons": $value = 1; break;
       	case "can_use_sig_bbcode": $value = 1; break;
       	case "can_use_sig_smilies": $value = 1; break;
       	case "can_use_sig_images": $value = 1; break;
       	case "can_use_event_bbcode": $value = 1; break;
       	case "can_use_event_smilies": $value = 1; break;
       	case "can_use_event_images": $value = 1; break;
       	case "can_use_post_bbcode": $value = 1; break;
       	case "can_use_post_smilies": $value = 1; break;
       	case "can_use_post_icons": $value = 1; break;
       	case "can_use_post_images": $value = 1; break;
       	case "can_use_pn_images": $value = 1; break;
       	case "can_use_prefix": $value = 1; break;

       	default:  $value = 0;
       }
      }
      else if($row['default_group']==1) {
       // guests
       switch($var['variablename']) {
       	case "can_enter_board": $value = 1; break;
       	case "can_read_thread": $value = 1; break;
       	case "can_view_wiw": $value = 1; break;
       	case "can_use_pn_bbcode": $value = 1; break;
       	case "can_use_pn_smilies": $value = 1; break;
       	case "can_use_pn_icons": $value = 1; break;
       	case "can_use_sig_bbcode": $value = 1; break;
       	case "can_use_sig_smilies": $value = 1; break;
       	case "can_use_sig_images": $value = 1; break;
       	case "can_use_event_bbcode": $value = 1; break;
       	case "can_use_event_smilies": $value = 1; break;
       	case "can_use_event_images": $value = 1; break;
       	case "can_use_post_bbcode": $value = 1; break;
       	case "can_use_post_smilies": $value = 1; break;
       	case "can_use_post_icons": $value = 1; break;
       	case "can_use_post_images": $value = 1; break;
       	case "can_use_pn_images": $value = 1; break;
       	case "can_use_prefix": $value = 1; break;

       	default:  $value = 0;
       }
      }
      else if($row['canuseacp']==1) {
       // admin
       switch($var['variablename']) {
       	case "can_use_pn_html": $value = 0; break;
       	case "can_use_sig_html": $value = 0; break;
       	case "can_use_event_html": $value = 0; break;
       	case "can_use_post_html": $value = 0; break;
       	case "a_override_max_securitylevel": $value = -1; break;

       	default:  $value = 1;
       }
      }
      else if($row['issupermod']==1) {
       // supermod
       switch($var['variablename']) {
       	case "can_select_rankgroup": $value = 1; break;
       	case "can_select_useronlinegroup": $value = 1; break;
       	case "m_can_thread_close": $value = 1; break;
       	case "m_can_thread_move": $value = 1; break;
       	case "m_can_thread_edit": $value = 1; break;
       	case "m_can_post_del": $value = 1; break;
       	case "m_can_thread_del": $value = 1; break;
       	case "m_can_thread_merge": $value = 1; break;
       	case "m_can_thread_cut": $value = 1; break;
       	case "m_can_thread_top": $value = 1; break;
       	case "m_can_add_poll": $value = 1; break;
       	case "m_can_post_edit": $value = 1; break;
       	case "m_can_announce": $value = 1; break;
       	case "m_can_edit_poll": $value = 1; break;
       	case "can_enter_board": $value = 1; break;
       	case "can_read_thread": $value = 1; break;
       	case "can_move_own_topic": $value = 1; break;
       	case "m_can_close_reply": $value = 1; break;
       	case "can_view_wiw": $value = 1; break;
       	case "can_edit_public_event": $value = 1; break;
       	case "can_use_pn_bbcode": $value = 1; break;
       	case "can_use_pn_smilies": $value = 1; break;
       	case "can_use_pn_icons": $value = 1; break;
       	case "can_use_sig_bbcode": $value = 1; break;
       	case "can_use_sig_smilies": $value = 1; break;
       	case "can_use_sig_images": $value = 1; break;
       	case "can_use_event_bbcode": $value = 1; break;
       	case "can_use_event_smilies": $value = 1; break;
       	case "can_use_event_images": $value = 1; break;
       	case "can_use_post_bbcode": $value = 1; break;
       	case "can_use_post_smilies": $value = 1; break;
       	case "can_use_post_icons": $value = 1; break;
       	case "can_use_post_images": $value = 1; break;
       	case "can_use_pn_images": $value = 1; break;
       	case "can_edit_title": $value = 1; break;
       	case "can_use_prefix": $value = 1; break;

       	default:  $value = 0;
       }
      }
      else if($row['ismod']==1) {
       // moderator
       switch($var['variablename']) {
       	case "can_select_rankgroup": $value = 1; break;
       	case "can_select_useronlinegroup": $value = 1; break;
       	case "m_can_thread_close": $value = 1; break;
       	case "m_can_thread_move": $value = 1; break;
       	case "m_can_thread_edit": $value = 1; break;
       	case "m_can_post_del": $value = 1; break;
       	case "m_can_thread_del": $value = 1; break;
       	case "m_can_thread_merge": $value = 1; break;
       	case "m_can_thread_cut": $value = 1; break;
       	case "m_can_thread_top": $value = 1; break;
       	case "m_can_add_poll": $value = 1; break;
       	case "m_can_post_edit": $value = 1; break;
       	case "m_can_announce": $value = 1; break;
       	case "m_can_edit_poll": $value = 1; break;
       	case "can_enter_board": $value = 1; break;
       	case "can_read_thread": $value = 1; break;
       	case "can_move_own_topic": $value = 1; break;
       	case "m_can_close_reply": $value = 1; break;
       	case "can_view_wiw": $value = 1; break;
       	case "can_edit_public_event": $value = 1; break;
       	case "can_use_pn_bbcode": $value = 1; break;
       	case "can_use_pn_smilies": $value = 1; break;
       	case "can_use_pn_icons": $value = 1; break;
       	case "can_use_sig_bbcode": $value = 1; break;
       	case "can_use_sig_smilies": $value = 1; break;
       	case "can_use_sig_images": $value = 1; break;
       	case "can_use_event_bbcode": $value = 1; break;
       	case "can_use_event_smilies": $value = 1; break;
       	case "can_use_event_images": $value = 1; break;
       	case "can_use_post_bbcode": $value = 1; break;
       	case "can_use_post_smilies": $value = 1; break;
       	case "can_use_post_icons": $value = 1; break;
       	case "can_use_post_images": $value = 1; break;
       	case "can_use_pn_images": $value = 1; break;
       	case "can_edit_title": $value = 1; break;
       	case "can_use_prefix": $value = 1; break;

       	default:  $value = 0;
       }
      }
      else {
       // other group
       switch($var['variablename']) {
       	case "can_enter_board": $value = 1; break;
       	case "can_read_thread": $value = 1; break;
       	case "can_view_wiw": $value = 1; break;
       	case "can_use_pn_bbcode": $value = 1; break;
       	case "can_use_pn_smilies": $value = 1; break;
       	case "can_use_pn_icons": $value = 1; break;
       	case "can_use_sig_bbcode": $value = 1; break;
       	case "can_use_sig_smilies": $value = 1; break;
       	case "can_use_sig_images": $value = 1; break;
       	case "can_use_event_bbcode": $value = 1; break;
       	case "can_use_event_smilies": $value = 1; break;
       	case "can_use_event_images": $value = 1; break;
       	case "can_use_post_bbcode": $value = 1; break;
       	case "can_use_post_smilies": $value = 1; break;
       	case "can_use_post_icons": $value = 1; break;
       	case "can_use_post_images": $value = 1; break;
       	case "can_use_pn_images": $value = 1; break;
       	case "can_use_prefix": $value = 1; break;

       	default:  $value = 0;
       }
      }
    }

    if($var_insert_sql=="") $var_insert_sql = "('".$row['groupid']."','".$var['variableid']."','".addslashes($value)."')";
    else $var_insert_sql .= ",('".$row['groupid']."','".$var['variableid']."','".addslashes($value)."')";

   }

   $grouptype=7;
   $useronlinemarking="%s";
   $securitylevel=1;
   $showonteam=0;

   if($row['default_group']==2) {
    // default user
    $grouptype=4;
   }
   else if($row['default_group']==1) {
    // guests
    $grouptype=1;
   }
   else if($row['canuseacp']==1) {
    // admin
    $useronlinemarking="<b><i>%s</i></b>";
    $securitylevel=4;
    $showonteam=1;
   }
   else if($row['issupermod']==1) {
    // supermod
    $useronlinemarking="<b>%s</b>";
    $securitylevel=2;
    $showonteam=1;
   }
   else if($row['ismod']==1) {
    // moderator
    $useronlinemarking="<b>%s</b>";
    $securitylevel=2;
    $showonteam=1;
   }

   if($group_insert_sql=="") $group_insert_sql = "('".$row['groupid']."','".addslashes($row['title'])."','".$grouptype."','".$useronlinemarking."','".$securitylevel."','".$showonteam."')";
    else $group_insert_sql .= ",('".$row['groupid']."','".addslashes($row['title'])."','".$grouptype."','".$useronlinemarking."','".$securitylevel."','".$showonteam."')";
  }

  $db->query("DELETE FROM bb".$n."_groups");
  $db->query("ALTER TABLE bb".$n."_groups
    ADD grouptype tinyint(1) NOT NULL DEFAULT '0' AFTER title,
    ADD useronlinemarking varchar(255) NOT NULL DEFAULT '%s' AFTER grouptype,
    ADD priority tinyint(1) NOT NULL DEFAULT '0' AFTER useronlinemarking,
    ADD securitylevel smallint(5) unsigned NOT NULL DEFAULT '0' AFTER priority,
    ADD ai_posts smallint(5) NOT NULL DEFAULT '-1' AFTER securitylevel,
    ADD ai_days smallint(5) NOT NULL DEFAULT '-1' AFTER ai_posts,
    ADD showonteam tinyint(1) NOT NULL DEFAULT '0' AFTER ai_days,
    ADD showorder smallint(5) NOT NULL DEFAULT '0' AFTER showonteam,
    MODIFY title varchar(50) NOT NULL DEFAULT '',
    DROP canviewboard,
    DROP canviewoffboard,
    DROP canusesearch,
    DROP canusepms,
    DROP canstarttopic,
    DROP canreplyowntopic,
    DROP canreplytopic,
    DROP canpostwithoutmoderation,
    DROP caneditownpost,
    DROP candelownpost,
    DROP cancloseowntopic,
    DROP candelowntopic,
    DROP caneditowntopic,
    DROP canpostpoll,
    DROP canvotepoll,
    DROP canuseavatar,
    DROP canuploadavatar,
    DROP canuploadattachments,
    DROP candownloadattachments,
    DROP canratethread,
    DROP canviewmblist,
    DROP canviewprofile,
    DROP canviewcalender,
    DROP canprivateevent,
    DROP canpublicevent,
    DROP canrateusers,
    DROP appendeditnote,
    DROP avoidfc,
    DROP ismod,
    DROP issupermod,
    DROP canuseacp,
    DROP maxpostimage,
    DROP maxsigimage,
    DROP maxsiglength,
    DROP allowedavatarextensions,
    DROP maxavatarwidth,
    DROP maxavatarheight,
    DROP maxavatarsize,
    DROP allowedattachmentextensions,
    DROP maxattachmentsize,
    DROP maxusertextlength,
    DROP default_group,
    DROP INDEX default_group;");


  if($var_insert_sql!="") $db->query("INSERT INTO bb".$n."_groupvalues (groupid,variableid,value) VALUES " . $var_insert_sql);
  if($group_insert_sql!="") $db->query("INSERT INTO bb".$n."_groups (groupid,title,grouptype,useronlinemarking,securitylevel,showonteam) VALUES " . $group_insert_sql);

  list($groupid) = $db->query_first("SELECT MAX(groupid) FROM bb".$n."_groups");

  $groupid_2 = $groupid + 1;
  $groupid_3 = $groupid + 2;

  $db->query("INSERT INTO bb".$n."_groups (groupid, title, grouptype, useronlinemarking, priority, securitylevel, ai_posts, ai_days, showonteam, showorder) VALUES (".$groupid_2.", 'Standardgruppe für nicht aktivierte User', 2, '%s', 1, 1, -1, -1, 0, 0)");
  $db->query("INSERT INTO bb".$n."_groups (groupid, title, grouptype, useronlinemarking, priority, securitylevel, ai_posts, ai_days, showonteam, showorder) VALUES (".$groupid_3.", 'Standardgruppe für gesperrte User', 3, '%s', 2, 1, -1, -1, 0, 0)");

  require("./lib/class_query.php");

  $fp = fopen("./lib/lite_update4.sql", "rb");
  $query=fread($fp, filesize("./lib/lite_update4.sql"));
  fclose($fp);
  if($n!=1) $query=str_replace("bb1_","bb".$n."_",$query);
  $query=str_replace("groupid_2",$groupid_2,$query);
  $query=str_replace("groupid_3",$groupid_3,$query);

  $sql_query = new query($query);
  $sql_query->doquery();

  informationPage('Konvertierung der Benutzergruppen ist abgeschlossen.
   <br /><br /><a href="setup.php?step=85&amp;mode='.$mode.'&amp;frameset='.$frameset.'">Klicken Sie hier, um mit dem Update fortzufahren.</a>');
 }

 if($step==85) {
  $perm_insert_sql="";

  $result = $db->query("SELECT * FROM bb".$n."_permissions");
  while($row=$db->fetch_array($result)) {
   $temp = "('$row[boardid]','$row[groupid]','$row[boardpermission]','$row[boardpermission]','$row[boardpermission]','$row[startpermission]','$row[replypermission]')";
   if($perm_insert_sql=="") $perm_insert_sql=$temp;
   else $perm_insert_sql .= "," . $temp;
  }

  $db->query("DELETE FROM bb".$n."_permissions");
  $db->query("ALTER TABLE bb".$n."_permissions
    ADD can_view_board tinyint(1) NOT NULL DEFAULT '-1' AFTER groupid,
    ADD can_enter_board tinyint(1) NOT NULL DEFAULT '-1' AFTER can_view_board,
    ADD can_read_thread tinyint(1) NOT NULL DEFAULT '-1' AFTER can_enter_board,
    ADD can_start_topic tinyint(1) NOT NULL DEFAULT '-1' AFTER can_read_thread,
    ADD can_reply_topic tinyint(1) NOT NULL DEFAULT '-1' AFTER can_start_topic,
    ADD can_post_poll tinyint(1) NOT NULL DEFAULT '-1' AFTER can_reply_topic,
    ADD can_upload_attachments tinyint(1) NOT NULL DEFAULT '-1' AFTER can_post_poll,
    ADD can_download_attachments tinyint(1) NOT NULL DEFAULT '-1' AFTER can_upload_attachments,
    ADD can_post_without_moderation tinyint(1) NOT NULL DEFAULT '-1' AFTER can_download_attachments,
    ADD can_close_own_topic tinyint(1) NOT NULL DEFAULT '-1' AFTER can_post_without_moderation,
    ADD can_use_search tinyint(1) NOT NULL DEFAULT '-1' AFTER can_close_own_topic,
    ADD can_vote_poll tinyint(1) NOT NULL DEFAULT '-1' AFTER can_use_search,
    ADD can_rate_thread tinyint(1) NOT NULL DEFAULT '-1' AFTER can_vote_poll,
    ADD can_del_own_post tinyint(1) NOT NULL DEFAULT '-1' AFTER can_rate_thread,
    ADD can_edit_own_post tinyint(1) NOT NULL DEFAULT '-1' AFTER can_del_own_post,
    ADD can_del_own_topic tinyint(1) NOT NULL DEFAULT '-1' AFTER can_edit_own_post,
    ADD can_edit_own_topic tinyint(1) NOT NULL DEFAULT '-1' AFTER can_del_own_topic,
    ADD can_move_own_topic tinyint(1) NOT NULL DEFAULT '-1' AFTER can_edit_own_topic,
    ADD can_use_post_html tinyint(1) NOT NULL DEFAULT '-1' AFTER can_move_own_topic,
    ADD can_use_post_bbcode tinyint(1) NOT NULL DEFAULT '-1' AFTER can_use_post_html,
    ADD can_use_post_smilies tinyint(1) NOT NULL DEFAULT '-1' AFTER can_use_post_bbcode,
    ADD can_use_post_icons tinyint(1) NOT NULL DEFAULT '-1' AFTER can_use_post_smilies,
    ADD can_use_post_images tinyint(1) NOT NULL DEFAULT '-1' AFTER can_use_post_icons,
    ADD can_use_prefix tinyint(1) NOT NULL DEFAULT '-1' AFTER can_use_post_images,
    DROP boardpermission,
    DROP startpermission,
    DROP replypermission;");

  if($perm_insert_sql!="") $db->query("INSERT INTO bb".$n."_permissions (boardid,groupid,can_view_board,can_enter_board,can_read_thread,can_start_topic,can_reply_topic) VALUES " . $perm_insert_sql);

  informationPage('Konvertierung der Zugriffsrechte ist abgeschlossen.
   <br /><br /><a href="setup.php?step=86&amp;mode='.$mode.'&amp;frameset='.$frameset.'">Klicken Sie hier, um mit dem Update fortzufahren.</a>');

 }


 if($step==86) {
  $access_insert_sql="";

  $result = $db->query("SELECT * FROM bb".$n."_access");
  while($row=$db->fetch_array($result)) {
   $temp = "('$row[boardid]','$row[userid]','$row[boardpermission]','$row[boardpermission]','$row[boardpermission]','$row[startpermission]','$row[replypermission]')";
   if($access_insert_sql=="") $access_insert_sql=$temp;
   else $access_insert_sql .= "," . $temp;
  }

  $db->query("DELETE FROM bb".$n."_access");
  $db->query("ALTER TABLE bb".$n."_access
    ADD can_view_board tinyint(1) NOT NULL DEFAULT '-1' AFTER userid,
    ADD can_enter_board tinyint(1) NOT NULL DEFAULT '-1' AFTER can_view_board,
    ADD can_read_thread tinyint(1) NOT NULL DEFAULT '-1' AFTER can_enter_board,
    ADD can_start_topic tinyint(1) NOT NULL DEFAULT '-1' AFTER can_read_thread,
    ADD can_reply_topic tinyint(1) NOT NULL DEFAULT '-1' AFTER can_start_topic,
    ADD can_post_poll tinyint(1) NOT NULL DEFAULT '-1' AFTER can_reply_topic,
    ADD can_upload_attachments tinyint(1) NOT NULL DEFAULT '-1' AFTER can_post_poll,
    ADD can_download_attachments tinyint(1) NOT NULL DEFAULT '-1' AFTER can_upload_attachments,
    ADD can_post_without_moderation tinyint(1) NOT NULL DEFAULT '-1' AFTER can_download_attachments,
    ADD can_close_own_topic tinyint(1) NOT NULL DEFAULT '-1' AFTER can_post_without_moderation,
    ADD can_use_search tinyint(1) NOT NULL DEFAULT '-1' AFTER can_close_own_topic,
    ADD can_vote_poll tinyint(1) NOT NULL DEFAULT '-1' AFTER can_use_search,
    ADD can_rate_thread tinyint(1) NOT NULL DEFAULT '-1' AFTER can_vote_poll,
    ADD can_del_own_post tinyint(1) NOT NULL DEFAULT '-1' AFTER can_rate_thread,
    ADD can_edit_own_post tinyint(1) NOT NULL DEFAULT '-1' AFTER can_del_own_post,
    ADD can_del_own_topic tinyint(1) NOT NULL DEFAULT '-1' AFTER can_edit_own_post,
    ADD can_edit_own_topic tinyint(1) NOT NULL DEFAULT '-1' AFTER can_del_own_topic,
    ADD can_move_own_topic tinyint(1) NOT NULL DEFAULT '-1' AFTER can_edit_own_topic,
    ADD can_use_post_html tinyint(1) NOT NULL DEFAULT '-1' AFTER can_move_own_topic,
    ADD can_use_post_bbcode tinyint(1) NOT NULL DEFAULT '-1' AFTER can_use_post_html,
    ADD can_use_post_smilies tinyint(1) NOT NULL DEFAULT '-1' AFTER can_use_post_bbcode,
    ADD can_use_post_icons tinyint(1) NOT NULL DEFAULT '-1' AFTER can_use_post_smilies,
    ADD can_use_post_images tinyint(1) NOT NULL DEFAULT '-1' AFTER can_use_post_icons,
    DROP boardpermission,
    DROP startpermission,
    DROP replypermission;");

  if($access_insert_sql!="") $db->query("INSERT INTO bb".$n."_access (boardid,userid,can_view_board,can_enter_board,can_read_thread,can_start_topic,can_reply_topic) VALUES " . $access_insert_sql);

  informationPage('Konvertierung der Einzelfreischaltungen ist abgeschlossen.
   <br /><br /><a href="setup.php?step=87&amp;mode='.$mode.'&amp;frameset='.$frameset.'">Klicken Sie hier, um mit dem Update fortzufahren.</a>');
 }


 if($step==87) {
  $db->query("ALTER TABLE bb".$n."_users
    ADD sha1_password varchar(40) NOT NULL DEFAULT '' AFTER password,
    ADD groupcombinationid int(11) unsigned NOT NULL DEFAULT '0' AFTER userposts,
    ADD disablesignature tinyint(1) NOT NULL DEFAULT '0' AFTER signature,
    ADD langid int(11) NOT NULL DEFAULT '0' AFTER styleid,
    ADD useuseraccess tinyint(1) NOT NULL DEFAULT '0' AFTER threadview,
    ADD isgroupleader tinyint(1) NOT NULL DEFAULT '0' AFTER useuseraccess,
    ADD rankgroupid int(11) NOT NULL DEFAULT '0' AFTER isgroupleader,
    ADD useronlinegroupid int(11) NOT NULL DEFAULT '0' AFTER rankgroupid,
    ADD allowsigsmilies tinyint(1) NOT NULL DEFAULT '1' AFTER useronlinegroupid,
    ADD allowsightml tinyint(1) NOT NULL DEFAULT '0' AFTER allowsigsmilies,
    ADD allowsigbbcode tinyint(1) NOT NULL DEFAULT '1' AFTER allowsightml,
    ADD allowsigimages tinyint(1) NOT NULL DEFAULT '1' AFTER allowsigbbcode,
    ADD emailonapplication tinyint(1) NOT NULL DEFAULT '0' AFTER allowsigimages,
    ADD acpmode tinyint(3) NOT NULL DEFAULT '1' AFTER emailonapplication,
    ADD acppersonalmenu tinyint(1) NOT NULL DEFAULT '0' AFTER acpmode,
    ADD acpmenumarkfirst tinyint(3) NOT NULL DEFAULT '0' AFTER acppersonalmenu,
    ADD acpmenuhidelast tinyint(3) NOT NULL DEFAULT '0' AFTER acpmenumarkfirst,
    ADD INDEX activation (activation),
    ADD INDEX groupcombinationid (groupcombinationid);");

  header("Location: setup.php?step=88&mode=$mode&frameset=$frameset");
  exit;
 }

 if($step==88) {
  if($frameset==1) repeatstep(0, 0, 88.2, 88.1);
  else {
   header("Location: setup.php?step=88.1&mode=$mode");
   exit;
  }
 }

 if($step==88.1) {
  if(isset($_REQUEST['loop'])) $loop=intval($_REQUEST['loop']);
  else $loop=0;
  $perloop=50;

  $result = $db->query("SELECT groupid, grouptype FROM bb".$n."_groups WHERE grouptype>1 AND grouptype<5");
  while($row = $db->fetch_array($result)) {
   switch($row['grouptype']) {
    case 2: $grouptype_2 = $row['groupid']; break;
    case 3: $grouptype_3 = $row['groupid']; break;
    case 4: $grouptype_4 = $row['groupid']; break;
   }
  }

  $profilefieldcache=array();
  $result = $db->query("SELECT profilefieldid FROM bb".$n."_profilefields");
  while($row=$db->fetch_array($result)) $profilefieldcache[]=$row['profilefieldid'];
  $j = count($profilefieldcache);

  list($totalcount)=$db->query_first("SELECT COUNT(*) FROM bb".$n."_users");
  $result = $db->query("SELECT uf.*, u.* FROM bb".$n."_users u LEFT JOIN bb".$n."_userfields uf USING (userid)",$perloop,$loop*$perloop);

  if($db->num_rows($result)>0) {
   if($frameset==1) stepstart();
   $c = new ConvertSize();

   while($row=$db->fetch_array($result)) {
    $groupids = array();
    $groupids[] = $grouptype_4;
    $insert_sql = "('".$row['userid']."','".$grouptype_4."')";

    if($row['groupid']!=$grouptype_4) {
     $insert_sql .= ",('".$row['userid']."','".$row['groupid']."')";
     $groupids[] = $row['groupid'];
    }

    if($row['activation']!=1) {
     $insert_sql .= ",('".$row['userid']."','".$grouptype_2."')";
     $groupids[] = $grouptype_2;
    }

    if($row['blocked']==1) {
     $insert_sql .= ",('".$row['userid']."','".$grouptype_3."')";
     $groupids[] = $grouptype_3;
    }

    sort($groupids);

    $db->query("INSERT IGNORE INTO bb".$n."_user2groups (userid,groupid) VALUES " . $insert_sql);
    $db->query("UPDATE bb".$n."_users SET username='".addslashes(rehtmlspecialchars($row['username']))."', email='".addslashes(rehtmlspecialchars($row['email']))."', groupcombinationid='".cachegroupcombinationdata(implode(",", $groupids),0)."', title='".addslashes(rehtmlspecialchars($row['title']))."', aim='".addslashes(rehtmlspecialchars($row['aim']))."', yim='".addslashes(rehtmlspecialchars($row['yim']))."', msn='".addslashes(rehtmlspecialchars($row['msn']))."', birthday='".addslashes(rehtmlspecialchars($row['birthday']))."', rankgroupid='".$row['groupid']."', useronlinegroupid='".$row['groupid']."', signature='".addslashes($c->convertSizeTag($row['signature']))."' WHERE userid='".$row['userid']."'");

    $userfields_update = "";
    for($i=0;$i<$j;$i++) $userfields_update .= (($userfields_update!="") ? (" ,") : ("")) . "field".$profilefieldcache[$i]."='".addslashes(rehtmlspecialchars($row['field'.$profilefieldcache[$i]]))."'";
    if($userfields_update!="") $db->query("UPDATE bb".$n."_userfields SET ".$userfields_update." WHERE userid='".$row['userid']."'");
   }
   $loop++;

   if($frameset==1) repeatstep((($loop*$perloop)/$totalcount)*100, $loop, 88.2, 88.1);
   else {
    header("Location: setup.php?step=88.1&loop=$loop&mode=$mode");
    exit;
   }
  }
  else {
   if($frameset==1) {
    informationPage('<script type="text/javascript">
<!--
parent.frames[0].location.href=\'setup.php?step=88.3&mode='.$mode.'&frameset=1\';
//-->
</script>');
   }
   else {
    header("Location: setup.php?step=88.3&mode=$mode");
    exit;
   }
  }
 }

 if($step==88.2) statusPage("Das Aktualisieren der Benutzer läuft...", "88");


 if($step==88.3) {
  // rebuild guest usergroup
  cachegroupcombinationdata(5, 0);

 	
 	informationPage('Das Aktualisieren der Benutzer ist erfolgreich durchgef&uuml;hrt worden.
   <br /><br /><a href="setup.php?step=89&amp;mode='.$mode.'&amp;frameset='.$frameset.'">Klicken Sie hier, um mit dem Update fortzufahren.</a>');
 }

 if($step==89) {
  $db->query("ALTER TABLE bb".$n."_users
    DROP groupid,
    DROP INDEX groupid;");

  header("Location: setup.php?step=90&mode=$mode&frameset=$frameset");
  exit;
 }

 /* convert events */
 if($step==90) {
  if($frameset==1) repeatstep(0, 0, 90.2, 90.1);
  else {
   header("Location: setup.php?step=90.1&mode=$mode");
   exit;
  }
 }

 if($step==90.1) {
  if(isset($_REQUEST['loop'])) $loop=intval($_REQUEST['loop']);
  else $loop=0;
  $perloop=500;

  list($totalcount)=$db->query_first("SELECT COUNT(*) FROM bb".$n."_events");
  $result = $db->query("SELECT * FROM bb".$n."_events",$perloop,$loop*$perloop);

  if($db->num_rows($result)>0) {
   if($frameset==1) stepstart();

   while($row=$db->fetch_array($result)) {
    $db->query("UPDATE bb".$n."_events SET subject='".addslashes(rehtmlspecialchars($row['subject']))."' WHERE eventid='".$row['eventid']."'");
   }
   $loop++;

   if($frameset==1) repeatstep((($loop*$perloop)/$totalcount)*100, $loop, 90.2, 90.1);
   else {
    header("Location: setup.php?step=90.1&loop=$loop&mode=$mode");
    exit;
   }
  }
  else {
   header("Location: setup.php?step=91&mode=$mode&frameset=$frameset");
   exit;
  }
 }

 if($step==90.2) statusPage("Datenkonvertierung läuft (Schritt 1)...", "91");

 /* convert pm-folders */
 if($step==91) {
  if($frameset==1) repeatstep(0, 0, 91.2, 91.1);
  else {
   header("Location: setup.php?step=91.1&mode=$mode");
   exit;
  }
 }

 if($step==91.1) {
  if(isset($_REQUEST['loop'])) $loop=intval($_REQUEST['loop']);
  else $loop=0;
  $perloop=500;

  list($totalcount)=$db->query_first("SELECT COUNT(*) FROM bb".$n."_folders");
  $result = $db->query("SELECT * FROM bb".$n."_folders",$perloop,$loop*$perloop);

  if($db->num_rows($result)>0) {
   if($frameset==1) stepstart();

   while($row=$db->fetch_array($result)) {
    $db->query("UPDATE bb".$n."_folders SET title='".addslashes(rehtmlspecialchars($row['title']))."' WHERE folderid='".$row['folderid']."'");
   }
   $loop++;

   if($frameset==1) repeatstep((($loop*$perloop)/$totalcount)*100, $loop, 91.2, 91.1);
   else {
    header("Location: setup.php?step=91.1&loop=$loop&mode=$mode");
    exit;
   }
  }
  else {
   header("Location: setup.php?step=92.1&mode=$mode&frameset=$frameset");
   exit;
  }
 }

 if($step==91.2) statusPage("Datenkonvertierung läuft (Schritt 2)...", "92");

 /* convert posts */
 if($step==92) {
  if($frameset==1) repeatstep(0, 0, 92.2, 92.1);
  else {
   header("Location: setup.php?step=92.1&mode=$mode");
   exit;
  }
 }

 if($step==92.1) {
  if(isset($_REQUEST['loop'])) $loop=intval($_REQUEST['loop']);
  else $loop=0;
  $perloop=250;

  list($totalcount)=$db->query_first("SELECT COUNT(*) FROM bb".$n."_posts");
  $result = $db->query("SELECT * FROM bb".$n."_posts",$perloop,$loop*$perloop);

  if($db->num_rows($result)>0) {
   if($frameset==1) stepstart();
   $c = new ConvertSize();

   while($row=$db->fetch_array($result)) {
    $db->query("UPDATE bb".$n."_posts SET username='".addslashes(rehtmlspecialchars($row['username']))."', posttopic='".addslashes(rehtmlspecialchars($row['posttopic']))."', editor='".addslashes(rehtmlspecialchars($row['editor']))."', message='".addslashes($c->convertSizeTag($row['message']))."' WHERE postid='".$row['postid']."'");
   }
   $loop++;

   if($frameset==1) repeatstep((($loop*$perloop)/$totalcount)*100, $loop, 92.2, 92.1);
   else {
    header("Location: setup.php?step=92.1&loop=$loop&mode=$mode");
    exit;
   }
  }
  else {
   header("Location: setup.php?step=93.1&mode=$mode&frameset=$frameset");
   exit;
  }
 }

 if($step==92.2) statusPage("Datenkonvertierung läuft (Schritt 3)...", "93");

 /* convert privmsg */
 if($step==93) {
  if($frameset==1) repeatstep(0, 0, 93.2, 93.1);
  else {
   header("Location: setup.php?step=93.1&mode=$mode");
   exit;
  }
 }

 if($step==93.1) {
  if(isset($_REQUEST['loop'])) $loop=intval($_REQUEST['loop']);
  else $loop=0;
  $perloop=250;

  list($totalcount)=$db->query_first("SELECT COUNT(*) FROM bb".$n."_privatemessage");
  $result = $db->query("SELECT * FROM bb".$n."_privatemessage",$perloop,$loop*$perloop);

  if($db->num_rows($result)>0) {
   if($frameset==1) stepstart();
   $c = new ConvertSize();

   while($row=$db->fetch_array($result)) {
    $db->query("UPDATE bb".$n."_privatemessage SET subject='".addslashes(rehtmlspecialchars($row['subject']))."', message='".addslashes($c->convertSizeTag($row['message']))."' WHERE privatemessageid='".$row['privatemessageid']."'");
   }
   $loop++;

   if($frameset==1) repeatstep((($loop*$perloop)/$totalcount)*100, $loop, 93.2, 93.1);
   else {
    header("Location: setup.php?step=93.1&loop=$loop&mode=$mode");
    exit;
   }
  }
  else {
   header("Location: setup.php?step=94.1&mode=$mode&frameset=$frameset");
   exit;
  }
 }

 if($step==93.2) statusPage("Datenkonvertierung läuft (Schritt 4)...", "94");

 /* convert threads */
 if($step==94) {
  if($frameset==1) repeatstep(0, 0, 94.2, 94.1);
  else {
   header("Location: setup.php?step=94.1&mode=$mode");
   exit;
  }
 }

 if($step==94.1) {
  if(isset($_REQUEST['loop'])) $loop=intval($_REQUEST['loop']);
  else $loop=0;
  $perloop=500;

  list($totalcount)=$db->query_first("SELECT COUNT(*) FROM bb".$n."_threads");
  $result = $db->query("SELECT * FROM bb".$n."_threads",$perloop,$loop*$perloop);

  if($db->num_rows($result)>0) {
   if($frameset==1) stepstart();

   while($row=$db->fetch_array($result)) {
    $db->query("UPDATE bb".$n."_threads SET prefix='".addslashes(rehtmlspecialchars($row['prefix']))."', topic='".addslashes(rehtmlspecialchars($row['topic']))."', starter='".addslashes(rehtmlspecialchars($row['starter']))."', lastposter='".addslashes(rehtmlspecialchars($row['lastposter']))."' WHERE threadid='".$row['threadid']."'");
   }
   $loop++;

   if($frameset==1) repeatstep((($loop*$perloop)/$totalcount)*100, $loop, 94.2, 94.1);
   else {
    header("Location: setup.php?step=94.1&loop=$loop&mode=$mode");
    exit;
   }
  }
  else {
   header("Location: setup.php?step=95.1&mode=$mode&frameset=$frameset");
   exit;
  }
 }

 if($step==94.2) statusPage("Datenkonvertierung läuft (Schritt 5)...", "95");


 /* convert boards */
 if($step==95) {
  if($frameset==1) repeatstep(0, 0, 95.2, 95.1);
  else {
   header("Location: setup.php?step=95.1&mode=$mode");
   exit;
  }
 }

 if($step==95.1) {
  if(isset($_REQUEST['loop'])) $loop=intval($_REQUEST['loop']);
  else $loop=0;
  $perloop=500;

  list($totalcount)=$db->query_first("SELECT COUNT(*) FROM bb".$n."_boards");
  $result = $db->query("SELECT * FROM bb".$n."_boards",$perloop,$loop*$perloop);

  if($db->num_rows($result)>0) {
   if($frameset==1) stepstart();

   while($row=$db->fetch_array($result)) {
    $db->query("UPDATE bb".$n."_boards SET lastposter='".addslashes(rehtmlspecialchars($row['lastposter']))."' WHERE boardid='".$row['boardid']."'");
   }
   $loop++;

   if($frameset==1) repeatstep((($loop*$perloop)/$totalcount)*100, $loop, 95.2, 95.1);
   else {
    header("Location: setup.php?step=95.1&loop=$loop&mode=$mode");
    exit;
   }
  }
  else {
   if($frameset==1) {
    informationPage('<script type="text/javascript">
<!--
parent.frames[0].location.href=\'setup.php?step=96&mode='.$mode.'&frameset=1\';
//-->
</script>');
   }
   else {
    header("Location: setup.php?step=96&mode=$mode&frameset=$frameset");
    exit;
   }
  }
 }

 if($step==95.2) statusPage("Datenkonvertierung läuft (Schritt 6)...", "96");


 /* convert style & delete tpls */
 if($step==96) {
  list($default_styleid) = $db->query_first("SELECT styleid FROM bb".$n."_styles WHERE default_style = 1");

  $db->query("UPDATE bb".$n."_styles SET styleid=0 WHERE styleid = '".$default_styleid."'");
  $db->query("UPDATE bb".$n."_styles SET designpackid=subvariablepackid, templatepackid=0");

  $db->query("ALTER TABLE bb".$n."_styles
    DROP subvariablepackid,
    DROP default_style;");

  $db->query("UPDATE bb".$n."_boards SET styleid=0 WHERE styleid = '".$default_styleid."'");
  $db->query("UPDATE bb".$n."_users SET styleid=0 WHERE styleid = '".$default_styleid."'");

  $db->query("DELETE FROM bb".$n."_templatepacks");
  $db->query("DELETE FROM bb".$n."_templates");

  header("Location: setup.php?step=97&mode=$mode&frameset=$frameset");
  exit;
 }

 /* convert designpack */
 if($step==97) {
  $insert_sql="";

  require("./lib/class_query.php");

  $fp = fopen("./lib/lite_update5.sql", "rb");
  $query=fread($fp, filesize("./lib/lite_update5.sql"));
  fclose($fp);
  if($n!=1) $query=str_replace("bb1_","bb".$n."_",$query);
  $total_query = "";

  $result = $db->query("SELECT * FROM bb".$n."_subvariablepacks");
  while($row=$db->fetch_array($result)) {
   $temp = "('".$row['subvariablepackid']."','".addslashes($row['subvariablepackname'])."')";
   if($insert_sql=="") $insert_sql = $temp;
   else $insert_sql .= "," . $temp;

   $total_query .= str_replace("{designpackid}", $row['subvariablepackid'], $query) ."\n";
  }

  if($total_query != "") {
   $sql_query = new query($total_query);
   $sql_query->doquery();
  }

  if($insert_sql!="") $db->query("INSERT IGNORE INTO bb".$n."_designpacks (designpackid,designpackname) VALUES " . $insert_sql);

  header("Location: setup.php?step=98&mode=$mode&frameset=$frameset");
  exit;
 }

 /* convert designpackelements */
 if($step==98) {
  $result = $db->query("SELECT * FROM bb".$n."_subvariables");
  while($row=$db->fetch_array($result)) {
   switch($row['variable']) {
    case "<body":
     preg_match("/<body bgcolor=\"([^\"]*)\" text=\"([^\"]*)\"(.*)/i",$row['substitute'],$match);
     $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($match[1])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'pagebgcolor'"); // pagebgcolor
     $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($match[2])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'fontcolor'"); // fontcolor
     break;

    case "{tableoutbordercolor}": // tableoutbordercolor
     $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($row['substitute'])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'tableoutbordercolor'");
     break;

    case "{tableinbordercolor}": // tableinbordercolor
     $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($row['substitute'])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'tableinbordercolor'");
     break;

    case "{tabletitlecolor}": // tabletitlebgcolor
     $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($row['substitute'])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'tabletitlebgcolor'");
     break;

    case "{tablecolora}": // tableabgcolor
     $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($row['substitute'])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'tableabgcolor'");
     break;

    case "{tablecolorb}": // tablebbgcolor
     $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($row['substitute'])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'tablebbgcolor'");
     break;

    case "{fontcolorsecond}": // tabletitlefontcolor
     $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($row['substitute'])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'tabletitlefontcolor'");
     break;

    case "{fontcolorthird}": // tablecatfontcolor
     $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($row['substitute'])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'tablecatfontcolor'");
     break;

    case "{tablecatcolor}": // tablecatbgcolor
     $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($row['substitute'])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'tablecatbgcolor'");
     break;

    case "{tableinwidth}": // tableinwidth
     $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($row['substitute'])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'tableinwidth'");
     break;

    case "{timecolor}": // timefontcolor
     $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($row['substitute'])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'timefontcolor'");
     break;

    case "{imagefolder}": // imagefolder
     $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($row['substitute'])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'imagefolder'");
     break;

    case "{inposttablecolor}": // inposttablebgcolor
     $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($row['substitute'])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'inposttablebgcolor'");
     break;

    case "{prefixcolor}": // prefixfontcolor
     $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($row['substitute'])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'prefixfontcolor'");
     break;

    case "{mainbgcolor}": // mainbgcolor
     $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($row['substitute'])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'mainbgcolor'");
     break;

    case "{tableoutwidth}": // tableoutwidth
     $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($row['substitute'])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'tableoutwidth'");
     break;

    case "{imageback}": // logobackground
     preg_match("/background=\"([^\"]*)\"/i",$row['substitute'],$match);
     $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($match[1])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'logobackground'");
     break;

    case "{imagelogo}": // logobackground
     preg_match("/<img src=\"([^\"]*)\"/i",$row['substitute'],$match);
     $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($match[1])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'logoimage'");
     break;

    case "<smallfont": // smallfontface
     preg_match("/<font face=\"([^\"]*)\" size=\"([^\"]*)\"(.*)/i",$row['substitute'],$match);
     $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($match[1])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'smallfontface'");
     break;

    case "<normalfont": // normalfontface
     preg_match("/<font face=\"([^\"]*)\" size=\"([^\"]*)\"(.*)/i",$row['substitute'],$match);
     $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($match[1])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'normalfontface'");
     break;

    case "{css}":

     if(preg_match("/#bg A:link, #bg A:visited, #bg A:active { COLOR: (.*); TEXT-DECORATION: (.*); }/iU",$row['substitute'],$match)) {
      if($match[1]!="") $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($match[1])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'pagelinkcolor'");
      if($match[2]!="") $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($match[2])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'pagelinkdeco'");
     }
     if(preg_match("/#bg A:hover { COLOR: (.*); TEXT-DECORATION: (.*); }/iU",$row['substitute'],$match)) {
      if($match[1]!="") $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($match[1])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'pagelinkhovercolor'");
      if($match[2]!="") $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($match[2])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'pagelinkhoverdeco'");
     }

     if(preg_match("/#tablea A:link, #tablea A:visited, #tablea A:active { COLOR: (.*); TEXT-DECORATION: (.*); }/iU",$row['substitute'],$match)) {
      if($match[1]!="") $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($match[1])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'tablealinkcolor'");
      if($match[2]!="") $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($match[2])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'tablealinkdeco'");
     }
     if(preg_match("/#tablea A:hover { COLOR: (.*); TEXT-DECORATION: (.*); }/iU",$row['substitute'],$match)) {
      if($match[1]!="") $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($match[1])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'tablealinkhovercolor'");
      if($match[2]!="") $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($match[2])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'tablealinkhoverdeco'");
     }

     if(preg_match("/#tableb A:link, #tableb A:visited, #tableb A:active { COLOR: (.*); TEXT-DECORATION: (.*); }/iU",$row['substitute'],$match)) {
      if($match[1]!="") $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($match[1])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'tableblinkcolor'");
      if($match[2]!="") $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($match[2])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'tableblinkdeco'");
     }
     if(preg_match("/#tableb A:hover { COLOR: (.*); TEXT-DECORATION: (.*); }/iU",$row['substitute'],$match)) {
      if($match[1]!="") $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($match[1])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'tableblinkhovercolor'");
      if($match[2]!="") $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($match[2])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'tableblinkhoverdeco'");
     }

     if(preg_match("/#tablecat A:link, #tablecat A:visited, #tablecat A:active { COLOR: (.*); TEXT-DECORATION: (.*); }/iU",$row['substitute'],$match)) {
      if($match[1]!="") $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($match[1])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'tablecatlinkcolor'");
      if($match[2]!="") $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($match[2])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'tablecatlinkdeco'");
     }
     if(preg_match("/#tablecat A:hover { COLOR: (.*); TEXT-DECORATION: (.*); }/iU",$row['substitute'],$match)) {
      if($match[1]!="") $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($match[1])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'tablecatlinkhovercolor'");
      if($match[2]!="") $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($match[2])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'tablecatlinkhoverdeco'");
     }

     if(preg_match("/#tabletitle A:link, #tabletitle A:visited, #tabletitle A:active { COLOR: (.*); TEXT-DECORATION: (.*); }/iU",$row['substitute'],$match)) {
      if($match[1]!="") $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($match[1])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'tabletitlelinkcolor'");
      if($match[2]!="") $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($match[2])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'tabletitlelinkdeco'");
     }
     if(preg_match("/#tabletitle A:hover { COLOR: (.*); TEXT-DECORATION: (.*); }/iU",$row['substitute'],$match)) {
      if($match[1]!="") $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($match[1])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'tabletitlelinkhovercolor'");
      if($match[2]!="") $db->query("UPDATE bb".$n."_designelements SET value = '".addslashes($match[2])."' WHERE designpackid='".$row['subvariablepackid']."' AND element = 'tabletitlelinkhoverdeco'");
     }

     break;
   }
  }

  $db->query("DROP TABLE bb".$n."_subvariablepacks;");
  $db->query("DROP TABLE bb".$n."_subvariables;");

  require("./lib/class_query.php");

  // update sql
  $fp = fopen("./lib/lite_updatex.sql", "rb");
  $query = fread($fp, filesize("./lib/lite_updatex.sql"));
  fclose($fp);
  if ($n != 1) $query = str_replace("bb1_", "bb".$n."_", $query); 
  $sql_query = new query($query);
  $sql_query->doquery();


  header("Location: setup.php?step=99&mode=$mode&frameset=$frameset");
  exit;
 }
 if($step==99) {
  list($threadcount)=$db->query_first("SELECT COUNT(*) FROM bb".$n."_threads WHERE closed<>3");
  list($postcount)=$db->query_first("SELECT COUNT(*) FROM bb".$n."_posts");
  $user=$db->query_first("SELECT COUNT(*) AS usercount, MAX(userid) AS userid FROM bb".$n."_users");

  $db->unbuffered_query("UPDATE bb".$n."_stats SET threadcount='".$threadcount."', postcount='".$postcount."', usercount='".$user['usercount']."', lastuserid='".$user['userid']."'",1);

  $result = $db->query("SELECT varname, value FROM bb".$n."_options");
  while($row=$db->fetch_array($result)) ${$row['varname']}=$row['value'];

  require("./lib/class_query.php");

  $fp = fopen("./lib/lite_update3.sql", "rb");
  $query=fread($fp, filesize("./lib/lite_update3.sql"));
  fclose($fp);
  if($n!=1) $query=str_replace("bb1_","bb".$n."_",$query);
  $sql_query = new query($query);
  $sql_query->doquery();
  
  	// update group values
 	$result = $db->query("SELECT variableid,defaultvalue FROM bb".$n."_groupvariables");
	$not_str = '';
	while ($row = $db->fetch_array($result)) {
		$not_str .= ",'$row[variableid]'";
		$db->unbuffered_query("INSERT IGNORE INTO bb".$n."_groupvalues (variableid,value,groupid) SELECT '$row[variableid]' as variableid,'".addslashes($row['defaultvalue'])."' as value,groupid FROM bb".$n."_groups");
	}

	if ($not_str) $db->unbuffered_query("DELETE FROM bb".$n."_groupvalues WHERE variableid NOT IN (".wbb_substr($not_str, 1).")");

  // update groupcombinationdata
  $result = $db->query("SELECT groupids FROM bb".$n."_groupcombinations");
  while ($row = $db->fetch_array($result)) cachegroupcombinationdata($row['groupids']);
 
  
  

  $db->query("UPDATE bb".$n."_options SET value='".addslashes($rekordtime)."' WHERE varname='rekordtime'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($rekord)."' WHERE varname='rekord'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($dateformat)."' WHERE varname='dateformat'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($timeformat)."' WHERE varname='timeformat'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($showbirthdays)."' WHERE varname='showbirthdays'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($showevents)."' WHERE varname='showevents'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($index_depth)."' WHERE varname='index_depth'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($show_subboards)."' WHERE varname='show_subboards'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($showlastposttitle)."' WHERE varname='showlastposttitle'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($master_board_name)."' WHERE varname='master_board_name'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($showuseronlineinboard)."' WHERE varname='showuseronlineinboard'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($showuseronline)."' WHERE varname='showuseronline'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($showpmonindex)."' WHERE varname='showpmonindex'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($minusernamelength)."' WHERE varname='minusernamelength'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($maxusernamelength)."' WHERE varname='maxusernamelength'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($multipleemailuse)."' WHERE varname='multipleemailuse'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($emailverifymode)."' WHERE varname='emailverifymode'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($showuseronlineonboard)."' WHERE varname='showuseronlineonboard'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($dostopshooting)."' WHERE varname='dostopshooting'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($showpostsinreply)."' WHERE varname='showpostsinreply'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($smilie_table_cols)."' WHERE varname='smilie_table_cols'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($smilie_table_rows)."' WHERE varname='smilie_table_rows'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($maxpolloptions)."' WHERE varname='maxpolloptions'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($postmaxchars)."' WHERE varname='postmaxchars'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($frommail)."' WHERE varname='frommail'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($boardordermode)."' WHERE varname='boardordermode'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($useronlinetimeout)."' WHERE varname='useronlinetimeout'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($board_depth)."' WHERE varname='board_depth'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($showown)."' WHERE varname='showown'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($default_threadsperpage)."' WHERE varname='default_threadsperpage'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($default_daysprune)."' WHERE varname='default_daysprune'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($default_postsperpage)."' WHERE varname='default_postsperpage'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($showmultipages)."' WHERE varname='showmultipages'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($showavatar)."' WHERE varname='showavatar'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($allowflashavatar)."' WHERE varname='allowflashavatar'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($showregdateinthread)."' WHERE varname='showregdateinthread'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($showuserpostsinthread)."' WHERE varname='showuserpostsinthread'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($showuserfieldsinthread)."' WHERE varname='showuserfieldsinthread'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($showgenderinthread)."' WHERE varname='showgenderinthread'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($showonlineinthread)."' WHERE varname='showonlineinthread'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($showthreadstarter)."' WHERE varname='showthreadstarter'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($membersperpage)."' WHERE varname='membersperpage'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($showlastpostinprofile)."' WHERE varname='showlastpostinprofile'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($allowregister)."' WHERE varname='allowregister'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($showdisclaimer)."' WHERE varname='showdisclaimer'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($default_startweek)."' WHERE varname='default_startweek'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($default_timezoneoffset)."' WHERE varname='default_timezoneoffset'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($avatarsperpage)."' WHERE varname='avatarsperpage'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($gzip)."' WHERE varname='gzip'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($gziplevel)."' WHERE varname='gziplevel'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($minwordlength)."' WHERE varname='minwordlength'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($maxwordlength)."' WHERE varname='maxwordlength'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($showstats)."' WHERE varname='showstats'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($usecode)."' WHERE varname='usecode'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($showpagelinks)."' WHERE varname='showpagelinks'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($allowdynimg)."' WHERE varname='allowdynimg'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($url2board)."' WHERE varname='url2board'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($webmastermail)."' WHERE varname='webmastermail'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($sendnocacheheaders)."' WHERE varname='sendnocacheheaders'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($default_hotthread_reply)."' WHERE varname='default_hotthread_reply'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($default_hotthread_view)."' WHERE varname='default_hotthread_view'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($maxpms)."' WHERE varname='maxpms'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($showboardjump)."' WHERE varname='showboardjump'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($maxfolders)."' WHERE varname='maxfolders'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($pmmaxchars)."' WHERE varname='pmmaxchars'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($docensor)."' WHERE varname='docensor'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($listallbirthdays)."' WHERE varname='listallbirthdays'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($eventmaxchars)."' WHERE varname='eventmaxchars'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($offlinemessage)."' WHERE varname='offlinemessage'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($offline)."' WHERE varname='offline'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($dpvtime)."' WHERE varname='dpvtime'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($fctime)."' WHERE varname='fctime'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($showsmiliesrandom)."' WHERE varname='showsmiliesrandom'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($badsearchwords)."' WHERE varname='badsearchwords'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($turnoff_formmail)."' WHERE varname='turnoff_formmail'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($userratings)."' WHERE varname='userratings'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($showuserratinginthread)."' WHERE varname='showuserratinginthread'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($smtp)."' WHERE varname='smtp'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($wiw_showonlyusers)."' WHERE varname='wiw_showonlyusers'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($wiw_autorefresh)."' WHERE varname='wiw_autorefresh'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($installdate)."' WHERE varname='installdate'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($cookiepath)."' WHERE varname='cookiepath'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($cookiedomain)."' WHERE varname='cookiedomain'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($ban_ip)."' WHERE varname='ban_ip'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($censorwords)."' WHERE varname='censorwords'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($censorcover)."' WHERE varname='censorcover'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($ban_name)."' WHERE varname='ban_name'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($ban_email)."' WHERE varname='ban_email'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($userlevels)."' WHERE varname='userlevels'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($showuserlevels)."' WHERE varname='showuserlevels'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($default_register_invisible)."' WHERE varname='default_register_invisible'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($default_register_nosessionhash)."' WHERE varname='default_register_nosessionhash'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($default_register_usecookies)."' WHERE varname='default_register_usecookies'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($default_register_admincanemail)."' WHERE varname='default_register_admincanemail'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($default_register_showemail)."' WHERE varname='default_register_showemail'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($default_register_usercanemail)."' WHERE varname='default_register_usercanemail'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($default_register_emailnotify)."' WHERE varname='default_register_emailnotify'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($default_register_receivepm)."' WHERE varname='default_register_receivepm'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($default_register_emailonpm)."' WHERE varname='default_register_emailonpm'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($default_register_pmpopup)."' WHERE varname='default_register_pmpopup'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($default_register_showsignatures)."' WHERE varname='default_register_showsignatures'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($default_register_showavatars)."' WHERE varname='default_register_showavatars'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($default_register_showimages)."' WHERE varname='default_register_showimages'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($default_register_threadview)."' WHERE varname='default_register_threadview'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($sessiontimeout)."' WHERE varname='sessiontimeout'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($adminsession_timeout)."' WHERE varname='adminsession_timeout'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($picmaxwidth)."' WHERE varname='picmaxwidth'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($picmaxheight)."' WHERE varname='picmaxheight'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($default_prefix)."' WHERE varname='default_prefix'");
  $db->query("UPDATE bb".$n."_options SET value='".addslashes($regnotify)."' WHERE varname='regnotify'");

  require ("./lib/class_options.php");
  $option=new options("lib");
  $option->write();

  $db->query("UPDATE bb".$n."_threads SET votepoints=votepoints*2");

  header("Location: setup.php?step=180&mode=4&frameset=$frameset");
  exit;
 }

}





/********* update from wbb2.2.x *********/
if ($mode == 4 && $step >= 180 && $step < 190) {
	// update table structure (part I)
	if ($step == 180) {
		require("./lib/config.inc.php");
		require("./lib/class_db_mysql.php");
		require("./lib/class_query.php");
		$db = new db($sqlhost, $sqluser, $sqlpassword, $sqldb, $phpversion);
		
		// update sql
		$fp = fopen("./lib/update1.sql", "rb");
		$query = fread($fp, filesize("./lib/update1.sql"));
		fclose($fp);
		if ($n != 1) $query = str_replace("bb1_", "bb".$n."_", $query); 
		$sql_query = new query($query);
		$sql_query->doquery();
		
		// update group values
		$result = $db->query("SELECT variableid,defaultvalue FROM bb".$n."_groupvariables");
		$not_str = '';
		while ($row = $db->fetch_array($result)) {
			$not_str .= ",'$row[variableid]'";
			$db->unbuffered_query("INSERT IGNORE INTO bb".$n."_groupvalues (variableid,value,groupid) SELECT '$row[variableid]' as variableid,'".addslashes($row['defaultvalue'])."' as value,groupid FROM bb".$n."_groups");
		}
		if ($not_str) $db->unbuffered_query("DELETE FROM bb".$n."_groupvalues WHERE variableid NOT IN (".wbb_substr($not_str, 1).")");
		
		// update groupcombinationdata
		$result = $db->query("SELECT groupids FROM bb".$n."_groupcombinations");
		while ($row = $db->fetch_array($result)) cachegroupcombinationdata($row['groupids']);

		// update templates, languagepacks
		informationPage('Die Datenbankstruktur wurde erfolgreich f&uuml;r das Update auf Version 2.3 vorbereitet.
		<br /><br /><a href="setup.php?step=7&amp;mode='.$mode.'&amp;frameset='.$frameset.'">Klicken Sie hier, um mit dem Update fortzufahren.</a>');
	}
	
	// convert attachments
	if($step == 181) {
		if($frameset==1) repeatstep(0, 0, 181.2, 181.1);
		else {
			header("Location: setup.php?step=181.1&mode=$mode");
			exit;
		}
	}
	if ($step == 181.1) {
		require("./lib/config.inc.php");
		require("./lib/class_db_mysql.php");
		$db = new db($sqlhost, $sqluser, $sqlpassword, $sqldb, $phpversion);
		
		if(isset($_REQUEST['loop'])) $loop=intval($_REQUEST['loop']);
		else $loop=0;
		$perloop=250;
		
		list($totalcount)=$db->query_first("SELECT COUNT(*) FROM bb".$n."_attachments");
		$result = $db->query("SELECT a.attachmentid, p.postid, p.userid, p.posttime ".
		"FROM bb".$n."_attachments a ".
		"LEFT JOIN bb".$n."_posts p ON (p.postid = a.postid) ".
		"ORDER BY a.attachmentid ASC", $perloop, $loop * $perloop);
		
		if($db->num_rows($result) > 0) {
			if($frameset==1) stepstart();
			
			while($row = $db->fetch_array($result)) {
				$db->query("UPDATE bb".$n."_attachments SET userid = '".$row['userid']."', uploadtime = '".$row['posttime']."' WHERE attachmentid = '".$row['attachmentid']."'");
			}
			$loop++;
			
			if($frameset==1) repeatstep((($loop*$perloop)/$totalcount)*100, $loop, 181.2, 181.1);
			else {
				header("Location: setup.php?step=181.1&loop=$loop&mode=$mode");
				exit;
			}
		}
		else {
			if ($frameset == 1) {
				informationPage('<script type="text/javascript">
				<!--
				parent.frames[0].location.href=\'setup.php?step=181.3&mode='.$mode.'&frameset=1\';
				//-->
				</script>');
			}
			else {
				header("Location: setup.php?step=181.3&mode=$mode");
				exit;
			}			
		}
	}
	if($step == 181.2) {
		statusPage("Datenkonvertierung läuft (Schritt 1)...", "182");	
	}
	if($step == 181.3) {
		informationPage('Datenkonvertierung (Schritt 1) erfolgreich beendet.
		 <br /><br /><a href="setup.php?step=182&amp;mode='.$mode.'&amp;frameset='.$frameset.'">Klicken Sie hier, um fortzufahren.</a>');
	}	
	
	
	// convert private messages
	if($step == 182) {
		if($frameset==1) repeatstep(0, 0, 182.2, 182.1);
		else {
			header("Location: setup.php?step=182.1&mode=$mode");
			exit;
		}
	}
	if ($step == 182.1) {
		require("./lib/config.inc.php");
		require("./lib/class_db_mysql.php");
		$db = new db($sqlhost, $sqluser, $sqlpassword, $sqldb, $phpversion);

		if(isset($_REQUEST['loop'])) $loop=intval($_REQUEST['loop']);
		else $loop=0;
		$perloop=100;
		
		list($totalcount)=$db->query_first("SELECT COUNT(*) FROM bb".$n."_privatemessage");
		$result = $db->query("SELECT pm.*, u.username ".
		"FROM bb".$n."_privatemessage pm ".
		"LEFT JOIN bb".$n."_users u ON (u.userid = pm.recipientid) ".
		"ORDER BY pm.privatemessageid ASC", $perloop, $loop * $perloop);
		
		if($db->num_rows($result) > 0) {
			if($frameset==1) stepstart();
			
			while($row = $db->fetch_array($result)) {
				$recipientlistSerialized = serialize(array($row['recipientid'] => $row['username']));
				$pmhash = md5($row['senderid']."\n"."1"."\n".$recipientlistSerialized."\n".$row['subject']."\n".$row['message']);
				if ($row['deletepm'] != 1) {
					$deletepm = 0;
				}
				else {
					$deletepm = 1;	
				}
				if ($row['deletepm'] != 2) {
					$inoutbox = 1;	
				}
				else {
					$inoutbox = 0;	
				}
				
				
				$db->query("UPDATE bb".$n."_privatemessage SET inoutbox = '".$inoutbox."', pmhash = '".addslashes($pmhash)."', recipientlist = '".addslashes($recipientlistSerialized)."', recipientcount = '1' WHERE privatemessageid = '".$row['privatemessageid']."'");
				$db->query("INSERT INTO bb".$n."_privatemessagereceipts (privatemessageid, recipientid, recipient, folderid, deletepm, view, reply, forward) ".
				"VALUES ('".$row['privatemessageid']."', '".$row['recipientid']."', '".addslashes($row['username'])."', '".$row['folderid']."', '".$deletepm."', '".$row['view']."', '".$row['reply']."', '".$row['forward']."')");
			}
			$loop++;
			
			if($frameset==1) repeatstep((($loop*$perloop)/$totalcount)*100, $loop, 182.2, 182.1);
			else {
				header("Location: setup.php?step=182.1&loop=$loop&mode=$mode");
				exit;
			}
		}
		else {
			if ($frameset == 1) {
				informationPage('<script type="text/javascript">
				<!--
				parent.frames[0].location.href=\'setup.php?step=182.3&mode='.$mode.'&frameset=1\';
				//-->
				</script>');
			}
			else {
				header("Location: setup.php?step=182.3&mode=$mode");
				exit;
			}			
		}
	}
	if($step == 182.2) {
		statusPage("Datenkonvertierung läuft (Schritt 2)...", "183");	
	}
	if($step == 182.3) {
		informationPage('Datenkonvertierung (Schritt 2) erfolgreich beendet.
		 <br /><br /><a href="setup.php?step=183&amp;mode='.$mode.'&amp;frameset='.$frameset.'">Klicken Sie hier, um fortzufahren.</a>');
	}	
	
	// update acp menu, options, optiongroups & groupvariables
	if ($step == 183) {
		require("./lib/config.inc.php");
		require("./lib/class_db_mysql.php");
		require("./lib/options.inc.php");
		$db = new db($sqlhost, $sqluser, $sqlpassword, $sqldb, $phpversion);
		
		// acp menu
		list($itemgroupID) = $db->query_first("SELECT itemgroupid FROM bb".$n."_acpmenuitemgroups WHERE title = 'other1'");
		$db->query("UPDATE bb".$n."_acpmenuitems SET itemgroupid = '".$itemgroupID."' WHERE languageitem = 'OTHERSTUFF_MAILQUEUE'");
		
		// insert and reassign options & optiongroups
		list($optiongroupID) = $db->query_first("SELECT optiongroupid FROM bb".$n."_optiongroups WHERE title = 'attachments'");
		$db->query("UPDATE bb".$n."_options SET optiongroupid = '".$optiongroupID."', showorder = '2' WHERE varname = 'picmaxwidth'");
		$db->query("UPDATE bb".$n."_options SET optiongroupid = '".$optiongroupID."', showorder = '3' WHERE varname = 'picmaxheight'");
		$db->query("UPDATE bb".$n."_options SET optiongroupid = '".$optiongroupID."' WHERE varname IN ('makethumbnails', 'thumbnailwidth', 'thumbnailheight', 'thumbnailsperrow', 'total_attachment_filesize_limit')");
		list($optiongroupID) = $db->query_first("SELECT optiongroupid FROM bb".$n."_optiongroups WHERE title = 'register'");
		$db->query("UPDATE bb".$n."_options SET optiongroupid = '".$optiongroupID."' WHERE varname IN ('default_register_notificationperpm')");
		list($optiongroupID) = $db->query_first("SELECT optiongroupid FROM bb".$n."_optiongroups WHERE title = 'search'");
		$db->query("UPDATE bb".$n."_options SET optiongroupid = '".$optiongroupID."' WHERE varname IN ('goodsearchwords')");
		
		// groupvariables
		list($variablegroupID) = $db->query_first("SELECT variablegroupid FROM bb".$n."_groupvariablegroups WHERE title = 'USER_PMSG'");
		$db->query("UPDATE bb".$n."_groupvariables SET variablegroupid = '".$variablegroupID."' WHERE variablename IN ('max_pms_recipients', 'max_pms', 'max_pms_folders', 'can_upload_pm_attachments', 'max_pm_attachments', 'max_pm_attachment_size', 'allowed_pm_attachment_extensions')");
		list($variablegroupID) = $db->query_first("SELECT variablegroupid FROM bb".$n."_groupvariablegroups WHERE title = 'ADMIN_GROUP'");
		$db->query("UPDATE bb".$n."_groupvariables SET variablegroupid = '".$variablegroupID."' WHERE variablename IN ('a_can_groups_pmsend')");
		list($variablegroupID) = $db->query_first("SELECT variablegroupid FROM bb".$n."_groupvariablegroups WHERE title = 'USER_POSTING'");
		$db->query("UPDATE bb".$n."_groupvariables SET variablegroupid = '".$variablegroupID."' WHERE variablename IN ('max_attachments', 'total_attachment_filesize_limit')");
		list($variablegroupID) = $db->query_first("SELECT variablegroupid FROM bb".$n."_groupvariablegroups WHERE title = 'ADMIN_UPDATEVIEW'");
		$db->query("UPDATE bb".$n."_groupvariables SET variablegroupid = '".$variablegroupID."' WHERE variablename IN ('a_can_otherstuff_thumbnails', 'a_can_otherstuff_pmcounters')");
		
		// move 'maxpms' and 'maxfolders' from global options to groupvariables
		list($variableID) = $db->query_first("SELECT variableid FROM bb".$n."_groupvariables WHERE variablename = 'max_pms'");
		$db->query("UPDATE bb".$n."_groupvalues SET value = '".intval($maxpms)."' WHERE variableid = '".$variableID."'");
		list($variableID) = $db->query_first("SELECT variableid FROM bb".$n."_groupvariables WHERE variablename = 'max_pms_folders'");
		$db->query("UPDATE bb".$n."_groupvalues SET value = '".intval($maxfolders)."' WHERE variableid = '".$variableID."'");
		$db->query("DELETE FROM bb".$n."_options WHERE varname IN ('maxpms', 'maxfolders')");
		
		// update groupcombinationdata (due to the update of bb1_groupvalues)
		$result = $db->query("SELECT groupids FROM bb".$n."_groupcombinations");
		while ($row = $db->fetch_array($result)) cachegroupcombinationdata($row['groupids']);
		
		
		header("Location: setup.php?step=188&mode=$mode&frameset=$frameset");
		exit;
	}
	
	// update table structure (part II)
	if ($step == 188) {
		require("./lib/config.inc.php");
		require("./lib/class_db_mysql.php");
		require("./lib/class_query.php");
		$db = new db($sqlhost, $sqluser, $sqlpassword, $sqldb, $phpversion);
		
		// update sql
		$fp = fopen("./lib/update2.sql", "rb");
		$query = fread($fp, filesize("./lib/update2.sql"));
		fclose($fp);
		if ($n != 1) $query = str_replace("bb1_", "bb".$n."_", $query); 
		$sql_query = new query($query);
		$sql_query->doquery();
		
		informationPage('Die Datenbankstruktur wurde erfolgreich an Version 2.3 angepasst.
		<br /><br /><a href="setup.php?step=189&amp;mode='.$mode.'&amp;frameset='.$frameset.'">Klicken Sie hier, um mit dem Update fortzufahren.</a>');
	}
	
	// end update
	if ($step == 189) {
		require("./lib/config.inc.php");
		require("./lib/class_db_mysql.php");
		$db = new db($sqlhost, $sqluser, $sqlpassword, $sqldb, $phpversion);
		
		// update groupcombinationdata
		$result = $db->query("SELECT groupids FROM bb".$n."_groupcombinations");
		while ($row = $db->fetch_array($result)) cachegroupcombinationdata($row['groupids']);
		
		// update board version
		$db->query("UPDATE bb".$n."_options SET value='2.3.2' WHERE varname='boardversion'");
		
		// update bbcode align
		$db->query("UPDATE bb".$n."_bbcodes SET pattern1='[^\\\\\"\';}]*' WHERE bbcodetag='align'");
	 
		require("./lib/class_options.php");
		$option = new options("lib");
		$option->write();
		
		$fp = @fopen("./lib/install.lock", "w+b");
		fclose($fp);
		
		informationPage('<b>Update auf Version 2.3 erfolgreich abgeschlossen.</b>
		<br /><br /><a href="index.php" target="_blank">Hier gelangen Sie ins Admin Control Panel</a>');		
	}
}


/********* update from wbb2.3.1 *********/
if ($step == 290) {
	 // update templates, languagepacks
	 header("Location: setup.php?step=7&mode=$mode&frameset=$frameset");
	 exit;
}

if ($step == 291) {
	 require("./lib/config.inc.php");
	 require("./lib/class_db_mysql.php");
	 $db = new db($sqlhost, $sqluser, $sqlpassword, $sqldb, $phpversion);
	 
	 // update groupcombinationdata
	 $result = $db->query("SELECT groupids FROM bb".$n."_groupcombinations");
	 while ($row = $db->fetch_array($result)) cachegroupcombinationdata($row['groupids']);
	 
	 // update board version
	 $db->query("UPDATE bb".$n."_options SET value='2.3.2' WHERE varname='boardversion'");
	 
	 // update bbcode align
	 $db->query("UPDATE bb".$n."_bbcodes SET pattern1='[^\\\\\"\';}]*' WHERE bbcodetag='align'");
	 	 
	 require("./lib/class_options.php");
	 $option = new options("lib");
	 $option->write();
	 
	 $fp = @fopen("./lib/install.lock", "w+b");
	 fclose($fp);
	 
	 informationPage('<b>Update auf Version 2.3.2 erfolgreich abgeschlossen.</b>
	   <br /><br /><a href="index.php" target="_blank">Hier gelangen Sie ins Admin Control Panel</a>');		
}
?>