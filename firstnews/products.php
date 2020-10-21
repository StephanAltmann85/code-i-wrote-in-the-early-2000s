<?php
include "lib/global.php";

if($_GET["id"])
{
  $query = $database->db_query("SELECT * FROM firstnews_products WHERE id = $_GET[id]");

  $product = $row = @mysql_fetch_array($query);
  $product["info_box"] = nl2br($product["info_box"]);
  $product["description"] = nl2br($product["description"]);

  if($product["download"])
  {
    $size = @round(@filesize($product["download"]) / 1024);
    if(!$size) $size = "-";
    eval("\$product_download = \"".$template->tpl("products_download.htm")."\";");
  }

  if($_REQUEST["action"] == "download")
  {
    $downloads = $product["downloads"] + 1;
    $database->db_query("UPDATE `firstnews_products` SET downloads = $downloads WHERE id = $_GET[id]");

    header("Location: $product[download]");
  }

  if($product["info_box"]) eval("\$product_info_box = \"".$template->tpl("products_info_box.htm")."\";");

  if($product["price"]) eval("\$product_order = \"".$template->tpl("products_order.htm")."\";");

  eval("\$products_bit = \"".$template->tpl("products_info.htm")."\";");
  $title = $product["name"];
  eval("\$main_bit = \"".$template->tpl("products.htm")."\";");
}
else
{
  $query = $database->db_query("SELECT id, name, short_description, price, language, downloads FROM firstnews_products ORDER BY sort ASC");

  while($row = @mysql_fetch_row($query))
  {
    $id = $row[0];
    $name = $row[1];
    $short_description = nl2br($row[2]);
    $price  = $row[3];
    $language  = $row[4];
    $downloads  = $row[5];

    eval("\$products_bit .= \"".$template->tpl("products_list.htm")."\";");
  }
  $title = "Produktübersicht";
  eval("\$main_bit = \"".$template->tpl("products.htm")."\";");
}

$used_queries = $database->used_queries;
$database->db_close();
echo $database->error_output();

$used_templates = $template->used_templates;
$exec_time = exec_time();
eval("\$template->tpl_output(\"".$template->tpl("main.htm")."\");");
?>