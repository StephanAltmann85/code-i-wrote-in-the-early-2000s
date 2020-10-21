<?php
/** 
* script to cache acp templates in WoltLab Burning Board 2.3.x
* upload this script to your /acp directory and execute it.
*/

$phpversion = phpversion();
require("./lib/functions.php");
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
@set_magic_quotes_runtime(0);






if (isset($_REQUEST['loop'])) $loop = intval($_REQUEST['loop']);
else $loop = 0;
$perloop = 20;
$self_name = basename(__FILE__);
@set_time_limit(0);


@ini_set("error_reporting", "E_ALL");
@ini_set("display_errors", "1");
@error_reporting(E_ALL);





/** search for templates to compile */
if (isset($_REQUEST['tplname'])) $tplname = trim($_REQUEST['tplname']);
else $tplname = "";

if ($tplname && file_exists()) {
	$templates = array($tplname);
}
else {
	$templates = array();
	$handle = opendir("./templates");
	while ($file = readdir($handle)) {
		if ($file == ".." || $file == "." || substr($file, - 3) != "htm") continue;
		$templates[] = substr($file, 0, - 1*strlen(strrchr($file, ".")));
	}
	closedir($handle);
	unset($handle);
	sort($templates);
}


echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"
\"http://www.w3.org/TR/html4/loose.dtd\">\n";
echo "<html>\n";
echo "<head>\n";
echo "<title>Cache ACP-Templates ...</title>\n";
echo "<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>\n";
echo "</head>\n";
echo "<body bgcolor='#FFFFFF' text='#000000'>\n";
flush();


/** compile these templates */
if (count($templates) > $loop * $perloop) {
	echo "<font face='Tahoma' size='2'>";
	echo "<b>Cache ACP-Templates. Bitte warten... Dieser Vorgang kann u.U. mehrere Minuten dauern.</b>";
	echo "</font><p>&nbsp;</p>";
	flush();  //
	
	$count = 0;
	include_once("./lib/class_templateparser.php");
	$tplparser = new TemplateParser();
	for ($i = $loop * $perloop; $i < (($loop + 1) * $perloop) && $i < count($templates); $i++) {
		$templatename = $templates[$i];
		echo "<font face='Tahoma' size='2'>cache ACP-Template '$templatename' ...</font><br>\n";
		flush(); 
		
		$fp = fopen("./templates/".$templatename.".htm", "rb");
		$template = fread($fp, filesize("./templates/".$templatename.".htm"));
		fclose($fp);
		$template = dos2unix($template);
		$template = $tplparser->parse($template);
		$fp = fopen("../cache/templates/acp/".$templatename.".php", "w+b");
		fwrite($fp, "<?php
		/*
		templatepackid: acp template
		templatename: ".$templatename."
		*/
		
		\$this->templates['acp_".$templatename."']=\"".addcslashes($template, "$\"\\")."\";
		?".">");
		fclose($fp);
		@chmod("../cache/templates/acp/".$templatename.".php", 0777);
		@touch("../cache/templates/acp/".$templatename.".php", filemtime("./templates/".$templatename.".htm"));
		
		$count++;
		if ($count == $perloop) break;
	}
	// redirect to next loop
	$loop++;
	echo "\n<p>&nbsp;</p><font face='Tahoma' size='2'>";
	echo "<a href='$self_name?loop=$loop&amp;tplname=$tplname'>Falls die automatische Weiterleitung nicht funktioniert, klicken Sie bitte hier um fortzufahren.</a>";
	echo "</font><p>&nbsp;</p>";
	
	echo "\n<script type=\"text/javascript\" language=\"javascript\">\n";
	echo "window.location=\"$self_name?loop=$loop&tplname=$tplname\";\n";
	echo "</script>\n";
	
	
	echo "</body>\n";
	echo "</html>\n";
	exit;
}



echo "<p>&nbsp;</p><p>&nbsp;</p><font face='Tahoma' size='2'>";
echo "<b>Das Cachen der ACP-Templates wurde erfolgreich beendet.</b>";
echo "</font>";


echo "</body></html>";
?>
