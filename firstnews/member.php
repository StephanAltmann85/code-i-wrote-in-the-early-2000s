<?php
include "lib/global.php";
$m_password = $_REQUEST["password"];

session_start();
session_name("sid");
$sid = session_id();

if($_REQUEST["id"])
{
  $result = $database->db_query("SELECT * FROM `firstnews_mandates` WHERE `id` = $_REQUEST[id]");
  $client = @mysql_fetch_array($result);
}

if($_REQUEST["password"] == $client["password"] && $client["payed"])
{
  session_register("m_password");
  header("Location: member.php?sid=$sid&id=$_REQUEST[id]&associate=$associate");
}


if($_SESSION["m_password"] == $client["password"] && $client["payed"])
{

  switch($_REQUEST["action"])
  {
    case "download": $query_product = $database->db_query("SELECT * from firstnews_products WHERE id = $_GET[productid]");
                     $product = mysql_fetch_array($query_product);

                     $filename = $product["member_download_url"];
                     $save_as = basename($filename);

                     $file = @fopen($filename, 'r');
                     header("Content-Type: application/octet-stream");
                     header("Content-Disposition: attachment; filename=$save_as");
                     header("Content-Description: PHP4 Generated Data");
                     header("Pragma: no-cache");
                     header("Expires: 0");
                     fpassthru($file);
                     fclose($file);
    break;

    case "edit_client": if($_GET["street"] && $_GET["location"] && $_GET["email"])
                        {
                          $database->db_query("UPDATE `firstnews_mandates` SET email = '$_GET[email]', street = '$_GET[street]', location = '$_GET[location]', phonenumber = '$_GET[phonenumber]' WHERE id = '$_GET[id]'");
                        }
                        header("Location: member.php?id=$_GET[id]&sid=$sid&associate=$associate");
    break;

    case "delete_board_access": $result = $database->db_query("SELECT board_user_id FROM `firstnews_mandates` WHERE id = '$_GET[id]'");

                                $user_information = @mysql_fetch_array($result);

                                if($user_information["board_user_id"])
                                {
                                  $database->db_query("UPDATE `bb" . $options["board_prefix"] . "_users` SET useronlinegroupid = $options[default_group], rankgroupid = $options[default_group], groupcombinationid = 1 WHERE userid = '$user_information[board_user_id]'");

                                  $database->db_query("UPDATE `firstnews_mandates` SET board_user_id = '' WHERE id = '$_GET[id]'");
                                }
                                header("Location: member.php?id=$_GET[id]&sid=$sid&associate=$associate");
    break;

    case "edit_client_set_username": $result = $database->db_query("SELECT userid, useronlinegroupid, groupcombinationid, rankgroupid FROM `bb" . $options["board_prefix"] . "_users` WHERE username = '$_GET[board_name]'");
                                     $user_information = @mysql_fetch_array($result);

                                     if($user_information["userid"] && $user_information["useronlinegroupid"] == $options["default_group"] && $user_information["groupcombinationid"] == 1 && $user_information["rankgroupid"] == $options["default_group"])
                                     {
                                       $database->db_query("UPDATE `bb" . $options["board_prefix"] . "_users` SET useronlinegroupid = $options[mandate_group], rankgroupid = $options[mandate_group], groupcombinationid = 5 WHERE userid = '$user_information[userid]'");

                                       $database->db_query("UPDATE `firstnews_mandates` SET board_user_id = $user_information[userid] WHERE id = '$_GET[id]'");
                                     }
                                     header("Location: member.php?id=$_GET[id]&sid=$sid&associate=$associate");
    break;

    case "update_licences_url":  $database->db_query("UPDATE `firstnews_mandates` SET licences_url = '$_GET[licences_url]' WHERE id = '$client[id]'");

                                 header("Location: member.php?id=$_GET[id]&sid=$sid&associate=$associate");
    break;

    default: $client["date"] = date("d.m.Y - H:i:s", $client["date"]);

            $i = 0;

            $licences_lines = split("\r\n", $client["licences"]);
            foreach($licences_lines as $line)
            {
              $product = split("-", $line);
              $licences[$product[0]] = $product[1];
            }

            $total_price = 0;

            $query = $database->db_query("SELECT id from firstnews_products WHERE price > 0 ORDER BY sort ASC");

            while($row = @mysql_fetch_array($query))
            {
              if($licences[$row["id"]])
              {
                $query_product = $database->db_query("SELECT * from firstnews_products WHERE id = $row[id]");
                $product_quantity = $licences[$row["id"]];
                $product = @mysql_fetch_array($query_product);
                if($product["board_access"] && $product_quantity > 0) $allow_board_access = 1;
                $product_total_price = sprintf("%0.2f", $product_quantity * $product["price"]);
                $total_price = $total_price + $product_total_price;

                $product_discount = 0;

                if($product_quantity >= $product["discount_mark_1"]) $product_discount = $product["discount_rate_1"];
                if($product_quantity >= $product["discount_mark_2"]) $product_discount = $product["discount_rate_2"];
                if($product_quantity >= $product["discount_mark_3"]) $product_discount = $product["discount_rate_3"];

                $product_total_discount = sprintf("%0.2f", $product_quantity *                                $product["price"] / 100 * $product_discount);
                $total_discount = $total_discount + $product_total_discount;

                eval("\$member_products .= \"".$template->tpl("member_products.htm")."\";");
                if($product["member_download_url"]) eval("\$member_downloads .= \"".$template->tpl("member_downloads.htm")."\";");
              }
            }
            
            if($client[board_user_id])
            {
              $result = $database->db_query("SELECT username FROM `bb" . $options["board_prefix"] . "_users` WHERE `userid` = $client[board_user_id]");
              $board = @mysql_fetch_array($result);
              eval("\$board_username = \"".$template->tpl("member_boardname.htm")."\";");
            }
            else
            {
              if($allow_board_access) eval("\$board_username = \"".$template->tpl("member_set_boardname.htm")."\";");
            }
            
            $total_price = sprintf("%0.2f", $total_price);
            $total_discount = sprintf("%0.2f", $total_discount);
            $final_price = sprintf("%0.2f", $total_price - $total_discount);

            eval("\$main_bit = \"".$template->tpl("member.htm")."\";");
    break;
  }
  eval("\$member_logout = \"".$template->tpl("member_logout.htm")."\";");
}
else
{
  switch($_REQUEST["action"])
  {
    case "forgot_password": include "lib/shop_mail.php";
                            $shop_mail = new shop_mail;

                            if($_REQUEST["email"])
                            {
                              if($client["email"] == $_REQUEST["email"])
                              {
                                $mail_header = $shop_mail->header();

                                $mail_message = $shop_mail->text_part();
                                eval("\$mail_message .= \"".$template->tpl("member_mail_text.htm")."\";");
                                $mail_message .= $shop_mail->html_part();
                                eval("\$mail_message .= \"".$template->tpl("member_mail_html.htm")."\";");

                                mail($client["email"], "Zugangsdaten zum Mitgliederbereich", $mail_message, $mail_header);

                                eval("\$message = \"".$template->tpl("member_forgot_password_send_message.htm")."\";");
                              } else eval("\$message = \"".$template->tpl("member_forgot_password_error_message.htm")."\";");
                            }

    eval("\$main_bit = \"".$template->tpl("member_forgot_password.htm")."\";");
    break;

    default: eval("\$main_bit = \"".$template->tpl("member_login.htm")."\";");
    break;
  }
}

$used_queries = $database->used_queries;
$database->db_close();
//echo $database->error_output();


$used_templates = $template->used_templates;
$exec_time = exec_time();

eval("\$template->tpl_output(\"".$template->tpl("member_main.htm")."\");");
?>
