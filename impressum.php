<?php
$site = "impressum";

include "lib/global.php";
include "lib/functions.php";

//Layout-Ausgaben
shop_box($site);
partner_box($site);
subnavigation_box($site);
newsletter_box($site);
top_navigation();

eval("\$main_webring = \"".$template->tpl("main_webring")."\";");

eval("\$main_content .= \"".$template->tpl("impressum")."\";");

eval("\$template->tpl_output(\"".$template->tpl("main")."\");");

$database->db_close();
echo $database->error_output();
?>
