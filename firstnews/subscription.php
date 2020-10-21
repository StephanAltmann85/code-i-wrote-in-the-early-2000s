<?php
include "lib/global.php";

$query = $database->db_query("SELECT id, name, short_description, price, language, discount_mark_1, discount_rate_1, discount_mark_2, discount_rate_2, discount_mark_3, discount_rate_3 FROM firstnews_products  WHERE price > 0 ORDER BY sort ASC");

while($row = @mysql_fetch_row($query))
{
  $id = $row[0];
  $name = $row[1];
  $short_description = nl2br($row[2]);
  $price  = $row[3];
  $language  = $row[4];
  $discount_mark_1 = $row[5];
  $discount_rate_1  = $row[6];
  $discount_mark_2  = $row[7];
  $discount_rate_2 = $row[8];
  $discount_mark_3  = $row[9];
  $discount_rate_3  = $row[10];

  $discount_1 = sprintf("%0.2f", round($price / 100 * $discount_rate_1, 2));
  $discount_2 = sprintf("%0.2f", round($price / 100 * $discount_rate_2, 2));
  $discount_3 = sprintf("%0.2f", round($price / 100 * $discount_rate_3, 2));

  eval("\$subscriptions_list .= \"".$template->tpl("subscription_list.htm")."\";");
}

if(!$_REQUEST["associate"]) eval("\$subscription_associate_field .= \"".$template->tpl("subscription_associate_field.htm")."\";");
eval("\$main_bit = \"".$template->tpl("subscription.htm")."\";");

$used_queries = $database->used_queries;
$database->db_close();
echo $database->error_output();

$used_templates = $template->used_templates;
$exec_time = exec_time();
eval("\$template->tpl_output(\"".$template->tpl("main.htm")."\");");
?>
