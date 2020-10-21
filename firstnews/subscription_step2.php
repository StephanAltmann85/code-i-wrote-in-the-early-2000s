<?php
include "lib/global.php";
$total_price = 0;

$query = $database->db_query("SELECT id from firstnews_products WHERE price > 0 ORDER BY sort ASC");

while($row = @mysql_fetch_array($query))
{
 if($_POST[$row["id"]])
 {
   $query_product = $database->db_query("SELECT name, price, discount_mark_1, discount_rate_1, discount_mark_2, discount_rate_2, discount_mark_3, discount_rate_3 from firstnews_products WHERE id = $row[id]");
   $product_quantity = $_POST[$row["id"]];
   $product = @mysql_fetch_array($query_product);
   $product_total_price = sprintf("%0.2f", $product_quantity * $product["price"]);
   $total_price = $total_price + $product_total_price;

   $product_discount = 0;

   if($product_quantity >= $product["discount_mark_1"]) $product_discount = $product["discount_rate_1"];
   if($product_quantity >= $product["discount_mark_2"]) $product_discount = $product["discount_rate_2"];
   if($product_quantity >= $product["discount_mark_3"]) $product_discount = $product["discount_rate_3"];

   $product_total_discount = sprintf("%0.2f", $product_quantity * $product["price"] / 100 * $product_discount);
   $total_discount = $total_discount + $product_total_discount;

   eval("\$subscription_step2_list .= \"".$template->tpl("subscription_step2_list.htm")."\";");
 }
}
$total_price = sprintf("%0.2f", $total_price);
$total_discount = sprintf("%0.2f", $total_discount);
$final_price = sprintf("%0.2f", $total_price - $total_discount);

$query = $database->db_query("SELECT id from firstnews_products WHERE price > 0 ORDER BY sort ASC");

while($row = @mysql_fetch_array($query))
{
  $product_quantity = $_POST[$row["id"]];
  eval("\$subscription_hidden .= \"".$template->tpl("subscription_hidden.htm")."\";");
}

eval("\$main_bit = \"".$template->tpl("subscription_step2.htm")."\";");

$used_queries = $database->used_queries;
$database->db_close();
echo $database->error_output();

$used_templates = $template->used_templates;
$exec_time = exec_time();
eval("\$template->tpl_output(\"".$template->tpl("main.htm")."\");");
?>