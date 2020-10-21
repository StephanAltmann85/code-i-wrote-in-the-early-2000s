<?php
include "lib/global.php";
include "lib/shop_mail.php";

$shop_mail = new shop_mail;

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
   eval("\$mail_text_bit .= \"".$template->tpl("mail_text_bit.htm")."\";");
   eval("\$mail_html_bit .= \"".$template->tpl("mail_html_bit.htm")."\";");
 }
}
$total_price = sprintf("%0.2f", $total_price);
$total_discount = sprintf("%0.2f", $total_discount);
$final_price = sprintf("%0.2f", $total_price - $total_discount);

$query = $database->db_query("SELECT id from firstnews_products WHERE price > 0 ORDER BY sort ASC");

while($row = @mysql_fetch_array($query))
{
  $product_quantity = $_POST[$row["id"]];
  $licences .= $row["id"] . "-" . $_POST[$row["id"]] . "\r\n";
  eval("\$subscription_hidden .= \"".$template->tpl("subscription_hidden.htm")."\";");
}

if($_GET["action"] != done)
{
  if($_POST["name"] && $_POST["first_name"] && $_POST["street"] && $_POST["location"] && $_POST["email"] && $total_price > 0)
  {
    $date = time();
    $subscription_number = mysql_fetch_array($database->db_query("SHOW TABLE STATUS LIKE 'firstnews_mandates'"));
    $insert = $database->db_query("INSERT INTO firstnews_mandates (email, name, first_name, street, location, phonenumber, licences, date) VALUES ('$_POST[email]', '$_POST[name]', '$_POST[first_name]', '$_POST[street]', '$_POST[location]', '$_POST[phonenumber]', '$licences', '$date')");

    $mandate_id = @mysql_insert_id();
    if($_REQUEST["associate"]) $database->db_query("INSERT INTO firstnews_arbitrations (mandate_id, associate_id, price, date) VALUES ('$mandate_id', '$_REQUEST[associate]', '$final_price', '$date')");

    $mail_header = $shop_mail->header();

    $mail_message = $shop_mail->text_part();
    eval("\$mail_message .= \"".$template->tpl("mail_text.htm")."\";");
    $mail_message .= $shop_mail->html_part();
    eval("\$mail_message .= \"".$template->tpl("mail_html.htm")."\";");

    mail($_POST["email"], "Ihre Bestellung", $mail_message, $mail_header);

    header("Location: subscription_done.php?action=done&email=$_POST[email]&subscription_number=$subscription_number[Auto_increment]&associate=$associate");
  } else eval("\$main_bit = \"".$template->tpl("subscription_error.htm")."\";");
}
else eval("\$main_bit = \"".$template->tpl("subscription_done.htm")."\";");


$used_queries = $database->used_queries;
$database->db_close();
echo $database->error_output();

$used_templates = $template->used_templates;
$exec_time = exec_time();
eval("\$template->tpl_output(\"".$template->tpl("main.htm")."\");");
?>
