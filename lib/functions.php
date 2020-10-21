<?php
function shop_box($site)
{
  global $database, $template, $sql_prefix, $main_shop;

  $query = $database->db_query("SELECT `asin` FROM `hp" . $sql_prefix . "_shop` ORDER BY RAND() LIMIT 1");
  $products = mysql_fetch_row($query);

  eval("\$main_shop = \"".$template->tpl("main_shop")."\";");
}

function quote($quote)
{
  global $template;
  $quote = str_replace("\\\"","\"",$quote);
  eval("\$quote = \"".$template->tpl("quote")."\";");

  return $quote;
}

function parse_text($text, $mode = 0)
{
  //HTML-Code deaktivieren
  $text = str_replace("&","&amp;",$text);
  $text = str_replace("<","&lt;",$text);
  $text = str_replace(">","&gt;",$text);
  
  if($mode == 0)
  {
    //URL-Formate umwandeln
    $text = preg_replace("=(^|\ |\\n)(http:\/\/)([a-zA-Z0-9\.\/\-\_]{1,})=i","\\1<a href=\"\\2\\3\" target=\"_blank\">\\2\\3</a> ", $text);
    $text = preg_replace("=(^|\ |\\n)(www\.)([a-zA-Z0-9\.\/\-\_]{1,})=i","\\1<a href=\"http://\\2\\3\" target=\"_blank\">\\2\\3</a> ", $text);
  
    //BB-Codes
    $text = preg_replace("/\[b\](.*?)\[\/b\]/si", "<b>\\1</b>", $text);
    $text = preg_replace("/\[i\](.*?)\[\/i\]/si", "<i>\\1</i>", $text);
    $text = preg_replace("/\[u\](.*?)\[\/u\]/si", "<u>\\1</u>", $text);

    //Zeilenumbrüche wandeln
    $text = preg_replace("!(\r\n)|(\r)|(\n)!","<br>",$text);
    
    //Zitate
    $text = preg_replace("/\[quote\](.*?)\[\/quote\]/sie", "quote('\\1')",$text);
  }

  return $text;
}

function cat_hierarchy($site)
{
  global $database, $template, $sql_prefix, $main_cat_hierarchy_bit, $main_cat_hierarchy, $cats;

  $query = $database->db_query("SELECT `catid`, `title`, `description`, `subcat`, `maincat` FROM `hp" . $sql_prefix . "_cats` WHERE `catid` = '$_REQUEST[catid]'");
  $cats = mysql_fetch_array($query);

  if(!$cats["subcat"])
  {
    eval("\$main_cat_hierarchy_bit = \"".$template->tpl("main_cat_hierarchy_non_url_bit")."\";");
  }
  else
  {
    $query = $database->db_query("SELECT `catid`, `title` FROM `hp" . $sql_prefix . "_cats` WHERE `catid` = '$cats[maincat]'");
    $maincat = mysql_fetch_array($query);

    eval("\$main_cat_hierarchy_bit = \"".$template->tpl("main_cat_hierarchy_url_bit")."\";");
    eval("\$main_cat_hierarchy_bit .= \"".$template->tpl("main_cat_hierarchy_non_url_bit")."\";");
  }
  eval("\$main_cat_hierarchy = \"".$template->tpl("main_cat_hierarchy")."\";");
}

function partner_box($site)
{
  global $database, $template, $sql_prefix, $main_partner;
  eval("\$main_partner = \"".$template->tpl("main_partner")."\";");
}

function newsletter_box($site)
{
  global $database, $template, $sql_prefix, $main_newsletter;
  eval("\$main_newsletter = \"".$template->tpl("main_newsletter")."\";");
}

function subnavigation_box($site)
{
  global $database, $template, $sql_prefix, $main_subnavigation;
  if($site == "index" || $site == "impressum"|| $site == "contact") eval("\$main_subnavigation = \"".$template->tpl("index_subnavigation")."\";");
  else
  {
    $query = $database->db_query("SELECT `title`, `subcat`, `maincat` FROM `hp" . $sql_prefix . "_cats` WHERE `catid` = '$_REQUEST[catid]'");
    $cats = mysql_fetch_array($query);

    if(!$cats["subcat"])
    {
      $query = $database->db_query("SELECT `catid`, `title` FROM `hp" . $sql_prefix . "_cats` WHERE `maincat` = '$_REQUEST[catid]' And `subcat` = 1 ORDER BY `sort` ASC");
      while($subcats = mysql_fetch_array($query)) eval("\$main_subnavigation_bit .= \"".$template->tpl("main_subnavigation_bit")."\";");
    }
    else
    {
      $query = $database->db_query("SELECT `catid`, `title` FROM `hp" . $sql_prefix . "_cats` WHERE `maincat` = '$cats[maincat]' And `subcat` = 1 ORDER BY `sort` ASC");
      while($subcats = mysql_fetch_array($query)) eval("\$main_subnavigation_bit .= \"".$template->tpl("main_subnavigation_bit")."\";");
      
      $query = $database->db_query("SELECT `title` FROM `hp" . $sql_prefix . "_cats` WHERE `catid` = '$cats[maincat]'");
      $cats = mysql_fetch_array($query);
    }

    eval("\$main_subnavigation = \"".$template->tpl("main_subnavigation")."\";");
  }
}

function top_navigation()
{
  global $database, $template, $sql_prefix, $main_top_navigation;

  $query = $database->db_query("SELECT * FROM `hp" . $sql_prefix . "_cats` WHERE `subcat` = '0' ORDER BY `sort` ASC");
  while($cats = mysql_fetch_array($query))
  {
    if($cats["style"] == 1) eval("\$main_top_navigation .= \"".$template->tpl("main_top_navigation_downloads_bit")."\";");
    if($cats["style"] == 2) eval("\$main_top_navigation .= \"".$template->tpl("main_top_navigation_articles_bit")."\";");
    if($cats["style"] == 3) eval("\$main_top_navigation .= \"".$template->tpl("main_top_navigation_faq_bit")."\";");
    if($cats["style"] == 4) eval("\$main_top_navigation .= \"".$template->tpl("main_top_navigation_links_bit")."\";");
  }

}
?>
