<?php
include "lib/global.php";
include "lib/parse_class.php";

$parse = new parse_class;

//News aus Forum

$query_threads = $database->db_query("SELECT topic, threadid, replycount, starttime FROM bb" . $options["board_prefix"] . "_threads WHERE boardid='$options[forum_id]' ORDER BY starttime DESC LIMIT 5");

while($thread = mysql_fetch_array($query_threads))
{
  $starttime = date("d.m.Y - H:i:s", $thread["starttime"]);

  $query_posts = $database->db_query("SELECT message, allowsmilies FROM bb" . $options["board_prefix"] . "_posts WHERE threadid='$thread[threadid]' ORDER BY posttime ASC LIMIT 1");

  while($row = mysql_fetch_row($query_posts))
  {
    $message = $parse->parse($row[0], $row[1]);

    eval("\$main_bit .= \"".$template->tpl("index_news_bit.htm")."\";");
  }
}


$used_queries = $database->used_queries;
$database->db_close();
echo $database->error_output();

$used_templates = $template->used_templates;
$exec_time = exec_time();
eval("\$template->tpl_output(\"".$template->tpl("main.htm")."\");");
?>