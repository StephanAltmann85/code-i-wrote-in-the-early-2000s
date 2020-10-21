<?php
// ************************************************************************************//
// * WoltLab Burning Board 2
// ************************************************************************************//
// * Copyright (c) 2001-2004 WoltLab GmbH
// * Web           http://www.woltlab.de/
// * License       http://www.woltlab.de/products/burning_board/license_en.php
// *               http://www.woltlab.de/products/burning_board/license.php
// ************************************************************************************//
// * WoltLab Burning Board 2 is NOT free software.
// * You may not redistribute this package or any of it's files.
// ************************************************************************************//
// * $Date: 2004-10-20 20:57:36 +0200 (Wed, 20 Oct 2004) $
// * $Author: Burntime $
// * $Rev: 1455 $
// ************************************************************************************//


/** delete a thread **/
function deletethread($threadid) {
	global $db, $n, $thread, $board, $boardid, $wbbuserdata;
	
	/** delete thread **/
	$db->query("DELETE FROM bb".$n."_threads WHERE threadid = '$threadid'");
	$db->unbuffered_query("DELETE FROM bb".$n."_threads WHERE pollid = '$threadid' AND closed=3", 1);
	if ($thread['important'] == 2) $db->unbuffered_query("DELETE FROM bb".$n."_announcements WHERE threadid = '$threadid'", 1);
	
	/** delete subscriptions **/
	$db->query("DELETE FROM bb".$n."_subscribethreads WHERE threadid = '$threadid'"); 
	
	/** delete poll **/ 
	if ($thread['pollid']) {
		$db->query("DELETE FROM bb".$n."_polls WHERE pollid = '$thread[pollid]'");
		$pollvotes = " OR (id = '$thread[pollid]' AND votemode=1)";
		$db->query("DELETE FROM bb".$n."_polloptions WHERE pollid = '$thread[pollid]'");
	}
	else $pollvotes = '';
	
	/** delete ratings **/
	$db->query("DELETE FROM bb".$n."_votes WHERE (id = '$threadid' AND votemode=2)$pollvotes");
	
	/** delete attachments **/
	if ($thread['attachments']) {
		$postids = '';
		$result = $db->query("SELECT postid FROM bb".$n."_posts WHERE threadid='$threadid' AND attachments>0");
		while ($row = $db->fetch_array($result)) $postids .= (($postids != '') ? (',') : ('')) . $row['postid'];
		if ($postids != '') {
			$result = $db->query("SELECT attachmentid, attachmentextension, thumbnailextension FROM bb".$n."_attachments WHERE postid IN ($postids) AND privatemessageid = 0");
			while ($row = $db->fetch_array($result)) {
				@unlink("attachments/attachment-".$row['attachmentid'].".".$row['attachmentextension']);
				@unlink("attachments/thumbnail-".$row['attachmentid'].".".$row['thumbnailextension']);
			}
			$db->query("DELETE FROM bb".$n."_attachments WHERE postid IN ($postids)");
		}
	}
	
	/** delete userpost **/
	if ($board['countuserposts'] == 1) { 
		$result = $db->query("SELECT COUNT(postid) AS posts, userid FROM bb".$n."_posts WHERE threadid='$threadid' AND visible=1 AND userid>0 GROUP BY userid");
		while ($row = $db->fetch_array($result)) $db->query("UPDATE bb".$n."_users SET userposts=userposts-'$row[posts]' WHERE userid='$row[userid]'");
	}
	
	/** delete posts **/
	$db->query("DELETE FROM bb".$n."_posts WHERE threadid = '$threadid'");
	$db->query("DELETE FROM bb".$n."_postcache WHERE threadid = '$threadid'");
	$thread['replycount'] += 1;
	
	/* update global threadcount & postcount */
	if ($thread['visible'] == 1) $db->unbuffered_query("UPDATE bb".$n."_stats SET threadcount=threadcount-1, postcount=postcount-'".$thread['replycount']."'", 1);
	
	/* update boardcount */
	if ($thread['visible'] == 1) $db->query("UPDATE bb".$n."_boards SET threadcount=threadcount-1, postcount=postcount-'".$thread['replycount']."' WHERE boardid IN ($boardid,$board[parentlist])");
	if ($board['lastthreadid'] == $threadid) updateBoardInfo("$boardid,$board[parentlist]", 0, $threadid);
}


/** delete an amount of posts **/
function deleteposts($postids, $threadid, $postcount) {
	global $db, $n, $thread, $board, $boardid, $wbbuserdata;
	
	$result = $db->query("SELECT postid, parentpostid FROM bb".$n."_posts WHERE postid IN ($postids) ORDER BY posttime DESC");
	while ($row = $db->fetch_array($result)) $db->query("UPDATE bb".$n."_posts SET parentpostid='$row[parentpostid]' WHERE threadid = '".$threadid."' AND parentpostid='$row[postid]'");
	
	/** delete userpost **/
	if ($board['countuserposts'] == 1) {
		$result = $db->query("SELECT COUNT(postid) AS posts, userid FROM bb".$n."_posts WHERE postid IN ($postids) AND visible=1 AND userid>0 GROUP BY userid");
		while ($row = $db->fetch_array($result)) $db->unbuffered_query("UPDATE bb".$n."_users SET userposts=userposts-'$row[posts]' WHERE userid='$row[userid]'", 1);
	}
	
	/** delete attachments **/
	$attachmentcount = 0;
	if ($thread['attachments']) {
		$result = $db->query("SELECT attachmentid, attachmentextension, thumbnailextension FROM bb".$n."_attachments WHERE postid IN ($postids)");
		$attachmentcount = $db->num_rows($result);
		while ($row = $db->fetch_array($result)) {
			@unlink("attachments/attachment-".$row['attachmentid'].".".$row['attachmentextension']);
			@unlink("attachments/thumbnail-".$row['attachmentid'].".".$row['thumbnailextension']);
		}
		$db->unbuffered_query("DELETE FROM bb".$n."_attachments WHERE postid IN ($postids)", 1);
	}
	
	$db->query("DELETE FROM bb".$n."_posts WHERE postid IN ($postids)");
	$db->query("DELETE FROM bb".$n."_postcache WHERE postid IN ($postids)");
	
	/* update global postcount */
	$db->unbuffered_query("UPDATE bb".$n."_stats SET postcount=postcount-'".$postcount."'", 1); 
	
	/* update board & thread count */
	$db->query("UPDATE bb".$n."_boards SET postcount=postcount-'$postcount' WHERE boardid IN ($boardid,$board[parentlist])");
	$result = $db->query_first("SELECT userid, username, posttime FROM bb".$n."_posts WHERE threadid='$threadid' ORDER BY posttime DESC", 1);
	$db->query("UPDATE bb".$n."_threads SET replycount=replycount-'$postcount', lastposttime='$result[posttime]', lastposterid='$result[userid]', lastposter='".addslashes($result['username'])."'".(($attachmentcount != 0) ? (", attachments=attachments-'$attachmentcount'") : (""))." WHERE threadid='$threadid'");
	
	updateBoardInfo("$boardid,$board[parentlist]", $thread['lastposttime']);
}


/** move a thread **/
function movethread($threadid, $mode, $newboardid) {
	global $board, $thread, $db, $n, $newboard, $default_prefix;	
	
	$boardid = $board['boardid'];
	if (!is_array($newboard)) $newboard = $db->query_first("SELECT * FROM bb".$n."_boards WHERE boardid = '$newboardid'");
	
	if ($mode == "onlymove" || $mode == "movewithredirect") {
		if ($thread['important'] == 2) {
			list($announcements) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_announcements WHERE threadid='$threadid'");	
			if ($announcements > 1) $db->query("INSERT IGNORE INTO bb".$n."_announcements (boardid,threadid) VALUES ('$newboardid','$threadid')");
			else $db->query("UPDATE bb".$n."_announcements SET boardid='$newboardid' WHERE threadid='$threadid' AND boardid='$boardid'");
		}
		
		// verify prefix
		$prefix = $thread['prefix'];
		if ($thread['prefix'] != '') {
			// get allowed prefixes in newboard
			if ($newboard['prefixuse'] == 1) $ch_prefix = $default_prefix;
			if ($newboard['prefixuse'] == 2) $ch_prefix = $default_prefix."\n".$newboard['prefix'];
			if ($newboard['prefixuse'] == 3) $ch_prefix = $newboard['prefix'];
			else $ch_prefix = "";
			$ch_prefix = preg_replace("/\s*\n\s*/", "\n", wbb_trim($ch_prefix));
			$ch_prefix = explode("\n", $ch_prefix);
			
			// thread's prefix is not allowed in new board -> delete prefix
			if (!in_array($thread['prefix'], $ch_prefix)) {
				$prefix='';	
			}
		}
		
		$db->query("DELETE FROM bb".$n."_threads WHERE boardid='$newboardid' AND pollid='$threadid' AND closed='3'"); 
		$db->query("UPDATE bb".$n."_threads SET boardid='$newboardid'".(($thread['prefix']!=$prefix) ? ",prefix='".addslashes($prefix)."'" : "")." WHERE threadid='$threadid'");
		if ($mode=="movewithredirect") $db->query("INSERT INTO bb".$n."_threads (boardid,prefix,topic,iconid,starttime,starterid,starter,lastposttime,lastposterid,lastposter,replycount,views,closed,voted,votepoints,pollid,visible) VALUES ('$boardid','".addslashes($prefix)."','".addslashes($thread['topic'])."','$thread[iconid]','$thread[starttime]','$thread[starterid]','".addslashes($thread['starter'])."','$thread[lastposttime]','$thread[lastposterid]','".addslashes($thread['lastposter'])."','$thread[replycount]','$thread[views]','3','$thread[voted]','$thread[votepoints]','$threadid','$thread[visible]')");
		
		$thread['replycount']+=1;
		$db->query("UPDATE bb".$n."_boards SET threadcount=threadcount-1, postcount=postcount-'$thread[replycount]' WHERE boardid IN ($boardid,$board[parentlist])");
		$db->query("UPDATE bb".$n."_boards SET threadcount=threadcount+1, postcount=postcount+'$thread[replycount]' WHERE boardid IN ($newboardid,$newboard[parentlist])");
		
		if ($board['lastthreadid']==$threadid) updateBoardInfo("$boardid,$board[parentlist]",0,$threadid);
		if ($newboard['lastposttime']<=$thread['lastposttime']) updateBoardInfo("$newboardid,$newboard[parentlist]",$thread['lastposttime']);
		
		if ($board['countuserposts']==1 && $newboard['countuserposts']==0) {
			$result = $db->query("SELECT COUNT(postid) AS posts, userid FROM bb".$n."_posts WHERE threadid='$threadid' AND visible = 1 AND userid>0 GROUP BY userid");
			while ($row=$db->fetch_array($result)) $db->query("UPDATE bb".$n."_users SET userposts=userposts-'$row[posts]' WHERE userid='$row[userid]'");
		}
		if ($board['countuserposts']==0 && $newboard['countuserposts']==1) {
			$result = $db->query("SELECT COUNT(postid) AS posts, userid FROM bb".$n."_posts WHERE threadid='$threadid' AND visible = 1 AND userid>0 GROUP BY userid");
			while ($row=$db->fetch_array($result)) $db->query("UPDATE bb".$n."_users SET userposts=userposts+'$row[posts]' WHERE userid='$row[userid]'");
		}
	}
	if ($mode == "copy") {
		$db->query("INSERT INTO bb".$n."_threads (boardid,topic,iconid,starttime,starterid,starter,lastposttime,lastposterid,lastposter,replycount,views,closed,voted,votepoints,attachments,pollid,important,visible)
		VALUES ('$newboardid','".addslashes($thread[topic])."','$thread[iconid]','$thread[starttime]','$thread[starterid]','".addslashes($thread[starter])."','$thread[lastposttime]','$thread[lastposterid]','".addslashes($thread[lastposter])."','$thread[replycount]','$thread[views]','$thread[closed]','$thread[voted]','$thread[votepoints]','$thread[attachments]','$thread[pollid]','$thread[important]','$thread[visible]')");
		$newthreadid = $db->insert_id();
		// copy poll (ignore votes)
		if ($thread['pollid'] != 0) {
			$poll = $db->query_first("SELECT * FROM bb".$n."_polls WHERE pollid='$thread[pollid]'");
			$db->query("INSERT INTO bb".$n."_polls (threadid, question, starttime, choicecount, timeout) ".
			"VALUES ('$newthreadid', '".addslashes($poll['question'])."', '$poll[starttime]', '$poll[choicecount]', '$poll[timeout]')");
			$newpollid = $db->insert_id();
			$db->query("UPDATE bb".$n."_threads SET pollid = '$newpollid' WHERE threadid = '$newthreadid'");
			
			$insert_str = '';
			$result = $db->query("SELECT * FROM bb".$n."_polloptions WHERE pollid = '$thread[pollid]'");
			while ($row = $db->fetch_array($result)) {
				$insert_str .= ",('$newpollid', '".addslashes($row['polloption'])."', '$row[votes]', '$row[showorder]')";
			}
			if ($insert_str != '') $db->query("INSERT INTO bb".$n."_polloptions (pollid, polloption, votes, showorder) VALUES ".wbb_substr($insert_str, 1));
		}
		
		$result = $db->query("SELECT * FROM bb".$n."_announcements WHERE threadid='$threadid'");
		if ($db->num_rows($result)) {
			while ($row=$db->fetch_array($result)) $db->query("INSERT INTO bb".$n."_announcements (boardid,threadid) VALUES ('$row[boardid]','$newthreadid')");
			$db->query("INSERT IGNORE INTO bb".$n."_announcements (boardid,threadid) VALUES ('$newboardid','$newthreadid')");
		}
		
		$attachmentPostIDs = array();
		$newPostIDs = array();
		$oldPostIDs = array();
		$result = $db->query("SELECT * FROM bb".$n."_posts WHERE threadid='$threadid'");
		while ($row = $db->fetch_array($result)) {
			$db->query("INSERT INTO bb".$n."_posts (parentpostid,threadid,userid,username,iconid,posttopic,posttime,message,attachments,edittime,editorid,editor,editcount,allowsmilies,allowhtml,allowbbcode,allowimages,showsignature,ipaddress,visible,reindex) ".
			"VALUES ('".((isset($newPostIDs[$row['parentpostid']]) && $newPostIDs[$row['parentpostid']]) ? ($newPostIDs[$row['parentpostid']]) : ($row['parentpostid']))."','$newthreadid','$row[userid]','".addslashes($row['username'])."','$row[iconid]','".addslashes($row[posttopic])."','$row[posttime]','".addslashes($row[message])."','$row[attachments]','$row[edittime]','$row[editorid]','".addslashes($row['editor'])."','$row[editcount]','$row[allowsmilies]','$row[allowhtml]','$row[allowbbcode]','$row[allowimages]','$row[showsignature]','$row[ipaddress]','$row[visible]','1')");
			$newPostIDs[$row['postid']] = $db->insert_id();
			if (!isset($newPostIDs[$row['parentpostid']]) && !$newPostIDs[$row['parentpostid']]) {
				$oldPostIDs[$row['postid']] = $newPostIDs[$row['postid']];
				$oldPostIDs[$newPostIDs[$row['postid']]] = $row['parentpostid'];
			}
			if ($row['attachments']) {
				$attachmentPostIDs[$row['postid']] = $newPostIDs[$row['postid']];
			}
		}
		
		// rebuild threaded view
		if (count($oldPostIDs)) {
			foreach ($oldPostIDs as $newPostID => $oldparentpostID) {
				$db->unbuffered_query("UPDATE bb".$n."_posts SET parentpostid = '".intval($newPostIDs[$oldparentpostID])."' WHERE postid = '".$newPostID."'", 1);
			}			
		}
	
		// copy attachments
		if (count($attachmentPostIDs) > 0) {
			$result = $db->query("SELECT * FROM bb".$n."_attachments WHERE postid IN (".implode(',', array_keys($attachmentPostIDs)).")");
			while ($row = $db->fetch_array($result)) {
				$db->query("INSERT INTO bb".$n."_attachments (postid, userid, attachmentname, attachmentextension, attachmentsize, thumbnailextension, thumbnailsize, counter, uploadtime) ".
				"VALUES ('".$attachmentPostIDs[$row['postid']]."', '$row[userid]', '".addslashes($row['attachmentname'])."', '".addslashes($row['attachmentextension'])."', '$row[attachmentsize]', '".addslashes($row['thumbnailextension'])."', '$row[thumbnailsize]', '$row[counter]', '$row[uploadtime]')");
				$newattachmentid = $db->insert_id();
				@copy('attachments/attachment-'.$row['attachmentid'].'.'.$row['attachmentextension'], 'attachments/attachment-'.$newattachmentid.'.'.$row['attachmentextension']);
				@chmod('attachments/attachment-'.$newattachmentid.'.'.$row['attachmentextension'], 0777);
				@copy('attachments/thumbnail-'.$row['attachmentid'].'.'.$row['thumbnailextension'], 'attachments/thumbnail-'.$newattachmentid.'.'.$row['thumbnailextension']);
				@chmod('attachments/thumbnail-'.$newattachmentid.'.'.$row['thumbnailextension'], 0777);
			}
		}

		
		$thread['replycount']+=1;
		$db->query("UPDATE bb".$n."_boards SET threadcount=threadcount+1, postcount=postcount+'$thread[replycount]' WHERE boardid IN ($newboardid,$newboard[parentlist])");
		
		if ($newboard['lastposttime']<=$thread['lastposttime']) updateBoardInfo("$newboardid,$newboard[parentlist]",$thread['lastposttime']);
		
		if ($newboard['countuserposts']==1) {
			$result = $db->query("SELECT COUNT(postid) AS posts, userid FROM bb".$n."_posts WHERE threadid='$newthreadid' AND visible = 1 AND userid>0 GROUP BY userid");
			while ($row=$db->fetch_array($result)) $db->query("UPDATE bb".$n."_users SET userposts=userposts+'$row[posts]' WHERE userid='$row[userid]'");
		}
		
		/* update global threadcount & postcount */
		$db->unbuffered_query("UPDATE bb".$n."_stats SET threadcount=threadcount+1, postcount=postcount+'".$thread['replycount']."'", 1);
	}	
}
?>