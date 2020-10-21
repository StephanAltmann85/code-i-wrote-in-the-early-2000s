<?php
$filename = 'index.php';

require('./global.php');
$lang->load('START');

function makeArchiveBoardBit($boardid, $depth = 1) {
	global $lang, $tpl, $boardcache, $permissioncache, $wbbuserdata;

	if (!isset($boardcache[$boardid])) return;
	reset($boardcache[$boardid]);

	$boardbit = '';
	while (list($key1, $val1) = each($boardcache[$boardid])) {
		while (list($key2, $boards) = each($val1)) {
			if (!isset($permissioncache[$boards['boardid']]['can_view_board']) || $permissioncache[$boards['boardid']]['can_view_board'] == -1) $permissioncache[$boards['boardid']]['can_view_board'] = $wbbuserdata['can_view_board'];
			if (!isset($permissioncache[$boards['boardid']]['can_enter_board']) || $permissioncache[$boards['boardid']]['can_enter_board'] == -1) $permissioncache[$boards['boardid']]['can_enter_board'] = $wbbuserdata['can_enter_board'];
			if ($boards['invisible'] == 2 || !$permissioncache[$boards['boardid']]['can_view_board']) continue;
			if ($boards['showinarchive'] == 0 || $boards['externalurl'] != '') continue;
			
			$boards['title'] = getlangvar($boards['title'], $lang);
			
			$subBoardBit = makeArchiveBoardBit($boards['boardid'], $depth + 1);		
			
			if ($boards['isboard']) eval("\$boardbit .= \"".$tpl->get("archive_index_boardbit")."\";");
			else eval("\$boardbit .= \"".$tpl->get("archive_index_catbit")."\";");
		}
	}
	unset($boardcache[$boardid]);

	return $boardbit;
}

$boardcache = array();
$permissioncache = array();

switch ($boardordermode) {
	case 1: $boardorder = 'title ASC'; break;
	case 2: $boardorder = 'title DESC'; break;
	case 3: $boardorder = 'lastposttime DESC'; break;
	default: $boardorder = 'boardorder ASC';
}
$activtime = time() - 60 * $useronlinetimeout;

$result = $db->query("SELECT * FROM bb".$n."_boards ORDER by parentid ASC, $boardorder");
while ($row = $db->fetch_array($result)) {
	$boardcache[$row['parentid']][$row['boardorder']][$row['boardid']] = $row;
}

// read permissions
$permissioncache = getPermissions();
$boardbit = makeArchiveBoardBit(0);

eval("\$tpl->output(\"".$tpl->get("archive_index")."\");"); 
?>