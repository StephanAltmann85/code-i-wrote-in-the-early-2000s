<?php
$site = "links";

include "lib/global.php";
include "lib/functions.php";

//Layout-Ausgaben
shop_box($site);
partner_box($site);
newsletter_box($site);
subnavigation_box($site);
top_navigation();
cat_hierarchy($site);

$cats["description"] = parse_text($cats["description"]);

eval("\$main_webring = \"".$template->tpl("main_webring")."\";");

switch($_REQUEST["action"])
{
  case "vote": $query = $database->db_query("SELECT title, clicks FROM `hp" . $sql_prefix . "_links` WHERE `linkid` = '$_REQUEST[linkid]'");
               $link = mysql_fetch_array($query);
               
               if(strlen($link["title"]) > 25) $link["title"] = substr($link["title"], 0, 22) . "...";

               eval("\$template->tpl_output(\"".$template->tpl("links_vote")."\");");
  break;


  default: $query = $database->db_query("SELECT a.linkid, a.title, a.language, a.description, a.clicks, b.image, b.language AS lang FROM `hp" . $sql_prefix . "_links` a LEFT JOIN `hp" . $sql_prefix . "_languages` b ON a.language = b.langid Order By a.clicks ASC");
           while($links = mysql_fetch_array($query))
           {
             if(!$links["language"])
             {
               $links["image"] = "none.gif";
               $links["lang"] = "Sprache: Unbekannt";
             }
             
             if(!$links["count"]) $links["count"] = "0";
  
             eval("\$links_bit .= \"".$template->tpl("links_bit")."\";");
           }
  break;
}


if($_REQUEST["action"] != "vote")
{
 eval("\$main_content .= \"".$template->tpl("links_main")."\";");
 eval("\$template->tpl_output(\"".$template->tpl("main")."\");");
}

$database->db_close();
?>
