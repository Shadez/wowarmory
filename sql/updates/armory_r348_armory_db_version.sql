ALTER TABLE `armory_db_version` ADD `rename_status` SMALLINT( 1 ) DEFAULT '1' NOT NULL ,
ADD `prev_name` VARCHAR( 255 ) NOT NULL ;
UPDATE `armory_db_version` SET `prev_name` = 'armory', `version`='armory_r348';