<?
include("lib/global.php");

$login = md5($_REQUEST["login"]);
$sid = $_REQUEST["sid"];

session_start();
session_name("sid");
$sid = session_id();
$time = time();

if($login == $options["password"])
{
  session_register("login");
  header("Location: index.php?sid=$sid");
}

if($_SESSION["login"] == $options["password"])
{
  switch($_REQUEST["action"])
  {
    case "cat_edit": if($_REQUEST["update"] == "yes")
                     {
                       if($_REQUEST["title"])
                       {
                         if($_REQUEST["subcat"] == 0) $_REQUEST["maincat"] = 0;
                         $database->db_query("UPDATE `hp" . $sql_prefix . "_cats` SET `title` = '$_REQUEST[title]', `description` = '$_REQUEST[textarea]', `styleid` = '$_REQUEST[styleid]', `top_image` = '$_REQUEST[top_image]', `style` = '$_REQUEST[style]', `subcat` = '$_REQUEST[subcat]', `maincat` = '$_REQUEST[maincat]' WHERE `catid` = '$_REQUEST[catid]'");
                         header("Location: index.php?action=cats&sid=$sid");
                       } else header("Location: index.php?action=cat_edit&catid=$_REQUEST[catid]&sid=$sid&error=title");
                     }

                     if($_REQUEST["error"]) eval("\$error_message .= \"".$template->tpl("cat_edit_error")."\";");

                     $query = $database->db_query("SELECT a.*, b.style AS catstyle FROM `hp" . $sql_prefix . "_cats` a LEFT JOIN `hp" . $sql_prefix . "_cats` b ON a.maincat = b.catid WHERE a.catid = '$_REQUEST[catid]'");
                     $cat = @mysql_fetch_array($query);

                     if($cat["subcat"] == 1)
                     {
                       $id = $cat[catid];

                       $subcat_selected = "selected";
                       $style_selected[$cat["catstyle"]] = "selected";
                     }
                     else $style_selected[$cat["style"]] = "selected";

                     $query = $database->db_query("SELECT `catid`, `title` FROM `hp" . $sql_prefix . "_cats` WHERE `subcat` = '0' ORDER BY `sort` ASC");
                     while($cats = @mysql_fetch_array($query))
                     {
                       if($cat["maincat"] == $cats["catid"] && $cat["subcat"] == 1) $maincat_selected[$id] ="selected";
                       eval("\$cats_edit_maincats_bit .= \"".$template->tpl("cat_edit_maincats_bit")."\";");
                     }
                       
                     eval("\$main_content .= \"".$template->tpl("cat_edit")."\";");
    break;

    case "news_add": if($_REQUEST["add"] == "yes")
                     {
                       if($_REQUEST["title"] && $_REQUEST["textarea"])
                       {
                         $database->db_query("INSERT INTO `hp" . $sql_prefix . "_news` (`title`, `content`, `time`) VALUES ('$_REQUEST[title]', '$_REQUEST[textarea]', '$time')");
                         header("Location: index.php?action=news&sid=$sid");
                       } else $error = "incomplete";
                     }
                     if($error) eval("\$error_message .= \"".$template->tpl("news_add_error")."\";");
                     
                     
                     eval("\$main_content .= \"".$template->tpl("news_add")."\";");
    break;


    case "cat_add": if($_REQUEST["add"] == "yes")
                    {
                      if($_REQUEST["title"])
                      {
                        if($_REQUEST["subcat"] == 0) $_REQUEST["maincat"] = 0;
                        $database->db_query("INSERT INTO `hp" . $sql_prefix . "_cats` (`title`, `description`, `styleid`, `top_image`, `style`, `subcat`, `maincat`) VALUES ('$_REQUEST[title]', '$_REQUEST[textarea]', '$_REQUEST[styleid]', '$_REQUEST[top_image]', '$_REQUEST[style]', '$_REQUEST[subcat]', '$_REQUEST[maincat]')");
                        header("Location: index.php?action=cats&sid=$sid");
                      } else header("Location: index.php?action=cat_add&sid=$sid&error=title");
                    }
                    
                    if($_REQUEST["error"]) eval("\$error_message .= \"".$template->tpl("cat_add_error")."\";");

                    $query = $database->db_query("SELECT `catid`, `title` FROM `hp" . $sql_prefix . "_cats` WHERE `subcat` = '0' ORDER BY `sort` ASC");
                    while($cats = @mysql_fetch_array($query)) eval("\$cat_add_maincats_bit .= \"".$template->tpl("cat_add_maincats_bit")."\";");

                    eval("\$main_content .= \"".$template->tpl("cat_add")."\";");
    break;

    case "cats": if($_REQUEST["sort"] == "yes")
                 {
                   $query = $database->db_query("SELECT `catid` FROM `hp" . $sql_prefix . "_cats`");
                   while($cats = @mysql_fetch_array($query))
                   {
                     $i = $cats["catid"];
                      $database->db_query("UPDATE `hp" . $sql_prefix . "_cats` SET `sort` = '" . $_REQUEST["sort_" .$i] . "' WHERE catid = '$cats[catid]'");
                   }
                   header("Location: index.php?action=cats&sid=$sid");
                 }
                 
                 if($_REQUEST["del"] == "yes")
                 {
                   $database->db_query("DELETE FROM `hp" . $sql_prefix . "_cats` WHERE `catid` = '$_REQUEST[catid]'");
                   header("Location: index.php?action=cats&sid=$sid");
                 }

                 $outer_query = $database->db_query("SELECT `catid`, `title`, `style`, `sort`  FROM `hp" . $sql_prefix . "_cats` WHERE `subcat` = '0' ORDER BY `sort` ASC");
                 while($cats = @mysql_fetch_array($outer_query))
                 {
                   for($i=1; $i <= @mysql_num_rows($outer_query); $i++)
                   {
                     if($cats["sort"] == $i) $selected = "selected";
                     else $selected = "";
                     eval("\$cats_sort_bit .= \"".$template->tpl("cats_sort_bit")."\";");
                   }
                   
                   eval("\$cats_bit .= \"".$template->tpl("cats_bit")."\";");
                   $cats_sort_bit = "";

                   $inner_query = $database->db_query("SELECT `catid`, `title`, `style`, `sort`  FROM `hp" . $sql_prefix . "_cats` WHERE `subcat` = '1' AND `maincat` = '$cats[catid]' ORDER BY `sort` ASC");
                   while($subcats = @mysql_fetch_array($inner_query))
                   {
                     for($i=1; $i <= @mysql_num_rows($inner_query); $i++)
                     {
                       if($subcats["sort"] == $i) $selected = "selected";
                       else $selected = "";
                       eval("\$cats_sort_bit .= \"".$template->tpl("cats_sort_bit")."\";");
                     }

                     eval("\$cats_bit .= \"".$template->tpl("cats_sub_bit")."\";");
                     $cats_sort_bit = "";
                   }
                 }

                 eval("\$main_content .= \"".$template->tpl("cats")."\";");
    break;

    default:
    break;
  }
  
  eval("\$main_subnavigation = \"".$template->tpl("main_subnavigation_connected")."\";");
}
else
{
  eval("\$main_subnavigation = \"".$template->tpl("main_subnavigation_disconnected")."\";");
  eval("\$main_content .= \"".$template->tpl("main_login")."\";");
}

//eval("\$main_content .= \"".$template->tpl("index_news_bit")."\";");
eval("\$template->tpl_output(\"".$template->tpl("main")."\");");

$database->db_close();
echo $database->error_output();
?>
