DROP TABLE IF EXISTS bb1_acpmenuitemgroups;
CREATE TABLE bb1_acpmenuitemgroups (
    itemgroupid smallint(5) unsigned NOT NULL auto_increment,
    title varchar(255) NOT NULL DEFAULT '',
    condition text NOT NULL DEFAULT '',
    conditiontype enum('OR','AND') NOT NULL DEFAULT 'OR',
    showorder smallint(5) unsigned NOT NULL DEFAULT '0',
    acpmode tinyint(3) unsigned NOT NULL DEFAULT '0',
    PRIMARY KEY (itemgroupid)
);

DROP TABLE IF EXISTS bb1_acpmenuitemgroupscount;
CREATE TABLE bb1_acpmenuitemgroupscount (
    userid int(11) unsigned NOT NULL DEFAULT '0',
    itemgroupid smallint(5) unsigned NOT NULL DEFAULT '0',
    count int(11) unsigned NOT NULL DEFAULT '0',
    lastaccesstime int(11) unsigned NOT NULL DEFAULT '0',
    PRIMARY KEY (userid, itemgroupid)
);

DROP TABLE IF EXISTS bb1_acpmenuitems;
CREATE TABLE bb1_acpmenuitems (
    itemid smallint(5) unsigned NOT NULL auto_increment,
    itemgroupid smallint(5) unsigned NOT NULL DEFAULT '0',
    link varchar(255) NOT NULL DEFAULT '',
    languageitem varchar(255) NOT NULL DEFAULT '',
    linkformat varchar(20) NOT NULL DEFAULT '',
    condition varchar(255) NOT NULL DEFAULT '',
    conditiontype enum('OR','AND') NOT NULL DEFAULT 'OR',
    showorder smallint(5) unsigned NOT NULL DEFAULT '0',
    acpmode tinyint(3) unsigned NOT NULL DEFAULT '0',
    PRIMARY KEY (itemid)
);

DROP TABLE IF EXISTS bb1_acpmenuitemscount;
CREATE TABLE bb1_acpmenuitemscount (
    userid int(11) unsigned NOT NULL DEFAULT '0',
    itemid smallint(5) unsigned NOT NULL DEFAULT '0',
    count int(11) unsigned NOT NULL DEFAULT '0',
    lastaccesstime int(11) unsigned NOT NULL DEFAULT '0',
    PRIMARY KEY (userid, itemid)
);

DROP TABLE IF EXISTS bb1_applications;
CREATE TABLE bb1_applications (
    applicationid int(11) unsigned NOT NULL auto_increment,
    userid int(11) unsigned NOT NULL DEFAULT '0',
    groupid int(11) unsigned NOT NULL DEFAULT '0',
    sendtime int(11) unsigned NOT NULL DEFAULT '0',
    reason text NOT NULL DEFAULT '',
    reply text NOT NULL DEFAULT '',
    status tinyint(1) NOT NULL DEFAULT '0',
    groupleaderid int(11) unsigned NOT NULL DEFAULT '0',
    notifyperemail tinyint(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (applicationid),
    UNIQUE userid (userid, groupid)
);

DROP TABLE IF EXISTS bb1_boardvisit;
CREATE TABLE bb1_boardvisit (
    boardid int(11) unsigned NOT NULL DEFAULT '0',
    userid int(11) unsigned NOT NULL DEFAULT '0',
    lastvisit int(11) unsigned NOT NULL DEFAULT '0',
    PRIMARY KEY (boardid, userid),
    INDEX userid (userid, lastvisit)
);

DROP TABLE IF EXISTS bb1_designelements;
CREATE TABLE bb1_designelements (
    elementid int(11) unsigned NOT NULL auto_increment,
    designpackid int(11) unsigned NOT NULL DEFAULT '0',
    element varchar(250) NOT NULL DEFAULT '',
    value text NOT NULL DEFAULT '',
    PRIMARY KEY (elementid),
    UNIQUE subvariablepackid (designpackid, element)
);

DROP TABLE IF EXISTS bb1_designpacks;
CREATE TABLE bb1_designpacks (
    designpackid int(11) unsigned NOT NULL auto_increment,
    designpackname varchar(100) NOT NULL DEFAULT '',
    PRIMARY KEY (designpackid)
);

DROP TABLE IF EXISTS bb1_groupcombinations;
CREATE TABLE bb1_groupcombinations (
    groupcombinationid int(11) unsigned NOT NULL auto_increment,
    groupids text NOT NULL DEFAULT '',
    data longtext NOT NULL DEFAULT '',
    PRIMARY KEY (groupcombinationid)
);

DROP TABLE IF EXISTS bb1_groupleaders;
CREATE TABLE bb1_groupleaders (
    userid int(11) unsigned NOT NULL DEFAULT '0',
    groupid int(11) unsigned NOT NULL DEFAULT '0',
    PRIMARY KEY (userid, groupid)
);

DROP TABLE IF EXISTS bb1_groupvalues;
CREATE TABLE bb1_groupvalues (
    groupid int(11) unsigned NOT NULL DEFAULT '0',
    variableid int(11) unsigned NOT NULL DEFAULT '0',
    value text NOT NULL DEFAULT '',
    PRIMARY KEY (groupid, variableid)
);

DROP TABLE IF EXISTS bb1_groupvariablegroups;
CREATE TABLE bb1_groupvariablegroups (
    variablegroupid int(11) unsigned NOT NULL auto_increment,
    parentvariablegroupid int(11) unsigned NOT NULL DEFAULT '0',
    title varchar(50) NOT NULL DEFAULT '',
    showorder smallint(5) unsigned NOT NULL DEFAULT '0',
    securitylevel smallint(5) unsigned NOT NULL DEFAULT '0',
    acpmode tinyint(3) unsigned NOT NULL DEFAULT '0',
    PRIMARY KEY (variablegroupid)
);

DROP TABLE IF EXISTS bb1_groupvariables;
CREATE TABLE bb1_groupvariables (
    variableid int(11) unsigned NOT NULL auto_increment,
    variablename varchar(50) NOT NULL DEFAULT '',
    type varchar(15) NOT NULL DEFAULT '',
    defaultvalue text NOT NULL DEFAULT '',
    variablegroupid int(11) unsigned NOT NULL DEFAULT '0',
    showorder mediumint(7) unsigned NOT NULL DEFAULT '0',
    acpmode tinyint(3) unsigned NOT NULL DEFAULT '0',
    PRIMARY KEY (variableid),
    UNIQUE variablename (variablename)
);

DROP TABLE IF EXISTS bb1_languagecats;
CREATE TABLE bb1_languagecats (
    catid int(11) NOT NULL auto_increment,
    catname varchar(100) NOT NULL DEFAULT '',
    PRIMARY KEY (catid),
    UNIQUE catname (catname)
);

DROP TABLE IF EXISTS bb1_languagepacks;
CREATE TABLE bb1_languagepacks (
    languagepackid smallint(5) NOT NULL DEFAULT '0',
    languagepackname varchar(100) NOT NULL DEFAULT '',
    languagecode varchar(10) NOT NULL DEFAULT '',
    PRIMARY KEY (languagepackid),
    INDEX languagecode (languagecode)
);

DROP TABLE IF EXISTS bb1_languages;
CREATE TABLE bb1_languages (
    itemid int(11) NOT NULL auto_increment,
    itemname varchar(100) NOT NULL DEFAULT '',
    languagepackid smallint(5) NOT NULL DEFAULT '0',
    catid int(11) NOT NULL DEFAULT '0',
    item mediumtext NOT NULL DEFAULT '',
    showorder mediumint(7) unsigned NOT NULL DEFAULT '0',
    PRIMARY KEY (itemid),
    UNIQUE languagepackid (languagepackid, itemname),
    INDEX languagepackid_2 (languagepackid, catid)
);

DROP TABLE IF EXISTS bb1_stats;
CREATE TABLE bb1_stats (
    threadcount int(11) unsigned NOT NULL DEFAULT '0',
    postcount int(11) unsigned NOT NULL DEFAULT '0',
    usercount int(11) unsigned NOT NULL DEFAULT '0',
    lastuserid int(11) unsigned NOT NULL DEFAULT '0'
);

DROP TABLE IF EXISTS bb1_threadvisit;
CREATE TABLE bb1_threadvisit (
    threadid int(11) unsigned NOT NULL DEFAULT '0',
    userid int(11) unsigned NOT NULL DEFAULT '0',
    lastvisit int(11) unsigned NOT NULL DEFAULT '0',
    PRIMARY KEY (threadid, userid),
    INDEX userid (userid, lastvisit)
);

DROP TABLE IF EXISTS bb1_user2groups;
CREATE TABLE bb1_user2groups (
    userid int(11) unsigned NOT NULL DEFAULT '0',
    groupid int(11) unsigned NOT NULL DEFAULT '0',
    PRIMARY KEY (userid, groupid),
    UNIQUE groupid (groupid, userid)
);



ALTER TABLE bb1_adminsessions
    ADD authentificationcode varchar(32) NOT NULL DEFAULT '' AFTER lastactivity,
    CHANGE hash sessionhash VARCHAR(32) NOT NULL;

ALTER TABLE bb1_bbcodes
    ADD pattern1 varchar(100) NOT NULL DEFAULT '' AFTER multiuse,
    ADD pattern2 varchar(100) NOT NULL DEFAULT '' AFTER pattern1,
    ADD pattern3 varchar(100) NOT NULL DEFAULT '' AFTER pattern2,
    ADD eval_replacement tinyint(1) NOT NULL DEFAULT '0' AFTER pattern3;

ALTER TABLE bb1_boards
    ADD allowratings tinyint(1) NOT NULL DEFAULT '1' AFTER lastposter,
    ADD sortfield varchar(20) NOT NULL DEFAULT '' AFTER daysprune,
    ADD sortorder varchar(5) NOT NULL DEFAULT '' AFTER sortfield,
    MODIFY title varchar(250) NOT NULL DEFAULT '',
    DROP allowbbcode,
    DROP allowimages,
    DROP allowhtml,
    DROP allowsmilies,
    DROP allowicons,
    DROP allowpolls,
    DROP allowattachments;


ALTER TABLE bb1_events
    ADD allowhtml tinyint(1) NOT NULL DEFAULT '0' AFTER allowsmilies,
    ADD allowbbcode tinyint(1) NOT NULL DEFAULT '1' AFTER allowhtml,
    ADD allowimages tinyint(1) NOT NULL DEFAULT '1' AFTER allowbbcode;


ALTER TABLE bb1_moderators
    ADD notify_newpost tinyint(1) NOT NULL DEFAULT '0' AFTER boardid,
    ADD notify_newthread tinyint(1) NOT NULL DEFAULT '0' AFTER notify_newpost,
    ADD m_can_thread_close tinyint(1) NOT NULL DEFAULT '-1' AFTER notify_newthread,
    ADD m_can_thread_move tinyint(1) NOT NULL DEFAULT '-1' AFTER m_can_thread_close,
    ADD m_can_thread_edit tinyint(1) NOT NULL DEFAULT '-1' AFTER m_can_thread_move,
    ADD m_can_post_del tinyint(1) NOT NULL DEFAULT '-1' AFTER m_can_thread_edit,
    ADD m_can_thread_del tinyint(1) NOT NULL DEFAULT '-1' AFTER m_can_post_del,
    ADD m_can_thread_merge tinyint(1) NOT NULL DEFAULT '-1' AFTER m_can_thread_del,
    ADD m_can_thread_cut tinyint(1) NOT NULL DEFAULT '-1' AFTER m_can_thread_merge,
    ADD m_can_thread_top tinyint(1) NOT NULL DEFAULT '-1' AFTER m_can_thread_cut,
    ADD m_can_add_poll tinyint(1) NOT NULL DEFAULT '-1' AFTER m_can_thread_top,
    ADD m_can_post_edit tinyint(1) NOT NULL DEFAULT '-1' AFTER m_can_add_poll,
    ADD m_can_announce tinyint(1) NOT NULL DEFAULT '-1' AFTER m_can_post_edit,
    ADD m_can_edit_poll tinyint(1) NOT NULL DEFAULT '-1' AFTER m_can_announce,
    ADD INDEX userid (userid);

ALTER TABLE bb1_optiongroups
    ADD acpmode tinyint(3) unsigned NOT NULL DEFAULT '0' AFTER showorder;

ALTER TABLE bb1_options
    ADD acpmode tinyint(3) unsigned NOT NULL DEFAULT '0' AFTER showorder,
    DROP title,
    DROP description;

ALTER TABLE bb1_posts
    ADD allowhtml tinyint(1) NOT NULL DEFAULT '0' AFTER allowsmilies,
    ADD allowbbcode tinyint(1) NOT NULL DEFAULT '1' AFTER allowhtml,
    ADD allowimages tinyint(1) NOT NULL DEFAULT '1' AFTER allowbbcode,
    ALTER allowsmilies SET DEFAULT 1,
    ADD INDEX reindex (reindex),
    DROP INDEX userid,
    ADD INDEX userid (userid, visible),
    ADD INDEX parentpostid (parentpostid),
    ADD INDEX visible (visible,posttime);

ALTER TABLE bb1_privatemessage
    ADD allowsmilies tinyint(1) NOT NULL DEFAULT '1' AFTER sendtime,
    ADD allowhtml tinyint(1) NOT NULL DEFAULT '0' AFTER allowsmilies,
    ADD allowbbcode tinyint(1) NOT NULL DEFAULT '1' AFTER allowhtml,
    ADD allowimages tinyint(1) NOT NULL DEFAULT '1' AFTER allowbbcode,
    DROP showsmilies,
    DROP INDEX senderid,
    ADD INDEX senderid (senderid, deletepm),
    DROP INDEX recipientid,
    ADD INDEX recipientid (recipientid, deletepm);

ALTER TABLE bb1_profilefields
    ADD fieldtype varchar(40) NOT NULL DEFAULT 'text' AFTER hidden,
    ADD fieldoptions text NOT NULL DEFAULT '' AFTER fieldtype,
    ADD choicecount tinyint(1) NOT NULL DEFAULT '0' AFTER fieldsize;

ALTER TABLE bb1_sessions
    ADD langid int(11) NOT NULL DEFAULT '0' AFTER styleid,
    ADD authentificationcode varchar(32) NOT NULL DEFAULT '' AFTER threadid,
    CHANGE hash sessionhash VARCHAR(32) NOT NULL;

ALTER TABLE bb1_styles
    ADD designpackid int(11) unsigned NOT NULL DEFAULT '0' AFTER templatepackid,
    CHANGE styleid styleid INT(11) UNSIGNED NOT NULL DEFAULT 0;

ALTER TABLE bb1_votes
    ADD INDEX id (id, votemode, userid),
    ADD INDEX id_2 (id, votemode, ipaddress),
    DROP INDEX userid,
    DROP INDEX ipaddress;
 
