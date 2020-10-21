<?php
$filename="locator.php";

require ("./global.php");

$action = $_GET["action"];

eval("\$tpl->output(\"".$tpl->get("rules")."\");");


?>
