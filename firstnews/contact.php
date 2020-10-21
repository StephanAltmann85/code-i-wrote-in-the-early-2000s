<?php
include "lib/global.php";

eval("\$main_bit = \"".$template->tpl("contact.htm")."\";");

$used_queries = $database->used_queries;
$database->db_close();
echo $database->error_output();

$used_templates = $template->used_templates;
$exec_time = exec_time();
eval("\$template->tpl_output(\"".$template->tpl("main.htm")."\");");
?>