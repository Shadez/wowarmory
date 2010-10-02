UPDATE `armory_db_version` SET `version` = 'armory_r398';
-- `type` will be updated from Utils::CheckCheckConfigRealmData().
ALTER TABLE `armory_realm_data` ADD `type` SMALLINT( 1 ) NOT NULL;