#
# Tabellenstruktur für Tabelle `bb1_access`
#

DROP TABLE IF EXISTS bb1_access;
CREATE TABLE bb1_access (
  boardid int(11) unsigned NOT NULL default '0',
  userid int(11) unsigned NOT NULL default '0',
  can_view_board tinyint(1) NOT NULL default '-1',
  can_enter_board tinyint(1) NOT NULL default '-1',
  can_read_thread tinyint(1) NOT NULL default '-1',
  can_start_topic tinyint(1) NOT NULL default '-1',
  can_reply_topic tinyint(1) NOT NULL default '-1',
  can_post_poll tinyint(1) NOT NULL default '-1',
  can_upload_attachments tinyint(1) NOT NULL default '-1',
  can_download_attachments tinyint(1) NOT NULL default '-1',
  can_post_without_moderation tinyint(1) NOT NULL default '-1',
  can_close_own_topic tinyint(1) NOT NULL default '-1',
  can_use_search tinyint(1) NOT NULL default '-1',
  can_vote_poll tinyint(1) NOT NULL default '-1',
  can_rate_thread tinyint(1) NOT NULL default '-1',
  can_del_own_post tinyint(1) NOT NULL default '-1',
  can_edit_own_post tinyint(1) NOT NULL default '-1',
  can_del_own_topic tinyint(1) NOT NULL default '-1',
  can_edit_own_topic tinyint(1) NOT NULL default '-1',
  can_move_own_topic tinyint(1) NOT NULL default '-1',
  can_use_post_html tinyint(1) NOT NULL default '-1',
  can_use_post_bbcode tinyint(1) NOT NULL default '-1',
  can_use_post_smilies tinyint(1) NOT NULL default '-1',
  can_use_post_icons tinyint(1) NOT NULL default '-1',
  can_use_post_images tinyint(1) NOT NULL default '-1',
  PRIMARY KEY  (userid,boardid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_acpmenuitemgroups`
#

DROP TABLE IF EXISTS bb1_acpmenuitemgroups;
CREATE TABLE bb1_acpmenuitemgroups (
  itemgroupid smallint(5) unsigned NOT NULL auto_increment,
  title varchar(255) NOT NULL default '',
  `condition` text NOT NULL,
  conditiontype enum('OR','AND') NOT NULL default 'OR',
  showorder smallint(5) unsigned NOT NULL default '0',
  acpmode tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (itemgroupid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_acpmenuitemgroupscount`
#

DROP TABLE IF EXISTS bb1_acpmenuitemgroupscount;
CREATE TABLE bb1_acpmenuitemgroupscount (
  userid int(11) unsigned NOT NULL default '0',
  itemgroupid smallint(5) unsigned NOT NULL default '0',
  count int(11) unsigned NOT NULL default '0',
  lastaccesstime int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (userid,itemgroupid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_acpmenuitems`
#

DROP TABLE IF EXISTS bb1_acpmenuitems;
CREATE TABLE bb1_acpmenuitems (
  itemid smallint(5) unsigned NOT NULL auto_increment,
  itemgroupid smallint(5) unsigned NOT NULL default '0',
  link varchar(255) NOT NULL default '',
  languageitem varchar(255) NOT NULL default '',
  linkformat varchar(20) NOT NULL default '',
  `condition` varchar(255) NOT NULL default '',
  conditiontype enum('OR','AND') NOT NULL default 'OR',
  showorder smallint(5) unsigned NOT NULL default '0',
  acpmode tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (itemid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_acpmenuitemscount`
#

DROP TABLE IF EXISTS bb1_acpmenuitemscount;
CREATE TABLE bb1_acpmenuitemscount (
  userid int(11) unsigned NOT NULL default '0',
  itemid smallint(5) unsigned NOT NULL default '0',
  count int(11) unsigned NOT NULL default '0',
  lastaccesstime int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (userid,itemid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_adminsessions`
#

DROP TABLE IF EXISTS bb1_adminsessions;
CREATE TABLE bb1_adminsessions (
  sessionhash varchar(32) NOT NULL default '',
  userid int(11) unsigned NOT NULL default '0',
  ipaddress varchar(16) NOT NULL default '',
  useragent varchar(100) NOT NULL default '',
  starttime int(11) unsigned NOT NULL default '0',
  lastactivity int(11) unsigned NOT NULL default '0',
  authentificationcode varchar(32) NOT NULL default '',
  PRIMARY KEY  (sessionhash)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_announcements`
#

DROP TABLE IF EXISTS bb1_announcements;
CREATE TABLE bb1_announcements (
  boardid int(11) NOT NULL default '0',
  threadid int(11) NOT NULL default '0',
  PRIMARY KEY  (boardid,threadid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_applications`
#

DROP TABLE IF EXISTS bb1_applications;
CREATE TABLE bb1_applications (
  applicationid int(11) unsigned NOT NULL auto_increment,
  userid int(11) unsigned NOT NULL default '0',
  groupid int(11) unsigned NOT NULL default '0',
  sendtime int(11) unsigned NOT NULL default '0',
  reason text NOT NULL,
  reply text NOT NULL,
  status tinyint(1) NOT NULL default '0',
  groupleaderid int(11) unsigned NOT NULL default '0',
  notifyperemail tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (applicationid),
  UNIQUE KEY userid (userid,groupid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_attachments`
#

DROP TABLE IF EXISTS bb1_attachments;
CREATE TABLE bb1_attachments (
  attachmentid int(11) unsigned NOT NULL auto_increment,
  postid int(11) unsigned NOT NULL default '0',
  privatemessageid int(11) unsigned NOT NULL default '0',
  userid int(11) unsigned NOT NULL default '0',
  attachmentname varchar(250) NOT NULL default '',
  attachmentextension varchar(7) NOT NULL default '',
  attachmentsize int(11) unsigned NOT NULL default '0',
  thumbnailextension varchar(7) NOT NULL default '',
  thumbnailsize int(11) unsigned NOT NULL default '0',
  counter int(11) unsigned NOT NULL default '0',
  idhash varchar(32) NOT NULL default '',
  uploadtime int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (attachmentid),
  KEY postid (postid),
  KEY privatemessageid (privatemessageid),
  KEY userid (userid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_avatars`
#

DROP TABLE IF EXISTS bb1_avatars;
CREATE TABLE bb1_avatars (
  avatarid int(11) unsigned NOT NULL auto_increment,
  avatarname varchar(250) NOT NULL default '',
  avatarextension varchar(7) NOT NULL default '',
  width smallint(5) unsigned NOT NULL default '0',
  height smallint(5) unsigned NOT NULL default '0',
  groupid int(11) unsigned NOT NULL default '0',
  needposts mediumint(7) unsigned NOT NULL default '0',
  userid int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (avatarid),
  KEY userid (userid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_bbcodes`
#

DROP TABLE IF EXISTS bb1_bbcodes;
CREATE TABLE bb1_bbcodes (
  bbcodeid int(11) unsigned NOT NULL auto_increment,
  bbcodetag varchar(250) NOT NULL default '',
  bbcodereplacement text NOT NULL,
  bbcodeexample varchar(250) NOT NULL default '',
  bbcodeexplanation text NOT NULL,
  params tinyint(1) unsigned NOT NULL default '1',
  multiuse tinyint(3) unsigned NOT NULL default '1',
  pattern1 varchar(100) NOT NULL default '',
  pattern2 varchar(100) NOT NULL default '',
  pattern3 varchar(100) NOT NULL default '',
  eval_replacement tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (bbcodeid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_boards`
#

DROP TABLE IF EXISTS bb1_boards;
CREATE TABLE bb1_boards (
  boardid int(11) unsigned NOT NULL auto_increment,
  styleid int(11) unsigned NOT NULL default '0',
  parentid int(11) unsigned NOT NULL default '0',
  parentlist text NOT NULL,
  childlist text NOT NULL,
  boardorder mediumint(7) unsigned NOT NULL default '1',
  title varchar(250) NOT NULL default '',
  password varchar(25) NOT NULL default '',
  description text NOT NULL,
  prefixuse tinyint(1) NOT NULL default '0',
  prefixrequired tinyint(1) NOT NULL default '0',
  prefix text NOT NULL,
  threadtemplateuse tinyint(1) NOT NULL default '0',
  threadtemplate text NOT NULL,
  posttemplateuse tinyint(1) NOT NULL default '0',
  posttemplate text NOT NULL,
  threadcount int(11) unsigned NOT NULL default '0',
  postcount int(11) unsigned NOT NULL default '0',
  lastthreadid int(11) unsigned NOT NULL default '0',
  lastposttime int(11) unsigned NOT NULL default '0',
  lastposterid int(11) unsigned NOT NULL default '0',
  lastposter varchar(50) NOT NULL default '0',
  allowratings tinyint(1) NOT NULL default '1',
  daysprune smallint(5) unsigned NOT NULL default '0',
  sortfield varchar(20) NOT NULL default '',
  sortorder varchar(5) NOT NULL default '',
  threadsperpage smallint(5) unsigned NOT NULL default '0',
  postsperpage smallint(5) unsigned NOT NULL default '0',
  postorder tinyint(1) NOT NULL default '0',
  countuserposts tinyint(1) NOT NULL default '1',
  hotthread_reply smallint(5) unsigned NOT NULL default '0',
  hotthread_view smallint(5) unsigned NOT NULL default '0',
  moderatenew tinyint(2) NOT NULL default '0',
  enforcestyle tinyint(1) NOT NULL default '0',
  closed tinyint(1) NOT NULL default '0',
  isboard tinyint(1) NOT NULL default '0',
  invisible tinyint(1) NOT NULL default '0',
  showinarchive tinyint(1) NOT NULL default '1',
  externalurl varchar(255) NOT NULL default '',
  PRIMARY KEY  (boardid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_boardvisit`
#

DROP TABLE IF EXISTS bb1_boardvisit;
CREATE TABLE bb1_boardvisit (
  boardid int(11) unsigned NOT NULL default '0',
  userid int(11) unsigned NOT NULL default '0',
  lastvisit int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (boardid,userid),
  KEY userid (userid,lastvisit)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_designelements`
#

DROP TABLE IF EXISTS bb1_designelements;
CREATE TABLE bb1_designelements (
  elementid int(11) unsigned NOT NULL auto_increment,
  designpackid int(11) unsigned NOT NULL default '0',
  element varchar(250) NOT NULL default '',
  value text NOT NULL,
  PRIMARY KEY  (elementid),
  UNIQUE KEY subvariablepackid (designpackid,element)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_designpacks`
#

DROP TABLE IF EXISTS bb1_designpacks;
CREATE TABLE bb1_designpacks (
  designpackid int(11) unsigned NOT NULL auto_increment,
  designpackname varchar(100) NOT NULL default '',
  PRIMARY KEY  (designpackid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_events`
#

DROP TABLE IF EXISTS bb1_events;
CREATE TABLE bb1_events (
  eventid int(11) unsigned NOT NULL auto_increment,
  userid int(11) unsigned NOT NULL default '0',
  groupid int(11) unsigned NOT NULL default '0',
  subject varchar(250) NOT NULL default '',
  event mediumtext NOT NULL,
  eventdate date NOT NULL default '0000-00-00',
  public tinyint(1) NOT NULL default '0',
  allowsmilies tinyint(1) NOT NULL default '1',
  allowhtml tinyint(1) NOT NULL default '0',
  allowbbcode tinyint(1) NOT NULL default '1',
  allowimages tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (eventid),
  KEY groupid (groupid),
  KEY userid (userid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_folders`
#

DROP TABLE IF EXISTS bb1_folders;
CREATE TABLE bb1_folders (
  folderid int(11) unsigned NOT NULL auto_increment,
  userid int(11) unsigned NOT NULL default '0',
  title varchar(100) NOT NULL default '',
  PRIMARY KEY  (folderid),
  KEY userid (userid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_groupcombinations`
#

DROP TABLE IF EXISTS bb1_groupcombinations;
CREATE TABLE bb1_groupcombinations (
  groupcombinationid int(11) unsigned NOT NULL auto_increment,
  groupids text NOT NULL,
  data longtext NOT NULL,
  PRIMARY KEY  (groupcombinationid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_groupleaders`
#

DROP TABLE IF EXISTS bb1_groupleaders;
CREATE TABLE bb1_groupleaders (
  userid int(11) unsigned NOT NULL default '0',
  groupid int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (userid,groupid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_groups`
#

DROP TABLE IF EXISTS bb1_groups;
CREATE TABLE bb1_groups (
  groupid int(11) unsigned NOT NULL auto_increment,
  title varchar(50) NOT NULL default '',
  grouptype tinyint(1) NOT NULL default '0',
  useronlinemarking varchar(255) NOT NULL default '%s',
  priority tinyint(1) NOT NULL default '0',
  securitylevel smallint(5) unsigned NOT NULL default '0',
  ai_posts smallint(5) NOT NULL default '-1',
  ai_days smallint(5) NOT NULL default '-1',
  showonteam tinyint(1) NOT NULL default '0',
  showorder smallint(5) NOT NULL default '0',
  description text NOT NULL default '',
  PRIMARY KEY  (groupid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_groupvalues`
#

DROP TABLE IF EXISTS bb1_groupvalues;
CREATE TABLE bb1_groupvalues (
  groupid int(11) unsigned NOT NULL default '0',
  variableid int(11) unsigned NOT NULL default '0',
  value text NOT NULL,
  PRIMARY KEY  (groupid,variableid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_groupvariablegroups`
#

DROP TABLE IF EXISTS bb1_groupvariablegroups;
CREATE TABLE bb1_groupvariablegroups (
  variablegroupid int(11) unsigned NOT NULL auto_increment,
  parentvariablegroupid int(11) unsigned NOT NULL default '0',
  title varchar(50) NOT NULL default '',
  showorder smallint(5) unsigned NOT NULL default '0',
  securitylevel smallint(5) unsigned NOT NULL default '0',
  acpmode tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (variablegroupid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_groupvariables`
#

DROP TABLE IF EXISTS bb1_groupvariables;
CREATE TABLE bb1_groupvariables (
  variableid int(11) unsigned NOT NULL auto_increment,
  variablename varchar(50) NOT NULL default '',
  type varchar(15) NOT NULL default '',
  defaultvalue text NOT NULL,
  variablegroupid int(11) unsigned NOT NULL default '0',
  showorder mediumint(7) unsigned NOT NULL default '0',
  acpmode tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (variableid),
  UNIQUE KEY variablename (variablename)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_icons`
#

DROP TABLE IF EXISTS bb1_icons;
CREATE TABLE bb1_icons (
  iconid int(11) unsigned NOT NULL auto_increment,
  iconpath varchar(250) NOT NULL default '',
  icontitle varchar(250) NOT NULL default '',
  iconorder mediumint(7) unsigned NOT NULL default '0',
  PRIMARY KEY  (iconid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_languagecats`
#

DROP TABLE IF EXISTS bb1_languagecats;
CREATE TABLE bb1_languagecats (
  catid int(11) NOT NULL auto_increment,
  catname varchar(100) NOT NULL default '',
  PRIMARY KEY  (catid),
  UNIQUE KEY catname (catname)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_languagepacks`
#

DROP TABLE IF EXISTS bb1_languagepacks;
CREATE TABLE bb1_languagepacks (
  languagepackid smallint(5) NOT NULL default '0',
  languagepackname varchar(100) NOT NULL default '',
  languagecode varchar(10) NOT NULL default '',
  PRIMARY KEY  (languagepackid),
  KEY languagecode (languagecode)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_mailqueue`
#

DROP TABLE IF EXISTS bb1_mailqueue;
CREATE TABLE bb1_mailqueue (
  mailid int(11) unsigned NOT NULL default '0',
  userid int(11) unsigned NOT NULL default '0',
  email varchar(150) NOT NULL default '',
  username varchar(50) NOT NULL default '',
  PRIMARY KEY  (mailid,userid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_mails`
#

DROP TABLE IF EXISTS bb1_mails;
CREATE TABLE bb1_mails (
  mailid int(11) unsigned NOT NULL auto_increment,
  subject varchar(50) NOT NULL default '',
  message mediumtext NOT NULL,
  sender varchar(50) NOT NULL default '',
  otherheaders varchar(255) NOT NULL default '',
  userid int(11) unsigned NOT NULL default '0',
  sendtime int(11) unsigned NOT NULL default '0',
  recipients int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (mailid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_languages`
#

DROP TABLE IF EXISTS bb1_languages;
CREATE TABLE bb1_languages (
  itemid int(11) NOT NULL auto_increment,
  itemname varchar(100) NOT NULL default '',
  languagepackid smallint(5) NOT NULL default '0',
  catid int(11) NOT NULL default '0',
  item mediumtext NOT NULL,
  showorder mediumint(7) unsigned NOT NULL default '0',
  PRIMARY KEY  (itemid),
  UNIQUE KEY languagepackid (languagepackid,itemname),
  KEY languagepackid_2 (languagepackid,catid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_moderators`
#

DROP TABLE IF EXISTS bb1_moderators;
CREATE TABLE bb1_moderators (
  userid int(11) unsigned NOT NULL default '0',
  boardid int(11) unsigned NOT NULL default '0',
  notify_newpost tinyint(1) NOT NULL default '0',
  notify_newthread tinyint(1) NOT NULL default '0',
  m_can_thread_close tinyint(1) NOT NULL default '-1',
  m_can_thread_move tinyint(1) NOT NULL default '-1',
  m_can_thread_edit tinyint(1) NOT NULL default '-1',
  m_can_post_del tinyint(1) NOT NULL default '-1',
  m_can_thread_del tinyint(1) NOT NULL default '-1',
  m_can_thread_merge tinyint(1) NOT NULL default '-1',
  m_can_thread_cut tinyint(1) NOT NULL default '-1',
  m_can_thread_top tinyint(1) NOT NULL default '-1',
  m_can_add_poll tinyint(1) NOT NULL default '-1',
  m_can_post_edit tinyint(1) NOT NULL default '-1',
  m_can_announce tinyint(1) NOT NULL default '-1',
  m_can_edit_poll tinyint(1) NOT NULL default '-1',
  PRIMARY KEY  (boardid,userid),
  KEY userid (userid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_optiongroups`
#

DROP TABLE IF EXISTS bb1_optiongroups;
CREATE TABLE bb1_optiongroups (
  optiongroupid int(11) unsigned NOT NULL auto_increment,
  title varchar(100) NOT NULL default '',
  showorder mediumint(7) unsigned NOT NULL default '0',
  acpmode tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (optiongroupid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_options`
#

DROP TABLE IF EXISTS bb1_options;
CREATE TABLE bb1_options (
  optionid int(11) unsigned NOT NULL auto_increment,
  optiongroupid int(11) unsigned NOT NULL default '0',
  varname varchar(250) NOT NULL default '',
  value text NOT NULL,
  optioncode text NOT NULL,
  showorder mediumint(7) unsigned NOT NULL default '0',
  acpmode tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (optionid),
  KEY optiongroupid (optiongroupid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_permissions`
#

DROP TABLE IF EXISTS bb1_permissions;
CREATE TABLE bb1_permissions (
  boardid int(11) unsigned NOT NULL default '0',
  groupid int(11) unsigned NOT NULL default '0',
  can_view_board tinyint(1) NOT NULL default '-1',
  can_enter_board tinyint(1) NOT NULL default '-1',
  can_read_thread tinyint(1) NOT NULL default '-1',
  can_start_topic tinyint(1) NOT NULL default '-1',
  can_reply_topic tinyint(1) NOT NULL default '-1',
  can_reply_own_topic tinyint(1) NOT NULL default '-1',
  can_post_poll tinyint(1) NOT NULL default '-1',
  can_upload_attachments tinyint(1) NOT NULL default '-1',
  can_download_attachments tinyint(1) NOT NULL default '-1',
  can_post_without_moderation tinyint(1) NOT NULL default '-1',
  can_close_own_topic tinyint(1) NOT NULL default '-1',
  can_use_search tinyint(1) NOT NULL default '-1',
  can_vote_poll tinyint(1) NOT NULL default '-1',
  can_rate_thread tinyint(1) NOT NULL default '-1',
  can_del_own_post tinyint(1) NOT NULL default '-1',
  can_edit_own_post tinyint(1) NOT NULL default '-1',
  can_del_own_topic tinyint(1) NOT NULL default '-1',
  can_edit_own_topic tinyint(1) NOT NULL default '-1',
  can_move_own_topic tinyint(1) NOT NULL default '-1',
  can_use_post_html tinyint(1) NOT NULL default '-1',
  can_use_post_bbcode tinyint(1) NOT NULL default '-1',
  can_use_post_smilies tinyint(1) NOT NULL default '-1',
  can_use_post_icons tinyint(1) NOT NULL default '-1',
  can_use_post_images tinyint(1) NOT NULL default '-1',
  can_use_prefix tinyint(1) NOT NULL default '-1',
  PRIMARY KEY  (boardid,groupid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_polloptions`
#

DROP TABLE IF EXISTS bb1_polloptions;
CREATE TABLE bb1_polloptions (
  polloptionid int(11) unsigned NOT NULL auto_increment,
  pollid int(11) unsigned NOT NULL default '0',
  polloption varchar(250) NOT NULL default '',
  votes mediumint(7) unsigned NOT NULL default '0',
  showorder tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (polloptionid),
  KEY pollid (pollid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_polls`
#

DROP TABLE IF EXISTS bb1_polls;
CREATE TABLE bb1_polls (
  pollid int(11) unsigned NOT NULL auto_increment,
  threadid int(11) unsigned NOT NULL default '0',
  question varchar(100) NOT NULL default '',
  starttime int(11) unsigned NOT NULL default '0',
  choicecount tinyint(3) unsigned NOT NULL default '0',
  timeout mediumint(7) unsigned NOT NULL default '0',
  idhash varchar(32) NOT NULL default '',
  PRIMARY KEY  (pollid),
  KEY threadid (threadid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_postcache`
#

DROP TABLE IF EXISTS bb1_postcache;
CREATE TABLE bb1_postcache (
  postid int(11) unsigned NOT NULL auto_increment,
  threadid int(11) unsigned NOT NULL default '0',
  cache mediumtext NOT NULL,
  PRIMARY KEY  (postid),
  KEY threadid (threadid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_posts`
#

DROP TABLE IF EXISTS bb1_posts;
CREATE TABLE bb1_posts (
  postid int(11) unsigned NOT NULL auto_increment,
  parentpostid int(11) unsigned NOT NULL default '0',
  threadid int(11) unsigned NOT NULL default '0',
  userid int(11) unsigned NOT NULL default '0',
  username varchar(50) NOT NULL default '0',
  iconid int(11) unsigned NOT NULL default '0',
  posttopic varchar(100) NOT NULL default '',
  posttime int(11) unsigned NOT NULL default '0',
  message mediumtext NOT NULL,
  attachments int(11) unsigned NOT NULL default '0',
  edittime int(11) unsigned NOT NULL default '0',
  editorid int(11) unsigned NOT NULL default '0',
  editor varchar(50) NOT NULL default '',
  editcount mediumint(7) unsigned NOT NULL default '0',
  allowsmilies tinyint(1) NOT NULL default '1',
  allowhtml tinyint(1) NOT NULL default '0',
  allowbbcode tinyint(1) NOT NULL default '1',
  allowimages tinyint(1) NOT NULL default '1',
  showsignature tinyint(1) NOT NULL default '0',
  ipaddress varchar(15) NOT NULL default '',
  visible tinyint(1) NOT NULL default '0',
  reindex tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (postid),
  KEY iconid (iconid),
  KEY userid (userid,visible),
  KEY attachments (attachments),
  KEY threadid (threadid,visible),
  KEY threadid_2 (threadid,userid),
  KEY parentpostid (parentpostid),
  KEY visible (visible,posttime),
  KEY reindex (reindex)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_privatemessage`
#

DROP TABLE IF EXISTS bb1_privatemessage;
CREATE TABLE bb1_privatemessage (
  privatemessageid int(11) unsigned NOT NULL auto_increment,
  senderid int(11) unsigned NOT NULL default '0',
  recipientlist mediumtext NOT NULL,
  recipientcount int(11) unsigned NOT NULL default '0',
  subject varchar(250) NOT NULL default '',
  message mediumtext NOT NULL,
  sendtime int(11) unsigned NOT NULL default '0',
  allowsmilies tinyint(1) NOT NULL default '1',
  allowhtml tinyint(1) NOT NULL default '0',
  allowbbcode tinyint(1) NOT NULL default '1',
  allowimages tinyint(1) NOT NULL default '1',
  showsignature tinyint(1) NOT NULL default '0',
  iconid int(11) unsigned NOT NULL default '0',
  inoutbox tinyint(1) NOT NULL default '0',
  tracking tinyint(1) NOT NULL default '0',
  attachments int(11) unsigned NOT NULL default '0',
  pmhash varchar(32) NOT NULL default '',
  PRIMARY KEY  (privatemessageid),
  KEY iconid (iconid),
  KEY senderid (senderid,inoutbox),
  KEY pmhash (pmhash,sendtime)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_privatemessagereceipts`
#

DROP TABLE IF EXISTS bb1_privatemessagereceipts;
CREATE TABLE bb1_privatemessagereceipts (
  privatemessageid int(11) unsigned NOT NULL default '0',
  recipientid int(11) unsigned NOT NULL default '0',
  recipient varchar(50) NOT NULL default '',
  blindcopy tinyint(1) NOT NULL default '0',
  folderid int(11) unsigned NOT NULL default '0',
  deletepm tinyint(1) NOT NULL default '0',
  view int(11) unsigned NOT NULL default '0',
  reply tinyint(1) NOT NULL default '0',
  forward tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (privatemessageid,recipientid),
  KEY recipientid (recipientid,deletepm,folderid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_profilefields`
#

DROP TABLE IF EXISTS bb1_profilefields;
CREATE TABLE bb1_profilefields (
  profilefieldid int(11) unsigned NOT NULL auto_increment,
  title varchar(100) NOT NULL default '',
  description text NOT NULL,
  required tinyint(1) NOT NULL default '0',
  showinthread tinyint(1) NOT NULL default '0',
  hidden tinyint(1) NOT NULL default '0',
  fieldtype varchar(40) NOT NULL default 'text',
  fieldoptions text NOT NULL,
  maxlength smallint(5) unsigned NOT NULL default '250',
  fieldsize tinyint(3) unsigned NOT NULL default '25',
  choicecount tinyint(1) NOT NULL default '0',
  fieldorder mediumint(7) unsigned NOT NULL default '0',
  PRIMARY KEY  (profilefieldid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_ranks`
#

DROP TABLE IF EXISTS bb1_ranks;
CREATE TABLE bb1_ranks (
  rankid int(11) unsigned NOT NULL auto_increment,
  groupid int(11) unsigned NOT NULL default '1',
  gender tinyint(1) NOT NULL default '0',
  needposts mediumint(7) unsigned NOT NULL default '0',
  ranktitle varchar(70) NOT NULL default '',
  rankimages text NOT NULL,
  PRIMARY KEY  (rankid),
  KEY groupid (groupid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_searchs`
#

DROP TABLE IF EXISTS bb1_searchs;
CREATE TABLE bb1_searchs (
  searchid int(11) unsigned NOT NULL auto_increment,
  searchhash varchar(32) NOT NULL default '',
  searchstring varchar(250) NOT NULL default '',
  searchuserid int(11) unsigned NOT NULL default '0',
  postids mediumtext NOT NULL,
  showposts tinyint(1) NOT NULL default '0',
  sortby varchar(25) NOT NULL default '0',
  sortorder varchar(4) NOT NULL default '0',
  searchtime int(11) unsigned NOT NULL default '0',
  userid int(11) unsigned NOT NULL default '0',
  ipaddress varchar(16) NOT NULL default '',
  PRIMARY KEY  (searchid),
  KEY searchhash (searchhash)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_sessions`
#

DROP TABLE IF EXISTS bb1_sessions;
CREATE TABLE bb1_sessions (
  sessionhash varchar(32) NOT NULL default '',
  userid int(11) unsigned NOT NULL default '0',
  ipaddress varchar(16) NOT NULL default '',
  useragent varchar(100) NOT NULL default '',
  lastactivity int(11) unsigned NOT NULL default '0',
  request_uri varchar(250) NOT NULL default '',
  styleid int(11) unsigned NOT NULL default '0',
  langid int(11) NOT NULL default '0',
  boardid int(11) unsigned NOT NULL default '0',
  threadid int(11) unsigned NOT NULL default '0',
  authentificationcode varchar(32) NOT NULL default '',
  PRIMARY KEY  (sessionhash),
  KEY userid (userid),
  KEY boardid (boardid)
) TYPE=HEAP;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_smilies`
#

DROP TABLE IF EXISTS bb1_smilies;
CREATE TABLE bb1_smilies (
  smilieid int(11) unsigned NOT NULL auto_increment,
  smiliepath varchar(250) NOT NULL default '{imagefolder}/',
  smilietitle varchar(250) NOT NULL default '',
  smiliecode varchar(250) NOT NULL default '',
  smilieorder mediumint(7) unsigned NOT NULL default '0',
  PRIMARY KEY  (smilieid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_stats`
#

DROP TABLE IF EXISTS bb1_stats;
CREATE TABLE bb1_stats (
  threadcount int(11) unsigned NOT NULL default '0',
  postcount int(11) unsigned NOT NULL default '0',
  usercount int(11) unsigned NOT NULL default '0',
  lastuserid int(11) unsigned NOT NULL default '0'
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_styles`
#

DROP TABLE IF EXISTS bb1_styles;
CREATE TABLE bb1_styles (
  styleid int(11) unsigned NOT NULL default '0',
  stylename varchar(100) NOT NULL default '',
  templatepackid int(11) unsigned NOT NULL default '0',
  designpackid int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (styleid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_subscribeboards`
#

DROP TABLE IF EXISTS bb1_subscribeboards;
CREATE TABLE bb1_subscribeboards (
  userid int(11) unsigned NOT NULL default '0',
  boardid int(11) unsigned NOT NULL default '0',
  emailnotify tinyint(1) NOT NULL default '0',
  countemails tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (userid,boardid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_subscribethreads`
#

DROP TABLE IF EXISTS bb1_subscribethreads;
CREATE TABLE bb1_subscribethreads (
  userid int(11) unsigned NOT NULL default '0',
  threadid int(11) unsigned NOT NULL default '0',
  emailnotify tinyint(1) NOT NULL default '0',
  countemails tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (userid,threadid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_templatepacks`
#

DROP TABLE IF EXISTS bb1_templatepacks;
CREATE TABLE bb1_templatepacks (
  templatepackid int(11) unsigned NOT NULL auto_increment,
  templatepackname varchar(100) NOT NULL default '',
  templatefolder varchar(250) NOT NULL default '',
  parentid int(11) unsigned NOT NULL default '0',
  templatestructure mediumtext NOT NULL,
  PRIMARY KEY  (templatepackid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_templates`
#

DROP TABLE IF EXISTS bb1_templates;
CREATE TABLE bb1_templates (
  templateid int(11) unsigned NOT NULL auto_increment,
  templatepackid int(11) unsigned NOT NULL default '0',
  templatename varchar(100) NOT NULL default '',
  template mediumtext NOT NULL,
  recompile tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (templateid),
  UNIQUE KEY templatepackid (templatepackid,templatename)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_threads`
#

DROP TABLE IF EXISTS bb1_threads;
CREATE TABLE bb1_threads (
  threadid int(11) unsigned NOT NULL auto_increment,
  boardid int(11) unsigned NOT NULL default '0',
  prefix varchar(250) NOT NULL default '',
  topic varchar(250) NOT NULL default '',
  iconid int(11) unsigned NOT NULL default '0',
  starttime int(11) unsigned NOT NULL default '0',
  starterid int(11) unsigned NOT NULL default '0',
  starter varchar(50) NOT NULL default '',
  lastposttime int(11) unsigned NOT NULL default '0',
  lastposterid int(11) unsigned NOT NULL default '0',
  lastposter varchar(50) NOT NULL default '',
  replycount mediumint(7) unsigned NOT NULL default '0',
  views mediumint(7) unsigned NOT NULL default '0',
  closed tinyint(1) NOT NULL default '0',
  voted smallint(5) unsigned NOT NULL default '0',
  votepoints mediumint(7) unsigned NOT NULL default '0',
  attachments smallint(5) unsigned NOT NULL default '0',
  pollid int(11) unsigned NOT NULL default '0',
  important tinyint(1) NOT NULL default '0',
  visible tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (threadid),
  KEY iconid (iconid),
  KEY boardid (boardid,visible,important,lastposttime),
  KEY visible (visible,lastposttime,closed)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_threadvisit`
#

DROP TABLE IF EXISTS bb1_threadvisit;
CREATE TABLE bb1_threadvisit (
  threadid int(11) unsigned NOT NULL default '0',
  userid int(11) unsigned NOT NULL default '0',
  lastvisit int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (threadid,userid),
  KEY userid (userid,lastvisit)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_user2groups`
#

DROP TABLE IF EXISTS bb1_user2groups;
CREATE TABLE bb1_user2groups (
  userid int(11) unsigned NOT NULL default '0',
  groupid int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (userid,groupid),
  UNIQUE KEY groupid (groupid,userid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_userfields`
#

DROP TABLE IF EXISTS bb1_userfields;
CREATE TABLE bb1_userfields (
  userid int(11) unsigned NOT NULL default '0',
  field1 varchar(250) NOT NULL default '',
  field2 varchar(250) NOT NULL default '',
  field3 varchar(250) NOT NULL default '',
  PRIMARY KEY  (userid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_users`
#

DROP TABLE IF EXISTS bb1_users;
CREATE TABLE bb1_users (
  userid int(11) unsigned NOT NULL auto_increment,
  username varchar(50) NOT NULL default '',
  password varchar(50) NOT NULL default '',
  sha1_password varchar(40) NOT NULL default '',
  email varchar(150) NOT NULL default '',
  userposts mediumint(7) unsigned NOT NULL default '0',
  groupcombinationid int(11) unsigned NOT NULL default '0',
  rankid int(11) unsigned NOT NULL default '0',
  title varchar(50) NOT NULL default '',
  regdate int(11) unsigned NOT NULL default '0',
  lastvisit int(11) unsigned NOT NULL default '0',
  lastactivity int(11) unsigned NOT NULL default '0',
  usertext text NOT NULL,
  signature text NOT NULL,
  disablesignature tinyint(1) NOT NULL default '0',
  icq varchar(30) NOT NULL default '',
  aim varchar(30) NOT NULL default '',
  yim varchar(30) NOT NULL default '',
  msn varchar(30) NOT NULL default '',
  homepage varchar(250) NOT NULL default '',
  birthday date NOT NULL default '0000-00-00',
  avatarid int(11) unsigned NOT NULL default '0',
  gender tinyint(1) NOT NULL default '0',
  showemail tinyint(1) NOT NULL default '0',
  admincanemail tinyint(1) NOT NULL default '1',
  usercanemail tinyint(1) NOT NULL default '1',
  invisible tinyint(1) NOT NULL default '0',
  usecookies tinyint(1) NOT NULL default '1',
  styleid int(11) unsigned NOT NULL default '0',
  langid int(11) NOT NULL default '0',
  activation int(11) unsigned NOT NULL default '0',
  blocked tinyint(1) NOT NULL default '0',
  daysprune smallint(5) unsigned NOT NULL default '0',
  timezoneoffset char(3) NOT NULL default '',
  startweek tinyint(1) NOT NULL default '0',
  dateformat varchar(10) NOT NULL default '',
  timeformat varchar(10) NOT NULL default '',
  emailnotify tinyint(1) NOT NULL default '0',
  notificationperpm tinyint(1) NOT NULL default '0',
  buddylist text NOT NULL,
  ignorelist text NOT NULL,
  receivepm tinyint(1) NOT NULL default '1',
  emailonpm tinyint(1) NOT NULL default '0',
  pmpopup tinyint(1) NOT NULL default '0',
  umaxposts smallint(5) unsigned NOT NULL default '0',
  showsignatures tinyint(1) NOT NULL default '1',
  showavatars tinyint(1) NOT NULL default '1',
  showimages tinyint(1) NOT NULL default '1',
  ratingcount smallint(5) unsigned NOT NULL default '0',
  ratingpoints mediumint(7) unsigned NOT NULL default '0',
  threadview tinyint(1) NOT NULL default '0',
  useuseraccess tinyint(1) NOT NULL default '0',
  isgroupleader tinyint(1) NOT NULL default '0',
  rankgroupid int(11) NOT NULL default '0',
  useronlinegroupid int(11) NOT NULL default '0',
  allowsigsmilies tinyint(1) NOT NULL default '1',
  allowsightml tinyint(1) NOT NULL default '0',
  allowsigbbcode tinyint(1) NOT NULL default '1',
  allowsigimages tinyint(1) NOT NULL default '1',
  emailonapplication tinyint(1) NOT NULL default '0',
  acpmode tinyint(3) NOT NULL default '1',
  acppersonalmenu tinyint(1) NOT NULL default '0',
  acpmenumarkfirst tinyint(3) NOT NULL default '0',
  acpmenuhidelast tinyint(3) NOT NULL default '0',
  usewysiwyg tinyint(1) unsigned NOT NULL default '0',
  pmtotalcount int(11) unsigned NOT NULL default '0',
  pminboxcount int(11) unsigned NOT NULL default '0',
  pmnewcount int(11) unsigned NOT NULL default '0',
  pmunreadcount int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (userid),
  KEY username (username),
  KEY rankid (rankid),
  KEY avatarid (avatarid),
  KEY activation (activation),
  KEY groupcombinationid (groupcombinationid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_votes`
#

DROP TABLE IF EXISTS bb1_votes;
CREATE TABLE bb1_votes (
  id int(11) unsigned NOT NULL default '0',
  votemode tinyint(1) NOT NULL default '0',
  userid int(11) unsigned NOT NULL default '0',
  ipaddress varchar(15) NOT NULL default '',
  KEY id (id,votemode,userid),
  KEY id_2 (id,votemode,ipaddress)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_wordlist`
#

DROP TABLE IF EXISTS bb1_wordlist;
CREATE TABLE bb1_wordlist (
  wordid int(11) unsigned NOT NULL auto_increment,
  word varchar(50) NOT NULL default '',
  PRIMARY KEY  (wordid),
  UNIQUE KEY word (word)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `bb1_wordmatch`
#

DROP TABLE IF EXISTS bb1_wordmatch;
CREATE TABLE bb1_wordmatch (
  wordid int(11) unsigned NOT NULL default '0',
  postid int(11) unsigned NOT NULL default '0',
  intopic tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (wordid,postid)
) TYPE=MyISAM;
