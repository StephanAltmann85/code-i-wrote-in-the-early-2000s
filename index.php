<?php
$site = "index";

include "lib/global.php";
include "lib/functions.php";

//Layout-Ausgaben
shop_box($site);
partner_box($site);
newsletter_box($site);
subnavigation_box($site);
top_navigation();

eval("\$main_webring = \"".$template->tpl("main_webring")."\";");

$query = $database->db_query("SELECT * FROM `hp" . $sql_prefix . "_news` ORDER BY `time` DESC");
while($news = @mysql_fetch_array($query))
{
  $news["content"] = parse_text($news["content"]);
  $news["title"] = parse_text($news["title"], 1);
  eval("\$main_content .= \"".$template->tpl("index_news_bit")."\";");
}
eval("\$template->tpl_output(\"".$template->tpl("main")."\");");

$database->db_close();
echo $database->error_output();
?>
