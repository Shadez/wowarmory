UPDATE `armory_db_version` SET `version` = 'armory_r87';
ALTER TABLE `armory_item_sources` ADD `type` SMALLINT NOT NULL ;
ALTER TABLE `armory_item_sources` ADD `subtype` SMALLINT NOT NULL ;