<?php
$site = "contact";

include "lib/global.php";
include "lib/functions.php";

//Layout-Ausgaben
shop_box($site);
partner_box($site);
newsletter_box($site);
subnavigation_box($site);
top_navigation();

eval("\$main_webring = \"".$template->tpl("main_webring")."\";");

$upload_max_filesize = get_cfg_var("upload_max_filesize");

if($_REQUEST["send"] == "yes")
{
  if($_REQUEST["email"] && $_REQUEST["subject"] && $_REQUEST["message"])
  {
    include "lib/mail_functions.php";
    $mail = new mail_class;

    @move_uploaded_file($_FILES["attachment"]["tmp_name"], "attachments/" . $_FILES["attachment"]["name"]);
    
    $header = $mail->header($_FILES["attachment"]["name"], $_REQUEST["email"]);
    $body = $mail->message($_FILES["attachment"]["name"], stripslashes($_REQUEST["message"]));
    
    mail("stephan@lan1.lan", stripslashes($_REQUEST["subject"]), $body, $header);

    eval("\$report_message = \"".$template->tpl("contact_success_bit")."\";");
  } else eval("\$report_message = \"".$template->tpl("contact_error_bit")."\";");
}

eval("\$main_content .= \"".$template->tpl("contact")."\";");
eval("\$template->tpl_output(\"".$template->tpl("main")."\");");

$database->db_close();
echo $database->error_output();
?>
