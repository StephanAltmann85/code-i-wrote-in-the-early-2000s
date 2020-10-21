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
// * $Date: 2005-04-26 16:41:52 +0200 (Tue, 26 Apr 2005) $
// * $Author: Burntime $
// * $Rev: 1597 $
// ************************************************************************************//


$filename = 'thread.php';

require('./global.php');
require('./acp/lib/class_parse.php');
$lang->load('THREAD,MEMBERS');

if ((!isset($postid) && !isset($threadid)) || $thread['closed'] == 3) error($lang->get("LANG_GLOBAL_ERROR_FALSELINK", array('$adminmail' => $adminmail)));
if (!checkpermissions("can_read_thread")) access_error();






/** Thread Class **/
class Thread {
	/**
	* @var integer threadid
	*/
	var $threadid = 0;

	/**
	* @var string pagelink
	*/
	var $pagelink = "";

	/**
	* @var integer page
	*/
	var $page = 0;

	/**
	* @var integer pages
	*/
	var $pages = 0;

	/**
	* @var string postids
	*/
	var $postids = ""; 

	/**
	* @var string orderby
	*/
	var $orderBy = "";

	/**
	* @var array userfieldcache
	*/
	var $userfieldcache = array();

	/**
	* @var object parse
	*/
	var $parse;
	
	/**
	* @var array attachmentArray
	*/
	var $attachmentArray = array();
	
	/**
	* @var boolean readAttachments
	*/
	var $readAttachments = false;
	
	/**
	* parse a message and generate postbit
	*
	* @param array posts
	* @param integer count
	* @param integer indentwidth
	*
	* @return string postbit
	*/
	function makePostBit($posts, $count, $indentwidth = 0) {
		global $thread, $board, $tpl, $wbbuserdata, $style, $lang, $session, $userratings, $showuserratinginthread, $showuserlevels, $showonlineinthread, $useronlinetimeout, $showregdateinthread, $showuserfieldsinthread, $showgenderinthread, $showavatar, $_GET, $showthreadstarter, $showuserpostsinthread, $allowsigsmilies, $allowsightml, $allowsigbbcode, $max_sig_image, $authormarking, $picmaxwidth, $picmaxheight, $allowflashavatar, $thumbnailsperrow, $SID_ARG_1ST, $SID_ARG_2ND, $SID_ARG_2ND_UN;
		if ($this->userfieldcache) reset($this->userfieldcache);
		$userrating = '';
		$signature = '';
		$lastedit = '';
		$user_online = '';
		$userfields = '';
		$useravatar = '';
		$rankimages = '';
		$setvisible = '';
		$userlevel = '';
		$posts['username'] = htmlconverter($posts['username']);
		$username = $posts['username'];
		
		/** mod / admin option -> set visible post **/
		if ($posts['visible'] == 0 && $posts['posttime'] != $thread['starttime']) $invisible = 1;
		else $invisible = 0;
		
		$tdclass = getone($count, 'tableb', 'tablea');
		
		// use postcache if possible
		if ($posts['cache']) $posts['message'] = $this->parse->parseCache($posts['cache']);
		else $posts['message'] = $this->parse->doparse($posts['message'], $posts['allowsmilies'], $posts['allowhtml'], $posts['allowbbcode'], $posts['allowimages']);
				
		$posts['posttopic'] = htmlconverter(textwrap($posts['posttopic']));
		if ($posts['iconid']) $posticon = makeimgtag($posts['iconpath'], getlangvar($posts['icontitle'], $lang), 0);
		else $posticon = '';
		if ($posts['posttime'] > $thread['lastvisit']) $newpost = 1;
		else $newpost = 0;
		
		$postdate = formatdate($wbbuserdata['dateformat'], $posts['posttime'], 1);
		$posttime = formatdate($wbbuserdata['timeformat'], $posts['posttime']);
		
		
		// show attachments
		$attachments = '';
		$attachment_thumbnailCount = 0;
		$attachmentbit = '';
		$attachmentbit_img = '';
		$attachmentbit_img_small = '';
		$attachmentbit_img_thumbnails = '';
		
		if (isset($this->attachmentArray[$posts['postid']]) && count($this->attachmentArray[$posts['postid']])) {
			unset($LANG_THREAD_ATTACHMENT_IMAGE_THUMBNAIL);
			unset($LANG_THREAD_ATTACHMENT_IMAGE_SMALL);
			unset($LANG_THREAD_ATTACHMENT_IMAGE);
			unset($LANG_THREAD_ATTACHMENT);
			
			foreach ($this->attachmentArray[$posts['postid']] as $attachment) {
				$attachment['attachmentextension'] = htmlconverter($attachment['attachmentextension']);
				$attachment['attachmentname'] = htmlconverter($attachment['attachmentname']);
				
				// attachment is an image, display it directly
				if (checkpermissions('can_download_attachments') == 1 && $wbbuserdata['showimages'] == 1 && $wbbuserdata['can_download_attachments'] == 1 && ($attachment['attachmentextension'] == 'gif' || $attachment['attachmentextension'] == 'jpg' || $attachment['attachmentextension'] == 'jpeg'  || $attachment['attachmentextension'] == 'png')) {
					if ($attachment['thumbnailextension'] != '') {
						$attachment_thumbnailCount++;
						if ($attachment_thumbnailCount && ($attachment_thumbnailCount % $thumbnailsperrow) == 0) $thumbnailNewline = true;
						else $thumbnailNewline = false;
						if (!isset($LANG_THREAD_ATTACHMENT_IMAGE_THUMBNAIL)) $LANG_THREAD_ATTACHMENT_IMAGE_THUMBNAIL = $lang->get("LANG_THREAD_ATTACHMENT_IMAGE_SMALL", array('$username' => $username));
						else $LANG_THREAD_ATTACHMENT_IMAGE_THUMBNAIL = $lang->get("LANG_THREAD_ATTACHMENTS_IMAGE_SMALL", array('$username' => $username));
						
						eval("\$attachmentbit_img_thumbnails .= \"".$tpl->get("thread_attachmentbit_show_thumbnail")."\";");
					}
					else {
						$imgsize = @getimagesize("./attachments/attachment-$attachment[attachmentid].$attachment[attachmentextension]");
						
						if (($picmaxwidth != 0 && $imgsize[0] > $picmaxwidth) || ($picmaxheight != 0 && $imgsize[1] > $picmaxheight)) {
							if ($picmaxwidth != 0) $div1 = $picmaxwidth / $imgsize[0];
							else $div1 = 1;
							if ($picmaxheight != 0) $div2 = $picmaxheight / $imgsize[1];
							else $div2 = 1;
							
							if ($div1 < $div2) {
								$attachment['imgwidth'] = $picmaxwidth;
								$attachment['imgheight'] = round($imgsize[1] * $div1);
							}
							else {
								$attachment['imgheight'] = $picmaxheight;
								$attachment['imgwidth'] = round($imgsize[0] * $div2);	
							}
							
							if (!isset($LANG_THREAD_ATTACHMENT_IMAGE_SMALL)) $LANG_THREAD_ATTACHMENT_IMAGE_SMALL = $lang->get("LANG_THREAD_ATTACHMENT_IMAGE_SMALL", array('$username' => $username));
							else $LANG_THREAD_ATTACHMENT_IMAGE_SMALL = $lang->get("LANG_THREAD_ATTACHMENTS_IMAGE_SMALL", array('$username' => $username));
							
							eval("\$attachmentbit_img_small .= \"".$tpl->get("thread_attachmentbit_show_small")."\";");
						}
						else {
							if (!isset($LANG_THREAD_ATTACHMENT_IMAGE)) $LANG_THREAD_ATTACHMENT_IMAGE = $lang->get("LANG_THREAD_ATTACHMENT_IMAGE", array('$username' => $username));
							else $LANG_THREAD_ATTACHMENT_IMAGE = $lang->get("LANG_THREAD_ATTACHMENTS_IMAGE", array('$username' => $username));
							
							eval("\$attachmentbit_img .= \"".$tpl->get("thread_attachmentbit_show")."\";");
						}
					}
				}
				else {
					if (!file_exists($style['imagefolder']."/filetypes/".$attachment['attachmentextension'].".gif")) $extensionimage = "unknown";
					else $extensionimage = $attachment['attachmentextension'];
					if ($attachment['counter'] >= 1000) $attachment['counter'] = number_format($attachment['counter'], 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP")); 
					$attachment['attachmentsize'] = formatFilesize($attachment['attachmentsize']);
					$LANG_THREAD_ATTACHMENT_INFO = $lang->get("LANG_THREAD_ATTACHMENT_INFO", array('$attachmentsize' => $attachment['attachmentsize'], '$counter' => $attachment['counter']));
					if (!isset($LANG_THREAD_ATTACHMENT)) $LANG_THREAD_ATTACHMENT = $lang->get('LANG_THREAD_ATTACHMENT');
					else  $LANG_THREAD_ATTACHMENT = $lang->get('LANG_THREAD_ATTACHMENTS');
					
					eval("\$attachmentbit .= \"".$tpl->get("thread_attachmentbit")."\";");
				}				
			}
			eval("\$attachments = \"".$tpl->get("thread_attachments")."\";");
		}
		
		if ($posts['editorid']) {
			$editdate = formatdate($wbbuserdata['dateformat'], $posts['edittime'], 1);
			$edittime = formatdate($wbbuserdata['timeformat'], $posts['edittime']);
			$posts['editor'] = htmlconverter($posts['editor']);
			
			$LANG_THREAD_EDITOR = $lang->get("LANG_THREAD_EDITOR", array('$editcount' => $posts['editcount'], '$editor' => $posts['editor'], '$editdate' => $editdate, '$edittime' => $edittime));
		}
		
		if ($posts['userid']) {
			$posts['homepage'] = htmlconverter($posts['homepage']);
			$posts['email'] = getASCIICodeString($posts['email']);
			
			$rankimages = formatRI($posts['rankimages']);
			if ($posts['title']) $posts['ranktitle'] = htmlconverter($posts['title']);
			else $posts['ranktitle'] = getlangvar($posts['ranktitle'], $lang);
			
			if ($userratings == 1 && $showuserratinginthread == 1) $userrating = userrating($posts['ratingcount'], $posts['ratingpoints'], $posts['userid']);
			if ($showuserlevels == 1) $userlevel = userlevel($posts['userposts'], $posts['regdate']);
			
			if ($showonlineinthread == 1) {
				if (($posts['invisible'] == 0 || $wbbuserdata['a_can_view_ghosts'] == 1) && $posts['lastactivity'] >= time() - $useronlinetimeout * 60) {
					$user_online = 1;
					$LANG_MEMBERS_USERONLINE = $lang->get("LANG_MEMBERS_USERONLINE", array('$username' => $username));
				}
				else {
					$user_online = 0;
					$LANG_MEMBERS_USERONLINE = $lang->get("LANG_MEMBERS_USEROFFLINE", array('$username' => $username));
				}
			}
			
			if ($showregdateinthread == 1) $posts['regdate'] = formatdate($wbbuserdata['dateformat'], $posts['regdate']);
			
			if ($showuserfieldsinthread == 1 && is_array($this->userfieldcache) && count($this->userfieldcache)) {
				while (list($key, $val) = each($this->userfieldcache)) {
					$fieldcontent = textwrap($posts["field".$val['profilefieldid']], 20);
					if ($fieldcontent && $fieldcontent != "0000-00-00") {
						if ($val['fieldtype'] == "multiselect") $fieldcontent = str_replace("\n", "; ", $fieldcontent);
						elseif ($val['fieldtype'] == "date") {
							$row_datearray = explode("-", $fieldcontent);
							if ($row_datearray[0] == "0000") $fieldcontent = $row_datearray[2].".".$row_datearray[1].".";
							else $fieldcontent = $row_datearray[2].".".$row_datearray[1].".".$row_datearray[0];
						}
						$fieldcontent = htmlconverter($fieldcontent);
						eval("\$userfields .= \"".$tpl->get("thread_userfields")."\";");
					}
				}
			}
			
			if ($showgenderinthread == 0) $posts['gender'] = 0;
			if ($posts['gender'] == 1) $LANG_THREAD_MALE = $lang->get("LANG_THREAD_MALE", array('$username' => $username));
			if ($posts['gender'] == 2) $LANG_THREAD_FEMALE = $lang->get("LANG_THREAD_FEMALE", array('$username' => $username));
			
			if ($posts['showemail'] == 1 || $posts['usercanemail'] == 1) $LANG_MEMBERS_SENDEMAIL = $lang->get("LANG_MEMBERS_SENDEMAIL", array('$username' => $username));
			if ($posts['homepage']) $LANG_MEMBERS_HOMEPAGE = $lang->get("LANG_MEMBERS_HOMEPAGE", array('$username' => $username));
			
			$LANG_MEMBERS_SEARCH = $lang->get("LANG_MEMBERS_SEARCH", array('$username' => $username));
			$LANG_MEMBERS_BUDDY = $lang->get("LANG_MEMBERS_BUDDY", array('$username' => $username));
			
			if ($posts['receivepm'] == 1 && $wbbuserdata['can_use_pms'] == 1) $LANG_MEMBERS_PM = $lang->get("LANG_MEMBERS_PM", array('$username' => $username));
			
			if ($posts['icq']) $LANG_MEMBERS_ICQ = $lang->get("LANG_MEMBERS_ICQ", array('$username' => $username));
			if ($posts['aim']) {
				$posts['aim'] = htmlconverter($posts['aim']);
				$aim = $posts['aim'];
				$LANG_MEMBERS_AIM = $lang->get("LANG_MEMBERS_AIM", array('$username' => $username, '$aim' => $aim));
			}
			if ($posts['yim']) {
				$posts['yim'] = htmlconverter($posts['yim']);
				$yim = $posts['yim'];
				$LANG_MEMBERS_YIM = $lang->get("LANG_MEMBERS_YIM", array('$username' => $username, '$yim' => $yim));
			}
			if ($posts['msn']) {
				$posts['msn'] = htmlconverter($posts['msn']);
				$LANG_MEMBERS_MSN = $lang->get("LANG_MEMBERS_MSN", array('$username' => $username));
			}
			
			if ($posts['avatarid'] && $showavatar == 1 && $wbbuserdata['showavatars'] == 1) {
				$avatarname = "images/avatars/avatar-$posts[avatarid].".htmlconverter($posts['avatarextension']);
				$avatarwidth = $posts['width'];
				$avatarheight = $posts['height'];
				if ($posts['avatarextension'] == "swf" && $allowflashavatar == 1) eval("\$useravatar = \"".$tpl->get("avatar_flash")."\";");
				elseif ($posts['avatarextension'] != "swf") eval("\$useravatar = \"".$tpl->get("avatar_image")."\";");
			}
			
			if ($authormarking == 1 && $posts['useronlinemarking'] != '') $posts['username'] = sprintf($posts['useronlinemarking'], $posts['username']);
			if (isset($_GET['hilightuser']) && $_GET['hilightuser'] == $posts['userid']) $posts['username'] = "<span class=\"highlight\">".$posts['username']."</span>";
			
			if ($showthreadstarter == 1 && $thread['starterid'] == $posts['userid'] && $thread['starttime'] != $posts['posttime']) {
				$threadstarter = 1;
				$LANG_THREAD_THREADSTARTER_ALT = $lang->get("LANG_THREAD_THREADSTARTER_ALT", array('$starter' => htmlconverter($thread['starter'])));
			}
			else $threadstarter = 0;
			
			if ($posts['showsignature'] == 1 && !$posts['disablesignature'] && $wbbuserdata['showsignatures'] == 1 && $posts['signature']) {
				$posts['signature'] = $this->parse->doparse($posts['signature'], $posts['allowsigsmilies'], $posts['allowsightml'], $posts['allowsigbbcode'], $posts['allowsigimages']);
				eval("\$signature = \"".$tpl->get("thread_signature")."\";");
			}
			
			if ($showuserpostsinthread == 1 && $posts['userposts'] >= 1000) $posts['userposts'] = number_format($posts['userposts'], 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP")); 
		}
		
		eval("\$postbit = \"".$tpl->get("thread_postbit")."\";");
		return $postbit;
	}
	
	
	/**
	* jump to last post
	*
	* @return void
	*/
	function lastpost() {
		global $visible, $SID_ARG_2ND_UN, $db, $n, $url2board;
		$result = $db->query_first("SELECT postid FROM bb".$n."_posts WHERE threadid = '".$this->threadid."' $visible ORDER BY posttime DESC", 1);
		header("Location: thread.php?postid=".$result['postid'].$SID_ARG_2ND_UN."#post$result[postid]");
		exit;	
	}
	
	/**
	* jump to first new post
	*
	* @param integer lastvisit
	*
	* @return void
	*/
	function firstnew($lastvisit) {
		global $visible, $db, $n, $SID_ARG_2ND_UN, $threadid, $url2board;
		$result = $db->query_first("SELECT postid FROM bb".$n."_posts WHERE threadid='".$this->threadid."' AND posttime>'".$lastvisit."' $visible ORDER BY posttime ASC", 1);
		if ($result['postid']) header("Location: thread.php?postid=".$result['postid'].$SID_ARG_2ND_UN."#post$result[postid]");
		else header("Location: thread.php?goto=lastpost&threadid=".$threadid.$SID_ARG_2ND_UN);
		exit;
	}
	
	
	/**
	* jump to next newest thread
	*
	* @return void
	*/
	function nextnewest() {
		global $db, $n, $thread, $boardid, $tpl, $lang, $threadid, $wbbuserdata, $REMOTE_ADDR;
		$result = $db->query_first("SELECT threadid FROM bb".$n."_threads WHERE visible = 1 AND lastposttime>'$thread[lastposttime]' AND closed <> 3 AND boardid = '$boardid' ORDER BY lastposttime ASC", 1);
		if (!$result['threadid']) error($lang->get("LANG_THREAD_ERROR_NONEXTNEWEST"));
		$threadid = $result['threadid'];
		$this->threadid = $threadid;
		
		$select = ", v.id AS isvoted";
		$join = " LEFT JOIN bb".$n."_votes v ON (v.id=t.threadid AND v.votemode=2 AND ".(($wbbuserdata['userid']) ? ("v.userid='".$wbbuserdata['userid']."'") : ("v.ipaddress='".addslashes($REMOTE_ADDR)."'")).")";
		
		if ($wbbuserdata['userid']) {
			$select .= ", tv.lastvisit, s.emailnotify, s.countemails";	
			$join .= " LEFT JOIN bb".$n."_threadvisit tv ON (tv.threadid=t.threadid AND tv.userid='".$wbbuserdata['userid']."')
			LEFT JOIN bb".$n."_subscribethreads s ON (s.userid='".$wbbuserdata['userid']."' AND s.threadid=t.threadid)";
		}
		
		$thread = $db->query_first("SELECT t.*".$select." FROM bb".$n."_threads t".$join." WHERE t.threadid = '".$this->threadid."'");
	}
	
	/**
	* jump to next oldest thread
	*
	* @return void
	*/
	function nextoldest() {
		global $db, $n, $thread, $boardid, $tpl, $lang, $threadid, $wbbuserdata, $REMOTE_ADDR;
		$result = $db->query_first("SELECT threadid FROM bb".$n."_threads WHERE visible = 1 AND lastposttime<'$thread[lastposttime]' AND closed <> 3 AND boardid = '$boardid' ORDER BY lastposttime DESC", 1);
		if (!$result['threadid']) error($lang->get("LANG_THREAD_ERROR_NONEXTOLDEST"));
		$threadid = $result['threadid'];
		$this->threadid = $threadid;
		$thread = $db->query_first("SELECT * FROM bb".$n."_threads WHERE threadid = '$threadid'");
		
		$select = ", v.id AS isvoted";
		$join = " LEFT JOIN bb".$n."_votes v ON (v.id=t.threadid AND v.votemode=2 AND ".(($wbbuserdata['userid']) ? ("v.userid='".$wbbuserdata['userid']."'") : ("v.ipaddress='".addslashes($REMOTE_ADDR)."'")).")";
		
		if ($wbbuserdata['userid']) {
			$select .= ", tv.lastvisit, s.emailnotify, s.countemails";	
			$join .= " LEFT JOIN bb".$n."_threadvisit tv ON (tv.threadid=t.threadid AND tv.userid='".$wbbuserdata['userid']."')
			LEFT JOIN bb".$n."_subscribethreads s ON (s.userid='".$wbbuserdata['userid']."' AND s.threadid=t.threadid)";
		}
		
		$thread = $db->query_first("SELECT t.*".$select." FROM bb".$n."_threads t".$join." WHERE t.threadid = '".$this->threadid."'");	
	}
	
	/**
	* create links to further pages
	*
	* @return void
	*/
	function makePagelink() {
		global $SID_ARG_2ND, $threadview, $hilight, $hilightuser, $showpagelinks;
		$this->pagelink = makepagelink("thread.php?threadid=".$this->threadid."&amp;threadview=$threadview&amp;hilight=".urlencode($hilight)."&amp;hilightuser=$hilightuser".$SID_ARG_2ND, $this->page, $this->pages, $showpagelinks - 1);
	}
	
	
	/**
	* read post information from database
	*
	* @return resource result
	*/
	function readPosts() {
		global $docensor, $board, $wbbuserdata, $hilight, $usecode, $showuserfieldsinthread, $db, $n, $showavatar, $authormarking, $lang; 
		$this->parse = &new parse($docensor, 75, $wbbuserdata['showimages'], $hilight, $usecode);
		
		if ($this->readAttachments) {
			$result = $db->unbuffered_query("SELECT postid, attachmentid, attachmentname, attachmentextension, attachmentsize, counter, thumbnailextension FROM bb".$n."_attachments WHERE postid IN (0".$this->postids.") ORDER BY uploadtime");
			while ($row = $db->fetch_array($result)) {
				$this->attachmentArray[$row['postid']][$row['attachmentid']] = $row;
			}
		}
		
		if ($showuserfieldsinthread == 1) {
			$userfields = ", uf.*";
			$userfieldsjoin = "LEFT JOIN bb".$n."_userfields uf ON (uf.userid=p.userid)";
			$result = $db->unbuffered_query("SELECT profilefieldid, title, fieldtype FROM bb".$n."_profilefields WHERE showinthread=1".(($wbbuserdata['a_can_view_hidden'] == 0) ? (" AND hidden=0") : (""))." ORDER BY fieldorder ASC");
			while ($row = $db->fetch_array($result)) {
				$row['title'] = getlangvar($row['title'], $lang);
				$this->userfieldcache[] = $row;
			}
		}
		else {
			$userfields = '';
			$userfieldsjoin = '';
		}
		
		if ($showavatar == 1) {
			$avatar = ", av.avatarid, av.avatarextension, av.width, av.height";
			$avatarjoin = "LEFT JOIN bb".$n."_avatars av ON (u.avatarid=av.avatarid)";
		}
		else {
			$avatar = '';
			$avatarjoin = '';	
		}
		
		if ($authormarking == 1) {
			$marking = ", g.useronlinemarking";
			$markingjoin = "LEFT JOIN bb".$n."_groups g ON (u.useronlinegroupid=g.groupid)";
		}
		else {
			$marking = '';
			$markingjoin = '';	
		}
		
		
		$result = $db->query("SELECT p.*, pc.cache,
		u.userposts, u.regdate, u.signature, u.email, u.homepage, u.icq, u.aim, u.yim, u.msn, u.showemail, u.receivepm, u.usercanemail, u.ratingcount, u.ratingpoints, u.gender, u.invisible, u.title, u.lastactivity, u.allowsigsmilies, u.allowsightml, u.allowsigbbcode, u.allowsigimages, u.disablesignature,
		r.ranktitle, r.rankimages,
		i.iconpath, i.icontitle
		$userfields
		$avatar
		$marking
		FROM bb".$n."_posts p 
		LEFT JOIN bb".$n."_users u USING (userid)
		LEFT JOIN bb".$n."_ranks r USING (rankid)
		LEFT JOIN bb".$n."_icons i ON (p.iconid=i.iconid)
		LEFT JOIN bb".$n."_postcache pc ON (p.postid=pc.postid)
		$userfieldsjoin
		$avatarjoin
		$markingjoin
		WHERE p.postid IN (0".$this->postids.")".$this->orderBy);
		
		return $result;
	}
}














/** FlatThread Class **/
class FlatThread extends Thread {
	
	/**
	* constructor
	*
	* @param integer threadid
	*/
	function FlatThread($threadid) {
		$this->threadid = $threadid;
	}
	
	/**
	* get and stores the pagenumber of a certain message
	*
	* @param integer postid
	*
	* @return void
	*/
	function gotoPost($postid) {
		global $db, $n, $visible, $postorder, $postsperpage, $_GET;
		if ($postorder == 0) $result = $db->query_first("SELECT COUNT(*) AS posts FROM bb".$n."_posts WHERE threadid='".$this->threadid."' AND postid<='$postid' $visible");
		else $result = $db->query_first("SELECT COUNT(*) AS posts FROM bb".$n."_posts WHERE threadid='$threadid' AND postid>='$postid' $visible");
		$_GET['page'] = ceil($result['posts'] / $postsperpage);
	}
	
	
	/**
	* parse messages and returns complete postbit
	*
	* @return string postbit
	*/
	function start() {
		global $postorder, $db;
		$this->getPostIds();	
		
		$this->orderBy = "ORDER BY p.posttime ".(($postorder) ? ("DESC") : ("ASC"));
		
		$count = 0;
		$postbit = '';
		$result = $this->readPosts();
		while ($row = $db->fetch_array($result)) $postbit .= $this->makePostBit($row, $count++);
		
		return $postbit;	
	}
	
	
	/**
	* get and stores the postids of the current page
	*
	* @return void
	*/
	function getPostIds() {
		global $visible, $db, $n, $_GET, $postsperpage, $postorder, $thread;
		$postcount = $thread['replycount'] + 1;
		
		if (isset($_GET['page'])) {
			$this->page = intval($_GET['page']);
			if ($this->page == 0) $this->page = 1;
		}
		else $this->page = 1;
		
		$this->pages = ceil($postcount / $postsperpage);
		if ($this->pages > 1) $this->makePagelink();
		
		$result = $db->unbuffered_query("SELECT postid, attachments FROM bb".$n."_posts WHERE threadid = '".$this->threadid."' $visible ORDER BY posttime ".(($postorder) ? ("DESC") : ("ASC")), 0, $postsperpage, $postsperpage * ($this->page - 1));
		while ($row = $db->fetch_array($result)) {
			$this->postids .= ",".$row['postid'];
			if ($row['attachments']) $this->readAttachments = true;
		}
	}
}












/** ThreadedThread Class **/
class ThreadedThread extends Thread {
	
	/**
	* @var integer offset
	*/
	var $offset = 0;

	/**
	* @var integer offset2
	*/
	var $offset2 = 0;

	/**
	* @var array cache
	*/
	var $cache = array();

	/**
	* @var array list
	*/
	var $list = array();

	/**
	* @var integer max
	*/
	var $max = -1;

	/**
	* @var integer total
	*/
	var $total = 0;

	/**
	* @var integer cout
	*/
	var $count = 0;

	/**
	* @var string postbitlist
	*/
	var $postbitlist = '';
	
	
	/**
	* constructor
	*
	* @param integer threadid
	*/
	function ThreadedThread($threadid) {
		$this->threadid = $threadid;
	}	
	
	
	/**
	* get and stores the pagenumber of a certain message
	*
	* @param integer postid
	*
	* @return void
	*/
	function gotoPost($postid) {
		global $_GET, $postsperpage, $db, $n, $visible;	
		
		$result = $db->query("SELECT postid, parentpostid, attachments FROM bb".$n."_posts WHERE threadid='".$this->threadid."' $visible ORDER BY posttime ASC");
		$this->total = $db->num_rows($result);
		while ($row = $db->fetch_array($result)) {
			$this->cache[$row['parentpostid']][$row['postid']] = 1;
			if ($row['attachments']) $this->readAttachments = true;
		}
		
		$this->countPosts($postid);
		$_GET['page'] = ceil($this->count / $postsperpage);
	}
	
	
	/**
	* get and stores the number of a certain message in threaded view
	* 
	* @param integer postid
	* @param integer count
	* @param integer parentid
	*
	* @return void
	*/
	function countPosts($finalpostid, $count = 0, $parentid = 0) {
		if (!isset($this->cache[$parentid])) return $count;
		reset($this->cache[$parentid]);
		
		while (list($postid, ) = each($this->cache[$parentid])) {
			$count++;
			if ($postid == $finalpostid) {
				$this->count = $count;
				break;
			}
			$count = $this->countPosts($finalpostid, $count, $postid); 	
		}
		
		return $count;	
	}
	
	/**
	* parse messages and returns complete postbit
	*
	* @return string postbit
	*/
	function start() {
		global $db, $n, $postsperpage, $_GET, $visible;
		
		if (isset($_GET['page'])) {
			$this->page = intval($_GET['page']);
			if ($this->page == 0) $this->page = 1;
		}
		else $this->page = 1;
		
		$this->offset = $postsperpage * ($this->page - 1);
		$this->offset2 = $this->offset + $postsperpage;
		
		if (count($this->cache) == 0) {
			$result = $db->query("SELECT postid, parentpostid, attachments FROM bb".$n."_posts WHERE threadid='".$this->threadid."' $visible ORDER BY posttime ASC");
			$this->total = $db->num_rows($result);
			while ($row = $db->fetch_array($result)) {
				$this->cache[$row['parentpostid']][$row['postid']] = 1;
				if ($row['attachments']) $this->readAttachments = true;
			}
		}
		
		$this->pages = ceil($this->total / $postsperpage);
		if ($this->pages > 1) $this->makePagelink();
		
		reset($this->cache);
		$this->generate();
		if ($this->max > 0) $this->sync();
		$result = $this->readPosts();
		
		while ($posts = $db->fetch_array($result)) {
			$temp = $this->list[$posts['postid']];
			$this->list[$posts['postid']] = $posts;
			$this->list[$posts['postid']]['depth'] = $temp;	
		}
		
		$count = 0;
		$postbit = '';
		reset($this->list);
		while (list($postid, ) = each($this->list)) {
			$postbit .= $this->makePostBit($this->list[$postid], $count++, $this->list[$postid]['depth'] * 15);
			$this->postbitlist .= $this->makePostBitList($this->list[$postid], $this->list[$postid]['depth'] * 15);
		}
		return $postbit;
	}
	
	
	/**
	* calculates the depth of the threaded view
	*
	* @param integer parentid
	* @param integer count
	* @param integer depth
	*
	* @return integer count
	*/
	function generate($parentid = 0, $count = 0, $depth = 0) {
		if (!isset($this->cache[$parentid])) return $count;
		reset($this->cache[$parentid]);
		
		while (list($postid, ) = each($this->cache[$parentid])) {
			if ($count >= $this->offset && $count < $this->offset2) {
				if ($this->max == -1) $this->max = $depth;
				if ($depth < $this->max) $this->max = $depth;
				
				$this->list[$postid] = $depth;
				$this->postids .= ",".$postid;	
			}	
			$count++;
			$count = $this->generate($postid, $count, $depth + 1); 	
		}
		
		return $count;
	}
	
	
	/**
	* generates a postlist
	* 
	* @param array posts
	* @param integer imgwidth
	*
	* @return string postlist
	*/
	function makePostBitList($posts, $imgwidth = 0) {
		global $tpl, $wbbuserdata, $lang, $SID_ARG_1ST, $SID_ARG_2ND, $SID_ARG_2ND_UN, $style, $thread;
		
		$postdate = formatdate($wbbuserdata['dateformat'], $posts['posttime']);
		$posttime = formatdate($wbbuserdata['timeformat'], $posts['posttime']);
		
		if (!$posts['posttopic']) $posts['posttopic'] = "RE: ".$thread['topic']; 
		$posts['posttopic'] = htmlconverter(textwrap($posts['posttopic']));
		$posts['username'] = htmlconverter(textwrap($posts['username'], 30));
		
		if ($posts['posttime'] > $thread['lastvisit']) $newpost = 1;
		else $newpost = 0;
		
		
		eval("\$postbit = \"".$tpl->get("thread_postbitlist")."\";");
		return $postbit;
	}
	
	/**
	* calculates the depth of the threaded view
	*
	* @return void
	*/
	function sync() {
		reset($this->list);
		while (list($postid, $depth) = each($this->list)) $this->list[$postid] = $depth - $this->max;
	}	
}













if (checkmodpermissions()) $visible = '';
else $visible = "AND visible=1";

if (isset($_REQUEST['threadview'])) $threadview = intval($_REQUEST['threadview']);
else $threadview = $wbbuserdata['threadview'];

if (isset($_REQUEST['hilight'])) $hilight = urldecode($_REQUEST['hilight']);
else $hilight = '';

if (isset($_REQUEST['hilightuser'])) $hilightuser = intval($_REQUEST['hilightuser']);
else $hilightuser = 0;

if (!isset($_REQUEST['goto'])) $_REQUEST['goto'] = '';

if ($threadview == 1) $t = &new ThreadedThread($threadid);
else $t = &new FlatThread($threadid);

/* goto actions 1 */
if ($_REQUEST['goto'] == "lastpost") $t->lastpost();
if ($_REQUEST['goto'] == "nextnewest") $t->nextnewest();
if ($_REQUEST['goto'] == "nextoldest") $t->nextoldest();

/* threadvisit */
if ($board['lastvisit'] > $thread['lastvisit']) $thread['lastvisit'] = $board['lastvisit'];
if ($wbbuserdata['lastvisit'] > $thread['lastvisit']) $thread['lastvisit'] = $wbbuserdata['lastvisit'];

/* goto actions 2 */
if ($_REQUEST['goto'] == "firstnew") $t->firstnew($thread['lastvisit']);
if ($_REQUEST['goto'] == "firstnew_thread") $t->firstnew($wbbuserdata['lastvisit']);


if ($wbbuserdata['umaxposts']) $postsperpage = $wbbuserdata['umaxposts'];
elseif ($board['postsperpage']) $postsperpage = $board['postsperpage'];
else $postsperpage = $default_postsperpage;
$postorder = $board['postorder'];

if (isset($postid)) $t->gotoPost($postid);

$db->unbuffered_query("UPDATE bb".$n."_threads SET views=views+1 WHERE threadid='$threadid'", 1);
if ($wbbuserdata['userid'] && $thread['lastposttime'] > $thread['lastvisit']) $db->unbuffered_query("REPLACE INTO bb".$n."_threadvisit (threadid,userid,lastvisit) VALUES ('".$threadid."','".$wbbuserdata['userid']."','".time()."')", 1);


$boardnavcache = array();
if ($showboardjump == 1) $boardjump = makeboardjump($boardid);
$navbar = getNavbar($board['parentlist']);
eval("\$navbar .= \"".$tpl->get("navbar_board")."\";");

$postbit = $t->start();
$thread_poll = '';
if ($thread['pollid']) {
	if (checkmodpermissions("m_can_edit_poll")) eval("\$mod_poll_edit = \"".$tpl->get("thread_poll_edit")."\";");
	unset($votecheck);
	
	$poll = $db->query_first("SELECT * FROM bb".$n."_polls WHERE pollid='$thread[pollid]'");
	$poll['question'] = htmlconverter($poll['question']);
	
	if ($poll['timeout'] == 0) $timeout = time() + 1;
	else $timeout = $poll['starttime'] + $poll['timeout'] * 86400;
	if ($_REQUEST['preresult'] != 1 && checkpermissions("can_vote_poll") == 1 && $timeout >= time()) {
		if ($wbbuserdata['userid']) $votecheck = $db->query_first("SELECT id AS pollid FROM bb".$n."_votes WHERE id='$thread[pollid]' AND votemode=1 AND userid='$wbbuserdata[userid]'");
		else $votecheck = $db->query_first("SELECT id AS pollid FROM bb".$n."_votes WHERE id='$thread[pollid]' AND votemode=1 AND ipaddress='$REMOTE_ADDR'");
	} 
	
	// already voted; show result
	if ($_REQUEST['preresult'] == 1 || $votecheck['pollid'] || !checkpermissions("can_vote_poll") || $timeout < time()) {
		$votes = 0;
		unset($polloption);
		$totalvotes = 0;
		$polloptions = array();
		$result = $db->unbuffered_query("SELECT * FROM bb".$n."_polloptions WHERE pollid='$thread[pollid]' ORDER BY votes DESC");
		while ($row = $db->fetch_array($result)) {
			$totalvotes += $row['votes'];
			$polloptions[] = $row;
		}
		
		$i = 1;
		if (count($polloptions)) {
			while (list($key, $row) = each($polloptions)) {
				$row['polloption'] = htmlconverter(textwrap($row['polloption']));
				if ($totalvotes) {
					$percent_float = $row['votes'] * 100 / $totalvotes;
					$percent = number_format($percent_float, 2);
					$percent_int = floor($percent_float) * 3;
					$percent_int += 1;	
				}
				else $percent = $percent_int = 0; 
				eval("\$thread_poll_resultbit .= \"".$tpl->get("thread_poll_resultbit")."\";");
				if ($i == 5) $i = 0;
				$i++;
			}
		}
		
		$lang->items['LANG_THREAD_POLL_VOTES'] = $lang->get("LANG_THREAD_POLL_VOTES", array('$totalvotes' => $totalvotes));
		eval("\$thread_poll = \"".$tpl->get("thread_poll_result")."\";");
	}
	else {
		if ($poll['choicecount'] > 1) $inputtype = "checkbox";
		else $inputtype = "radio";
		
		$result = $db->unbuffered_query("SELECT * FROM bb".$n."_polloptions WHERE pollid='$thread[pollid]' ORDER BY showorder ASC");
		while ($row = $db->fetch_array($result)) {
			$row['polloption'] = htmlconverter(textwrap($row['polloption']));
			eval("\$thread_pollbit .= \"".$tpl->get("thread_pollbit")."\";");
		}
		
		eval("\$thread_poll = \"".$tpl->get("thread_poll")."\";");
	}
}

if ($board['allowratings'] == 1) {
	$colors = createGradient($style['gradientleft'], $style['gradientmiddle'], $style['gradientright']);
	if ($thread['voted'] && $thread['voted'] >= $showvotes) $threadrating = threadrating($thread['votepoints'], $thread['voted']);
}
else $threadrating = '';

if ($board['closed'] == 0) eval("\$newthread = \"".$tpl->get("board_newthread")."\";");
if ($thread['closed'] != 0) eval("\$addreply = \"".$tpl->get("thread_closed")."\";");
elseif ($board['closed'] == 0) eval("\$addreply = \"".$tpl->get("thread_addreply")."\";");

$thread['topic'] = htmlconverter(textwrap($thread['topic']));

if ($board['emailnotify'] == 1 && $board['countemails'] != 0) $db->unbuffered_query("UPDATE bb".$n."_subscribeboards SET countemails=0 WHERE userid = '".$wbbuserdata['userid']."' AND boardid = '".$boardid."'", 1);
if ($thread['emailnotify'] == 1 && $thread['countemails'] != 0) $db->unbuffered_query("UPDATE bb".$n."_subscribethreads SET countemails=0 WHERE userid = '".$wbbuserdata['userid']."' AND threadid = '".$threadid."'", 1);

$hilight = htmlconverter($hilight);
eval("\$tpl->output(\"".$tpl->get("thread")."\");");
?>