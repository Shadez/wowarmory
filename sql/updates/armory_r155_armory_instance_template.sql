UPDATE `armory_db_version` SET `version`='armory_r155';
ALTER TABLE `armory_instance_template` ADD `difficulty` SMALLINT NOT NULL ;
UPDATE `armory_instance_template` SET `difficulty` = 1 WHERE `key` IN ('trialofthecrusader10', 'icecrowncitadel10');
UPDATE `armory_instance_template` SET `difficulty` = 2 WHERE `key` IN ('trialofthecrusader25', 'icecrowncitadel25');