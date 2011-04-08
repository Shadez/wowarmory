ALTER TABLE `armory_character_stats` ADD `save_date` INT NOT NULL ;
ALTER TABLE `character_feed_log` ADD `item_quality` SMALLINT NOT NULL ;
ALTER TABLE `character_feed_log` DROP PRIMARY KEY;