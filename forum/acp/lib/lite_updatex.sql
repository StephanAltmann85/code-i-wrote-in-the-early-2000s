#
# 2.1.x to 2.2 beta 2 update sql
#

UPDATE bb1_optiongroups SET showorder = showorder + 1 WHERE showorder > 2;

INSERT INTO bb1_optiongroups VALUES (99,'email',3,1);


UPDATE bb1_options SET optioncode = '".$lang->load("BOARD")."<select name=\\"option[$row[optionid]]\\">\r\n <option value=\\"prefix\\">{$lang->items[\'LANG_BOARD_SORTFIELD_PREFIX\']}</option>\r\n <option value=\\"topic\\"".(($row[\'value\']=="topic") ? (" selected=\\"selected\\"") : ("")).">{$lang->items[\'LANG_BOARD_SORTFIELD_TOPIC\']}</option>\r\n <option value=\\"starttime\\"".(($row[\'value\']=="starttime") ? (" selected=\\"selected\\"") : ("")).">{$lang->items[\'LANG_BOARD_SORTFIELD_STARTTIME\']}</option>\r\n <option value=\\"replycount\\"".(($row[\'value\']=="replycount") ? (" selected=\\"selected\\"") : ("")).">{$lang->items[\'LANG_BOARD_SORTFIELD_REPLYCOUNT\']}</option>\r\n <option value=\\"starter\\"".(($row[\'value\']=="starter") ? (" selected=\\"selected\\"") : ("")).">{$lang->items[\'LANG_BOARD_SORTFIELD_STARTER\']}</option>\r\n <option value=\\"views\\"".(($row[\'value\']=="views") ? (" selected=\\"selected\\"") : ("")).">{$lang->items[\'LANG_BOARD_SORTFIELD_VIEWS\']}</option>\r\n <option value=\\"vote\\"".(($row[\'value\']=="vote") ? (" selected=\\"selected\\"") : ("")).">{$lang->items[\'LANG_BOARD_SORTFIELD_VOTE\']}</option>\r\n <option value=\\"lastposttime\\"".(($row[\'value\']=="lastposttime") ? (" selected=\\"selected\\"") : ("")).">{$lang->items[\'LANG_BOARD_SORTFIELD_LASTPOSTTIME\']}</option>\r\n <option value=\\"lastposter\\"".(($row[\'value\']=="lastposter") ? (" selected=\\"selected\\"") : ("")).">{$lang->items[\'LANG_BOARD_SORTFIELD_LASTPOSTER\']}</option>\r\n</select>' WHERE varname = 'default_sortfield';
UPDATE bb1_options SET optiongroupid = 99, showorder = 1 WHERE varname = 'frommail';
UPDATE bb1_options SET optiongroupid = 99, showorder = 2 WHERE varname = 'webmastermail';
UPDATE bb1_options SET optiongroupid = 99, showorder = 3 WHERE varname = 'smtp';

UPDATE bb1_options SET showorder = 10 WHERE varname = 'useronlinetimeout';
UPDATE bb1_options SET showorder = 11 WHERE varname = 'sessiontimeout';
UPDATE bb1_options SET showorder = 12 WHERE varname = 'adminsession_timeout';

UPDATE bb1_options SET showorder = 23 WHERE varname = 'register_default_checked_0';
UPDATE bb1_options SET showorder = 24 WHERE varname = 'register_default_checked_1';
UPDATE bb1_options SET showorder = 25 WHERE varname = 'register_default_checked_2';
UPDATE bb1_options SET showorder = 26 WHERE varname = 'register_default_checked_3';

DELETE FROM bb1_options WHERE varname = 'default_register_nosessionhash';

INSERT INTO bb1_options VALUES
	(NULL, 5, 'default_threadtemplate', '', 'textarea', 21, 2),
	(NULL, 5, 'default_posttemplate', '', 'textarea', 22, 2),
	(NULL, 9, 'showlanguageinprofile', '0', 'truefalse', 7, 1),
	(NULL, 17, 'show_archive', '0', 'truefalse', 7, 1),
	(NULL, 2, 'boardurls', '', 'textarea', 7, 1),
	(NULL, 2, 'imprint_url', '', 'text', 8, 1),
	(NULL, 2, 'imprint_text', '', 'textarea', 9, 1),
	(NULL, 17, 'postcache_daysprune', '7', 'text', 9, 2),
	(NULL, 99, 'socket', '0', 'truefalse', 4, 2),
	(NULL, 99, 'smtp_use_auth', '0', 'truefalse', 5, 2),
	(NULL, 99, 'smtp_user', '', 'text', 6, 2),
	(NULL, 99, 'smtp_pass', '', 'text', 7, 2),
	(NULL, 4, 'default_register_usewysiwyg', '0', 'truefalse', 22, 2),
	(NULL, 99, 'mailer_use_f_param', '1', 'truefalse', 8, 2);


UPDATE bb1_acpmenuitemgroups SET condition = 'a_can_otherstuff_ranks;a_can_otherstuff_threads;a_can_otherstuff_reindex;a_can_otherstuff_delindex;a_can_otherstuff_userposts;a_can_memberslist;a_can_otherstuff_wordmatch;a_can_users_edit' WHERE title = 'other1';
UPDATE bb1_acpmenuitemgroups SET condition = 'a_can_groups_add;a_can_groups_edit;a_can_groups_edit_own;a_can_groups_del;a_can_groups_variablegroups_set_securitylevel;a_can_boards_permissions;a_can_users_email' WHERE title = 'group';
UPDATE bb1_acpmenuitemgroups SET condition = 'a_can_languagepack_add;a_can_languagepack_edit;a_can_languagepack_del;a_can_languagepack_export;a_can_languagepack_import;a_can_languagepack_translate;a_can_languagepack_delitem;a_can_languagepack_additem;a_can_languagepack_addcategory;a_can_languagepack_delcategory;a_can_languagepack_search;a_can_languagepack_sync' WHERE title = 'languagepack';


UPDATE bb1_acpmenuitems SET showorder = 7 WHERE languageitem = 'TEMPLATE_CACHE';
UPDATE bb1_acpmenuitems SET showorder = 6 WHERE languageitem = 'LANGUAGEPACK_IMPORT';
UPDATE bb1_acpmenuitems SET showorder = 7 WHERE languageitem = 'LANGUAGEPACK_SEARCH';
UPDATE bb1_acpmenuitems SET showorder = 8 WHERE languageitem = 'LANGUAGEPACK_SYNC';
UPDATE bb1_acpmenuitems SET condition =  'a_can_groups_edit;a_can_groups_edit_own;a_can_groups_del;a_can_groups_add;a_can_boards_permissions;a_can_users_email' WHERE languageitem = 'GROUP_EDIT';

INSERT INTO bb1_acpmenuitems (itemgroupid, link, languageitem, linkformat, condition, conditiontype, showorder, acpmode) VALUES
	(9, 'avatar.php?action=backup', 'AVATAR_BACKUP', '', 'a_can_avatars_edit;a_can_avatars_del', 'OR', 3, 1),
	(8, 'languagepack.php?action=delcategory', 'LANGUAGECAT_DEL', '', 'a_can_languagepack_delcategory', 'OR', 5, 2);


INSERT INTO bb1_groupvariables VALUES 
	(NULL, 'a_can_view_hidden', 'truefalse', '0', 9, 7, 2),
	(NULL, 'a_can_be_ignored', 'truefalse', '0', 9, 8, 2),
	(NULL, 'a_can_ignore_maxpms', 'truefalse', '0', 9, 9, 2),
	(NULL, 'can_reply_own_topic', 'truefalse', '0', 7, 3, 1),
	(NULL, 'doublepost_timegap', 'inverse_integer', '0', 7, 3, 1),
	(NULL, 'a_can_languagepack_delcategory', 'truefalse', '0', 23, 10, 2);


UPDATE bb1_bbcodes SET pattern1 = '[^\\"\';}]*' WHERE bbcodetag = 'font';
UPDATE bb1_bbcodes SET pattern1 = '[1-3]?[0-9]{1}' WHERE bbcodetag = 'size';

UPDATE bb1_smilies SET smiliecode = '=)' WHERE smiliecode = ':))';


DROP TABLE IF EXISTS bb1_postcache;
CREATE TABLE bb1_postcache (
	postid int(11) unsigned NOT NULL auto_increment,
	threadid int(11) unsigned NOT NULL DEFAULT '0',
	cache mediumtext NOT NULL DEFAULT '',
	PRIMARY KEY (postid),
	INDEX threadid (threadid)
) TYPE=MyISAM;

ALTER TABLE bb1_boards
	ADD threadtemplateuse tinyint(1) NOT NULL DEFAULT '0' AFTER prefix,
	ADD threadtemplate text NOT NULL DEFAULT '' AFTER threadtemplateuse,
	ADD posttemplateuse tinyint(1) NOT NULL DEFAULT '0' AFTER threadtemplate,
	ADD posttemplate text NOT NULL DEFAULT '' AFTER posttemplateuse,
	ADD showinarchive tinyint(1) NOT NULL default '1' AFTER invisible;

ALTER TABLE bb1_groups
	ADD description text NOT NULL DEFAULT '' AFTER showorder;

ALTER TABLE bb1_permissions
	ADD can_reply_own_topic tinyint(1) NOT NULL DEFAULT '-1' AFTER can_reply_topic;

ALTER TABLE bb1_posts
	ADD INDEX parentpostid (parentpostid),
	ADD INDEX visible (visible, posttime),
	DROP INDEX userid,
	ADD INDEX userid (userid, visible);

ALTER TABLE bb1_searchs
	ADD searchhash varchar(32) NOT NULL DEFAULT '' AFTER searchid,
	ADD INDEX searchhash (searchhash);

ALTER TABLE bb1_templatepacks
	ADD parentid int(11) unsigned NOT NULL DEFAULT '0' AFTER templatefolder,
	ADD templatestructure mediumtext NOT NULL DEFAULT '' AFTER parentid;

ALTER TABLE bb1_templates
	ADD recompile tinyint(1) NOT NULL DEFAULT '1' AFTER template;

ALTER TABLE bb1_users
	ADD usewysiwyg tinyint(1) unsigned NOT NULL default '0' AFTER acpmenuhidelast,
	DROP nosessionhash;
