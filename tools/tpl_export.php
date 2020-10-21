<?php
include "lib/global.php";
include "lib/functions.php";

$query = $database->db_query("SELECT * FROM `hp" . $sql_prefix . "_templates` WHERE templatepackid = 1");
while($templates = mysql_fetch_array($query))
{
  $Datei = fopen("templates/" . $templates["title"] . ".htm", "w");
  fputs($Datei, $templates["content"]);
  fclose($Datei);
}

$database->db_close();
echo $database->error_output();
?>
