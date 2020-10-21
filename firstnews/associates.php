<?php
include "lib/global.php";
include "lib/shop_mail.php";

$shop_mail = new shop_mail;

switch($_REQUEST["action"])
{
  case "done": $query = $database->db_query("SELECT * FROM firstnews_associates WHERE id = '$_REQUEST[id]'");
               $associate = @mysql_fetch_array($query);
               eval("\$main_bit = \"".$template->tpl("associates_register_done.htm")."\";");
  break;

  case "register_step2": if($_POST["name"] && $_POST["first_name"] && $_POST["street"] && $_POST["location"] && $_POST["email"])
                         {
                           $associates["password"] = password();
                           $date = time();
                           $database->db_query("INSERT INTO firstnews_associates (email, name, first_name, street, location, phonenumber, date, password) VALUES ('$_REQUEST[email]', '$_REQUEST[name]', '$_REQUEST[first_name]', '$_REQUEST[street]', '$_REQUEST[location]', '$_REQUEST[phonenumber]', '$date', '$associates[password]')");

                           $associates["id"] = mysql_insert_id();

                           $mail_header = $shop_mail->header();
                           $mail_message = $shop_mail->text_part();
                           eval("\$mail_message .= \"".$template->tpl("mail_associates_text.htm")."\";");
                           $mail_message .= $shop_mail->html_part();
                           eval("\$mail_message .= \"".$template->tpl("mail_associates_html.htm")."\";");

                           @mail($_POST["email"], "Registrierungsbestätigung", $mail_message, $mail_header);
                           header("Location: associates.php?action=done&id=$associates[id]&associate=$associate");
                         }
                         else eval("\$main_bit = \"".$template->tpl("associates_register_error.htm")."\";");
  break;

  case "register": eval("\$main_bit = \"".$template->tpl("associates_register.htm")."\";");
  break;

  default: eval("\$main_bit = \"".$template->tpl("associates.htm")."\";");
  break;
}

$used_queries = $database->used_queries;
$database->db_close();
echo $database->error_output();

$used_templates = $template->used_templates;
$exec_time = exec_time();
eval("\$template->tpl_output(\"".$template->tpl("main.htm")."\");");
?>
