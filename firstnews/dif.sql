ALTER TABLE `firstnews_products` ADD `board_access` INT( 1 ) NOT NULL ;
ALTER TABLE `firstnews_options` ADD `pay_period` INT( 11 ) NOT NULL ;
ALTER TABLE `firstnews_options` ADD `commission` INT( 3 ) NOT NULL ;


firstnews_arbitrations
firstnews_associates

products --> board_access
options --> pay_period, commission