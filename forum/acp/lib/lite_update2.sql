#
# 2.2 Beta 1 to 2.2 beta 2 update sql
#

INSERT INTO bb1_options VALUES
	(NULL, 4, 'default_register_usewysiwyg', '0', 'truefalse', 22, 2);

UPDATE bb1_options SET showorder = 23 WHERE varname = 'register_default_checked_0';
UPDATE bb1_options SET showorder = 24 WHERE varname = 'register_default_checked_1';
UPDATE bb1_options SET showorder = 25 WHERE varname = 'register_default_checked_2';
UPDATE bb1_options SET showorder = 26 WHERE varname = 'register_default_checked_3';

UPDATE bb1_smilies SET smiliecode = '=)' WHERE smiliecode = ':))';

ALTER TABLE bb1_boards
	ADD showinarchive tinyint(1) NOT NULL default '1' AFTER invisible;

ALTER TABLE bb1_users
	ADD usewysiwyg tinyint(1) unsigned NOT NULL default '0' AFTER acpmenuhidelast;
