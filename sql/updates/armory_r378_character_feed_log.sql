-- This update is for CHARACTERS database!
ALTER TABLE `character_feed_log` CHANGE `date` `date` INT;
ALTER TABLE `character_feed_log` ADD `difficulty` SMALLINT NOT NULL ;
TRUNCATE TABLE `character_feed_log`;