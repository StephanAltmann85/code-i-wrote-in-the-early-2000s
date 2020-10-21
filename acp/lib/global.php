<?php
$time_begin = microtime();

include "../lib/config_data.php";
include "../lib/database_class.php";

$database = new database_class;

include "../lib/template_class.php";

$template = new template_class;

$database->db_connect();

$query = $database->db_query("SELECT * FROM hp" . $sql_prefix . "_options WHERE id = 0");
$options = mysql_fetch_array($query);


?>
