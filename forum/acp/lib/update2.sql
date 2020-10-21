#
# 2.2.x to 2.3.0 Beta 2 update sql (part II)
#

UPDATE bb1_posts SET attachments = 1 WHERE attachmentid > 0;

ALTER TABLE bb1_posts
    DROP attachmentid,
    DROP INDEX attachmentid;

ALTER TABLE bb1_privatemessage
    DROP folderid,
    DROP recipientid,
    DROP view,
    DROP reply,
    DROP forward,
    DROP deletepm,
    DROP INDEX folderid,
    DROP INDEX recipientid;
