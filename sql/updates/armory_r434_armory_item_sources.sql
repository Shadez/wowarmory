UPDATE `armory_db_version` SET `version` = 'armory_r434';
UPDATE `armory_item_sources` SET `type` = '15', `subtype` = '4' WHERE `key` = 'misc' LIMIT 1 ;
INSERT IGNORE INTO `armory_item_sources` ( `key` , `parent` , `item` , `type` , `subtype` ) VALUES ('reagents', '0', '0', '15', '1');
INSERT IGNORE INTO `armory_item_sources` ( `key` , `parent` , `item` , `type` , `subtype` ) VALUES ('recipes', '0', '0', '9', '0');