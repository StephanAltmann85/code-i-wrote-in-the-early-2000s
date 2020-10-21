#
# 2.2.x to 2.3.0 Beta 2 update sql (part I)
#

UPDATE bb1_optiongroups SET showorder = showorder + 1 WHERE showorder >= 9;
INSERT INTO bb1_optiongroups VALUES (NULL, 'attachments', 9, 1);

INSERT INTO bb1_options VALUES 
	(NULL, 13, 'goodsearchwords', '', 'textarea', 4, 2),
	(NULL, 0, 'makethumbnails', '2', '<select name=\\"option[$row[optionid]]\\">\r\n <option value=\\"0\\">{$lang->items[\'LANG_ACP_GLOBAL_NO\']}</option>\r\n <option value=\\"1\\"".(($row[\'value\']==1) ? (" selected=\\"selected\\"") : ("")).">{$lang->items[\'LANG_ACP_OPTIONS_OPTION_MAKETHUMBNAILS_1\']}</option>\r\n <option value=\\"2\\"".(($row[\'value\']==2) ? (" selected=\\"selected\\"") : ("")).">{$lang->items[\'LANG_ACP_OPTIONS_OPTION_MAKETHUMBNAILS_2\']}</option>\r\n</select>', 4, 1),
	(NULL, 0, 'thumbnailwidth', '160', 'text', 6, 2),
	(NULL, 0, 'thumbnailheight', '160', 'text', 7, 2),
	(NULL, 0, 'thumbnailsperrow', '3', 'text', 5, 2),
	(NULL, 0, 'total_attachment_filesize_limit', '0', 'text', 1, 2),
	(NULL, 4, 'default_register_notificationperpm', '0', 'truefalse', 26, 2);

UPDATE bb1_acpmenuitemgroups SET `condition` = 'a_can_otherstuff_ranks;a_can_otherstuff_threads;a_can_otherstuff_reindex;a_can_otherstuff_delindex;a_can_otherstuff_userposts;a_can_memberslist;a_can_otherstuff_wordmatch;a_can_users_edit;a_can_users_email;a_can_otherstuff_thumbnails;a_can_otherstuff_pmcounters' WHERE title = 'other1';
INSERT INTO bb1_acpmenuitems VALUES (NULL, 16, 'otherstuff.php?action=mailqueue', 'OTHERSTUFF_MAILQUEUE', '%s', 'a_can_users_email', 'OR', 4, 1);
UPDATE bb1_acpmenuitems SET `condition` = 'a_can_otherstuff_ranks;a_can_otherstuff_threads;a_can_otherstuff_reindex;a_can_otherstuff_delindex;a_can_otherstuff_userposts;a_can_users_edit;a_can_otherstuff_thumbnails;a_can_otherstuff_pmcounters' WHERE languageitem = 'OTHERSTUFF_UPDATEVIEW';

INSERT INTO bb1_groupvariables VALUES 
	(NULL, 'max_pms_recipients', 'integer', '5', 8, 7, 2),
	(NULL, 'a_can_groups_pmsend', 'truefalse', '0', 10, 6, 2),
	(NULL, 'max_pms', 'integer', '100', 8, 8, 1),
	(NULL, 'max_pms_folders', 'integer', '2', 8, 9, 1),
	(NULL, 'max_attachments', 'integer', '5', 7, 25, 1),
	(NULL, 'can_upload_pm_attachments', 'truefalse', '1', 8, 10, 1),
	(NULL, 'max_pm_attachments', 'integer', '5', 8, 11, 1),
	(NULL, 'max_pm_attachment_size', 'integer', '20480', 8, 12, 1),
	(NULL, 'allowed_pm_attachment_extensions', 'string', 'gif\r\njpg\r\njpeg\r\npng\r\nbmp\r\nzip\r\ntxt', 8, 13, 1),
	(NULL, 'total_attachment_filesize_limit', 'integer', '-1', 7, 26, 1),
	(NULL, 'a_can_otherstuff_thumbnails', 'truefalse', '0', 21, 8, 2),
	(NULL, 'a_can_otherstuff_pmcounters', 'truefalse', '0', 21, 9, 2);




DROP TABLE IF EXISTS bb1_mailqueue;
CREATE TABLE bb1_mailqueue (
    mailid int(11) unsigned NOT NULL DEFAULT '0',
    userid int(11) unsigned NOT NULL DEFAULT '0',
    email varchar(150) NOT NULL DEFAULT '',
    username varchar(50) NOT NULL DEFAULT '',
    PRIMARY KEY (mailid, userid)
);

DROP TABLE IF EXISTS bb1_mails;
CREATE TABLE bb1_mails (
    mailid int(11) unsigned NOT NULL auto_increment,
    subject varchar(50) NOT NULL DEFAULT '',
    message mediumtext NOT NULL DEFAULT '',
    sender varchar(50) NOT NULL DEFAULT '',
    otherheaders varchar(255) NOT NULL DEFAULT '',
    userid int(11) unsigned NOT NULL DEFAULT '0',
    sendtime int(11) unsigned NOT NULL DEFAULT '0',
    recipients int(11) unsigned NOT NULL DEFAULT '0',
    PRIMARY KEY (mailid)
);

DROP TABLE IF EXISTS bb1_privatemessagereceipts;
CREATE TABLE bb1_privatemessagereceipts (
    privatemessageid int(11) unsigned NOT NULL DEFAULT '0',
    recipientid int(11) unsigned NOT NULL DEFAULT '0',
    recipient varchar(50) NOT NULL DEFAULT '',
    blindcopy tinyint(1) NOT NULL DEFAULT '0',
    folderid int(11) unsigned NOT NULL DEFAULT '0',
    deletepm tinyint(1) NOT NULL DEFAULT '0',
    view int(11) unsigned NOT NULL DEFAULT '0',
    reply tinyint(1) NOT NULL DEFAULT '0',
    forward tinyint(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (privatemessageid, recipientid),
    INDEX recipientid (recipientid, deletepm, folderid)
);


ALTER TABLE bb1_attachments
    ADD privatemessageid int(11) unsigned NOT NULL DEFAULT '0' AFTER postid,
    ADD userid int(11) unsigned NOT NULL DEFAULT '0' AFTER privatemessageid,
    ADD thumbnailextension varchar(7) NOT NULL DEFAULT '' AFTER attachmentsize,
    ADD thumbnailsize int(11) unsigned NOT NULL DEFAULT '0' AFTER thumbnailextension,
    ADD idhash varchar(32) NOT NULL DEFAULT '' AFTER counter,
    ADD uploadtime int(11) unsigned NOT NULL DEFAULT '0' AFTER idhash,
    ADD INDEX privatemessageid (privatemessageid),
    ADD INDEX userid (userid);

ALTER TABLE bb1_boards
    ADD prefixrequired tinyint(1) NOT NULL DEFAULT '0' AFTER prefixuse,
    ADD externalurl varchar(255) NOT NULL DEFAULT '' AFTER showinarchive;

ALTER TABLE bb1_polls
    ADD idhash varchar(32) NOT NULL DEFAULT '' AFTER timeout;
        

ALTER TABLE bb1_posts
    ADD attachments int(11) unsigned NOT NULL DEFAULT '0' AFTER message,
    ADD INDEX attachments (attachments);

ALTER TABLE bb1_privatemessage
    ADD recipientlist mediumtext NOT NULL DEFAULT '' AFTER senderid,
    ADD recipientcount int(11) unsigned NOT NULL DEFAULT '0' AFTER recipientlist,
    ADD inoutbox tinyint(1) NOT NULL DEFAULT '0' AFTER iconid,
    ADD attachments int(11) unsigned NOT NULL DEFAULT '0' AFTER tracking,
    ADD pmhash varchar(32) NOT NULL DEFAULT '' AFTER attachments,
    MODIFY message mediumtext NOT NULL DEFAULT '',
    ADD INDEX pmhash (pmhash, sendtime),
    DROP INDEX senderid,
    ADD INDEX senderid (senderid, inoutbox);
    
ALTER TABLE bb1_users
    ADD notificationperpm tinyint(1) NOT NULL DEFAULT '0' AFTER emailnotify,
    ADD pmtotalcount int(11) unsigned NOT NULL DEFAULT '0' AFTER usewysiwyg,
    ADD pminboxcount int(11) unsigned NOT NULL DEFAULT '0' AFTER pmtotalcount,
    ADD pmnewcount int(11) unsigned NOT NULL DEFAULT '0' AFTER pminboxcount,
    ADD pmunreadcount int(11) unsigned NOT NULL DEFAULT '0' AFTER pmnewcount;
