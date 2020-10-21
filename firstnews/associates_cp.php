<?php
include "lib/global.php";
$a_password = $_REQUEST["password"];

session_start();
session_name("sid");
$sid = session_id();

if($_REQUEST["id"])
{
  $result = $database->db_query("SELECT * FROM `firstnews_associates` WHERE `id` = $_REQUEST[id]");
  $associate = @mysql_fetch_array($result);
  $count = @mysql_num_rows($result);
}

if($_REQUEST["password"] == $associate["password"] && $count)
{
  session_register("a_password");
  header("Location: associates_cp.php?sid=$sid&id=$_REQUEST[id]&associate=$associate");
}


if($_SESSION["a_password"] == $associate["password"] && $count)
{
  $associate["date"] = date("d.m.Y - H:i:s", $associate["date"]);
  
  switch($_REQUEST["action"])
  {
    case "codegen": $handle = @opendir("images/promotion/");
                    while ($filename = @readdir($handle))
                    {
                      if(eregi("^\.{1,2}$",$filename)) continue;
                      $filesize = round(@filesize("images/promotion/" . $filename) / 1024);
                      $size = GetImageSize ("images/promotion/" . $filename);

                      eval("\$associates_cp_codegen_bit .= \"".$template->tpl("associates_cp_codegen_bit.htm")."\";");
                    }

                    eval("\$main_bit = \"".$template->tpl("associates_cp_codegen.htm")."\";");
    break;

    case "stats": $result = $database->db_query("SELECT * FROM `firstnews_arbitrations` WHERE `associate_id` = $_REQUEST[id] ORDER BY `date` DESC");
                  while($arbitration = @mysql_fetch_array($result))
                  {

                    $arbitration["date"] = date("d.m.Y", $arbitration["date"]);
                    $commission = sprintf("%0.2f", $arbitration["price"] / $options["commission"]);
                    $arbitration["price"] = sprintf("%0.2f", $arbitration["price"]);

                    if($arbitration["payed"])
                    {
                      $arbitration["status"] = date("d.m.Y", $arbitration["payed"]);
                      eval("\$associates_cp_stats_payed_bit = \"".$template->tpl("associates_cp_stats_payed_bit.htm")."\";");

                      if($arbitration["payed_out"])
                      {
                        $arbitration["payed_out_date"] = date("d.m.Y", $arbitration["payed_out"]);
                        eval("\$associates_cp_stats_commision_bit = \"".$template->tpl("associates_cp_stats_commission_payed_bit.htm")."\";");
                      }
                      else
                      {
                        $idle_time = round($options["pay_period"] + (($arbitration["payed"] - time()) / 86400));
                        if($idle_time > 0) eval("\$associates_cp_stats_commision_bit = \"".$template->tpl("associates_cp_stats_commission_wait_bit.htm")."\";");
                        else eval("\$associates_cp_stats_commision_bit = \"".$template->tpl("associates_cp_stats_commission_progress_bit.htm")."\";");
                      }
                    }
                    else
                    {
                      $associates_cp_stats_commision_bit = "";
                      eval("\$associates_cp_stats_payed_bit = \"".$template->tpl("associates_cp_stats_unpayed_bit.htm")."\";");
                    }

                    eval("\$associates_cp_stats_bit .= \"".$template->tpl("associates_cp_stats_bit.htm")."\";");
                  }

                  eval("\$main_bit = \"".$template->tpl("associates_cp_stats.htm")."\";");
    break;
    
    case "faq": eval("\$main_bit = \"".$template->tpl("associates_cp_faq.htm")."\";");
    break;

    case "edit_associate": if($_GET["street"] && $_GET["location"] && $_GET["email"])
                           {
                             $database->db_query("UPDATE `firstnews_associates` SET email = '$_GET[email]', street = '$_GET[street]', location = '$_GET[location]', phonenumber = '$_GET[phonenumber]', account_holder = '$_REQUEST[account_holder]', account_number = '$_REQUEST[account_number]', bank_code_number = '$_REQUEST[bank_code_number]', bank = '$_REQUEST[bank]', iban = '$_REQUEST[iban]', bic = '$_REQUEST[bic]' WHERE id = '$_REQUEST[id]'");
                           }
                           header("Location: associates_cp.php?id=$_REQUEST[id]&sid=$sid&associate=$associate");
    break;

    default: eval("\$main_bit = \"".$template->tpl("associates_cp.htm")."\";");
    break;
  }
  eval("\$associates_cp_nav = \"".$template->tpl("associates_cp_nav.htm")."\";");
}
else
{
  switch($_REQUEST["action"])
  {
    case "forgot_password": include "lib/shop_mail.php";
                            $shop_mail = new shop_mail;

                            if($_REQUEST["email"])
                            {
                              if($associate["email"] == $_REQUEST["email"])
                              {
                                $mail_header = $shop_mail->header();

                                $mail_message = $shop_mail->text_part();
                                eval("\$mail_message .= \"".$template->tpl("mail_associates_cp_text.htm")."\";");
                                $mail_message .= $shop_mail->html_part();
                                eval("\$mail_message .= \"".$template->tpl("mail_associates_cp_html.htm")."\";");

                                mail($associate["email"], "Zugangsdaten zum Mitgliederbereich", $mail_message, $mail_header);

                                eval("\$message = \"".$template->tpl("associates_cp_forgot_password_send_message.htm")."\";");
                              } else eval("\$message = \"".$template->tpl("associates_cp_forgot_password_error_message.htm")."\";");
                            }

                            eval("\$main_bit = \"".$template->tpl("associates_cp_forgot_password.htm")."\";");
    break;

    default: eval("\$main_bit = \"".$template->tpl("associates_cp_login.htm")."\";");
    break;
  }
}

$used_queries = $database->used_queries;
$database->db_close();
//echo $database->error_output();


$used_templates = $template->used_templates;
$exec_time = exec_time();

eval("\$template->tpl_output(\"".$template->tpl("associates_cp_main.htm")."\");");
?>
