<?php
$time_begin = microtime();

include "lib/config_data.php";

include "lib/functions.php";
include "lib/template_class.php";
include "lib/database_class.php";

$template = new template_class;
$database = new database_class;

$database->db_connect();

$query = $database->db_query("SELECT * FROM firstnews_options WHERE id = 1");
$options = mysql_fetch_array($query);

//Werbung durch Partner
$associate = $_REQUEST["associate"];

//Partnerseiten
$partner_sites = $database->db_query("SELECT * FROM firstnews_links WHERE partner = 1 ORDER BY graphic_source ASC");

while($link = @mysql_fetch_array($partner_sites))
{
  if($link["graphic_source"]) eval("\$partner_links .= \"".$template->tpl("link_graphic.htm")."\";");
  else eval("\$partner_links .= \"".$template->tpl("link_text.htm")."\";");
}

//Bewertungsseiten
$voting_sites = $database->db_query("SELECT * FROM firstnews_links WHERE partner = 0");

while($link = @mysql_fetch_array($voting_sites))
{
  if($link["graphic_source"]) eval("\$voting_links .= \"".$template->tpl("link_graphic.htm")."\";");
  else eval("\$voting_links .= \"".$template->tpl("link_text.htm")."\";");
}

eval("\$voting_forms = \"".$template->tpl("voting_forms.htm")."\";");

?>
