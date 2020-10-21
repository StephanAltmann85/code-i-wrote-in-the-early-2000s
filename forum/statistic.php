<?php
$filename="statistic.php";

require ("./global.php");

$male_users = $db->query_first("Select COUNT(*) AS gender FROM bb".$n."_users WHERE gender = 1");
$statistic_male_users = $male_users['gender'];

$female_users = $db->query_first("Select COUNT(*) AS gender FROM bb".$n."_users WHERE gender = 2");
$statistic_female_users = $female_users['gender'];

$no_gender = $db->query_first("Select COUNT(*) AS gender FROM bb".$n."_users WHERE gender = 0");
$statistic_no_gender = $no_gender['gender'];

$user = $db->query_first("Select COUNT(*) As user FROM bb".$n."_users ");
$statistic_user = $user['user'];

$user_invisible = $db->query_first("Select COUNT(*) AS invisible FROM bb".$n."_users WHERE invisible = 1");
$statistic_user_invisible = $user_invisible['invisible'];

$user_blocked = $db->query_first("Select COUNT(*) AS blocked FROM bb".$n."_users WHERE blocked = 1");
$statistic_user_blocked = $user_blocked['blocked'];

$user_not_activated = $db->query_first("Select COUNT(*) AS not_activated FROM bb".$n."_users WHERE activation = 0");
$statistic_user_not_activated = $user_not_activated['not_activated'];

$result = $db->query("SELECT userid, username, userposts, regdate FROM bb".$n."_users ORDER BY regdate Desc Limit 5");

while($stat_newmembers = $db->fetch_array($result))
{
 $stat_newmembers['regdate'] = formatdate($wbbuserdata['dateformat'],$stat_newmembers['regdate']);

 eval ("\$statistic_newmembers .= \" ".$tpl->get("statistic_newmembers")."\";");
}
$db->free_result($result);

$result = $db->query("SELECT userid, username, userposts, regdate FROM bb".$n."_users ORDER BY userposts Desc Limit 5");

while($stat_topmembers = $db->fetch_array($result))
{
  $stat_topmembers['regdate'] = formatdate($wbbuserdata['dateformat'],$stat_topmembers['regdate']);

 eval ("\$statistic_topmembers .= \" ".$tpl->get("statistic_topmembers")."\";");
}
$db->free_result($result);

$result = $db->query("SELECT threadid, topic, views, starter, starterid FROM bb".$n."_threads ORDER BY views Desc Limit 5");

while($stat_topviews = $db->fetch_array($result))
{
 eval ("\$statistic_topviews .= \" ".$tpl->get("statistic_topviews")."\";");
}
$db->free_result($result);

$result = $db->query("SELECT threadid, topic, replycount, starter, starterid FROM bb".$n."_threads ORDER BY replycount Desc Limit 5");

while($stat_topreplys = $db->fetch_array($result))
{
 eval ("\$statistic_topreplys .= \" ".$tpl->get("statistic_topreplys")."\";");
}
$db->free_result($result);

$result = $db->query("SELECT threadid, topic, replycount, starter, starterid FROM bb".$n."_threads ORDER BY lastposttime Desc Limit 5");

while($stat_lastthreads = $db->fetch_array($result))
{
 eval ("\$statistic_lastthreads .= \" ".$tpl->get("statistic_lastthreads")."\";");
}
$db->free_result($result);

eval("\$tpl->output(\"".$tpl->get("statistic")."\");");
?>