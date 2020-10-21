<?php
$time_begin = microtime();

include "../lib/config_data.php";

include "../lib/functions.php";
include "../lib/template_class.php";
include "../lib/database_class.php";

$template = new template_class;
$database = new database_class;

$database->db_connect();

$query = $database->db_query("SELECT * FROM firstnews_options WHERE id = 1");
$options = mysql_fetch_array($query);
?>