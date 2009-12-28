ALTER TABLE `db_version` CHANGE `armory_r38` `version` VARCHAR( 11 ) DEFAULT NULL;
INSERT INTO `db_version` ( `version` ) VALUES ('armory_r38');
ALTER TABLE `cache` ADD `locale` VARCHAR( 5 ) NOT NULL ;
TRUNCATE TABLE `cache`;