<?php
include "lib/global.php";
$password = $_POST["password"];

session_start();
session_name("sid");
$sid = session_id();

if($_POST["password"] == $options["password"] && $options["password"] != "")
{
  session_register("password");
  header("Location: index.php?sid=$sid");
}

if($_SESSION["password"] == $options["password"])
{
  switch($_REQUEST["action"])
  {
    case "update_options": $database->db_query("UPDATE `firstnews_options` SET board_path = '$_GET[board_path]', board_images_path = '$_GET[board_images_path]', forum_id = '$_GET[forum_id]', board_prefix = '$_GET[board_prefix]', currency = '$_GET[currency]', receiver = '$_GET[receiver]', account_number = '$_GET[account_number]', bank_number = '$_GET[bank_number]', bank = '$_GET[bank]', webmaster_mail = '$_GET[webmaster_mail]', password = '$_GET[password]', default_group = '$_GET[default_group]', mandate_group = '$_GET[mandate_group]', url = '$_GET[url]', pay_period = '$_GET[pay_period]', commission = '$_GET[commission]' WHERE id = $_GET[id]");
                           header("Location: index.php?action=options&sid=$sid");
    break;
    
    case "promotion": if($_REQUEST["upload"] == 1) move_uploaded_file($_FILES['attachment_file']['tmp_name'], "../images/promotion/" . $_FILES['attachment_file']['name']);
                      if($_REQUEST["del"]) @unlink("../images/promotion/" . $_REQUEST["del"]);

                      $handle = @opendir("../images/promotion/");
                      while ($filename = @readdir($handle))
                      {
                        if(eregi("^\.{1,2}$",$filename)) continue;
                        $filesize = round(@filesize("../images/promotion/" . $filename) / 1024);
                        $size = GetImageSize ("../images/promotion/" . $filename);

                        eval("\$advertisement_images_bit .= \"".$template->tpl("advertisement_images_bit.htm")."\";");
                      }

                      eval("\$main_bit = \"".$template->tpl("advertisement_images.htm")."\";");
    break;

    case "arbitration_set_payed_out": $payed_out_date = time();
                                      $database->db_query("UPDATE `firstnews_arbitrations` SET payed_out = '$payed_out_date' WHERE id = $_GET[id]");
                                      header("Location: index.php?action=arbitration_stats&sid=$sid");
    break;

    case "arbitration_stats": if(!$_REQUEST["sort"]) $_REQUEST["sort"] = "date";
                              if(!$_REQUEST["sort_direction"]) $_REQUEST["sort_direction"] = "desc";

                              if(!$_REQUEST["search"]) $result = $database->db_query("SELECT * FROM `firstnews_arbitrations` ORDER BY `$_REQUEST[sort]` $_REQUEST[sort_direction]");
                              if($_REQUEST["search"] == "unpayed") $result = $database->db_query("SELECT * FROM `firstnews_arbitrations` WHERE payed = 0 ORDER BY `$_REQUEST[sort]` $_REQUEST[sort_direction]");
                              if($_REQUEST["search"] == "waiting") $result = $database->db_query("SELECT * FROM `firstnews_arbitrations` WHERE payed > 0 AND payed_out = 0 ORDER BY `$_REQUEST[sort]` $_REQUEST[sort_direction]");
                              if($_REQUEST["search"] == "payed_out") $result = $database->db_query("SELECT * FROM `firstnews_arbitrations` WHERE payed_out > 0 ORDER BY `$_REQUEST[sort]` $_REQUEST[sort_direction]");
                              if($_REQUEST["search"] == "id") $result = $database->db_query("SELECT * FROM `firstnews_arbitrations` WHERE associate_id = '$_REQUEST[associate_id]' ORDER BY `$_REQUEST[sort]` $_REQUEST[sort_direction]");

                              while($arbitration = @mysql_fetch_array($result))
                              {
                                $arbitration["date"] = date("d.m.Y", $arbitration["date"]);
                                $commission = sprintf("%0.2f", $arbitration["price"] / $options["commission"]);
                                $arbitration["price"] = sprintf("%0.2f", $arbitration["price"]);
                                if(!$arbitration["payed_out"]) eval("\$arbitration_stats_set_payed_out_bit = \"".$template->tpl("arbitration_stats_set_payed_out_bit.htm")."\";");

                                if($arbitration["payed"])
                                {
                                  $arbitration["status"] = date("d.m.Y", $arbitration["payed"]);
                                  eval("\$arbitration_stats_payed_bit = \"".$template->tpl("arbitration_stats_payed_bit.htm")."\";");

                                  if($arbitration["payed_out"])
                                  {
                                    $arbitration["payed_out_date"] = date("d.m.Y", $arbitration["payed_out"]);
                                    eval("\$arbitration_stats_commision_bit = \"".$template->tpl("arbitration_stats_commission_payed_bit.htm")."\";");
                                  }
                                  else
                                  {
                                    $idle_time = round($options["pay_period"] + (($arbitration["payed"] - time()) / 86400));
                                    if($idle_time > 0) eval("\$arbitration_stats_commision_bit = \"".$template->tpl("arbitration_stats_commission_wait_bit.htm")."\";");
                                    else eval("\$arbitration_stats_commision_bit = \"".$template->tpl("arbitration_stats_commission_progress_bit.htm")."\";");
                                  }
                                }
                                else
                                {
                                  $arbitration_stats_commision_bit = "";
                                  eval("\$arbitration_stats_payed_bit = \"".$template->tpl("arbitration_stats_unpayed_bit.htm")."\";");
                                }
                                eval("\$arbitration_stats_bit .= \"".$template->tpl("arbitration_stats_bit.htm")."\";");
                              }

                              eval("\$main_bit = \"".$template->tpl("arbitration_stats.htm")."\";");
    break;

    case "del_associate": $database->db_query("DELETE FROM firstnews_associates WHERE id = $_GET[id]");
                          header("Location: index.php?action=associates&sid=$sid");
    break;
    
    case "edit_associate": if($_GET["name"] && $_GET["first_name"] && $_GET["street"] && $_GET["location"] && $_GET["email"])
                           {
                             $database->db_query("UPDATE `firstnews_associates` SET name = '$_GET[name]', first_name = '$_GET[first_name]', email = '$_GET[email]', street = '$_GET[street]', location = '$_GET[location]', phonenumber = '$_GET[phonenumber]', account_holder = '$_GET[account_holder]', account_number = '$_GET[account_number]', bank_code_number = '$_GET[bank_code_number]', bank = '$_GET[bank]', iban = '$_GET[iban]', bic = '$_GET[bic]' WHERE id = '$_GET[id]'");
                           }

                           $result = $database->db_query("SELECT * FROM `firstnews_associates` WHERE `id` = $_GET[id]");
                           $associate = @mysql_fetch_array($result);
                           $associate["date"] = date("d.m.Y - H:i:s", $associate["date"]);

                           eval("\$main_bit = \"".$template->tpl("edit_associate.htm")."\";");
    break;

    case "associates": $result = $database->db_query("SELECT * FROM `firstnews_associates`");

                       while($associate = @mysql_fetch_array($result))
                       {
                         $associate["date"] = date("d.m.Y - H:i:s", $associate["date"]);
                         eval("\$associates_bit .= \"".$template->tpl("associates_bit.htm")."\";");
                       }

                       eval("\$main_bit = \"".$template->tpl("associates.htm")."\";");
    break;

    case "options": $result = $database->db_query("SELECT groupid, title FROM `bb" . $options["board_prefix"] . "_groups`");

                    while($groups = @mysql_fetch_array($result))
                    {
                      if($options["default_group"] == $groups["groupid"]) $selected = "selected";

                      eval("\$groups_default_list .= \"".$template->tpl("groups_list.htm")."\";");

                      unset($selected);

                      if($options["mandate_group"] == $groups["groupid"]) $selected = "selected";
                      eval("\$groups_mandate_list .= \"".$template->tpl("groups_list.htm")."\";");

                      unset($selected);
                    }

                    $result = $database->db_query("SELECT boardid, title FROM `bb" . $options["board_prefix"] . "_boards` WHERE isboard = 1");

                    while($boards = @mysql_fetch_array($result))
                    {
                      if($options["forum_id"] == $boards["boardid"]) $selected = "selected";

                      eval("\$boards_list .= \"".$template->tpl("boards_list.htm")."\";");

                      unset($selected);
                    }

                    eval("\$main_bit .= \"".$template->tpl("options.htm")."\";");
    break;

    case "update_link": $database->db_query("UPDATE `firstnews_links` SET url = '$_GET[url]', text = '$_GET[text]', graphic_source = '$_GET[graphic_source]', partner = '$_GET[partner]' WHERE id = '$_GET[id]'");
                        header("Location: index.php?action=edit_links&sid=$sid");
    break;

    case "edit_link": $partner_sites = $database->db_query("SELECT * FROM firstnews_links WHERE id = $_GET[id]");

                       $link = @mysql_fetch_array($partner_sites);
                       if($link["partner"]) $selected = "selected";

                       eval("\$main_bit .= \"".$template->tpl("edit_link.htm")."\";");
    break;

    case "delete_link": $database->db_query("DELETE FROM firstnews_links WHERE id = $_GET[id]");

                        header("Location: index.php?action=edit_links&sid=$sid");
    break;

    case "insert_link": $database->db_query("INSERT INTO firstnews_links (url, text, graphic_source, partner) VALUES ('$_GET[url]', '$_GET[text]', '$_GET[graphic_source]', '$_GET[partner]')");

                        header("Location: index.php?action=edit_links&sid=$sid");
    break;

    case "edit_links": $voting_sites = $database->db_query("SELECT * FROM firstnews_links WHERE partner = 0");

                       while($link = @mysql_fetch_array($voting_sites))
                       {
                         if($link["graphic_source"])
                         {
                           if (!strspn($link["graphic_source"], "http://")) $link["graphic_source"] = "../" . $link["graphic_source"];
                           eval("\$links_graphic_bit = \"".$template->tpl("links_graphic_bit.htm")."\";");
                         }

                         eval("\$voting_sites_list .= \"".$template->tpl("links_list_bit.htm")."\";");

                         unset($links_graphic_bit);
                       }

                       $partner_sites = $database->db_query("SELECT * FROM firstnews_links WHERE partner = 1 ORDER BY graphic_source ASC");

                       while($link = @mysql_fetch_array($partner_sites))
                       {
                         if($link["graphic_source"])
                         {
                           if(!strspn($link["graphic_source"], "http://")) $link["graphic_source"] = "../" . $link["graphic_source"];
                           eval("\$links_graphic_bit = \"".$template->tpl("links_graphic_bit.htm")."\";");
                         }

                         eval("\$partner_sites_list .= \"".$template->tpl("links_list_bit.htm")."\";");

                         unset($links_graphic_bit);
                       }

                       eval("\$main_bit = \"".$template->tpl("links.htm")."\";");
    break;

    case "delete_product": $database->db_query("DELETE FROM firstnews_products WHERE id = $_GET[id]");
                           header("Location: index.php?action=list_products&sid=$sid");
    break;

    case "insert_product": $database->db_query("INSERT INTO firstnews_products (name, description, short_description, price, member_download_url, language, download, info_box, sort, board_access, discount_mark_1, discount_rate_1, discount_mark_2, discount_rate_2, discount_mark_3, discount_rate_3) VALUES ('$_POST[name]', '$_POST[description]', '$_POST[short_description]', '$_POST[price]', '$_POST[member_download_url]', '$_POST[language]', '$_POST[download]', '$_POST[info_box]', '$_POST[sort]', '$_POST[board_access]', '$_POST[discount_mark_1]', '$_POST[discount_rate_1]', '$_POST[discount_mark_2]', '$_POST[discount_rate_2]', '$_POST[discount_mark_3]', '$_POST[discount_rate_3]')");

                           $id = mysql_insert_id();
                           header("Location: index.php?action=edit_product&id=$id&sid=$sid");
    break;

    case "add_product": $query_products = $database->db_query("SELECT id from firstnews_products");

                         $i = 1;
                         while($i <= mysql_num_rows($query_products) + 1)
                         {
                           eval("\$product_sort_bit .= \"".$template->tpl("product_sort_bit.htm")."\";");
                           $i++;
                         }

                         eval("\$products_edit_add = \"".$template->tpl("add_product.htm")."\";");

                         eval("\$main_bit = \"".$template->tpl("products.htm")."\";");
    break;

    case "update_product": $database->db_query("UPDATE `firstnews_products` SET name = '$_POST[name]', description = '$_POST[description]', short_description = '$_POST[short_description]', price = '$_POST[price]', member_download_url = '$_POST[member_download_url]', language = '$_POST[language]', download = '$_POST[download]', info_box = '$_POST[info_box]', sort = '$_POST[sort]', board_access = '$_REQUEST[board_access]', discount_mark_1 = '$_POST[discount_mark_1]', discount_mark_2 = '$_POST[discount_mark_2]', discount_mark_3 = '$_POST[discount_mark_3]', discount_rate_1 = '$_POST[discount_rate_1]', discount_rate_2 = '$_POST[discount_rate_2]', discount_rate_3 = '$_POST[discount_rate_3]' WHERE id = '$_POST[id]'");

                           header("Location: index.php?action=edit_product&id=$_POST[id]&sid=$sid");
    break;

    case "edit_product": $query_product = $database->db_query("SELECT * from firstnews_products WHERE id = $_GET[id]");
                         $product = @mysql_fetch_array($query_product);

                         $query_products = $database->db_query("SELECT id from firstnews_products");

                         $i = 1;
                         while($i <= mysql_num_rows($query_products))
                         {
                           if($product["sort"] == $i) $selected = "selected";
                           else unset($selected);

                           eval("\$product_sort_bit .= \"".$template->tpl("product_sort_bit.htm")."\";");
                           $i++;
                         }
                         if(!$product["board_access"]) $board_access = "selected";
                         eval("\$products_edit_add = \"".$template->tpl("edit_product.htm")."\";");

                         eval("\$main_bit = \"".$template->tpl("products.htm")."\";");
    break;

    case "list_products": $query = $database->db_query("SELECT id, name, price, language, discount_mark_1, discount_rate_1, discount_mark_2, discount_rate_2, discount_mark_3, discount_rate_3 FROM firstnews_products ORDER BY sort ASC");

                          while($product = @mysql_fetch_array($query))
                          {
                            $discount_1 = sprintf("%0.2f", round($product["price"] / 100 * $product["discount_rate_1"], 2));
                            $discount_2 = sprintf("%0.2f", round($product["price"] / 100 * $product["discount_rate_2"], 2));
                            $discount_3 = sprintf("%0.2f", round($product["price"] / 100 * $product["discount_rate_3"], 2));

                            eval("\$products_list .= \"".$template->tpl("products_list.htm")."\";");
                          }
                          eval("\$main_bit = \"".$template->tpl("products.htm")."\";");
    break;

    case "set_password": include "lib/acp_mail.php";
                         $acp_mail = new acp_mail;

                         $client = $database->db_query("SELECT email, name FROM `firstnews_mandates` WHERE id = '$_GET[id]'");
                         $client = @mysql_fetch_array($client);

                         $user_password = password();
                         $database->db_query("UPDATE `firstnews_mandates` SET password = '$user_password' WHERE id = '$_GET[id]'");

                         $mail_header = $acp_mail->header();

                         $mail_message = $acp_mail->text_part();
                         eval("\$mail_message .= \"".$template->tpl("mail_text.htm")."\";");
                         $mail_message .= $acp_mail->html_part();
                         eval("\$mail_message .= \"".$template->tpl("mail_html.htm")."\";");

                         mail($client["email"], "Zugangsdaten zum Mitgliederbereich", $mail_message, $mail_header);

                         header("Location: index.php?action=edit_client&id=$_GET[id]&sid=$sid");
    break;

    case "update_licences_url":  $database->db_query("UPDATE `firstnews_mandates` SET licences_url = '$_GET[licences_url]' WHERE id = '$_GET[id]'");

                                 header("Location: index.php?action=edit_client&id=$_GET[id]&sid=$sid");
    break;

    case "delete_board_access": $result = $database->db_query("SELECT board_user_id FROM `firstnews_mandates` WHERE id = '$_GET[id]'");

                                $user_information = @mysql_fetch_array($result);

                                if($user_information["board_user_id"])
                                {
                                  $database->db_query("UPDATE `bb" . $options["board_prefix"] . "_users` SET groupid = $options[default_group] WHERE userid = '$user_information[board_user_id]'");

                                  $database->db_query("UPDATE `firstnews_mandates` SET board_user_id = '' WHERE id = '$_GET[id]'");
                                }
                                header("Location: index.php?action=edit_client&id=$_GET[id]&sid=$sid");
    break;

    case "edit_client_set_username": $result = $database->db_query("SELECT userid, groupid FROM `bb" . $options["board_prefix"] . "_users` WHERE username = '$_GET[board_name]'");
                                     $user_information = @mysql_fetch_array($result);

                                     if($user_information["userid"] && $user_information["groupid"] == $options["default_group"])
                                     {
                                       $database->db_query("UPDATE `bb" . $options["board_prefix"] . "_users` SET groupid = $options[mandate_group] WHERE userid = '$user_information[userid]'");

                                       $database->db_query("UPDATE `firstnews_mandates` SET board_user_id = $user_information[userid] WHERE id = '$_GET[id]'");
                                     }
                                     header("Location: index.php?action=edit_client&id=$_GET[id]&sid=$sid");
    break;

    case "update_licences": $query = $database->db_query("SELECT id from firstnews_products WHERE price > 0 ORDER BY sort ASC");

                            while($row = @mysql_fetch_array($query))
                            {
                              $licences .= $row["id"] . "-" . $_GET[$row["id"]] . "\r\n";
                            }

                            $database->db_query("UPDATE `firstnews_mandates` SET licences = '$licences' WHERE id = '$_GET[id]'");

                            header("Location: index.php?action=edit_client&id=$_GET[id]&sid=$sid&temp_price=$_GET[temp_price]");
    break;

    case "delete_account": $database->db_query("DELETE FROM `firstnews_mandates` WHERE id = '$_GET[id]'");
                           $database->db_query("DELETE FROM `firstnews_arbitrations` WHERE mandate_id = '$_GET[id]'");
                           header("Location: index.php?action=list_all_clients&sid=$sid");
    break;

    case "activate_account": $query = $database->db_query("SELECT a.id, a.payed, b.licences FROM `firstnews_arbitrations` a LEFT JOIN `firstnews_mandates` b ON a.mandate_id = b.id WHERE `mandate_id` = '$_REQUEST[id]'");
                             $arbitrations = @mysql_fetch_array($query);
                             
                             if($arbitrations["id"] && !$arbitrations["payed"])
                             {
                               $total_price = 0;
                               $date = time();
                               $licences_lines = split("\r\n", $arbitrations["licences"]);

                               foreach($licences_lines as $line)
                               {
                                 $product = split("-", $line);
                                 $licences[$product[0]] = $product[1];
                               }

                               $query = $database->db_query("SELECT id from firstnews_products WHERE price > 0 ORDER BY sort ASC");
                               while($row = @mysql_fetch_array($query))
                               {
                                 if($licences[$row["id"]])
                                 {
                                   $query_product = $database->db_query("SELECT name, price, discount_mark_1, discount_rate_1, discount_mark_2, discount_rate_2, discount_mark_3, discount_rate_3 from firstnews_products WHERE id = $row[id]");
                                   $product_quantity = $licences[$row["id"]];
                                   $product = @mysql_fetch_array($query_product);
                                   $product_total_price = sprintf("%0.2f", $product_quantity * $product["price"]);
                                   $total_price = $total_price + $product_total_price;
                                   $product_discount = 0;

                                   if($product_quantity >= $product["discount_mark_1"]) $product_discount = $product["discount_rate_1"];
                                   if($product_quantity >= $product["discount_mark_2"]) $product_discount = $product["discount_rate_2"];
                                   if($product_quantity >= $product["discount_mark_3"]) $product_discount = $product["discount_rate_3"];

                                   $product_total_discount = sprintf("%0.2f", $product_quantity * $product["price"] / 100 * $product_discount);
                                   $total_discount = $total_discount + $product_total_discount;
                                 }
                               }
                               $total_price = sprintf("%0.2f", $total_price);
                               $total_discount = sprintf("%0.2f", $total_discount);
                               $final_price = sprintf("%0.2f", $total_price - $total_discount);

                               $database->db_query("UPDATE `firstnews_arbitrations` SET payed = $date, price = $final_price WHERE mandate_id = '$_REQUEST[id]'");
                             }

                             $database->db_query("UPDATE `firstnews_mandates` SET payed = 1 WHERE id = '$_REQUEST[id]'");
                             header("Location: index.php?action=edit_client&id=$_GET[id]&sid=$sid");
    break;

    case "lock_account": $database->db_query("UPDATE `firstnews_mandates` SET payed = 0 WHERE id = '$_GET[id]'");
                         header("Location: index.php?action=edit_client&id=$_GET[id]&sid=$sid");
    break;

    case "edit_client": if($_GET["name"] && $_GET["first_name"] && $_GET["street"] && $_GET["location"] && $_GET["email"])
                        {
                          $database->db_query("UPDATE `firstnews_mandates` SET name = '$_GET[name]', first_name = '$_GET[first_name]', email = '$_GET[email]', street = '$_GET[street]', location = '$_GET[location]', phonenumber = '$_GET[phonenumber]' WHERE id = '$_GET[id]'");
                        }

                        $result = $database->db_query("SELECT * FROM `firstnews_mandates` WHERE `id` = $_GET[id]");

                        $client = @mysql_fetch_array($result);
                        $client["date"] = date("d.m.Y - H:i:s", $client["date"]);
                        if($client["payed"]) eval("\$edit_client_bit = \"".$template->tpl("edit_client_lock.htm")."\";");
                        else eval("\$edit_client_bit = \"".$template->tpl("edit_client_activate.htm")."\";");

                        if($client[board_user_id])
                        {
                          $result = $database->db_query("SELECT username FROM `bb" . $options["board_prefix"] . "_users` WHERE `userid` = $client[board_user_id]");
                          $board = @mysql_fetch_array($result);
                          //$board_username = $board["username"];
                          eval("\$board_username = \"".$template->tpl("edit_client_username.htm")."\";");


                        } else eval("\$board_username = \"".$template->tpl("edit_client_set_username.htm")."\";");

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
                            $query_product = $database->db_query("SELECT name, price, discount_mark_1, discount_rate_1, discount_mark_2, discount_rate_2, discount_mark_3, discount_rate_3 from firstnews_products WHERE id = $row[id]");
                            $product_quantity = $licences[$row["id"]];
                            $product = @mysql_fetch_array($query_product);
                            $product_total_price = sprintf("%0.2f", $product_quantity * $product["price"]);
                            $total_price = $total_price + $product_total_price;

                            $product_discount = 0;

                            if($product_quantity >= $product["discount_mark_1"]) $product_discount = $product["discount_rate_1"];
                            if($product_quantity >= $product["discount_mark_2"]) $product_discount = $product["discount_rate_2"];
                            if($product_quantity >= $product["discount_mark_3"]) $product_discount = $product["discount_rate_3"];

                            $product_total_discount = sprintf("%0.2f", $product_quantity *                                $product["price"] / 100 * $product_discount);
                            $total_discount = $total_discount + $product_total_discount;

                            eval("\$edit_client_products .= \"".$template->tpl("edit_client_products.htm")."\";");
                          }
                        }
                        $total_price = sprintf("%0.2f", $total_price);
                        $total_discount = sprintf("%0.2f", $total_discount);
                        $final_price = sprintf("%0.2f", $total_price - $total_discount);

                        if($_GET["temp_price"]) $difference = sprintf("%0.2f", $final_price - $_GET["temp_price"]);
                        else $difference = sprintf("%0.2f", $_GET["temp_price"]);

                        $query = $database->db_query("SELECT id, name, price, language, discount_mark_1, discount_rate_1, discount_mark_2, discount_rate_2, discount_mark_3, discount_rate_3 FROM firstnews_products  WHERE price > 0 ORDER BY sort ASC");

                        while($product = @mysql_fetch_array($query))
                        {
                          $discount_1 = sprintf("%0.2f", round($product["price"] / 100 * $product["discount_rate_1"], 2));
                          $discount_2 = sprintf("%0.2f", round($product["price"] / 100 * $product["discount_rate_2"], 2));
                          $discount_3 = sprintf("%0.2f", round($product["price"] / 100 * $product["discount_rate_3"], 2));

                          eval("\$subscription_list .= \"".$template->tpl("subscription_list.htm")."\";");
                        }

                        eval("\$main_bit = \"".$template->tpl("edit_client.htm")."\";");
    break;

    case "add_client": if($_GET["name"] && $_GET["first_name"] && $_GET["street"] && $_GET["location"] && $_GET["email"])
                       {
                         $date = time();
                         $database->db_query("INSERT INTO firstnews_mandates (email, name, first_name, street, location, phonenumber, date) VALUES ('$_GET[email]', '$_GET[name]', '$_GET[first_name]', '$_GET[street]', '$_GET[location]', '$_GET[phonenumber]', '$date')");
                         header("Location: index.php?sid=$sid&action=search_clients&row=name&order=asc&criterion=$_GET[name]");
                       }
                       eval("\$main_bit = \"".$template->tpl("add_client.htm")."\";");
    break;

    case "search_clients": eval("\$clients_search_bit = \"".$template->tpl("clients_search_bit.htm")."\";");

                           if($_GET["row"] && $_GET["criterion"] && $_GET["order"])
                           {
                             $result = $database->db_query("SELECT * FROM `firstnews_mandates` WHERE `$_GET[row]` LIKE '$_GET[criterion]' ORDER by `$_GET[row]` $_GET[order]");

                              while($client = @mysql_fetch_array($result))
                              {
                                $client["date"] = date("d.m.Y - H:i:s", $client["date"]);
                                eval("\$clients_bit .= \"".$template->tpl("clients_bit.htm")."\";");
                              }
                           }
                           else eval("\$clients_bit = \"".$template->tpl("clients_no_search.htm")."\";");

                           eval("\$main_bit = \"".$template->tpl("clients.htm")."\";");
    break;

    case "list_all_clients": $result = $database->db_query("SELECT * FROM `firstnews_mandates`");

                             while($client = @mysql_fetch_array($result))
                             {
                               $client["date"] = date("d.m.Y - H:i:s", $client["date"]);
                               eval("\$clients_bit .= \"".$template->tpl("clients_bit.htm")."\";");
                             }

                             eval("\$main_bit = \"".$template->tpl("clients.htm")."\";");
    break;

    default: $products_count = @mysql_fetch_row($database->db_query("SELECT Count(id) FROM `firstnews_products` WHERE price > 0"));

             $mandates_count = @mysql_fetch_row($database->db_query("SELECT Count(id) FROM `firstnews_mandates`"));

             $unpayed_count = @mysql_fetch_row($database->db_query("SELECT Count(id) FROM `firstnews_mandates` WHERE payed = 0"));

             eval("\$main_bit = \"".$template->tpl("default.htm")."\";");
    break;
  }


  $used_queries = $database->used_queries;
  $database->db_close();
  echo $database->error_output();

  $used_templates = $template->used_templates;
  $exec_time = exec_time();

  eval("\$template->tpl_output(\"".$template->tpl("main.htm")."\");");
}
else eval("\$template->tpl_output(\"".$template->tpl("login.htm")."\");");
?>
